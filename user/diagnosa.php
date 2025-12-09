<?php 
require_once "../inc/config.php";

$error = "";
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

$symptoms = $pdo->query("SELECT * FROM symptom ORDER BY code")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosa Penyakit Kucing - MeowCare Expert</title>
    <link rel="stylesheet" href="../assets/user/style.css">
</head>

<body>
<div class="hero">
    <img src="assets/cat.png" class="cat-hero">
    <h1>MeowCare Expert</h1>
    <p>Sistem Pakar Diagnosa Penyakit Kucing</p>
</div>

<div class="container">
    <h2>Diagnosa Penyakit Kucing Anda</h2>
    <p>Silakan pilih gejala yang dialami kucing Anda untuk mendapatkan diagnosis akurat.</p>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="diagnosa_proses.php" method="POST" class="diagnosa-form">
        <div class="symptoms-container">
            <h3>Pilih Gejala yang Dialami:</h3>
            
            <?php if (empty($symptoms)): ?>
                <p>Tidak ada data gejala yang tersedia.</p>
            <?php else: ?>
                <div class="symptoms-grid">
                    <?php foreach($symptoms as $s): ?>
                    <div class="symptom-item">
                        <input type="checkbox" id="symptom_<?php echo $s['id']; ?>" 
                               name="gejala[]" value="<?php echo $s['id']; ?>" class="symptom-checkbox">
                        <label for="symptom_<?php echo $s['id']; ?>">
                            <span class="symptom-code"><?php echo htmlspecialchars($s['code']); ?></span>
                            <span class="symptom-name"><?php echo htmlspecialchars($s['name']); ?></span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Proses Diagnosa</button>
            <a href="index.php" class="btn-secondary">Kembali ke Home</a>
        </div>
    </form>
</div>

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
