document.addEventListener('DOMContentLoaded', () => {
    // Current Year for Footer
    const yearEl = document.getElementById('year');
    if (yearEl) yearEl.textContent = new Date().getFullYear();

    // Navbar Scroll Effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    });

    // Mobile Menu Toggle
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');

    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });

        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });
    }

    // Smooth Scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            const target = document.querySelector(targetId);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Hero Image Switcher
    const heroImg = document.getElementById('heroImg');
    const heroImages = [
        'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1555400038-63f5ba517a47?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
    ];
    let currentHeroIdx = 0;

    if (heroImg) {
        heroImg.addEventListener('click', () => {
            currentHeroIdx = (currentHeroIdx + 1) % heroImages.length;
            heroImg.style.opacity = '0';
            setTimeout(() => {
                heroImg.src = heroImages[currentHeroIdx];
                heroImg.style.opacity = '1';
            }, 300);
        });
        heroImg.style.transition = 'opacity 0.3s ease';
    }

    // Tentang Bali Slider
    const sliderWrapper = document.getElementById('baliSlider');
    const dotsContainer = document.getElementById('sliderDots');
    const slides = sliderWrapper ? sliderWrapper.querySelectorAll('img') : [];
    let currentSlide = 0;

    if (sliderWrapper && slides.length > 0) {
        // Create dots
        slides.forEach((_, idx) => {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            if (idx === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(idx));
            dotsContainer.appendChild(dot);
        });

        const dots = dotsContainer.querySelectorAll('.dot');

        const goToSlide = (n) => {
            currentSlide = n;
            sliderWrapper.style.transform = `translateX(-${n * 100}%)`;
            dots.forEach(d => d.classList.remove('active'));
            dots[n].classList.add('active');
        };

        const nextSlide = () => {
            currentSlide = (currentSlide + 1) % slides.length;
            goToSlide(currentSlide);
        };

        // Auto slide setiap 5 detik
        setInterval(nextSlide, 5000);
    }

    // Survei Form Custom Popup
    const surveiForm = document.getElementById('surveiForm');
    const popupOverlay = document.getElementById('popupOverlay');
    const popupMessage = document.getElementById('popupMessage');
    const closePopupBtn = document.getElementById('closePopupBtn');

    if (surveiForm && popupOverlay) {
        surveiForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Mengambil nilai input
            const nama = document.getElementById('nama').value;
            const produk = document.getElementById('produk').value;
            
            // Set pesan HTML
            popupMessage.innerHTML = `Terima kasih, <strong>${nama}</strong>!<br>Survei Anda untuk produk <strong>${produk}</strong> telah berhasil dikirim.`;
            
            // Munculkan popup modal
            popupOverlay.classList.add('active');
            
            // Reset form setelah disubmit
            surveiForm.reset();
        });
    }

    if (closePopupBtn) {
        closePopupBtn.addEventListener('click', () => {
            popupOverlay.classList.remove('active');
        });
    }

    // Tutup popup klik luar
    window.addEventListener('click', (e) => {
        if (e.target === popupOverlay) {
            popupOverlay.classList.remove('active');
        }
    });

    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');
    const body = document.documentElement;
    let isDark = localStorage.getItem('theme') === 'dark';

    const setTheme = (dark) => {
        if (dark) {
            body.setAttribute('data-theme', 'dark');
            if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            localStorage.setItem('theme', 'dark');
        } else {
            body.removeAttribute('data-theme');
            if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            localStorage.setItem('theme', 'light');
        }
    };

    if (isDark) setTheme(true);

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            isDark = !isDark;
            setTheme(isDark);
        });
    }

    // Animasi Scroll Reveal
    const revealElements = document.querySelectorAll('.reveal');
    const revealOnScroll = () => {
        const windowHeight = window.innerHeight;
        const revealPoint = 100;
        revealElements.forEach(el => {
            const revealTop = el.getBoundingClientRect().top;
            if (revealTop < windowHeight - revealPoint) {
                el.classList.add('active');
            }
        });
    };

    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll(); 
});
