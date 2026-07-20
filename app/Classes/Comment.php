<?php

Class Comment {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConn();
    }

    // Get all comments (admin)
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT * FROM comments ORDER BY created_at DESC";
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        } else {
            $stmt = $this->conn->prepare($sql);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get approved comments for a specific content
    public function getApproved($content_type, $content_id) {
        $stmt = $this->conn->prepare("SELECT * FROM comments 
                WHERE content_type = :content_type 
                AND content_id = :content_id 
                AND is_approved = 1 
                ORDER BY created_at DESC");
        $stmt->execute([
            ':content_type' => $content_type,
            ':content_id'   => $content_id
        ]);
        return $stmt->fetchAll();
    }

    // Get all pending comments (not yet approved)
    public function getPending() {
        $stmt = $this->conn->prepare("SELECT * FROM comments 
                WHERE is_approved = 0 
                ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get pending comments count
    public function getPendingCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total 
                FROM comments WHERE is_approved = 0");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    // Get total comments count
    public function getCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM comments");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    // Get comment count for a specific content
    public function getCountForContent($content_type, $content_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM comments 
                WHERE content_type = :content_type 
                AND content_id = :content_id 
                AND is_approved = 1");
        $stmt->execute([
            ':content_type' => $content_type,
            ':content_id'   => $content_id
        ]);
        return $stmt->fetch()['total'];
    }

    // Add new comment
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO comments 
                (content_type, content_id, name, email, comment) 
                VALUES (:content_type, :content_id, :name, :email, :comment)");
        return $stmt->execute([
            ':content_type' => $data['content_type'],
            ':content_id'   => $data['content_id'],
            ':name'         => $data['name'],
            ':email'        => $data['email'],
            ':comment'      => $data['comment']
        ]);
    }

    // Approve a comment
    public function approve($id) {
        $stmt = $this->conn->prepare("UPDATE comments 
                SET is_approved = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Unapprove a comment
    public function unapprove($id) {
        $stmt = $this->conn->prepare("UPDATE comments 
                SET is_approved = 0 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Delete a comment
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM comments WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Delete all comments for a specific content
    public function deleteForContent($content_type, $content_id) {
        $stmt = $this->conn->prepare("DELETE FROM comments 
                WHERE content_type = :content_type 
                AND content_id = :content_id");
        return $stmt->execute([
            ':content_type' => $content_type,
            ':content_id'   => $content_id
        ]);
    }

    // Get single comment by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM comments WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}