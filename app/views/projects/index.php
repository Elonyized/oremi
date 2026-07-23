<?php
$pageTitle = 'Projects';
require_once '../app/views/layouts/header.php';

$projectObj  = new Project();
$projects    = $projectObj->getAll();
$categories  = $projectObj->getCategories();
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Our Work</span>
            <h1 class="page-hero-title">Our <span>Projects</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                Projects
            </p>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">

        <!-- Filter Buttons -->
        <div class="text-center mb-5" data-aos="fade-up">
            <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;">
                <button class="filter-btn active" data-filter="all">All Projects</button>
                <?php foreach ($categories as $cat) : ?>
                    <button class="filter-btn" data-filter="<?= $cat['slug'] ?>">
                        <?= htmlspecialchars($cat['name']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (!empty($projects)) : ?>
        <div class="row g-4">
            <?php foreach ($projects as $proj) :
                $cover = $projectObj->getCoverImage($proj['id']);
            ?>
            <div class="col-lg-4 col-md-6 filter-item"
                        data-category="<?= $proj['category_slug'] ? $proj['category_slug'] : '' ?>"
                 data-aos="fade-up">
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
                        <div style="position:absolute;top:12px;left:12px;">
                            <span class="badge-gold">
                                <?= htmlspecialchars($proj['category_name']) ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom">
                            <?= htmlspecialchars($proj['title']) ?>
                        </h5>
                        <p class="card-text-custom">
                            <?= truncate($proj['description'], 80) ?>
                        </p>
                        <div class="card-meta">
                            <i class="bi bi-geo-alt"></i>
                            <span><?= htmlspecialchars($proj['location']) ?></span>
                        </div>
                        <div class="card-meta">
                            <i class="bi bi-check-circle"></i>
                            <span><?= ucfirst($proj['status']) ?></span>
                        </div>
                        <div class="mt-3">
                            <a href="<?= SITE_URL ?>/?page=project-detail&id=<?= $proj['id'] ?>"
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
                <i class="bi bi-folder-x"
                   style="font-size:3rem;color:var(--border-gold);display:block;margin-bottom:1rem;"></i>
                <h4 style="color:var(--text-secondary);">No Projects Yet</h4>
                <p style="color:var(--text-muted);">Check back soon for our latest work.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section-padding">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Work With Us</span>
            <h2 class="cta-title">Have a <span>Project</span> in Mind?</h2>
            <p class="cta-text">
                Let's discuss your vision and bring it to life.
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