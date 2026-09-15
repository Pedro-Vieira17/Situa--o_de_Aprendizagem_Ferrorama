<?php
require_once "../infra/conexao.php";

$id          = $_POST['id'] ?? null;
$localizacao = trim($_POST['localizacao'] ?? '');
$tipoDado    = trim($_POST['tipoDado'] ?? '');
$status      = trim($_POST['status'] ?? '');

if (!$id || $localizacao === '' || $tipoDado === '' || $status === '') {
    header('Location: editar_trens.php?id=' . urlencode($id ?? '') . '&erro=' . urlencode('Preencha todos os campos obrigatórios.'));
    exit;
}

$stmt = $conexao->prepare('UPDATE TRENS SET localizacao = ?, tipo_de_dado = ?, status = ? WHERE id = ?');

if (!$stmt) {
    header('Location: editar_trens.php?id=' . urlencode($id) . '&erro=' . urlencode('Erro ao preparar a consulta: ' . $conexao->error));
    exit;
}

$stmt->bind_param('sssi', $localizacao, $tipoDado, $status, $id);

if ($stmt->execute()) {
    $stmt->close();
    header('Location: tela_inicial.php');
    exit;
} else {
    $erro = $stmt->error;
    $stmt->close();
    header('Location: editar_trens.php?id=' . urlencode($id) . '&erro=' . urlencode('Erro ao atualizar trem: ' . $erro));
    exit;
}