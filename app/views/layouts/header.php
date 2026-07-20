<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= SITE_NAME ?> — Professional Architecture, Construction & Real Estate Platform in Nigeria">
    <meta name="keywords" content="architecture, construction, real estate, interior design, Nigeria, building, property">
    <meta name="author" content="<?= SITE_NAME ?>">

    <title><?= isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand" href="<?= SITE_URL ?>/?page=home">
            <span class="logo-text"><?= SITE_NAME ?></span>
            <span class="logo-dot">.</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <i class="bi bi-list navbar-toggler-icon-custom"></i>
        </button>

        <!-- Desktop Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link <?= ($page === 'home') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page === 'about') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=about">About</a>
                </li>

                <!-- Services Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array($page, ['architecture','supervision','construction','real-estate']) ? 'active' : '' ?>" href="#" data-bs-toggle="dropdown">Services</a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= SITE_URL ?>/?page=architecture">
                                <i class="bi bi-building me-2"></i>Architectural Designs
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= SITE_URL ?>/?page=supervision">
                                <i class="bi bi-eye me-2"></i>Supervision of Projects
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= SITE_URL ?>/?page=construction">
                                <i class="bi bi-hammer me-2"></i>Building Construction
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= SITE_URL ?>/?page=real-estate">
                                <i class="bi bi-house me-2"></i>Real Estate Management
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($page === 'projects') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=projects">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page === 'properties') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=properties">Properties</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page === 'designs') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=designs">Designs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page === 'interiors') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=interiors">Interiors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page === 'contact') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=contact">Contact</a>
                </li>

                <!-- Dark Mode Toggle -->
                <li class="nav-item ms-2">
                    <button class="btn btn-theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
                        <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- MOBILE MENU (Offcanvas) -->
<div class="offcanvas offcanvas-end" id="mobileMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">
            <span class="logo-text"><?= SITE_NAME ?></span>
            <span class="logo-dot">.</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?= ($page === 'home') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=home">
                    <i class="bi bi-house me-2"></i>Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($page === 'about') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=about">
                    <i class="bi bi-person me-2"></i>About
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#mobileServices">
                    <i class="bi bi-grid me-2"></i>Services
                    <i class="bi bi-chevron-down float-end"></i>
                </a>
                <div class="collapse" id="mobileServices">
                    <ul class="navbar-nav ps-3">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>/?page=architecture">
                                <i class="bi bi-building me-2"></i>Architectural Designs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>/?page=supervision">
                                <i class="bi bi-eye me-2"></i>Supervision of Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>/?page=construction">
                                <i class="bi bi-hammer me-2"></i>Building Construction
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>/?page=real-estate">
                                <i class="bi bi-house me-2"></i>Real Estate Management
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($page === 'projects') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=projects">
                    <i class="bi bi-folder me-2"></i>Projects
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($page === 'properties') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=properties">
                    <i class="bi bi-buildings me-2"></i>Properties
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($page === 'designs') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=designs">
                    <i class="bi bi-pen me-2"></i>Designs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($page === 'interiors') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=interiors">
                    <i class="bi bi-layout-text-window me-2"></i>Interiors
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($page === 'contact') ? 'active' : '' ?>" href="<?= SITE_URL ?>/?page=contact">
                    <i class="bi bi-envelope me-2"></i>Contact
                </a>
            </li>

            <!-- Dark Mode Toggle Mobile -->
            <li class="nav-item mt-3">
                <button class="btn btn-theme-toggle w-100" id="themeToggleMobile">
                    <i class="bi bi-moon-stars-fill me-2"></i>Toggle Dark/Light Mode
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- PAGE CONTENT STARTS HERE -->
<main>