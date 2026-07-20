<?php
adminGuard();

$projectObj = new Project();
$projects   = $projectObj->getAll();
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects | <?= SITE_NAME ?> Admin</title>

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
                <h1 class="admin-page-title">Projects</h1>
                <p class="admin-page-subtitle">Manage all portfolio projects</p>
            </div>
            <a href="<?= SITE_URL ?>/?page=admin-projects-add" class="btn btn-gold">
                <i class="bi bi-plus-lg me-2"></i>Add New Project
            </a>
        </div>

        <!-- Flash Message -->
        <?php
            $flash = getFlash();
            if ($flash) :
        ?>
            <div class="flash-message flash-<?= $flash['type'] ?>">
                <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <!-- Projects Table -->
        <div class="admin-section-card">
            <div class="admin-section-header">
                <h5 class="admin-section-title">
                    <i class="bi bi-folder me-2"></i>All Projects
                    <span style="color: var(--text-muted); font-weight: 400; font-size: 0.85rem;">
                        (<?= count($projects) ?>)
                    </span>
                </h5>
                <!-- Search -->
                <input 
                    type="text" 
                    id="tableSearch" 
                    class="admin-form-control" 
                    placeholder="Search projects..." 
                    style="width: 220px;">
            </div>

            <div class="admin-section-body" style="padding: 0;">
                <?php if (!empty($projects)) : ?>
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projects as $index => $proj) :
                                $cover = $projectObj->getCoverImage($proj['id']);
                            ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <?php if ($cover) : ?>
                                        <img src="<?= UPLOAD_URL ?>projects/<?= $cover['image_path'] ?>" 
                                             alt="<?= htmlspecialchars($proj['title']) ?>"
                                             class="admin-table-img">
                                    <?php else : ?>
                                        <div style="width:50px;height:50px;background:var(--bg-secondary);border-radius:4px;display:flex;align-items:center;justify-content:center;">
                                            <i class="bi bi-image" style="color:var(--text-muted);"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="font-weight:500;color:var(--text-primary);">
                                        <?= htmlspecialchars($proj['title']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-gold">
                                        <?= htmlspecialchars($proj['category_name']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($proj['location']) ?></td>
                                <td>
                                    <?php if ($proj['status'] === 'completed') : ?>
                                        <span class="badge-available">Completed</span>
                                    <?php else : ?>
                                        <span class="badge-rent">Ongoing</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= formatDate($proj['created_at']) ?></td>
                                <td>
                                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                        <a href="<?= SITE_URL ?>/?page=project-detail&id=<?= $proj['id'] ?>" 
                                           class="btn-admin-view" target="_blank">
                                            <i class="bi bi-eye"></i>View
                                        </a>
                                        <a href="<?= SITE_URL ?>/?page=admin-projects-edit&id=<?= $proj['id'] ?>" 
                                           class="btn-admin-edit">
                                            <i class="bi bi-pencil"></i>Edit
                                        </a>
                                        <form method="POST" 
                                              action="<?= SITE_URL ?>/?page=admin-projects-delete" 
                                              class="delete-form" 
                                              style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $proj['id'] ?>">
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
                        <i class="bi bi-folder-x"></i>
                        <h5>No Projects Yet</h5>
                        <p>You have not added any projects yet.</p>
                        <a href="<?= SITE_URL ?>/?page=admin-projects-add" class="btn btn-gold">
                            <i class="bi bi-plus-lg me-2"></i>Add First Project
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