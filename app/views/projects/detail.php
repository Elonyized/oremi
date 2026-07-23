<?php
$projectObj = new Project();
$likeObj    = new Like();
$commentObj = new Comment();

// Get project ID
$project_id = (int)($id ?? 0);

if ($project_id === 0) {
    redirect('?page=projects');
}

// Get project data
$project = $projectObj->getById($project_id);

if (!$project) {
    redirect('?page=projects');
}

$images        = $projectObj->getImages($project_id);
$comments      = $commentObj->getApproved('project', $project_id);
$commentCount  = $commentObj->getCountForContent('project', $project_id);
$likeCount     = $likeObj->getCount('project', $project_id);
$hasLiked      = $likeObj->hasLiked('project', $project_id, getIPAddress());
$relatedProjects = $projectObj->getByCategory($project['category_name'] ?? '', 3);

$pageTitle = $project['title'];
require_once '../app/views/layouts/header.php';
?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="section-label"><?= htmlspecialchars($project['category_name']) ?></span>
            <h1 class="page-hero-title"><?= htmlspecialchars($project['title']) ?></h1>
            <div class="gold-line-center"></div>
            <p class="page-hero-breadcrumb">
                <a href="<?= SITE_URL ?>/?page=home">Home</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <a href="<?= SITE_URL ?>/?page=projects">Projects</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <?= htmlspecialchars($project['title']) ?>
            </p>
        </div>
    </div>
</section>

