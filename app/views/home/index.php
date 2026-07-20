<?php
$pageTitle = 'Home';
require_once '../app/views/layouts/header.php';

// Fetch data for homepage
$project = new Project();
$property = new Property();
$construction = new Construction();
$design = new Design();
$interior = new Interior();

$featuredProjects = $project->getFeatured(6);
$featuredProperties = $property->getFeatured(6);
$featuredConstructions = $construction->getFeatured(3);
$featuredDesigns = $design->getFeatured(4);
$featuredInteriors = $interior->getFeatured(6);
?>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content" data-aos="fade-up">
        <span class="hero-label">Architecture · Construction · Real Estate</span>
        <h1 class="hero-title">
            Building Dreams Into <span>Reality</span>
        </h1>
        <p class="hero-subtitle">
            Professional architecture, construction and real estate services 
            across Nigeria and beyond. Quality you can trust, designs you will love.
        </p>
        <div class="hero-buttons">
            <a href="<?= SITE_URL ?>/?page=projects" class="btn btn-gold">
                View Our Work
            </a>
            <a href="<?= SITE_URL ?>/?page=contact" class="btn btn-gold-outline">
                Contact Us
            </a>
        </div>
    </div>
    <div class="hero-scroll">
        <span>Scroll</span>
        <i class="bi bi-chevron-down"></i>
    </div>
</section>

<!-- ============================================================
     ABOUT SNIPPET
     ============================================================ -->
<section class="about-section section-padding">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- Image -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-image-wrapper">
                    <img src="<?= SITE_URL ?>/assets/images/about.jpg" alt="About <?= SITE_NAME ?>">
                    <div class="about-image-badge">
                        <span class="number">10+</span>
                        <span class="label">Years of Experience</span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <span class="section-label">Who We Are</span>
                    <h2 class="section-title">
                        Excellence in Every <span>Structure</span> We Build
                    </h2>
                    <div class="gold-line"></div>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                        We are a team of professional architects, builders and real estate 
                        managers dedicated to delivering world-class structures across Nigeria 
                        and beyond. From concept to completion, we bring your vision to life.
                    </p>
                    <p style="color: var(--text-secondary); margin-bottom: 2rem;">
                        With over a decade of experience in architectural design, building 
                        construction, project supervision and real estate management, we have 
                        built a reputation for quality, innovation and timely delivery.
                    </p>
                    <a href="<?= SITE_URL ?>/?page=about" class="btn btn-gold-outline">
                        Learn More About Us
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================
     SERVICES SECTION
     ============================================================ -->
<section class="section-padding" style="background-color: var(--bg-primary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">What We Do</span>
            <h2 class="section-title">Our <span>Services</span></h2>
            <div class="gold-line-center"></div>
            <p class="section-subtitle">
                We offer a full range of professional services to meet all your 
                architectural, construction and real estate needs.
            </p>
        </div>

        <div class="row g-4">
            <!-- Architecture -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h4 class="service-title">Architectural Designs</h4>
                    <p class="service-text">
                        Creative and functional architectural designs tailored 
                        to your vision and budget.
                    </p>
                    <a href="<?= SITE_URL ?>/?page=architecture" class="btn btn-gold-outline btn-sm">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- Supervision -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-eye"></i>
                    </div>
                    <h4 class="service-title">Project Supervision</h4>
                    <p class="service-text">
                        Professional oversight of your construction project 
                        from groundbreaking to completion.
                    </p>
                    <a href="<?= SITE_URL ?>/?page=supervision" class="btn btn-gold-outline btn-sm">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- Construction -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-hammer"></i>
                    </div>
                    <h4 class="service-title">Building Construction</h4>
                    <p class="service-text">
                        Quality building construction of all kinds — residential, 
                        commercial and industrial.
                    </p>
                    <a href="<?= SITE_URL ?>/?page=construction" class="btn btn-gold-outline btn-sm">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- Real Estate -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-house-heart"></i>
                    </div>
                    <h4 class="service-title">Real Estate Management</h4>
                    <p class="service-text">
                        Expert real estate management services — buying, selling, 
                        renting and property management.
                    </p>
                    <a href="<?= SITE_URL ?>/?page=real-estate" class="btn btn-gold-outline btn-sm">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     STATS SECTION
     ============================================================ -->
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
                    <span class="stat-number" data-count="<?= $project->getCount() ?>">0</span>
                    <span class="stat-label">Projects Completed</span>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <span class="stat-number" data-count="<?= $property->getCount() ?>">0</span>
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

<!-- ============================================================
     FEATURED PROJECTS
     ============================================================ -->
