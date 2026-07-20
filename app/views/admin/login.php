<?php

// If already logged in redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: ' . SITE_URL . '/?page=admin-dashboard');
    exit();
}

// Handle login form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter your email and password.';
    } else {
        $admin = new Admin();
        $result = $admin->login($email, $password);

        if ($result) {
            $_SESSION['admin_id']   = $result['id'];
            $_SESSION['admin_name'] = $result['name'];
            header('Location: ' . SITE_URL . '/?page=admin-dashboard');
            exit();
        } else {
            $error = 'Invalid email or password. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?= SITE_NAME ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">

    <style>
        .admin-login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-primary);
            padding: 20px;
        }

        .login-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-gold);
            border-radius: 4px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: var(--shadow-gold);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .login-logo .logo-dot {
            color: var(--accent-gold);
            font-size: 2.5rem;
            font-weight: 700;
        }

        .login-title {
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--accent-gold);
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-divider {
            width: 40px;
            height: 2px;
            background: var(--accent-gold);
            margin: 0 auto 2rem;
        }
    </style>
</head>
<body>

<div class="admin-login-page">
    <div class="login-card">

        <!-- Logo -->
        <div class="login-logo">
            <span class="logo-text"><?= SITE_NAME ?></span>
            <span class="logo-dot">.</span>
        </div>

        <p class="login-title">Admin Panel</p>
        <div class="login-divider"></div>

        <!-- Error Message -->
        <?php if (!empty($error)) : ?>
            <div class="flash-message flash-error mb-4">
                <i class="bi bi-exclamation-circle"></i>
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="">

            <div class="form-group-custom">
                <label class="form-label-custom">
                    <i class="bi bi-envelope me-1"></i>Email Address
                </label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control-custom" 
                    placeholder="Enter your email"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required>
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">
                    <i class="bi bi-lock me-1"></i>Password
                </label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        name="password" 
                        id="passwordInput"
                        class="form-control-custom" 
                        placeholder="Enter your password"
                        required>
                    <button 
                        type="button" 
                        id="togglePassword"
                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0;">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-gold w-100 mt-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </button>

        </form>

        <p style="text-align: center; font-size: 0.8rem; color: var(--text-muted); margin-top: 2rem;">
            <a href="<?= SITE_URL ?>/?page=home" style="color: var(--accent-gold);">
                <i class="bi bi-arrow-left me-1"></i>Back to Website
            </a>
        </p>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Password show/hide toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput  = document.getElementById('passwordInput');
    const toggleIcon     = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        toggleIcon.className = type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    });
</script>

</body>
</html>