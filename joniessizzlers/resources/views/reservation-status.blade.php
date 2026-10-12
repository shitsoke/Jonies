<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Reservation Status</title>
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
        </header>

        <main class="reservation-page-shell">
            <div class="reservation-page-inner">
                <section class="reservation-form-shell">
                    <div class="reservation-header-block">
                        <span class="section-kicker">CHECK STATUS</span>
                        <h1>Reservation Lookup</h1>
                    </div>

                    @if ($errors->any())
                        <div class="admin-alert error" style="margin-bottom: 24px;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservation.status.submit') }}" class="reservation-form">
                        @csrf
                        <div class="reservation-form-grid single-column">
                            <label>
                                <span>Reservation Reference Number</span>
                                <input type="text" name="reference_number" value="{{ old('reference_number') }}" required>
                            </label>

                            <label>
                                <span>Contact Number</span>
                                <input type="tel" name="contact_number" value="{{ old('contact_number') }}" required>
                            </label>
                        </div>

                        <div class="reservation-action-row">
                            <button type="submit" class="button reservation-submit">CHECK STATUS</button>
                        </div>
                    </form>

                    @if($reservation)
                        <div class="reservation-summary-box" style="margin-top: 28px;">
                            <div><span>Reference No.</span><strong>{{ $reservation->reference_number }}</strong></div>
                            <div><span>Branch</span><strong>{{ $reservation->branch->name }}</strong></div>
                            <div><span>Date</span><strong>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('F j, Y') }}</strong></div>
                            <div><span>Time</span><strong>{{ \Carbon\Carbon::createFromFormat('H:i:s', $reservation->reservation_time)->format('g:i A') }}</strong></div>
                            <div><span>Guests</span><strong>{{ $reservation->guest_count }}</strong></div>
                            <div><span>Status</span><strong>{{ ucfirst($reservation->status) }}</strong></div>
                            @if($reservation->decline_reason)
                                <div><span>Reason</span><strong>{{ $reservation->decline_reason }}</strong></div>
                            @endif
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </div>
</body>
</html>
