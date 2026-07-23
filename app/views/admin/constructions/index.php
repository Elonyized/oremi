<?php
adminGuard();

$constructionObj = new Construction();
$constructions   = $constructionObj->getAll();
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constructions | <?= SITE_NAME ?> Admin</title>

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
                <h1 class="admin-page-title">Constructions</h1>
                <p class="admin-page-subtitle">Manage all under construction projects</p>
            </div>
            <a href="<?= SITE_URL ?>/?page=admin-constructions-add" class="btn btn-gold">
                <i class="bi bi-plus-lg me-2"></i>Add New Construction
            </a>
        </div>

        <!-- Flash Message -->
        <?php $flash = getFlash(); if ($flash) : ?>
            <div class="flash-message flash-<?= $flash['type'] ?>">
                <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <!-- Constructions Table -->
        <div class="admin-section-card">
            <div class="admin-section-header">
                <h5 class="admin-section-title">
                    <i class="bi bi-hammer me-2"></i>All Constructions
                    <span style="color:var(--text-muted);font-weight:400;font-size:0.85rem;">
                        (<?= count($constructions) ?>)
                    </span>
                </h5>
                <input
                    type="text"
                    id="tableSearch"
                    class="admin-form-control"
                    placeholder="Search constructions..."
                    style="width:220px;">
            </div>

            <div class="admin-section-body" style="padding:0;">
                <?php if (!empty($constructions)) : ?>
                <div style="overflow-x:auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Progress</th>
                                <th>Expected Completion</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($constructions as $index => $cons) :
                                $cover = $constructionObj->getCoverImage($cons['id']);
                            ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <?php if ($cover) : ?>
                                        <img src="<?= UPLOAD_URL ?>constructions/<?= $cover['image_path'] ?>"
                                             alt="<?= htmlspecialchars($cons['title']) ?>"
                                             class="admin-table-img">
                                    <?php else : ?>
                                        <div style="width:50px;height:50px;background:var(--bg-secondary);border-radius:4px;display:flex;align-items:center;justify-content:center;">
                                            <i class="bi bi-image" style="color:var(--text-muted);"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="font-weight:500;color:var(--text-primary);">
                                        <?= htmlspecialchars($cons['title']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($cons['location']) ?></td>
                                <td>
                                    <div style="min-width:120px;">
                                        <div class="progress-label">
                                            <span><?= $cons['progress_percent'] ?>%</span>
                                        </div>
                                        <div class="progress-custom">
                                            <div class="progress-bar-custom"
                                                 style="width:<?= $cons['progress_percent'] ?>%">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($cons['expected_completion']) : ?>
                                        <?= formatDate($cons['expected_completion']) ?>
                                    <?php else : ?>
                                        <span style="color:var(--text-muted);">Not set</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= formatDate($cons['created_at']) ?></td>
                                <td>
                                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                        <a href="<?= SITE_URL ?>/?page=construction-detail&id=<?= $cons['id'] ?>"
                                           class="btn-admin-view" target="_blank">
                                            <i class="bi bi-eye"></i>View
                                        </a>
                                        <a href="<?= SITE_URL ?>/?page=admin-constructions-edit&id=<?= $cons['id'] ?>"
                                           class="btn-admin-edit">
                                            <i class="bi bi-pencil"></i>Edit
                                        </a>
                                        <form method="POST"
                                              action="<?= SITE_URL ?>/?page=admin-constructions-delete"
                                              class="delete-form"
                                              style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $cons['id'] ?>">
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
                        <i class="bi bi-hammer"></i>
                        <h5>No Constructions Yet</h5>
                        <p>You have not added any construction projects yet.</p>
                        <a href="<?= SITE_URL ?>/?page=admin-constructions-add" class="btn btn-gold">
                            <i class="bi bi-plus-lg me-2"></i>Add First Construction
                        </a>
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