<?php if (!empty($featuredProjects)) : ?>
<section class="section-padding" style="background-color: var(--bg-secondary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Our Portfolio</span>
            <h2 class="section-title">Featured <span>Projects</span></h2>
            <div class="gold-line-center"></div>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredProjects as $proj) : 
                $cover = $project->getCoverImage($proj['id']);
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="content-card">
                    <div class="card-img-wrapper">
                        <?php if ($cover) : ?>
                            <img src="<?= UPLOAD_URL ?>projects/<?= $cover['image_path'] ?>" 
                                 alt="<?= htmlspecialchars($proj['title']) ?>">
                        <?php else : ?>
                            <img src="<?= SITE_URL ?>/assets/images/placeholder.jpg" 
                                 alt="No image">
                        <?php endif; ?>
                        <div class="card-img-overlay-hover">
                            <a href="<?= SITE_URL ?>/?page=project-detail&id=<?= $proj['id'] ?>" 
                               class="btn btn-gold btn-sm">View Project</a>
                        </div>
                        <div style="position: absolute; top: 12px; left: 12px;">
                            <span class="badge-gold"><?= htmlspecialchars($proj['category_name']) ?></span>
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom"><?= htmlspecialchars($proj['title']) ?></h5>
                        <div class="card-meta">
                            <i class="bi bi-geo-alt"></i>
                            <span><?= htmlspecialchars($proj['location']) ?></span>
                        </div>
                        <div class="card-meta">
                            <i class="bi bi-check-circle"></i>
                            <span><?= ucfirst($proj['status']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= SITE_URL ?>/?page=projects" class="btn btn-gold-outline">
                View All Projects
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     FEATURED PROPERTIES
     ============================================================ -->
<?php if (!empty($featuredProperties)) : ?>
<section class="section-padding" style="background-color: var(--bg-primary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Real Estate</span>
            <h2 class="section-title">Featured <span>Properties</span></h2>
            <div class="gold-line-center"></div>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredProperties as $prop) :
                $cover = $property->getCoverImage($prop['id']);
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="content-card">
                    <div class="card-img-wrapper">
                        <?php if ($cover) : ?>
                            <img src="<?= UPLOAD_URL ?>properties/<?= $cover['image_path'] ?>" 
                                 alt="<?= htmlspecialchars($prop['title']) ?>">
                        <?php else : ?>
                            <img src="<?= SITE_URL ?>/assets/images/placeholder.jpg" 
                                 alt="No image">
                        <?php endif; ?>
                        <div class="card-img-overlay-hover">
                            <a href="<?= SITE_URL ?>/?page=property-detail&id=<?= $prop['id'] ?>" 
                               class="btn btn-gold btn-sm">View Property</a>
                        </div>
                        <div style="position: absolute; top: 12px; left: 12px;">
                            <?php if ($prop['listing_type'] === 'sale') : ?>
                                <span class="badge-sale">For Sale</span>
                            <?php else : ?>
                                <span class="badge-rent">For Rent</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom"><?= htmlspecialchars($prop['title']) ?></h5>
                        <div class="card-meta">
                            <i class="bi bi-geo-alt"></i>
                            <span><?= htmlspecialchars($prop['location']) ?></span>
                        </div>
                        <div class="card-meta">
                            <i class="bi bi-currency-exchange"></i>
                            <span><?= formatPrice($prop['price']) ?></span>
                        </div>
                        <div class="card-meta">
                            <i class="bi bi-door-open"></i>
                            <span><?= $prop['bedrooms'] ?> Beds</span>
                            <i class="bi bi-droplet ms-2"></i>
                            <span><?= $prop['bathrooms'] ?> Baths</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= SITE_URL ?>/?page=properties" class="btn btn-gold-outline">
                View All Properties
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     UNDER CONSTRUCTION
     ============================================================ -->
