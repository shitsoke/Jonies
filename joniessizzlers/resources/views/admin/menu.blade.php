<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Menu</title>
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
                <h1>Manage Menu</h1>
                </div>
            </div>
            <div class="admin-top-actions">
                <a class="back-link" href="{{ route('menu') }}">View Menu</a>
                <a class="back-link" href="{{ route('admin.promotions') }}">Promotions</a>
                <a class="back-link" href="{{ route('admin.content') }}">Website Content</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="secondary-btn">Logout</button>
                </form>
            </div>
        </header>

        @if(session('success'))
            <div class="admin-alert success">
                {{ session('success') }}
            </div>
        @endif

        <section class="admin-panel">
            <h2>{{ $editingItem ? 'Edit Menu Item' : 'Add New Menu Item' }}</h2>

            <form action="{{ $editingItem ? route('admin.menu.update', $editingItem) : route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @if($editingItem)
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <label>
                        <span>Title</span>
                        <input type="text" name="title" value="{{ old('title', $editingItem->title ?? '') }}" required>
                    </label>

                    <label>
                        <span>Category</span>
                        <select name="category" required>
                            @foreach(['all-time-favorites' => 'All time favorites', 'house-of-specialties' => 'House of Specialties', 'seafoods' => 'Seafoods', 'dessert' => 'Dessert', 'shareable-flaming-bundles' => 'Shareable Flaming Bundles'] as $key => $value)
                                <option value="{{ $key }}" {{ old('category', $editingItem->category ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        <span>Price</span>
                        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $editingItem->price ?? '') }}" required>
                    </label>

                    <label>
                        <span>Image</span>
                        <input type="file" name="image" accept="image/*">
                    </label>
                </div>

                <label>
                    <span>Description</span>
                    <textarea name="description" rows="4">{{ old('description', $editingItem->description ?? '') }}</textarea>
                </label>

                <div class="admin-actions">
                    <button type="submit" class="primary-btn">{{ $editingItem ? 'Update Item' : 'Add Item' }}</button>
                    @if($editingItem)
                        <a href="{{ route('admin.menu') }}" class="secondary-btn">Cancel</a>
                    @endif
                </div>
            </form>
        </section>

        <section class="admin-table-wrap">
            <h2>Current Menu Items</h2>

            <div class="admin-item-grid">
                @foreach($items as $item)
                    <div class="admin-item-card">
                        <img src="{{ $item->image_path && !str_starts_with($item->image_path, 'http') ? asset('storage/' . $item->image_path) : ($item->image_path ?: 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=900&q=80') }}" alt="{{ $item->title }}">
                        <div class="admin-item-body">
                            <h3>{{ $item->title }}</h3>
                            <p class="admin-meta">{{ ucfirst(str_replace('-', ' ', $item->category)) }} • ₱{{ number_format((float) $item->price, 2) }}</p>
                            <p>{{ $item->description ?: 'No description provided.' }}</p>
                            <div class="admin-item-actions">
                                <a href="{{ route('admin.menu.edit', $item) }}" class="secondary-btn">Edit</a>
                                <form action="{{ route('admin.menu.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this menu item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="danger-btn">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</body>

</html>
