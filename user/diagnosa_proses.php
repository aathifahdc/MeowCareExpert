<?php
session_start();
require_once "../inc/config.php";

if (!isset($_POST['gejala']) || empty($_POST['gejala'])) {
    $_SESSION['error'] = "Pilih minimal satu gejala!";
    header("Location: diagnosa.php");
    exit;
}

$selected = $_POST['gejala']; // array id gejala
$selected_str = implode(",", $selected);

// Ambil semua rule dengan detail penyakit
$query = $pdo->query("
    SELECT rb.id AS rule_id, d.id as disease_id, d.code as disease_code, 
           d.name AS disease_name, d.description
    FROM rule_base rb
    JOIN disease d ON rb.disease_id = d.id
    ORDER BY d.code
");
$rules = $query->fetchAll(PDO::FETCH_ASSOC);

$hasil = [];
foreach ($rules as $r) {
    // Ambil gejala dalam rule
    $conds = $pdo->prepare("
        SELECT symptom_id FROM rule_condition WHERE rule_id=?
    ");
    $conds->execute([$r['rule_id']]);
    $conds = $conds->fetchAll(PDO::FETCH_COLUMN);

    // Cek apakah semua gejala dalam rule ada dalam input
    // dan hitung percentage match
    $match_count = count(array_intersect($conds, $selected));
    $total_symptoms = count($conds);
    
    if ($total_symptoms > 0) {
        $match_percentage = ($match_count / $total_symptoms) * 100;
        
        // Hanya accept jika minimal match 70% atau semua gejala cocok
        if ($match_percentage >= 70) {
            $hasil[] = [
                'disease_id' => $r['disease_id'],
                'disease_code' => $r['disease_code'],
                'disease_name' => $r['disease_name'],
                'description' => $r['description'],
                'match_percentage' => $match_percentage
            ];
        }
    }
}

// Sort by match percentage descending
usort($hasil, function($a, $b) {
    return $b['match_percentage'] - $a['match_percentage'];
});

// Jika tidak ada rule match
if (empty($hasil)) {
    $hasilText = "Tidak ada penyakit yang cocok dengan gejala yang dipilih.";
} else {
    $hasilText = json_encode($hasil);
}

// Simpan ke riwayat
try {
    $stmt = $pdo->prepare("INSERT INTO history (symptoms, result, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$selected_str, $hasilText]);
} catch (PDOException $e) {
    // Database error handling
}

$_SESSION['hasil'] = $hasil;
$_SESSION['gejala_dipilih'] = $selected;

header("Location: hasil.php");
exit;
header("Location: hasil.php");
exit;
