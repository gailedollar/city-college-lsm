document.addEventListener('DOMContentLoaded', () => {
    const loginRole = document.getElementById('login-role');
    const loginIdInput = document.querySelector('[data-login-id-input]');
    const loginIdLabel = document.querySelector('[data-login-id-label]');
    const roleLabels = { student: 'Student ID', teacher: 'Employee ID', admin: 'Administrator Email' };

    const updateLoginIdLabel = () => {
        if (!loginRole || !loginIdInput || !loginIdLabel) return;
        const label = roleLabels[loginRole.value] || 'Student ID';
        loginIdInput.placeholder = label;
        loginIdLabel.textContent = label;
        loginIdInput.type = loginRole.value === 'admin' ? 'email' : 'text';
        loginIdInput.autocomplete = loginRole.value === 'admin' ? 'email' : 'username';
    };

    loginRole?.addEventListener('change', updateLoginIdLabel);
    updateLoginIdLabel();

    const passwordToggle = document.querySelector('[data-password-toggle]');
    const passwordInput = document.getElementById('password');

    passwordToggle?.addEventListener('change', () => {
        if (!passwordInput) return;
        passwordInput.type = passwordToggle.checked ? 'text' : 'password';
    });

    const toggle = document.querySelector('[data-menu-toggle]');
    const sidebar = document.querySelector('[data-sidebar]');
    const overlay = document.querySelector('[data-sidebar-overlay]');
    const closeButton = document.querySelector('[data-menu-close]');

    if (!toggle || !sidebar || !overlay) return;

    const closeMenu = (restoreFocus = false) => {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Open navigation');
        if (restoreFocus) toggle.focus();
    };

    toggle.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('is-open');
        overlay.classList.toggle('is-visible', isOpen);
        toggle.setAttribute('aria-expanded', String(isOpen));
        toggle.setAttribute('aria-label', isOpen ? 'Close navigation' : 'Open navigation');
        if (isOpen) closeButton?.focus();
    });

    overlay.addEventListener('click', () => closeMenu());
    closeButton?.addEventListener('click', () => closeMenu(true));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && sidebar.classList.contains('is-open')) closeMenu(true);
    });
});
