<?php
session_start();
require 'koneksi.php';

$error_list = [];
$success = '';

function handle_upload($file_input_name, array $allowed_exts, $upload_dir = 'uploads/') {
    if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] == 0) {
        $file_name = $_FILES[$file_input_name]['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_exts)) {
            return ['error' => "Format file tidak valid. Hanya " . strtoupper(implode(', ', $allowed_exts)) . " yang diizinkan."];
        }
        $new_file_name = uniqid('', true) . '.' . $file_ext;
        if (move_uploaded_file($_FILES[$file_input_name]['tmp_name'], $upload_dir . $new_file_name)) {
            return ['filename' => $new_file_name];
        }
        return ['error' => "Gagal mengunggah file."];
    }
    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['nim' => 'NIM', 'nama_lengkap' => 'Nama Lengkap', 'password' => 'Password', 'agama' => 'Agama', 'jenis_kelamin' => 'Jenis Kelamin', 'nilai_rata_rata' => 'Nilai Rata-rata'];
    foreach ($required_fields as $field => $label) {
        if (empty($_POST[$field])) $error_list[] = "$label wajib diisi.";
    }
    $nim = $_POST['nim'] ?? '';
    if (!empty($nim)) {
        if (!ctype_digit($nim)) {
            $error_list[] = "NIM hanya boleh berisi angka.";
        } else {
            $stmt_check = $conn->prepare("SELECT id FROM mahasiswa WHERE nim = ?");
            $stmt_check->bind_param("s", $nim);
            $stmt_check->execute();
            if ($stmt_check->get_result()->num_rows > 0) $error_list[] = "NIM sudah terdaftar.";
            $stmt_check->close();
        }
    }
    if (!isset($_FILES['foto_profil']) || $_FILES['foto_profil']['error'] == UPLOAD_ERR_NO_FILE) $error_list[] = "Foto Profil wajib diunggah.";
    if (!isset($_FILES['foto_sktm']) || $_FILES['foto_sktm']['error'] == UPLOAD_ERR_NO_FILE) $error_list[] = "Foto SKTM wajib diunggah.";
    
    if (empty($error_list)) {
        $foto_profil_result = handle_upload('foto_profil', ['jpg', 'jpeg', 'png']);
        $foto_sktm_result = handle_upload('foto_sktm', ['jpg', 'jpeg', 'png', 'pdf']);
        if (isset($foto_profil_result['error'])) $error_list[] = "Foto Profil: " . $foto_profil_result['error'];
        if (isset($foto_sktm_result['error'])) $error_list[] = "Foto SKTM: " . $foto_sktm_result['error'];
        
        if (empty($error_list)) {
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama_lengkap, password, agama, jenis_kelamin, foto_profil, foto_sktm, nilai_rata_rata) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssd", $_POST['nim'], $_POST['nama_lengkap'], $hashed_password, $_POST['agama'], $_POST['jenis_kelamin'], $foto_profil_result['filename'], $foto_sktm_result['filename'], $_POST['nilai_rata_rata']);
            if ($stmt->execute()) {
                $success = "Pendaftaran berhasil! Anda akan dialihkan ke halaman login.";
                header("refresh:3;url=login.php");
            } else {
                $error_list[] = "Terjadi kesalahan pada database: " . $stmt->error;
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - KIP Kuliah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/register.css">
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
        <h2 class="main-title">Buat Akun KIP Kuliah</h2>
        <div class="login-card">
            <h3>Formulir Pendaftaran</h3>

            <?php if (!empty($error_list)): ?>
                <div class="error-message">
                    <?php foreach ($error_list as $error): echo "<p>" . htmlspecialchars($error) . "</p>"; endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="register.php" enctype="multipart/form-data">
                <div class="input-group"><label for="nim">NIM</label><input type="text" inputmode="numeric" pattern="[0-9]*" id="nim" name="nim" title="NIM hanya boleh berisi angka." required></div>
                <div class="input-group"><label for="nama_lengkap">Nama Lengkap</label><input type="text" id="nama_lengkap" name="nama_lengkap" required></div>
                <div class="input-group"><label for="password">Password</label><input type="password" id="password" name="password" required></div>
                <div class="input-group"><label for="agama">Agama</label><select id="agama" name="agama" required><option value="">-- Pilih Agama --</option><option value="Islam">Islam</option><option value="Kristen">Kristen</option><option value="Katolik">Katolik</option><option value="Hindu">Hindu</option><option value="Budha">Budha</option><option value="Konghucu">Konghucu</option></select></div>
                <div class="input-group"><label>Jenis Kelamin</label><div class="gender-group"><label><input type="radio" name="jenis_kelamin" value="Laki-laki" required> Laki-laki</label><label><input type="radio" name="jenis_kelamin" value="Perempuan" required> Perempuan</label></div></div>
                <div class="input-group"><label for="nilai_rata_rata">Nilai Rata-rata 5 Semester</label><input type="number" step="0.01" id="nilai_rata_rata" name="nilai_rata_rata" placeholder="Contoh: 85.50" required></div>
                <div class="input-group"><label>Foto Profil (JPG, PNG)</label><label for="foto_profil_input" class="file-input-wrapper"><span id="foto_profil_text">Pilih File...</span></label><input type="file" id="foto_profil_input" name="foto_profil" onchange="previewFile('foto_profil_input', 'foto_profil_text', 'foto_profil_preview')" required><img id="foto_profil_preview" class="image-preview" alt="Pratinjau Foto Profil"></div>
                <div class="input-group"><label>Foto SKTM (PDF, JPG, PNG)</label><label for="foto_sktm_input" class="file-input-wrapper"><span id="foto_sktm_text">Pilih File...</span></label><input type="file" id="foto_sktm_input" name="foto_sktm" onchange="previewFile('foto_sktm_input', 'foto_sktm_text', 'foto_sktm_preview')" required><img id="foto_sktm_preview" class="image-preview" alt="Pratinjau Foto SKTM"></div>
                <p class="register-link">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
                <button type="submit" class="create-account-btn">Daftar</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>