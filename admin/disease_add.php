<?php 
require_once "../inc/config.php";

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = trim($_POST['code'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    if (empty($code) || empty($name) || empty($description)) {
        $error = "Semua field harus diisi!";
    } else {
        try {
            // Check jika kode sudah ada
            $stmt = $pdo->prepare("SELECT id FROM disease WHERE code = ?");
            $stmt->execute([$code]);
            if ($stmt->fetch()) {
                $error = "Kode penyakit sudah terdaftar!";
            } else {
                $stmt = $pdo->prepare("INSERT INTO disease (code, name, description) VALUES (?, ?, ?)");
                $stmt->execute([$code, $name, $description]);
                $success = "Penyakit berhasil ditambahkan!";
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
    <title>Tambah Penyakit - Admin MeowCare Expert</title>
    <link rel="stylesheet" href="../assets/admin/style.css">
</head>
<body>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="diseases.php" class="active">Penyakit</a>
        <a href="symtomps.php">Gejala</a>
        <a href="rules.php">Aturan</a>
        <a href="logout.php">Logout</a>
    </nav>
</div>

<div class="main-content">
    <div class="header">
        <h1>Tambah Penyakit Baru</h1>
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
                <label for="code">Kode Penyakit:</label>
                <input type="text" id="code" name="code" placeholder="Contoh: P01" value="<?php echo $_POST['code'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="name">Nama Penyakit:</label>
                <input type="text" id="name" name="name" placeholder="Contoh: Feline Panleukopenia" value="<?php echo $_POST['name'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Penyakit:</label>
                <textarea id="description" name="description" rows="5" placeholder="Masukkan deskripsi lengkap penyakit" required><?php echo $_POST['description'] ?? ''; ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Tambah Penyakit</button>
                <a href="diseases.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
