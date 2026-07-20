</main>
<!-- PAGE CONTENT ENDS HERE -->

<!-- FOOTER -->
<footer class="footer" id="footer">
    <div class="container">
        <div class="row g-4">

            <!-- Column 1 - Logo & About -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand">
                    <a href="<?= SITE_URL ?>/?page=home" class="footer-logo">
                        <span class="logo-text"><?= SITE_NAME ?></span>
                        <span class="logo-dot">.</span>
                    </a>
                    <p class="footer-about mt-3">
                        We are a professional architecture, construction and real estate firm 
                        delivering world-class designs and quality builds across Nigeria and beyond.
                    </p>
                    <!-- Social Media Icons -->
                    <div class="footer-socials mt-3">
                        <a href="#" class="social-link" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link" title="Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-link" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>" class="social-link" title="WhatsApp" target="_blank">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Column 2 - Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h5 class="footer-heading">Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="<?= SITE_URL ?>/?page=home"><i class="bi bi-chevron-right"></i>Home</a></li>
                    <li><a href="<?= SITE_URL ?>/?page=about"><i class="bi bi-chevron-right"></i>About</a></li>
                    <li><a href="<?= SITE_URL ?>/?page=projects"><i class="bi bi-chevron-right"></i>Projects</a></li>
                    <li><a href="<?= SITE_URL ?>/?page=properties"><i class="bi bi-chevron-right"></i>Properties</a></li>
                    <li><a href="<?= SITE_URL ?>/?page=designs"><i class="bi bi-chevron-right"></i>Designs</a></li>
                    <li><a href="<?= SITE_URL ?>/?page=interiors"><i class="bi bi-chevron-right"></i>Interiors</a></li>
                    <li><a href="<?= SITE_URL ?>/?page=contact"><i class="bi bi-chevron-right"></i>Contact</a></li>
                </ul>
            </div>

            <!-- Column 3 - Services -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-heading">Our Services</h5>
                <ul class="footer-links">
                    <li>
                        <a href="<?= SITE_URL ?>/?page=architecture">
                            <i class="bi bi-chevron-right"></i>Architectural Designs
                        </a>
                    </li>
                    <li>
                        <a href="<?= SITE_URL ?>/?page=supervision">
                            <i class="bi bi-chevron-right"></i>Supervision of Projects
                        </a>
                    </li>
                    <li>
                        <a href="<?= SITE_URL ?>/?page=construction">
                            <i class="bi bi-chevron-right"></i>Building Construction
                        </a>
                    </li>
                    <li>
                        <a href="<?= SITE_URL ?>/?page=real-estate">
                            <i class="bi bi-chevron-right"></i>Real Estate Management
                        </a>
                    </li>
                    <li>
                        <a href="<?= SITE_URL ?>/?page=interiors">
                            <i class="bi bi-chevron-right"></i>Interior Designs
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 4 - Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-heading">Contact Us</h5>
                <ul class="footer-contact">
                    <li>
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Otukpo, Benue State, Nigeria</span>
                    </li>
                    <li>
                        <i class="bi bi-telephone-fill"></i>
                        <span>+234 XXX XXX XXXX</span>
                    </li>
                    <li>
                        <i class="bi bi-envelope-fill"></i>
                        <span>info@oremi.com</span>
                    </li>
                    <li>
                        <i class="bi bi-clock-fill"></i>
                        <span>Mon - Sat: 8:00am - 6:00pm</span>
                    </li>
                </ul>

                <!-- WhatsApp CTA -->
                <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>" 
                   class="btn btn-whatsapp mt-3" 
                   target="_blank">
                    <i class="bi bi-whatsapp me-2"></i>Chat on WhatsApp
                </a>
            </div>

        </div>

        <!-- Footer Bottom Bar -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="footer-copy">
                        &copy; <?= date('Y') ?> <?= SITE_NAME ?>. All Rights Reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="footer-credit">
                        Designed & Built by 
                        <a href="https://github.com/Elonyized" target="_blank">Elonyized</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS Animation JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<!-- Custom JS -->
<script src="<?= SITE_URL ?>/assets/js/main.js"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });

    // Dark/Light Mode Toggle
    const themeToggle = document.getElementById('themeToggle');
    const themeToggleMobile = document.getElementById('themeToggleMobile');
    const themeIcon = document.getElementById('themeIcon');
    const html = document.documentElement;

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'dark';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    function updateThemeIcon(theme) {
        if (themeIcon) {
            themeIcon.className = theme === 'dark' 
                ? 'bi bi-moon-stars-fill' 
                : 'bi bi-sun-fill';
        }
    }

    function toggleTheme() {
        const current = html.getAttribute('data-theme');
        const newTheme = current === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);
    }

    if (themeToggle) themeToggle.addEventListener('click', toggleTheme);
    if (themeToggleMobile) themeToggleMobile.addEventListener('click', toggleTheme);

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });
</script>

</body>
</html>