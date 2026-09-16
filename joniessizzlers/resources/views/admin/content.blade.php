<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Content</title>
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
                <h1>Website Content</h1>
                </div>
            </div>
            <div class="admin-top-actions">
                <a class="back-link" href="{{ route('admin.menu') }}">Manage Menu</a>
                <a class="back-link" href="{{ route('admin.promotions') }}">Promotions</a>
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

        <form method="POST" action="{{ route('admin.content.save') }}" class="content-form">
            @csrf

            @foreach($pages as $slug => $label)
                <section class="admin-panel content-panel">
                    <h2>{{ $label }}</h2>

                    @php $entries = $content[$slug] ?? collect(); @endphp
                    @if($entries->isEmpty())
                        <div class="content-empty-state">
                            <p>No content entries yet for this page.</p>
                        </div>
                    @endif

                    @foreach($entries as $entry)
                        <div class="content-row">
                            <label>
                                <span>Field Label</span>
                                <input type="text" name="content[{{ $slug }}][{{ $entry->key }}][label]" value="{{ old('content.' . $slug . '.' . $entry->key . '.label', $entry->label) }}">
                            </label>

                            <label>
                                <span>Value</span>
                                <textarea name="content[{{ $slug }}][{{ $entry->key }}][value]" rows="3">{{ old('content.' . $slug . '.' . $entry->key . '.value', $entry->value) }}</textarea>
                            </label>

                            <input type="hidden" name="content[{{ $slug }}][{{ $entry->key }}][sort_order]" value="{{ $entry->sort_order }}">
                        </div>
                    @endforeach

                    @if($entries->isEmpty())
                        <div class="content-row">
                            <label>
                                <span>Field Label</span>
                                <input type="text" name="content[{{ $slug }}][main_title][label]" value="Main Title">
                            </label>

                            <label>
                                <span>Value</span>
                                <textarea name="content[{{ $slug }}][main_title][value]" rows="3">Welcome to Jonies</textarea>
                            </label>

                            <input type="hidden" name="content[{{ $slug }}][main_title][sort_order]" value="0">
                        </div>
                    @endif
                </section>
            @endforeach

            <div class="admin-actions">
                <button type="submit" class="primary-btn">Save Changes</button>
            </div>
        </form>
    </div>
</body>

</html>
