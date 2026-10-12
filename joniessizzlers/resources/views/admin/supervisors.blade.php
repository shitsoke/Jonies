<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Admin - Manage Supervisors</title>
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

        <main class="admin-main-section" style="padding: 40px 0;">
            @if(session('success'))
                <div class="admin-alert success" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #ffffff; padding: 12px 20px; border-radius: 6px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            <section class="admin-panel" style="background: #181818; border: 1px solid #2a2a2a; border-radius: 8px; padding: 28px; margin-bottom: 40px;">
                <h2 style="color: #f2a623; font-family: 'Barlow Condensed', sans-serif; font-size: 2.2rem; font-weight: 800; margin: 0 0 20px;">
                    {{ isset($editingSupervisor) ? 'Edit Supervisor' : 'Add Supervisor' }}
                </h2>

                <form action="{{ isset($editingSupervisor) ? route('admin.supervisors.update', $editingSupervisor) : route('admin.supervisors.store') }}" method="POST" class="admin-form">
                    @csrf
                    @if(isset($editingSupervisor))
                        @method('PUT')
                    @endif

                    <div class="form-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Full Name</span>
                            <input type="text" name="name" value="{{ old('name', $editingSupervisor->name ?? '') }}" required style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Email Address</span>
                            <input type="email" name="email" value="{{ old('email', $editingSupervisor->email ?? '') }}" required style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Password{{ isset($editingSupervisor) ? ' (leave blank to keep current)' : '' }}</span>
                            <input type="password" name="password" autocomplete="new-password" style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>
                        <label style="display: flex; flex-direction: column; gap: 8px;">
                            <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Confirm Password</span>
                            <input type="password" name="password_confirmation" autocomplete="new-password" style="background: #222; border: 1px solid #333; color: #fff; padding: 10px 14px; border-radius: 6px; outline: none;">
                        </label>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <span style="display: block; color: #cccccc; font-size: 0.88rem; font-weight: 600; margin-bottom: 10px;">Assigned Branches</span>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px;">
                            @foreach($branches as $branch)
                                <label style="display: flex; align-items: center; gap: 8px; background: #222; border: 1px solid #333; border-radius: 6px; padding: 10px 12px; color: #fff;">
                                    <input type="checkbox" name="branch_ids[]" value="{{ $branch->id }}" {{ isset($editingSupervisor) && $editingSupervisor->branches->contains($branch->id) ? 'checked' : '' }}>
                                    <span>{{ $branch->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; color: #cccccc; font-size: 0.9rem;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $editingSupervisor->is_active ?? true) ? 'checked' : '' }}>
                        Active account
                    </label>

                    <div class="admin-actions" style="display: flex; gap: 12px; align-items: center;">
                        <button type="submit" class="button" style="background: #e89a24; border-color: #e89a24; color: #111;">{{ isset($editingSupervisor) ? 'Update Supervisor' : 'Add Supervisor' }}</button>
                        @if(isset($editingSupervisor))
                            <a href="{{ route('admin.supervisors') }}" class="button button-secondary">Cancel</a>
                        @endif
                    </div>
                </form>
            </section>

            <section class="supervisor-list-panel">
                <div class="supervisor-list-heading">
                    <div>
                        <span class="section-kicker">ACCOUNT DIRECTORY</span>
                        <h2>All Supervisors</h2>
                    </div>
                    <span class="supervisor-list-count">{{ $supervisors->count() }} {{ \Illuminate\Support\Str::plural('supervisor', $supervisors->count()) }}</span>
                </div>

                <form method="GET" action="{{ route('admin.supervisors') }}" class="supervisor-filter-form">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search by name or email" aria-label="Search supervisors by name or email">
                    <select name="branch_id" aria-label="Filter supervisors by branch">
                        <option value="">All branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ ($branchId ?? '') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    <select name="status" aria-label="Filter supervisors by status">
                        <option value="">All statuses</option>
                        <option value="1" {{ ($status ?? '') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ ($status ?? '') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <div class="supervisor-filter-actions">
                        <button type="submit" class="button">Apply Filters</button>
                        @if(filled($search ?? null) || filled($branchId ?? null) || filled($status ?? null))
                            <a href="{{ route('admin.supervisors') }}">Clear filters</a>
                        @endif
                    </div>
                </form>

                <div class="supervisor-table-scroll">
                    <table class="admin-supervisors-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Assigned Branches</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supervisors as $supervisor)
                                <tr>
                                    <td class="supervisor-name">{{ $supervisor->name }}</td>
                                    <td class="supervisor-email">{{ $supervisor->email }}</td>
                                    <td class="supervisor-branches-cell">
                                        <div class="supervisor-branch-list">
                                        @forelse($supervisor->branches as $branch)
                                            <span class="branch-pill">{{ $branch->name }}</span>
                                        @empty
                                            <span class="no-branch-assigned">No branch assigned</span>
                                        @endforelse
                                        </div>
                                    </td>
                                    <td><span class="status-badge status-{{ $supervisor->is_active ? 'confirmed' : 'declined' }}">{{ $supervisor->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    <td class="supervisor-actions-cell">
                                        <div class="supervisor-row-actions">
                                        <a href="{{ route('admin.supervisors.edit', $supervisor) }}" class="button button-secondary">Edit</a>
                                        <form method="POST" action="{{ route('admin.supervisors.toggle', $supervisor) }}">
                                            @csrf
                                            <button type="submit" class="button">{{ $supervisor->is_active ? 'Deactivate' : 'Activate' }}</button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #bbbbbb;">No supervisors found.</td>
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
