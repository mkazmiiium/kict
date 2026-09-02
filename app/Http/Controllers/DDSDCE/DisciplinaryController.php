<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisciplinaryRecord\StoreDisciplinaryRecordRequest;
use App\Http\Requests\DisciplinaryRecord\UpdateDisciplinaryRecordRequest;
use App\Mail\DisciplinaryCancelledMail;
use App\Mail\DisciplinaryNoticeMail;
use App\Models\DisciplinaryRecord;
use App\Models\DisciplinaryRecordPhoto;
use App\Models\Offense;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DisciplinaryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');
        $status = $request->get('status');
        $filterMonth = $request->get('month');
        $filterYear = $request->get('year');

        $records = $this->filteredQuery($sort, $direction, $search, $status, $filterMonth, $filterYear)
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('ddsdce.disciplinary.index', [
            'records' => $records,
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search,
            'status' => $status,
            'filterMonth' => $filterMonth,
            'filterYear' => $filterYear,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');
        $status = $request->get('status');
        $filterMonth = $request->get('month');
        $filterYear = $request->get('year');

        $records = $this->filteredQuery($sort, $direction, $search, $status, $filterMonth, $filterYear)->get();

        $rows = $records->map(fn (DisciplinaryRecord $record) => [
            $record->student->name,
            $record->student->matric_no,
            $record->date->format('d M Y'),
            $record->offense->name ?? '—',
            $record->location,
            ucfirst($record->status),
            $record->due_date->format('d M Y'),
        ])->all();

        $parts = [];
        if ($search) {
            $parts[] = "Search: \"{$search}\"";
        }
        if ($status) {
            $parts[] = 'Status: '.ucfirst($status);
        }
        if ($filterMonth) {
            $parts[] = 'Month: '.date('F', mktime(0, 0, 0, (int) $filterMonth, 1));
        }
        if ($filterYear) {
            $parts[] = "Year: {$filterYear}";
        }

        return $this->exportListPdf(
            'Disciplinary Records',
            ['Student', 'Matric No.', 'Date', 'Offense', 'Location', 'Status', 'Due Date'],
            $rows,
            implode(', ', $parts)
        );
    }

    private function filteredQuery(string $sort, string $direction, ?string $search, ?string $status, $filterMonth, $filterYear)
    {
        $sortable = [
            'student_name' => 'students.name',
            'matric_no' => 'students.matric_no',
            'date' => 'disciplinary_records.date',
            'offense' => 'offenses.name',
            'location' => 'disciplinary_records.location',
            'status' => 'disciplinary_records.status',
            'due_date' => 'disciplinary_records.due_date',
            'created_at' => 'disciplinary_records.created_at',
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['created_at'];

        return DisciplinaryRecord::query()
            ->select('disciplinary_records.*')
            ->join('students', 'students.id', '=', 'disciplinary_records.student_id')
            ->leftJoin('offenses', 'offenses.id', '=', 'disciplinary_records.offense_id')
            ->with(['student', 'offense'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%")
                        ->orWhere('offenses.name', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('disciplinary_records.status', $status);
            })
            ->when($filterMonth, function ($query) use ($filterMonth) {
                $query->whereMonth('disciplinary_records.date', $filterMonth);
            })
            ->when($filterYear, function ($query) use ($filterYear) {
                $query->whereYear('disciplinary_records.date', $filterYear);
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('disciplinary_records.id');
    }

    public function create()
    {
        return view('ddsdce.disciplinary.create', $this->formData());
    }

    public function store(StoreDisciplinaryRecordRequest $request)
    {
        $data = $request->validated();

        $record = DisciplinaryRecord::create([
            'student_id' => $data['student_id'],
            'date' => $data['date'],
            'offense_id' => $data['offense_id'] ?? null,
            'location' => $data['location'],
            'remarks' => $data['remarks'] ?? null,
            'status' => 'pending',
            'due_date' => now()->addDays(14),
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        $this->storePhotos($record, $request->file('photos', []));
        $this->sendNotice($record);

        return redirect()->route('ddsdce.disciplinary.index')
            ->with('status', "Disciplinary record for {$record->student->name} created.");
    }

    public function show(DisciplinaryRecord $disciplinaryRecord)
    {
        $disciplinaryRecord->load(['student.program', 'student.department.kulliyyah', 'offense', 'creator', 'updater', 'photos']);

        return view('ddsdce.disciplinary.show', compact('disciplinaryRecord'));
    }

    public function edit(DisciplinaryRecord $disciplinaryRecord)
    {
        $disciplinaryRecord->load(['student.program', 'student.department.kulliyyah', 'photos']);

        return view('ddsdce.disciplinary.edit', [
            'disciplinaryRecord' => $disciplinaryRecord,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateDisciplinaryRecordRequest $request, DisciplinaryRecord $disciplinaryRecord)
    {
        $data = $request->validated();

        $disciplinaryRecord->update([
            'student_id' => $data['student_id'],
            'date' => $data['date'],
            'offense_id' => $data['offense_id'] ?? null,
            'location' => $data['location'],
            'remarks' => $data['remarks'] ?? null,
            'updated_by' => $request->user()->id,
        ]);

        $this->storePhotos($disciplinaryRecord, $request->file('photos', []));

        return redirect()->route('ddsdce.disciplinary.index')
            ->with('status', "Disciplinary record for {$disciplinaryRecord->student->name} updated.");
    }

    public function destroyPhoto(DisciplinaryRecord $disciplinaryRecord, DisciplinaryRecordPhoto $photo)
    {
        abort_unless($photo->disciplinary_record_id === $disciplinaryRecord->id, 404);

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return redirect()->route('ddsdce.disciplinary.edit', $disciplinaryRecord)
            ->with('status', 'Photo removed.');
    }

    public function destroy(DisciplinaryRecord $disciplinaryRecord)
    {
        $name = $disciplinaryRecord->student->name;

        $disciplinaryRecord->delete();

        return redirect()->route('ddsdce.disciplinary.index')
            ->with('status', "Disciplinary record for {$name} deleted.");
    }

    public function cancel(Request $request, DisciplinaryRecord $disciplinaryRecord)
    {
        if ($disciplinaryRecord->status !== 'pending') {
            return redirect()->route('ddsdce.disciplinary.index')
                ->with('error', 'Only pending records can be cancelled.');
        }

        $disciplinaryRecord->update([
            'status' => 'cancelled',
            'resolved_at' => now(),
            'updated_by' => $request->user()->id,
        ]);

        $this->sendCancellation($disciplinaryRecord);

        return redirect()->route('ddsdce.disciplinary.index')
            ->with('status', "Disciplinary record for {$disciplinaryRecord->student->name} cancelled — student notified.");
    }

    public function escalate(Request $request, DisciplinaryRecord $disciplinaryRecord)
    {
        if ($disciplinaryRecord->status !== 'pending') {
            return redirect()->route('ddsdce.disciplinary.index')
                ->with('error', 'Only pending records can be escalated.');
        }

        $disciplinaryRecord->update([
            'status' => 'escalated',
            'escalated_at' => now(),
            'updated_by' => $request->user()->id,
        ]);

        // Placeholder for the real OSEM system hand-off — no API/endpoint details
        // are available yet. Logging the payload keeps a record of what would be
        // transmitted once OSEM's integration details are provided.
        Log::info('Disciplinary record escalated to OSEM (placeholder — no live integration)', [
            'disciplinary_record_id' => $disciplinaryRecord->id,
            'student_matric_no' => $disciplinaryRecord->student->matric_no,
            'student_name' => $disciplinaryRecord->student->name,
            'offense' => $disciplinaryRecord->offense->name ?? null,
            'location' => $disciplinaryRecord->location,
            'remarks' => $disciplinaryRecord->remarks,
            'due_date' => $disciplinaryRecord->due_date->toDateString(),
        ]);

        return redirect()->route('ddsdce.disciplinary.index')
            ->with('status', "Disciplinary record for {$disciplinaryRecord->student->name} escalated to OSEM.");
    }

    private function storePhotos(DisciplinaryRecord $record, array $photos): void
    {
        foreach ($photos as $photo) {
            if (! $photo) {
                continue;
            }

            $path = $photo->store('disciplinary-photos', 'public');

            DisciplinaryRecordPhoto::create([
                'disciplinary_record_id' => $record->id,
                'path' => $path,
            ]);
        }
    }

    private function sendNotice(DisciplinaryRecord $record): void
    {
        $record->loadMissing(['student', 'offense']);

        if (! $record->student->email) {
            return;
        }

        try {
            Mail::to($record->student->email)->send(new DisciplinaryNoticeMail($record));
            $record->update(['notified_at' => now()]);
        } catch (\Throwable $e) {
            Log::error('Failed to send disciplinary notice email', [
                'disciplinary_record_id' => $record->id,
                'student_email' => $record->student->email,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function sendCancellation(DisciplinaryRecord $record): void
    {
        $record->loadMissing(['student', 'offense']);

        if (! $record->student->email) {
            return;
        }

        try {
            Mail::to($record->student->email)->send(new DisciplinaryCancelledMail($record));
        } catch (\Throwable $e) {
            Log::error('Failed to send disciplinary cancellation email', [
                'disciplinary_record_id' => $record->id,
                'student_email' => $record->student->email,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function formData(): array
    {
        return [
            'students' => Student::with(['program', 'department.kulliyyah'])->orderBy('name')->get(),
            'offenses' => Offense::where('is_active', true)->orderBy('name')->get(),
        ];
    }
}
