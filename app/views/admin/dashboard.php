<?php
adminGuard();

$adminObj = new Admin();
$adminInfo = $adminObj->getById($_SESSION['admin_id']);

$projectObj = new Project();
$propertyObj = new Property();
$constructionObj = new Construction();
$designObj = new Design();
$interiorObj = new Interior();
$commentObj = new Comment();
$messageObj = new ContactMessage();

// Get counts for dashboard
$totalProjects      = $projectObj->getCount();
$totalProperties    = $propertyObj->getCount();
$totalConstructions = $constructionObj->getCount();
$totalDesigns       = $designObj->getCount();
$totalInteriors     = $interiorObj->getCount();
$totalComments      = $commentObj->getCount();
$pendingComments    = $commentObj->getPendingCount();
$totalMessages      = $messageObj->getCount();
$unreadMessages     = $messageObj->getUnreadCount();
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | <?= SITE_NAME ?> Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body class="admin-body">

<!-- SIDEBAR -->
<?php require_once '../app/views/admin/includes/sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="admin-main">

    <!-- Top Bar -->
    <?php require_once '../app/views/admin/includes/topbar.php'; ?>

    <!-- Page Content -->
    <div class="admin-content">

        <!-- Page Header -->
        <div class="admin-page-header">
            <div>
                <h1 class="admin-page-title">Dashboard</h1>
                <p class="admin-page-subtitle">Welcome back, <?= htmlspecialchars($_SESSION['admin_name']) ?>!</p>
            </div>
            <a href="<?= SITE_URL ?>/?page=home" 
               class="btn btn-gold-outline btn-sm" target="_blank">
                <i class="bi bi-box-arrow-up-right me-1"></i>View Site
            </a>
        </div>

        <!-- Stats Cards Row 1 -->
        <div class="row g-4 mb-4">

            <div class="col-lg-3 col-md-6">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background: rgba(201,168,76,0.15);">
                        <i class="bi bi-folder" style="color: var(--accent-gold);"></i>
                    </div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number"><?= $totalProjects ?></span>
                        <span class="admin-stat-label">Total Projects</span>
                    </div>
                    <a href="<?= SITE_URL ?>/?page=admin-projects" class="admin-stat-link">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background: rgba(46,204,113,0.15);">
                        <i class="bi bi-buildings" style="color: #2ECC71;"></i>
                    </div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number"><?= $totalProperties ?></span>
                        <span class="admin-stat-label">Properties</span>
                    </div>
                    <a href="<?= SITE_URL ?>/?page=admin-properties" class="admin-stat-link">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background: rgba(52,152,219,0.15);">
                        <i class="bi bi-hammer" style="color: #3498DB;"></i>
                    </div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number"><?= $totalConstructions ?></span>
                        <span class="admin-stat-label">Under Construction</span>
                    </div>
                    <a href="<?= SITE_URL ?>/?page=admin-constructions" class="admin-stat-link">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background: rgba(155,89,182,0.15);">
                        <i class="bi bi-pen" style="color: #9B59B6;"></i>
                    </div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number"><?= $totalDesigns ?></span>
                        <span class="admin-stat-label">Designs</span>
                    </div>
                    <a href="<?= SITE_URL ?>/?page=admin-designs" class="admin-stat-link">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Stats Cards Row 2 -->
        <div class="row g-4 mb-4">

            <div class="col-lg-3 col-md-6">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background: rgba(230,126,34,0.15);">
                        <i class="bi bi-layout-text-window" style="color: #E67E22;"></i>
                    </div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number"><?= $totalInteriors ?></span>
                        <span class="admin-stat-label">Interiors</span>
                    </div>
                    <a href="<?= SITE_URL ?>/?page=admin-interiors" class="admin-stat-link">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background: rgba(231,76,60,0.15);">
                        <i class="bi bi-chat-dots" style="color: #E74C3C;"></i>
                    </div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number"><?= $totalComments ?></span>
                        <span class="admin-stat-label">
                            Comments
                            <?php if ($pendingComments > 0) : ?>
                                <span class="admin-badge-alert"><?= $pendingComments ?> pending</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <a href="<?= SITE_URL ?>/?page=admin-comments" class="admin-stat-link">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background: rgba(52,73,94,0.3);">
                        <i class="bi bi-envelope" style="color: var(--accent-gold);"></i>
                    </div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number"><?= $totalMessages ?></span>
                        <span class="admin-stat-label">
                            Messages
                            <?php if ($unreadMessages > 0) : ?>
                                <span class="admin-badge-alert"><?= $unreadMessages ?> unread</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <a href="<?= SITE_URL ?>/?page=admin-messages" class="admin-stat-link">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background: rgba(201,168,76,0.15);">
                        <i class="bi bi-heart" style="color: var(--accent-gold);"></i>
                    </div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number">
                            <?php
                                $likeObj = new Like();
                                echo $likeObj->getTotalCount();
                            ?>
                        </span>
                        <span class="admin-stat-label">Total Likes</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Actions -->
        <div class="admin-section-card mb-4">
            <div class="admin-section-header">
                <h5 class="admin-section-title">
                    <i class="bi bi-lightning me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="admin-section-body">
                <div class="row g-3">
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="<?= SITE_URL ?>/?page=admin-projects-add" class="admin-quick-action">
                            <i class="bi bi-folder-plus"></i>
                            <span>Add Project</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="<?= SITE_URL ?>/?page=admin-properties-add" class="admin-quick-action">
                            <i class="bi bi-building-add"></i>
                            <span>Add Property</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="<?= SITE_URL ?>/?page=admin-constructions-add" class="admin-quick-action">
                            <i class="bi bi-hammer"></i>
                            <span>Add Construction</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="<?= SITE_URL ?>/?page=admin-designs-add" class="admin-quick-action">
                            <i class="bi bi-pen"></i>
                            <span>Add Design</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="<?= SITE_URL ?>/?page=admin-interiors-add" class="admin-quick-action">
                            <i class="bi bi-layout-text-window"></i>
                            <span>Add Interior</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="<?= SITE_URL ?>/?page=admin-messages" class="admin-quick-action">
                            <i class="bi bi-envelope-open"></i>
                            <span>View Messages</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/admin.js"></script>

</body>
</html>