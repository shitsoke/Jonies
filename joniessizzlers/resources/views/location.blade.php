<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Sizzlers + Roast - Locations</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="location-page-body">
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
                <a class="nav-active" href="{{ route('location') }}">LOCATION</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="location-reference-main">

            <!-- Page Titles -->
            <div class="location-head">
                <h1>{{ $pageContent->get('main_title')?->value ?? 'VISIT US' }}</h1>
                <p class="location-subhead">{{ $pageContent->get('intro')?->value ?? 'Drop by for a dine-in experience, or grab your favorites for takeout.' }}</p>
            </div>

            <!-- Branch Lists (Two Columns) -->
            <div class="location-branches-grid">
                <!-- Column 1 -->
                <div class="branch-column">
                    <div class="branch-item">
                        <span class="pin-icon">📍</span>
                        <div class="branch-details">
                            <h3>SM City Cebu</h3>
                            <p>Lower Ground Floor, North Reclamation Area, Cebu City</p>
                        </div>
                    </div>

                    <div class="branch-item">
                        <span class="pin-icon">📍</span>
                        <div class="branch-details">
                            <h3>Ayala Center Cebu</h3>
                            <p>Food Choice / Terraces Level, Cebu Business Park, Cebu City</p>
                        </div>
                    </div>

                    <div class="branch-item">
                        <span class="pin-icon">📍</span>
                        <div class="branch-details">
                            <h3>IT Park</h3>
                            <p>Food Choice / Terraces Level, Cebu Business Park, Cebu City</p>
                        </div>
                    </div>

                    <div class="branch-item">
                        <span class="pin-icon">📍</span>
                        <div class="branch-details">
                            <h3>One Pavilion</h3>
                            <p>Gaisano Pavilion Mall, R. Duterte St. Banawa</p>
                        </div>
                    </div>

                    <div class="branch-item">
                        <span class="pin-icon">📍</span>
                        <div class="branch-details">
                            <h3>Insular Square</h3>
                            <p>31 J.P. Rizal St., Tabok, Mandaue City</p>
                        </div>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="branch-column">
                    <div class="branch-item">
                        <span class="pin-icon">📍</span>
                        <div class="branch-details">
                            <h3>City Time Square</h3>
                            <p>City Time Square Mall, Mandaue City</p>
                        </div>
                    </div>

                    <div class="branch-item">
                        <span class="pin-icon">📍</span>
                        <div class="branch-details">
                            <h3>Danao</h3>
                            <p>Sands Danao, Cebu</p>
                        </div>
                    </div>

                    <div class="branch-item">
                        <span class="pin-icon">📍</span>
                        <div class="branch-details">
                            <h3>SM Consolacion</h3>
                            <p>Ground Floor, SM City, Consolacion, Cebu</p>
                        </div>
                    </div>

                    <div class="branch-item">
                        <span class="pin-icon">📍</span>
                        <div class="branch-details">
                            <h3>Robinson's Galleria</h3>
                            <p>General Maxilom Avenue, Cebu City</p>
                        </div>
                    </div>

                    <div class="branch-item">
                        <span class="pin-icon">📍</span>
                        <div class="branch-details">
                            <h3>Ayala Central Bloc</h3>
                            <p>4th Floor, Food Choices</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Operating Hours & Map -->
            <div class="location-bottom-grid">
                <div class="hours-card-wrap">
                    <h4 class="bottom-section-title">OPERATING HOURS</h4>
                    <div class="hours-card">
                        <div class="hours-block">
                            <h3>MONDAY TO THURSDAY</h3>
                            <p class="hours-time">11:00 AM – 9:00 PM</p>
                        </div>
                        <div class="hours-block">
                            <h3>FRIDAY TO SUNDAY</h3>
                            <p class="hours-time">10:00 AM – 10:00 PM</p>
                        </div>
                    </div>
                </div>

                <div class="map-card-wrap">
                    <h4 class="bottom-section-title">FIND US IN CEBU</h4>
                    <div class="map-container">
                        <img src="{{ asset('images/Location image.png') }}" alt="Jonies locations map of Cebu">
                    </div>
                </div>
            </div>
        </main>

        <footer class="site-footer">
            <div class="footer-brand">
                <div class="brand-name">JONIES</div>
                <div class="brand-tag">SIZZLERS + ROAST</div>
            </div>
            <nav class="footer-links" aria-label="Footer links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('menu') }}">Menu</a>
                <a href="{{ route('location') }}">Location</a>
                <a href="{{ route('careers') }}">Careers</a>
                <a href="{{ route('contact') }}">Contact</a>
            </nav>
            <span>&copy; {{ date('Y') }} Jonies. All rights reserved.</span>
        </footer>
    </div>
</body>

</html>