<?php
require_once "../infra/conexao.php";

$localizacao = trim($_POST['localizacao'] ?? '');
$tipoDado    = trim($_POST['tipoDado'] ?? '');
$status      = trim($_POST['status'] ?? '');

// Validação básica dos campos obrigatórios
if ($localizacao === '' || $tipoDado === '' || $status === '') {
    header('Location: cadastrar_trens.php?erro=' . urlencode('Preencha todos os campos obrigatórios.'));
    exit;
}

$stmt = $conexao->prepare('INSERT INTO TRENS (localizacao, tipo_de_dado, status) VALUES (?, ?, ?)');

if (!$stmt) {
    header('Location: cadastrar_trens.php?erro=' . urlencode('Erro ao preparar a consulta: ' . $conexao->error));
    exit;
}

$stmt->bind_param('sss', $localizacao, $tipoDado, $status);

if ($stmt->execute()) {
    $stmt->close();
    header('Location: cadastrar_trens.php?sucesso=1');
    exit;
} else {
    $erro = $stmt->error;
    $stmt->close();
    header('Location: cadastrar_trens.php?erro=' . urlencode('Erro ao cadastrar trem: ' . $erro));
    exit;
}