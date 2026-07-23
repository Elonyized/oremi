<?php

// ============================================================
// ADMIN CONSTRUCTION PROCESS FILE
// Handles: Add, Edit, Delete
// ============================================================

$constructionObj = new Construction();

// ============================================================
// ADD CONSTRUCTION
// ============================================================
if (isset($_POST['submit_construction']) && $page === 'admin-constructions-add') {

    $title               = sanitize($_POST['title'] ?? '');
    $description         = sanitize($_POST['description'] ?? '');
    $location            = sanitize($_POST['location'] ?? '');
    $progress_percent    = (int)($_POST['progress_percent'] ?? 0);
    $expected_completion = sanitize($_POST['expected_completion'] ?? '');

    // Validate
    if (empty($title) || empty($description) || empty($location)) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=admin-constructions-add');
    }

    // Clamp progress between 0 and 100
    $progress_percent = max(0, min(100, $progress_percent));

    // Create construction
    $construction_id = $constructionObj->create([
        'title'               => $title,
        'description'         => $description,
        'location'            => $location,
        'progress_percent'    => $progress_percent,
        'expected_completion' => !empty($expected_completion) ? $expected_completion : null
    ]);

    if ($construction_id) {
        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir  = UPLOAD_PATH . 'constructions/';
            $firstImage = true;

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$index];
                $extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed      = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $allowed)) continue;
                if ($_FILES['images']['size'][$index] > 5 * 1024 * 1024) continue;

                $newFilename = uniqid('cons_', true) . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($tmpName, $destination)) {
                    $isCover = $firstImage ? 1 : 0;
                    $constructionObj->addImage($construction_id, $newFilename, $isCover);
                    $firstImage = false;
                }
            }
        }

        setFlash('success', 'Construction project added successfully.');
        redirect('?page=admin-constructions');
    } else {
        setFlash('error', 'Failed to add construction project. Please try again.');
        redirect('?page=admin-constructions-add');
    }
}

// ============================================================
// EDIT CONSTRUCTION
// ============================================================
if (isset($_POST['update_construction']) && $page === 'admin-constructions-edit') {

    $construction_id     = (int)($_POST['construction_id'] ?? 0);
    $title               = sanitize($_POST['title'] ?? '');
    $description         = sanitize($_POST['description'] ?? '');
    $location            = sanitize($_POST['location'] ?? '');
    $progress_percent    = (int)($_POST['progress_percent'] ?? 0);
    $expected_completion = sanitize($_POST['expected_completion'] ?? '');

    // Validate
    if (empty($title) || empty($description) || empty($location)) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=admin-constructions-edit&id=' . $construction_id);
    }

    // Clamp progress between 0 and 100
    $progress_percent = max(0, min(100, $progress_percent));

    // Update construction
    $updated = $constructionObj->update($construction_id, [
        'title'               => $title,
        'description'         => $description,
        'location'            => $location,
        'progress_percent'    => $progress_percent,
        'expected_completion' => !empty($expected_completion) ? $expected_completion : null
    ]);

    if ($updated) {
        // Handle new image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = UPLOAD_PATH . 'constructions/';

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$index];
                $extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed      = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $allowed)) continue;
                if ($_FILES['images']['size'][$index] > 5 * 1024 * 1024) continue;

                $newFilename = uniqid('cons_', true) . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($tmpName, $destination)) {
                    $constructionObj->addImage($construction_id, $newFilename, 0);
                }
            }
        }

        // Handle cover image change
        if (!empty($_POST['cover_image_id'])) {
            $constructionObj->setCoverImage($construction_id, (int)$_POST['cover_image_id']);
        }

        // Handle individual image deletions
        if (!empty($_POST['delete_images'])) {
            foreach ($_POST['delete_images'] as $img_id) {
                $constructionObj->deleteImage((int)$img_id);
            }
        }

        setFlash('success', 'Construction project updated successfully.');
        redirect('?page=admin-constructions');
    } else {
        setFlash('error', 'Failed to update construction project. Please try again.');
        redirect('?page=admin-constructions-edit&id=' . $construction_id);
    }
}

// ============================================================
// DELETE CONSTRUCTION
// ============================================================
if (isset($_POST['id']) && $page === 'admin-constructions-delete') {

    $construction_id = (int)($_POST['id'] ?? 0);

    if ($construction_id > 0) {
        $constructionObj->deleteAllImages($construction_id);

        $commentObj = new Comment();
        $likeObj    = new Like();
        $commentObj->deleteForContent('construction', $construction_id);
        $likeObj->deleteForContent('construction', $construction_id);

        $deleted = $constructionObj->delete($construction_id);

        if ($deleted) {
            setFlash('success', 'Construction project deleted successfully.');
        } else {
            setFlash('error', 'Failed to delete construction project.');
        }
    }

    redirect('?page=admin-constructions');
}