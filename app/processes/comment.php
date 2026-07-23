<?php

// ============================================================
// COMMENT PROCESS FILE
// Handles: Submit Comment
// ============================================================

if (isset($_POST['submit_comment']) && $page === 'comment') {

    $content_type = sanitize($_POST['content_type'] ?? '');
    $content_id   = (int)($_POST['content_id'] ?? 0);
    $name         = sanitize($_POST['name'] ?? '');
    $email        = sanitize($_POST['email'] ?? '');
    $comment      = sanitize($_POST['comment'] ?? '');

    $allowed_types = ['project', 'property', 'construction', 'design', 'interior'];

    // Validate
    if (!in_array($content_type, $allowed_types) || $content_id === 0) {
        setFlash('error', 'Invalid request.');
        redirect('?page=home');
    }

    if (empty($name) || empty($email) || empty($comment)) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=' . $content_type . '-detail&id=' . $content_id);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlash('error', 'Please enter a valid email address.');
        redirect('?page=' . $content_type . '-detail&id=' . $content_id);
    }

    // Save comment
    $commentObj = new Comment();
    $saved = $commentObj->create([
        'content_type' => $content_type,
        'content_id'   => $content_id,
        'name'         => $name,
        'email'        => $email,
        'comment'      => $comment
    ]);

    if ($saved) {
        setFlash('success', 'Your comment has been submitted and is awaiting approval.');
    } else {
        setFlash('error', 'Failed to submit comment. Please try again.');
    }

    redirect('?page=' . $content_type . '-detail&id=' . $content_id);
}