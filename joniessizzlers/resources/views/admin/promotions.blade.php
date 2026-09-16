<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Promotions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-menu-page">
    <div class="admin-menu-shell">
        <header class="admin-menu-header">
            <div class="admin-heading">
                <img class="admin-logo" src="{{ asset('images/Jonies logo.jpg') }}" alt="Jonies logo">
                <div>
                    <span class="menu-badge">ADMIN</span>
                    <h1>Promotions</h1>
                </div>
            </div>
            <div class="admin-top-actions">
                <a class="back-link" href="{{ route('admin.menu') }}">Manage Menu</a>
                <a class="back-link" href="{{ route('admin.content') }}">Website Content</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="secondary-btn">Logout</button>
                </form>
            </div>
        </header>

        @if(session('success'))
            <div class="admin-alert success">{{ session('success') }}</div>
        @endif

        <section class="admin-panel">
            <h2>{{ $editingPromotion ? 'Edit Promotion' : 'Add New Promotion' }}</h2>
            <form action="{{ $editingPromotion ? route('admin.promotions.update', $editingPromotion) : route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @if($editingPromotion)
                    @method('PUT')
                @endif
                <div class="form-grid promotion-form-grid">
                    <label>
                        <span>Promotion Title</span>
                        <input type="text" name="title" value="{{ old('title', $editingPromotion->title ?? '') }}" required>
                    </label>
                    <label>
                        <span>Promotion Picture{{ $editingPromotion ? ' (optional)' : '' }}</span>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" {{ $editingPromotion ? '' : 'required' }}>
                    </label>
                </div>
                <label>
                    <span>Description</span>
                    <textarea name="description" rows="4">{{ old('description', $editingPromotion->description ?? '') }}</textarea>
                </label>
                @if($editingPromotion)
                    <div class="promotion-current-image">
                        <span>Current picture</span>
                        <img src="{{ asset('storage/' . $editingPromotion->image_path) }}" alt="{{ $editingPromotion->title }}">
                    </div>
                @endif
                <div class="admin-actions">
                    <button type="submit" class="primary-btn">{{ $editingPromotion ? 'Update Promotion' : 'Add Promotion' }}</button>
                    @if($editingPromotion)
                        <a href="{{ route('admin.promotions') }}" class="secondary-btn">Cancel</a>
                    @endif
                </div>
            </form>
        </section>

        <section class="admin-table-wrap">
            <h2>Homepage Promotions</h2>
            <div class="admin-item-grid">
                @forelse($promotions as $promotion)
                    <article class="admin-item-card">
                        <img src="{{ asset('storage/' . $promotion->image_path) }}" alt="{{ $promotion->title }}">
                        <div class="admin-item-body">
                            <h3>{{ $promotion->title }}</h3>
                            <p>{{ $promotion->description ?: 'No description provided.' }}</p>
                            <div class="admin-item-actions">
                                <a href="{{ route('admin.promotions.edit', $promotion) }}" class="secondary-btn">Edit</a>
                                <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" onsubmit="return confirm('Delete this promotion?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="danger-btn">Delete</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="content-empty-state">No promotions yet. Add the first homepage promotion above.</div>
                @endforelse
            </div>
        </section>
    </div>
</body>

</html>