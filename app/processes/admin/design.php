<?php

// ============================================================
// ADMIN DESIGN PROCESS FILE
// Handles: Add, Edit, Delete
// ============================================================

$designObj = new Design();

// ============================================================
// ADD DESIGN
// ============================================================
if (isset($_POST['submit_design']) && $page === 'admin-designs-add') {

    $title       = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $price       = (float)($_POST['price'] ?? 0);

    // Validate
    if (empty($title) || empty($description)) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=admin-designs-add');
    }

    // Handle PDF upload first
    $pdf_path = null;
    if (!empty($_FILES['pdf_file']['name'])) {
        $pdfName      = $_FILES['pdf_file']['name'];
        $pdfTmp       = $_FILES['pdf_file']['tmp_name'];
        $pdfSize      = $_FILES['pdf_file']['size'];
        $pdfExtension = strtolower(pathinfo($pdfName, PATHINFO_EXTENSION));

        if ($pdfExtension !== 'pdf') {
            setFlash('error', 'Only PDF files are allowed.');
            redirect('?page=admin-designs-add');
        }

        if ($pdfSize > 10 * 1024 * 1024) {
            setFlash('error', 'PDF file size must not exceed 10MB.');
            redirect('?page=admin-designs-add');
        }

        $pdfFilename = uniqid('design_', true) . '.pdf';
        $pdfDest     = UPLOAD_PATH . 'pdfs/' . $pdfFilename;

        if (move_uploaded_file($pdfTmp, $pdfDest)) {
            $pdf_path = $pdfFilename;
        }
    }

    // Create design
    $design_id = $designObj->create([
        'title'       => $title,
        'description' => $description,
        'price'       => $price,
        'pdf_path'    => $pdf_path
    ]);

    if ($design_id) {
        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir  = UPLOAD_PATH . 'designs/';
            $firstImage = true;

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$index];
                $extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed      = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $allowed)) continue;
                if ($_FILES['images']['size'][$index] > 5 * 1024 * 1024) continue;

                $newFilename = uniqid('des_', true) . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($tmpName, $destination)) {
                    $isCover = $firstImage ? 1 : 0;
                    $designObj->addImage($design_id, $newFilename, $isCover);
                    $firstImage = false;
                }
            }
        }

        setFlash('success', 'Design added successfully.');
        redirect('?page=admin-designs');
    } else {
        setFlash('error', 'Failed to add design. Please try again.');
        redirect('?page=admin-designs-add');
    }
}

// ============================================================
// EDIT DESIGN
// ============================================================
if (isset($_POST['update_design']) && $page === 'admin-designs-edit') {

    $design_id   = (int)($_POST['design_id'] ?? 0);
    $title       = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $price       = (float)($_POST['price'] ?? 0);

    // Validate
    if (empty($title) || empty($description)) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=admin-designs-edit&id=' . $design_id);
    }

    // Get current design
    $currentDesign = $designObj->getById($design_id);
    $pdf_path      = $currentDesign['pdf_path'];

    // Handle PDF deletion
    if (isset($_POST['delete_pdf']) && $_POST['delete_pdf'] == 1 && $pdf_path) {
        $pdfFile = UPLOAD_PATH . 'pdfs/' . $pdf_path;
        if (file_exists($pdfFile)) {
            unlink($pdfFile);
        }
        $pdf_path = null;
    }

    // Handle new PDF upload
    if (!empty($_FILES['pdf_file']['name'])) {
        $pdfName      = $_FILES['pdf_file']['name'];
        $pdfTmp       = $_FILES['pdf_file']['tmp_name'];
        $pdfSize      = $_FILES['pdf_file']['size'];
        $pdfExtension = strtolower(pathinfo($pdfName, PATHINFO_EXTENSION));

        if ($pdfExtension === 'pdf' && $pdfSize <= 10 * 1024 * 1024) {
            // Delete old PDF if exists
            if ($pdf_path) {
                $oldPdf = UPLOAD_PATH . 'pdfs/' . $pdf_path;
                if (file_exists($oldPdf)) unlink($oldPdf);
            }

            $pdfFilename = uniqid('design_', true) . '.pdf';
            $pdfDest     = UPLOAD_PATH . 'pdfs/' . $pdfFilename;

            if (move_uploaded_file($pdfTmp, $pdfDest)) {
                $pdf_path = $pdfFilename;
            }
        }
    }

    // Update design
    $updated = $designObj->update($design_id, [
        'title'       => $title,
        'description' => $description,
        'price'       => $price,
        'pdf_path'    => $pdf_path
    ]);

    if ($updated) {
        // Handle new image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = UPLOAD_PATH . 'designs/';

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$index];
                $extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed      = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $allowed)) continue;
                if ($_FILES['images']['size'][$index] > 5 * 1024 * 1024) continue;

                $newFilename = uniqid('des_', true) . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($tmpName, $destination)) {
                    $designObj->addImage($design_id, $newFilename, 0);
                }
            }
        }

        // Handle cover image change
        if (!empty($_POST['cover_image_id'])) {
            $designObj->setCoverImage($design_id, (int)$_POST['cover_image_id']);
        }

        // Handle individual image deletions
        if (!empty($_POST['delete_images'])) {
            foreach ($_POST['delete_images'] as $img_id) {
                $designObj->deleteImage((int)$img_id);
            }
        }

        setFlash('success', 'Design updated successfully.');
        redirect('?page=admin-designs');
    } else {
        setFlash('error', 'Failed to update design. Please try again.');
        redirect('?page=admin-designs-edit&id=' . $design_id);
    }
}

// ============================================================
// DELETE DESIGN
// ============================================================
if (isset($_POST['id']) && $page === 'admin-designs-delete') {

    $design_id = (int)($_POST['id'] ?? 0);

    if ($design_id > 0) {
        // Delete PDF file
        $designObj->deletePDF($design_id);

        // Delete all images
        $designObj->deleteAllImages($design_id);

        // Delete comments and likes
        $commentObj = new Comment();
        $likeObj    = new Like();
        $commentObj->deleteForContent('design', $design_id);
        $likeObj->deleteForContent('design', $design_id);

        // Delete design
        $deleted = $designObj->delete($design_id);

        if ($deleted) {
            setFlash('success', 'Design deleted successfully.');
        } else {
            setFlash('error', 'Failed to delete design.');
        }
    }

    redirect('?page=admin-designs');
}