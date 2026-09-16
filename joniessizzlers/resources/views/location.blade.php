<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Location</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="location-page-body">
    <div class="location-shell">
        <header class="site-header">
            <div class="brand-wrap" aria-label="Jonies home">
                <img class="brand-mark" src="{{ asset('images/Jonies logo.jpg') }}" alt="Jonies logo">
                <div class="brand-copy">
                    <span class="brand-name">JONIES</span>
                    <span class="brand-tag">SIZZLERS + ROAST</span>
                </div>
            </div>

            <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="main-nav" aria-label="Main menu">
                <a href="{{ route('home') }}">HOME</a>
                <a href="{{ route('about') }}">ABOUT</a>
                <a href="{{ route('menu') }}">MENU</a>
                <a href="{{ route('location') }}" class="nav-active">LOCATION</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="location-section">
            <div class="location-main">
                <div class="location-badge-wrap">
                    <span class="location-badge">LOCATION</span>
                </div>

                <h1>{{ $pageContent->get('main_title')?->value ?? 'VISIT US' }}</h1>
                <p class="location-intro">{{ $pageContent->get('intro')?->value ?? 'Drop by for a dine-in experience, or grab your favorites for takeout.' }}</p>

                <div class="location-columns">
                    <div class="location-list">
                        <ul>
                            <li>SM City Cebu</li>
                            <li>Ayala Center Cebu</li>
                            <li>IT Park</li>
                            <li>One Pavilion</li>
                            <li>Insular Square</li>
                        </ul>
                    </div>

                    <div class="location-list">
                        <ul>
                            <li>City Time Square</li>
                            <li>Danao</li>
                            <li>SM Consolacion</li>
                            <li>Robinson's Galleria</li>
                            <li>Ayala Central Bloc</li>
                        </ul>
                    </div>
                </div>

                <div class="hours-box">
                    <h2>OPERATING HOURS</h2>
                    <div class="hours-row">
                        <span>MONDAY TO THURSDAY</span>
                        <strong>11:00 AM – 9:00 PM</strong>
                    </div>
                    <div class="hours-row">
                        <span>FRIDAY TO SUNDAY</span>
                        <strong>10:00 AM – 10:00 PM</strong>
                    </div>
                </div>
            </div>

            <div class="location-visuals">
                <div class="map-panel">
                    <img src="{{ asset('images/Location image.png') }}" alt="Jonies location map">
                </div>
            </div>
        </main>
    </div>
</body>

</html>
