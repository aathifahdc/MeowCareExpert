<?php 
require_once "../inc/config.php";

$error = "";
$success = "";
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: rules.php");
    exit;
}

// Get rule data
$stmt = $pdo->prepare("SELECT * FROM rule_base WHERE id = ?");
$stmt->execute([$id]);
$rule = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rule) {
    header("Location: rules.php");
    exit;
}

// Get all diseases and symptoms
$diseases = $pdo->query("SELECT * FROM disease ORDER BY code")->fetchAll(PDO::FETCH_ASSOC);
$symptoms = $pdo->query("SELECT * FROM symptom ORDER BY code")->fetchAll(PDO::FETCH_ASSOC);

// Get current symptoms for this rule
$stmt = $pdo->prepare("SELECT symptom_id FROM rule_condition WHERE rule_id = ?");
$stmt->execute([$id]);
$current_symptoms = $stmt->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $disease_id = $_POST['disease_id'] ?? null;
    $symptom_ids = $_POST['symptom_ids'] ?? [];
    
    if (empty($disease_id)) {
        $error = "Pilih penyakit terlebih dahulu!";
    } elseif (empty($symptom_ids)) {
        $error = "Pilih minimal satu gejala!";
    } else {
        try {
            // Update rule
            $stmt = $pdo->prepare("UPDATE rule_base SET disease_id = ? WHERE id = ?");
            $stmt->execute([$disease_id, $id]);
            
            // Delete old conditions
            $stmt = $pdo->prepare("DELETE FROM rule_condition WHERE rule_id = ?");
            $stmt->execute([$id]);
            
            // Insert new conditions
            $stmt = $pdo->prepare("INSERT INTO rule_condition (rule_id, symptom_id) VALUES (?, ?)");
            foreach ($symptom_ids as $symptom_id) {
                $stmt->execute([$id, $symptom_id]);
            }
            
            $success = "Aturan berhasil diupdate!";
            
            // Reload data
            $current_symptoms = $symptom_ids;
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
    <title>Edit Aturan - Admin MeowCare Expert</title>
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
        <h1>Edit Aturan</h1>
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
                <label for="disease_id">Pilih Penyakit:</label>
                <select id="disease_id" name="disease_id" required>
                    <option value="">-- Pilih Penyakit --</option>
                    <?php foreach ($diseases as $disease): ?>
                        <option value="<?php echo $disease['id']; ?>" 
                                <?php echo $disease['id'] == $rule['disease_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($disease['code'] . ' - ' . $disease['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Pilih Gejala yang Sesuai:</label>
                <div class="checkbox-group">
                    <?php foreach ($symptoms as $symptom): ?>
                        <div class="checkbox-item">
                            <input type="checkbox" id="symptom_<?php echo $symptom['id']; ?>" 
                                   name="symptom_ids[]" value="<?php echo $symptom['id']; ?>"
                                   <?php echo in_array($symptom['id'], $current_symptoms) ? 'checked' : ''; ?>>
                            <label for="symptom_<?php echo $symptom['id']; ?>">
                                <?php echo htmlspecialchars($symptom['code'] . ' - ' . $symptom['name']); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Aturan</button>
                <a href="rules.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
