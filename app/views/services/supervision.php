<?php
$pageTitle = 'Supervision of Projects';
require_once '../app/views/layouts/header.php';

$projectObj = new Project();
$projects   = $projectObj->getByCategory('supervision', 6);
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Our Services</span>
            <h1 class="page-hero-title">Project <span>Supervision</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <a href="<?= SITE_URL ?>/?page=home#services">Services</a>
                <i class="bi bi-chevron-right mx-2"></i>
                Supervision of Projects
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
                    <img src="<?= SITE_URL ?>/assets/images/supervision.jpg"
                         alt="Project Supervision"
                         style="width:100%;height:450px;object-fit:cover;border-radius:4px;">
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <span class="section-label">What We Offer</span>
                    <h2 class="section-title">
                        Professional Project <span>Oversight</span>
                    </h2>
                    <div class="gold-line"></div>
                    <p style="color:var(--text-secondary);margin-bottom:1.5rem;margin-top:1rem;">
                        Our project supervision service ensures your construction project
                        is executed to the highest standards, on time and within budget.
                        We act as your eyes and ears on site, protecting your investment
                        at every stage.
                    </p>
                    <p style="color:var(--text-secondary);margin-bottom:2rem;">
                        Whether you are building a home, an office complex or any other
                        structure, our experienced supervisors will oversee every aspect
                        of the construction process to guarantee quality and compliance
                        with approved plans.
                    </p>

                    <!-- Service Features -->
                    <?php
                    $features = [
                        'Full site supervision and management',
                        'Quality control and assurance',
                        'Material inspection and approval',
                        'Contractor coordination',
                        'Progress monitoring and reporting',
                        'Cost control and budget management',
                        'Health and safety compliance',
                        'Final inspection and handover',
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

<!-- How It Works -->
<section class="section-padding" style="background-color:var(--bg-secondary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Our Process</span>
            <h2 class="section-title">How We <span>Work</span></h2>
            <div class="gold-line-center"></div>
        </div>

        <div class="row g-4">
            <?php
            $steps = [
                ['number' => '01', 'icon' => 'bi-file-text',
                 'title'  => 'Project Review',
                 'text'   => 'We review your approved plans, specifications and contracts before work begins.'],
                ['number' => '02', 'icon' => 'bi-person-check',
                 'title'  => 'Site Assessment',
                 'text'   => 'Our supervisor conducts a thorough site assessment and meets with contractors.'],
                ['number' => '03', 'icon' => 'bi-eye',
                 'title'  => 'Active Supervision',
                 'text'   => 'We provide daily or weekly supervision depending on project requirements.'],
                ['number' => '04', 'icon' => 'bi-graph-up',
                 'title'  => 'Progress Reports',
                 'text'   => 'Regular detailed reports keep you informed of progress at every stage.'],
                ['number' => '05', 'icon' => 'bi-shield-check',
                 'title'  => 'Quality Control',
                 'text'   => 'All materials and workmanship are inspected against approved standards.'],
                ['number' => '06', 'icon' => 'bi-house-check',
                 'title'  => 'Final Handover',
                 'text'   => 'We conduct a final inspection and ensure everything meets specifications before handover.'],
            ];
            foreach ($steps as $index => $step) :
            ?>
            <div class="col-lg-4 col-md-6"
                 data-aos="fade-up"
                 data-aos-delay="<?= ($index + 1) * 100 ?>">
                <div style="background:var(--bg-card);border:1px solid var(--border-color);
                            border-radius:4px;padding:2rem;height:100%;
                            transition:all 0.3s ease;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:10px;right:15px;font-family:'Playfair Display',serif;
                                font-size:3rem;font-weight:700;color:var(--border-gold);line-height:1;">
                        <?= $step['number'] ?>
                    </div>
                    <div style="width:50px;height:50px;background:var(--accent-gold-dim);
                                border:1px solid var(--border-gold);border-radius:50%;
                                display:flex;align-items:center;justify-content:center;
                                margin-bottom:1rem;">
                        <i class="bi <?= $step['icon'] ?>"
                           style="color:var(--accent-gold);font-size:1.2rem;"></i>
                    </div>
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:0.75rem;"><?= $step['title'] ?></h5>
                    <p style="font-size:0.875rem;color:var(--text-secondary);margin:0;">
                        <?= $step['text'] ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Related Projects -->
<?php if (!empty($projects)) : ?>
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Our Work</span>
            <h2 class="section-title">Supervised <span>Projects</span></h2>
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
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="cta-section section-padding">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Get Started</span>
            <h2 class="cta-title">Need a Professional <span>Supervisor?</span></h2>
            <p class="cta-text">
                Let us protect your investment and ensure your project is
                built to the highest standards.
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