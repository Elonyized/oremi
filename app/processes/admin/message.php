<?php

// ============================================================
// ADMIN MESSAGE PROCESS FILE
// Handles: Mark Read, Mark Unread, Delete
// ============================================================

$messageObj = new ContactMessage();

// ============================================================
// MARK AS READ
// ============================================================
if (isset($_POST['id']) && isset($_POST['mark_read']) && $page === 'admin-messages-view') {

    $message_id = (int)($_POST['id'] ?? 0);

    if ($message_id > 0) {
        $messageObj->markRead($message_id);
    }
}

// ============================================================
// MARK ALL AS READ
// ============================================================
if (isset($_POST['mark_all_read']) && $page === 'admin-messages') {
    $messageObj->markAllRead();
    setFlash('success', 'All messages marked as read.');
    redirect('?page=admin-messages');
}


// ============================================================
// MARK AS UNREAD
// ============================================================
if (isset($_POST['id']) && isset($_POST['mark_unread']) && $page === 'admin-messages') {

    $message_id = (int)($_POST['id'] ?? 0);

    if ($message_id > 0) {
        $messageObj->markUnread($message_id);
        setFlash('success', 'Message marked as unread.');
    }

    redirect('?page=admin-messages');
}

// ============================================================
// DELETE MESSAGE
// ============================================================
if (isset($_POST['id']) && isset($_POST['delete_message']) && $page === 'admin-messages') {

    $message_id = (int)($_POST['id'] ?? 0);

    if ($message_id > 0) {
        $deleted = $messageObj->delete($message_id);

        if ($deleted) {
            setFlash('success', 'Message deleted successfully.');
        } else {
            setFlash('error', 'Failed to delete message.');
        }
    }

    redirect('?page=admin-messages');
}