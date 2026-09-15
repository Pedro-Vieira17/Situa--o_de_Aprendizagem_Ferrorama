<?php
require_once '../infra/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: gerenciar_sensores.html');
    exit;
}

$id = $_POST['id'] ?? null;

if (!$id || !ctype_digit((string)$id)) {
    header('Location: gerenciar_sensores.html?erro=' . urlencode('Trem inválido.'));
    exit;
}


$stmt = $pdo->prepare('DELETE FROM TRENS WHERE id = :id');

try {
    $stmt->execute(['id' => $id]);
} catch (PDOException $e) {
    header('Location: gerenciar_sensores.html?erro=' . urlencode('Erro ao excluir: ' . $e->getMessage()));
    exit;
}

if ($stmt->rowCount() === 0) {
    header('Location: gerenciar_sensores.html?erro=' . urlencode('Trem não encontrado.'));
    exit;
}

header('Location: gerenciar_sensores.html?excluido=1');
exit;