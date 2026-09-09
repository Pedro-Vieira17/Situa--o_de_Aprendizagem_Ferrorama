<?php
require_once '../infra/conexao.php';

// Só aceita requisições enviadas pelo formulário (POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastrar_sensores.php');
    exit;
}

$nome = trim($_POST['nomeSensor'] ?? '');
$localizacao = trim($_POST['localizacao'] ?? '');
$tipoDado = trim($_POST['tipoDado'] ?? '');
$tremId = $_POST['tremVinculado'] ?? '';

// Validação básica dos campos obrigatórios
if ($nome === '' || $localizacao === '' || $tipoDado === '' || $tremId === '') {
    header('Location: cadastrar_sensores.php?erro=' . urlencode('Preencha todos os campos.'));
    exit;
}

if (!ctype_digit((string)$tremId)) {
    header('Location: cadastrar_sensores.php?erro=' . urlencode('Trem vinculado inválido.'));
    exit;
}

// Confere se o trem realmente existe (regra: só pode vincular a um trem já cadastrado)
$stmt = $pdo->prepare('SELECT id FROM TRENS WHERE id = :id');
$stmt->execute(['id' => $tremId]);

if (!$stmt->fetch()) {
    header('Location: cadastrar_sensores.php?erro=' . urlencode('O trem selecionado não existe.'));
    exit;
}

// Insere o sensor vinculado ao trem
$insere = $pdo->prepare(
    'INSERT INTO SENSORES (nome, localizacao, tipo_de_dado, trens_id)
     VALUES (:nome, :localizacao, :tipo_de_dado, :trens_id)'
);

try {
    $insere->execute([
        'nome' => $nome,
        'localizacao' => $localizacao,
        'tipo_de_dado' => $tipoDado,
        'trens_id' => $tremId,
    ]);
} catch (PDOException $e) {
    header('Location: cadastrar_sensores.php?erro=' . urlencode('Erro ao salvar: ' . $e->getMessage()));
    exit;
}

header('Location: gerenciar_sensores.html?sucesso=1');
exit;