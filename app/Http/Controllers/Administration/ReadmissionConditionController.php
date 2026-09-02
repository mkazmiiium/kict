<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReadmissionCondition\StoreReadmissionConditionRequest;
use App\Http\Requests\ReadmissionCondition\UpdateReadmissionConditionRequest;
use App\Models\ReadmissionCondition;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ReadmissionConditionController extends Controller
{
    public function index(Request $request)
    {
        $conditions = ReadmissionCondition::orderBy('name')->paginate($this->perPage($request));

        return view('administration.readmission-conditions.index', [
            'conditions' => $conditions,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function exportPdf()
    {
        $rows = ReadmissionCondition::orderBy('name')->get()->map(fn (ReadmissionCondition $condition) => [
            $condition->name,
            $condition->is_active ? 'Active' : 'Inactive',
        ])->all();

        return $this->exportListPdf('Readmission Conditions', ['Name', 'Status'], $rows);
    }

    public function create()
    {
        return view('administration.readmission-conditions.create');
    }

    public function store(StoreReadmissionConditionRequest $request)
    {
        $condition = ReadmissionCondition::create([
            'name' => $request->validated('name'),
            'footnote_text' => $request->validated('footnote_text'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('administration.readmission-conditions.index')
            ->with('status', "Readmission condition \"{$condition->name}\" created.");
    }

    public function edit(ReadmissionCondition $readmissionCondition)
    {
        return view('administration.readmission-conditions.edit', [
            'condition' => $readmissionCondition,
        ]);
    }

    public function update(UpdateReadmissionConditionRequest $request, ReadmissionCondition $readmissionCondition)
    {
        $readmissionCondition->update([
            'name' => $request->validated('name'),
            'footnote_text' => $request->validated('footnote_text'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('administration.readmission-conditions.index')
            ->with('status', "Readmission condition \"{$readmissionCondition->name}\" updated.");
    }

    public function destroy(ReadmissionCondition $readmissionCondition)
    {
        $name = $readmissionCondition->name;

        try {
            $readmissionCondition->delete();
        } catch (QueryException $e) {
            return redirect()->route('administration.readmission-conditions.index')
                ->with('error', "Cannot delete \"{$name}\" — this condition is used by existing readmission letters.");
        }

        return redirect()->route('administration.readmission-conditions.index')
            ->with('status', "Readmission condition \"{$name}\" deleted.");
    }
}
