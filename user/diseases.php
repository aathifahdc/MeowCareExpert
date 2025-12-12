<?php
session_start();
require_once "../inc/config.php";

// Get all diseases with detail from database
$query = "SELECT d.*, dd.* FROM disease d
          LEFT JOIN disease_detail dd ON d.id = dd.disease_id
          ORDER BY d.code";
$diseases = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Penyakit - MeowCare Expert</title>
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
                    <a class="nav-link active" href="diseases.php">🏥 Info Penyakit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="doctors.php">👨‍⚕️ Dokter</a>
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
    <h1 class="text-primary fw-bold mb-2">🏥 Informasi Penyakit Kucing</h1>
    <p class="text-muted lead mb-5">Pelajari lebih lanjut tentang berbagai penyakit yang dapat menyerang kucing Anda</p>

    <!-- Diseases List -->
    <?php if (empty($diseases)): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Tidak ada data penyakit yang tersedia.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($diseases as $disease): ?>
            <div class="col-12 mb-4">
                <div class="card disease-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                <span class="badge badge-primary"><?php echo htmlspecialchars($disease['code']); ?></span>
                                <?php echo htmlspecialchars($disease['name']); ?>
                            </h5>
                        </div>
                        <div class="d-flex gap-2">
                            <?php if (isset($disease['is_emergency']) && $disease['is_emergency']): ?>
                                <span class="badge bg-danger">🚨 EMERGENCY</span>
                            <?php endif; ?>
                            <?php if (isset($disease['is_contagious']) && $disease['is_contagious']): ?>
                                <span class="badge bg-warning text-dark">⚠️ Menular</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Description -->
                        <div class="mb-3">
                            <h6 class="text-primary fw-bold">📝 Deskripsi</h6>
                            <p class="card-text"><?php echo htmlspecialchars($disease['description']); ?></p>
                        </div>

                        <!-- Symptoms Summary -->
                        <?php if (isset($disease['symptoms_summary']) && !empty($disease['symptoms_summary'])): ?>
                        <div class="mb-3">
                            <h6 class="text-primary fw-bold">🔍 Gejala Umum</h6>
                            <ul class="ms-3 mb-0">
                                <?php foreach (explode('|', $disease['symptoms_summary']) as $symptom): ?>
                                    <?php if (trim($symptom)): ?>
                                    <li><?php echo htmlspecialchars(trim($symptom)); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- Prevention -->
                        <?php if (isset($disease['prevention']) && !empty($disease['prevention'])): ?>
                        <div class="mb-3">
                            <h6 class="text-success fw-bold">💚 Pencegahan</h6>
                            <ul class="ms-3 mb-0">
                                <?php foreach (explode('|', $disease['prevention']) as $item): ?>
                                    <?php if (trim($item)): ?>
                                    <li><?php echo htmlspecialchars(trim($item)); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- Treatment -->
                        <?php if (isset($disease['treatment']) && !empty($disease['treatment'])): ?>
                        <div class="mb-3">
                            <h6 class="text-info fw-bold">💊 Penanganan</h6>
                            <ul class="ms-3 mb-0">
                                <?php foreach (explode('|', $disease['treatment']) as $item): ?>
                                    <?php if (trim($item)): ?>
                                    <li><?php echo htmlspecialchars(trim($item)); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- Additional Info -->
                        <div class="row mt-3 pt-3 border-top">
                            <?php if (isset($disease['survival_rate']) && !empty($disease['survival_rate'])): ?>
                            <div class="col-md-6">
                                <p class="mb-0"><strong>📊 Tingkat Kesembuhan:</strong> <span class="badge bg-info"><?php echo htmlspecialchars($disease['survival_rate']); ?></span></p>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-6">
                                <p class="mb-0"><strong>⚕️ Perlu Dokter:</strong> <span class="badge bg-primary">Ya, Segera</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="doctors.php" class="btn btn-sm btn-primary">
                            <i class="bi bi-search"></i> Cari Dokter Hewan
                        </a>
                        <a href="diagnosa.php" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-search"></i> Lakukan Diagnosa
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- CTA Section -->
    <div class="content-wrapper text-center bg-gradient py-5 mt-5">
        <h3 class="text-primary mb-3">Punya Kucing Sakit?</h3>
        <p class="mb-4">Lakukan diagnosa sekarang untuk mengetahui kemungkinan penyakitnya</p>
        <a href="diagnosa.php" class="btn btn-primary btn-lg">
            <i class="bi bi-search"></i> Mulai Diagnosa
        </a>
        <a href="doctors.php" class="btn btn-outline-primary btn-lg ms-2">
            <i class="bi bi-telephone"></i> Hubungi Dokter
        </a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
