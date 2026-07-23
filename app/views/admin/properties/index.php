<?php
adminGuard();

$propertyObj = new Property();
$properties  = $propertyObj->getAll();
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties | <?= SITE_NAME ?> Admin</title>

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
                <h1 class="admin-page-title">Properties</h1>
                <p class="admin-page-subtitle">Manage all property listings</p>
            </div>
            <a href="<?= SITE_URL ?>/?page=admin-properties-add" class="btn btn-gold">
                <i class="bi bi-plus-lg me-2"></i>Add New Property
            </a>
        </div>

        <!-- Flash Message -->
        <?php $flash = getFlash(); if ($flash) : ?>
            <div class="flash-message flash-<?= $flash['type'] ?>">
                <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <!-- Properties Table -->
        <div class="admin-section-card">
            <div class="admin-section-header">
                <h5 class="admin-section-title">
                    <i class="bi bi-buildings me-2"></i>All Properties
                    <span style="color:var(--text-muted);font-weight:400;font-size:0.85rem;">
                        (<?= count($properties) ?>)
                    </span>
                </h5>
                <input
                    type="text"
                    id="tableSearch"
                    class="admin-form-control"
                    placeholder="Search properties..."
                    style="width:220px;">
            </div>

            <div class="admin-section-body" style="padding:0;">
                <?php if (!empty($properties)) : ?>
                <div style="overflow-x:auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Location</th>
                                <th>Beds/Baths</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($properties as $index => $prop) :
                                $cover = $propertyObj->getCoverImage($prop['id']);
                            ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <?php if ($cover) : ?>
                                        <img src="<?= UPLOAD_URL ?>properties/<?= $cover['image_path'] ?>"
                                             alt="<?= htmlspecialchars($prop['title']) ?>"
                                             class="admin-table-img">
                                    <?php else : ?>
                                        <div style="width:50px;height:50px;background:var(--bg-secondary);border-radius:4px;display:flex;align-items:center;justify-content:center;">
                                            <i class="bi bi-image" style="color:var(--text-muted);"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="font-weight:500;color:var(--text-primary);">
                                        <?= htmlspecialchars($prop['title']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($prop['listing_type'] === 'sale') : ?>
                                        <span class="badge-sale">For Sale</span>
                                    <?php else : ?>
                                        <span class="badge-rent">For Rent</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="color:var(--accent-gold);font-weight:600;">
                                        <?= formatPrice($prop['price']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($prop['location']) ?></td>
                                <td>
                                    <span style="font-size:0.8rem;">
                                        <i class="bi bi-door-open"></i> <?= $prop['bedrooms'] ?>
                                        &nbsp;
                                        <i class="bi bi-droplet"></i> <?= $prop['bathrooms'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($prop['status'] === 'available') : ?>
                                        <span class="badge-available">Available</span>
                                    <?php elseif ($prop['status'] === 'sold') : ?>
                                        <span class="badge-sold">Sold</span>
                                    <?php else : ?>
                                        <span class="badge-rent">Rented</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                        <a href="<?= SITE_URL ?>/?page=property-detail&id=<?= $prop['id'] ?>"
                                           class="btn-admin-view" target="_blank">
                                            <i class="bi bi-eye"></i>View
                                        </a>
                                        <a href="<?= SITE_URL ?>/?page=admin-properties-edit&id=<?= $prop['id'] ?>"
                                           class="btn-admin-edit">
                                            <i class="bi bi-pencil"></i>Edit
                                        </a>
                                        <form method="POST"
                                              action="<?= SITE_URL ?>/?page=admin-properties-delete"
                                              class="delete-form"
                                              style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $prop['id'] ?>">
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
                        <i class="bi bi-buildings"></i>
                        <h5>No Properties Yet</h5>
                        <p>You have not added any properties yet.</p>
                        <a href="<?= SITE_URL ?>/?page=admin-properties-add" class="btn btn-gold">
                            <i class="bi bi-plus-lg me-2"></i>Add First Property
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