<?php
$pageTitle = 'Contact Us';
require_once '../app/views/layouts/header.php';
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Get In Touch</span>
            <h1 class="page-hero-title">Contact <span>Us</span></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                Contact
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">
        <div class="row g-5">

            <!-- Left - Contact Form -->
            <div class="col-lg-7" data-aos="fade-right">
                <span class="section-label">Send A Message</span>
                <h2 class="section-title">Let's <span>Talk</span></h2>
                <div class="gold-line"></div>
                <p style="color:var(--text-secondary);margin-bottom:2rem;">
                    Have a project in mind or want to inquire about our services?
                    Fill in the form below and we will get back to you as soon as possible.
                </p>

                <!-- Flash Message -->
                <?php
                    $flash = getFlash();
                    if ($flash) :
                ?>
                    <div class="flash-message flash-<?= $flash['type'] ?> mb-4">
                        <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                        <?= $flash['message'] ?>
                    </div>
                <?php endif; ?>

                <!-- Contact Form -->
                <form method="POST"
                      action="<?= SITE_URL ?>/?page=contact">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    Full Name <span style="color:var(--error);">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control-custom"
                                    placeholder="Your full name"
                                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    Email Address <span style="color:var(--error);">*</span>
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control-custom"
                                    placeholder="Your email address"
                                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                    required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Phone Number</label>
                                <input
                                    type="tel"
                                    name="phone"
                                    class="form-control-custom"
                                    placeholder="Your phone number (optional)"
                                    value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    Message <span style="color:var(--error);">*</span>
                                </label>
                                <textarea
                                    name="message"
                                    class="form-control-custom"
                                    rows="6"
                                    placeholder="Tell us about your project or inquiry..."
                                    required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit"
                                    name="submit_contact"
                                    class="btn btn-gold">
                                <i class="bi bi-send me-2"></i>Send Message
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Right - Contact Info -->
            <div class="col-lg-5" data-aos="fade-left">
                <span class="section-label">Our Details</span>
                <h2 class="section-title">Find <span>Us</span></h2>
                <div class="gold-line"></div>

                <div class="contact-info-card mt-4">

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div class="contact-info-text">
                            <h6>Our Location</h6>
                            <p>Otukpo, Benue State, Nigeria</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div class="contact-info-text">
                            <h6>Phone Number</h6>
                            <p>+234 XXX XXX XXXX</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div class="contact-info-text">
                            <h6>Email Address</h6>
                            <p>info@oremi.com</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div class="contact-info-text">
                            <h6>Working Hours</h6>
                            <p>Monday - Saturday: 8:00am - 6:00pm</p>
                        </div>
                    </div>

                </div>

                <!-- WhatsApp CTA -->
                <div class="whatsapp-cta mt-4">
                    <p>Prefer to chat directly?</p>
                    <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>"
                       class="btn btn-whatsapp"
                       target="_blank">
                        <i class="bi bi-whatsapp me-2"></i>Chat on WhatsApp
                    </a>
                </div>

                <!-- Social Links -->
                <div class="mt-4">
                    <h6 style="color:var(--text-secondary);font-size:0.875rem;margin-bottom:1rem;">
                        Follow Us
                    </h6>
                    <div class="footer-socials">
                        <a href="#" class="social-link" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link" title="Twitter">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="#" class="social-link" title="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>