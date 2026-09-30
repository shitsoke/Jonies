<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Sizzlers + Roast - Get in Touch</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="contact-page-body">
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
                <a class="nav-active" href="{{ route('contact') }}">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="contact-reference-page">
            <div class="contact-reference-content">
                <div class="contact-reference-details">
                    <h1>Sizzling Service is Just a Message Away</h1>
                    <p class="contact-reference-intro">
                        Have a question about our menu, need to book a group reservation, or want to share feedback about your recent visit? Drop us a line below or reach out directly to our team.
                    </p>

                    <div class="contact-reference-info">
                        <div class="contact-reference-row">
                            <div class="contact-reference-icon phone-icon">&#9742;</div>
                            <div class="contact-reference-value">
                                <span>(032) 231-1234</span>
                                <span>+63 917 123 4567</span>
                            </div>
                        </div>

                        <div class="contact-reference-row">
                            <div class="contact-reference-icon facebook-icon">f</div>
                            <div class="contact-reference-value">
                                <span>facebook.com/JoniesSizzlersRoast</span>
                            </div>
                        </div>

                        <div class="contact-reference-row">
                            <div class="contact-reference-icon email-icon">&#9993;</div>
                            <div class="contact-reference-value">
                                <span>customercare@jonies.ph</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-reference-form">
                    <form action="#" method="POST" class="contact-reference-form-inner">
                        @csrf
                        <div class="contact-field">
                            <input type="text" name="name" placeholder="Full Name" required>
                        </div>
                        <div class="contact-field">
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="contact-field">
                            <input type="text" name="subject" placeholder="Subject">
                        </div>
                        <div class="contact-field">
                            <textarea name="message" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="contact-submit-button">SEND MESSAGE</button>
                    </form>
                </div>
            </div>
        </main>

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