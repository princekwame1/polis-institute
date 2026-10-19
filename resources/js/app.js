const hidePreloader = () => {
    const preloader = document.getElementById('preloader');

    if (!preloader) {
        return;
    }

    preloader.classList.add('is-hidden');
    setTimeout(() => preloader.remove(), 600);
};

window.addEventListener('load', () => setTimeout(hidePreloader, 300));
// Safety net in case a slow asset holds up the load event.
setTimeout(hidePreloader, 4000);

document.addEventListener('DOMContentLoaded', () => {
    initMobileNav();
    initHeaderShadow();
    initHeroSlider();
    initReveal();
    initAdminSidebar();
    initImagePreviews();
    initPasswordToggles();
    initRichTextEditors();
    initShareButtons();
});

function initMobileNav() {
    const toggle = document.querySelector('[data-nav-toggle]');
    const menu = document.querySelector('[data-nav-menu]');

    if (!toggle || !menu) {
        return;
    }

    toggle.addEventListener('click', () => {
        const isOpen = toggle.getAttribute('aria-expanded') === 'true';

        toggle.setAttribute('aria-expanded', String(!isOpen));
        menu.classList.toggle('hidden', isOpen);
        toggle.querySelector('[data-icon-open]').classList.toggle('hidden', !isOpen);
        toggle.querySelector('[data-icon-close]').classList.toggle('hidden', isOpen);
    });
}

function initHeaderShadow() {
    const header = document.querySelector('[data-site-header]');

    if (!header) {
        return;
    }

    let isScrolled = null;

    const update = () => {
        const scrolled = window.scrollY > 10;

        if (scrolled !== isScrolled) {
            isScrolled = scrolled;
            header.classList.toggle('shadow-md', scrolled);
        }
    };

    update();
    window.addEventListener('scroll', update, { passive: true });
}

function initHeroSlider() {
    const slider = document.querySelector('[data-hero-slider]');

    if (!slider) {
        return;
    }

    const slides = [...slider.querySelectorAll('.hero-slide')];
    const dots = [...slider.querySelectorAll('[data-slide-to]')];
    let current = 0;
    let timer;

    const show = (index) => {
        current = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            slide.classList.toggle('is-active', i === current);
            slide.setAttribute('aria-hidden', String(i !== current));
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('w-10', i === current);
            dot.classList.toggle('bg-white', i === current);
            dot.classList.toggle('w-3', i !== current);
            dot.classList.toggle('bg-white/40', i !== current);
            dot.setAttribute('aria-current', String(i === current));
        });
    };

    const restart = () => {
        clearInterval(timer);
        timer = setInterval(() => show(current + 1), 7000);
    };

    dots.forEach((dot) => dot.addEventListener('click', () => {
        show(Number(dot.dataset.slideTo));
        restart();
    }));

    slider.querySelector('[data-slide-prev]')?.addEventListener('click', () => {
        show(current - 1);
        restart();
    });

    slider.querySelector('[data-slide-next]')?.addEventListener('click', () => {
        show(current + 1);
        restart();
    });

    slider.addEventListener('mouseenter', () => clearInterval(timer));
    slider.addEventListener('mouseleave', restart);

    show(0);
    restart();
}

function initReveal() {
    const items = document.querySelectorAll('.reveal');

    if (!('IntersectionObserver' in window)) {
        return;
    }

    document.documentElement.classList.add('js-reveal');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    items.forEach((item) => observer.observe(item));
}

function initAdminSidebar() {
    const sidebar = document.querySelector('[data-admin-sidebar]');
    const overlay = document.querySelector('[data-admin-overlay]');
    const toggle = document.querySelector('[data-admin-sidebar-toggle]');

    if (!sidebar || !toggle) {
        return;
    }

    const setOpen = (isOpen) => {
        sidebar.classList.toggle('-translate-x-full', !isOpen);
        overlay?.classList.toggle('hidden', !isOpen);
    };

    toggle.addEventListener('click', () => setOpen(true));
    overlay?.addEventListener('click', () => setOpen(false));
}

function initImagePreviews() {
    document.querySelectorAll('[data-image-input]').forEach((input) => {
        const name = input.dataset.imageInput;
        const preview = document.querySelector(`[data-image-preview="${name}"]`);
        const placeholder = document.querySelector(`[data-image-placeholder="${name}"]`);

        input.addEventListener('change', () => {
            const [file] = input.files;

            if (!file || !preview) {
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            placeholder?.classList.add('hidden');
        });
    });
}

function initPasswordToggles() {
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        const input = document.getElementById(button.dataset.passwordToggle);

        if (!input) {
            return;
        }

        button.addEventListener('click', () => {
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';
            button.setAttribute('aria-pressed', String(isHidden));
            button.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            button.classList.toggle('text-brand-700', isHidden);
        });
    });
}

function initRichTextEditors() {
    const textareas = document.querySelectorAll('textarea[data-rich-text]');

    if (textareas.length === 0) {
        return;
    }

    import('./rich-text.js').then(({ default: mountRichTextEditor }) => textareas.forEach(mountRichTextEditor));
}

function initShareButtons() {
    document.querySelectorAll('[data-copy-link]').forEach((button) => {
        const status = button.parentElement.querySelector('[data-copy-link-status]');

        button.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(button.dataset.copyLink);
                status.textContent = 'Link copied';
            } catch {
                status.textContent = 'Could not copy the link';
            }

            setTimeout(() => (status.textContent = ''), 2500);
        });
    });

    if (!navigator.share) {
        return;
    }

    document.querySelectorAll('[data-native-share]').forEach((button) => {
        button.classList.replace('hidden', 'grid');
        button.addEventListener('click', () => {
            navigator.share({ title: button.dataset.shareTitle, url: button.dataset.shareUrl }).catch(() => {});
        });
    });
}
