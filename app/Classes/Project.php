<?php

Class Project {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConn();
    }

    // Get all projects
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
                FROM projects p 
                JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
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

    // Get projects by category slug
    public function getByCategory($slug, $limit = null, $offset = 0) {
        $sql = "SELECT p.*, c.name AS category_name 
                FROM projects p 
                JOIN categories c ON p.category_id = c.id 
                WHERE c.slug = :slug 
                ORDER BY p.created_at DESC";
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':slug', $slug);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        } else {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':slug', $slug);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get single project by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT p.*, c.name AS category_name 
                FROM projects p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Get total project count
    public function getCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM projects");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    // Get featured projects (latest 6)
    public function getFeatured($limit = 6) {
        $stmt = $this->conn->prepare("SELECT p.*, c.name AS category_name 
                FROM projects p 
                JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Add new project
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO projects 
                (category_id, title, description, location, status) 
                VALUES (:category_id, :title, :description, :location, :status)");
        $stmt->execute([
            ':category_id'  => $data['category_id'],
            ':title'        => $data['title'],
            ':description'  => $data['description'],
            ':location'     => $data['location'],
            ':status'       => $data['status']
        ]);
        return $this->conn->lastInsertId();
    }

    // Update project
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE projects SET 
                category_id = :category_id, 
                title = :title, 
                description = :description, 
                location = :location, 
                status = :status 
                WHERE id = :id");
        return $stmt->execute([
            ':category_id'  => $data['category_id'],
            ':title'        => $data['title'],
            ':description'  => $data['description'],
            ':location'     => $data['location'],
            ':status'       => $data['status'],
            ':id'           => $id
        ]);
    }

    // Delete project
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM projects WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // -------------------------------------------------------
    // PROJECT IMAGES
    // -------------------------------------------------------

    // Add image to project
    public function addImage($project_id, $image_path, $is_cover = 0) {
        $stmt = $this->conn->prepare("INSERT INTO project_images 
                (project_id, image_path, is_cover) 
                VALUES (:project_id, :image_path, :is_cover)");
        return $stmt->execute([
            ':project_id'  => $project_id,
            ':image_path'  => $image_path,
            ':is_cover'    => $is_cover
        ]);
    }

    // Get all images for a project
    public function getImages($project_id) {
        $stmt = $this->conn->prepare("SELECT * FROM project_images 
                WHERE project_id = :project_id");
        $stmt->execute([':project_id' => $project_id]);
        return $stmt->fetchAll();
    }

    // Get cover image for a project
    public function getCoverImage($project_id) {
        $stmt = $this->conn->prepare("SELECT * FROM project_images 
                WHERE project_id = :project_id AND is_cover = 1 LIMIT 1");
        $stmt->execute([':project_id' => $project_id]);
        $cover = $stmt->fetch();
        if (!$cover) {
            $stmt = $this->conn->prepare("SELECT * FROM project_images 
                    WHERE project_id = :project_id LIMIT 1");
            $stmt->execute([':project_id' => $project_id]);
            $cover = $stmt->fetch();
        }
        return $cover;
    }

    // Set cover image
    public function setCoverImage($project_id, $image_id) {
        // Remove current cover
        $stmt = $this->conn->prepare("UPDATE project_images 
                SET is_cover = 0 WHERE project_id = :project_id");
        $stmt->execute([':project_id' => $project_id]);

        // Set new cover
        $stmt = $this->conn->prepare("UPDATE project_images 
                SET is_cover = 1 WHERE id = :id AND project_id = :project_id");
        return $stmt->execute([
            ':id'         => $image_id,
            ':project_id' => $project_id
        ]);
    }

    // Delete single image
    public function deleteImage($image_id) {
        // Get image path first so we can delete the file
        $stmt = $this->conn->prepare("SELECT * FROM project_images WHERE id = :id");
        $stmt->execute([':id' => $image_id]);
        $image = $stmt->fetch();

        if ($image) {
            $filePath = UPLOAD_PATH . 'projects/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $stmt = $this->conn->prepare("DELETE FROM project_images WHERE id = :id");
            return $stmt->execute([':id' => $image_id]);
        }
        return false;
    }

    // Delete all images for a project
    public function deleteAllImages($project_id) {
        $images = $this->getImages($project_id);
        foreach ($images as $image) {
            $filePath = UPLOAD_PATH . 'projects/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $stmt = $this->conn->prepare("DELETE FROM project_images WHERE project_id = :project_id");
        return $stmt->execute([':project_id' => $project_id]);
    }

    // Get all categories
    public function getCategories() {
        $stmt = $this->conn->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}