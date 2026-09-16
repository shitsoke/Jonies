<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | About</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="about-page-body">
    <div class="about-shell">
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
                <a href="{{ route('about') }}" class="nav-active">ABOUT</a>
                <a href="{{ route('menu') }}">MENU</a>
                <a href="{{ route('location') }}">LOCATION</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="about-section">
            <div class="about-copy">
                <div class="about-badge-wrap">
                    <span class="about-badge">ABOUT</span>
                </div>

                <h1>{{ $pageContent->get('main_title')?->value ?? 'Turning Everyday Dining into a Feast' }}</h1>

                <p>
                    {{ $pageContent->get('paragraph_1')?->value ?? 'Born in Cebu, Jonies Sizzlers & Roast has spent years mastering the art of the perfect sizzle.' }}
                </p>

                <p>
                    {{ $pageContent->get('paragraph_2')?->value ?? 'We specialize in hot, smoking sizzling plates, slow-cooked roasts, and our signature theatrical "flaming" dishes that turn a simple meal into an unforgettable dining experience.' }}
                </p>

                <p>
                    {{ $pageContent->get('paragraph_3')?->value ?? 'We believe that great food shouldn\'t cost a fortune. Whether you are gathered for a family reunion, catching up with friends, or grabbing a quick lunch break, our vibrant, clean, and welcoming spaces are designed to make you feel right at home. Come for the aroma, stay for the taste, and leave with a smile.' }}
                </p>
            </div>

            <div class="about-visual">
                <div class="about-photo photo-top">
                    <img src="{{ asset('images/image 1.png') }}" alt="Dining table with sizzling food">
                </div>
                <div class="about-photo photo-bottom">
                    <img src="{{ asset('images/image 2.png') }}" alt="Family enjoying food together">
                </div>
            </div>
        </main>
    </div>
</body>

</html>
