<?php
adminGuard();

$messageObj = new ContactMessage();

// Get message ID
$message_id = (int)($id ?? 0);

if ($message_id === 0) {
    setFlash('error', 'Invalid message ID.');
    redirect('?page=admin-messages');
}

// Get message data
$message = $messageObj->getById($message_id);

if (!$message) {
    setFlash('error', 'Message not found.');
    redirect('?page=admin-messages');
}

// Mark as read automatically when viewed
if (!$message['is_read']) {
    $messageObj->markRead($message_id);
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Message | <?= SITE_NAME ?> Admin</title>

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
                <h1 class="admin-page-title">View Message</h1>
                <p class="admin-page-subtitle">
                    From: <?= htmlspecialchars($message['name']) ?>
                </p>
            </div>
            <a href="<?= SITE_URL ?>/?page=admin-messages" class="btn btn-gold-outline">
                <i class="bi bi-arrow-left me-2"></i>Back to Messages
            </a>
        </div>

        <div class="row g-4">

            <!-- Message Content -->
            <div class="col-lg-8">
                <div class="admin-form-card">
                    <h5 class="admin-section-title mb-4">
                        <i class="bi bi-envelope-open me-2"></i>Message
                    </h5>

                    <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-left:3px solid var(--accent-gold);border-radius:4px;padding:1.5rem;">
                        <p style="color:var(--text-primary);font-size:0.95rem;line-height:1.8;margin:0;">
                            <?= nl2br(htmlspecialchars($message['message'])) ?>
                        </p>
                    </div>

                    <!-- Reply via Email -->
                    <div class="mt-4">
                        <a href="mailto:<?= htmlspecialchars($message['email']) ?>?subject=Re: Your Inquiry&body=Dear <?= htmlspecialchars($message['name']) ?>,"
                           class="btn btn-gold">
                            <i class="bi bi-reply me-2"></i>Reply via Email
                        </a>
                        <?php if ($message['phone']) : ?>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $message['phone']) ?>"
                           class="btn btn-whatsapp ms-2"
                           target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Reply on WhatsApp
                        </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <!-- Sender Info -->
            <div class="col-lg-4">
                <div class="admin-form-card mb-4">
                    <h5 class="admin-section-title mb-4">
                        <i class="bi bi-person me-2"></i>Sender Details
                    </h5>

                    <ul style="list-style:none;padding:0;margin:0;">
                        <li style="padding:12px 0;border-bottom:1px solid var(--border-color);">
                            <span style="font-size:0.75rem;color:var(--text-muted);display:block;margin-bottom:4px;">
                                Full Name
                            </span>
                            <span style="font-weight:600;color:var(--text-primary);">
                                <?= htmlspecialchars($message['name']) ?>
                            </span>
                        </li>
                        <li style="padding:12px 0;border-bottom:1px solid var(--border-color);">
                            <span style="font-size:0.75rem;color:var(--text-muted);display:block;margin-bottom:4px;">
                                Email Address
                            </span>
                            <a href="mailto:<?= htmlspecialchars($message['email']) ?>"
                               style="color:var(--accent-gold);font-size:0.875rem;">
                                <?= htmlspecialchars($message['email']) ?>
                            </a>
                        </li>
                        <li style="padding:12px 0;border-bottom:1px solid var(--border-color);">
                            <span style="font-size:0.75rem;color:var(--text-muted);display:block;margin-bottom:4px;">
                                Phone Number
                            </span>
                            <span style="color:var(--text-primary);font-size:0.875rem;">
                                <?= $message['phone'] ? htmlspecialchars($message['phone']) : '—' ?>
                            </span>
                        </li>
                        <li style="padding:12px 0;border-bottom:1px solid var(--border-color);">
                            <span style="font-size:0.75rem;color:var(--text-muted);display:block;margin-bottom:4px;">
                                Date Sent
                            </span>
                            <span style="color:var(--text-primary);font-size:0.875rem;">
                                <?= formatDate($message['created_at']) ?>
                            </span>
                        </li>
                        <li style="padding:12px 0;">
                            <span style="font-size:0.75rem;color:var(--text-muted);display:block;margin-bottom:4px;">
                                Status
                            </span>
                            <span class="badge-available">Read</span>
                        </li>
                    </ul>

                </div>

                <!-- Actions -->
                <div class="admin-form-card">
                    <h5 class="admin-section-title mb-4">
                        <i class="bi bi-gear me-2"></i>Actions
                    </h5>

                    <!-- Mark Unread -->
                    <form method="POST"
                          action="<?= SITE_URL ?>/?page=admin-messages"
                          style="margin:0 0 10px;">
                        <input type="hidden" name="id" value="<?= $message_id ?>">
                        <input type="hidden" name="mark_unread" value="1">
                        <button type="submit" class="btn btn-gold-outline w-100">
                            <i class="bi bi-envelope me-2"></i>Mark as Unread
                        </button>
                    </form>

                    <!-- Delete -->
                    <form method="POST"
                          action="<?= SITE_URL ?>/?page=admin-messages"
                          class="delete-form"
                          style="margin:0;">
                        <input type="hidden" name="id" value="<?= $message_id ?>">
                        <input type="hidden" name="delete_message" value="1">
                        <button type="submit" class="btn-admin-delete w-100"
                                style="padding:10px;border-radius:2px;justify-content:center;">
                            <i class="bi bi-trash me-2"></i>Delete Message
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/admin.js"></script>

</body>
</html>