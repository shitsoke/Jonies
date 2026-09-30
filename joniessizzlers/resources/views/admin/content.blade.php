<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Admin - Website Content</title>
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

            <nav class="main-nav dark-nav" aria-label="Admin content navigation">
                <a class="{{ request()->routeIs('admin.menu*') ? 'nav-active' : '' }}" href="{{ route('admin.menu') }}">MANAGE MENU</a>
                <a class="{{ request()->routeIs('admin.content*') ? 'nav-active' : '' }}" href="{{ route('admin.content') }}">WEBSITE CONTENT</a>
                <a class="{{ request()->routeIs('admin.promotions*') ? 'nav-active' : '' }}" href="{{ route('admin.promotions') }}">PROMOTIONS</a>
                <a href="{{ route('home') }}" target="_blank">VIEW SITE</a>
                <form method="POST" action="{{ route('admin.logout') }}" style="display: inline-flex; align-items: center;">
                    @csrf
                    <button type="submit" 
                            class="button" 
                            style="background: transparent; border: 1px solid #e89a24; color: #e89a24; padding: 6px 18px; min-height: 38px; font-size: 0.9rem; font-weight: 700; cursor: pointer; border-radius: 4px; margin-left: 10px; transition: all 0.2s ease;">
                        LOGOUT
                    </button>
</form>
            </nav>
        </header>

        <main class="admin-main-section" style="padding: 40px 0;">
            <h1 style="color: #f2a623; font-family: 'Barlow Condensed', sans-serif; font-size: 3rem; font-weight: 800; margin: 0 0 24px;">Website Content</h1>

            @if(session('success'))
                <div class="admin-alert success" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #ffffff; padding: 12px 20px; border-radius: 6px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.content.save') }}" enctype="multipart/form-data" class="content-form">
                @csrf

                @foreach($pages as $slug => $label)
                    <section class="admin-panel content-panel" style="background: #181818; border: 1px solid #2a2a2a; border-radius: 8px; padding: 28px; margin-bottom: 32px;">
                        <h2 style="color: #ffffff; font-family: 'Barlow Condensed', sans-serif; font-size: 2.2rem; font-weight: 800; margin: 0 0 20px; border-bottom: 1px solid #333; padding-bottom: 10px;">
                            {{ $label }}
                        </h2>

                        @php $entries = $content[$slug] ?? collect(); @endphp
                        @if($entries->isEmpty())
                            <div class="content-empty-state" style="color: #999; margin-bottom: 16px;">
                                <p>No content entries yet for this page. Default fields added below:</p>
                            </div>
                        @endif

                        @foreach($entries as $entry)
                            <div class="content-row" style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 20px; background: #222; padding: 16px; border-radius: 6px; border: 1px solid #2e2e2e;">
                                <label style="display: flex; flex-direction: column; gap: 8px;">
                                    <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Field Label</span>
                                    <input type="text" name="content[{{ $slug }}][{{ $entry->key }}][label]" value="{{ old('content.' . $slug . '.' . $entry->key . '.label', $entry->label) }}" style="background: #181818; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                                </label>

                                @if(str_contains($entry->key, 'image') || str_contains($entry->key, 'photo'))
                                    <label style="display: flex; flex-direction: column; gap: 8px;">
                                        <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Upload Image</span>
                                        <input type="file" name="images[{{ $slug }}][{{ $entry->key }}]" accept="image/*" style="background: #181818; border: 1px solid #333; color: #fff; padding: 8px 14px; border-radius: 6px;">
                                        <input type="hidden" name="content[{{ $slug }}][{{ $entry->key }}][value]" value="{{ $entry->value }}">
                                        
                                        @if($entry->value)
                                            <div class="promotion-current-image" style="margin-top: 10px; display: flex; align-items: center; gap: 12px;">
                                                <span style="color: #999; font-size: 0.82rem;">Current:</span>
                                                <img src="{{ str_starts_with($entry->value, 'http') ? $entry->value : asset('storage/' . $entry->value) }}" alt="{{ $entry->label }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #333; background: #000;">
                                            </div>
                                        @endif
                                    </label>
                                @else
                                    <label style="display: flex; flex-direction: column; gap: 8px;">
                                        <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Value</span>
                                        <textarea name="content[{{ $slug }}][{{ $entry->key }}][value]" rows="3" style="background: #181818; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">{{ old('content.' . $slug . '.' . $entry->key . '.value', $entry->value) }}</textarea>
                                    </label>
                                @endif

                                <input type="hidden" name="content[{{ $slug }}][{{ $entry->key }}][sort_order]" value="{{ $entry->sort_order }}">
                            </div>
                        @endforeach

                        @if($entries->isEmpty())
                            <div class="content-row" style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 20px; background: #222; padding: 16px; border-radius: 6px;">
                                <label style="display: flex; flex-direction: column; gap: 8px;">
                                    <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Field Label</span>
                                    <input type="text" name="content[{{ $slug }}][main_title][label]" value="Main Title" style="background: #181818; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px;">
                                </label>

                                <label style="display: flex; flex-direction: column; gap: 8px;">
                                    <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Value</span>
                                    <textarea name="content[{{ $slug }}][main_title][value]" rows="3" style="background: #181818; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px;">Welcome to Jonies</textarea>
                                </label>

                                <input type="hidden" name="content[{{ $slug }}][main_title][sort_order]" value="0">
                            </div>

                            <div class="content-row" style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 20px; background: #222; padding: 16px; border-radius: 6px;">
                                <label style="display: flex; flex-direction: column; gap: 8px;">
                                    <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Field Label</span>
                                    <input type="text" name="content[{{ $slug }}][hero_image][label]" value="Hero Image" style="background: #181818; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px;">
                                </label>

                                <label style="display: flex; flex-direction: column; gap: 8px;">
                                    <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Upload Hero Image</span>
                                    <input type="file" name="images[{{ $slug }}][hero_image]" accept="image/*" style="background: #181818; border: 1px solid #333; color: #fff; padding: 8px 14px; border-radius: 6px;">
                                    <input type="hidden" name="content[{{ $slug }}][hero_image][value]" value="">
                                </label>

                                <input type="hidden" name="content[{{ $slug }}][hero_image][sort_order]" value="1">
                            </div>
                        @endif
                    </section>
                @endforeach

                <div class="admin-actions" style="margin-top: 24px;">
                    <button type="submit" class="button" style="background: #e89a24; border-color: #e89a24; color: #111; padding: 12px 32px; font-size: 1rem;">Save Changes</button>
                </div>
            </form>
        </main>

        <footer class="site-footer">
            <div class="footer-brand">
                <div class="brand-name">JONIES</div>
                <div class="brand-tag">SIZZLERS + ROAST</div>
            </div>
            <span>&copy; {{ date('Y') }} Jonies Admin Portal. All rights reserved.</span>
        </footer>
    </div>
</body>

</html>