@php
    $record = $provisionalRecord ?? null;
    $studentsForJs = $students->map(fn ($student) => [
        'id' => $student->id,
        'name' => $student->name,
        'matric_no' => $student->matric_no,
        'program' => $student->program->name_en ?? '—',
        'kulliyyah' => $student->department->kulliyyah->name_en ?? '—',
        'year_of_study' => $student->year_of_study ?? '—',
    ]);

    // Provisional Semester is only ever recent — limit the list to the most
    // recent sessions, but keep whatever an existing record already has
    // selected even if it has since fallen out of that recent window.
    $provisionalSessionOptions = $academicSessions->take(6);
    if ($record && ! $provisionalSessionOptions->contains('id', $record->academic_session_id)) {
        $extra = $academicSessions->firstWhere('id', $record->academic_session_id);
        if ($extra) {
            $provisionalSessionOptions = $provisionalSessionOptions->push($extra);
        }
    }
@endphp

<div class="row">
  <div class="col-md-6 mb-6 position-relative">
    <label for="student_search" class="form-label">Student</label>
    <input
      type="text"
      id="student_search"
      class="form-control @error('student_id') is-invalid @enderror"
      placeholder="Type matric no. or name to search…"
      value="{{ $record ? $record->student->name.' ('.$record->student->matric_no.')' : '' }}"
      autocomplete="off"
      required />
    <input type="hidden" id="student_id" name="student_id" value="{{ old('student_id', $record->student_id ?? '') }}" />
    <div
      id="student_results"
      class="list-group position-absolute w-100 shadow"
      style="top: 100%; left: 0; z-index: 1050; max-height: 260px; overflow-y: auto; display: none; background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color); border-radius: 0.375rem;"></div>
    @error('student_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label class="form-label">Programme (auto-filled)</label>
    <input type="text" id="program_preview" class="form-control" readonly
      value="{{ $record->student->program->name_en ?? '' }}" />
  </div>

  <div class="col-md-3 mb-6">
    <label class="form-label">Kulliyyah (auto-filled)</label>
    <input type="text" id="kulliyyah_preview" class="form-control" readonly
      value="{{ $record->student->department->kulliyyah->name_en ?? '' }}" />
  </div>

  <div class="col-md-3 mb-6">
    <label class="form-label">Current Year (auto-filled)</label>
    <input type="text" id="year_preview" class="form-control" readonly
      value="{{ $record->student->year_of_study ?? '' }}" />
  </div>

  <div class="col-md-4 mb-6">
    <label for="academic_session_id" class="form-label">Provisional Semester</label>
    <select id="academic_session_id" name="academic_session_id" class="form-select @error('academic_session_id') is-invalid @enderror" required>
      <option value="">Select semester…</option>
      @foreach ($provisionalSessionOptions as $session)
        <option value="{{ $session->id }}" {{ (int) old('academic_session_id', $record->academic_session_id ?? '') === $session->id ? 'selected' : '' }}>
          {{ $session->label() }}
        </option>
      @endforeach
    </select>
    <div class="form-text">The semester the student is/was in provisional pass status.</div>
    @error('academic_session_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="cgpa" class="form-label">CGPA</label>
    <input
      type="number"
      step="0.01"
      min="0"
      max="4"
      id="cgpa"
      name="cgpa"
      class="form-control @error('cgpa') is-invalid @enderror"
      value="{{ old('cgpa', $record->cgpa ?? '') }}"
      required />
    @error('cgpa')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  @if ($record)
    <div class="col-md-4 mb-6">
      <label class="form-label">Date Keyed In</label>
      <input type="text" class="form-control" readonly value="{{ $record->created_at->format('d M Y') }} by {{ $record->creator->name ?? '—' }}" />
    </div>
  @endif

  <div class="col-md-4 mb-6">
    <label for="meeting_number" class="form-label">Meeting No.</label>
    <input
      type="text"
      id="meeting_number"
      name="meeting_number"
      class="form-control @error('meeting_number') is-invalid @enderror"
      placeholder="e.g. 6/2026"
      value="{{ old('meeting_number', $record->meeting_number ?? '') }}" />
    @error('meeting_number')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="meeting_date" class="form-label">Meeting Date</label>
    <input
      type="date"
      id="meeting_date"
      name="meeting_date"
      class="form-control @error('meeting_date') is-invalid @enderror"
      value="{{ old('meeting_date', optional($record?->meeting_date)->format('Y-m-d') ?? '') }}" />
    @error('meeting_date')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-12 mb-6">
    <label for="remarks" class="form-label">Remarks</label>
    <textarea
      id="remarks"
      name="remarks"
      rows="3"
      class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $record->remarks ?? '') }}</textarea>
    @error('remarks')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</div>

<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('ddsdce.provisional.index') }}" class="btn btn-outline-secondary">Cancel</a>

@push('page-css')
  <style>
    #student_results .list-group-item {
      background-color: var(--bs-body-bg);
      color: var(--bs-body-color);
      text-align: left;
      border-color: var(--bs-border-color);
    }
    #student_results .list-group-item:hover,
    #student_results .list-group-item:focus {
      background-color: var(--bs-tertiary-bg);
    }
  </style>
@endpush

@push('page-js')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const studentsData = @json($studentsForJs);

      const studentSearch = document.getElementById('student_search');
      const studentIdInput = document.getElementById('student_id');
      const studentResults = document.getElementById('student_results');
      const programPreview = document.getElementById('program_preview');
      const kulliyyahPreview = document.getElementById('kulliyyah_preview');
      const yearPreview = document.getElementById('year_preview');

      function findStudent(id) {
        return studentsData.find((s) => s.id === Number(id));
      }

      function renderStudentResults(query) {
        const q = query.trim().toLowerCase();

        if (q === '') {
          studentResults.style.display = 'none';
          studentResults.innerHTML = '';
          return;
        }

        const matches = studentsData
          .filter((s) => s.name.toLowerCase().includes(q) || s.matric_no.toLowerCase().includes(q))
          .slice(0, 20);

        studentResults.innerHTML = '';

        if (matches.length === 0) {
          const empty = document.createElement('div');
          empty.className = 'list-group-item text-body-secondary';
          empty.textContent = 'No matching students';
          studentResults.appendChild(empty);
          studentResults.style.display = 'block';
          return;
        }

        matches.forEach((student) => {
          const item = document.createElement('button');
          item.type = 'button';
          item.className = 'list-group-item list-group-item-action';
          item.textContent = `${student.name} (${student.matric_no})`;
          item.addEventListener('click', function () {
            selectStudent(student);
          });
          studentResults.appendChild(item);
        });

        studentResults.style.display = 'block';
      }

      function selectStudent(student) {
        studentIdInput.value = student.id;
        studentSearch.value = `${student.name} (${student.matric_no})`;
        studentResults.style.display = 'none';
        updatePreview();
      }

      studentSearch.addEventListener('input', function () {
        studentIdInput.value = '';
        renderStudentResults(studentSearch.value);
      });

      studentSearch.addEventListener('focus', function () {
        if (studentSearch.value.trim() !== '') renderStudentResults(studentSearch.value);
      });

      document.addEventListener('click', function (event) {
        if (event.target !== studentSearch && !studentResults.contains(event.target)) {
          studentResults.style.display = 'none';
        }
      });

      function updatePreview() {
        const student = findStudent(studentIdInput.value);
        programPreview.value = student ? student.program : '';
        kulliyyahPreview.value = student ? student.kulliyyah : '';
        yearPreview.value = student ? student.year_of_study : '';
      }
    });
  </script>
@endpush
