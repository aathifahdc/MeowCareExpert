<?php 
session_start();
require_once "../inc/config.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeowCare Expert - Diagnosa Penyakit Kucing</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/user/style.css">
</head>

<body>
<!-- Navigation Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-lg">
        <a class="navbar-brand" href="index.php">
            <span style="font-size: 1.8rem; font-weight: 700; letter-spacing: 0.5px;">MeowCare Expert</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="diagnosa.php">🔍 Diagnosa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="guide.php">📚 Panduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="diseases.php">🏥 Info Penyakit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="doctors.php">👨‍⚕️ Dokter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-lg py-4">
    <!-- Hero Section -->
    <div class="text-center py-3 my-3">
        <img src="../assets/MeowCareLogo.png" class="float" alt="MeowCare Mascot" style="max-width: 350px; height: auto;">
        <h1 class="display-4 fw-bold text-primary mt-4">Pahami Gejala, Berikan Pertolongan Terbaik</h1>
        <p class="lead text-muted">Sistem Pakar Diagnosa Penyakit Kucing<br>Menggunakan Forward Chaining</p>
    </div>

    <!-- Features Grid -->
    <div class="row g-4 my-5">
        <div class="col-md-6 col-lg-4">
            <div class="feature-box">
                <div class="feature-icon">🔍</div>
                <h4>Diagnosa Akurat</h4>
                <p>Dapatkan diagnosis penyakit kucing Anda berdasarkan gejala yang diamati dengan akurasi tinggi.</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-box">
                <div class="feature-icon">📊</div>
                <h4>Analisis Detail</h4>
                <p>Lihat persentase kecocokan gejala dan deskripsi lengkap untuk setiap kemungkinan penyakit.</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-box">
                <div class="feature-icon">📚</div>
                <h4>Panduan Gejala</h4>
                <p>Pelajari cara mengidentifikasi gejala penyakit kucing dengan panduan lengkap dan cara pencegahan.</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-box">
                <div class="feature-icon">👨‍⚕️</div>
                <h4>Direktori Dokter Hewan</h4>
                <p>Temukan dokter hewan terpercaya di kota Anda untuk konsultasi profesional.</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-box">
                <div class="feature-icon">💡</div>
                <h4>Tips & Panduan</h4>
                <p>Dapatkan rekomendasi untuk konsultasi dengan dokter hewan profesional jika diperlukan.</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-box">
                <div class="feature-icon">🎯</div>
                <h4>Solusi Cepat</h4>
                <p>Proses diagnosis cepat dan mudah hanya dengan beberapa klik untuk kesehatan kucing Anda.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="content-wrapper text-center bg-gradient py-5 my-5">
        <h2 class="text-primary mb-3">Mulai Diagnosa Sekarang</h2>
        <p class="lead mb-4">Pilih gejala yang dialami kucing Anda untuk mendapatkan diagnosis yang akurat dan cepat</p>
        <a href="diagnosa.php" class="btn btn-primary btn-lg">
            <i class="bi bi-play-circle"></i> Mulai Diagnosa
        </a>
    </div>

    <!-- About Section -->
    <div class="content-wrapper my-5">
        <h2 class="text-primary mb-4">Tentang Sistem Ini</h2>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <p><strong>MeowCare Expert</strong> adalah sistem pakar yang dirancang untuk membantu pemilik kucing dalam mengenali gejala penyakit kucing secara dini.</p>
                
                <p class="mt-3">Sistem ini menggunakan metode <strong>Forward Chaining</strong>, yaitu suatu teknik dalam artificial intelligence yang memulai dari fakta (gejala yang Anda masukkan) dan kemudian menyimpulkan penyakit yang mungkin terjadi. Dengan database penyakit yang lengkap dan akurat, sistem kami dapat memberikan rekomendasi diagnosis dengan tingkat keakuratan tinggi.</p>
                
                <div class="alert alert-warning border-start border-4 mt-4" role="alert">
                    <strong>⚠️ Catatan Penting:</strong> Hasil diagnosis dari sistem ini bukan merupakan pengganti untuk konsultasi dengan dokter hewan profesional. Untuk diagnosis yang lebih akurat dan perawatan yang tepat, selalu konsultasikan dengan dokter hewan.
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
