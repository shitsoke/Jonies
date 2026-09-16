import 'bootstrap';
import '../css/app.css';

const navToggles = document.querySelectorAll('.nav-toggle');

navToggles.forEach((button) => {
    const header = button.closest('.site-header');
    const nav = header ? header.querySelector('.main-nav') : null;

    if (!nav) return;

    button.addEventListener('click', () => {
        const isOpen = nav.classList.toggle('is-open');
        button.setAttribute('aria-expanded', String(isOpen));
    });

    nav.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            nav.classList.remove('is-open');
            button.setAttribute('aria-expanded', 'false');
        });
    });
});
