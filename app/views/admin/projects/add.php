<?php
adminGuard();

$projectObj = new Project();
$categories = $projectObj->getCategories();
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project | <?= SITE_NAME ?> Admin</title>

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
                <h1 class="admin-page-title">Add New Project</h1>
                <p class="admin-page-subtitle">Fill in the details below to add a new project</p>
            </div>
            <a href="<?= SITE_URL ?>/?page=admin-projects" class="btn btn-gold-outline">
                <i class="bi bi-arrow-left me-2"></i>Back to Projects
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

        <form method="POST" 
              action="<?= SITE_URL ?>/?page=admin-projects-add" 
              enctype="multipart/form-data">

            <div class="row g-4">

                <!-- Left Column - Main Details -->
                <div class="col-lg-8">
                    <div class="admin-form-card">
                        <h5 class="admin-section-title mb-4">
                            <i class="bi bi-info-circle me-2"></i>Project Details
                        </h5>

                        <!-- Title -->
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                Project Title <span style="color:var(--error);">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="title" 
                                class="admin-form-control" 
                                placeholder="e.g. 3 Bedroom Duplex in Abuja"
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
                                placeholder="Describe the project in detail..."
                                required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                        </div>

                        <!-- Location -->
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                Location <span style="color:var(--error);">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="location" 
                                class="admin-form-control" 
                                placeholder="e.g. Maitama, Abuja"
                                value="<?= htmlspecialchars($_POST['location'] ?? '') ?>"
                                required>
                        </div>

                    </div>
                </div>

                <!-- Right Column - Settings -->
                <div class="col-lg-4">
                    <div class="admin-form-card mb-4">
                        <h5 class="admin-section-title mb-4">
                            <i class="bi bi-gear me-2"></i>Settings
                        </h5>

                        <!-- Category -->
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                Category <span style="color:var(--error);">*</span>
                            </label>
                            <select name="category_id" class="admin-form-control" required>
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $cat) : ?>
                                    <option value="<?= $cat['id'] ?>" 
                                        <?= (isset($_POST['category_id']) && $_POST['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                Status <span style="color:var(--error);">*</span>
                            </label>
                            <select name="status" class="admin-form-control" required>
                                <option value="completed" 
                                    <?= (isset($_POST['status']) && $_POST['status'] === 'completed') ? 'selected' : '' ?>>
                                    Completed
                                </option>
                                <option value="ongoing"
                                    <?= (isset($_POST['status']) && $_POST['status'] === 'ongoing') ? 'selected' : '' ?>>
                                    Ongoing
                                </option>
                            </select>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="admin-form-card">
                        <button type="submit" name="submit_project" class="btn btn-gold w-100">
                            <i class="bi bi-check-lg me-2"></i>Save Project
                        </button>
                        <a href="<?= SITE_URL ?>/?page=admin-projects" 
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
                            <i class="bi bi-images me-2"></i>Project Images
                        </h5>

                        <!-- Upload Area -->
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

                        <!-- Image Preview Grid -->
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