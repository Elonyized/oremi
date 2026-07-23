<?php

// ============================================================
// ADMIN PROPERTY PROCESS FILE
// Handles: Add, Edit, Delete
// ============================================================

$propertyObj = new Property();

// ============================================================
// ADD PROPERTY
// ============================================================
if (isset($_POST['submit_property']) && $page === 'admin-properties-add') {

    $title        = sanitize($_POST['title'] ?? '');
    $description  = sanitize($_POST['description'] ?? '');
    $location     = sanitize($_POST['location'] ?? '');
    $price        = (float)($_POST['price'] ?? 0);
    $listing_type = sanitize($_POST['listing_type'] ?? '');
    $status       = sanitize($_POST['status'] ?? 'available');
    $bedrooms     = (int)($_POST['bedrooms'] ?? 0);
    $bathrooms    = (int)($_POST['bathrooms'] ?? 0);

    // Validate
    if (empty($title) || empty($description) || empty($location) || empty($listing_type) || $price <= 0) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=admin-properties-add');
    }

    // Create property
    $property_id = $propertyObj->create([
        'title'        => $title,
        'description'  => $description,
        'location'     => $location,
        'price'        => $price,
        'listing_type' => $listing_type,
        'status'       => $status,
        'bedrooms'     => $bedrooms,
        'bathrooms'    => $bathrooms
    ]);

    if ($property_id) {
        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir  = UPLOAD_PATH . 'properties/';
            $firstImage = true;

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$index];
                $extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed      = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $allowed)) continue;
                if ($_FILES['images']['size'][$index] > 5 * 1024 * 1024) continue;

                $newFilename = uniqid('prop_', true) . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($tmpName, $destination)) {
                    $isCover = $firstImage ? 1 : 0;
                    $propertyObj->addImage($property_id, $newFilename, $isCover);
                    $firstImage = false;
                }
            }
        }

        setFlash('success', 'Property added successfully.');
        redirect('?page=admin-properties');
    } else {
        setFlash('error', 'Failed to add property. Please try again.');
        redirect('?page=admin-properties-add');
    }
}

// ============================================================
// EDIT PROPERTY
// ============================================================
if (isset($_POST['update_property']) && $page === 'admin-properties-edit') {

    $property_id  = (int)($_POST['property_id'] ?? 0);
    $title        = sanitize($_POST['title'] ?? '');
    $description  = sanitize($_POST['description'] ?? '');
    $location     = sanitize($_POST['location'] ?? '');
    $price        = (float)($_POST['price'] ?? 0);
    $listing_type = sanitize($_POST['listing_type'] ?? '');
    $status       = sanitize($_POST['status'] ?? 'available');
    $bedrooms     = (int)($_POST['bedrooms'] ?? 0);
    $bathrooms    = (int)($_POST['bathrooms'] ?? 0);

    // Validate
    if (empty($title) || empty($description) || empty($location) || empty($listing_type) || $price <= 0) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=admin-properties-edit&id=' . $property_id);
    }

    // Update property
    $updated = $propertyObj->update($property_id, [
        'title'        => $title,
        'description'  => $description,
        'location'     => $location,
        'price'        => $price,
        'listing_type' => $listing_type,
        'status'       => $status,
        'bedrooms'     => $bedrooms,
        'bathrooms'    => $bathrooms
    ]);

    if ($updated) {
        // Handle new image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = UPLOAD_PATH . 'properties/';

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$index];
                $extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed      = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $allowed)) continue;
                if ($_FILES['images']['size'][$index] > 5 * 1024 * 1024) continue;

                $newFilename = uniqid('prop_', true) . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($tmpName, $destination)) {
                    $propertyObj->addImage($property_id, $newFilename, 0);
                }
            }
        }

        // Handle cover image change
        if (!empty($_POST['cover_image_id'])) {
            $propertyObj->setCoverImage($property_id, (int)$_POST['cover_image_id']);
        }

        // Handle individual image deletions
        if (!empty($_POST['delete_images'])) {
            foreach ($_POST['delete_images'] as $img_id) {
                $propertyObj->deleteImage((int)$img_id);
            }
        }

        setFlash('success', 'Property updated successfully.');
        redirect('?page=admin-properties');
    } else {
        setFlash('error', 'Failed to update property. Please try again.');
        redirect('?page=admin-properties-edit&id=' . $property_id);
    }
}

// ============================================================
// DELETE PROPERTY
// ============================================================
if (isset($_POST['id']) && $page === 'admin-properties-delete') {

    $property_id = (int)($_POST['id'] ?? 0);

    if ($property_id > 0) {
        $propertyObj->deleteAllImages($property_id);

        $commentObj = new Comment();
        $likeObj    = new Like();
        $commentObj->deleteForContent('property', $property_id);
        $likeObj->deleteForContent('property', $property_id);

        $deleted = $propertyObj->delete($property_id);

        if ($deleted) {
            setFlash('success', 'Property deleted successfully.');
        } else {
            setFlash('error', 'Failed to delete property.');
        }
    }

    redirect('?page=admin-properties');
}