<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Admin - Manage Menu</title>
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

            <nav class="main-nav dark-nav" aria-label="Admin menu">
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
            @if(session('success'))
                <div class="admin-alert success" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #ffffff; padding: 12px 20px; border-radius: 6px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            <section class="admin-panel" style="background: #181818; border: 1px solid #2a2a2a; border-radius: 8px; padding: 28px; margin-bottom: 40px;">
                <h2 style="color: #f2a623; font-family: 'Barlow Condensed', sans-serif; font-size: 2.2rem; font-weight: 800; margin: 0 0 20px;">
                    {{ isset($editingItem) ? 'Edit Menu Item' : 'Add New Menu Item' }}
                </h2>

                <form action="{{ isset($editingItem) ? route('admin.menu.update', $editingItem) : route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                    @csrf
                    @if(isset($editingItem))
                        @method('PUT')
                    @endif

                    <div class="form-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Title</span>
                            <input type="text" name="title" value="{{ old('title', $editingItem->title ?? '') }}" required style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>

                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Category</span>
                            <select name="category" style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category', $editingItem->category ?? '') === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Price (₱)</span>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $editingItem->price ?? '') }}" required style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>
                    </div>

                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr; gap: 20px; margin-bottom: 20px;">
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Image{{ isset($editingItem) ? ' (optional)' : '' }}</span>
                            <input type="file" name="image" accept="image/*" {{ isset($editingItem) ? '' : 'required' }} style="background: #222; border: 1px solid #333; color: #fff; padding: 8px 14px; border-radius: 6px;">
                        </label>

                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Description</span>
                            <textarea name="description" rows="3" style="background: #222; border: 1px solid #333; color: #fff; padding: 12px 14px; border-radius: 6px; outline: none;">{{ old('description', $editingItem->description ?? '') }}</textarea>
                        </label>
                    </div>

                    <div class="admin-actions" style="display: flex; gap: 12px; align-items: center;">
                        <button type="submit" class="button" style="background: #e89a24; border-color: #e89a24; color: #111;">
                            {{ isset($editingItem) ? 'Update Item' : 'Add Item' }}
                        </button>
                        @if(isset($editingItem))
                            <a href="{{ route('admin.menu') }}" class="button button-secondary">Cancel</a>
                        @endif
                    </div>
                </form>
            </section>

            <section class="admin-table-wrap">
                <h2 style="color: #ffffff; font-family: 'Barlow Condensed', sans-serif; font-size: 2.2rem; font-weight: 800; margin: 0 0 24px;">Current Menu Items</h2>
                
                <div class="menu-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    @forelse($items as $item)
                        <article class="menu-card" style="background: #181818; border: 1px solid #2a2a2a; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                            <div class="menu-card-image-wrap" style="height: 200px; width: 100%; overflow: hidden; background: #222;">
                                @php
                                    $imageUrl = $item->image_path;
                                    if ($imageUrl && !str_starts_with($imageUrl, 'http')) {
                                        $imageUrl = asset('storage/' . $imageUrl);
                                    }
                                @endphp
                                <img src="{{ $imageUrl ?: 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            
                            <div class="menu-card-body" style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-space-between;">
                                <div>
                                    <div class="menu-card-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <h3 style="color: #ffffff; font-family: 'Barlow Condensed', sans-serif; font-size: 1.5rem; margin: 0;">{{ $item->title }}</h3>
                                        <span style="color: #f2a623; font-weight: 700;">₱{{ number_format((float)$item->price, 2) }}</span>
                                    </div>
                                    <p style="color: #cccccc; font-size: 0.88rem; line-height: 1.4; margin: 0 0 16px;">{{ $item->description ?: 'No description provided.' }}</p>
                                </div>

                                <div class="admin-item-actions" style="display: flex; gap: 10px; margin-top: auto;">
                                    <a href="{{ route('admin.menu.edit', $item) }}" class="button button-secondary" style="padding: 4px 16px; min-height: 34px; font-size: 0.85rem;">Edit</a>
                                    <form action="{{ route('admin.menu.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this menu item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button" style="background: #bd2a2a; border-color: #bd2a2a; color: #fff; padding: 4px 16px; min-height: 34px; font-size: 0.85rem;">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="content-empty-state" style="grid-column: span 3; color: #999; text-align: center; padding: 40px; background: #181818; border-radius: 8px; border: 1px dashed #333;">
                            No menu items added yet.
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