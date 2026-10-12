<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Reservation;
use App\Models\ReservationActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function publicForm()
    {
        $branches = Branch::active()->orderBy('name')->get();

        return view('reservation', [
            'branches' => $branches,
            'reservationTimes' => $this->timeSlots(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:50'],
            'branch_id' => ['required', 'exists:branches,id'],
            'reservation_date' => ['required', 'date', 'after_or_equal:today'],
            'reservation_time' => ['required', 'date_format:H:i', Rule::in(array_keys($this->timeSlots()))],
            'guest_count' => ['required', 'integer', 'min:1', 'max:20'],
            'additional_requests' => ['nullable', 'string', 'max:1000'],
            'policy_accepted' => ['accepted'],
        ], [
            'branch_id.exists' => 'Please select a valid active branch.',
            'reservation_time.date_format' => 'Please select a valid reservation time.',
            'policy_accepted.accepted' => 'You must accept the reservation policy before submitting.',
        ]);

        $branch = Branch::active()->find($validated['branch_id']);

        if (!$branch) {
            return back()->withErrors(['branch_id' => 'The selected branch is currently unavailable.'])->withInput();
        }

        $selectedDate = Carbon::parse($validated['reservation_date'], 'Asia/Manila')->format('Y-m-d');
        $selectedTime = $validated['reservation_time'];
        $selectedDateTime = Carbon::parse($selectedDate . ' ' . $selectedTime, 'Asia/Manila');

        if ($selectedDateTime->isPast()) {
            return back()->withErrors(['reservation_date' => 'Please choose a future reservation date and time.'])->withInput();
        }

        if (!$this->isSlotAvailable($branch, $selectedDate, $selectedTime, $validated['guest_count'])) {
            return back()->withErrors(['reservation_time' => 'The selected reservation slot is unavailable for the chosen branch. Please choose another time.'])->withInput();
        }

        $reservation = DB::transaction(function () use ($validated, $branch, $selectedDate, $selectedTime) {
            $customerReservation = Reservation::create([
                'reference_number' => Reservation::generateReferenceNumber(),
                'customer_name' => $validated['customer_name'],
                'contact_number' => $validated['contact_number'],
                'branch_id' => $branch->id,
                'reservation_date' => $selectedDate,
                'reservation_time' => $selectedTime,
                'guest_count' => $validated['guest_count'],
                'additional_requests' => $validated['additional_requests'] ?? null,
                'status' => Reservation::STATUS_PENDING,
                'policy_accepted' => true,
                'policy_accepted_at' => now('Asia/Manila'),
            ]);

            ReservationActivity::create([
                'reservation_id' => $customerReservation->id,
                'previous_status' => null,
                'new_status' => Reservation::STATUS_PENDING,
                'user_id' => null,
                'action' => 'reservation_created',
                'reason' => 'Customer submitted reservation.',
                'created_at' => now('Asia/Manila'),
            ]);

            return $customerReservation;
        });

        return redirect()->route('reservation.success', ['reservation' => $reservation->reference_number])->with('success', 'Your reservation has been submitted and is pending supervisor approval.');
    }

    public function success(Request $request, $reservation)
    {
        $record = Reservation::with('branch')->where('reference_number', $reservation)->firstOrFail();

        return view('reservation-success', [
            'reservation' => $record,
        ]);
    }

    public function lookup(Request $request)
    {
        $reservation = null;

        if ($request->isMethod('post')) {
            $request->validate([
                'reference_number' => ['required', 'string', 'max:50'],
                'contact_number' => ['required', 'string', 'max:50'],
            ]);

            $reservation = Reservation::where('reference_number', strtoupper($request->reference_number))
                ->where('contact_number', $request->contact_number)
                ->with('branch')
                ->first();

            if (!$reservation) {
                return back()->withErrors(['reference_number' => 'No reservation matched the reference number and contact number provided.'])->withInput();
            }
        }

        return view('reservation-status', ['reservation' => $reservation]);
    }

    public function index(Request $request)
    {
        $query = Reservation::with('branch', 'processor');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

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

        $branches = Branch::orderBy('name')->get();

        return view('admin.reservations', [
            'reservations' => $reservations,
            'branches' => $branches,
            'filters' => $request->only(['branch_id', 'status', 'customer', 'reference', 'date']),
        ]);
    }

    public function details(Request $request, Reservation $reservation)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $reservation->load('branch', 'processor', 'activities.user');

        return view('admin.reservation-detail', [
            'reservation' => $reservation,
        ]);
    }

    public function process(Request $request, Reservation $reservation)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in([Reservation::STATUS_CONFIRMED, Reservation::STATUS_DECLINED, Reservation::STATUS_CANCELLED])],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($reservation->status !== Reservation::STATUS_PENDING && $validated['status'] === Reservation::STATUS_CONFIRMED) {
            return back()->withErrors(['status' => 'Only pending reservations can be processed.'])->withInput();
        }

        if ($reservation->status !== Reservation::STATUS_PENDING && $validated['status'] === Reservation::STATUS_DECLINED) {
            return back()->withErrors(['status' => 'Only pending reservations can be processed.'])->withInput();
        }

        $reason = $validated['reason'] ?? null;

        if ($validated['status'] === Reservation::STATUS_DECLINED && empty($reason)) {
            return back()->withErrors(['reason' => 'A decline reason is required.'])->withInput();
        }

        $oldStatus = $reservation->status;

        $reservation->update([
            'status' => $validated['status'],
            'processed_by_user_id' => auth()->id() ?? null,
            'processed_at' => now('Asia/Manila'),
            'decline_reason' => $validated['status'] === Reservation::STATUS_DECLINED ? $reason : null,
            'cancellation_reason' => $validated['status'] === Reservation::STATUS_CANCELLED ? $reason : null,
        ]);

        ReservationActivity::create([
            'reservation_id' => $reservation->id,
            'previous_status' => $oldStatus,
            'new_status' => $validated['status'],
            'user_id' => auth()->id(),
            'action' => $validated['status'],
            'reason' => $reason,
            'created_at' => now('Asia/Manila'),
        ]);

        return redirect()->route('admin.reservations')->with('success', 'Reservation updated successfully.');
    }

    private function isSlotAvailable(Branch $branch, string $date, string $time, int $guestCount): bool
    {
        $capacity = (int) ($branch->capacity ?? 0);

        if ($capacity <= 0) {
            return false;
        }

        $bookedGuests = Reservation::where('branch_id', $branch->id)
            ->where('reservation_date', $date)
            ->where('reservation_time', $time)
            ->whereIn('status', [Reservation::STATUS_CONFIRMED, Reservation::STATUS_PENDING])
            ->sum('guest_count');

        return ($bookedGuests + $guestCount) <= $capacity;
    }

    private function timeSlots(): array
    {
        $slots = [];
        $start = Carbon::create(2024, 1, 1, 12, 0, 0, 'Asia/Manila');
        $end = Carbon::create(2024, 1, 1, 20, 0, 0, 'Asia/Manila');

        while ($start->lessThanOrEqualTo($end)) {
            $slots[$start->format('H:i')] = $start->format('g:i A');
            $start->addHour();
        }

        return $slots;
    }
}
