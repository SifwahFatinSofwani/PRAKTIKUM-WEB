<?php
// Start the session
session_start();

// Check if user is logged in, if not redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Get the username from session
$username = $_SESSION['username'];

// Use $_GET parameter for any dashboard views if needed
$view = isset($_GET['view']) ? $_GET['view'] : 'overview';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KIP Kuliah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="style/dashboard.css">
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

    <div class="dashboard-container">
        <div class="sidebar">
            <div class="user-info">
                <div class="avatar">
                    <?php echo strtoupper(substr($username, 0, 1)); ?>
                </div>
                <h3><?php echo htmlspecialchars($username); ?></h3>
                <p>Mahasiswa</p>
            </div>
            
            <ul class="menu-list">
                <li><a href="dashboard.php" class="<?php echo $view === 'overview' ? 'active' : ''; ?>">Dashboard</a></li>
                <li><a href="dashboard.php?view=profile" class="<?php echo $view === 'profile' ? 'active' : ''; ?>">Profil</a></li>
                <li><a href="dashboard.php?view=documents" class="<?php echo $view === 'documents' ? 'active' : ''; ?>">Dokumen</a></li>
                <li><a href="dashboard.php?view=applications" class="<?php echo $view === 'applications' ? 'active' : ''; ?>">Pendaftaran</a></li>
            </ul>
            
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <div class="content">
            <?php if($view === 'overview'): ?>
                <div class="welcome-box">
                    <h1>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h1>
                    <p>Ini adalah dashboard KIP Kuliah Anda. Anda dapat melacak pendaftaran dan status KIP Kuliah Anda di sini.</p>
                </div>
                
                <div class="stats-container">
                    <div class="stat-box">
                        <h3>Status Pendaftaran</h3>
                        <p>Lengkap</p>
                    </div>
                    <div class="stat-box">
                        <h3>Status Verifikasi</h3>
                        <p>Terverifikasi</p>
                    </div>
                    <div class="stat-box">
                        <h3>Status KIP Kuliah</h3>
                        <p>Diproses</p>
                    </div>
                </div>
                
                <div class="recent-activity">
                    <h2>Aktivitas Terbaru</h2>
                    <ul class="activity-list">
                        <li>
                            <strong>Pendaftaran Berhasil</strong>
                            <p>Anda telah berhasil mendaftar di sistem KIP Kuliah.</p>
                            <small>2 Oktober 2025</small>
                        </li>
                        <li>
                            <strong>Dokumen Diunggah</strong>
                            <p>Dokumen persyaratan Anda telah berhasil diunggah.</p>
                            <small>3 Oktober 2025</small>
                        </li>
                        <li>
                            <strong>Verifikasi Data</strong>
                            <p>Data Anda sedang dalam proses verifikasi.</p>
                            <small>3 Oktober 2025</small>
                        </li>
                    </ul>
                </div>
            <?php elseif($view === 'profile'): ?>
                <h1>Profil Anda</h1>
                <p>Nama: <?php echo htmlspecialchars($username); ?></p>
                <p>Halaman profil masih dalam pengembangan.</p>
            <?php elseif($view === 'documents'): ?>
                <h1>Dokumen</h1>
                <p>Halaman dokumen masih dalam pengembangan.</p>
            <?php elseif($view === 'applications'): ?>
                <h1>Pendaftaran</h1>
                <p>Halaman pendaftaran masih dalam pengembangan.</p>
            <?php endif; ?>
        </div>
    </div>

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