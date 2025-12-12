<?php
session_start();
require_once "../inc/config.php";

// Tidak perlu login untuk melakukan diagnosa
if (!isset($_POST['gejala']) || empty($_POST['gejala'])) {
    $_SESSION['error'] = "Pilih minimal satu gejala!";
    header("Location: diagnosa.php");
    exit;
}

$selected = $_POST['gejala']; // array id gejala
$selected_count = count($selected);

// Debug: Log selected symptoms
error_log("Selected symptoms: " . implode(",", $selected));

// Ambil semua rule dengan detail penyakit
$query = $pdo->query("
    SELECT rb.id AS rule_id, d.id as disease_id, d.code as disease_code, 
           d.name AS disease_name, d.description
    FROM rule_base rb
    JOIN disease d ON rb.disease_id = d.id
    ORDER BY d.code
");
$rules = $query->fetchAll(PDO::FETCH_ASSOC);

error_log("Total rules found: " . count($rules));

$hasil = [];
foreach ($rules as $r) {
    // Ambil gejala dalam rule
    $conds = $pdo->prepare("
        SELECT symptom_id FROM rule_condition WHERE rule_id=?
    ");
    $conds->execute([$r['rule_id']]);
    $rule_symptoms = $conds->fetchAll(PDO::FETCH_COLUMN);

    error_log("Rule {$r['disease_code']}: Found " . count($rule_symptoms) . " symptoms in database");

    // Hitung berapa banyak gejala user yang cocok dengan gejala rule
    $match_count = count(array_intersect($rule_symptoms, $selected));
    $rule_symptom_count = count($rule_symptoms);
    
    if ($rule_symptom_count > 0) {
        // Persentase: berapa % gejala rule yang dipenuhi oleh user
        $match_percentage = ($match_count / $rule_symptom_count) * 100;
        
        error_log("Rule {$r['disease_code']}: Match {$match_count}/{$rule_symptom_count} = {$match_percentage}%");
        
        // Hanya accept jika minimal match 50% (lebih realistis)
        if ($match_percentage >= 50) {
            $hasil[] = [
                'disease_id' => $r['disease_id'],
                'disease_code' => $r['disease_code'],
                'disease_name' => $r['disease_name'],
                'description' => $r['description'],
                'match_percentage' => round($match_percentage, 2),
                'matched_symptoms' => $match_count,
                'total_symptoms' => $rule_symptom_count
            ];
        }
    }
}

error_log("Total results with >= 50% match: " . count($hasil));

// Sort by match percentage descending
usort($hasil, function($a, $b) {
    return $b['match_percentage'] - $a['match_percentage'];
});

// Jika tidak ada hasil, tampilkan pesan
if (empty($hasil)) {
    error_log("No diseases matched - redirecting to diagnosa with error message");
    $_SESSION['error'] = "Tidak ada penyakit yang cocok dengan gejala yang dipilih (threshold 50%). Coba pilih gejala lain atau konsultasi dengan dokter hewan.";
    header("Location: diagnosa.php");
    exit;
}

$_SESSION['hasil'] = $hasil;
$_SESSION['gejala_dipilih'] = $selected;

header("Location: hasil.php");
exit;
