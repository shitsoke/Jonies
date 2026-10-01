<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Menu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="menu-page-body">
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
                <a class="nav-active" href="{{ route('menu') }}">MENU</a>
                <a href="{{ route('location') }}">LOCATION</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="menu-reference-main">
            <!-- Centered Page Header -->
            <div class="menu-hero-center">
                <h1>Crave-Worthy Favorites!</h1>
                <p>
                    Big flavors at prices that keep your wallet happy. Available for<br>
                    solo dining with unli-rice options, or massive bundles built for sharing.
                </p>
            </div>

            <!-- Compact Red Category Pills -->
            <div class="menu-category-banners" style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin-bottom: 32px;" aria-label="Menu categories">
                @foreach($categories as $key => $label)
                    <a href="{{ route('menu', ['category' => $key]) }}"
                       style="background: #a82323; color: #ffffff; padding: 14px 24px; border-radius: 8px; font-weight: 800; text-decoration: none; font-family: 'Barlow Condensed', sans-serif; font-size: 1.15rem; letter-spacing: 0.5px; border: 2px solid {{ $selectedCategory === $key ? '#f2b84b' : 'transparent' }}; box-shadow: {{ $selectedCategory === $key ? '0 0 12px rgba(242, 184, 75, 0.4)' : 'none' }}; transition: all 0.2s ease;">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <!-- Food Items Listing Grid -->
            <section class="menu-grid">
                @forelse ($items as $item)
                    <article class="menu-card">
                        <div class="menu-card-image-wrap">
                            @php
                                $imageUrl = $item->image_path ?? $item->image;
                                if ($imageUrl && !str_starts_with($imageUrl, 'http')) {
                                    $imageUrl = str_starts_with($imageUrl, 'images/') ? asset($imageUrl) : asset('storage/' . $imageUrl);
                                }
                            @endphp
                            <img src="{{ $imageUrl ?: asset('images/All time favorites.jpg') }}" alt="{{ $item->title ?? $item->name }}">
                        </div>
                        <div class="menu-card-body">
                            <div class="menu-card-top">
                                <h3>{{ $item->title ?? $item->name }}</h3>
                                <span>₱{{ number_format((float) ($item->price ?? 0), 2) }}</span>
                            </div>
                            <p>{{ $item->description ?: 'Freshly prepared and served with the Jonies signature taste.' }}</p>
                            <a class="menu-card-details" href="{{ route('menu-items.show', $item) }}">VIEW DETAILS</a>
                        </div>
                    </article>
                @empty
                    <div class="menu-empty">
                        <p>No items found in this category yet.</p>
                    </div>
                @endforelse
            </section>
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