<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Admin - Manage Branches</title>
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
                <a class="{{ request()->routeIs('admin.branches*') ? 'nav-active' : '' }}" href="{{ route('admin.branches') }}">MANAGE BRANCHES</a>
                <a class="{{ request()->routeIs('admin.supervisors*') ? 'nav-active' : '' }}" href="{{ route('admin.supervisors') }}">MANAGE SUPERVISORS</a>
                <a class="{{ request()->routeIs('admin.reservations*') ? 'nav-active' : '' }}" href="{{ route('admin.reservations') }}">MANAGE RESERVATIONS</a>
                <a href="{{ route('home') }}" target="_blank">VIEW SITE</a>
                <form method="POST" action="{{ route('admin.logout') }}" style="display: inline-flex; align-items: center;">
                    @csrf
                    <button type="submit" class="button" style="background: transparent; border: 1px solid #e89a24; color: #e89a24; padding: 6px 18px; min-height: 38px; font-size: 0.9rem; font-weight: 700; cursor: pointer; border-radius: 4px; margin-left: 10px; transition: all 0.2s ease;">LOGOUT</button>
                </form>
            </nav>
        </header>

        <main class="admin-main-section branch-management-page" style="padding: 40px 0;">
            @if(session('success'))
                <div class="admin-alert success" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #ffffff; padding: 12px 20px; border-radius: 6px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            <section class="admin-panel" style="background: #181818; border: 1px solid #2a2a2a; border-radius: 8px; padding: 28px; margin-bottom: 40px;">
                <h2 style="color: #f2a623; font-family: 'Barlow Condensed', sans-serif; font-size: 2.2rem; font-weight: 800; margin: 0 0 20px;">
                    {{ isset($editingBranch) ? 'Edit Branch' : 'Add Branch' }}
                </h2>

                <form action="{{ isset($editingBranch) ? route('admin.branches.update', $editingBranch) : route('admin.branches.store') }}" method="POST" class="admin-form">
                    @csrf
                    @if(isset($editingBranch))
                        @method('PUT')
                    @endif

                    <div class="form-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Branch Name</span>
                            <input type="text" name="name" value="{{ old('name', $editingBranch->name ?? '') }}" required style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Capacity</span>
                            <input type="number" name="capacity" min="1" value="{{ old('capacity', $editingBranch->capacity ?? '') }}" required style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Address</span>
                            <input type="text" name="address" value="{{ old('address', $editingBranch->address ?? '') }}" style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Contact Number</span>
                            <input type="text" name="contact_number" value="{{ old('contact_number', $editingBranch->contact_number ?? '') }}" style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>
                    </div>

                    <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; color: #cccccc; font-size: 0.9rem;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $editingBranch->is_active ?? true) ? 'checked' : '' }}>
                        Active branch
                    </label>

                    <div class="admin-actions" style="display: flex; gap: 12px; align-items: center;">
                        <button type="submit" class="button" style="background: #e89a24; border-color: #e89a24; color: #111;">{{ isset($editingBranch) ? 'Update Branch' : 'Add Branch' }}</button>
                        @if(isset($editingBranch))
                            <a href="{{ route('admin.branches') }}" class="button button-secondary">Cancel</a>
                        @endif
                    </div>
                </form>
            </section>

            <section class="branch-list-panel">
                <div class="branch-list-heading">
                    <div>
                        <span class="section-kicker">BRANCH DIRECTORY</span>
                        <h2>All Branches</h2>
                    </div>
                    <span class="branch-list-count">{{ $branches->count() }} {{ \Illuminate\Support\Str::plural('branch', $branches->count()) }}</span>
                </div>

                <form method="GET" action="{{ route('admin.branches') }}" class="branches-filter-form">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search branches" aria-label="Search branches">
                    <select name="status" aria-label="Filter branches by status">
                        <option value="">All statuses</option>
                        <option value="1" {{ ($status ?? '') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ ($status ?? '') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <button type="submit" class="button">Filter</button>
                </form>

                <div class="branch-table-scroll">
                    <table class="branches-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branches as $branch)
                                <tr>
                                    <td>{{ $branch->name }}</td>
                                    <td>{{ $branch->address ?: 'Not provided' }}</td>
                                    <td>{{ $branch->contact_number ?: 'Not provided' }}</td>
                                    <td>{{ $branch->capacity ?: 'Not set' }}</td>
                                    <td><span class="status-badge status-{{ $branch->is_active ? 'confirmed' : 'declined' }}">{{ $branch->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    <td class="branch-actions-cell">
                                        <div class="branch-actions">
                                        <a href="{{ route('admin.branches.edit', $branch) }}" class="button button-secondary">Edit</a>
                                        <form method="POST" action="{{ route('admin.branches.toggle', $branch) }}">
                                            @csrf
                                            <button type="submit" class="button">{{ $branch->is_active ? 'Deactivate' : 'Activate' }}</button>
                                        </form>
                                        <a href="{{ route('admin.reservations', ['branch_id' => $branch->id]) }}" class="button button-secondary">Reservations</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #bbbbbb;">No branches found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
