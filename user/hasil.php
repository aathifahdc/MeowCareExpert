<?php
session_start();
require_once "../inc/config.php";

if (!isset($_SESSION['hasil'])) {
    header("Location: diagnosa.php");
    exit;
}

$hasil = $_SESSION['hasil'];
$gejala_dipilih = $_SESSION['gejala_dipilih'] ?? [];

// Get symptom codes for display
$symptomList = [];
$symp_query = $pdo->query("SELECT id, code, name FROM symptom");
while ($row = $symp_query->fetch(PDO::FETCH_ASSOC)) {
    $symptomList[$row['id']] = $row['code'] . ' - ' . $row['name'];
}

// Unset session data
unset($_SESSION['hasil']);
unset($_SESSION['gejala_dipilih']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa - MeowCare Expert</title>
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="guide.php">📚 Panduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="diseases.php">🏥 Info Penyakit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="doctors.php">👨‍⚕️ Dokter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">🚪 Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="guide.php">📚 Panduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="diseases.php">🏥 Info Penyakit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="doctors.php">👨‍⚕️ Dokter</a>
                    </li>
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
    <h1 class="text-primary fw-bold mb-2">📊 Hasil Diagnosa</h1>
    <p class="text-muted lead mb-4">Hasil diagnosis berdasarkan gejala yang Anda pilih dengan menggunakan metode Forward Chaining</p>

    <?php if (empty($hasil)): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">⚠️ Tidak Ada Kecocokan</h4>
            <p>Tidak ada penyakit yang cocok dengan gejala yang Anda pilih. Silakan konsultasikan dengan dokter hewan profesional untuk diagnosis yang lebih akurat.</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="text-center mt-4">
            <a href="diagnosa.php" class="btn btn-primary btn-lg">🔄 Lakukan Diagnosa Ulang</a>
        </div>
    <?php else: ?>
        <!-- Selected Symptoms -->
        <div class="content-wrapper mb-4">
            <h4 class="text-primary mb-3">
                <span class="badge badge-warning text-dark">Gejala yang Dipilih</span>
            </h4>
            <div class="d-flex flex-wrap gap-2">
                <?php foreach ($gejala_dipilih as $id): ?>
                    <?php if (isset($symptomList[$id])): ?>
                        <span class="badge badge-primary"><?php echo htmlspecialchars($symptomList[$id]); ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Disease Results -->
        <div class="container-lg">
            <h3 class="text-primary mb-4">
                <span class="badge badge-success">Kemungkinan Penyakit</span>
                (Berdasarkan Kesamaan Gejala)
            </h3>
            
            <?php foreach ($hasil as $index => $disease): ?>
            <div class="disease-card">
                <div class="disease-header">
                    <div class="disease-title">
                        <span class="rank-badge"><?php echo $index + 1; ?></span>
                        <div>
                            <h5 class="mb-0">
                                <span class="text-primary"><?php echo htmlspecialchars($disease['disease_code']); ?></span>
                            </h5>
                            <h4 class="mb-0"><?php echo htmlspecialchars($disease['disease_name']); ?></h4>
                        </div>
                    </div>
                    <span class="match-percentage"><?php echo round($disease['match_percentage']); ?>% Cocok</span>
                </div>
                
                <div class="progress-match">
                    <div class="progress-bar" style="width: <?php echo $disease['match_percentage']; ?>%"></div>
                </div>

                <div class="disease-description">
                    <h5 class="text-primary">📋 Deskripsi:</h5>
                    <p><?php echo htmlspecialchars($disease['description']); ?></p>
                    
                    <h5 class="text-primary mt-3">✓ Gejala yang Cocok:</h5>
                    <p class="text-muted"><small><?php echo $disease['matched_symptoms']; ?> dari <?php echo $disease['total_symptoms']; ?> gejala dalam penyakit ini cocok dengan gejala yang Anda pilih</small></p>
                </div>

                <div class="alert alert-info border-start border-4 mt-3">
                    <strong>💡 Catatan Penting:</strong> Diagnosis ini berdasarkan analisis gejala yang Anda masukkan. Untuk diagnosis yang lebih akurat dan perawatan yang tepat, silakan konsultasikan dengan dokter hewan profesional.
                </div>

                <div class="d-flex gap-2">
                    <a href="diseases.php" class="btn btn-sm btn-outline-primary">Pelajari Lebih Lanjut</a>
                    <a href="doctors.php" class="btn btn-sm btn-outline-primary">Cari Dokter Hewan</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-3 mt-5 mb-4">
            <a href="diagnosa.php" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-clockwise"></i> Diagnosa Ulang
            </a>
            <a href="index.php" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-arrow-left"></i> Kembali ke Home
            </a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
