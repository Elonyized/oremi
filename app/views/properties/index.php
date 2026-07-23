<?php
$pageTitle = 'Properties';
require_once '../app/views/layouts/header.php';

$propertyObj = new Property();
$properties  = $propertyObj->getAll();
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Real Estate</span>
            <h1 class="page-hero-title">Our <span>Properties</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                Properties
            </p>
        </div>
    </div>
</section>

<!-- Properties Section -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">

        <!-- Filter Buttons -->
        <div class="text-center mb-5" data-aos="fade-up">
            <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;">
                <button class="filter-btn active" data-filter="all">All Properties</button>
                <button class="filter-btn" data-filter="sale">For Sale</button>
                <button class="filter-btn" data-filter="rent">For Rent</button>
                <button class="filter-btn" data-filter="available">Available</button>
                <button class="filter-btn" data-filter="sold">Sold</button>
            </div>
        </div>

        <?php if (!empty($properties)) : ?>
        <div class="row g-4">
            <?php foreach ($properties as $prop) :
                $cover = $propertyObj->getCoverImage($prop['id']);
            ?>
            <div class="col-lg-4 col-md-6 filter-item"
                 data-category="<?= $prop['listing_type'] ?>"
                 data-aos="fade-up">
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
                        <div style="position:absolute;top:12px;left:12px;">
                            <?php if ($prop['listing_type'] === 'sale') : ?>
                                <span class="badge-sale">For Sale</span>
                            <?php else : ?>
                                <span class="badge-rent">For Rent</span>
                            <?php endif; ?>
                        </div>
                        <div style="position:absolute;top:12px;right:12px;">
                            <?php if ($prop['status'] === 'available') : ?>
                                <span class="badge-available">Available</span>
                            <?php elseif ($prop['status'] === 'sold') : ?>
                                <span class="badge-sold">Sold</span>
                            <?php else : ?>
                                <span class="badge-sold">Rented</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom">
                            <?= htmlspecialchars($prop['title']) ?>
                        </h5>
                        <p class="card-text-custom">
                            <?= truncate($prop['description'], 80) ?>
                        </p>
                        <div class="card-meta">
                            <i class="bi bi-geo-alt"></i>
                            <span><?= htmlspecialchars($prop['location']) ?></span>
                        </div>
                        <div class="card-meta">
                            <i class="bi bi-currency-exchange"></i>
                            <span style="color:var(--accent-gold);font-weight:600;">
                                <?= formatPrice($prop['price']) ?>
                            </span>
                        </div>
                        <div class="card-meta">
                            <i class="bi bi-door-open"></i>
                            <span><?= $prop['bedrooms'] ?> Beds</span>
                            <i class="bi bi-droplet ms-2"></i>
                            <span><?= $prop['bathrooms'] ?> Baths</span>
                        </div>
                        <div class="mt-3">
                            <a href="<?= SITE_URL ?>/?page=property-detail&id=<?= $prop['id'] ?>"
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
                <i class="bi bi-buildings"
                   style="font-size:3rem;color:var(--border-gold);display:block;margin-bottom:1rem;"></i>
                <h4 style="color:var(--text-secondary);">No Properties Yet</h4>
                <p style="color:var(--text-muted);">Check back soon for available properties.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section-padding">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Get In Touch</span>
            <h2 class="cta-title">Looking for a <span>Property?</span></h2>
            <p class="cta-text">
                Contact us today and let us help you find your dream property.
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