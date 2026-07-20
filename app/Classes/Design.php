<?php

Class Design {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConn();
    }

    // Get all designs
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT * FROM designs ORDER BY created_at DESC";
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

    // Get single design by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM designs 
                WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Get total count
    public function getCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM designs");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    // Get featured designs for homepage (latest 4)
    public function getFeatured($limit = 4) {
        $stmt = $this->conn->prepare("SELECT * FROM designs 
                ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Create new design
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO designs 
                (title, description, pdf_path, price) 
                VALUES (:title, :description, :pdf_path, :price)");
        $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':pdf_path'    => $data['pdf_path'] ?? null,
            ':price'       => $data['price'] ?? 0.00
        ]);
        return $this->conn->lastInsertId();
    }

    // Update design
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE designs SET 
                title = :title, 
                description = :description, 
                pdf_path = :pdf_path, 
                price = :price 
                WHERE id = :id");
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':pdf_path'    => $data['pdf_path'] ?? null,
            ':price'       => $data['price'] ?? 0.00,
            ':id'          => $id
        ]);
    }

    // Delete design
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM designs WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Delete PDF file from server
    public function deletePDF($design_id) {
        $design = $this->getById($design_id);
        if ($design && $design['pdf_path']) {
            $filePath = UPLOAD_PATH . 'pdfs/' . $design['pdf_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    // Update PDF path only
    public function updatePDF($id, $pdf_path) {
        $stmt = $this->conn->prepare("UPDATE designs SET pdf_path = :pdf_path WHERE id = :id");
        return $stmt->execute([
            ':pdf_path' => $pdf_path,
            ':id'       => $id
        ]);
    }

    // -------------------------------------------------------
    // DESIGN IMAGES
    // -------------------------------------------------------

    // Add image to design
    public function addImage($design_id, $image_path, $is_cover = 0) {
        $stmt = $this->conn->prepare("INSERT INTO design_images 
                (design_id, image_path, is_cover) 
                VALUES (:design_id, :image_path, :is_cover)");
        return $stmt->execute([
            ':design_id'   => $design_id,
            ':image_path'  => $image_path,
            ':is_cover'    => $is_cover
        ]);
    }

    // Get all images for a design
    public function getImages($design_id) {
        $stmt = $this->conn->prepare("SELECT * FROM design_images 
                WHERE design_id = :design_id");
        $stmt->execute([':design_id' => $design_id]);
        return $stmt->fetchAll();
    }

    // Get cover image for a design
    public function getCoverImage($design_id) {
        $stmt = $this->conn->prepare("SELECT * FROM design_images 
                WHERE design_id = :design_id AND is_cover = 1 LIMIT 1");
        $stmt->execute([':design_id' => $design_id]);
        $cover = $stmt->fetch();
        if (!$cover) {
            $stmt = $this->conn->prepare("SELECT * FROM design_images 
                    WHERE design_id = :design_id LIMIT 1");
            $stmt->execute([':design_id' => $design_id]);
            $cover = $stmt->fetch();
        }
        return $cover;
    }

    // Set cover image
    public function setCoverImage($design_id, $image_id) {
        $stmt = $this->conn->prepare("UPDATE design_images 
                SET is_cover = 0 WHERE design_id = :design_id");
        $stmt->execute([':design_id' => $design_id]);

        $stmt = $this->conn->prepare("UPDATE design_images 
                SET is_cover = 1 WHERE id = :id AND design_id = :design_id");
        return $stmt->execute([
            ':id'        => $image_id,
            ':design_id' => $design_id
        ]);
    }

    // Delete single image
    public function deleteImage($image_id) {
        $stmt = $this->conn->prepare("SELECT * FROM design_images WHERE id = :id");
        $stmt->execute([':id' => $image_id]);
        $image = $stmt->fetch();

        if ($image) {
            $filePath = UPLOAD_PATH . 'designs/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $stmt = $this->conn->prepare("DELETE FROM design_images WHERE id = :id");
            return $stmt->execute([':id' => $image_id]);
        }
        return false;
    }

    // Delete all images for a design
    public function deleteAllImages($design_id) {
        $images = $this->getImages($design_id);
        foreach ($images as $image) {
            $filePath = UPLOAD_PATH . 'designs/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $stmt = $this->conn->prepare("DELETE FROM design_images 
                WHERE design_id = :design_id");
        return $stmt->execute([':design_id' => $design_id]);
    }
}