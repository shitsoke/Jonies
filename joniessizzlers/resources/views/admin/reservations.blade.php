<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Admin - Manage Reservations</title>
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

            <nav class="main-nav dark-nav" aria-label="Admin menu">
                <a class="{{ request()->routeIs('admin.menu*') ? 'nav-active' : '' }}" href="{{ route('admin.menu') }}">MANAGE MENU</a>
                <a class="{{ request()->routeIs('admin.content*') ? 'nav-active' : '' }}" href="{{ route('admin.content') }}">WEBSITE CONTENT</a>
                <a class="{{ request()->routeIs('admin.promotions*') ? 'nav-active' : '' }}" href="{{ route('admin.promotions') }}">PROMOTIONS</a>
                <a class="{{ request()->routeIs('admin.branches*') ? 'nav-active' : '' }}" href="{{ route('admin.branches') }}">MANAGE BRANCHES</a>
                <a class="{{ request()->routeIs('admin.supervisors*') ? 'nav-active' : '' }}" href="{{ route('admin.supervisors') }}">MANAGE SUPERVISORS</a>
                <a class="{{ request()->routeIs('admin.reservations*') ? 'nav-active' : '' }}" href="{{ route('admin.reservations') }}">MANAGE RESERVATIONS</a>
                <a href="{{ route('home') }}" target="_blank">VIEW SITE</a>
                <form method="POST" action="{{ route('admin.logout') }}" style="display: inline-flex; align-items: center;">
                    @csrf
                    <button type="submit" class="button" style="background: transparent; border: 1px solid #e89a24; color: #e89a24; padding: 6px 18px; min-height: 38px; font-size: 0.9rem; font-weight: 700; cursor: pointer; border-radius: 4px; margin-left: 10px; transition: all 0.2s ease;">LOGOUT</button>
                </form>
            </nav>
        </header>

        <main class="admin-main-section reservation-management-page" style="padding: 40px 0;">
            @if(session('success'))
                <div class="admin-alert success" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #ffffff; padding: 12px 20px; border-radius: 6px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            <section class="reservation-filter-panel">
                <div class="reservation-management-heading">
                    <div>
                        <span class="section-kicker">BOOKING OVERVIEW</span>
                        <h2>Reservation Filters</h2>
                    </div>
                    <p>Find reservations by branch, status, customer, reference, or date.</p>
                </div>
                <form method="GET" action="{{ route('admin.reservations') }}" class="admin-reservation-filter-form">
                    <label>
                        <span>Branch</span>
                        <select name="branch_id">
                            <option value="">All</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ ($filters['branch_id'] ?? '') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>Status</span>
                        <select name="status">
                            <option value="">All</option>
                            @foreach(['pending', 'confirmed', 'declined', 'cancelled', 'completed', 'no_show'] as $status)
                                <option value="{{ $status }}" {{ ($filters['status'] ?? '') === $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>Customer</span>
                        <input type="text" name="customer" value="{{ $filters['customer'] ?? '' }}" placeholder="Name">
                    </label>
                    <label>
                        <span>Reference</span>
                        <input type="text" name="reference" value="{{ $filters['reference'] ?? '' }}" placeholder="Reference">
                    </label>
                    <label>
                        <span>Date</span>
                        <input type="date" name="date" value="{{ $filters['date'] ?? '' }}">
                    </label>
                    <div class="reservation-filter-actions">
                        <button type="submit" class="button">Apply Filters</button>
                        @if(collect($filters)->filter()->isNotEmpty())
                            <a href="{{ route('admin.reservations') }}">Clear filters</a>
                        @endif
                    </div>
                </form>
            </section>

            <section class="reservation-list-panel">
                <div class="reservation-management-heading reservation-list-heading">
                    <div>
                        <span class="section-kicker">ALL BOOKINGS</span>
                        <h2>All Reservations</h2>
                    </div>
                    <span class="reservation-list-count">{{ $reservations->count() }} {{ \Illuminate\Support\Str::plural('reservation', $reservations->count()) }}</span>
                </div>
                <div class="reservation-table-scroll">
                    <table class="admin-reservations-table">
                        <thead>
                            <tr>
                                <th>Ref</th>
                                <th>Customer</th>
                                <th>Branch</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Guests</th>
                                <th>Status</th>
                                <th>Assigned Supervisor</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $reservation)
                                <tr>
                                    <td class="reservation-reference">{{ $reservation->reference_number }}</td>
                                    <td class="reservation-customer">{{ $reservation->customer_name }}</td>
                                    <td>{{ $reservation->branch->name }}</td>
                                    <td class="reservation-nowrap">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }}</td>
                                    <td class="reservation-nowrap">{{ \Carbon\Carbon::createFromFormat('H:i:s', $reservation->reservation_time)->format('g:i A') }}</td>
                                    <td class="reservation-guests">{{ $reservation->guest_count }}</td>
                                    <td><span class="status-badge status-{{ $reservation->status }}">{{ ucfirst(str_replace('_', ' ', $reservation->status)) }}</span></td>
                                    <td class="reservation-supervisor">{{ $reservation->processor?->name ?? 'N/A' }}</td>
                                    <td class="reservation-actions-cell">
                                        <a href="{{ route('admin.reservations.show', $reservation) }}" class="button button-secondary">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="text-align: center; color: #bbbbbb;">No reservations found.</td>
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
