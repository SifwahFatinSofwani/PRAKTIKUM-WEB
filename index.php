<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIP Kuliah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>

    <div class="hero-section-container">
        <div class="container">
            <header class="navbar">
                <div class="logo">
                    <img src="image/komendikbud 1.svg" alt="Logo KIP Kuliah">
                </div>
                <ul class="nav-links">
                    <li><a href="#hero-content">Beranda</a></li>
                    <li><a href="#about-section">Tentang</a></li>
                    <li><a href="#schedule-section">Jadwal</a></li>
                    <li><a href="#requirements-section">Persyaratan</a></li>
                    <li><a href="#faq-section">FAQ</a></li>
                </ul>
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
                    <a href="login.php" class="login-btn">Masuk</a>
                    <a href="register.php" class="login-btn">Daftar</a>
                </div>
            </header>

            <section class="hero-content" id="hero-content">
                <div class="hero-text">
                    <h1>Ayo Kuliah! <br> Wujudkan Mimpimu dengan KIP Kuliah</h1>
                    <p>Bantuan biaya pendidikan dari pemerintah bagi lulusan SMA/sederajat yang memiliki potensi akademik baik tetapi memiliki keterbatasan ekonomi.</p>
                </div>
                <div class="hero-image">
                    <img src="image/gambahero.jpg" alt="Taman Kampus dengan Air Mancur">
                </div>
            </section>
        </div>
    </div>
    
    <section class="about-section" id="about-section">
        <div class="container">
            <div class="about-content">
                <div class="about-video">
                    <iframe 
                        src="https://www.youtube.com/embed/D6nPiEwbqmY" 
                        title="YouTube video player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="about-text">
                    <h2>Apa itu KIP Kuliah?</h2>
                    <p>
                        Kartu Indonesia Pintar (KIP) Kuliah adalah <strong>bantuan biaya pendidikan dari pemerintah</strong> bagi lulusan Sekolah Menengah Atas (SMA) atau sederajat yang memiliki potensi akademik baik tetapi memiliki <strong>keterbatasan ekonomi</strong>.
                    </p>
                    <p>
                        Bantuan ini mencakup <strong>pembebasan biaya pendaftaran</strong>, <strong>biaya kuliah (UKT/SPP)</strong>, dan <strong>bantuan biaya hidup bulanan</strong>.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="schedule-section" id="schedule-section">
        <div class="container">
            <div class="schedule-card">
                <h2 class="schedule-title">Jadwal Kartu Indonesia Pintar Kuliah</h2>
                <p class="schedule-description">Tanggal penting jadwal pendaftaran dan penutupan Kartu Indonesia Pintar Kuliah Tahun 2025</p>
                
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kegiatan</th>
                            <th>Dibuka</th>
                            <th>Ditutup</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Pendaftaran Akun Siswa KIP-Kuliah</td>
                            <td>04 Februari 2025</td>
                            <td>31 Oktober 2025</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Seleksi Nasional Berdasarkan Prestasi (SNBP)</td>
                            <td>04 Februari 2025</td>
                            <td>18 Februari 2025</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>UTBK-SNBT</td>
                            <td>11 Maret 2025</td>
                            <td>27 Maret 2025</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Seleksi Mandiri PTN</td>
                            <td>04 Juni 2025</td>
                            <td>30 September 2025</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Seleksi Mandiri PTS</td>
                            <td>04 Juni 2025</td>
                            <td>31 Oktober 2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    
    <section class="requirements-section" id="requirements-section">
        <div class="container">
        <div class="requirements-content">
            <div class="requirements-text">
                <h2>Persyaratan Penerima KIP Kuliah</h2>
                <ol>
                    <li>Siswa melakukan pendaftaran akun secara mandiri di web Sistem KIP Kuliah.</li>
                    <li>Masukkan NIK, NISN, NPSN, dan alamat email yang valid dan aktif.</li>
                    <li>Sistem KIP Kuliah akan melakukan validasi data serta kelayakan mendapatkan KIP Kuliah.</li>
                    <li>Jika berhasil, sistem akan mengirimkan Nomor Pendaftaran dan Kode Akses ke alamat email.</li>
                    <li>Siswa menyelesaikan proses pendaftaran dan memilih jalur seleksi yang akan diikuti.</li>
                    <li>Selesaikan proses pendaftaran di portal atau sistem informasi seleksi nasional.</li>
                </ol>
            </div>
            <div class="requirements-image">
                <img src="image/gambarsyarat.jpg" alt="Mahasiswa belajar di perpustakaan">
            </div>
        </div>
    </div>
    </section>

    <section id="faq-section" class="faq-section">
        <div class="container">
            <div class="faq-header">
                <p class="faq-subtitle">TANYA JAWAB</p>
                <h2 class="faq-title">Punya Pertanyaan?<br>Temukan Jawabannya Di Sini.</h2>
            </div>

            <div class="faq-accordion">
                <details open>
                    <summary>1. Bagaimana jika saya tidak punya Kartu Indonesia Pintar (KIP) saat SMA?</summary>
                    <div class="faq-content">
                        <p>Anda tetap dapat mendaftar KIP Kuliah selama memenuhi persyaratan ekonomi yang dibuktikan dengan dokumen lain, seperti kepemilikan Program Keluarga Harapan (PKH), Kartu Keluarga Sejahtera (KKS), atau terdata di Data Terpadu Kesejahteraan Sosial (DTKS) Kemensos.</p>
                    </div>
                </details>

                <details>
                    <summary>2. Apakah KIP Kuliah hanya untuk Perguruan Tinggi Negeri (PTN)?</summary>
                    <div class="faq-content">
                        <p>Tidak. KIP Kuliah berlaku untuk pendaftaran di Perguruan Tinggi Negeri (PTN) dan Perguruan Tinggi Swasta (PTS) yang telah terakreditasi dan bekerja sama dengan program KIP Kuliah.</p>
                    </div>
                </details>

                <details>
                    <summary>3. Berapa besaran bantuan biaya hidup yang diterima?</summary>
                    <div class="faq-content">
                        <p>Besaran bantuan biaya hidup dibagi menjadi lima klaster daerah, mulai dari Rp 800.000 hingga Rp 1.400.000 per bulan, yang disesuaikan dengan indeks harga di wilayah perguruan tinggi masing-masing.</p>
                    </div>
                </details>
                
                <details>
                    <summary>4. Apakah mahasiswa penerima KIP Kuliah bisa mendaftar beasiswa lain?</summary>
                    <div class="faq-content">
                        <p>Pada umumnya, mahasiswa penerima KIP Kuliah tidak diperkenankan menerima beasiswa lain yang sumber dananya berasal dari APBN/APBD. Namun, kebijakan ini bisa berbeda tergantung aturan dari pemberi beasiswa lain tersebut.</p>
                    </div>
                </details>
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