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
$symptomList = $pdo->query("SELECT id, code, name FROM symptom")->fetchAll(PDO::FETCH_KEY_PAIR);

// Unset session data
unset($_SESSION['hasil']);
unset($_SESSION['gejala_dipilih']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa - MeowCare Expert</title>
    <link rel="stylesheet" href="../assets/user/style.css">
</head>

<body>
<div class="hero">
    <img src="assets/cat.png" class="cat-hero">
    <h1>MeowCare Expert</h1>
    <p>Hasil Diagnosa Penyakit Kucing</p>
</div>

<div class="container">
    <h2>Hasil Diagnosa</h2>

    <?php if (empty($hasil)): ?>
        <div class="result-box alert alert-warning">
            <h3>⚠️ Tidak Ada Kecocokan</h3>
            <p>Tidak ada penyakit yang cocok dengan gejala yang Anda pilih. Silakan konsultasikan dengan dokter hewan profesional untuk diagnosis yang lebih akurat.</p>
        </div>
    <?php else: ?>
        <div class="gejala-info">
            <h3>Gejala yang Dipilih:</h3>
            <div class="tags-container">
                <?php foreach ($gejala_dipilih as $id): ?>
                    <?php if (isset($symptomList[$id])): ?>
                        <span class="tag"><?php echo htmlspecialchars($symptomList[$id]); ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="hasil-container">
            <h3>Kemungkinan Penyakit (Berdasarkan Kesamaan Gejala):</h3>
            
            <?php foreach ($hasil as $index => $disease): ?>
            <div class="disease-card">
                <div class="disease-header">
                    <h4>
                        <span class="rank"><?php echo $index + 1; ?></span>
                        <?php echo htmlspecialchars($disease['disease_code']); ?> - 
                        <?php echo htmlspecialchars($disease['disease_name']); ?>
                    </h4>
                    <span class="match-badge"><?php echo round($disease['match_percentage']); ?>% Match</span>
                </div>
                
                <div class="match-bar">
                    <div class="match-progress" style="width: <?php echo round($disease['match_percentage']); ?>%"></div>
                </div>

                <div class="disease-description">
                    <h5>Deskripsi:</h5>
                    <p><?php echo htmlspecialchars($disease['description']); ?></p>
                </div>

                <div class="disease-info">
                    <p><strong>⚠️ Penting:</strong> Diagnosis ini berdasarkan analisis gejala yang Anda masukkan. Untuk diagnosis yang lebih akurat dan perawatan yang tepat, silakan konsultasikan dengan dokter hewan profesional.</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="form-actions">
        <a href="diagnosa.php" class="btn-primary">Diagnosa Lagi</a>
        <a href="riwayat.php" class="btn-secondary">Lihat Riwayat</a>
        <a href="index.php" class="btn-secondary">Kembali ke Home</a>
    </div>
</div>
</body>
</html>
