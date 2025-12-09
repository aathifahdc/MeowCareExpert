<?php 
require_once "../inc/config.php";

// Get all symptoms
$symptoms = $pdo->query("SELECT * FROM symptom ORDER BY code")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gejala - Admin MeowCare Expert</title>
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
        <h1>Daftar Gejala</h1>
        <a href="symtomp_add.php" class="btn btn-primary">+ Tambah Gejala</a>
    </div>

    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (empty($symptoms)): ?>
            <p>Belum ada data gejala.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Gejala</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($symptoms as $symptom): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($symptom['code']); ?></td>
                            <td><?php echo htmlspecialchars($symptom['name']); ?></td>
                            <td>
                                <a href="symtomp_edit.php?id=<?php echo $symptom['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="symtomp_delete.php?id=<?php echo $symptom['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
