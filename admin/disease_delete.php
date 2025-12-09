<?php 
require_once "../inc/config.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: diseases.php");
    exit;
}

try {
    // Check jika penyakit digunakan dalam rule
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM rule_base WHERE disease_id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] > 0) {
        $_SESSION['error'] = "Penyakit tidak bisa dihapus karena masih digunakan dalam aturan!";
    } else {
        $stmt = $pdo->prepare("DELETE FROM disease WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Penyakit berhasil dihapus!";
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

header("Location: diseases.php");
exit;
?>
