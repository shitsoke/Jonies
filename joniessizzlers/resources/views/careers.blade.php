<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Sizzlers + Roast - Careers</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="careers-page-body">
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

            <nav class="main-nav dark-nav" aria-label="Main menu">
                <a href="{{ route('home') }}">HOME</a>
                <a href="{{ route('about') }}">ABOUT</a>
                <a href="{{ route('menu') }}">MENU</a>
                <a href="{{ route('location') }}">LOCATION</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a class="nav-active" href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="careers-reference-page">
            <div class="careers-reference-content">
                <div class="careers-reference-copy">
                    <h1>Join Our Sizzling Team!</h1>

                    @if(session('success'))
                        <div style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #ffffff; padding: 12px 20px; border-radius: 6px; margin-bottom: 24px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div style="background: rgba(189, 42, 42, 0.2); border: 1px solid #bd2a2a; color: #ffffff; padding: 12px 20px; border-radius: 6px; margin-bottom: 24px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="careers-reference-text">
                        <p>At Jonies Sizzlers & Roast, we believe that great food starts with great people. We are always on the lookout for passionate, energetic, and dedicated individuals to join our growing family across Cebu.</p>
                        <p>Whether you thrive in the kitchen or excel at hospitality on the dining floor, we offer competitive pay, career growth opportunities, and a supportive team environment where every day brings something exciting.</p>
                    </div>

                    <div class="careers-apply-info">
                        <h2>HOW TO APPLY:</h2>
                        <p>Fill out our application form below or visit any of our branch locations to submit a walk-in application.</p>
                    </div>

                    <div class="careers-apply-button-wrap">
                        <button type="button" class="careers-apply-button" onclick="document.getElementById('applicationModal').style.display = 'flex';">APPLY NOW</button>
                    </div>
                </div>

                <div class="careers-reference-image">
                    <img src="{{ asset('images/homeImage 1.jpg') }}" alt="Jonies team member cooking flaming dish">
                </div>
            </div>
        </main>

        <!-- Application Form Modal -->
        <div id="applicationModal" style="display: {{ $errors->any() ? 'flex' : 'none' }}; position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(4px); align-items: center; justify-content: center; z-index: 1000; padding: 20px;">
            <div style="background: #181818; border: 1px solid #2a2a2a; border-radius: 12px; padding: 32px; width: 100%; max-width: 500px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                <button type="button" onclick="document.getElementById('applicationModal').style.display = 'none';" style="position: absolute; top: 16px; right: 16px; background: transparent; border: none; color: #ffffff; font-size: 1.5rem; cursor: pointer;">&times;</button>

                <h2 style="color: #f2a623; font-family: 'Barlow Condensed', sans-serif; font-size: 2.2rem; font-weight: 800; margin: 0 0 8px;">Job Application</h2>
                <p style="color: #cccccc; font-size: 0.88rem; margin: 0 0 20px;">Submit your resume to join the Jonies team.</p>

                <form action="{{ route('careers.apply') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 16px;">
                    @csrf
                    
                    <label style="display: flex; flex-direction: column; gap: 6px; text-align: left;">
                        <span style="color: #cccccc; font-size: 0.85rem; font-weight: 600;">Full Name</span>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" required style="background: #222222; border: 1px solid #333333; color: #ffffff; padding: 10px 14px; border-radius: 6px; outline: none;">
                    </label>

                    <label style="display: flex; flex-direction: column; gap: 6px; text-align: left;">
                        <span style="color: #cccccc; font-size: 0.85rem; font-weight: 600;">Email Address</span>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="johndoe@example.com" required style="background: #222222; border: 1px solid #333333; color: #ffffff; padding: 10px 14px; border-radius: 6px; outline: none;">
                    </label>

                    <label style="display: flex; flex-direction: column; gap: 6px; text-align: left;">
                        <span style="color: #cccccc; font-size: 0.85rem; font-weight: 600;">Resume (PDF, DOC, DOCX - Max 5MB)</span>
                        <input type="file" name="resume" accept=".pdf,.doc,.docx" required style="background: #222222; border: 1px solid #333333; color: #ffffff; padding: 8px 14px; border-radius: 6px;">
                    </label>

                    <label style="display: flex; flex-direction: column; gap: 6px; text-align: left;">
                        <span style="color: #cccccc; font-size: 0.85rem; font-weight: 600;">Cover Note / Message (Optional)</span>
                        <textarea name="message" rows="3" placeholder="Tell us briefly about your experience..." style="background: #222222; border: 1px solid #333333; color: #ffffff; padding: 10px 14px; border-radius: 6px; outline: none;">{{ old('message') }}</textarea>
                    </label>

                    <button type="submit" class="button" style="background: #e89a24; border-color: #e89a24; color: #111111; font-weight: 800; padding: 12px; margin-top: 8px; cursor: pointer;">
                        SUBMIT APPLICATION
                    </button>
                </form>
            </div>
        </div>

        <footer class="site-footer">
            <div class="footer-brand">
                <div class="brand-name">JONIES</div>
                <div class="brand-tag">SIZZLERS + ROAST</div>
            </div>
            <nav class="footer-links" aria-label="Footer links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('menu') }}">Menu</a>
                <a href="{{ route('location') }}">Location</a>
                <a href="{{ route('careers') }}">Careers</a>
                <a href="{{ route('contact') }}">Contact</a>
            </nav>
            <span>&copy; {{ date('Y') }} Jonies. All rights reserved.</span>
        </footer>
    </div>
</body>

</html>