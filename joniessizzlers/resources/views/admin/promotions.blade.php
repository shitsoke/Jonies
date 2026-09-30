<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Admin - Promotions</title>
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

            <nav class="main-nav dark-nav" aria-label="Admin navigation">
                <a class="{{ request()->routeIs('admin.menu') ? 'nav-active' : '' }}" href="{{ route('admin.menu') }}">MANAGE MENU</a>
                <a class="{{ request()->routeIs('admin.content') ? 'nav-active' : '' }}" href="{{ route('admin.content') }}">WEBSITE CONTENT</a>
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
            @if(session('success'))
                <div class="admin-alert success" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #ffffff; padding: 12px 20px; border-radius: 6px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            <section class="admin-panel" style="background: #181818; border: 1px solid #2a2a2a; border-radius: 8px; padding: 28px; margin-bottom: 40px;">
                <h2 style="color: #f2a623; font-family: 'Barlow Condensed', sans-serif; font-size: 2.2rem; font-weight: 800; margin: 0 0 20px;">
                    {{ $editingPromotion ? 'Edit Promotion' : 'Add New Promotion' }}
                </h2>

                <form action="{{ $editingPromotion ? route('admin.promotions.update', $editingPromotion) : route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                    @csrf
                    @if($editingPromotion)
                        @method('PUT')
                    @endif

                    <div class="form-grid promotion-form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Promotion Title</span>
                            <input type="text" name="title" value="{{ old('title', $editingPromotion->title ?? '') }}" required style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Promotion Picture{{ $editingPromotion ? ' (optional)' : '' }}</span>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/webp" {{ $editingPromotion ? '' : 'required' }} style="background: #222; border: 1px solid #333; color: #fff; padding: 8px 14px; border-radius: 6px;">
                        </label>
                    </div>

                    <label style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                        <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Description</span>
                        <textarea name="description" rows="4" style="background: #222; border: 1px solid #333; color: #fff; padding: 12px 14px; border-radius: 6px; outline: none;">{{ old('description', $editingPromotion->description ?? '') }}</textarea>
                    </label>

                    @if($editingPromotion)
                        <div class="promotion-current-image" style="margin-bottom: 20px;">
                            <span style="display: block; color: #cccccc; font-size: 0.88rem; margin-bottom: 8px;">Current picture</span>
                            <img src="{{ asset('storage/' . $editingPromotion->image_path) }}" alt="{{ $editingPromotion->title }}" style="max-width: 200px; border-radius: 6px; border: 1px solid #333;">
                        </div>
                    @endif

                    <div class="admin-actions" style="display: flex; gap: 12px; align-items: center;">
                        <button type="submit" class="button" style="background: #e89a24; border-color: #e89a24; color: #111;">{{ $editingPromotion ? 'Update Promotion' : 'Add Promotion' }}</button>
                        @if($editingPromotion)
                            <a href="{{ route('admin.promotions') }}" class="button button-secondary">Cancel</a>
                        @endif
                    </div>
                </form>
            </section>

            <section class="admin-table-wrap">
                <h2 style="color: #ffffff; font-family: 'Barlow Condensed', sans-serif; font-size: 2.2rem; font-weight: 800; margin: 0 0 24px;">Homepage Promotions</h2>
                <div class="admin-item-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    @forelse($promotions as $promotion)
                        <article class="admin-item-card" style="background: #181818; border: 1px solid #2a2a2a; border-radius: 8px; overflow: hidden;">
                            <div style="height: 200px; overflow: hidden; background: #222;">
                                <img src="{{ asset('storage/' . $promotion->image_path) }}" alt="{{ $promotion->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="admin-item-body" style="padding: 20px;">
                                <h3 style="color: #ffffff; font-family: 'Barlow Condensed', sans-serif; font-size: 1.5rem; margin: 0 0 8px;">{{ $promotion->title }}</h3>
                                <p style="color: #cccccc; font-size: 0.9rem; line-height: 1.5; margin: 0 0 16px;">{{ $promotion->description ?: 'No description provided.' }}</p>
                                <div class="admin-item-actions" style="display: flex; gap: 10px;">
                                    <a href="{{ route('admin.promotions.edit', $promotion) }}" class="button button-secondary" style="padding: 4px 16px; min-height: 34px; font-size: 0.85rem;">Edit</a>
                                    <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" onsubmit="return confirm('Delete this promotion?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button" style="background: #bd2a2a; border-color: #bd2a2a; color: #fff; padding: 4px 16px; min-height: 34px; font-size: 0.85rem;">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="content-empty-state" style="grid-column: span 3; color: #999; text-align: center; padding: 40px; background: #181818; border-radius: 8px; border: 1px dashed #333;">
                            No promotions yet. Add the first homepage promotion above.
                        </div>
                    @endforelse
                </div>
            </section>
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