<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    public function adminIndex(Request $request)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = Branch::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->boolean('status'));
        }

        $branches = $query->orderBy('name')->get();

        return view('admin.branches', [
            'branches' => $branches,
            'search' => $request->input('search'),
            'status' => $request->input('status'),
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($request->boolean('is_active'));

        Branch::create($validated);

        return redirect()->route('admin.branches')->with('success', 'Branch added successfully.');
    }

    public function edit(Request $request, Branch $branch)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $branch->load('supervisors', 'reservations');

        return view('admin.branches', [
            'branches' => Branch::orderBy('name')->get(),
            'editingBranch' => $branch,
            'search' => $request->input('search'),
            'status' => $request->input('status'),
        ]);
    }

    public function update(Request $request, Branch $branch)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($request->boolean('is_active'));

        $branch->update($validated);

        return redirect()->route('admin.branches')->with('success', 'Branch updated successfully.');
    }

    public function toggleStatus(Request $request, Branch $branch)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $branch->update(['is_active' => ! $branch->is_active]);

        return redirect()->route('admin.branches')->with('success', 'Branch status updated successfully.');
    }
}
