<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SupervisorController extends Controller
{
    public function loginForm()
    {
        return view('supervisor.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !$user->isSupervisor() || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid supervisor account or inactive account.'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('supervisor.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('supervisor.login');
    }

    public function dashboard(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isSupervisor()) {
            return redirect()->route('supervisor.login');
        }

        $user = Auth::user();
        $branchIds = $user->branches()->pluck('branches.id');

        $stats = [
            'pending' => Reservation::whereIn('branch_id', $branchIds)->where('status', Reservation::STATUS_PENDING)->count(),
            'confirmed' => Reservation::whereIn('branch_id', $branchIds)->where('status', Reservation::STATUS_CONFIRMED)->count(),
            'declined' => Reservation::whereIn('branch_id', $branchIds)->where('status', Reservation::STATUS_DECLINED)->count(),
            'completed' => Reservation::whereIn('branch_id', $branchIds)->where('status', Reservation::STATUS_COMPLETED)->count(),
        ];

        $query = Reservation::with('branch')->whereIn('branch_id', $branchIds);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer')) {
            $query->where('customer_name', 'like', '%' . $request->customer . '%');
        }

        if ($request->filled('reference')) {
            $query->where('reference_number', 'like', '%' . $request->reference . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->date);
        }

        $reservations = $query->orderByDesc('created_at')->get();

        return view('supervisor.dashboard', [
            'user' => $user,
            'branches' => $user->branches()->orderBy('name')->get(),
            'stats' => $stats,
            'reservations' => $reservations,
            'filters' => $request->only(['status', 'customer', 'reference', 'date']),
        ]);
    }

    public function processReservation(Request $request, Reservation $reservation)
    {
        if (!Auth::check() || !Auth::user()->isSupervisor()) {
            return redirect()->route('supervisor.login');
        }

        $user = Auth::user();

        if (!$user->branches()->where('branches.id', $reservation->branch_id)->exists()) {
            abort(403, 'You are not assigned to this branch.');
        }

        if ($reservation->status !== Reservation::STATUS_PENDING) {
            return back()->withErrors(['status' => 'Only pending reservations can be accepted or declined.']);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in([Reservation::STATUS_CONFIRMED, Reservation::STATUS_DECLINED])],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($validated['status'] === Reservation::STATUS_DECLINED && blank($validated['reason'] ?? null)) {
            return back()->withErrors(['reason' => 'A decline reason is required.'])->withInput();
        }

        $oldStatus = $reservation->status;

        $reservation->update([
            'status' => $validated['status'],
            'processed_by_user_id' => $user->id,
            'processed_at' => now('Asia/Manila'),
            'decline_reason' => $validated['status'] === Reservation::STATUS_DECLINED ? ($validated['reason'] ?? null) : null,
        ]);

        $reservation->activities()->create([
            'previous_status' => $oldStatus,
            'new_status' => $validated['status'],
            'user_id' => $user->id,
            'action' => $validated['status'],
            'reason' => $validated['reason'] ?? null,
            'created_at' => now('Asia/Manila'),
        ]);

        return redirect()->route('supervisor.dashboard')->with('success', 'Reservation updated successfully.');
    }

    public function edit(Request $request, User $user)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->session()->flash('editingSupervisor', $user->id);

        return $this->adminIndex($request, $user);
    }

    public function adminIndex(Request $request, ?User $editingSupervisor = null)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = User::query()->where('role', 'supervisor');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('branch_id')) {
            $query->whereHas('branches', function ($q) use ($request) {
                $q->where('branches.id', $request->branch_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->boolean('status'));
        }

        $supervisors = $query->with('branches')->orderBy('name')->get();

        return view('admin.supervisors', [
            'supervisors' => $supervisors,
            'branches' => Branch::orderBy('name')->get(),
            'editingSupervisor' => $editingSupervisor,
            'search' => $request->input('search'),
            'branchId' => $request->input('branch_id'),
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
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'branch_ids' => ['nullable', 'array'],
            'branch_ids.*' => ['exists:branches,id'],
            'is_active' => ['required', 'boolean'],
            'role' => ['nullable', 'in:supervisor'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'supervisor',
            'is_active' => $validated['is_active'],
        ]);

        if (!empty($validated['branch_ids'])) {
            $user->branches()->sync($validated['branch_ids']);
        }

        return redirect()->route('admin.supervisors')->with('success', 'Supervisor account created successfully.');
    }

    public function update(Request $request, User $user)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'branch_ids' => ['nullable', 'array'],
            'branch_ids.*' => ['exists:branches,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => 'supervisor',
            'is_active' => $validated['is_active'],
        ]);

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        if (array_key_exists('branch_ids', $validated)) {
            $user->branches()->sync($validated['branch_ids'] ?? []);
        }

        return redirect()->route('admin.supervisors')->with('success', 'Supervisor updated successfully.');
    }

    public function toggleStatus(Request $request, User $user)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($user->role !== 'supervisor') {
            return redirect()->route('admin.supervisors')->withErrors(['status' => 'Only supervisor accounts can be toggled here.']);
        }

        $user->update(['is_active' => ! $user->is_active]);

        return redirect()->route('admin.supervisors')->with('success', 'Supervisor status updated successfully.');
    }
}
