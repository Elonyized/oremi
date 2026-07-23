<?php
$interiorObj = new Interior();
$likeObj     = new Like();
$commentObj  = new Comment();

// Get interior ID
$interior_id = (int)($id ?? 0);

if ($interior_id === 0) {
    redirect('?page=interiors');
}

// Get interior data
$interior = $interiorObj->getById($interior_id);

if (!$interior) {
    redirect('?page=interiors');
}

$images       = $interiorObj->getImages($interior_id);
$comments     = $commentObj->getApproved('interior', $interior_id);
$commentCount = $commentObj->getCountForContent('interior', $interior_id);
$likeCount    = $likeObj->getCount('interior', $interior_id);
$hasLiked     = $likeObj->hasLiked('interior', $interior_id, getIPAddress());

$pageTitle = $interior['title'];
require_once '../app/views/layouts/header.php';
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label">
                <?= $interior['style'] ? htmlspecialchars($interior['style']) . ' Design' : 'Interior Design' ?>
            </span>
            <h1 class="page-hero-title"><?= htmlspecialchars($interior['title']) ?></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <a href="<?= SITE_URL ?>/?page=interiors">Interiors</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <?= htmlspecialchars($interior['title']) ?>
            </p>
        </div>
    </div>
</section>

<!-- Interior Detail -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">
        <div class="row g-5">

            <!-- Left - Gallery & Description -->
            <div class="col-lg-8" data-aos="fade-right">

                <!-- Image Gallery -->
                <?php if (!empty($images)) : ?>
                <div class="mb-4">
                    <img src="<?= UPLOAD_URL ?>interiors/<?= $images[0]['image_path'] ?>"
                         alt="<?= htmlspecialchars($interior['title']) ?>"
                         class="gallery-main"
                         id="mainGalleryImage">
                    <?php if (count($images) > 1) : ?>
                    <div class="gallery-thumbs">
                        <?php foreach ($images as $index => $img) : ?>
                        <img src="<?= UPLOAD_URL ?>interiors/<?= $img['image_path'] ?>"
                             alt="Image <?= $index + 1 ?>"
                             class="gallery-thumb <?= $index === 0 ? 'active' : '' ?>"
                             data-src="<?= UPLOAD_URL ?>interiors/<?= $img['image_path'] ?>">
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
                        <?= nl2br(htmlspecialchars($interior['description'])) ?>
                    </p>
                </div>

                <!-- Like & Share -->
                <div style="display:flex;align-items:center;gap:1rem;
                            margin-bottom:2rem;flex-wrap:wrap;">
                    <button class="like-btn <?= $hasLiked ? 'liked' : '' ?>"
                            data-type="interior"
                            data-id="<?= $interior_id ?>">
                        <i class="bi bi-heart<?= $hasLiked ? '-fill' : '' ?>"></i>
                        <span class="like-count"><?= $likeCount ?></span>
                        <?= $hasLiked ? 'Liked' : 'Like' ?>
                    </button>
                    <span style="color:var(--text-muted);font-size:0.875rem;">
                        <i class="bi bi-chat me-1"></i><?= $commentCount ?> Comments
                    </span>
                    <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=I'm interested in this interior design: <?= urlencode($interior['title']) ?>"
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
                        <input type="hidden" name="content_type" value="interior">
                        <input type="hidden" name="content_id" value="<?= $interior_id ?>">

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

            <!-- Right - Interior Info -->
            <div class="col-lg-4" data-aos="fade-left">

                <!-- Interior Details -->
                <div class="detail-meta-card mb-4">
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:1rem;">Design Details</h5>
                    <div class="gold-line" style="margin-bottom:1rem;"></div>

                    <?php if ($interior['style']) : ?>
                    <div class="detail-meta-item">
                        <i class="bi bi-palette"></i>
                        <div>
                            <span class="detail-meta-label">Style</span>
                            <span class="detail-meta-value">
                                <?= htmlspecialchars($interior['style']) ?>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="detail-meta-item">
                        <i class="bi bi-calendar"></i>
                        <div>
                            <span class="detail-meta-label">Date Added</span>
                            <span class="detail-meta-value">
                                <?= formatDate($interior['created_at']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="detail-meta-item">
                        <i class="bi bi-heart"></i>
                        <div>
                            <span class="detail-meta-label">Likes</span>
                            <span class="detail-meta-value"><?= $likeCount ?></span>
                        </div>
                    </div>

                    <div class="detail-meta-item">
                        <i class="bi bi-chat"></i>
                        <div>
                            <span class="detail-meta-label">Comments</span>
                            <span class="detail-meta-value"><?= $commentCount ?></span>
                        </div>
                    </div>

                </div>

                <!-- CTA Card -->
                <div class="detail-meta-card mb-4"
                     style="background:var(--accent-gold-dim);
                            border-color:var(--border-gold);text-align:center;">
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:0.5rem;">Love this design?</h5>
                    <p style="color:var(--text-secondary);font-size:0.875rem;
                              margin-bottom:1.5rem;">
                        Contact us to get a similar interior design for your space.
                    </p>
                    <a href="<?= SITE_URL ?>/?page=contact" class="btn btn-gold w-100 mb-2">
                        <i class="bi bi-envelope me-2"></i>Contact Us
                    </a>
                    <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>"
                       class="btn btn-whatsapp w-100" target="_blank">
                        <i class="bi bi-whatsapp me-2"></i>WhatsApp
                    </a>
                </div>

                <!-- More Interiors -->
                <?php
                $moreInteriors = $interiorObj->getFeatured(3);
                $moreInteriors = array_filter($moreInteriors, function($i) use ($interior_id) {
                    return $i['id'] != $interior_id;
                });
                $moreInteriors = array_slice($moreInteriors, 0, 2);
                if (!empty($moreInteriors)) :
                ?>
                <div class="detail-meta-card">
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:1rem;">More Interiors</h5>
                    <div class="gold-line" style="margin-bottom:1rem;"></div>
                    <?php foreach ($moreInteriors as $more) :
                        $moreCover = $interiorObj->getCoverImage($more['id']);
                    ?>
                    <div style="display:flex;gap:12px;margin-bottom:1rem;
                                padding-bottom:1rem;border-bottom:1px solid var(--border-color);">
                        <?php if ($moreCover) : ?>
                        <img src="<?= UPLOAD_URL ?>interiors/<?= $moreCover['image_path'] ?>"
                             alt="<?= htmlspecialchars($more['title']) ?>"
                             style="width:70px;height:70px;object-fit:cover;
                                    border-radius:4px;flex-shrink:0;">
                        <?php endif; ?>
                        <div>
                            <a href="<?= SITE_URL ?>/?page=interior-detail&id=<?= $more['id'] ?>"
                               style="font-size:0.875rem;font-weight:600;
                                      color:var(--text-primary);display:block;margin-bottom:4px;">
                                <?= htmlspecialchars($more['title']) ?>
                            </a>
                            <?php if ($more['style']) : ?>
                            <span style="font-size:0.775rem;color:var(--accent-gold);">
                                <?= htmlspecialchars($more['style']) ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>