<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Careers</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="careers-page-body">
    <div class="careers-shell">
        <header class="site-header">
            <div class="brand-wrap" aria-label="Jonies home">
                <img class="brand-mark" src="{{ asset('images/Jonies logo.jpg') }}" alt="Jonies logo">
                <div class="brand-copy">
                    <span class="brand-name">JONIES</span>
                    <span class="brand-tag">SIZZLERS + ROAST</span>
                </div>
            </div>

            <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="main-nav" aria-label="Main menu">
                <a href="{{ route('home') }}">HOME</a>
                <a href="{{ route('about') }}">ABOUT</a>
                <a href="{{ route('menu') }}">MENU</a>
                <a href="{{ route('location') }}">LOCATION</a>
                <a href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}" class="nav-active">CAREERS</a>
            </nav>
        </header>

        <main class="careers-section">
            <div class="careers-copy">
                <h1>
                    {{ $pageContent->get('main_title')?->value ?? 'JOIN THE JONIES SIZZLERS' }}<br>
                    {{ $pageContent->get('subtitle')?->value ?? '& ROAST TEAM' }}
                </h1>

                <p class="careers-intro">
                    {{ $pageContent->get('intro')?->value ?? 'At Jonies, our secret ingredient isn\'t just our recipe—it\'s our people. We pride ourselves on a customer-oriented, high-energy environment where every team member greets our guests with a genuine smile.' }}
                </p>

                <p class="careers-body">
                    {{ $pageContent->get('body')?->value ?? 'We are constantly looking for passionate talent to join our growing kitchen crew, service staff, and branch management teams. If your local food and thrive in a fast-paced environment, we want to meet you.' }}
                </p>

                <div class="apply-block">
                    <h2>HOW TO APPLY:</h2>
                    <p>
                        Send your updated resume and cover letter to recruitment.crgi@gmail.com
                        with the subject line <strong>"Application: [Name] - [Position]"</strong>, or drop off your
                        application directly at any of our branches.
                    </p>
                </div>

                <form method="POST" action="{{ route('careers.apply') }}" enctype="multipart/form-data" class="application-form">
                    @csrf

                    <div class="form-row">
                        <label for="name">Full Name</label>
                        <input id="name" name="name" type="text" required>
                    </div>

                    <div class="form-row">
                        <label for="email">Email Address</label>
                        <input id="email" name="email" type="email" required>
                    </div>

                    <div class="form-row">
                        <label for="resume">Upload Resume</label>
                        <input id="resume" name="resume" type="file" accept=".pdf,.doc,.docx" required>
                    </div>

                    <div class="form-row">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="4" placeholder="Tell us a bit about yourself..."></textarea>
                    </div>

                    <button type="submit" class="apply-btn">SEND AN APPLICATION</button>
                </form>
            </div>

            <div class="careers-photo-wrap" aria-label="Jonies team photo">
                <img src="{{ asset('images/Career Image 1.png') }}" alt="Jonies team photo">
            </div>
        </main>
    </div>
</body>

</html>
