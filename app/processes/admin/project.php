<?php

// ============================================================
// ADMIN PROJECT PROCESS FILE
// Handles: Add, Edit, Delete
// ============================================================

$projectObj = new Project();

// ============================================================
// ADD PROJECT
// ============================================================
if (isset($_POST['submit_project']) && $page === 'admin-projects-add') {

    $title       = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $location    = sanitize($_POST['location'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $status      = sanitize($_POST['status'] ?? 'completed');

    // Validate
    if (empty($title) || empty($description) || empty($location) || $category_id === 0) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=admin-projects-add');
    }

    // Create project
    $project_id = $projectObj->create([
        'title'       => $title,
        'description' => $description,
        'location'    => $location,
        'category_id' => $category_id,
        'status'      => $status
    ]);

    if ($project_id) {
        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir  = UPLOAD_PATH . 'projects/';
            $firstImage = true;

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$index];
                $extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed      = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $allowed)) continue;

                // Check file size (max 5MB)
                if ($_FILES['images']['size'][$index] > 5 * 1024 * 1024) continue;

                // Generate unique filename
                $newFilename = uniqid('proj_', true) . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($tmpName, $destination)) {
                    // First image is the cover
                    $isCover = $firstImage ? 1 : 0;
                    $projectObj->addImage($project_id, $newFilename, $isCover);
                    $firstImage = false;
                }
            }
        }

        setFlash('success', 'Project added successfully.');
        redirect('?page=admin-projects');
    } else {
        setFlash('error', 'Failed to add project. Please try again.');
        redirect('?page=admin-projects-add');
    }
}

// ============================================================
// EDIT PROJECT
// ============================================================
if (isset($_POST['update_project']) && $page === 'admin-projects-edit') {

    $project_id  = (int)($_POST['project_id'] ?? 0);
    $title       = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $location    = sanitize($_POST['location'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $status      = sanitize($_POST['status'] ?? 'completed');

    // Validate
    if (empty($title) || empty($description) || empty($location) || $category_id === 0) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=admin-projects-edit&id=' . $project_id);
    }

    // Update project
    $updated = $projectObj->update($project_id, [
        'title'       => $title,
        'description' => $description,
        'location'    => $location,
        'category_id' => $category_id,
        'status'      => $status
    ]);

    if ($updated) {
        // Handle new image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = UPLOAD_PATH . 'projects/';

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$index];
                $extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed      = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $allowed)) continue;

                if ($_FILES['images']['size'][$index] > 5 * 1024 * 1024) continue;

                $newFilename = uniqid('proj_', true) . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($tmpName, $destination)) {
                    $projectObj->addImage($project_id, $newFilename, 0);
                }
            }
        }

        // Handle cover image change
        if (!empty($_POST['cover_image_id'])) {
            $projectObj->setCoverImage($project_id, (int)$_POST['cover_image_id']);
        }

        // Handle individual image deletions
        if (!empty($_POST['delete_images'])) {
            foreach ($_POST['delete_images'] as $img_id) {
                $projectObj->deleteImage((int)$img_id);
            }
        }

        setFlash('success', 'Project updated successfully.');
        redirect('?page=admin-projects');
    } else {
        setFlash('error', 'Failed to update project. Please try again.');
        redirect('?page=admin-projects-edit&id=' . $project_id);
    }
}

// ============================================================
// DELETE PROJECT
// ============================================================
if (isset($_POST['id']) && $page === 'admin-projects-delete') {

    $project_id = (int)($_POST['id'] ?? 0);

    if ($project_id > 0) {
        // Delete all images first
        $projectObj->deleteAllImages($project_id);

        // Delete comments and likes for this project
        $commentObj = new Comment();
        $likeObj    = new Like();
        $commentObj->deleteForContent('project', $project_id);
        $likeObj->deleteForContent('project', $project_id);

        // Delete project
        $deleted = $projectObj->delete($project_id);

        if ($deleted) {
            setFlash('success', 'Project deleted successfully.');
        } else {
            setFlash('error', 'Failed to delete project.');
        }
    }

    redirect('?page=admin-projects');
}