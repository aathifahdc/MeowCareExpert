<?php 
require_once "../inc/config.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: rules.php");
    exit;
}

try {
    // Delete rule conditions first
    $stmt = $pdo->prepare("DELETE FROM rule_condition WHERE rule_id = ?");
    $stmt->execute([$id]);
    
    // Delete rule
    $stmt = $pdo->prepare("DELETE FROM rule_base WHERE id = ?");
    $stmt->execute([$id]);
    
    $_SESSION['success'] = "Aturan berhasil dihapus!";
} catch (PDOException $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

header("Location: rules.php");
exit;
?>
