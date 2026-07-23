<?php
$pageTitle = 'About Us';
require_once '../app/views/layouts/header.php';

$projectObj  = new Project();
$propertyObj = new Property();
$designObj   = new Design();
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Who We Are</span>
            <h1 class="page-hero-title">About <span>Us</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                About
            </p>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- Image -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-image-wrapper">
                    <img src="<?= SITE_URL ?>/assets/images/about.jpg"
                         alt="About <?= SITE_NAME ?>">
                    <div class="about-image-badge">
                        <span class="number">10+</span>
                        <span class="label">Years of Experience</span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <span class="section-label">Our Story</span>
                    <h2 class="section-title">
                        Excellence in Every <span>Structure</span> We Build
                    </h2>
                    <div class="gold-line"></div>
                    <p style="color:var(--text-secondary);margin-bottom:1.5rem;margin-top:1rem;">
                        We are a team of professional architects, builders and real estate
                        managers dedicated to delivering world-class structures across Nigeria
                        and beyond. From concept to completion, we bring your vision to life.
                    </p>
                    <p style="color:var(--text-secondary);margin-bottom:1.5rem;">
                        With over a decade of experience in architectural design, building
                        construction, project supervision and real estate management, we have
                        built a reputation for quality, innovation and timely delivery.
                    </p>
                    <p style="color:var(--text-secondary);margin-bottom:2rem;">
                        Our commitment to excellence and client satisfaction has made us
                        one of the most trusted names in the industry. We don't just build
                        structures — we create spaces where people live, work and thrive.
                    </p>

                    <!-- Key Points -->
                    <div class="row g-3">
                        <div class="col-6">
                            <div style="display:flex;align-items:flex-start;gap:10px;">
                                <i class="bi bi-check-circle-fill"
                                   style="color:var(--accent-gold);font-size:1.1rem;
                                          margin-top:2px;flex-shrink:0;"></i>
                                <span style="font-size:0.875rem;color:var(--text-secondary);">
                                    Professional Team
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="display:flex;align-items:flex-start;gap:10px;">
                                <i class="bi bi-check-circle-fill"
                                   style="color:var(--accent-gold);font-size:1.1rem;
                                          margin-top:2px;flex-shrink:0;"></i>
                                <span style="font-size:0.875rem;color:var(--text-secondary);">
                                    Quality Materials
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="display:flex;align-items:flex-start;gap:10px;">
                                <i class="bi bi-check-circle-fill"
                                   style="color:var(--accent-gold);font-size:1.1rem;
                                          margin-top:2px;flex-shrink:0;"></i>
                                <span style="font-size:0.875rem;color:var(--text-secondary);">
                                    Timely Delivery
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="display:flex;align-items:flex-start;gap:10px;">
                                <i class="bi bi-check-circle-fill"
                                   style="color:var(--accent-gold);font-size:1.1rem;
                                          margin-top:2px;flex-shrink:0;"></i>
                                <span style="font-size:0.875rem;color:var(--text-secondary);">
                                    Client Satisfaction
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="display:flex;align-items:flex-start;gap:10px;">
                                <i class="bi bi-check-circle-fill"
                                   style="color:var(--accent-gold);font-size:1.1rem;
                                          margin-top:2px;flex-shrink:0;"></i>
                                <span style="font-size:0.875rem;color:var(--text-secondary);">
                                    Innovative Designs
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="display:flex;align-items:flex-start;gap:10px;">
                                <i class="bi bi-check-circle-fill"
                                   style="color:var(--accent-gold);font-size:1.1rem;
                                          margin-top:2px;flex-shrink:0;"></i>
                                <span style="font-size:0.875rem;color:var(--text-secondary);">
                                    Nationwide Service
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section section-padding-sm">
    <div class="container">
        <div class="row g-0">
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <span class="stat-number" data-count="10">0</span>
                    <span class="stat-label">Years Experience</span>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <span class="stat-number"
                          data-count="<?= $projectObj->getCount() ?>">0</span>
                    <span class="stat-label">Projects Completed</span>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <span class="stat-number"
                          data-count="<?= $propertyObj->getCount() ?>">0</span>
                    <span class="stat-label">Properties Listed</span>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item">
                    <span class="stat-number" data-count="50">0</span>
                    <span class="stat-label">Happy Clients</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="section-padding" style="background-color:var(--bg-secondary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">What Drives Us</span>
            <h2 class="section-title">Mission & <span>Vision</span></h2>
            <div class="gold-line-center"></div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card text-center">
                    <div class="service-icon">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h4 class="service-title">Our Mission</h4>
                    <p class="service-text">
                        To deliver exceptional architectural designs, quality construction
                        and outstanding real estate services that exceed our clients'
                        expectations while maintaining the highest standards of
                        professionalism and integrity.
                    </p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card text-center">
                    <div class="service-icon">
                        <i class="bi bi-eye"></i>
                    </div>
                    <h4 class="service-title">Our Vision</h4>
                    <p class="service-text">
                        To be the most trusted and innovative architecture and construction
                        firm in Nigeria, known for transforming communities through
                        beautiful, functional and sustainable structures.
                    </p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card text-center">
                    <div class="service-icon">
                        <i class="bi bi-gem"></i>
                    </div>
                    <h4 class="service-title">Our Values</h4>
                    <p class="service-text">
                        Integrity, excellence, innovation and client satisfaction are
                        the core values that guide every project we undertake. We believe
                        every client deserves the best and we strive to deliver nothing less.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Our Advantage</span>
            <h2 class="section-title">Why Choose <span>Us</span></h2>
            <div class="gold-line-center"></div>
        </div>

        <div class="row g-4">
            <?php
            $reasons = [
                ['icon' => 'bi-award', 'title' => 'Experienced Team',
                 'text' => 'Our team of professionals brings years of experience and expertise to every project.'],
                ['icon' => 'bi-shield-check', 'title' => 'Quality Guaranteed',
                 'text' => 'We use only the finest materials and construction methods to ensure lasting quality.'],
                ['icon' => 'bi-clock-history', 'title' => 'Timely Delivery',
                 'text' => 'We respect your time and always strive to deliver projects on schedule.'],
                ['icon' => 'bi-currency-exchange', 'title' => 'Competitive Pricing',
                 'text' => 'We offer fair and transparent pricing without compromising on quality.'],
                ['icon' => 'bi-headset', 'title' => 'Excellent Support',
                 'text' => 'Our team is always available to address your concerns and keep you informed.'],
                ['icon' => 'bi-geo-alt', 'title' => 'Nationwide Reach',
                 'text' => 'We serve clients across Nigeria and beyond with the same level of dedication.'],
            ];
            foreach ($reasons as $index => $reason) :
            ?>
            <div class="col-lg-4 col-md-6"
                 data-aos="fade-up"
                 data-aos-delay="<?= ($index + 1) * 100 ?>">
                <div style="display:flex;align-items:flex-start;gap:1rem;
                            padding:1.5rem;background:var(--bg-card);
                            border:1px solid var(--border-color);border-radius:4px;
                            height:100%;transition:all 0.3s ease;"
                     onmouseover="this.style.borderColor='var(--border-gold)'"
                     onmouseout="this.style.borderColor='var(--border-color)'">
                    <div style="width:45px;height:45px;background:var(--accent-gold-dim);
                                border:1px solid var(--border-gold);border-radius:50%;
                                display:flex;align-items:center;justify-content:center;
                                flex-shrink:0;">
                        <i class="bi <?= $reason['icon'] ?>"
                           style="color:var(--accent-gold);font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <h5 style="font-family:'Playfair Display',serif;font-size:1rem;
                                   color:var(--text-primary);margin-bottom:0.5rem;">
                            <?= $reason['title'] ?>
                        </h5>
                        <p style="font-size:0.875rem;color:var(--text-secondary);margin:0;">
                            <?= $reason['text'] ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section-padding">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Get In Touch</span>
            <h2 class="cta-title">Ready to Start Your <span>Project?</span></h2>
            <p class="cta-text">
                Let's work together to bring your vision to life.
            </p>
            <div class="cta-buttons">
                <a href="<?= SITE_URL ?>/?page=contact" class="btn btn-gold">
                    <i class="bi bi-envelope me-2"></i>Contact Us
                </a>
                <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>"
                   class="btn btn-whatsapp" target="_blank">
                    <i class="bi bi-whatsapp me-2"></i>Chat on WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Counter Script -->
<script>
    const statNumbers = document.querySelectorAll('.stat-number');
    const countUp = (el) => {
        const target   = parseInt(el.getAttribute('data-count'));
        const duration = 2000;
        const step     = target / (duration / 16);
        let current    = 0;
        const timer    = setInterval(() => {
            current += step;
            if (current >= target) {
                el.textContent = target + '+';
                clearInterval(timer);
            } else {
                el.textContent = Math.floor(current);
            }
        }, 16);
    };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                countUp(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    statNumbers.forEach(el => observer.observe(el));
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>