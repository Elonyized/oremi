<?php
adminGuard();

$projectObj = new Project();
$categories = $projectObj->getCategories();

// Get project ID
$project_id = (int)($id ?? 0);

if ($project_id === 0) {
    setFlash('error', 'Invalid project ID.');
    redirect('?page=admin-projects');
}

// Get project data
$project = $projectObj->getById($project_id);

if (!$project) {
    setFlash('error', 'Project not found.');
    redirect('?page=admin-projects');
}

// Get existing images
$images = $projectObj->getImages($project_id);
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project | <?= SITE_NAME ?> Admin</title>

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
                <h1 class="admin-page-title">Edit Project</h1>
                <p class="admin-page-subtitle">
                    Editing: <?= htmlspecialchars($project['title']) ?>
                </p>
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
              action="<?= SITE_URL ?>/?page=admin-projects-edit&id=<?= $project_id ?>"
              enctype="multipart/form-data">

            <input type="hidden" name="project_id" value="<?= $project_id ?>">

            <div class="row g-4">

                <!-- Left Column -->
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
                                value="<?= htmlspecialchars($_POST['title'] ?? $project['title']) ?>"
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
                                required><?= htmlspecialchars($_POST['description'] ?? $project['description']) ?></textarea>
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
                                value="<?= htmlspecialchars($_POST['location'] ?? $project['location']) ?>"
                                required>
                        </div>

                    </div>
                </div>

                <!-- Right Column -->
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
                                        <?= ($cat['id'] == ($project['category_id'])) ? 'selected' : '' ?>>
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
                                    <?= ($project['status'] === 'completed') ? 'selected' : '' ?>>
                                    Completed
                                </option>
                                <option value="ongoing"
                                    <?= ($project['status'] === 'ongoing') ? 'selected' : '' ?>>
                                    Ongoing
                                </option>
                            </select>
                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="admin-form-card">
                        <button type="submit" name="update_project" class="btn btn-gold w-100">
                            <i class="bi bi-check-lg me-2"></i>Update Project
                        </button>
                        <a href="<?= SITE_URL ?>/?page=admin-projects"
                           class="btn btn-gold-outline w-100 mt-2">
                            Cancel
                        </a>
                    </div>

                </div>

            </div>

            <!-- Existing Images -->
            <?php if (!empty($images)) : ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="admin-form-card">
                        <h5 class="admin-section-title mb-4">
                            <i class="bi bi-images me-2"></i>Existing Images
                        </h5>
                        <p class="admin-form-hint mb-3">
                            <i class="bi bi-info-circle me-1"></i>
                            Select a cover image or check images to delete them.
                        </p>

                        <div class="admin-image-preview-grid">
                            <?php foreach ($images as $img) : ?>
                            <div class="admin-image-preview-item <?= $img['is_cover'] ? 'is-cover' : '' ?>">
                                <img src="<?= UPLOAD_URL ?>projects/<?= $img['image_path'] ?>"
                                     alt="Project Image">

                                <!-- Set as Cover -->
                                <div style="position:absolute;bottom:4px;left:4px;">
                                    <input type="radio"
                                           name="cover_image_id"
                                           value="<?= $img['id'] ?>"
                                           class="cover-radio"
                                           <?= $img['is_cover'] ? 'checked' : '' ?>
                                           title="Set as cover"
                                           style="accent-color:var(--accent-gold);cursor:pointer;">
                                </div>

                                <!-- Delete Checkbox -->
                                <div style="position:absolute;top:4px;left:4px;">
                                    <input type="checkbox"
                                           name="delete_images[]"
                                           value="<?= $img['id'] ?>"
                                           title="Delete this image"
                                           style="accent-color:var(--error);cursor:pointer;">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <p class="admin-form-hint mt-2">
                            <i class="bi bi-circle-fill me-1" style="color:var(--accent-gold);font-size:0.5rem;"></i>
                            Radio button = set as cover &nbsp;|&nbsp;
                            <i class="bi bi-circle-fill me-1" style="color:var(--error);font-size:0.5rem;"></i>
                            Checkbox = delete image
                        </p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Upload New Images -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="admin-form-card">
                        <h5 class="admin-section-title mb-4">
                            <i class="bi bi-cloud-upload me-2"></i>Upload New Images
                        </h5>

                        <div class="admin-upload-area" id="uploadArea">
                            <i class="bi bi-cloud-upload"></i>
                            <p>Click to upload more images or drag and drop here</p>
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

                    </div>
                </div>
            </div>

        </form>

    </div>
</div>

<!-- Cover image highlight style -->
<style>
    .admin-image-preview-item.is-cover {
        border: 2px solid var(--accent-gold);
    }
    .admin-image-preview-item.is-cover::after {
        content: 'Cover';
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: var(--accent-gold);
        color: #0D0D0D;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 2px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/admin.js"></script>

</body>
</html>