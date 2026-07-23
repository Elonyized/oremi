<?php
$constructionObj = new Construction();
$likeObj         = new Like();
$commentObj      = new Comment();

// Get construction ID
$construction_id = (int)($id ?? 0);

if ($construction_id === 0) {
    redirect('?page=constructions');
}

// Get construction data
$construction = $constructionObj->getById($construction_id);

if (!$construction) {
    redirect('?page=constructions');
}

$images       = $constructionObj->getImages($construction_id);
$comments     = $commentObj->getApproved('construction', $construction_id);
$commentCount = $commentObj->getCountForContent('construction', $construction_id);
$likeCount    = $likeObj->getCount('construction', $construction_id);
$hasLiked     = $likeObj->hasLiked('construction', $construction_id, getIPAddress());

$pageTitle = $construction['title'];
require_once '../app/views/layouts/header.php';
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">Under Construction</span>
            <h1 class="page-hero-title"><?= htmlspecialchars($construction['title']) ?></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <a href="<?= SITE_URL ?>/?page=constructions">Constructions</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <?= htmlspecialchars($construction['title']) ?>
            </p>
        </div>
    </div>
</section>

<!-- Construction Detail -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">
        <div class="row g-5">

            <!-- Left - Gallery & Description -->
            <div class="col-lg-8" data-aos="fade-right">

                <!-- Image Gallery -->
                <?php if (!empty($images)) : ?>
                <div class="mb-4">
                    <img src="<?= UPLOAD_URL ?>constructions/<?= $images[0]['image_path'] ?>"
                         alt="<?= htmlspecialchars($construction['title']) ?>"
                         class="gallery-main"
                         id="mainGalleryImage">
                    <?php if (count($images) > 1) : ?>
                    <div class="gallery-thumbs">
                        <?php foreach ($images as $index => $img) : ?>
                        <img src="<?= UPLOAD_URL ?>constructions/<?= $img['image_path'] ?>"
                             alt="Image <?= $index + 1 ?>"
                             class="gallery-thumb <?= $index === 0 ? 'active' : '' ?>"
                             data-src="<?= UPLOAD_URL ?>constructions/<?= $img['image_path'] ?>">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Progress Bar -->
                <div class="admin-form-card mb-4">
                    <h4 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:1rem;">Construction Progress</h4>
                    <div class="gold-line" style="margin-bottom:1.5rem;"></div>
                    <div class="progress-label">
                        <span style="font-weight:600;color:var(--text-primary);">
                            Overall Completion
                        </span>
                        <span style="font-weight:700;color:var(--accent-gold);">
                            <?= $construction['progress_percent'] ?>%
                        </span>
                    </div>
                    <div class="progress-custom" style="height:12px;">
                        <div class="progress-bar-custom"
                             style="width:<?= $construction['progress_percent'] ?>%">
                        </div>
                    </div>
                    <?php if ($construction['expected_completion']) : ?>
                    <p style="font-size:0.875rem;color:var(--text-muted);margin-top:0.75rem;">
                        <i class="bi bi-calendar me-1"></i>
                        Expected completion: 
                        <strong style="color:var(--text-primary);">
                            <?= formatDate($construction['expected_completion']) ?>
                        </strong>
                    </p>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div class="admin-form-card mb-4">
                    <h3 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:1rem;">About This Project</h3>
                    <div class="gold-line"></div>
                    <p style="color:var(--text-secondary);line-height:1.9;margin-top:1rem;">
                        <?= nl2br(htmlspecialchars($construction['description'])) ?>
                    </p>
                </div>

                <!-- Like & Share -->
                <div style="display:flex;align-items:center;gap:1rem;
                            margin-bottom:2rem;flex-wrap:wrap;">
                    <button class="like-btn <?= $hasLiked ? 'liked' : '' ?>"
                            data-type="construction"
                            data-id="<?= $construction_id ?>">
                        <i class="bi bi-heart<?= $hasLiked ? '-fill' : '' ?>"></i>
                        <span class="like-count"><?= $likeCount ?></span>
                        <?= $hasLiked ? 'Liked' : 'Like' ?>
                    </button>
                    <span style="color:var(--text-muted);font-size:0.875rem;">
                        <i class="bi bi-chat me-1"></i><?= $commentCount ?> Comments
                    </span>
                    <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=I'm interested in this project: <?= urlencode($construction['title']) ?>"
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
                        <input type="hidden" name="content_type" value="construction">
                        <input type="hidden" name="content_id" value="<?= $construction_id ?>">

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

            <!-- Right - Construction Info -->
            <div class="col-lg-4" data-aos="fade-left">

                <!-- Construction Details -->
                <div class="detail-meta-card mb-4">
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:1rem;">Project Details</h5>
                    <div class="gold-line" style="margin-bottom:1rem;"></div>

                    <div class="detail-meta-item">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <span class="detail-meta-label">Location</span>
                            <span class="detail-meta-value">
                                <?= htmlspecialchars($construction['location']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="detail-meta-item">
                        <i class="bi bi-bar-chart"></i>
                        <div>
                            <span class="detail-meta-label">Progress</span>
                            <span class="detail-meta-value">
                                <?= $construction['progress_percent'] ?>% Complete
                            </span>
                        </div>
                    </div>

                    <?php if ($construction['expected_completion']) : ?>
                    <div class="detail-meta-item">
                        <i class="bi bi-calendar-check"></i>
                        <div>
                            <span class="detail-meta-label">Expected Completion</span>
                            <span class="detail-meta-value">
                                <?= formatDate($construction['expected_completion']) ?>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="detail-meta-item">
                        <i class="bi bi-calendar"></i>
                        <div>
                            <span class="detail-meta-label">Date Started</span>
                            <span class="detail-meta-value">
                                <?= formatDate($construction['created_at']) ?>
                            </span>
                        </div>
                    </div>

                </div>

                <!-- CTA Card -->
                <div class="detail-meta-card"
                     style="background:var(--accent-gold-dim);
                            border-color:var(--border-gold);text-align:center;">
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:0.5rem;">Interested in this project?</h5>
                    <p style="color:var(--text-secondary);font-size:0.875rem;
                              margin-bottom:1.5rem;">
                        Contact us to discuss a similar build for you.
                    </p>
                    <a href="<?= SITE_URL ?>/?page=contact" class="btn btn-gold w-100 mb-2">
                        <i class="bi bi-envelope me-2"></i>Contact Us
                    </a>
                    <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>"
                       class="btn btn-whatsapp w-100" target="_blank">
                        <i class="bi bi-whatsapp me-2"></i>WhatsApp
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>