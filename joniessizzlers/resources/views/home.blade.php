<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Sizzlers + Roast</title>
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
                <div class="brand-copy">
                    <span class="brand-name">JONIES</span>
                    <span class="brand-tag">SIZZLERS + ROAST</span>
                </div>
            </a>

            <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>

            <nav class="main-nav" aria-label="Main menu">
                <a class="nav-active" href="{{ route('home') }}">HOME</a>
                <a href="{{ route('about') }}">ABOUT</a>
                <a href="{{ route('menu') }}">MENU</a>
                <a href="{{ route('location') }}">LOCATION</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main>
            <section class="hero-section" aria-labelledby="hero-title">
                <div class="hero-copy">
                    <p class="eyebrow">JONIES SIZZLERS + ROAST</p>
                    <h1 id="hero-title">
                        {{ $pageContent->get('main_title')?->value ?? 'Have a' }}<br>
                        <span>{{ $pageContent->get('subtitle')?->value ?? 'Sizzling Day!' }}</span>
                    </h1>
                    <p class="lead-text">
                        {{ $pageContent->get('lead_text')?->value ?? "Serving Cebu's favorite sizzling home-style plates and roasted specialties for 25 years." }}
                    </p>
                    <div class="hero-actions">
                        <a class="button" href="{{ route('menu') }}">VIEW MENU</a>
                        <a class="button button-secondary" href="{{ route('location') }}">FIND A LOCATION</a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="photo-card large-card">
                        <img src="{{ asset('images/homeImage 1.jpg') }}" alt="Chef preparing sizzling food">
                    </div>
                    <div class="photo-card top-card"><img src="{{ asset('images/homeImage 2.jpg') }}" alt="Jonies dish with eggs and rice"></div>
                    <div class="photo-card bottom-card"><img src="{{ asset('images/homeImage 3.jpg') }}" alt="Sizzling plate with rice and egg"></div>
                </div>
            </section>

            <section class="home-section" aria-labelledby="sizzling-title">
                <div class="section-heading"><div><p class="section-kicker">WHAT'S SIZZLING</p><h2 id="sizzling-title">Good reasons to drop by.</h2></div></div>
                <div class="promo-grid">
                    @forelse($promotions as $promotion)
                        <article class="promo-card"><div class="promo-card-image"><img src="{{ asset('storage/' . $promotion->image_path) }}" alt="{{ $promotion->title }}"></div><div class="promo-card-body"><h3>{{ $promotion->title }}</h3><p>{{ $promotion->description }}</p><a class="text-link" href="{{ route('promotions.show', $promotion) }}">VIEW DETAILS &rarr;</a></div></article>
                    @empty
                        <article class="promo-card"><div class="promo-card-image"><img src="{{ asset('images/All time Favorites.png') }}" alt="A Jonies favorite meal"></div><div class="promo-card-body"><h3>Bring Your Appetite</h3><p>Big portions, familiar flavors, and a table worth sharing.</p><a class="text-link" href="{{ route('menu') }}">VIEW DETAILS &rarr;</a></div></article>
                        <article class="promo-card"><div class="promo-card-image"><img src="{{ asset('images/image 2.png') }}" alt="Friends sharing a meal at Jonies"></div><div class="promo-card-body"><h3>Made for Sharing</h3><p>Gather your favorite people around a spread of sizzling plates.</p><a class="text-link" href="{{ route('location') }}">FIND A BRANCH &rarr;</a></div></article>
                    @endforelse
                </div>
            </section>

            <section class="home-section" aria-labelledby="favorites-title">
                <div class="section-heading">
                    <div>
                        <p class="section-kicker">OUR FAVORITES</p>
                        <h2 id="favorites-title">Made to satisfy.</h2>
                    </div>
                    <a class="text-link" href="{{ route('menu') }}">SEE FULL MENU &rarr;</a>
                </div>
                <div class="feature-grid">
                    <article class="feature-card">
                        <div class="feature-card-image"><img src="{{ asset('images/All time favorites.jpg') }}" alt="Jonies all-time favorite dish"></div>
                        <div class="feature-card-body"><h3>All-Time Favorites</h3><p>Juicy, sizzling plates made for your everyday cravings.</p><div class="card-meta"><span>From ₱299</span><a class="text-link" href="{{ route('foods.show', 'all-time-favorites') }}">VIEW</a></div></div>
                    </article>
                    <article class="feature-card">
                        <div class="feature-card-image"><img src="{{ asset('images/House of Specialties.png') }}" alt="Jonies house specialty"></div>
                        <div class="feature-card-body"><h3>House Specialties</h3><p>Signature flavors with a little extra Jonies magic.</p><div class="card-meta"><span>From ₱349</span><a class="text-link" href="{{ route('foods.show', 'house-specialties') }}">VIEW</a></div></div>
                    </article>
                    <article class="feature-card">
                        <div class="feature-card-image"><img src="{{ asset('images/Seafood.png') }}" alt="Jonies seafood dish"></div>
                        <div class="feature-card-body"><h3>Fresh Seafood</h3><p>Flavor-packed seafood grilled and served hot.</p><div class="card-meta"><span>From ₱399</span><a class="text-link" href="{{ route('foods.show', 'fresh-seafood') }}">VIEW</a></div></div>
                    </article>
                </div>
            </section>

            <section class="home-section story-section" aria-labelledby="story-title">
                <div class="story-image"><img src="{{ asset('images/image 1.png') }}" alt="A table filled with Jonies food"></div>
                <div class="story-copy">
                    <p class="section-kicker">OUR STORY</p>
                    <h2 id="story-title">25 Years of Serving Cebu</h2>
                    <p>{{ $pageContent->get('supporting_text')?->value ?? 'Born in Cebu, Jonies brings people together over hot plates, roasted specialties, and the kind of generous Filipino comfort food that feels like home.' }}</p>
                    <div class="section-actions"><a class="button" href="{{ route('about') }}">LEARN MORE</a></div>
                </div>
            </section>

            <section class="home-section" aria-labelledby="visit-title">
                <div class="section-heading"><div><p class="section-kicker">VISIT US</p><h2 id="visit-title">Your next meal is nearby.</h2></div><a class="text-link" href="{{ route('location') }}">ALL LOCATIONS &rarr;</a></div>
                <div class="location-cards">
                    <article class="location-card"><h3>SM City Cebu</h3><p>North Reclamation Area<br>Open daily, 11:00 AM to 9:00 PM</p><a class="text-link" href="{{ route('location') }}">VIEW LOCATION &rarr;</a></article>
                    <article class="location-card"><h3>Ayala Center Cebu</h3><p>Business Park<br>Open daily, 11:00 AM to 9:00 PM</p><a class="text-link" href="{{ route('location') }}">VIEW LOCATION &rarr;</a></article>
                    <article class="location-card"><h3>Ayala Central Bloc</h3><p>Cebu IT Park<br>Open daily, 10:00 AM to 10:00 PM</p><a class="text-link" href="{{ route('location') }}">VIEW LOCATION &rarr;</a></article>
                </div>
            </section>

            <section class="home-section story-section" aria-labelledby="connect-title">
                <div class="story-copy"><p class="section-kicker">LET'S CONNECT</p><h2 id="connect-title">Come hungry. Leave happy.</h2><p>Questions, celebrations, or just a craving? Our team would love to hear from you.</p><div class="section-actions"><a class="button" href="{{ route('contact') }}">GET IN TOUCH</a></div></div>
                <div class="story-image"><img src="{{ asset('images/homeImage 3.jpg') }}" alt="Sizzling Jonies meal ready to serve"></div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="footer-brand"><div class="brand-name">JONIES</div><div class="brand-tag">SIZZLERS + ROAST</div></div>
            <nav class="footer-links" aria-label="Footer links"><a href="{{ route('home') }}">Home</a><a href="{{ route('about') }}">About</a><a href="{{ route('menu') }}">Menu</a><a href="{{ route('location') }}">Location</a><a href="{{ route('careers') }}">Careers</a><a href="{{ route('contact') }}">Contact</a></nav>
            <span>&copy; {{ date('Y') }} Jonies. All rights reserved.</span>
        </footer>
    </div>
</body>

</html>
