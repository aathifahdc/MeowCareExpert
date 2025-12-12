<?php
session_start();
require_once "../inc/config.php";

// Get all symptoms with detail from database
$query = "SELECT s.*, sg.description, sg.how_to_identify, sg.when_to_see_vet, sg.prevention
          FROM symptom s
          LEFT JOIN symptom_guide sg ON s.id = sg.symptom_id
          ORDER BY s.code";
$symptoms = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Gejala - MeowCare Expert</title>
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
                    <a class="nav-link active" href="guide.php">📚 Panduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="diseases.php">🏥 Info Penyakit</a>
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
    <h1 class="text-primary fw-bold mb-2">📚 Panduan Gejala Kucing</h1>
    <p class="text-muted lead mb-5">Pelajari cara mengidentifikasi gejala penyakit kucing dengan detail lengkap dan tips pencegahan</p>

    <!-- Symptoms Grid -->
    <div class="guide-grid">
        <?php if (empty($symptoms)): ?>
            <div class="alert alert-info w-100">
                <i class="bi bi-info-circle"></i> Tidak ada data panduan gejala yang tersedia.
            </div>
        <?php else: ?>
            <?php foreach ($symptoms as $symptom): ?>
            <div class="guide-card" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $symptom['id']; ?>">
                <div class="guide-code"><?php echo htmlspecialchars($symptom['code']); ?></div>
                <div class="guide-icon">🔍</div>
                <div class="guide-title"><?php echo htmlspecialchars($symptom['name']); ?></div>
            </div>

            <!-- Modal untuk detail gejala -->
            <div class="modal fade" id="modal_<?php echo $symptom['id']; ?>" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <span class="text-primary"><?php echo htmlspecialchars($symptom['code']); ?></span>
                                - <?php echo htmlspecialchars($symptom['name']); ?>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <?php if (!empty($symptom['description'])): ?>
                            <div class="mb-4">
                                <h6 class="text-primary fw-bold">📝 Deskripsi</h6>
                                <p><?php echo htmlspecialchars($symptom['description']); ?></p>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($symptom['how_to_identify'])): ?>
                            <div class="mb-4">
                                <h6 class="text-primary fw-bold">🔎 Cara Mengidentifikasi</h6>
                                <ul class="ms-3">
                                    <?php foreach (explode('|', $symptom['how_to_identify']) as $item): ?>
                                        <?php if (trim($item)): ?>
                                        <li class="mb-2"><?php echo htmlspecialchars(trim($item)); ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($symptom['when_to_see_vet'])): ?>
                            <div class="mb-4">
                                <h6 class="text-danger fw-bold">⚠️ Kapan Harus Ke Dokter</h6>
                                <ul class="ms-3">
                                    <?php foreach (explode('|', $symptom['when_to_see_vet']) as $item): ?>
                                        <?php if (trim($item)): ?>
                                        <li class="mb-2"><?php echo htmlspecialchars(trim($item)); ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($symptom['prevention'])): ?>
                            <div class="mb-4">
                                <h6 class="text-success fw-bold">💚 Tips Pencegahan</h6>
                                <ul class="ms-3">
                                    <?php foreach (explode('|', $symptom['prevention']) as $item): ?>
                                        <?php if (trim($item)): ?>
                                        <li class="mb-2"><?php echo htmlspecialchars(trim($item)); ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <a href="diagnosa.php" class="btn btn-primary">
                                <i class="bi bi-search"></i> Cek Gejala Ini
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- CTA Section -->
    <div class="content-wrapper text-center bg-gradient py-5 mt-5">
        <h3 class="text-primary mb-3">Sudah Mengenali Gejalanya?</h3>
        <p class="mb-4">Lakukan diagnosa sekarang untuk mengetahui kemungkinan penyakit kucing Anda</p>
        <a href="diagnosa.php" class="btn btn-primary btn-lg">
            <i class="bi bi-search"></i> Mulai Diagnosa
        </a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
