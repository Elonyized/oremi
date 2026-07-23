<?php

// ============================================================
// CONTACT FORM PROCESS FILE
// ============================================================

if (isset($_POST['submit_contact']) && $page === 'contact') {

    $name    = sanitize($_POST['name'] ?? '');
    $email   = sanitize($_POST['email'] ?? '');
    $phone   = sanitize($_POST['phone'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    // Validate
    if (empty($name) || empty($email) || empty($message)) {
        setFlash('error', 'Please fill in all required fields.');
        redirect('?page=contact');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlash('error', 'Please enter a valid email address.');
        redirect('?page=contact');
    }

    // Save message
    $messageObj = new ContactMessage();
    $saved = $messageObj->create([
        'name'    => $name,
        'email'   => $email,
        'phone'   => !empty($phone) ? $phone : null,
        'message' => $message
    ]);

    if ($saved) {
        setFlash('success', 'Your message has been sent successfully. We will get back to you shortly.');
        redirect('?page=contact');
    } else {
        setFlash('error', 'Failed to send message. Please try again.');
        redirect('?page=contact');
    }
}