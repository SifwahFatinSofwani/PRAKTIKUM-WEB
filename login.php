<?php
session_start();
require 'koneksi.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'] ?? '';
    $password = $_POST['password'] ?? '';
    if (!empty($nim) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password FROM mahasiswa WHERE nim = ?");
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: dashboard.php");
                exit;
            }
        }
        $error = "NIM atau password salah!";
        $stmt->close();
    } else {
        $error = "NIM dan password harus diisi!";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - KIP Kuliah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <a href="index.php" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    </a>

    <div class="theme-toggle-container-login">
        <div class="theme-switch-wrapper">
            <label class="theme-switch" for="checkbox">
                <input type="checkbox" id="checkbox" />
                <div class="slider round"></div>
            </label>
        </div>
        <span id="theme-mode-text">Light Mode</span>
    </div>

    <div class="login-wrapper">
        <img src="image/komendikbud 1.svg" alt="Logo KIP Kuliah" class="logo">
        <h2 class="main-title">Kartu Indonesia Pintar - Kuliah</h2>
        <div class="login-card">
            <h3>Masuk ke Akun</h3>
            <?php if (!empty($error)): ?><div class="error-message"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <form method="POST" action="login.php" class="login-form">
                <div class="input-group">
                    <label for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <span id="togglePassword" class="toggle-password">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>
                    </span>
                </div>
                <p class="register-link">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
                <button type="submit" class="create-account-btn">Masuk</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>