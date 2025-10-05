document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mobileOverlay = document.querySelector('.mobile-overlay');
    const body = document.body;

    if (sidebarToggle) {
        const handleSidebarToggle = () => {
            body.classList.toggle('sidebar-hidden');
            if (window.innerWidth > 992) {
                localStorage.setItem('sidebar-hidden', body.classList.contains('sidebar-hidden'));
            }
        };

        sidebarToggle.addEventListener('click', handleSidebarToggle);
        
        if(mobileOverlay) {
            mobileOverlay.addEventListener('click', handleSidebarToggle);
        }

        if (window.innerWidth <= 992) {
            body.classList.add('sidebar-hidden');
        } else {
            if (localStorage.getItem('sidebar-hidden') === 'true') {
                body.classList.add('sidebar-hidden');
            }
        }
    }

    const themeSwitch = document.getElementById('checkbox');
    const modeText = document.getElementById('theme-mode-text');
    
    if (themeSwitch && body) { 
        const enableDarkMode = () => {
            body.classList.add('dark-mode');
            localStorage.setItem('theme', 'dark');
            themeSwitch.checked = true;
            if(modeText) modeText.textContent = 'Dark Mode';
        };

        const disableDarkMode = () => {
            body.classList.remove('dark-mode');
            localStorage.setItem('theme', 'light');
            themeSwitch.checked = false;
            if(modeText) modeText.textContent = 'Light Mode';
        };

        if (localStorage.getItem('theme') === 'dark') {
            enableDarkMode();
        }

        themeSwitch.addEventListener('change', () => {
            if (themeSwitch.checked) {
                enableDarkMode();
            } else {
                disableDarkMode();
            }
        });
    }

    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');

    if (passwordInput && togglePasswordButton) {
        const eyeIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>`;
        const eyeSlashIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/></svg>`;

        togglePasswordButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = (type === 'text') ? eyeSlashIcon : eyeIcon;
        });
    }
});
