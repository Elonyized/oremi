<?php

Class Interior {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConn();
    }

    // Get all interiors
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT * FROM interiors ORDER BY created_at DESC";
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

    // Get interiors by style
    public function getByStyle($style, $limit = null, $offset = 0) {
        $sql = "SELECT * FROM interiors 
                WHERE style = :style 
                ORDER BY created_at DESC";
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':style', $style);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        } else {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':style', $style);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get single interior by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM interiors 
                WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Get total count
    public function getCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM interiors");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    // Get featured interiors for homepage (latest 4)
    public function getFeatured($limit = 4) {
        $stmt = $this->conn->prepare("SELECT * FROM interiors 
                ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get all distinct styles for filter
    public function getStyles() {
        $stmt = $this->conn->prepare("SELECT DISTINCT style 
                FROM interiors 
                WHERE style IS NOT NULL AND style != '' 
                ORDER BY style ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Create new interior
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO interiors 
                (title, description, style) 
                VALUES (:title, :description, :style)");
        $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':style'       => $data['style'] ?? null
        ]);
        return $this->conn->lastInsertId();
    }

    // Update interior
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE interiors SET 
                title = :title, 
                description = :description, 
                style = :style 
                WHERE id = :id");
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':style'       => $data['style'] ?? null,
            ':id'          => $id
        ]);
    }

    // Delete interior
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM interiors WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // -------------------------------------------------------
    // INTERIOR IMAGES
    // -------------------------------------------------------

    // Add image to interior
    public function addImage($interior_id, $image_path, $is_cover = 0) {
        $stmt = $this->conn->prepare("INSERT INTO interior_images 
                (interior_id, image_path, is_cover) 
                VALUES (:interior_id, :image_path, :is_cover)");
        return $stmt->execute([
            ':interior_id' => $interior_id,
            ':image_path'  => $image_path,
            ':is_cover'    => $is_cover
        ]);
    }

    // Get all images for an interior
    public function getImages($interior_id) {
        $stmt = $this->conn->prepare("SELECT * FROM interior_images 
                WHERE interior_id = :interior_id");
        $stmt->execute([':interior_id' => $interior_id]);
        return $stmt->fetchAll();
    }

    // Get cover image for an interior
    public function getCoverImage($interior_id) {
        $stmt = $this->conn->prepare("SELECT * FROM interior_images 
                WHERE interior_id = :interior_id AND is_cover = 1 LIMIT 1");
        $stmt->execute([':interior_id' => $interior_id]);
        $cover = $stmt->fetch();
        if (!$cover) {
            $stmt = $this->conn->prepare("SELECT * FROM interior_images 
                    WHERE interior_id = :interior_id LIMIT 1");
            $stmt->execute([':interior_id' => $interior_id]);
            $cover = $stmt->fetch();
        }
        return $cover;
    }

    // Set cover image
    public function setCoverImage($interior_id, $image_id) {
        $stmt = $this->conn->prepare("UPDATE interior_images 
                SET is_cover = 0 WHERE interior_id = :interior_id");
        $stmt->execute([':interior_id' => $interior_id]);

        $stmt = $this->conn->prepare("UPDATE interior_images 
                SET is_cover = 1 WHERE id = :id AND interior_id = :interior_id");
        return $stmt->execute([
            ':id'          => $image_id,
            ':interior_id' => $interior_id
        ]);
    }

    // Delete single image
    public function deleteImage($image_id) {
        $stmt = $this->conn->prepare("SELECT * FROM interior_images WHERE id = :id");
        $stmt->execute([':id' => $image_id]);
        $image = $stmt->fetch();

        if ($image) {
            $filePath = UPLOAD_PATH . 'interiors/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $stmt = $this->conn->prepare("DELETE FROM interior_images WHERE id = :id");
            return $stmt->execute([':id' => $image_id]);
        }
        return false;
    }

    // Delete all images for an interior
    public function deleteAllImages($interior_id) {
        $images = $this->getImages($interior_id);
        foreach ($images as $image) {
            $filePath = UPLOAD_PATH . 'interiors/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $stmt = $this->conn->prepare("DELETE FROM interior_images 
                WHERE interior_id = :interior_id");
        return $stmt->execute([':interior_id' => $interior_id]);
    }
}