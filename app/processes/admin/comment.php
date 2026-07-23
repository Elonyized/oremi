<?php

// ============================================================
// ADMIN COMMENT PROCESS FILE
// Handles: Approve, Unapprove, Delete
// ============================================================

$commentObj = new Comment();

// ============================================================
// APPROVE / UNAPPROVE COMMENT
// ============================================================
if (isset($_POST['id']) && $page === 'admin-comments-approve') {

    $comment_id = (int)($_POST['id'] ?? 0);
    $unapprove  = isset($_POST['unapprove']) && $_POST['unapprove'] == 1;

    if ($comment_id > 0) {
        if ($unapprove) {
            $result = $commentObj->unapprove($comment_id);
            if ($result) {
                setFlash('success', 'Comment unapproved successfully.');
            } else {
                setFlash('error', 'Failed to unapprove comment.');
            }
        } else {
            $result = $commentObj->approve($comment_id);
            if ($result) {
                setFlash('success', 'Comment approved successfully.');
            } else {
                setFlash('error', 'Failed to approve comment.');
            }
        }
    }

    redirect('?page=admin-comments');
}

// ============================================================
// DELETE COMMENT
// ============================================================
if (isset($_POST['id']) && $page === 'admin-comments-delete') {

    $comment_id = (int)($_POST['id'] ?? 0);

    if ($comment_id > 0) {
        $deleted = $commentObj->delete($comment_id);

        if ($deleted) {
            setFlash('success', 'Comment deleted successfully.');
        } else {
            setFlash('error', 'Failed to delete comment.');
        }
    }

    redirect('?page=admin-comments');
}