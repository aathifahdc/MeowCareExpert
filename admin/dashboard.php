<?php 
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once "../inc/config.php";

// Get statistics
$disease_count = $pdo->query("SELECT COUNT(*) as count FROM disease")->fetch(PDO::FETCH_ASSOC)['count'];
$symptom_count = $pdo->query("SELECT COUNT(*) as count FROM symptom")->fetch(PDO::FETCH_ASSOC)['count'];
$rule_count = $pdo->query("SELECT COUNT(*) as count FROM rule_base")->fetch(PDO::FETCH_ASSOC)['count'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin MeowCare Expert</title>
    <link rel="stylesheet" href="../assets/admin/style.css">
</head>
<body>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <nav>
        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="diseases.php">Penyakit</a>
        <a href="symtomps.php">Gejala</a>
        <a href="rules.php">Aturan</a>
        <a href="logout.php">Logout</a>
    </nav>
</div>

<div class="main-content">
    <div class="header">
        <h1>Dashboard</h1>
        <p>Selamat datang, <?php echo $_SESSION['admin_username']; ?>!</p>
    </div>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <h3><?php echo $disease_count; ?></h3>
                <p>Penyakit</p>
                <a href="diseases.php" class="btn btn-small">Kelola</a>
            </div>

            <div class="stat-card">
                <h3><?php echo $symptom_count; ?></h3>
                <p>Gejala</p>
                <a href="symtomps.php" class="btn btn-small">Kelola</a>
            </div>

            <div class="stat-card">
                <h3><?php echo $rule_count; ?></h3>
                <p>Aturan</p>
                <a href="rules.php" class="btn btn-small">Kelola</a>
            </div>
        </div>

        <div class="info-box">
            <h2>Informasi Sistem</h2>
            <p><strong>MeowCare Expert</strong> adalah sistem pakar untuk diagnosa penyakit kucing menggunakan metode <strong>Forward Chaining</strong>.</p>
            <p>Gunakan menu di samping untuk mengelola data penyakit, gejala, dan aturan diagnosis.</p>
        </div>
    </div>
</div>
</body>
</html>