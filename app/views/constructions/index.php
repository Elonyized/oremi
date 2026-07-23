<?php
$pageTitle = 'Under Construction';
require_once '../app/views/layouts/header.php';

$constructionObj = new Construction();
$constructions   = $constructionObj->getAll();
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">In Progress</span>
            <h1 class="page-hero-title">Under <span>Construction</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                Under Construction
            </p>
        </div>
    </div>
</section>

<!-- Constructions Section -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">

        <?php if (!empty($constructions)) : ?>
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
                        <p class="card-text-custom">
                            <?= truncate($cons['description'], 80) ?>
                        </p>
                        <div class="card-meta">
                            <i class="bi bi-geo-alt"></i>
                            <span><?= htmlspecialchars($cons['location']) ?></span>
                        </div>
                        <?php if ($cons['expected_completion']) : ?>
                        <div class="card-meta">
                            <i class="bi bi-calendar"></i>
                            <span>Expected: <?= formatDate($cons['expected_completion']) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="progress-label mt-2">
                            <span>Progress</span>
                            <span><?= $cons['progress_percent'] ?>%</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar-custom"
                                 style="width:<?= $cons['progress_percent'] ?>%">
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?= SITE_URL ?>/?page=construction-detail&id=<?= $cons['id'] ?>"
                               class="btn btn-gold-outline btn-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
            <div class="text-center py-5">
                <i class="bi bi-hammer"
                   style="font-size:3rem;color:var(--border-gold);
                          display:block;margin-bottom:1rem;"></i>
                <h4 style="color:var(--text-secondary);">No Active Constructions</h4>
                <p style="color:var(--text-muted);">
                    Check back soon for ongoing construction projects.
                </p>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section-padding">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Start Building</span>
            <h2 class="cta-title">Ready to <span>Build?</span></h2>
            <p class="cta-text">
                Let us handle your construction project from start to finish.
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