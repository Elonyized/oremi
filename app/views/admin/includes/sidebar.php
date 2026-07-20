<div class="admin-sidebar" id="adminSidebar">

    <!-- Sidebar Logo -->
    <div class="sidebar-logo">
        <a href="<?= SITE_URL ?>/?page=admin-dashboard">
            <span class="logo-text"><?= SITE_NAME ?></span>
            <span class="logo-dot">.</span>
        </a>
        <button class="sidebar-close-btn" id="sidebarCloseBtn">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <!-- Admin Info -->
    <div class="sidebar-admin-info">
        <div class="sidebar-admin-avatar">
            <i class="bi bi-person-fill"></i>
        </div>
        <div class="sidebar-admin-details">
            <span class="sidebar-admin-name">
                <?= htmlspecialchars($_SESSION['admin_name']) ?>
            </span>
            <span class="sidebar-admin-role">Administrator</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">

        <div class="sidebar-nav-label">Main</div>

        <a href="<?= SITE_URL ?>/?page=admin-dashboard" 
           class="sidebar-nav-link <?= ($page === 'admin-dashboard') ? 'active' : '' ?>">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>

        <div class="sidebar-nav-label mt-3">Content</div>

        <a href="<?= SITE_URL ?>/?page=admin-projects" 
           class="sidebar-nav-link <?= (strpos($page, 'admin-projects') !== false) ? 'active' : '' ?>">
            <i class="bi bi-folder"></i>
            <span>Projects</span>
        </a>

        <a href="<?= SITE_URL ?>/?page=admin-properties" 
           class="sidebar-nav-link <?= (strpos($page, 'admin-properties') !== false) ? 'active' : '' ?>">
            <i class="bi bi-buildings"></i>
            <span>Properties</span>
        </a>

        <a href="<?= SITE_URL ?>/?page=admin-constructions" 
           class="sidebar-nav-link <?= (strpos($page, 'admin-constructions') !== false) ? 'active' : '' ?>">
            <i class="bi bi-hammer"></i>
            <span>Constructions</span>
        </a>

        <a href="<?= SITE_URL ?>/?page=admin-designs" 
           class="sidebar-nav-link <?= (strpos($page, 'admin-designs') !== false) ? 'active' : '' ?>">
            <i class="bi bi-pen"></i>
            <span>Designs</span>
        </a>

        <a href="<?= SITE_URL ?>/?page=admin-interiors" 
           class="sidebar-nav-link <?= (strpos($page, 'admin-interiors') !== false) ? 'active' : '' ?>">
            <i class="bi bi-layout-text-window"></i>
            <span>Interiors</span>
        </a>

        <div class="sidebar-nav-label mt-3">Engagement</div>

        <a href="<?= SITE_URL ?>/?page=admin-comments" 
           class="sidebar-nav-link <?= (strpos($page, 'admin-comments') !== false) ? 'active' : '' ?>">
            <i class="bi bi-chat-dots"></i>
            <span>Comments</span>
            <?php 
                $commentObj = new Comment();
                $pending = $commentObj->getPendingCount();
                if ($pending > 0) :
            ?>
                <span class="sidebar-badge"><?= $pending ?></span>
            <?php endif; ?>
        </a>

        <a href="<?= SITE_URL ?>/?page=admin-messages" 
           class="sidebar-nav-link <?= (strpos($page, 'admin-messages') !== false) ? 'active' : '' ?>">
            <i class="bi bi-envelope"></i>
            <span>Messages</span>
            <?php 
                $messageObj = new ContactMessage();
                $unread = $messageObj->getUnreadCount();
                if ($unread > 0) :
            ?>
                <span class="sidebar-badge"><?= $unread ?></span>
            <?php endif; ?>
        </a>

        <div class="sidebar-nav-label mt-3">Account</div>

        <a href="<?= SITE_URL ?>/?page=home" 
           class="sidebar-nav-link" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i>
            <span>View Site</span>
        </a>

        <a href="<?= SITE_URL ?>/?page=admin-logout" 
           class="sidebar-nav-link sidebar-logout">
            <i class="bi bi-box-arrow-left"></i>
            <span>Logout</span>
        </a>

    </nav>
</div>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>