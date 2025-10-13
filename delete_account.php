<?php
session_start();
require 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php'); exit;
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT foto_profil, foto_sktm FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $user_id); $stmt->execute();
$files = $stmt->get_result()->fetch_assoc(); $stmt->close();
if ($files) {
    @unlink('uploads/' . $files['foto_profil']);
    @unlink('uploads/' . $files['foto_sktm']);
}
$stmt_del = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
$stmt_del->bind_param("i", $user_id); $stmt_del->execute();
$stmt_del->close(); $conn->close();
session_destroy(); header('Location: login.php'); exit;
?>