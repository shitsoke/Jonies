<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="dark-home-body" style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">
    <div class="page-shell" style="padding: 0; display: flex; justify-content: center; width: 100%;">
        <form method="POST" action="{{ route('admin.login.submit') }}" class="admin-login-box" style="background: #181818; border: 1px solid #2a2a2a; border-radius: 12px; padding: 40px; width: 100%; max-width: 420px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            @csrf
            
            <a href="{{ route('home') }}" style="display: inline-block; margin-bottom: 16px;">
                <img class="admin-logo" src="{{ asset('images/Jonies logo.jpg') }}" alt="Jonies logo" style="width: 70px; height: 70px; border-radius: 8px; object-fit: cover; margin: 0 auto;">
            </a>

            <div style="margin-bottom: 12px;">
                <span class="menu-badge" style="background: #bd2a2a; color: #ffffff; font-family: 'Inter', sans-serif; font-size: 0.75rem; font-weight: 700; padding: 4px 14px; border-radius: 12px; letter-spacing: 0.08em; text-transform: uppercase;">ADMIN</span>
            </div>

            <h1 style="color: #f2a623; font-family: 'Barlow Condensed', sans-serif; font-size: 2.4rem; font-weight: 800; margin: 0 0 24px; line-height: 1;">Enter Password</h1>

            @if ($errors->any())
                <div class="admin-alert error" style="background: rgba(189, 42, 42, 0.2); border: 1px solid #bd2a2a; color: #ffffff; padding: 10px 14px; border-radius: 6px; font-size: 0.88rem; margin-bottom: 20px; text-align: left;">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <label style="display: flex; flex-direction: column; gap: 8px; text-align: left; margin-bottom: 24px;">
                <span style="color: #cccccc; font-size: 0.88rem; font-weight: 600;">Password</span>
                <input type="password" name="password" placeholder="Enter admin password" required autofocus style="background: #222222; border: 1px solid #333333; color: #ffffff; padding: 12px 16px; border-radius: 6px; font-size: 0.95rem; outline: none; transition: border-color 0.2s ease;">
            </label>

            <button type="submit" class="button" style="width: 100%; background: #e89a24; border-color: #e89a24; color: #111111; font-weight: 800; padding: 12px; min-height: 46px; font-size: 1rem; cursor: pointer;">
                LOGIN
            </button>
            
            <div style="margin-top: 20px;">
                <a href="{{ route('home') }}" style="color: #999999; font-size: 0.85rem; text-decoration: none; transition: color 0.2s ease;">&larr; Back to Main Website</a>
            </div>
        </form>
    </div>
</body>

</html>