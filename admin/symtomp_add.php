<?php 
require_once "../inc/config.php";

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = trim($_POST['code'] ?? '');
    $name = trim($_POST['name'] ?? '');
    
    if (empty($code) || empty($name)) {
        $error = "Kode dan nama gejala harus diisi!";
    } else {
        try {
            // Check jika kode sudah ada
            $stmt = $pdo->prepare("SELECT id FROM symptom WHERE code = ?");
            $stmt->execute([$code]);
            if ($stmt->fetch()) {
                $error = "Kode gejala sudah terdaftar!";
            } else {
                $stmt = $pdo->prepare("INSERT INTO symptom (code, name) VALUES (?, ?)");
                $stmt->execute([$code, $name]);
                $success = "Gejala berhasil ditambahkan!";
                $_POST = [];
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gejala - Admin MeowCare Expert</title>
    <link rel="stylesheet" href="../assets/admin/style.css">
</head>
<body>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="diseases.php">Penyakit</a>
        <a href="symtomps.php" class="active">Gejala</a>
        <a href="rules.php">Aturan</a>
        <a href="logout.php">Logout</a>
    </nav>
</div>

<div class="main-content">
    <div class="header">
        <h1>Tambah Gejala Baru</h1>
    </div>

    <div class="container">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" class="form">
            <div class="form-group">
                <label for="code">Kode Gejala:</label>
                <input type="text" id="code" name="code" placeholder="Contoh: G01" value="<?php echo $_POST['code'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="name">Nama Gejala:</label>
                <input type="text" id="name" name="name" placeholder="Contoh: Demam" value="<?php echo $_POST['name'] ?? ''; ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Tambah Gejala</button>
                <a href="symtomps.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
