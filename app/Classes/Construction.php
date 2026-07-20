<?php

Class Construction {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConn();
    }

    // Get all construction projects
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT * FROM constructions ORDER BY created_at DESC";
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

    // Get single construction by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM constructions 
                WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Get total count
    public function getCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM constructions");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    // Get featured constructions for homepage (latest 4)
    public function getFeatured($limit = 4) {
        $stmt = $this->conn->prepare("SELECT * FROM constructions 
                ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Create new construction project
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO constructions 
                (title, description, location, progress_percent, expected_completion) 
                VALUES (:title, :description, :location, :progress_percent, :expected_completion)");
        $stmt->execute([
            ':title'               => $data['title'],
            ':description'         => $data['description'],
            ':location'            => $data['location'],
            ':progress_percent'    => $data['progress_percent'],
            ':expected_completion' => $data['expected_completion']
        ]);
        return $this->conn->lastInsertId();
    }

    // Update construction project
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE constructions SET 
                title = :title, 
                description = :description, 
                location = :location, 
                progress_percent = :progress_percent, 
                expected_completion = :expected_completion 
                WHERE id = :id");
        return $stmt->execute([
            ':title'               => $data['title'],
            ':description'         => $data['description'],
            ':location'            => $data['location'],
            ':progress_percent'    => $data['progress_percent'],
            ':expected_completion' => $data['expected_completion'],
            ':id'                  => $id
        ]);
    }

    // Delete construction project
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM constructions WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // -------------------------------------------------------
    // CONSTRUCTION IMAGES
    // -------------------------------------------------------

    // Add image to construction
    public function addImage($construction_id, $image_path, $is_cover = 0) {
        $stmt = $this->conn->prepare("INSERT INTO construction_images 
                (construction_id, image_path, is_cover) 
                VALUES (:construction_id, :image_path, :is_cover)");
        return $stmt->execute([
            ':construction_id' => $construction_id,
            ':image_path'      => $image_path,
            ':is_cover'        => $is_cover
        ]);
    }

    // Get all images for a construction
    public function getImages($construction_id) {
        $stmt = $this->conn->prepare("SELECT * FROM construction_images 
                WHERE construction_id = :construction_id");
        $stmt->execute([':construction_id' => $construction_id]);
        return $stmt->fetchAll();
    }

    // Get cover image for a construction
    public function getCoverImage($construction_id) {
        $stmt = $this->conn->prepare("SELECT * FROM construction_images 
                WHERE construction_id = :construction_id AND is_cover = 1 LIMIT 1");
        $stmt->execute([':construction_id' => $construction_id]);
        $cover = $stmt->fetch();
        if (!$cover) {
            $stmt = $this->conn->prepare("SELECT * FROM construction_images 
                    WHERE construction_id = :construction_id LIMIT 1");
            $stmt->execute([':construction_id' => $construction_id]);
            $cover = $stmt->fetch();
        }
        return $cover;
    }

    // Set cover image
    public function setCoverImage($construction_id, $image_id) {
        $stmt = $this->conn->prepare("UPDATE construction_images 
                SET is_cover = 0 WHERE construction_id = :construction_id");
        $stmt->execute([':construction_id' => $construction_id]);

        $stmt = $this->conn->prepare("UPDATE construction_images 
                SET is_cover = 1 WHERE id = :id AND construction_id = :construction_id");
        return $stmt->execute([
            ':id'              => $image_id,
            ':construction_id' => $construction_id
        ]);
    }

    // Delete single image
    public function deleteImage($image_id) {
        $stmt = $this->conn->prepare("SELECT * FROM construction_images WHERE id = :id");
        $stmt->execute([':id' => $image_id]);
        $image = $stmt->fetch();

        if ($image) {
            $filePath = UPLOAD_PATH . 'constructions/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $stmt = $this->conn->prepare("DELETE FROM construction_images WHERE id = :id");
            return $stmt->execute([':id' => $image_id]);
        }
        return false;
    }

    // Delete all images for a construction
    public function deleteAllImages($construction_id) {
        $images = $this->getImages($construction_id);
        foreach ($images as $image) {
            $filePath = UPLOAD_PATH . 'constructions/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $stmt = $this->conn->prepare("DELETE FROM construction_images 
                WHERE construction_id = :construction_id");
        return $stmt->execute([':construction_id' => $construction_id]);
    }
}