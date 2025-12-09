<?php
require_once "../inc/config.php";

$data = $pdo->query("
    SELECT * FROM history ORDER BY created_at DESC LIMIT 100
")->fetchAll(PDO::FETCH_ASSOC);

// Get symptom list for mapping
$symptomList = $pdo->query("SELECT id, code FROM symptom")->fetchAll(PDO::FETCH_KEY_PAIR);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Diagnosa - MeowCare Expert</title>
    <link rel="stylesheet" href="../assets/user/style.css">
</head>

<body>
<div class="hero">
    <img src="assets/cat.png" class="cat-hero">
    <h1>MeowCare Expert</h1>
    <p>Riwayat Diagnosa Penyakit Kucing</p>
</div>

<div class="container">
    <h2>Riwayat Diagnosa</h2>

    <?php if (empty($data)): ?>
        <div class="alert alert-info">
            <p>Belum ada riwayat diagnosa. Mulai diagnosa baru dengan klik tombol di bawah.</p>
        </div>
    <?php else: ?>
        <div class="history-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal & Waktu</th>
                        <th>Gejala yang Dipilih</th>
                        <th>Hasil Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach($data as $row): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td>
                            <small><?php echo date('d/m/Y H:i:s', strtotime($row['created_at'])); ?></small>
                        </td>
                        <td>
                            <div class="symptoms-cell">
                                <?php
                                $ids = array_filter(explode(",", $row['symptoms']));
                                foreach ($ids as $id) {
                                    if (isset($symptomList[$id])) {
                                        echo "<span class='tag'>" . htmlspecialchars($symptomList[$id]) . "</span> ";
                                    }
                                }
                                if (empty($ids)) {
                                    echo "<em>-</em>";
                                }
                                ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            $result = $row['result'];
                            
                            // Try to decode JSON result
                            $decoded = json_decode($result, true);
                            
                            if (is_array($decoded) && !empty($decoded)) {
                                echo "<ul style='margin: 0; padding-left: 20px;'>";
                                foreach ($decoded as $disease) {
                                    if (is_array($disease)) {
                                        echo "<li>" . htmlspecialchars($disease['disease_name']) . 
                                             " (" . round($disease['match_percentage']) . "%)</li>";
                                    }
                                }
                                echo "</ul>";
                            } else {
                                echo htmlspecialchars($result);
                            }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="form-actions">
        <a href="diagnosa.php" class="btn-primary">Diagnosa Baru</a>
        <a href="index.php" class="btn-secondary">Kembali ke Home</a>
    </div>
</div>
</body>
</html>
