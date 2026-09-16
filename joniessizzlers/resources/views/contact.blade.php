<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JONIES | Get in Touch</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="contact-page-body">
    <div class="contact-shell">
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
                <a href="{{ route('contact') }}" class="nav-active">GET IN TOUCH</a>
                <a href="{{ route('careers') }}">CAREERS</a>
            </nav>
        </header>

        <main class="contact-layout">
            <section class="contact-details-panel">
                <h1>CONNECT WITH US</h1>

                <p class="contact-intro">
                    Got a question, hosting a large family gathering, or want to partner with us? We would love to hear from you. Fill out our contact form or reach us through our official channels.
                </p>

                <div class="contact-info-list">
                    <div class="contact-row">
                        <div class="contact-icon">☎</div>
                        <span>0939 972 3564</span>
                    </div>

                    <div class="contact-row">
                        <div class="contact-icon facebook-icon">f</div>
                        <span>https://www.facebook.com/JoniesOfficial</span>
                    </div>

                    <div class="contact-row">
                        <div class="contact-icon">✉</div>
                        <span>marketingjonies@gmail.com<br>marketingassistant@gmail.com</span>
                    </div>
                </div>
            </section>

            <section class="contact-form-panel">
                <form class="contact-form">
                    <div class="field-wrap">
                        <input type="text" placeholder="Name" aria-label="Name">
                    </div>
                    <div class="field-wrap">
                        <input type="email" placeholder="Email" aria-label="Email">
                    </div>
                    <div class="field-wrap">
                        <textarea placeholder="Message" aria-label="Message" rows="8"></textarea>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>

</html>
