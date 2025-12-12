<?php
require_once "inc/config.php";

echo "=== TEST DATABASE ===\n\n";

// Test 1: Cek jumlah disease
$diseases = $pdo->query("SELECT COUNT(*) as total FROM disease")->fetch(PDO::FETCH_ASSOC);
echo "Total Disease: " . $diseases['total'] . "\n";

// Test 2: Cek jumlah symptom
$symptoms = $pdo->query("SELECT COUNT(*) as total FROM symptom")->fetch(PDO::FETCH_ASSOC);
echo "Total Symptom: " . $symptoms['total'] . "\n";

// Test 3: Cek jumlah rule_base
$rules = $pdo->query("SELECT COUNT(*) as total FROM rule_base")->fetch(PDO::FETCH_ASSOC);
echo "Total Rule Base: " . $rules['total'] . "\n";

// Test 4: Cek jumlah rule_condition
$conditions = $pdo->query("SELECT COUNT(*) as total FROM rule_condition")->fetch(PDO::FETCH_ASSOC);
echo "Total Rule Condition: " . $conditions['total'] . "\n";

// Test 5: Cek detail rule dengan gejala
echo "\n=== DETAIL RULE ===\n";
$query = $pdo->query("
    SELECT rb.id as rule_id, d.code, d.name, 
           (SELECT COUNT(*) FROM rule_condition WHERE rule_id = rb.id) as symptom_count
    FROM rule_base rb
    JOIN disease d ON rb.disease_id = d.id
    ORDER BY d.code
");
$rules_detail = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($rules_detail as $rule) {
    echo "Rule ID {$rule['rule_id']}: {$rule['code']} - {$rule['name']} ({$rule['symptom_count']} gejala)\n";
}

// Test 6: Test diagnosis dengan sample gejala
echo "\n=== TEST DIAGNOSIS ===\n";
$sample_symptoms = [5, 14, 31, 9, 28]; // Bersin, Hidung berair, Mata berair, Demam, Lesu

foreach ($rules_detail as $rule) {
    // Cek gejala dalam rule ini
    $conds = $pdo->prepare("
        SELECT symptom_id FROM rule_condition WHERE rule_id=?
    ");
    $conds->execute([$rule['rule_id']]);
    $rule_symptoms = $conds->fetchAll(PDO::FETCH_COLUMN);
    
    $match_count = count(array_intersect($rule_symptoms, $sample_symptoms));
    $rule_symptom_count = count($rule_symptoms);
    
    if ($rule_symptom_count > 0) {
        $match_percentage = ($match_count / $rule_symptom_count) * 100;
        echo "Rule {$rule['code']}: {$match_count}/{$rule_symptom_count} = " . round($match_percentage, 2) . "%\n";
    }
}

echo "\n=== DONE ===\n";
?>
