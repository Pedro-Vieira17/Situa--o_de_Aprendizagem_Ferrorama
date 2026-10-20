<?php
require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";
exigirAdministrador();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: rotas.php");
    exit;
}

validarTokenCsrf();

$nome = trim($_POST["nome"] ?? "");
$descricao = trim($_POST["descricao"] ?? "");
$distancia = filter_var($_POST["distancia_km"] ?? null, FILTER_VALIDATE_FLOAT);
$tremId = filter_var($_POST["trem_id"] ?? null, FILTER_VALIDATE_INT);
$duracao = filter_var($_POST["duracao_min"] ?? null, FILTER_VALIDATE_INT);
$status = trim($_POST["status"] ?? "");
$statusPermitidos = ["Ativa", "Inativa", "Manutenção"];

if ($nome === "" || mb_strlen($nome) > 200 || $descricao === "" || $distancia === false || $distancia <= 0 || $tremId === false || $tremId <= 0 || $duracao === false || $duracao <= 0 || !in_array($status, $statusPermitidos, true)) {
    header("Location: cadastrar_rota.php?erro=" . urlencode("Preencha os campos corretamente."));
    exit;
}

$verificar = $conexao->prepare("SELECT id FROM TRENS WHERE id = ?");
if (!$verificar) {
    header("Location: cadastrar_rota.php?erro=" . urlencode("Não foi possível validar o trem selecionado."));
    exit;
}
$verificar->bind_param("i", $tremId);
$verificar->execute();
$existeTrem = $verificar->get_result()->num_rows === 1;
$verificar->close();

if (!$existeTrem) {
    header("Location: cadastrar_rota.php?erro=" . urlencode("Selecione um trem válido."));
    exit;
}

$stmt = $conexao->prepare("INSERT INTO ROTAS (nome, descricao, distancia_km, trem_id, duracao_min, status) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    header("Location: cadastrar_rota.php?erro=" . urlencode("Erro ao preparar o cadastro da rota."));
    exit;
}

$stmt->bind_param("ssdiis", $nome, $descricao, $distancia, $tremId, $duracao, $status);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: rotas.php?sucesso=1");
    exit;
}

$stmt->close();
header("Location: cadastrar_rota.php?erro=" . urlencode("Não foi possível cadastrar a rota. Confira os dados e tente novamente."));
exit;
