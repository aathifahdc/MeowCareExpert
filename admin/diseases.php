<?php 
require_once "../inc/config.php";

// Get all diseases
$diseases = $pdo->query("SELECT * FROM disease ORDER BY code")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyakit - Admin MeowCare Expert</title>
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
        <h1>Daftar Penyakit</h1>
        <a href="disease_add.php" class="btn btn-primary">+ Tambah Penyakit</a>
    </div>

    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (empty($diseases)): ?>
            <p>Belum ada data penyakit.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Penyakit</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($diseases as $disease): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($disease['code']); ?></td>
                            <td><?php echo htmlspecialchars($disease['name']); ?></td>
                            <td><?php echo htmlspecialchars(substr($disease['description'], 0, 50)) . '...'; ?></td>
                            <td>
                                <a href="disease_edit.php?id=<?php echo $disease['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="disease_delete.php?id=<?php echo $disease['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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
