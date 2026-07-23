<?php
session_start();

require_once '../config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/helpers.php';

// Autoload classes
require_once '../app/classes/Admin.php';
require_once '../app/classes/Project.php';
require_once '../app/classes/Property.php';
require_once '../app/classes/Construction.php';
require_once '../app/classes/Design.php';
require_once '../app/classes/Interior.php';
require_once '../app/classes/Comment.php';
require_once '../app/classes/Like.php';
require_once '../app/classes/ContactMessage.php';

// Get the page from URL
$page = isset($_GET['page']) ? sanitize($_GET['page']) : 'home';
$action = isset($_GET['action']) ? sanitize($_GET['action']) : null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Route map
$routes = [
    // Public routes
    'home'              => '../app/views/home/index.php',
    'about'             => '../app/views/about/index.php',

    // Services
    'architecture'      => '../app/views/services/architecture.php',
    'supervision'       => '../app/views/services/supervision.php',
    'construction'      => '../app/views/services/construction.php',
    'real-estate'       => '../app/views/services/real-estate.php',

    // Projects
    'projects'          => '../app/views/projects/index.php',
    'project-detail'    => '../app/views/projects/detail.php',

    // Properties
    'properties'        => '../app/views/properties/index.php',
    'property-detail'   => '../app/views/properties/detail.php',

    // Constructions
    'constructions'     => '../app/views/constructions/index.php',
    'construction-detail' => '../app/views/constructions/detail.php',

    // Designs
    'designs'           => '../app/views/designs/index.php',
    'design-detail'     => '../app/views/designs/detail.php',

    // Interiors
    'interiors'         => '../app/views/interiors/index.php',
    'interior-detail'   => '../app/views/interiors/detail.php',

    // Contact
    'contact'           => '../app/views/contact/index.php',

  // Like & Comment
    'like'              => '../app/processes/like.php',
    'comment'           => '../app/processes/comment.php',

    // Admin routes
    'admin'             => '../app/views/admin/login.php',
    'admin-login'       => '../app/views/admin/login.php',
    'admin-dashboard'   => '../app/views/admin/dashboard.php',

    // Admin Projects
    'admin-projects'            => '../app/views/admin/projects/index.php',
    'admin-projects-add'        => '../app/views/admin/projects/add.php',
    'admin-projects-edit'       => '../app/views/admin/projects/edit.php',
    'admin-projects-delete'     => '../app/views/admin/projects/delete.php',

    // Admin Properties
    'admin-properties'          => '../app/views/admin/properties/index.php',
    'admin-properties-add'      => '../app/views/admin/properties/add.php',
    'admin-properties-edit'     => '../app/views/admin/properties/edit.php',
    'admin-properties-delete'   => '../app/views/admin/properties/delete.php',

    // Admin Constructions
    'admin-constructions'        => '../app/views/admin/constructions/index.php',
    'admin-constructions-add'    => '../app/views/admin/constructions/add.php',
    'admin-constructions-edit'   => '../app/views/admin/constructions/edit.php',
    'admin-constructions-delete' => '../app/views/admin/constructions/delete.php',

    // Admin Designs
    'admin-designs'             => '../app/views/admin/designs/index.php',
    'admin-designs-add'         => '../app/views/admin/designs/add.php',
    'admin-designs-edit'        => '../app/views/admin/designs/edit.php',
    'admin-designs-delete'      => '../app/views/admin/designs/delete.php',

    // Admin Interiors
    'admin-interiors'           => '../app/views/admin/interiors/index.php',
    'admin-interiors-add'       => '../app/views/admin/interiors/add.php',
    'admin-interiors-edit'      => '../app/views/admin/interiors/edit.php',
    'admin-interiors-delete'    => '../app/views/admin/interiors/delete.php',

    // Admin Comments
    'admin-comments'            => '../app/views/admin/comments/index.php',
    'admin-comments-approve'    => '../app/views/admin/comments/approve.php',
    'admin-comments-delete'     => '../app/views/admin/comments/delete.php',

    // Admin Messages
    'admin-messages'            => '../app/views/admin/messages/index.php',
    'admin-messages-view'       => '../app/views/admin/messages/view.php',
];

// Handle logout
if ($page === 'admin-logout') {
    session_destroy();
    header('Location: ' . SITE_URL . '/?page=admin-login');
    exit();
}

// Run admin process files before loading views
$adminProcesses = [
    'like'                        => '../app/processes/like.php',
    'comment'                     => '../app/processes/comment.php',
    'contact'                     => '../app/processes/contact.php',
    'admin-projects-add'          => '../app/processes/admin/project.php',
    'admin-projects-edit'         => '../app/processes/admin/project.php',
    'admin-projects-delete'       => '../app/processes/admin/project.php',
    'admin-properties-add'        => '../app/processes/admin/property.php',
    'admin-properties-edit'       => '../app/processes/admin/property.php',
    'admin-properties-delete'     => '../app/processes/admin/property.php',
    'admin-constructions-add'     => '../app/processes/admin/construction.php',
    'admin-constructions-edit'    => '../app/processes/admin/construction.php',
    'admin-constructions-delete'  => '../app/processes/admin/construction.php',
    'admin-designs-add'           => '../app/processes/admin/design.php',
    'admin-designs-edit'          => '../app/processes/admin/design.php',
    'admin-designs-delete'        => '../app/processes/admin/design.php',
    'admin-interiors-add'         => '../app/processes/admin/interior.php',
    'admin-interiors-edit'        => '../app/processes/admin/interior.php',
    'admin-interiors-delete'      => '../app/processes/admin/interior.php',
    'admin-comments-approve'      => '../app/processes/admin/comment.php',
    'admin-comments-delete'       => '../app/processes/admin/comment.php',
    'admin-messages'              => '../app/processes/admin/message.php',
    'admin-messages-view'         => '../app/processes/admin/message.php',
];

if (array_key_exists($page, $adminProcesses)) {
    require_once $adminProcesses[$page];
}

// Load the page
if (array_key_exists($page, $routes)) {
    require_once $routes[$page];
} else {
    // 404 - page not found
    http_response_code(404);
    require_once '../app/views/home/index.php';
}