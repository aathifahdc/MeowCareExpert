<?php
session_start();
require_once "../inc/config.php";

// Get all doctors from database
$query = "SELECT * FROM veterinarian ORDER BY rating DESC";
$all_doctors = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Filter berdasarkan lokasi jika ada
$filter_location = isset($_GET['location']) ? $_GET['location'] : '';
$doctors = $all_doctors;

if ($filter_location) {
    $doctors = array_filter($all_doctors, function($doc) use ($filter_location) {
        return stripos($doc['location'], $filter_location) !== false;
    });
}

// Get unique locations for filter
$locations = array_unique(array_column($all_doctors, 'location'));
sort($locations);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Dokter Hewan - MeowCare Expert</title>
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
                    <a class="nav-link" href="diagnosa.php">🔍 Diagnosa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="guide.php">📚 Panduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="diseases.php">🏥 Info Penyakit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="doctors.php">👨‍⚕️ Dokter</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">🚪 Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">🏠 Home</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-lg py-5">
    <!-- Header -->
    <h1 class="text-primary fw-bold mb-2">👨‍⚕️ Direktori Dokter Hewan</h1>
    <p class="text-muted lead mb-4">Temukan dokter hewan terpercaya untuk konsultasi dan perawatan kucing Anda</p>

    <!-- Location Filter -->
    <div class="content-wrapper mb-4">
        <h5 class="text-primary mb-3">🔍 Filter Berdasarkan Lokasi</h5>
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <select name="location" class="form-select" style="max-width: 300px;">
                <option value="">Semua Lokasi</option>
                <?php foreach ($locations as $loc): ?>
                    <option value="<?php echo htmlspecialchars($loc); ?>" <?php echo ($filter_location === $loc) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($loc); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
            <?php if ($filter_location): ?>
                <a href="doctors.php" class="btn btn-outline-secondary">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Doctors Grid -->
    <?php if (empty($doctors)): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> Tidak ada dokter ditemukan untuk lokasi yang Anda pilih.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($doctors as $doctor): ?>
            <div class="col-md-6 col-lg-4">
                <div class="doctor-card">
                    <div class="doctor-header">
                        <div class="doctor-name">👨‍⚕️ <?php echo htmlspecialchars($doctor['name']); ?></div>
                        <div class="doctor-specialization"><?php echo htmlspecialchars($doctor['specialization']); ?></div>
                        <div class="doctor-rating mt-2">
                            <span class="stars">
                                <?php 
                                $rating = intval($doctor['rating']);
                                for ($i = 0; $i < 5; $i++) {
                                    echo ($i < $rating) ? '⭐' : '☆';
                                }
                                ?>
                            </span>
                            <small class="ms-2">
                                (<?php echo htmlspecialchars($doctor['rating']); ?>/5 - <?php echo htmlspecialchars($doctor['reviews_count']); ?> review)
                            </small>
                        </div>
                    </div>

                    <div class="doctor-body">
                        <!-- Clinic Name -->
                        <div class="doctor-info">
                            <span class="doctor-info-icon">🏥</span>
                            <span><?php echo htmlspecialchars($doctor['clinic_name']); ?></span>
                        </div>

                        <!-- Location -->
                        <div class="doctor-info">
                            <span class="doctor-info-icon">📍</span>
                            <span><?php echo htmlspecialchars($doctor['location']); ?></span>
                        </div>

                        <!-- Hours -->
                        <div class="doctor-info">
                            <span class="doctor-info-icon">🕐</span>
                            <span><?php echo htmlspecialchars($doctor['hours']); ?></span>
                        </div>

                        <!-- Contact Buttons -->
                        <div class="d-flex gap-2 mt-3">
                            <?php if (!empty($doctor['whatsapp'])): ?>
                            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $doctor['whatsapp']); ?>" 
                               target="_blank" class="btn btn-sm btn-success flex-grow-1">
                                💬 WhatsApp
                            </a>
                            <?php endif; ?>

                            <?php if (!empty($doctor['phone'])): ?>
                            <a href="tel:<?php echo htmlspecialchars($doctor['phone']); ?>" 
                               class="btn btn-sm btn-primary flex-grow-1">
                                ☎️ Telepon
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- CTA Section -->
    <div class="content-wrapper text-center bg-gradient py-5 mt-5">
        <h3 class="text-primary mb-3">Belum Menemukan Dokter?</h3>
        <p class="mb-4">Hubungi klinik hewan terdekat atau gunakan layanan konsultasi online</p>
        <a href="diagnosa.php" class="btn btn-primary btn-lg">
            <i class="bi bi-search"></i> Kembali ke Diagnosa
        </a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
