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

<body class="dark-home-body">
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
                <a class="nav-active" href="{{ route('home') }}">HOME</a>
                <a href="{{ route('about') }}">ABOUT</a>
                <a href="{{ route('menu') }}">MENU</a>
                <a href="{{ route('location') }}">LOCATION</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main>
            <section class="hero-section dark-hero" aria-labelledby="hero-title">
                <div class="hero-copy">
                    <h1 id="hero-title">
                        {{ $pageContent->get('main_title')?->value ?? 'Have a' }}<br>
                        <span>{{ $pageContent->get('subtitle')?->value ?? 'Sizzling Day!' }}</span>
                    </h1>
                    <p class="lead-text-dark">
                        {{ $pageContent->get('lead_text')?->value ?? "Serving Cebu's favorite sizzling home-style plates and roasted specialties for 25 years." }}
                    </p>
                    <p class="hero-description-dark">
                        {{ $pageContent->get('supporting_text')?->value ?? "Experience the ultimate Filipino comfort food experience. From our iconic table-side flaming chicken to smoking-hot iron plates packed with savory goodness, we serve up bold flavors that bring people together." }}
                    </p>
                </div>

                <div class="hero-visual">
                    {{-- Main Photo Card --}}
                    <div class="photo-card large-card">
                        @php
                            $heroImage = $pageContent->get('hero_image')?->value;
                            $heroImageUrl = $heroImage 
                                ? (str_starts_with($heroImage, 'images/') ? asset($heroImage) : asset('storage/' . $heroImage)) 
                                : asset('images/homeImage 1.jpg');
                        @endphp
                        <img src="{{ $heroImageUrl }}" alt="Chef preparing sizzling flaming chicken">
                    </div>

                    {{-- Top Right Photo Card --}}
                    <div class="photo-card top-card">
                        @php
                            $heroImage2 = $pageContent->get('hero_image_2')?->value;
                            $heroImage2Url = $heroImage2 
                                ? (str_starts_with($heroImage2, 'images/') ? asset($heroImage2) : asset('storage/' . $heroImage2)) 
                                : asset('images/homeImage 2.jpg');
                        @endphp
                        <img src="{{ $heroImage2Url }}" alt="Jonies rice bowl specialty with egg">
                    </div>

                    {{-- Bottom Right Photo Card --}}
                    <div class="photo-card bottom-card">
                        @php
                            $heroImage3 = $pageContent->get('hero_image_3')?->value;
                            $heroImage3Url = $heroImage3 
                                ? (str_starts_with($heroImage3, 'images/') ? asset($heroImage3) : asset('storage/' . $heroImage3)) 
                                : asset('images/homeImage 3.jpg');
                        @endphp
                        <img src="{{ $heroImage3Url }}" alt="Sizzling sisig plate with egg and calamansi">
                    </div>
                </div>
            </section>

            <section class="home-section" aria-labelledby="sizzling-title">
                <div class="section-heading">
                    <div>
                        <p class="section-kicker">WHAT'S SIZZLING</p>
                        <h2 id="sizzling-title">Good reasons to drop by.</h2>
                    </div>
                </div>
                <div class="promo-grid">
                    @forelse($promotions as $promotion)
                        <article class="promo-card">
                            <div class="promo-card-image">
                                <img src="{{ asset('storage/' . $promotion->image_path) }}" alt="{{ $promotion->title }}">
                            </div>
                            <div class="promo-card-body">
                                <h3>{{ $promotion->title }}</h3>
                                <p>{{ $promotion->description }}</p>
                                <a class="text-link" href="{{ route('promotions.show', $promotion) }}">VIEW DETAILS &rarr;</a>
                            </div>
                        </article>
                    @empty
                        <article class="promo-card">
                            <div class="promo-card-image">
                                <img src="{{ asset('images/All time Favorites.png') }}" alt="A Jonies favorite meal">
                            </div>
                            <div class="promo-card-body">
                                <h3>Bring Your Appetite</h3>
                                <p>Big portions, familiar flavors, and a table worth sharing.</p>
                                <a class="text-link" href="{{ route('menu') }}">VIEW DETAILS &rarr;</a>
                            </div>
                        </article>
                        <article class="promo-card">
                            <div class="promo-card-image">
                                <img src="{{ asset('images/image 2.png') }}" alt="Friends sharing a meal at Jonies">
                            </div>
                            <div class="promo-card-body">
                                <h3>Made for Sharing</h3>
                                <p>Gather your favorite people around a spread of sizzling plates.</p>
                                <a class="text-link" href="{{ route('location') }}">FIND A BRANCH &rarr;</a>
                            </div>
                        </article>
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
                    @forelse($menuItems ?? [] as $item)
                        @php
                            $itemName = strtolower($item->title ?? $item->category ?? '');
                            $imagePath = $item->image_path ?? $item->image ?? '';

                            // Handle specific dessert/halo-halo image assignment
                            if (str_contains($itemName, 'dessert') || str_contains($itemName, 'halo')) {
                                $imageSrc = asset('images/Halo Halo.png');
                            } elseif (!empty($imagePath)) {
                                $imageSrc = str_starts_with($imagePath, 'http')
                                    ? $imagePath
                                    : (str_starts_with($imagePath, 'images/')
                                        ? asset($imagePath)
                                        : asset('storage/' . $imagePath));
                            } else {
                                $imageSrc = asset('images/All time favorites.jpg');
                            }
                        @endphp

                        <article class="feature-card">
                            <div class="feature-card-image">
                                <img src="{{ $imageSrc }}" alt="{{ $item->title ?? 'Menu Item' }}">
                            </div>
                            <div class="feature-card-body">
                                <h3>{{ $item->title ?? $item->category ?? 'Sizzling Special' }}</h3>
                                <p>{{ Str::limit($item->description ?? 'Juicy, sizzling plates made for your everyday cravings.', 80) }}</p>
                                <div class="card-meta">
                                    @if(isset($item->price))
                                        <span>₱{{ number_format($item->price, 2) }}</span>
                                    @endif
                                    <a class="text-link" href="{{ route('menu') }}">VIEW</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        {{-- Static Category Fallbacks --}}
                        <article class="feature-card">
                            <div class="feature-card-image"><img src="{{ asset('images/All time favorites.jpg') }}" alt="All-Time Favorites"></div>
                            <div class="feature-card-body">
                                <h3>All-Time Favorites</h3>
                                <p>Juicy, sizzling plates made for your everyday cravings.</p>
                                <div class="card-meta"><span>From ₱299</span><a class="text-link" href="{{ route('foods.show', 'all-time-favorites') }}">VIEW</a></div>
                            </div>
                        </article>

                        <article class="feature-card">
                            <div class="feature-card-image"><img src="{{ asset('images/House of Specialties.png') }}" alt="House Specialties"></div>
                            <div class="feature-card-body">
                                <h3>House Specialties</h3>
                                <p>Signature flavors with a little extra Jonies magic.</p>
                                <div class="card-meta"><span>From ₱349</span><a class="text-link" href="{{ route('foods.show', 'house-specialties') }}">VIEW</a></div>
                            </div>
                        </article>

                        <article class="feature-card">
                            <div class="feature-card-image"><img src="{{ asset('images/Seafood.png') }}" alt="Fresh Seafood"></div>
                            <div class="feature-card-body">
                                <h3>Fresh Seafood</h3>
                                <p>Flavor-packed seafood grilled and served hot.</p>
                                <div class="card-meta"><span>From ₱399</span><a class="text-link" href="{{ route('foods.show', 'fresh-seafood') }}">VIEW</a></div>
                            </div>
                        </article>

                        <article class="feature-card">
                            <div class="feature-card-image"><img src="{{ asset('images/Halo Halo.png') }}" alt="Halo-Halo Dessert"></div>
                            <div class="feature-card-body">
                                <h3>Dessert</h3>
                                <p>Sweet Filipino treats featuring our signature Halo-Halo.</p>
                                <div class="card-meta"><span>From ₱120</span><a class="text-link" href="{{ route('foods.show', 'dessert') }}">VIEW</a></div>
                            </div>
                        </article>
                    @endforelse
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
                <div class="section-heading">
                    <div>
                        <p class="section-kicker">VISIT US</p>
                        <h2 id="visit-title">Your next meal is nearby.</h2>
                    </div>
                    <a class="text-link" href="{{ route('location') }}">ALL LOCATIONS &rarr;</a>
                </div>
                <div class="location-cards">
                    <article class="location-card">
                        <h3>SM City Cebu</h3>
                        <p>North Reclamation Area<br>Open daily, 11:00 AM to 9:00 PM</p>
                        <a class="text-link" href="{{ route('location') }}">VIEW LOCATION &rarr;</a>
                    </article>
                    <article class="location-card">
                        <h3>Ayala Center Cebu</h3>
                        <p>Business Park<br>Open daily, 11:00 AM to 9:00 PM</p>
                        <a class="text-link" href="{{ route('location') }}">VIEW LOCATION &rarr;</a>
                    </article>
                    <article class="location-card">
                        <h3>Ayala Central Bloc</h3>
                        <p>Cebu IT Park<br>Open daily, 10:00 AM to 10:00 PM</p>
                        <a class="text-link" href="{{ route('location') }}">VIEW LOCATION &rarr;</a>
                    </article>
                </div>
            </section>

            <section class="home-section story-section" aria-labelledby="connect-title">
                <div class="story-copy">
                    <p class="section-kicker">LET'S CONNECT</p>
                    <h2 id="connect-title">Come hungry. Leave happy.</h2>
                    <p>Questions, celebrations, or just a craving? Our team would love to hear from you.</p>
                    <div class="section-actions"><a class="button" href="{{ route('contact') }}">GET IN TOUCH</a></div>
                </div>
                <div class="story-image"><img src="{{ asset('images/homeImage 3.jpg') }}" alt="Sizzling Jonies meal ready to serve"></div>
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