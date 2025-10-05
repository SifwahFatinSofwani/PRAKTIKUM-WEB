<?php
// Start the session
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Very simple authentication
    // In a real application, you would use secure password storage and validation
    if (!empty($username) && !empty($password)) {
        // For demonstration purposes, we'll use a simple validation
        // In a real app, you should validate against a database
        if ($password === "password123") {
            // Set session variables
            $_SESSION['username'] = $username;
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username dan password harus diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KIP Kuliah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="container">
        <header class="navbar">
            <div class="logo">
                <a href="index.php">
                    <img src="image/komendikbud 1.svg" alt="Logo KIP Kuliah">
                </a>
            </div>
            <div class="nav-controls">
                <div class="theme-toggle-container">
                    <div class="theme-switch-wrapper">
                        <label class="theme-switch" for="checkbox">
                            <input type="checkbox" id="checkbox" />
                            <div class="slider round"></div>
                        </label>
                    </div>
                    <span id="theme-mode-text">Light Mode</span>
                </div>
            </div>
        </header>
    </div>

    <section class="login-section">
        <div class="login-container">
            <div class="login-header">
                <div class="login-logo">
                    <img src="image/komendikbud 1.svg" alt="Logo KIP Kuliah">
                </div>
                <h1>Login KIP Kuliah</h1>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form class="login-form" method="POST" action="login.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
            
            <div class="login-links">
                <a href="index.php">Kembali ke Beranda</a>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            <hr class="footer-divider">
            <div class="footer-content">
                <div class="footer-left">
                    <p>
                        <strong>Referensi Desain dan Informasi:</strong> <br>
                        <a href="https://kip-kuliah.kemdikbud.go.id/" target="_blank">Website Resmi KIP Kuliah</a>
                    </p>
                </div>
                <div class="footer-right">
                    <p>© 2025 KIP Kuliah Landing Page</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>