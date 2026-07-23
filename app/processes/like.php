<?php

// ============================================================
// LIKE PROCESS FILE
// Handles: Toggle Like via AJAX
// ============================================================

if (isset($_POST['content_type']) && isset($_POST['content_id'])) {

    $content_type = sanitize($_POST['content_type'] ?? '');
    $content_id   = (int)($_POST['content_id'] ?? 0);

    $allowed_types = ['project', 'property', 'construction', 'design', 'interior'];

    if (!in_array($content_type, $allowed_types) || $content_id === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit();
    }

    $likeObj   = new Like();
    $ip        = getIPAddress();
    $result    = $likeObj->toggle($content_type, $content_id, $ip);

    echo json_encode([
        'success' => true,
        'action'  => $result['action'],
        'count'   => $result['count']
    ]);
    exit();
}