<?php if (!empty($featuredConstructions)) : ?>
<section class="section-padding" style="background-color: var(--bg-secondary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">In Progress</span>
            <h2 class="section-title">Under <span>Construction</span></h2>
            <div class="gold-line-center"></div>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredConstructions as $cons) :
                $cover = $construction->getCoverImage($cons['id']);
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="content-card">
                    <div class="card-img-wrapper">
                        <?php if ($cover) : ?>
                            <img src="<?= UPLOAD_URL ?>constructions/<?= $cover['image_path'] ?>" 
                                 alt="<?= htmlspecialchars($cons['title']) ?>">
                        <?php else : ?>
                            <img src="<?= SITE_URL ?>/assets/images/placeholder.jpg" 
                                 alt="No image">
                        <?php endif; ?>
                        <div class="card-img-overlay-hover">
                            <a href="<?= SITE_URL ?>/?page=construction-detail&id=<?= $cons['id'] ?>" 
                               class="btn btn-gold btn-sm">View Details</a>
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom"><?= htmlspecialchars($cons['title']) ?></h5>
                        <div class="card-meta">
                            <i class="bi bi-geo-alt"></i>
                            <span><?= htmlspecialchars($cons['location']) ?></span>
                        </div>
                        <div class="progress-label">
                            <span>Progress</span>
                            <span><?= $cons['progress_percent'] ?>%</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar-custom" 
                                 style="width: <?= $cons['progress_percent'] ?>%">
                            </div>
                        </div>
                        <?php if ($cons['expected_completion']) : ?>
                        <div class="card-meta mt-2">
                            <i class="bi bi-calendar"></i>
                            <span>Expected: <?= formatDate($cons['expected_completion']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= SITE_URL ?>/?page=constructions" class="btn btn-gold-outline">
                View All
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     ARCHITECTURAL DESIGNS
     ============================================================ -->
<?php if (!empty($featuredDesigns)) : ?>
<section class="section-padding" style="background-color: var(--bg-primary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Design Plans</span>
            <h2 class="section-title">Architectural <span>Designs</span></h2>
            <div class="gold-line-center"></div>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredDesigns as $des) :
                $cover = $design->getCoverImage($des['id']);
            ?>
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="content-card">
                    <div class="card-img-wrapper">
                        <?php if ($cover) : ?>
                            <img src="<?= UPLOAD_URL ?>designs/<?= $cover['image_path'] ?>" 
                                 alt="<?= htmlspecialchars($des['title']) ?>">
                        <?php else : ?>
                            <img src="<?= SITE_URL ?>/assets/images/placeholder.jpg" 
                                 alt="No image">
                        <?php endif; ?>
                        <div class="card-img-overlay-hover">
                            <a href="<?= SITE_URL ?>/?page=design-detail&id=<?= $des['id'] ?>" 
                               class="btn btn-gold btn-sm">View Design</a>
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom"><?= htmlspecialchars($des['title']) ?></h5>
                        <?php if ($des['price'] > 0) : ?>
                        <div class="card-meta">
                            <i class="bi bi-tag"></i>
                            <span><?= formatPrice($des['price']) ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if ($des['pdf_path']) : ?>
                        <div class="card-meta">
                            <i class="bi bi-file-pdf"></i>
                            <span>PDF Available</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= SITE_URL ?>/?page=designs" class="btn btn-gold-outline">
                View All Designs
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     INTERIOR DESIGNS
     ============================================================ -->
<?php if (!empty($featuredInteriors)) : ?>
<section class="section-padding" style="background-color: var(--bg-secondary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Interior Spaces</span>
            <h2 class="section-title">Interior <span>Designs</span></h2>
            <div class="gold-line-center"></div>
        </div>

        <div class="row g-3">
            <?php foreach ($featuredInteriors as $index => $inter) :
                $cover = $interior->getCoverImage($inter['id']);
                $colClass = ($index === 0 || $index === 3) ? 'col-lg-6 col-md-6' : 'col-lg-3 col-md-6';
            ?>
            <div class="<?= $colClass ?>" data-aos="fade-up">
                <div class="content-card">
                    <div class="card-img-wrapper" style="height: <?= ($index === 0 || $index === 3) ? '300px' : '220px' ?>">
                        <?php if ($cover) : ?>
                            <img src="<?= UPLOAD_URL ?>interiors/<?= $cover['image_path'] ?>" 
                                 alt="<?= htmlspecialchars($inter['title']) ?>">
                        <?php else : ?>
                            <img src="<?= SITE_URL ?>/assets/images/placeholder.jpg" 
                                 alt="No image">
                        <?php endif; ?>
                        <div class="card-img-overlay-hover">
                            <a href="<?= SITE_URL ?>/?page=interior-detail&id=<?= $inter['id'] ?>" 
                               class="btn btn-gold btn-sm">View Interior</a>
                        </div>
                        <?php if ($inter['style']) : ?>
                        <div style="position: absolute; bottom: 12px; left: 12px;">
                            <span class="badge-gold"><?= htmlspecialchars($inter['style']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom"><?= htmlspecialchars($inter['title']) ?></h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= SITE_URL ?>/?page=interiors" class="btn btn-gold-outline">
                View All Interiors
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     CTA SECTION
     ============================================================ -->
<section class="cta-section section-padding">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Get In Touch</span>
            <h2 class="cta-title">
                Ready to Build Your <span>Dream?</span>
            </h2>
            <p class="cta-text">
                Let's discuss your project. Whether it's a new build, a design 
                consultation or a property — we are here to help.
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
    // Animate stat numbers on scroll
    const statNumbers = document.querySelectorAll('.stat-number');

    const countUp = (el) => {
        const target = parseInt(el.getAttribute('data-count'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
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