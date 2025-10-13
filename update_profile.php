<?php
session_start();
require 'koneksi.php';

// Memastikan pengguna sudah login dan request method adalah POST
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Fungsi untuk menangani unggahan file
function handle_upload($file_input, array $allowed, $dir = 'uploads/')
{
    if (isset($_FILES[$file_input]) && $_FILES[$file_input]['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES[$file_input]['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            return ['error' => 'Format file tidak valid.'];
        }
        $name = uniqid('', true) . '.' . $ext;
        if (move_uploaded_file($_FILES[$file_input]['tmp_name'], $dir . $name)) {
            return ['filename' => $name];
        }
        return ['error' => 'Gagal unggah file.'];
    }
    return ['filename' => null];
}

$user_id = $_SESSION['user_id'];

// Validasi input yang wajib diisi
$required = ['nama_lengkap', 'agama', 'jenis_kelamin', 'nilai_rata_rata'];
foreach ($required as $f) {
    if (empty($_POST[$f])) {
        $_SESSION['message'] = "Kolom $f wajib diisi.";
        $_SESSION['message_type'] = "error";
        header('Location: dashboard.php?view=edit');
        exit;
    }
}

// Mengambil data file lama untuk dihapus jika ada file baru
$stmt_old = $conn->prepare("SELECT foto_profil, foto_sktm FROM mahasiswa WHERE id = ?");
$stmt_old->bind_param("i", $user_id);
$stmt_old->execute();
$old = $stmt_old->get_result()->fetch_assoc();
$stmt_old->close();

// Memproses unggahan file baru
$profil_res = handle_upload('foto_profil', ['jpg', 'jpeg', 'png']);
$sktm_res = handle_upload('foto_sktm', ['jpg', 'jpeg', 'png', 'pdf']);

if (isset($profil_res['error'])) {
    $_SESSION['message'] = "Profil: " . $profil_res['error'];
    $_SESSION['message_type'] = "error";
    header('Location: dashboard.php?view=edit');
    exit;
}
if (isset($sktm_res['error'])) {
    $_SESSION['message'] = "SKTM: " . $sktm_res['error'];
    $_SESSION['message_type'] = "error";
    header('Location: dashboard.php?view=edit');
    exit;
}

// Menentukan nama file yang akan disimpan ke database
$foto_profil = $profil_res['filename'] ?? $old['foto_profil'];
$foto_sktm = $sktm_res['filename'] ?? $old['foto_sktm'];

// Menghapus file lama jika file baru berhasil diunggah
if ($profil_res['filename'] && !empty($old['foto_profil'])) {
    @unlink('uploads/' . $old['foto_profil']);
}
if ($sktm_res['filename'] && !empty($old['foto_sktm'])) {
    @unlink('uploads/' . $old['foto_sktm']);
}

// Mempersiapkan statement SQL untuk update
$sql = "UPDATE mahasiswa SET nama_lengkap=?, agama=?, jenis_kelamin=?, nilai_rata_rata=?, foto_profil=?, foto_sktm=?";
$types = "sssdss"; // PERBAIKAN: Diubah dari "sssds" menjadi "sssdss"
$params = [$_POST['nama_lengkap'], $_POST['agama'], $_POST['jenis_kelamin'], $_POST['nilai_rata_rata'], $foto_profil, $foto_sktm];

// Menambahkan update password jika diisi
if (!empty($_POST['password'])) {
    $sql .= ", password=?";
    $types .= "s";
    $params[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
}

// Menambahkan kondisi WHERE dan mengeksekusi statement
$sql .= " WHERE id=?";
$types .= "i";
$params[] = $user_id;

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    $_SESSION['message'] = "Profil berhasil diperbarui!";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Gagal memperbarui profil.";
    $_SESSION['message_type'] = "error";
}

$stmt->close();
$conn->close();
header('Location: dashboard.php?view=profile');
exit;
?>