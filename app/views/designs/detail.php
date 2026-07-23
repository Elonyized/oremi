<?php
$designObj  = new Design();
$likeObj    = new Like();
$commentObj = new Comment();

// Get design ID
$design_id = (int)($id ?? 0);

if ($design_id === 0) {
    redirect('?page=designs');
}

// Get design data
$design = $designObj->getById($design_id);

if (!$design) {
    redirect('?page=designs');
}

$images       = $designObj->getImages($design_id);
$comments     = $commentObj->getApproved('design', $design_id);
$commentCount = $commentObj->getCountForContent('design', $design_id);
$likeCount    = $likeObj->getCount('design', $design_id);
$hasLiked     = $likeObj->hasLiked('design', $design_id, getIPAddress());

$pageTitle = $design['title'];
require_once '../app/views/layouts/header.php';
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Architectural Design</span>
            <h1 class="page-hero-title"><?= htmlspecialchars($design['title']) ?></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <a href="<?= SITE_URL ?>/?page=designs">Designs</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <?= htmlspecialchars($design['title']) ?>
            </p>
        </div>
    </div>
</section>

<!-- Design Detail -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">
        <div class="row g-5">

            <!-- Left - Gallery & Description -->
            <div class="col-lg-8" data-aos="fade-right">

                <!-- Image Gallery -->
                <?php if (!empty($images)) : ?>
                <div class="mb-4">
                    <img src="<?= UPLOAD_URL ?>designs/<?= $images[0]['image_path'] ?>"
                         alt="<?= htmlspecialchars($design['title']) ?>"
                         class="gallery-main"
                         id="mainGalleryImage">
                    <?php if (count($images) > 1) : ?>
                    <div class="gallery-thumbs">
                        <?php foreach ($images as $index => $img) : ?>
                        <img src="<?= UPLOAD_URL ?>designs/<?= $img['image_path'] ?>"
                             alt="Image <?= $index + 1 ?>"
                             class="gallery-thumb <?= $index === 0 ? 'active' : '' ?>"
                             data-src="<?= UPLOAD_URL ?>designs/<?= $img['image_path'] ?>">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Description -->
                <div class="admin-form-card mb-4">
                    <h3 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:1rem;">About This Design</h3>
                    <div class="gold-line"></div>
                    <p style="color:var(--text-secondary);line-height:1.9;margin-top:1rem;">
                        <?= nl2br(htmlspecialchars($design['description'])) ?>
                    </p>
                </div>

                <!-- PDF Download -->
                <?php if ($design['pdf_path']) : ?>
                <div class="admin-form-card mb-4"
                     style="background:var(--accent-gold-dim);border-color:var(--border-gold);">
                    <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
                        <div style="width:50px;height:50px;background:var(--accent-gold);
                                    border-radius:4px;display:flex;align-items:center;
                                    justify-content:center;flex-shrink:0;">
                            <i class="bi bi-file-pdf"
                               style="font-size:1.5rem;color:#0D0D0D;"></i>
                        </div>
                        <div style="flex:1;">
                            <h6 style="color:var(--text-primary);margin:0 0 4px;">
                                Design Plan PDF Available
                            </h6>
                            <p style="color:var(--text-secondary);font-size:0.875rem;margin:0;">
                                Download or view the full architectural plan document.
                            </p>
                        </div>
                        <a href="<?= UPLOAD_URL ?>pdfs/<?= $design['pdf_path'] ?>"
                           class="btn btn-gold"
                           target="_blank">
                            <i class="bi bi-download me-2"></i>View PDF
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Like & Share -->
                <div style="display:flex;align-items:center;gap:1rem;
                            margin-bottom:2rem;flex-wrap:wrap;">
                    <button class="like-btn <?= $hasLiked ? 'liked' : '' ?>"
                            data-type="design"
                            data-id="<?= $design_id ?>">
                        <i class="bi bi-heart<?= $hasLiked ? '-fill' : '' ?>"></i>
                        <span class="like-count"><?= $likeCount ?></span>
                        <?= $hasLiked ? 'Liked' : 'Like' ?>
                    </button>
                    <span style="color:var(--text-muted);font-size:0.875rem;">
                        <i class="bi bi-chat me-1"></i><?= $commentCount ?> Comments
                    </span>
                    <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=I'm interested in this design: <?= urlencode($design['title']) ?>"
                       class="btn btn-whatsapp btn-sm" target="_blank">
                        <i class="bi bi-whatsapp me-1"></i>Inquire on WhatsApp
                    </a>
                </div>

                <!-- Comments Section -->
                <div class="admin-form-card">
                    <h4 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:1.5rem;">
                        Comments (<?= $commentCount ?>)
                    </h4>

                    <!-- Flash Message -->
                    <?php $flash = getFlash(); if ($flash) : ?>
                        <div class="flash-message flash-<?= $flash['type'] ?> mb-4">
                            <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                            <?= $flash['message'] ?>
                        </div>
                    <?php endif; ?>

                    <!-- Existing Comments -->
                    <?php if (!empty($comments)) : ?>
                        <?php foreach ($comments as $comment) : ?>
                        <div class="comment-card">
                            <div class="comment-author">
                                <i class="bi bi-person-circle me-2"
                                   style="color:var(--accent-gold);"></i>
                                <?= htmlspecialchars($comment['name']) ?>
                            </div>
                            <div class="comment-date">
                                <?= formatDate($comment['created_at']) ?>
                            </div>
                            <p class="comment-text">
                                <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                            </p>
                        </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p style="color:var(--text-muted);font-size:0.875rem;
                                  margin-bottom:1.5rem;">
                            No comments yet. Be the first to comment.
                        </p>
                    <?php endif; ?>

                    <!-- Comment Form -->
                    <h5 style="font-family:'Poppins',sans-serif;font-size:1rem;font-weight:600;
                               color:var(--text-primary);margin-top:2rem;margin-bottom:1rem;">
                        Leave a Comment
                    </h5>
                    <form method="POST" action="<?= SITE_URL ?>/?page=comment">
                        <input type="hidden" name="content_type" value="design">
                        <input type="hidden" name="content_id" value="<?= $design_id ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">
                                        Name <span style="color:var(--error);">*</span>
                                    </label>
                                    <input type="text"
                                           name="name"
                                           class="form-control-custom"
                                           placeholder="Your name"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">
                                        Email <span style="color:var(--error);">*</span>
                                    </label>
                                    <input type="email"
                                           name="email"
                                           class="form-control-custom"
                                           placeholder="Your email"
                                           required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">
                                        Comment <span style="color:var(--error);">*</span>
                                    </label>
                                    <textarea name="comment"
                                              class="form-control-custom"
                                              rows="4"
                                              placeholder="Write your comment..."
                                              required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit"
                                        name="submit_comment"
                                        class="btn btn-gold">
                                    <i class="bi bi-send me-2"></i>Post Comment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Right - Design Info -->
            <div class="col-lg-4" data-aos="fade-left">

                <!-- Price Card -->
                <div class="detail-meta-card mb-4"
                     style="text-align:center;background:var(--accent-gold-dim);
                            border-color:var(--border-gold);">
                    <?php if ($design['price'] > 0) : ?>
                        <span style="font-size:0.8rem;color:var(--text-muted);
                                     text-transform:uppercase;letter-spacing:2px;">
                            Design Price
                        </span>
                        <div style="font-family:'Playfair Display',serif;font-size:2rem;
                                    font-weight:700;color:var(--accent-gold);margin:0.5rem 0;">
                            <?= formatPrice($design['price']) ?>
                        </div>
                    <?php else : ?>
                        <span style="font-size:0.8rem;color:var(--text-muted);
                                     text-transform:uppercase;letter-spacing:2px;">
                            Price
                        </span>
                        <div style="font-family:'Playfair Display',serif;font-size:1.5rem;
                                    font-weight:700;color:var(--accent-gold);margin:0.5rem 0;">
                            On Inquiry
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Design Details -->
                <div class="detail-meta-card mb-4">
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:1rem;">Design Details</h5>
                    <div class="gold-line" style="margin-bottom:1rem;"></div>

                    <div class="detail-meta-item">
                        <i class="bi bi-file-pdf"></i>
                        <div>
                            <span class="detail-meta-label">PDF Plan</span>
                            <span class="detail-meta-value">
                                <?= $design['pdf_path'] ? 'Available' : 'Not Available' ?>
                            </span>
                        </div>
                    </div>

                    <div class="detail-meta-item">
                        <i class="bi bi-calendar"></i>
                        <div>
                            <span class="detail-meta-label">Date Added</span>
                            <span class="detail-meta-value">
                                <?= formatDate($design['created_at']) ?>
                            </span>
                        </div>
                    </div>

                </div>

                <!-- CTA Card -->
                <div class="detail-meta-card"
                     style="text-align:center;">
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:0.5rem;">Interested in this design?</h5>
                    <p style="color:var(--text-secondary);font-size:0.875rem;
                              margin-bottom:1.5rem;">
                        Contact us to inquire about this design or request a custom one.
                    </p>
                    <a href="<?= SITE_URL ?>/?page=contact" class="btn btn-gold w-100 mb-2">
                        <i class="bi bi-envelope me-2"></i>Contact Us
                    </a>
                    <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=I'm interested in this design: <?= urlencode($design['title']) ?>"
                       class="btn btn-whatsapp w-100" target="_blank">
                        <i class="bi bi-whatsapp me-2"></i>WhatsApp
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>