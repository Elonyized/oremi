<?php

// Redirect to a URL
function redirect($url) {
    header("Location: " . SITE_URL . "/" . $url);
    exit();
}

// Sanitize user input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Format price to Nigerian Naira
function formatPrice($amount) {
    return '₦' . number_format($amount, 2);
}

// Format date to readable format
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

// Check if admin is logged in
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

// Guard admin pages - redirect to login if not logged in
function adminGuard() {
    if (!isAdminLoggedIn()) {
        redirect('admin/login.php');
    }
}

// Get current page URL
function currentURL() {
    return $_SERVER['REQUEST_URI'];
}

// Truncate long text
function truncate($text, $limit = 100) {
    if (strlen($text) > $limit) {
        return substr($text, 0, $limit) . '...';
    }
    return $text;
}

// Get cover image for any content
function getCoverImage($images, $default = 'default.jpg') {
    foreach ($images as $image) {
        if ($image['is_cover'] == 1) {
            return $image['image_path'];
        }
    }
    return !empty($images) ? $images[0]['image_path'] : $default;
}

// Display flash messages
function setFlash($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// Get visitor IP address
function getIPAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $_SERVER['REMOTE_ADDR'];
}