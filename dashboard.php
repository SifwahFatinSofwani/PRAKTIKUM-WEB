<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil semua data pengguna yang sedang login dari database
$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user_data) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Router untuk menentukan tampilan mana yang akan ditampilkan
$view = $_GET['view'] ?? 'overview'; // Tampilan default adalah 'overview'
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KIP Kuliah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body class="sidebar-hidden">
    <header class="navbar">
        <div class="nav-left">
            <button type="button" id="sidebar-toggle" class="sidebar-toggle"><i class="fas fa-bars"></i></button>
            <div class="logo"><a href="index.php"><img src="image/komendikbud 1.svg" alt="Logo KIP Kuliah"></a></div>
        </div>
        <div class="nav-controls">
            <div class="theme-toggle-container">
                <div class="theme-switch-wrapper"><label class="theme-switch" for="checkbox"><input type="checkbox" id="checkbox" /><div class="slider round"></div></label></div>
                <span id="theme-mode-text">Light Mode</span>
            </div>
        </div>
    </header>

    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <div class="user-info">
                <div class="avatar" style="background-image: url('uploads/<?= htmlspecialchars($user_data['foto_profil']) ?>');"></div>
                <h3><?= htmlspecialchars($user_data['nama_lengkap']) ?></h3>
                <p>NIM: <?= htmlspecialchars($user_data['nim']) ?></p>
            </div>
            <ul class="menu-list">
                <li><a href="?view=overview" class="<?= $view === 'overview' ? 'active' : '' ?>"><i class="fas fa-home-alt"></i><span>Dashboard</span></a></li>
                <li><a href="?view=profile" class="<?= $view === 'profile' ? 'active' : '' ?>"><i class="fas fa-user"></i><span>Profil Saya</span></a></li>
                <li><a href="?view=edit" class="<?= $view === 'edit' ? 'active' : '' ?>"><i class="fas fa-edit"></i><span>Edit Profil</span></a></li>
                <li><a href="?view=delete" class="<?= $view === 'delete' ? 'active' : '' ?>"><i class="fas fa-trash-alt"></i><span>Hapus Akun</span></a></li>
            </ul>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </aside>
        
        <main class="content">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="notification <?= $_SESSION['message_type'] ?>"><?= htmlspecialchars($_SESSION['message']) ?></div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); endif; ?>

            <?php if ($view === 'overview'): ?>
                <div class="welcome-box"><h1>Selamat Datang, <?= htmlspecialchars($user_data['nama_lengkap']); ?>!</h1><p>Ini adalah dashboard KIP Kuliah Anda.</p></div>
                <div class="stats-container">
                    <div class="stat-box"><h3><i class="fas fa-tasks"></i> Status Pendaftaran</h3><p>Lengkap</p></div>
                    <div class="stat-box"><h3><i class="fas fa-check-circle"></i> Status Verifikasi</h3><p>Terverifikasi</p></div>
                    <div class="stat-box"><h3><i class="fas fa-spinner"></i> Status KIP Kuliah</h3><p>Diproses</p></div>
                </div>

            <?php elseif ($view === 'profile'): ?>
                <div class="content-card"><h2><i class="fas fa-user-circle"></i> Profil Mahasiswa</h2><div class="profile-details">
                    <p><strong>NIM:</strong> <?= htmlspecialchars($user_data['nim']) ?></p>
                    <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($user_data['nama_lengkap']) ?></p>
                    <p><strong>Agama:</strong> <?= htmlspecialchars($user_data['agama']) ?></p>
                    <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($user_data['jenis_kelamin']) ?></p>
                    <p><strong>Nilai Rata-rata:</strong> <?= htmlspecialchars($user_data['nilai_rata_rata']) ?></p>
                    <p><strong>Dokumen SKTM:</strong> <a href="uploads/<?= htmlspecialchars($user_data['foto_sktm']) ?>" target="_blank" class="view-document-link">Lihat Dokumen</a></p>
                </div></div>

            <?php elseif ($view === 'edit'): ?>
                <div class="content-card"><h2><i class="fas fa-edit"></i> Edit Profil</h2>
                    <form action="update_profile.php" method="POST" enctype="multipart/form-data" class="edit-form">
                        <div class="input-group"><label>NIM (Tidak dapat diubah)</label><input type="text" value="<?= htmlspecialchars($user_data['nim']) ?>" disabled></div>
                        <div class="input-group"><label for="nama_lengkap">Nama Lengkap</label><input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($user_data['nama_lengkap']) ?>" required></div>
                        <div class="input-group"><label for="agama">Agama</label><select id="agama" name="agama" required><?php $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu']; foreach($agamas as $a): ?><option value="<?= $a ?>" <?= ($user_data['agama'] == $a) ? 'selected' : '' ?>><?= $a ?></option><?php endforeach; ?></select></div>
                        <div class="input-group"><label>Jenis Kelamin</label><div class="gender-group"><label><input type="radio" name="jenis_kelamin" value="Laki-laki" <?= ($user_data['jenis_kelamin'] == 'Laki-laki') ? 'checked' : '' ?> required> Laki-laki</label><label><input type="radio" name="jenis_kelamin" value="Perempuan" <?= ($user_data['jenis_kelamin'] == 'Perempuan') ? 'checked' : '' ?> required> Perempuan</label></div></div>
                        <div class="input-group"><label for="nilai_rata_rata">Nilai Rata-rata</label><input type="number" step="0.01" name="nilai_rata_rata" value="<?= htmlspecialchars($user_data['nilai_rata_rata']) ?>" required></div>
                        <div class="input-group"><label for="foto_profil">Ubah Foto Profil (Opsional)</label><input type="file" name="foto_profil"></div>
                        <div class="input-group"><label for="foto_sktm">Ubah Foto SKTM (Opsional)</label><input type="file" name="foto_sktm"></div>
                        <div class="input-group"><label for="password">Password Baru (Opsional)</label><input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah"></div>
                        <button type="submit" class="button-primary">Simpan Perubahan</button>
                    </form>
                </div>

            <?php elseif ($view === 'delete'): ?>
                <div class="content-card"><h2><i class="fas fa-exclamation-triangle"></i> Hapus Akun</h2><p>Apakah Anda yakin ingin menghapus akun ini secara permanen?</p><form action="delete_account.php" method="POST" style="margin-top: 20px;"><button type="submit" class="button-danger">Ya, Hapus Akun Saya</button><a href="dashboard.php?view=profile" class="button-secondary">Batal</a></form></div>
            <?php endif; ?>
        </main>
    </div>
    <div class="mobile-overlay"></div>
    <script src="script.js"></script>
</body>
</html>