<?php
$pageTitle = 'Architectural Designs & Consultancy';
require_once '../app/views/layouts/header.php';

$projectObj = new Project();
$projects   = $projectObj->getByCategory('architecture', 6);
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Our Services</span>
            <h1 class="page-hero-title">Architectural <span>Designs</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <a href="<?= SITE_URL ?>/?page=home#services">Services</a>
                <i class="bi bi-chevron-right mx-2"></i>
                Architectural Designs
            </p>
        </div>
    </div>
</section>

<!-- Service Detail -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- Image -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-image-wrapper">
                    <img src="<?= SITE_URL ?>/assets/images/architecture.jpg"
                         alt="Architectural Designs"
                         style="width:100%;height:450px;object-fit:cover;border-radius:4px;">
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <span class="section-label">What We Offer</span>
                    <h2 class="section-title">
                        Creative & Functional <span>Architecture</span>
                    </h2>
                    <div class="gold-line"></div>
                    <p style="color:var(--text-secondary);margin-bottom:1.5rem;margin-top:1rem;">
                        We provide professional architectural design and consultancy services
                        tailored to your vision, lifestyle and budget. From simple bungalows
                        to complex commercial buildings, we design with purpose and precision.
                    </p>
                    <p style="color:var(--text-secondary);margin-bottom:2rem;">
                        Our team of experienced architects works closely with you from the
                        initial concept through to the final drawings, ensuring every detail
                        reflects your needs and exceeds your expectations.
                    </p>

                    <!-- Service Features -->
                    <?php
                    $features = [
                        'Residential building designs',
                        'Commercial building designs',
                        'Renovation and remodelling plans',
                        'Site analysis and feasibility studies',
                        '3D rendering and visualization',
                        'Structural and working drawings',
                        'Bill of quantities preparation',
                        'Building approval documentation',
                    ];
                    ?>
                    <div class="row g-2">
                        <?php foreach ($features as $feature) : ?>
                        <div class="col-md-6">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <i class="bi bi-check-circle-fill"
                                   style="color:var(--accent-gold);font-size:0.9rem;flex-shrink:0;"></i>
                                <span style="font-size:0.875rem;color:var(--text-secondary);">
                                    <?= $feature ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-4">
                        <a href="<?= SITE_URL ?>/?page=contact" class="btn btn-gold me-3">
                            <i class="bi bi-envelope me-2"></i>Get a Quote
                        </a>
                        <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>"
                           class="btn btn-whatsapp" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Related Projects -->
<?php if (!empty($projects)) : ?>
<section class="section-padding" style="background-color:var(--bg-secondary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Our Work</span>
            <h2 class="section-title">Architecture <span>Projects</span></h2>
            <div class="gold-line-center"></div>
        </div>

        <div class="row g-4">
            <?php foreach ($projects as $proj) :
                $cover = $projectObj->getCoverImage($proj['id']);
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
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom">
                            <?= htmlspecialchars($proj['title']) ?>
                        </h5>
                        <div class="card-meta">
                            <i class="bi bi-geo-alt"></i>
                            <span><?= htmlspecialchars($proj['location']) ?></span>
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

<!-- CTA -->
<section class="cta-section section-padding">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Start Today</span>
            <h2 class="cta-title">Ready for Your <span>Dream Design?</span></h2>
            <p class="cta-text">
                Contact us today and let's create something extraordinary together.
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

<?php require_once '../app/views/layouts/footer.php'; ?>