<div class="admin-topbar">

    <!-- Left - Hamburger Menu -->
    <button class="sidebar-toggle-btn" id="sidebarToggleBtn">
        <i class="bi bi-list"></i>
    </button>

    <!-- Page Breadcrumb -->
    <div class="topbar-breadcrumb">
        <a href="<?= SITE_URL ?>/?page=admin-dashboard">Admin</a>
        <i class="bi bi-chevron-right"></i>
        <span>
            <?php
                $pageTitles = [
                    'admin-dashboard'           => 'Dashboard',
                    'admin-projects'            => 'Projects',
                    'admin-projects-add'        => 'Add Project',
                    'admin-projects-edit'       => 'Edit Project',
                    'admin-properties'          => 'Properties',
                    'admin-properties-add'      => 'Add Property',
                    'admin-properties-edit'     => 'Edit Property',
                    'admin-constructions'       => 'Constructions',
                    'admin-constructions-add'   => 'Add Construction',
                    'admin-constructions-edit'  => 'Edit Construction',
                    'admin-designs'             => 'Designs',
                    'admin-designs-add'         => 'Add Design',
                    'admin-designs-edit'        => 'Edit Design',
                    'admin-interiors'           => 'Interiors',
                    'admin-interiors-add'       => 'Add Interior',
                    'admin-interiors-edit'      => 'Edit Interior',
                    'admin-comments'            => 'Comments',
                    'admin-messages'            => 'Messages',
                    'admin-messages-view'       => 'View Message',
                ];
                echo $pageTitles[$page] ?? 'Admin';
            ?>
        </span>
    </div>

    <!-- Right Side -->
    <div class="topbar-right">

        <!-- Unread Messages Bell -->
        <?php
            $messageObj = new ContactMessage();
            $unread = $messageObj->getUnreadCount();
        ?>
        <a href="<?= SITE_URL ?>/?page=admin-messages" class="topbar-icon-btn" title="Messages">
            <i class="bi bi-envelope"></i>
            <?php if ($unread > 0) : ?>
                <span class="topbar-badge"><?= $unread ?></span>
            <?php endif; ?>
        </a>

        <!-- Pending Comments Bell -->
        <?php
            $commentObj = new Comment();
            $pending = $commentObj->getPendingCount();
        ?>
        <a href="<?= SITE_URL ?>/?page=admin-comments" class="topbar-icon-btn" title="Pending Comments">
            <i class="bi bi-chat-dots"></i>
            <?php if ($pending > 0) : ?>
                <span class="topbar-badge"><?= $pending ?></span>
            <?php endif; ?>
        </a>

        <!-- View Site -->
        <a href="<?= SITE_URL ?>/?page=home" 
           class="topbar-icon-btn" 
           title="View Site" 
           target="_blank">
            <i class="bi bi-globe"></i>
        </a>

        <!-- Admin Name + Logout -->
        <div class="topbar-admin">
            <div class="topbar-admin-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="topbar-admin-info">
                <span class="topbar-admin-name">
                    <?= htmlspecialchars($_SESSION['admin_name']) ?>
                </span>
                <a href="<?= SITE_URL ?>/?page=admin-logout" class="topbar-logout">
                    <i class="bi bi-box-arrow-left me-1"></i>Logout
                </a>
            </div>
        </div>

    </div>
</div>