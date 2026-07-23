<?php
$pageTitle = 'Real Estate Management';
require_once '../app/views/layouts/header.php';

$propertyObj = new Property();
$properties  = $propertyObj->getFeatured(6);
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Our Services</span>
            <h1 class="page-hero-title">Real Estate <span>Management</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <a href="<?= SITE_URL ?>/?page=home#services">Services</a>
                <i class="bi bi-chevron-right mx-2"></i>
                Real Estate Management
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
                    <img src="<?= SITE_URL ?>/assets/images/real-estate.jpg"
                         alt="Real Estate Management"
                         style="width:100%;height:450px;object-fit:cover;border-radius:4px;">
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <span class="section-label">What We Offer</span>
                    <h2 class="section-title">
                        Expert Real Estate <span>Services</span>
                    </h2>
                    <div class="gold-line"></div>
                    <p style="color:var(--text-secondary);margin-bottom:1.5rem;margin-top:1rem;">
                        We offer comprehensive real estate management services covering
                        property sales, rentals, acquisitions and management. Our deep
                        knowledge of the Nigerian property market enables us to provide
                        informed advice and deliver exceptional results for our clients.
                    </p>
                    <p style="color:var(--text-secondary);margin-bottom:2rem;">
                        Whether you are looking to buy your dream home, sell a property,
                        find a rental or manage an existing real estate portfolio, our
                        team of experienced real estate professionals is here to help
                        you every step of the way.
                    </p>

                    <?php
                    $features = [
                        'Property sales and acquisition',
                        'Property rental management',
                        'Real estate investment advisory',
                        'Property valuation and appraisal',
                        'Land search and documentation',
                        'Property development consultancy',
                        'Tenant screening and management',
                        'Property maintenance services',
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
                            <i class="bi bi-envelope me-2"></i>Get In Touch
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

<!-- Stats -->
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
                          data-count="<?= $propertyObj->getCount() ?>">0</span>
                    <span class="stat-label">Properties Listed</span>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <span class="stat-number" data-count="50">0</span>
                    <span class="stat-label">Happy Clients</span>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item">
                    <span class="stat-number" data-count="5">0</span>
                    <span class="stat-label">States Covered</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Properties -->
<?php if (!empty($properties)) : ?>
<section class="section-padding" style="background-color:var(--bg-secondary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Available Now</span>
            <h2 class="section-title">Featured <span>Properties</span></h2>
            <div class="gold-line-center"></div>
        </div>

        <div class="row g-4">
            <?php foreach ($properties as $prop) :
                $cover = $propertyObj->getCoverImage($prop['id']);
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
                        <div style="position:absolute;top:12px;left:12px;">
                            <?php if ($prop['listing_type'] === 'sale') : ?>
                                <span class="badge-sale">For Sale</span>
                            <?php else : ?>
                                <span class="badge-rent">For Rent</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="card-title-custom">
                            <?= htmlspecialchars($prop['title']) ?>
                        </h5>
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

<!-- CTA -->
<section class="cta-section section-padding">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Get In Touch</span>
            <h2 class="cta-title">Looking for a <span>Property?</span></h2>
            <p class="cta-text">
                Let our real estate experts help you find or sell your
                perfect property today.
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