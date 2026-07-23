<?php
adminGuard();

$commentObj = new Comment();
$comments   = $commentObj->getAll();
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments | <?= SITE_NAME ?> Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body class="admin-body">

<?php require_once '../app/views/admin/includes/sidebar.php'; ?>

<div class="admin-main">

    <?php require_once '../app/views/admin/includes/topbar.php'; ?>

    <div class="admin-content">

        <!-- Page Header -->
        <div class="admin-page-header">
            <div>
                <h1 class="admin-page-title">Comments</h1>
                <p class="admin-page-subtitle">Moderate and manage all comments</p>
            </div>
        </div>

        <!-- Flash Message -->
        <?php $flash = getFlash(); if ($flash) : ?>
            <div class="flash-message flash-<?= $flash['type'] ?>">
                <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <!-- Comments Table -->
        <div class="admin-section-card">
            <div class="admin-section-header">
                <h5 class="admin-section-title">
                    <i class="bi bi-chat-dots me-2"></i>All Comments
                    <span style="color:var(--text-muted);font-weight:400;font-size:0.85rem;">
                        (<?= count($comments) ?>)
                    </span>
                </h5>
                <input
                    type="text"
                    id="tableSearch"
                    class="admin-form-control"
                    placeholder="Search comments..."
                    style="width:220px;">
            </div>

            <div class="admin-section-body" style="padding:0;">
                <?php if (!empty($comments)) : ?>
                <div style="overflow-x:auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Comment</th>
                                <th>On</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comments as $index => $comment) : ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <span style="font-weight:500;color:var(--text-primary);">
                                        <?= htmlspecialchars($comment['name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size:0.8rem;color:var(--text-secondary);">
                                        <?= htmlspecialchars($comment['email']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size:0.85rem;color:var(--text-secondary);">
                                        <?= truncate($comment['comment'], 60) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-gold">
                                        <?= ucfirst($comment['content_type']) ?> #<?= $comment['content_id'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($comment['is_approved']) : ?>
                                        <span class="badge-available">Approved</span>
                                    <?php else : ?>
                                        <span class="badge-rent">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= formatDate($comment['created_at']) ?></td>
                                <td>
                                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                        <?php if (!$comment['is_approved']) : ?>
                                        <form method="POST"
                                              action="<?= SITE_URL ?>/?page=admin-comments-approve"
                                              style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                            <button type="submit" class="btn-admin-approve">
                                                <i class="bi bi-check-lg"></i>Approve
                                            </button>
                                        </form>
                                        <?php else : ?>
                                        <form method="POST"
                                              action="<?= SITE_URL ?>/?page=admin-comments-approve"
                                              style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                            <input type="hidden" name="unapprove" value="1">
                                            <button type="submit" class="btn-admin-view">
                                                <i class="bi bi-x-lg"></i>Unapprove
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                        <form method="POST"
                                              action="<?= SITE_URL ?>/?page=admin-comments-delete"
                                              class="delete-form"
                                              style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                            <button type="submit" class="btn-admin-delete">
                                                <i class="bi bi-trash"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else : ?>
                    <div class="admin-empty-state">
                        <i class="bi bi-chat-dots"></i>
                        <h5>No Comments Yet</h5>
                        <p>No one has commented on any content yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/admin.js"></script>

</body>
</html>