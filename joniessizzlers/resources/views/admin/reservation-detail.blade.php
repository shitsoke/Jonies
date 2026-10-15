<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Reservation Details</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="dark-home-body">
    <div class="page-shell">
        <header class="site-header dark-header">
            <a class="brand-wrap" href="{{ route('home') }}" aria-label="Jonies home">
                <img class="brand-mark" src="{{ asset('images/Jonies logo.jpg') }}" alt="Jonies logo">
                <div class="brand-copy">
                    <span class="brand-name">JONIES</span>
                    <span class="brand-tag">SIZZLERS + ROAST</span>
                </div>
            </a>
        </header>

        <main class="admin-main-section" style="padding: 40px 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
                <div>
                    <span class="section-kicker">RESERVATION</span>
                    <h1 style="margin: 8px 0 0; color: #f2a623; font-family: 'Barlow Condensed', sans-serif; font-size: clamp(2.4rem, 5vw, 3.2rem); font-weight: 800; line-height: 1;">{{ $reservation->reference_number }}</h1>
                </div>
                <a href="{{ route('admin.reservations') }}" class="button button-secondary reservation-detail-back-link">Back to list</a>
            </div>

            <section class="reservation-summary-box" style="margin-bottom: 24px;">
                <div><span>Customer: </span><strong>{{ $reservation->customer_name }}</strong></div>
                <div><span>Contact: </span><strong>{{ $reservation->contact_number }}</strong></div>
                <div><span>Branch: </span><strong>{{ $reservation->branch->name }}</strong></div>
                <div><span>Date: </span><strong>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('F j, Y') }}</strong></div>
                <div><span>Time: </span><strong>{{ \Carbon\Carbon::createFromFormat('H:i:s', $reservation->reservation_time)->format('g:i A') }}</strong></div>
                <div><span>Guests: </span><strong>{{ $reservation->guest_count }}</strong></div>
                <div><span>Status: </span><strong>{{ ucfirst(str_replace('_', ' ', $reservation->status)) }}</strong></div>
                <div><span>Requests: </span><strong>{{ $reservation->additional_requests ?: 'None' }}</strong></div>
            </section>

            {{-- @if($reservation->decline_reason || $reservation->cancellation_reason)
                <div class="admin-alert error" style="margin-bottom: 24px;">{{ $reservation->decline_reason ?? $reservation->cancellation_reason }}</div>
            @endif --}}

            @if($reservation->status === 'pending')
                <section class="admin-panel" style="background: #181818; border: 1px solid #2a2a2a; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
                    <h2 style="margin-top: 0;">Update Status</h2>
                    <form method="POST" action="{{ route('admin.reservations.process', $reservation) }}">
                        @csrf
                        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; align-items: end;">
                            <label>
                                <span style="display: block; margin-bottom: 6px; color: #cccccc; font-size: 0.82rem; font-weight: 600;">Status</span>
                                <select name="status">
                                    <option value="confirmed">Confirm</option>
                                    <option value="declined">Decline</option>
                                    <option value="cancelled">Cancel</option>
                                </select>
                            </label>
                            <label>
                                <span style="display: block; margin-bottom: 6px; color: #cccccc; font-size: 0.82rem; font-weight: 600;">Reason</span>
                                <input type="text" name="reason" placeholder="Reason for status change" style="width: 100%;">
                            </label>
                        </div>
                        <div style="margin-top: 16px;">
                            <button type="submit" class="button">PROCESS RESERVATION</button>
                        </div>
                    </form>
                </section>
            @endif

            <section class="reservation-detail-panel reservation-history-panel">
                <h2 style="margin-top: 0;">Processing History</h2>
                <div class="reservation-history-table-wrap">
                    <table class="reservation-history-table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Previous</th>
                                <th>New</th>
                                <th>User</th>
                                <th>Time</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservation->activities as $activity)
                                <tr>
                                    <td>{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</td>
                                    <td>{{ $activity->previous_status ? ucfirst(str_replace('_', ' ', $activity->previous_status)) : '—' }}</td>
                                    <td>{{ $activity->new_status ? ucfirst(str_replace('_', ' ', $activity->new_status)) : '—' }}</td>
                                    <td>{{ $activity->user?->name ?? 'System' }}</td>
                                    <td>{{ $activity->created_at->format('M d, Y h:i A') }}</td>
                                    <td class="reservation-history-reason">{{ $activity->reason ?: '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="reservation-history-empty">No activity recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
