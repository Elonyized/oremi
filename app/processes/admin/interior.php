<?php

// ============================================================
// ADMIN INTERIOR PROCESS FILE
// Handles: Add, Edit, Delete
// ============================================================

$interiorObj = new Interior();

// ============================================================
// ADD INTERIOR
// ============================================================
if (isset($_POST['submit_interior']) && $page === 'admin-interiors-add') {

    $title       = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $style       = sanitize($_POST['style'] ?? '');

    // Validate
    if (empty($title) || empty($description)) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=admin-interiors-add');
    }

    // Create interior
    $interior_id = $interiorObj->create([
        'title'       => $title,
        'description' => $description,
        'style'       => !empty($style) ? $style : null
    ]);

    if ($interior_id) {
        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir  = UPLOAD_PATH . 'interiors/';
            $firstImage = true;

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$index];
                $extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed      = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $allowed)) continue;
                if ($_FILES['images']['size'][$index] > 5 * 1024 * 1024) continue;

                $newFilename = uniqid('int_', true) . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($tmpName, $destination)) {
                    $isCover = $firstImage ? 1 : 0;
                    $interiorObj->addImage($interior_id, $newFilename, $isCover);
                    $firstImage = false;
                }
            }
        }

        setFlash('success', 'Interior design added successfully.');
        redirect('?page=admin-interiors');
    } else {
        setFlash('error', 'Failed to add interior design. Please try again.');
        redirect('?page=admin-interiors-add');
    }
}

// ============================================================
// EDIT INTERIOR
// ============================================================
if (isset($_POST['update_interior']) && $page === 'admin-interiors-edit') {

    $interior_id = (int)($_POST['interior_id'] ?? 0);
    $title       = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $style       = sanitize($_POST['style'] ?? '');

    // Validate
    if (empty($title) || empty($description)) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=admin-interiors-edit&id=' . $interior_id);
    }

    // Update interior
    $updated = $interiorObj->update($interior_id, [
        'title'       => $title,
        'description' => $description,
        'style'       => !empty($style) ? $style : null
    ]);

    if ($updated) {
        // Handle new image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = UPLOAD_PATH . 'interiors/';

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$index];
                $extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed      = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $allowed)) continue;
                if ($_FILES['images']['size'][$index] > 5 * 1024 * 1024) continue;

                $newFilename = uniqid('int_', true) . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($tmpName, $destination)) {
                    $interiorObj->addImage($interior_id, $newFilename, 0);
                }
            }
        }

        // Handle cover image change
        if (!empty($_POST['cover_image_id'])) {
            $interiorObj->setCoverImage($interior_id, (int)$_POST['cover_image_id']);
        }

        // Handle individual image deletions
        if (!empty($_POST['delete_images'])) {
            foreach ($_POST['delete_images'] as $img_id) {
                $interiorObj->deleteImage((int)$img_id);
            }
        }

        setFlash('success', 'Interior design updated successfully.');
        redirect('?page=admin-interiors');
    } else {
        setFlash('error', 'Failed to update interior design. Please try again.');
        redirect('?page=admin-interiors-edit&id=' . $interior_id);
    }
}

// ============================================================
// DELETE INTERIOR
// ============================================================
if (isset($_POST['id']) && $page === 'admin-interiors-delete') {

    $interior_id = (int)($_POST['id'] ?? 0);

    if ($interior_id > 0) {
        $interiorObj->deleteAllImages($interior_id);

        $commentObj = new Comment();
        $likeObj    = new Like();
        $commentObj->deleteForContent('interior', $interior_id);
        $likeObj->deleteForContent('interior', $interior_id);

        $deleted = $interiorObj->delete($interior_id);

        if ($deleted) {
            setFlash('success', 'Interior design deleted successfully.');
        } else {
            setFlash('error', 'Failed to delete interior design.');
        }
    }

    redirect('?page=admin-interiors');
}