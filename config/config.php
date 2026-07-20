<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'oremi_db');

define('SITE_NAME', 'Ore Mi');

// Auto detect local or live
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

// If local, include the subfolder. If live, just the domain
if ($host === 'localhost') {
    define('SITE_URL', $protocol . '://' . $host . '/oremi/public');
} else {
    define('SITE_URL', $protocol . '://' . $host);
}

define('WHATSAPP_NUMBER', '234XXXXXXXXXX');
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/oremi/public/assets/uploads/');
define('UPLOAD_URL', SITE_URL . '/assets/uploads/');