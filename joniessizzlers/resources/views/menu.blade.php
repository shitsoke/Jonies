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
    <div class="menu-shell">
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
                <a href="{{ route('menu') }}" class="nav-active">MENU</a>
                <a href="{{ route('location') }}">LOCATION</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="menu-page">
            <div class="menu-hero">
                <h1>Crave-Worthy Favorites!</h1>

                <p>
                    Big flavors at prices that keep your wallet happy. Available for solo dining with unli-rice options, or massive bundles built for sharing.
                </p>
            </div>

            <div class="menu-category-tabs" aria-label="Menu categories">
                @foreach($categories as $key => $label)
                    <a href="{{ route('menu', ['category' => $key]) }}"
                       class="menu-tab {{ $selectedCategory === $key ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <section class="menu-grid">
                @forelse ($items as $item)
                    <article class="menu-card">
                        <div class="menu-card-image-wrap">
                            @php
                                $imageUrl = $item->image_path;
                                if ($imageUrl && !str_starts_with($imageUrl, 'http')) {
                                    $imageUrl = asset('storage/' . $imageUrl);
                                }
                            @endphp
                            <img src="{{ $imageUrl ?: 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $item->title }}">
                        </div>
                        <div class="menu-card-body">
                            <div class="menu-card-top">
                                <h3>{{ $item->title }}</h3>
                                <span>₱{{ number_format((float) $item->price, 2) }}</span>
                            </div>
                            <p>{{ $item->description ?: 'Freshly prepared and served with the Jonies signature taste.' }}</p>
                        </div>
                    </article>
                @empty
                    <div class="menu-empty">
                        <p>No items found in this category yet.</p>
                    </div>
                @endforelse
            </section>
        </main>
    </div>
</body>

</html>
