<?php
adminGuard();
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Design | <?= SITE_NAME ?> Admin</title>

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
                <h1 class="admin-page-title">Add New Design</h1>
                <p class="admin-page-subtitle">Fill in the details below to add a new architectural design</p>
            </div>
            <a href="<?= SITE_URL ?>/?page=admin-designs" class="btn btn-gold-outline">
                <i class="bi bi-arrow-left me-2"></i>Back to Designs
            </a>
        </div>

        <!-- Flash Message -->
        <?php $flash = getFlash(); if ($flash) : ?>
            <div class="flash-message flash-<?= $flash['type'] ?>">
                <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <form method="POST"
              action="<?= SITE_URL ?>/?page=admin-designs-add"
              enctype="multipart/form-data">

            <div class="row g-4">

                <!-- Left Column -->
                <div class="col-lg-8">
                    <div class="admin-form-card">
                        <h5 class="admin-section-title mb-4">
                            <i class="bi bi-info-circle me-2"></i>Design Details
                        </h5>

                        <!-- Title -->
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                Design Title <span style="color:var(--error);">*</span>
                            </label>
                            <input
                                type="text"
                                name="title"
                                class="admin-form-control"
                                placeholder="e.g. Modern 4 Bedroom Bungalow Design"
                                value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                                required>
                        </div>

                        <!-- Description -->
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                Description <span style="color:var(--error);">*</span>
                            </label>
                            <textarea
                                name="description"
                                class="admin-form-control"
                                rows="6"
                                placeholder="Describe the design in detail — dimensions, rooms, features..."
                                required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                        </div>

                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <div class="admin-form-card mb-4">
                        <h5 class="admin-section-title mb-4">
                            <i class="bi bi-gear me-2"></i>Settings
                        </h5>

                        <!-- Price -->
                        <div class="admin-form-group">
                            <label class="admin-form-label">Price (₦)</label>
                            <input
                                type="number"
                                name="price"
                                class="admin-form-control"
                                placeholder="e.g. 150000"
                                min="0"
                                step="0.01"
                                value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
                            <p class="admin-form-hint">Leave blank or 0 if price is on inquiry</p>
                        </div>

                        <!-- PDF Upload -->
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                Upload PDF Plan
                            </label>
                            <input
                                type="file"
                                name="pdf_file"
                                class="admin-form-control"
                                accept=".pdf">
                            <p class="admin-form-hint">
                                <i class="bi bi-info-circle me-1"></i>
                                PDF only — Max 10MB
                            </p>
                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="admin-form-card">
                        <button type="submit" name="submit_design" class="btn btn-gold w-100">
                            <i class="bi bi-check-lg me-2"></i>Save Design
                        </button>
                        <a href="<?= SITE_URL ?>/?page=admin-designs"
                           class="btn btn-gold-outline w-100 mt-2">
                            Cancel
                        </a>
                    </div>

                </div>

            </div>

            <!-- Image Upload -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="admin-form-card">
                        <h5 class="admin-section-title mb-4">
                            <i class="bi bi-images me-2"></i>Design Images
                        </h5>
                        <p class="admin-form-hint mb-3">
                            Upload preview images of the design — floor plans, 3D renders, elevations etc.
                        </p>

                        <div class="admin-upload-area" id="uploadArea">
                            <i class="bi bi-cloud-upload"></i>
                            <p>Click to upload images or drag and drop here</p>
                            <p style="font-size:0.775rem;margin-top:4px;">
                                PNG, JPG, JPEG — Max 5MB each — Multiple allowed
                            </p>
                        </div>

                        <input
                            type="file"
                            name="images[]"
                            id="imageInput"
                            multiple
                            accept="image/*"
                            style="display:none;">

                        <div class="admin-image-preview-grid" id="imagePreviewGrid"></div>

                        <p class="admin-form-hint mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            The first image uploaded will automatically be set as the cover image.
                        </p>

                    </div>
                </div>
            </div>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/admin.js"></script>

</body>
</html>