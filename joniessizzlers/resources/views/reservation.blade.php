<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Reserve a Table</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="careers-page-body">
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

            <nav class="main-nav dark-nav" aria-label="Main menu">
                <a href="{{ route('home') }}">HOME</a>
                <a href="{{ route('about') }}">ABOUT</a>
                <a href="{{ route('menu') }}">MENU</a>
                <a href="{{ route('location') }}">LOCATION</a>
                <a class="nav-active" href="{{ route('reservation') }}">RESERVE A SEAT</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="reservation-page-shell">
            <div class="reservation-page-inner">
                <section class="reservation-form-shell">
                    <div class="reservation-header-block">
                        <span class="section-kicker">BOOK YOUR TABLE</span>
                        <h1>Reserve a Seat</h1>
                        <p>Share your details and preferred time. Your reservation will be pending until the branch supervisor approves it.</p>
                    </div>

                    @if ($errors->any())
                        <div class="admin-alert error reservation-errors" role="alert">
                            <strong>Please review the following:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservation.store') }}" class="reservation-form">
                        @csrf

                        <div class="reservation-form-grid">
                            <label>
                                <span>Customer Name</span>
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}" autocomplete="name" placeholder="Enter your full name" required>
                            </label>

                            <label>
                                <span>Contact Number</span>
                                <input type="tel" name="contact_number" value="{{ old('contact_number') }}" autocomplete="tel" placeholder="e.g. 09XX XXX XXXX" required>
                            </label>

                            <label>
                                <span>Branch</span>
                                <select name="branch_id" required>
                                    <option value="">Select a branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <label>
                                <span>Reservation Date</span>
                                <input type="date" name="reservation_date" value="{{ old('reservation_date') }}" min="{{ date('Y-m-d') }}" required>
                            </label>

                            <label>
                                <span>Reservation Time</span>
                                <select name="reservation_time" required>
                                    <option value="">Select a time</option>
                                    @foreach($reservationTimes as $timeValue => $timeLabel)
                                        <option value="{{ $timeValue }}" {{ old('reservation_time') == $timeValue ? 'selected' : '' }}>
                                            {{ $timeLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <label>
                                <span>Number of Guests</span>
                                <input type="number" name="guest_count" value="{{ old('guest_count', 2) }}" min="1" max="20" required>
                            </label>
                        </div>

                        <label class="reservation-full-width">
                            <span>Additional Requests</span>
                            <textarea name="additional_requests" rows="4" placeholder="Optional notes or special requests...">{{ old('additional_requests') }}</textarea>
                        </label>

                        <div class="reservation-policy-box">
                            <p class="reservation-policy-title">Important reservation policy</p>
                            <p>Failure to arrive within 30 minutes of your reserved time will result in the forfeiture of your reservation.</p>
                        </div>

                        <label class="policy-checkbox">
                            <input type="checkbox" name="policy_accepted" value="1" {{ old('policy_accepted') ? 'checked' : '' }} required>
                            <span>I have read and agree to the reservation policy.</span>
                        </label>

                        <div class="reservation-action-row">
                            <button type="submit" class="button reservation-submit">Request Reservation</button>
                            <a href="{{ route('reservation.status') }}" class="button button-secondary">Check Reservation</a>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
