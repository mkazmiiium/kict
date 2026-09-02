<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offense\StoreOffenseRequest;
use App\Http\Requests\Offense\UpdateOffenseRequest;
use App\Models\Offense;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class OffenseController extends Controller
{
    public function index(Request $request)
    {
        $offenses = Offense::orderBy('name')->paginate($this->perPage($request));

        return view('administration.offenses.index', [
            'offenses' => $offenses,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function exportPdf()
    {
        $rows = Offense::orderBy('name')->get()->map(fn (Offense $offense) => [
            $offense->name,
            $offense->is_active ? 'Active' : 'Inactive',
        ])->all();

        return $this->exportListPdf('Offenses', ['Name', 'Status'], $rows);
    }

    public function create()
    {
        return view('administration.offenses.create');
    }

    public function store(StoreOffenseRequest $request)
    {
        $offense = Offense::create([
            'name' => $request->validated('name'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('administration.offenses.index')
            ->with('status', "Offense \"{$offense->name}\" created.");
    }

    public function edit(Offense $offense)
    {
        return view('administration.offenses.edit', [
            'offense' => $offense,
        ]);
    }

    public function update(UpdateOffenseRequest $request, Offense $offense)
    {
        $offense->update([
            'name' => $request->validated('name'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('administration.offenses.index')
            ->with('status', "Offense \"{$offense->name}\" updated.");
    }

    public function destroy(Offense $offense)
    {
        $name = $offense->name;

        try {
            $offense->delete();
        } catch (QueryException $e) {
            return redirect()->route('administration.offenses.index')
                ->with('error', "Cannot delete \"{$name}\" — this offense is used by existing disciplinary records.");
        }

        return redirect()->route('administration.offenses.index')
            ->with('status', "Offense \"{$name}\" deleted.");
    }
}
