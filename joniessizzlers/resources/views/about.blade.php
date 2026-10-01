<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Sizzlers + Roast - About Us</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="about-page-body">
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
                <a class="nav-active" href="{{ route('about') }}">ABOUT</a>
                <a href="{{ route('menu') }}">MENU</a>
                <a href="{{ route('location') }}">LOCATION</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="about-reference-page">
            <div class="about-reference-content">
                <div class="about-reference-copy">
                    <h1>{{ $pageContent->get('main_title')?->value ?? 'Turning Everyday Dining into a Feast' }}</h1>
                    <div class="about-reference-text">
                        <p>{{ $pageContent->get('paragraph_1')?->value ?? 'Born in Cebu, Jonies Sizzlers & Roast has spent years mastering the art of the perfect sizzle.' }}</p>
                        <p>{{ $pageContent->get('paragraph_2')?->value ?? 'We specialize in hot, smoking sizzling plates, slow-cooked roasts, and our signature theatrical "flaming" dishes that turn a simple meal into an unforgettable dining experience.' }}</p>
                        <p>{{ $pageContent->get('paragraph_3')?->value ?? "We believe that great food shouldn't cost a fortune. Whether you are gathered for a family reunion, catching up with friends, or grabbing a quick lunch break, our vibrant, clean, and welcoming spaces are designed to make you feel right at home. Come for the aroma, stay for the taste, and leave with a smile." }}</p>
                    </div>
                </div>

                <div class="about-reference-images">
                    <div class="about-reference-image about-reference-image-top">
                        <img src="{{ asset('images/homeImage 1.jpg') }}" alt="Jonies sizzling feast spread">
                    </div>
                    <div class="about-reference-image about-reference-image-bottom">
                        <img src="{{ asset('images/image 2.png') }}" alt="Family enjoying Jonies meal">
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