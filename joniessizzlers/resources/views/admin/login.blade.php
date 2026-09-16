<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-login-page">
    <div class="admin-login-shell">
        <form method="POST" action="{{ route('admin.login.submit') }}" class="admin-login-box">
            @csrf
            <img class="admin-logo" src="{{ asset('images/Jonies logo.jpg') }}" alt="Jonies logo">
            <span class="menu-badge">ADMIN</span>
            <h1>Enter Password</h1>

            @if ($errors->any())
                <div class="admin-alert error">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <label>
                <span>Password</span>
                <input type="password" name="password" placeholder="Enter admin password" required>
            </label>

            <button type="submit" class="primary-btn">Login</button>
        </form>
    </div>
</body>

</html>
