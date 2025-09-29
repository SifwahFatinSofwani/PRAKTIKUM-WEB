document.addEventListener('DOMContentLoaded', () => {
    const themeSwitch = document.getElementById('checkbox');
    const body = document.body;
    const modeText = document.getElementById('theme-mode-text');

    const enableDarkMode = () => {
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
        themeSwitch.checked = true;
        modeText.textContent = 'Dark Mode';
    };

    const disableDarkMode = () => {
        body.classList.remove('dark-mode');
        localStorage.setItem('theme', 'light');
        themeSwitch.checked = false;
        modeText.textContent = 'Light Mode';
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

    const navLinks = document.querySelectorAll('.nav-links a');
    const sections = document.querySelectorAll('section[id]');

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    const changeNavOnScroll = () => {
        let currentSection = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (pageYOffset >= (sectionTop - sectionHeight / 3)) {
                currentSection = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').substring(1) === currentSection) {
                link.classList.add('active');
            }
        });
    };

    window.addEventListener('scroll', changeNavOnScroll);
});
