<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    public function index()
    {
        $beneficiaries = Beneficiary::with(['category'])->paginate(20);
        return view('admin.beneficiaries.index', compact('beneficiaries'));
    }

    public function show(Beneficiary $beneficiary)
    {
        return view('admin.beneficiaries.show', compact('beneficiary'));
    }

    public function create()
    {
        return view('admin.beneficiaries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'count' => 'required|integer|min:1',
            'type' => 'nullable|string|max:255',
        ]);

        Beneficiary::create($validated);
        return redirect()->route('admin.beneficiaries.index')->with('success', 'Beneficiary created successfully!');
    }

    public function edit(Beneficiary $beneficiary)
    {
        return view('admin.beneficiaries.edit', compact('beneficiary'));
    }

    public function update(Request $request, Beneficiary $beneficiary)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'count' => 'required|integer|min:1',
            'type' => 'nullable|string|max:255',
        ]);

        $beneficiary->update($validated);
        return redirect()->route('admin.beneficiaries.show', $beneficiary)->with('success', 'Beneficiary updated successfully!');
    }

    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();
        return redirect()->route('admin.beneficiaries.index')->with('success', 'Beneficiary deleted successfully!');
    }

    public function exportCsv()
    {
        // Implementation for CSV export
        return response()->download('path/to/file.csv');
    }
}