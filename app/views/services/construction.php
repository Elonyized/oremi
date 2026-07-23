<?php
$pageTitle = 'Building Construction';
require_once '../app/views/layouts/header.php';

$projectObj      = new Project();
$constructionObj = new Construction();
$projects        = $projectObj->getByCategory('construction', 6);
$constructions   = $constructionObj->getFeatured(3);
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Our Services</span>
            <h1 class="page-hero-title">Building <span>Construction</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <a href="<?= SITE_URL ?>/?page=home#services">Services</a>
                <i class="bi bi-chevron-right mx-2"></i>
                Building Construction
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
                    <img src="<?= SITE_URL ?>/assets/images/construction.jpg"
                         alt="Building Construction"
                         style="width:100%;height:450px;object-fit:cover;border-radius:4px;">
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <span class="section-label">What We Offer</span>
                    <h2 class="section-title">
                        Quality Builds That <span>Last</span>
                    </h2>
                    <div class="gold-line"></div>
                    <p style="color:var(--text-secondary);margin-bottom:1.5rem;margin-top:1rem;">
                        We handle building construction of all kinds — residential,
                        commercial and industrial. Our experienced construction team
                        delivers quality builds that stand the test of time, using
                        the best materials and proven construction methods.
                    </p>
                    <p style="color:var(--text-secondary);margin-bottom:2rem;">
                        From the foundation to the finishing touches, we are with you
                        every step of the way, ensuring your building is constructed
                        safely, efficiently and to the exact specifications of your
                        approved design.
                    </p>

                    <?php
                    $features = [
                        'Residential buildings of all types',
                        'Commercial and office buildings',
                        'Industrial and warehouse buildings',
                        'School and church buildings',
                        'Foundation and substructure works',
                        'Roofing and finishing works',
                        'Tiling and plumbing works',
                        'Electrical and mechanical works',
                    ];
                    ?>
                    <div class="row g-2">
                        <?php foreach ($features as $feature) : ?>
                        <div class="col-md-6">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <i class="bi bi-check-circle-fill"
                                   style="color:var(--accent-gold);font-size:0.9rem;
                                          flex-shrink:0;"></i>
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

<!-- Under Construction Projects -->
<?php if (!empty($constructions)) : ?>
<section class="section-padding" style="background-color:var(--bg-secondary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">In Progress</span>
            <h2 class="section-title">Currently <span>Building</span></h2>
            <div class="gold-line-center"></div>
            <p class="section-subtitle">
                Take a look at what we are currently building.
            </p>
        </div>

        <div class="row g-4">
            <?php foreach ($constructions as $cons) :
                $cover = $constructionObj->getCoverImage($cons['id']);
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
                        <div style="position:absolute;top:12px;left:12px;">
                            <span class="badge-gold">
                                <?= $cons['progress_percent'] ?>% Complete
                            </span>
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom">
                            <?= htmlspecialchars($cons['title']) ?>
                        </h5>
                        <div class="card-meta">
                            <i class="bi bi-geo-alt"></i>
                            <span><?= htmlspecialchars($cons['location']) ?></span>
                        </div>
                        <div class="progress-label mt-2">
                            <span>Progress</span>
                            <span><?= $cons['progress_percent'] ?>%</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar-custom"
                                 style="width:<?= $cons['progress_percent'] ?>%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= SITE_URL ?>/?page=constructions" class="btn btn-gold-outline">
                View All Constructions
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Completed Projects -->
<?php if (!empty($projects)) : ?>
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Our Portfolio</span>
            <h2 class="section-title">Completed <span>Buildings</span></h2>
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
            <span class="section-label">Start Building</span>
            <h2 class="cta-title">Ready to Build Your <span>Dream?</span></h2>
            <p class="cta-text">
                Contact us today and let's start building something great together.
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