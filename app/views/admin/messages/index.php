<?php
adminGuard();

$messageObj = new ContactMessage();
$messages   = $messageObj->getAll();
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | <?= SITE_NAME ?> Admin</title>

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
                <h1 class="admin-page-title">Messages</h1>
                <p class="admin-page-subtitle">Contact form submissions from visitors</p>
            </div>
            <!-- Mark All Read -->
            <form method="POST"
                  action="<?= SITE_URL ?>/?page=admin-messages"
                  style="margin:0;">
                <input type="hidden" name="mark_all_read" value="1">
                <button type="submit" class="btn btn-gold-outline">
                    <i class="bi bi-check-all me-2"></i>Mark All Read
                </button>
            </form>
        </div>

        <!-- Flash Message -->
        <?php $flash = getFlash(); if ($flash) : ?>
            <div class="flash-message flash-<?= $flash['type'] ?>">
                <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <!-- Messages Table -->
        <div class="admin-section-card">
            <div class="admin-section-header">
                <h5 class="admin-section-title">
                    <i class="bi bi-envelope me-2"></i>All Messages
                    <span style="color:var(--text-muted);font-weight:400;font-size:0.85rem;">
                        (<?= count($messages) ?>)
                    </span>
                </h5>
                <input
                    type="text"
                    id="tableSearch"
                    class="admin-form-control"
                    placeholder="Search messages..."
                    style="width:220px;">
            </div>

            <div class="admin-section-body" style="padding:0;">
                <?php if (!empty($messages)) : ?>
                <div style="overflow-x:auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $index => $msg) : ?>
                            <tr style="<?= !$msg['is_read'] ? 'background-color:var(--accent-gold-dim);' : '' ?>">
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <span style="font-weight:<?= !$msg['is_read'] ? '600' : '400' ?>;color:var(--text-primary);">
                                        <?= htmlspecialchars($msg['name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars($msg['email']) ?>"
                                       style="font-size:0.8rem;color:var(--accent-gold);">
                                        <?= htmlspecialchars($msg['email']) ?>
                                    </a>
                                </td>
                                <td>
                                    <span style="font-size:0.8rem;color:var(--text-secondary);">
                                        <?= $msg['phone'] ? htmlspecialchars($msg['phone']) : '—' ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size:0.85rem;color:var(--text-secondary);">
                                        <?= truncate($msg['message'], 60) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($msg['is_read']) : ?>
                                        <span class="badge-available">Read</span>
                                    <?php else : ?>
                                        <span class="badge-rent">Unread</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= formatDate($msg['created_at']) ?></td>
                                <td>
                                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                        <a href="<?= SITE_URL ?>/?page=admin-messages-view&id=<?= $msg['id'] ?>"
                                           class="btn-admin-view">
                                            <i class="bi bi-eye"></i>View
                                        </a>
                                        <form method="POST"
                                              action="<?= SITE_URL ?>/?page=admin-messages"
                                              class="delete-form"
                                              style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                                            <input type="hidden" name="delete_message" value="1">
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
                        <i class="bi bi-envelope"></i>
                        <h5>No Messages Yet</h5>
                        <p>No one has sent a message yet.</p>
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