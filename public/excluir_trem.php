<?php

require_once "../infra/conexao.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: tela_inicial.php");
    exit;
}

$id = (int) $_GET["id"];

try {
    $stmt = $conexao->prepare("DELETE FROM TRENS WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: tela_inicial.php");
    exit;
} catch (Exception $e) {
    echo "Erro ao excluir: " . htmlspecialchars($e->getMessage());
}