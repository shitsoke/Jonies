<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Supervisor Dashboard</title>
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

            <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>

            <nav class="main-nav dark-nav" aria-label="Supervisor navigation">
                <a class="nav-active" href="{{ route('supervisor.dashboard') }}">DASHBOARD</a>
                <a href="{{ route('home') }}" target="_blank">VIEW SITE</a>
                <form method="POST" action="{{ route('supervisor.logout') }}" style="display: inline-flex; align-items: center;">
                    @csrf
                    <button type="submit" class="button" style="background: transparent; border: 1px solid #e89a24; color: #e89a24; padding: 6px 18px; min-height: 38px; font-size: 0.9rem; font-weight: 700; cursor: pointer; border-radius: 4px; margin-left: 10px; transition: all 0.2s ease;">LOGOUT</button>
                </form>
            </nav>
        </header>

        <main class="admin-main-section supervisor-dashboard" style="padding: 40px 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
                <div>
                    <span class="section-kicker">SUPERVISOR</span>
                    <h1 style="margin: 8px 0 0; color: #f2a623; font-family: 'Barlow Condensed', sans-serif; font-size: clamp(2.4rem, 5vw, 3.2rem); font-weight: 800; line-height: 1;">{{ $user->name }}</h1>
                </div>
                <div class="branch-badges">
                    @foreach($branches as $branch)
                        <span class="branch-pill">{{ $branch->name }}</span>
                    @endforeach
                </div>
            </div>

            @if(session('success'))
                <div class="admin-alert success" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #ffffff; padding: 12px 20px; border-radius: 6px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="admin-alert error" style="background: rgba(189, 42, 42, 0.2); border: 1px solid #bd2a2a; color: #ffffff; padding: 12px 20px; border-radius: 6px; margin-bottom: 24px;">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="supervisor-stats-grid" aria-label="Reservation totals">
                <article class="supervisor-stat-card stat-pending">
                    <span class="supervisor-stat-label">Pending</span>
                    <strong>{{ $stats['pending'] }}</strong>
                    <span class="supervisor-stat-hint">Awaiting your review</span>
                </article>
                <article class="supervisor-stat-card stat-confirmed">
                    <span class="supervisor-stat-label">Confirmed</span>
                    <strong>{{ $stats['confirmed'] }}</strong>
                    <span class="supervisor-stat-hint">Approved reservations</span>
                </article>
                <article class="supervisor-stat-card stat-declined">
                    <span class="supervisor-stat-label">Declined</span>
                    <strong>{{ $stats['declined'] }}</strong>
                    <span class="supervisor-stat-hint">Not approved</span>
                </article>
                <article class="supervisor-stat-card stat-completed">
                    <span class="supervisor-stat-label">Completed</span>
                    <strong>{{ $stats['completed'] }}</strong>
                    <span class="supervisor-stat-hint">Fulfilled reservations</span>
                </article>
            </div>

            <section class="supervisor-search-panel">
                <div class="supervisor-section-heading">
                    <div>
                        <span class="section-kicker">FIND A BOOKING</span>
                        <h2>Reservation Search</h2>
                    </div>
                    <p>Filter reservations by status, customer, reference, or date.</p>
                </div>
                <form method="GET" action="{{ route('supervisor.dashboard') }}" class="reservation-search-form">
                    <label>
                        <span>Status</span>
                        <select name="status">
                            <option value="">All</option>
                            <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ ($filters['status'] ?? '') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="declined" {{ ($filters['status'] ?? '') === 'declined' ? 'selected' : '' }}>Declined</option>
                            <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </label>
                    <label>
                        <span>Customer</span>
                        <input type="text" name="customer" value="{{ $filters['customer'] ?? '' }}" placeholder="Search name">
                    </label>
                    <label>
                        <span>Reference</span>
                        <input type="text" name="reference" value="{{ $filters['reference'] ?? '' }}" placeholder="JNS-XXXXXX">
                    </label>
                    <label>
                        <span>Date</span>
                        <input type="date" name="date" value="{{ $filters['date'] ?? '' }}">
                    </label>
                    <div class="supervisor-search-actions">
                        <button type="submit" class="button">Apply Filters</button>
                        @if(collect($filters)->filter()->isNotEmpty())
                            <a href="{{ route('supervisor.dashboard') }}" class="supervisor-clear-filters">Clear filters</a>
                        @endif
                    </div>
                </form>
            </section>

            <section class="supervisor-reservations-section">
                <div class="supervisor-section-heading reservation-list-heading">
                    <div>
                        <span class="section-kicker">BRANCH BOOKINGS</span>
                        <h2>Reservations</h2>
                    </div>
                    <span class="supervisor-result-count">{{ $reservations->count() }} {{ \Illuminate\Support\Str::plural('reservation', $reservations->count()) }}</span>
                </div>
                <div class="admin-table supervisor-table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Ref</th>
                                <th>Customer</th>
                                <th>Branch</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Guests</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->reference_number }}</td>
                                    <td>{{ $reservation->customer_name }}</td>
                                    <td>{{ $reservation->branch->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $reservation->reservation_time)->format('g:i A') }}</td>
                                    <td>{{ $reservation->guest_count }}</td>
                                    <td><span class="status-badge status-{{ $reservation->status }}">{{ ucfirst(str_replace('_', ' ', $reservation->status)) }}</span></td>
                                    <td>
                                        @if($reservation->status === 'pending')
                                            <div class="supervisor-reservation-actions">
                                                <form class="supervisor-accept-form" method="POST" action="{{ route('supervisor.reservations.process', $reservation) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="button supervisor-accept-button">Accept</button>
                                                </form>
                                                <form class="supervisor-decline-form" method="POST" action="{{ route('supervisor.reservations.process', $reservation) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="declined">
                                                    <input type="text" name="reason" placeholder="Decline reason" aria-label="Reason for declining reservation" required>
                                                    <button type="submit" class="button supervisor-decline-button">Decline</button>
                                                </form>
                                            </div>
                                        @else
                                            <span style="color: #bbbbbb;">Processed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; color: #bbbbbb;">No reservations found.</td>
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
