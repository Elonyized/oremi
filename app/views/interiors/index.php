<?php
$pageTitle = 'Interior Designs';
require_once '../app/views/layouts/header.php';

$interiorObj = new Interior();
$interiors   = $interiorObj->getAll();
$styles      = $interiorObj->getStyles();
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Interior Spaces</span>
            <h1 class="page-hero-title">Interior <span>Designs</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                Interiors
            </p>
        </div>
    </div>
</section>

<!-- Interiors Section -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">

        <!-- Filter Buttons -->
        <?php if (!empty($styles)) : ?>
        <div class="text-center mb-5" data-aos="fade-up">
            <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;">
                <button class="filter-btn active" data-filter="all">All Styles</button>
                <?php foreach ($styles as $style) : ?>
                    <button class="filter-btn"
                            data-filter="<?= strtolower($style['style']) ?>">
                        <?= htmlspecialchars($style['style']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($interiors)) : ?>
        <div class="row g-4">
            <?php foreach ($interiors as $index => $inter) :
                $cover = $interiorObj->getCoverImage($inter['id']);
                $colClass = ($index % 5 === 0 || $index % 5 === 3)
                    ? 'col-lg-6 col-md-6'
                    : 'col-lg-3 col-md-6';
            ?>
            <div class="<?= $colClass ?> filter-item"
                 data-category="<?= strtolower($inter['style'] ?? 'all') ?>"
                 data-aos="fade-up">
                <div class="content-card">
                    <div class="card-img-wrapper"
                         style="height:<?= ($index % 5 === 0 || $index % 5 === 3) ? '320px' : '220px' ?>">
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
                        <div style="position:absolute;bottom:12px;left:12px;">
                            <span class="badge-gold">
                                <?= htmlspecialchars($inter['style']) ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom">
                            <?= htmlspecialchars($inter['title']) ?>
                        </h5>
                        <p class="card-text-custom">
                            <?= truncate($inter['description'], 80) ?>
                        </p>
                        <div class="mt-3">
                            <a href="<?= SITE_URL ?>/?page=interior-detail&id=<?= $inter['id'] ?>"
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
                <i class="bi bi-layout-text-window"
                   style="font-size:3rem;color:var(--border-gold);
                          display:block;margin-bottom:1rem;"></i>
                <h4 style="color:var(--text-secondary);">No Interior Designs Yet</h4>
                <p style="color:var(--text-muted);">
                    Check back soon for our latest interior design work.
                </p>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section-padding">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Transform Your Space</span>
            <h2 class="cta-title">Want a Beautiful <span>Interior?</span></h2>
            <p class="cta-text">
                Let us transform your space into something extraordinary.
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