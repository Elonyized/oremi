<?php
$pageTitle = 'Architectural Designs';
require_once '../app/views/layouts/header.php';

$designObj = new Design();
$designs   = $designObj->getAll();
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Design Plans</span>
            <h1 class="page-hero-title">Architectural <span>Designs</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                Designs
            </p>
        </div>
    </div>
</section>

<!-- Designs Section -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">

        <!-- Filter Buttons -->
        <div class="text-center mb-5" data-aos="fade-up">
            <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;">
                <button class="filter-btn active" data-filter="all">All Designs</button>
                <button class="filter-btn" data-filter="with-pdf">With PDF</button>
                <button class="filter-btn" data-filter="priced">Priced</button>
                <button class="filter-btn" data-filter="inquiry">On Inquiry</button>
            </div>
        </div>

        <?php if (!empty($designs)) : ?>
        <div class="row g-4">
            <?php foreach ($designs as $des) :
                $cover = $designObj->getCoverImage($des['id']);
                $hasPdf = !empty($des['pdf_path']);
                $hasPrince = $des['price'] > 0;
                $filterCat = $hasPdf ? 'with-pdf' : ($hasPrince ? 'priced' : 'inquiry');
            ?>
            <div class="col-lg-3 col-md-6 filter-item"
                 data-category="<?= $filterCat ?>"
                 data-aos="fade-up">
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
                        <?php if ($hasPdf) : ?>
                        <div style="position:absolute;top:12px;left:12px;">
                            <span class="badge-gold">
                                <i class="bi bi-file-pdf me-1"></i>PDF Available
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom">
                            <?= htmlspecialchars($des['title']) ?>
                        </h5>
                        <p class="card-text-custom">
                            <?= truncate($des['description'], 80) ?>
                        </p>
                        <?php if ($hasPrince) : ?>
                        <div class="card-meta">
                            <i class="bi bi-tag"></i>
                            <span style="color:var(--accent-gold);font-weight:600;">
                                <?= formatPrice($des['price']) ?>
                            </span>
                        </div>
                        <?php else : ?>
                        <div class="card-meta">
                            <i class="bi bi-chat"></i>
                            <span style="color:var(--text-muted);">Price on inquiry</span>
                        </div>
                        <?php endif; ?>
                        <div class="mt-3">
                            <a href="<?= SITE_URL ?>/?page=design-detail&id=<?= $des['id'] ?>"
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
                <i class="bi bi-pen"
                   style="font-size:3rem;color:var(--border-gold);
                          display:block;margin-bottom:1rem;"></i>
                <h4 style="color:var(--text-secondary);">No Designs Yet</h4>
                <p style="color:var(--text-muted);">
                    Check back soon for our latest architectural designs.
                </p>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section-padding">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Custom Design</span>
            <h2 class="cta-title">Need a <span>Custom Design?</span></h2>
            <p class="cta-text">
                We can create a custom architectural design tailored to your
                specific needs and budget.
            </p>
            <div class="cta-buttons">
                <a href="<?= SITE_URL ?>/?page=contact" class="btn btn-gold">
                    <i class="bi bi-envelope me-2"></i>Request Custom Design
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