<?php 
require_once "../inc/config.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: symtomps.php");
    exit;
}

try {
    // Check jika gejala digunakan dalam rule
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM rule_condition WHERE symptom_id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] > 0) {
        $_SESSION['error'] = "Gejala tidak bisa dihapus karena masih digunakan dalam aturan!";
    } else {
        $stmt = $pdo->prepare("DELETE FROM symptom WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Gejala berhasil dihapus!";
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

header("Location: symtomps.php");
exit;
?>
