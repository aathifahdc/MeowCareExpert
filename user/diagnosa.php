<?php 
session_start();
require_once "../inc/config.php";

$error = "";
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

$symptoms = $pdo->query("SELECT * FROM symptom ORDER BY code")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosa Penyakit Kucing - MeowCare Expert</title>
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

<div class="container-lg" style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
    <!-- Header -->
    <h1 class="text-primary fw-bold mb-2">🔍 Diagnosa Penyakit Kucing Anda</h1>
    <p class="text-muted lead mb-4">Silakan pilih gejala yang dialami kucing Anda untuk mendapatkan diagnosis akurat dan detail.</p>

    <!-- Info Box -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle-fill"></i> <strong>ℹ️ Informasi Penting:</strong> Untuk diagnosis yang akurat, pilih minimal <strong>3-5 gejala</strong> yang dialami kucing Anda. Diagnosis akan mencocokkan gejala dengan penyakit yang memiliki kecocokan minimal 50%.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>⚠️ Error!</strong> <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Diagnosis Form -->
    <div class="content-wrapper">
        <form action="diagnosa_proses.php" method="POST" id="diagnosaForm">
            <h3 class="text-primary mb-4">
                <span class="badge badge-primary">Step 1</span> Pilih Gejala yang Dialami
            </h3>
            
            <?php if (empty($symptoms)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Tidak ada data gejala yang tersedia. Silakan hubungi administrator.
                </div>
            <?php else: ?>
                <div class="symptom-grid">
                    <?php foreach($symptoms as $s): ?>
                    <div class="symptom-card" onclick="toggleSymptom(this)">
                        <input type="checkbox" id="symptom_<?php echo $s['id']; ?>" 
                               name="gejala[]" value="<?php echo $s['id']; ?>" class="symptom-checkbox"
                               onchange="toggleSymptomCard(this)">
                        <div class="symptom-info">
                            <span class="symptom-code"><?php echo htmlspecialchars($s['code']); ?></span>
                            <span class="symptom-name"><?php echo htmlspecialchars($s['name']); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Selected Count Info -->
                <div class="mt-4 p-3 bg-light rounded-3">
                    <p class="mb-0 text-muted">
                        <strong id="selectedCount">0</strong> gejala dipilih
                    </p>
                </div>
            <?php endif; ?>

            <!-- Form Actions -->
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                    <i class="bi bi-check-circle"></i> Proses Diagnosa
                </button>
                <a href="index.php" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-left"></i> Kembali ke Home
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSymptomCard(checkbox) {
        const card = checkbox.closest('.symptom-card');
        if (checkbox.checked) {
            card.classList.add('active');
        } else {
            card.classList.remove('active');
        }
        updateSelectedCount();
    }

    function toggleSymptom(card) {
        const checkbox = card.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
        checkbox.dispatchEvent(new Event('change'));
    }

    function updateSelectedCount() {
        const selected = document.querySelectorAll('input[name="gejala[]"]:checked').length;
        document.getElementById('selectedCount').textContent = selected;
        document.getElementById('submitBtn').disabled = selected === 0;
        
        // Update warning message if less than 3 symptoms
        let warningMsg = document.getElementById('warningMsg');
        if (!warningMsg) {
            warningMsg = document.createElement('div');
            warningMsg.id = 'warningMsg';
            warningMsg.className = 'alert alert-warning mt-3';
            document.getElementById('selectedCount').parentElement.parentElement.appendChild(warningMsg);
        }
        
        if (selected > 0 && selected < 3) {
            warningMsg.style.display = 'block';
            warningMsg.innerHTML = `<i class="bi bi-exclamation-triangle-fill"></i> <strong>⚠️ Peringatan:</strong> Anda baru memilih ${selected} gejala. Untuk diagnosis yang lebih akurat, disarankan memilih minimal 3-5 gejala.`;
        } else {
            warningMsg.style.display = 'none';
        }
    }

    // Initialize
    updateSelectedCount();
</script>
</body>
</html>

<script>
    // Validasi form
    document.querySelector('.diagnosa-form').addEventListener('submit', function(e) {
        const checkboxes = document.querySelectorAll('.symptom-checkbox');
        const checked = Array.from(checkboxes).some(cb => cb.checked);
        
        if (!checked) {
            e.preventDefault();
            alert('Pilih minimal satu gejala!');
        }
    });
</script>
</body>
</html>