<!-- Project Detail -->
<section class="section-padding" style="background-color:var(--bg-primary);">
    <div class="container">
        <div class="row g-5">

            <!-- Left - Gallery & Description -->
            <div class="col-lg-8" data-aos="fade-right">

                <!-- Image Gallery -->
                <?php if (!empty($images)) : ?>
                <div class="mb-4">
                    <img src="<?= UPLOAD_URL ?>projects/<?= $images[0]['image_path'] ?>"
                         alt="<?= htmlspecialchars($project['title']) ?>"
                         class="gallery-main"
                         id="mainGalleryImage">
                    <?php if (count($images) > 1) : ?>
                    <div class="gallery-thumbs">
                        <?php foreach ($images as $index => $img) : ?>
                        <img src="<?= UPLOAD_URL ?>projects/<?= $img['image_path'] ?>"
                             alt="Image <?= $index + 1 ?>"
                             class="gallery-thumb <?= $index === 0 ? 'active' : '' ?>"
                             data-src="<?= UPLOAD_URL ?>projects/<?= $img['image_path'] ?>">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Description -->
                <div class="admin-form-card mb-4">
                    <h3 style="font-family:'Playfair Display',serif;color:var(--text-primary);margin-bottom:1rem;">
                        About This Project
                    </h3>
                    <div class="gold-line"></div>
                    <p style="color:var(--text-secondary);line-height:1.9;margin-top:1rem;">
                        <?= nl2br(htmlspecialchars($project['description'])) ?>
                    </p>
                </div>

                <!-- Like & Share -->
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
                    <button class="like-btn <?= $hasLiked ? 'liked' : '' ?>"
                            data-type="project"
                            data-id="<?= $project_id ?>">
                        <i class="bi bi-heart<?= $hasLiked ? '-fill' : '' ?>"></i>
                        <span class="like-count"><?= $likeCount ?></span>
                        <?= $hasLiked ? 'Liked' : 'Like' ?>
                    </button>
                    <span style="color:var(--text-muted);font-size:0.875rem;">
                        <i class="bi bi-chat me-1"></i><?= $commentCount ?> Comments
                    </span>
                    <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=I'm interested in this project: <?= urlencode($project['title']) ?>"
                       class="btn btn-whatsapp btn-sm" target="_blank">
                        <i class="bi bi-whatsapp me-1"></i>Inquire on WhatsApp
                    </a>
                </div>

                <!-- Comments Section -->
                <div class="admin-form-card">
                    <h4 style="font-family:'Playfair Display',serif;color:var(--text-primary);margin-bottom:1.5rem;">
                        Comments (<?= $commentCount ?>)
                    </h4>

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
                        <p style="color:var(--text-muted);font-size:0.875rem;margin-bottom:1.5rem;">
                            No comments yet. Be the first to comment.
                        </p>
                    <?php endif; ?>

                    <!-- Comment Form -->
                    <h5 style="font-family:'Poppins',sans-serif;font-size:1rem;font-weight:600;
                               color:var(--text-primary);margin-top:2rem;margin-bottom:1rem;">
                        Leave a Comment
                    </h5>
                    <form method="POST" action="<?= SITE_URL ?>/?page=comment">
                        <input type="hidden" name="content_type" value="project">
                        <input type="hidden" name="content_id" value="<?= $project_id ?>">

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

            <!-- Right - Project Info -->
            <div class="col-lg-4" data-aos="fade-left">

                <!-- Project Details -->
                <div class="detail-meta-card mb-4">
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:1rem;">Project Details</h5>
                    <div class="gold-line" style="margin-bottom:1rem;"></div>

                    <div class="detail-meta-item">
                        <i class="bi bi-folder"></i>
                        <div>
                            <span class="detail-meta-label">Category</span>
                            <span class="detail-meta-value">
                                <?= htmlspecialchars($project['category_name']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="detail-meta-item">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <span class="detail-meta-label">Location</span>
                            <span class="detail-meta-value">
                                <?= htmlspecialchars($project['location']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="detail-meta-item">
                        <i class="bi bi-check-circle"></i>
                        <div>
                            <span class="detail-meta-label">Status</span>
                            <span class="detail-meta-value">
                                <?= ucfirst($project['status']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="detail-meta-item">
                        <i class="bi bi-calendar"></i>
                        <div>
                            <span class="detail-meta-label">Date Added</span>
                            <span class="detail-meta-value">
                                <?= formatDate($project['created_at']) ?>
                            </span>
                        </div>
                    </div>

                </div>

                <!-- CTA Card -->
                <div class="detail-meta-card mb-4"
                     style="background:var(--accent-gold-dim);border-color:var(--border-gold);text-align:center;">
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:0.5rem;">Interested in this project?</h5>
                    <p style="color:var(--text-secondary);font-size:0.875rem;margin-bottom:1.5rem;">
                        Contact us to discuss something similar for you.
                    </p>
                    <a href="<?= SITE_URL ?>/?page=contact" class="btn btn-gold w-100 mb-2">
                        <i class="bi bi-envelope me-2"></i>Contact Us
                    </a>
                    <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>"
                       class="btn btn-whatsapp w-100" target="_blank">
                        <i class="bi bi-whatsapp me-2"></i>WhatsApp
                    </a>
                </div>

                <!-- Related Projects -->
                <?php
                $related = array_filter($relatedProjects, function($p) use ($project_id) {
                    return $p['id'] != $project_id;
                });
                $related = array_slice($related, 0, 2);
                if (!empty($related)) :
                ?>
                <div class="detail-meta-card">
                    <h5 style="font-family:'Playfair Display',serif;color:var(--text-primary);
                               margin-bottom:1rem;">Related Projects</h5>
                    <div class="gold-line" style="margin-bottom:1rem;"></div>
                    <?php foreach ($related as $rel) :
                        $relCover = $projectObj->getCoverImage($rel['id']);
                    ?>
                    <div style="display:flex;gap:12px;margin-bottom:1rem;
                                padding-bottom:1rem;border-bottom:1px solid var(--border-color);">
                        <?php if ($relCover) : ?>
                        <img src="<?= UPLOAD_URL ?>projects/<?= $relCover['image_path'] ?>"
                             alt="<?= htmlspecialchars($rel['title']) ?>"
                             style="width:70px;height:70px;object-fit:cover;border-radius:4px;flex-shrink:0;">
                        <?php endif; ?>
                        <div>
                            <a href="<?= SITE_URL ?>/?page=project-detail&id=<?= $rel['id'] ?>"
                               style="font-size:0.875rem;font-weight:600;color:var(--text-primary);
                                      display:block;margin-bottom:4px;">
                                <?= htmlspecialchars($rel['title']) ?>
                            </a>
                            <span style="font-size:0.775rem;color:var(--text-muted);">
                                <?= htmlspecialchars($rel['location']) ?>
                            </span>
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