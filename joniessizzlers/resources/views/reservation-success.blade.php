<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Reservation Submitted</title>
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
                <section class="reservation-confirmation-card">
                    <span class="section-kicker">REQUEST SUBMITTED</span>
                    <h1>Reservation Received</h1>
                    <p class="reservation-confirmation-message">Your reservation request has been submitted successfully.</p>

                    <div class="reservation-summary-box" aria-label="Reservation details">
                        <div class="reservation-summary-item"><span>Reference No.</span><strong>{{ $reservation->reference_number }}</strong></div>
                        <div class="reservation-summary-item"><span>Branch</span><strong>{{ $reservation->branch->name }}</strong></div>
                        <div class="reservation-summary-item"><span>Date</span><strong>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('F j, Y') }}</strong></div>
                        <div class="reservation-summary-item"><span>Time</span><strong>{{ \Carbon\Carbon::createFromFormat('H:i:s', $reservation->reservation_time)->format('g:i A') }}</strong></div>
                        <div class="reservation-summary-item"><span>Guests</span><strong>{{ $reservation->guest_count }}</strong></div>
                        <div class="reservation-summary-item reservation-status-summary"><span>Status</span><strong class="reservation-confirmation-status">{{ ucfirst(str_replace('_', ' ', $reservation->status)) }}</strong></div>
                    </div>

                    <p class="reservation-status-note">Your reservation is currently pending supervisor approval and is not yet confirmed.</p>

                    <div class="reservation-action-row">
                        <a href="{{ route('reservation.status') }}" class="button button-secondary">CHECK STATUS</a>
                        <a href="{{ route('home') }}" class="button">BACK HOME</a>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
