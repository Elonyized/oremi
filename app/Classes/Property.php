<?php

Class Property {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConn();
    }

    // Get all properties
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT * FROM properties ORDER BY created_at DESC";
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

    // Get properties by listing type (sale or rent)
    public function getByType($type, $limit = null, $offset = 0) {
        $sql = "SELECT * FROM properties 
                WHERE listing_type = :type 
                ORDER BY created_at DESC";
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':type', $type);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        } else {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':type', $type);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get available properties only
    public function getAvailable($limit = null, $offset = 0) {
        $sql = "SELECT * FROM properties 
                WHERE status = 'available' 
                ORDER BY created_at DESC";
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

    // Get single property by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM properties 
                WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Get total property count
    public function getCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM properties");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    // Get featured properties for homepage (latest 6)
    public function getFeatured($limit = 6) {
        $stmt = $this->conn->prepare("SELECT * FROM properties 
                WHERE status = 'available' 
                ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Create new property
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO properties 
                (title, description, location, price, listing_type, status, bedrooms, bathrooms) 
                VALUES (:title, :description, :location, :price, :listing_type, :status, :bedrooms, :bathrooms)");
        $stmt->execute([
            ':title'        => $data['title'],
            ':description'  => $data['description'],
            ':location'     => $data['location'],
            ':price'        => $data['price'],
            ':listing_type' => $data['listing_type'],
            ':status'       => $data['status'],
            ':bedrooms'     => $data['bedrooms'],
            ':bathrooms'    => $data['bathrooms']
        ]);
        return $this->conn->lastInsertId();
    }

    // Update property
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE properties SET 
                title = :title, 
                description = :description, 
                location = :location, 
                price = :price, 
                listing_type = :listing_type, 
                status = :status, 
                bedrooms = :bedrooms, 
                bathrooms = :bathrooms 
                WHERE id = :id");
        return $stmt->execute([
            ':title'        => $data['title'],
            ':description'  => $data['description'],
            ':location'     => $data['location'],
            ':price'        => $data['price'],
            ':listing_type' => $data['listing_type'],
            ':status'       => $data['status'],
            ':bedrooms'     => $data['bedrooms'],
            ':bathrooms'    => $data['bathrooms'],
            ':id'           => $id
        ]);
    }

    // Delete property
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM properties WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // -------------------------------------------------------
    // PROPERTY IMAGES
    // -------------------------------------------------------

    // Add image to property
    public function addImage($property_id, $image_path, $is_cover = 0) {
        $stmt = $this->conn->prepare("INSERT INTO property_images 
                (property_id, image_path, is_cover) 
                VALUES (:property_id, :image_path, :is_cover)");
        return $stmt->execute([
            ':property_id' => $property_id,
            ':image_path'  => $image_path,
            ':is_cover'    => $is_cover
        ]);
    }

    // Get all images for a property
    public function getImages($property_id) {
        $stmt = $this->conn->prepare("SELECT * FROM property_images 
                WHERE property_id = :property_id");
        $stmt->execute([':property_id' => $property_id]);
        return $stmt->fetchAll();
    }

    // Get cover image for a property
    public function getCoverImage($property_id) {
        $stmt = $this->conn->prepare("SELECT * FROM property_images 
                WHERE property_id = :property_id AND is_cover = 1 LIMIT 1");
        $stmt->execute([':property_id' => $property_id]);
        $cover = $stmt->fetch();
        if (!$cover) {
            $stmt = $this->conn->prepare("SELECT * FROM property_images 
                    WHERE property_id = :property_id LIMIT 1");
            $stmt->execute([':property_id' => $property_id]);
            $cover = $stmt->fetch();
        }
        return $cover;
    }

    // Set cover image
    public function setCoverImage($property_id, $image_id) {
        $stmt = $this->conn->prepare("UPDATE property_images 
                SET is_cover = 0 WHERE property_id = :property_id");
        $stmt->execute([':property_id' => $property_id]);

        $stmt = $this->conn->prepare("UPDATE property_images 
                SET is_cover = 1 WHERE id = :id AND property_id = :property_id");
        return $stmt->execute([
            ':id'          => $image_id,
            ':property_id' => $property_id
        ]);
    }

    // Delete single image
    public function deleteImage($image_id) {
        $stmt = $this->conn->prepare("SELECT * FROM property_images WHERE id = :id");
        $stmt->execute([':id' => $image_id]);
        $image = $stmt->fetch();

        if ($image) {
            $filePath = UPLOAD_PATH . 'properties/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $stmt = $this->conn->prepare("DELETE FROM property_images WHERE id = :id");
            return $stmt->execute([':id' => $image_id]);
        }
        return false;
    }

    // Delete all images for a property
    public function deleteAllImages($property_id) {
        $images = $this->getImages($property_id);
        foreach ($images as $image) {
            $filePath = UPLOAD_PATH . 'properties/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $stmt = $this->conn->prepare("DELETE FROM property_images 
                WHERE property_id = :property_id");
        return $stmt->execute([':property_id' => $property_id]);
    }
}