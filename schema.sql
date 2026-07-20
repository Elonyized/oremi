-- schema.sql

-- --------------------------------------------------------
-- DATABASE
-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS oremi_db;
USE oremi_db;

-- --------------------------------------------------------
-- ADMINS
-- --------------------------------------------------------
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------
-- CATEGORIES
-- (Architecture, Construction, Supervision, Real Estate)
-- --------------------------------------------------------
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
);

-- Default categories
INSERT INTO categories (name, slug) VALUES
('Architectural Designs & Consultancy', 'architecture'),
('Supervision of Projects', 'supervision'),
('Building Construction', 'construction'),
('Real Estate Management', 'real-estate');

-- --------------------------------------------------------
-- PROJECTS (completed portfolio work)
-- --------------------------------------------------------
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    location VARCHAR(200),
    status ENUM('completed', 'ongoing') DEFAULT 'completed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE project_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_cover TINYINT(1) DEFAULT 0,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- PROPERTIES (for sale or rent)
-- --------------------------------------------------------
CREATE TABLE properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    location VARCHAR(200),
    price DECIMAL(15,2),
    listing_type ENUM('sale', 'rent') NOT NULL,
    status ENUM('available', 'sold', 'rented') DEFAULT 'available',
    bedrooms INT DEFAULT 0,
    bathrooms INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE property_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_cover TINYINT(1) DEFAULT 0,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- CONSTRUCTIONS (under construction / ongoing builds)
-- --------------------------------------------------------
CREATE TABLE constructions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    location VARCHAR(200),
    progress_percent INT DEFAULT 0,
    expected_completion DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE construction_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    construction_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_cover TINYINT(1) DEFAULT 0,
    FOREIGN KEY (construction_id) REFERENCES constructions(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- ARCHITECTURAL DESIGNS (drawings + PDF plans)
-- --------------------------------------------------------
CREATE TABLE designs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    pdf_path VARCHAR(255),
    price DECIMAL(15,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE design_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    design_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_cover TINYINT(1) DEFAULT 0,
    FOREIGN KEY (design_id) REFERENCES designs(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- INTERIOR DESIGNS
-- --------------------------------------------------------
CREATE TABLE interiors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    style VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE interior_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    interior_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_cover TINYINT(1) DEFAULT 0,
    FOREIGN KEY (interior_id) REFERENCES interiors(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- COMMENTS (polymorphic - works across all content types)
-- --------------------------------------------------------
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_type ENUM('project', 'property', 'construction', 'design', 'interior') NOT NULL,
    content_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    comment TEXT NOT NULL,
    is_approved TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------
-- LIKES (polymorphic - tracked by IP)
-- --------------------------------------------------------
CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_type ENUM('project', 'property', 'construction', 'design', 'interior') NOT NULL,
    content_id INT NOT NULL,
    ip_address VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_like (content_type, content_id, ip_address)
);

-- --------------------------------------------------------
-- CONTACT MESSAGES
-- --------------------------------------------------------
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);