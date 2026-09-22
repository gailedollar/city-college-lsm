document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-menu-toggle]');
    const sidebar = document.querySelector('[data-sidebar]');
    const overlay = document.querySelector('[data-sidebar-overlay]');

    if (!toggle || !sidebar || !overlay) return;

    const closeMenu = () => {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('is-open');
        overlay.classList.toggle('is-visible', isOpen);
        toggle.setAttribute('aria-expanded', String(isOpen));
    });

    overlay.addEventListener('click', closeMenu);
});
