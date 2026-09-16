<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $food['title'] }} | JONIES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="page-shell">
        <header class="site-header">
            <a class="brand-wrap" href="{{ route('home') }}" aria-label="Jonies home">
                <img class="brand-mark" src="{{ asset('images/Jonies logo.jpg') }}" alt="Jonies logo">
                <div class="brand-copy"><span class="brand-name">JONIES</span><span class="brand-tag">SIZZLERS + ROAST</span></div>
            </a>
            <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false"><span></span><span></span><span></span></button>
            <nav class="main-nav" aria-label="Main menu">
                <a href="{{ route('home') }}">HOME</a><a href="{{ route('about') }}">ABOUT</a><a class="nav-active" href="{{ route('menu') }}">MENU</a><a href="{{ route('location') }}">LOCATION</a><a href="{{ route('contact') }}">GET IN TOUCH</a><a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="promotion-detail food-detail" aria-labelledby="food-title">
            <a class="text-link promotion-back-link" href="{{ route('home') }}">&larr; BACK TO HOME</a>
            <div class="promotion-detail-layout">
                <div class="promotion-detail-image"><img src="{{ asset($food['image']) }}" alt="{{ $food['title'] }}"></div>
                <div class="promotion-detail-copy">
                    <p class="section-kicker">JONIES MENU</p>
                    <h1 id="food-title">{{ $food['title'] }}</h1>
                    <p>{{ $food['description'] }}</p>
                    <p class="food-detail-price">{{ $food['price'] }}</p>
                    <div class="hero-actions"><a class="button" href="{{ route('menu', ['category' => $food['category']]) }}">SEE MENU ITEMS</a><a class="button button-secondary" href="{{ route('location') }}">FIND A LOCATION</a></div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>