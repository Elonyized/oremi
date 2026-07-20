<?php

Class Admin {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConn();
    }

    // Login admin
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM admins WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }

    // Get admin by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM admins WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Update admin profile
    public function updateProfile($id, $name, $email) {
        $stmt = $this->conn->prepare("UPDATE admins SET name = :name, email = :email WHERE id = :id");
        return $stmt->execute([
            ':name'  => $name,
            ':email' => $email,
            ':id'    => $id
        ]);
    }

    // Update admin password
    public function updatePassword($id, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE admins SET password = :password WHERE id = :id");
        return $stmt->execute([
            ':password' => $hashed,
            ':id'       => $id
        ]);
    }

    // Create first admin (run once during setup)
    public function createAdmin($name, $email, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO admins (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':password' => $hashed
        ]);
    }
}