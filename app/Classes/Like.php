<?php

Class Like {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConn();
    }

    // Get like count for a specific content
    public function getCount($content_type, $content_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM likes 
                WHERE content_type = :content_type 
                AND content_id = :content_id");
        $stmt->execute([
            ':content_type' => $content_type,
            ':content_id'   => $content_id
        ]);
        return $stmt->fetch()['total'];
    }

    // Check if a visitor has already liked a content
    public function hasLiked($content_type, $content_id, $ip_address) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM likes 
                WHERE content_type = :content_type 
                AND content_id = :content_id 
                AND ip_address = :ip_address");
        $stmt->execute([
            ':content_type' => $content_type,
            ':content_id'   => $content_id,
            ':ip_address'   => $ip_address
        ]);
        return $stmt->fetch()['total'] > 0;
    }

    // Add a like
    public function add($content_type, $content_id, $ip_address) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO likes 
                    (content_type, content_id, ip_address) 
                    VALUES (:content_type, :content_id, :ip_address)");
            return $stmt->execute([
                ':content_type' => $content_type,
                ':content_id'   => $content_id,
                ':ip_address'   => $ip_address
            ]);
        } catch (PDOException $e) {
            // Unique constraint will catch duplicate likes
            return false;
        }
    }

    // Remove a like (unlike)
    public function remove($content_type, $content_id, $ip_address) {
        $stmt = $this->conn->prepare("DELETE FROM likes 
                WHERE content_type = :content_type 
                AND content_id = :content_id 
                AND ip_address = :ip_address");
        return $stmt->execute([
            ':content_type' => $content_type,
            ':content_id'   => $content_id,
            ':ip_address'   => $ip_address
        ]);
    }

    // Toggle like — if liked remove it, if not liked add it
    public function toggle($content_type, $content_id, $ip_address) {
        if ($this->hasLiked($content_type, $content_id, $ip_address)) {
            $this->remove($content_type, $content_id, $ip_address);
            $action = 'unliked';
        } else {
            $this->add($content_type, $content_id, $ip_address);
            $action = 'liked';
        }
        return [
            'action' => $action,
            'count'  => $this->getCount($content_type, $content_id)
        ];
    }

    // Delete all likes for a specific content
    public function deleteForContent($content_type, $content_id) {
        $stmt = $this->conn->prepare("DELETE FROM likes 
                WHERE content_type = :content_type 
                AND content_id = :content_id");
        return $stmt->execute([
            ':content_type' => $content_type,
            ':content_id'   => $content_id
        ]);
    }

    // Get total likes count (for admin dashboard)
    public function getTotalCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM likes");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }
}