<?php

Class ContactMessage {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConn();
    }

    // Get all messages
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
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

    // Get single message by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM contact_messages 
                WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Get unread messages
    public function getUnread() {
        $stmt = $this->conn->prepare("SELECT * FROM contact_messages 
                WHERE is_read = 0 
                ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get unread messages count
    public function getUnreadCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total 
                FROM contact_messages WHERE is_read = 0");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    // Get total messages count
    public function getCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total 
                FROM contact_messages");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    // Save new message
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO contact_messages 
                (name, email, phone, message) 
                VALUES (:name, :email, :phone, :message)");
        return $stmt->execute([
            ':name'    => $data['name'],
            ':email'   => $data['email'],
            ':phone'   => $data['phone'] ?? null,
            ':message' => $data['message']
        ]);
    }

    // Mark message as read
    public function markRead($id) {
        $stmt = $this->conn->prepare("UPDATE contact_messages 
                SET is_read = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Mark message as unread
    public function markUnread($id) {
        $stmt = $this->conn->prepare("UPDATE contact_messages 
                SET is_read = 0 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Mark all messages as read
    public function markAllRead() {
        $stmt = $this->conn->prepare("UPDATE contact_messages SET is_read = 1");
        return $stmt->execute();
    }

    // Delete a message
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM contact_messages WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}