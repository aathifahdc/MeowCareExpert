<?php 
require_once "../inc/config.php";

// Get all rules with disease info
$stmt = $pdo->prepare("
    SELECT rb.id, d.code as disease_code, d.name as disease_name, 
           GROUP_CONCAT(s.code ORDER BY s.code SEPARATOR ', ') as symptom_codes,
           GROUP_CONCAT(s.name ORDER BY s.code SEPARATOR ', ') as symptom_names
    FROM rule_base rb
    JOIN disease d ON rb.disease_id = d.id
    LEFT JOIN rule_condition rc ON rb.id = rc.rule_id
    LEFT JOIN symptom s ON rc.symptom_id = s.id
    GROUP BY rb.id, d.id
    ORDER BY d.code
");
$stmt->execute();
$rules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aturan - Admin MeowCare Expert</title>
    <link rel="stylesheet" href="../assets/admin/style.css">
</head>
<body>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="diseases.php">Penyakit</a>
        <a href="symtomps.php">Gejala</a>
        <a href="rules.php" class="active">Aturan</a>
        <a href="logout.php">Logout</a>
    </nav>
</div>

<div class="main-content">
    <div class="header">
        <h1>Daftar Aturan (Rule Base)</h1>
        <a href="rule_add.php" class="btn btn-primary">+ Tambah Aturan</a>
    </div>

    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (empty($rules)): ?>
            <p>Belum ada data aturan.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Kode Penyakit</th>
                        <th>Nama Penyakit</th>
                        <th>Gejala</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rules as $rule): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($rule['disease_code']); ?></td>
                            <td><?php echo htmlspecialchars($rule['disease_name']); ?></td>
                            <td>
                                <small><?php echo htmlspecialchars($rule['symptom_codes']); ?></small><br>
                                <?php echo htmlspecialchars(substr($rule['symptom_names'], 0, 50)); ?>
                                <?php if (strlen($rule['symptom_names']) > 50): ?>...<?php endif; ?>
                            </td>
                            <td>
                                <a href="rule_edit.php?id=<?php echo $rule['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="rule_delete.php?id=<?php echo $rule['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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
