<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";

exigirAdministrador();

$origem = trim($_POST["origem"] ?? "");
$destino = trim($_POST["destino"] ?? "");
$horario = trim($_POST["horario"] ?? "");
$status = trim($_POST["status"] ?? "");

if (
    $origem === "" ||
    $destino === "" ||
    $horario === "" ||
    $status === ""
) {

    header(
        "Location: cadastrar_rota.php?erro=" .
        urlencode("Preencha todos os campos.")
    );

    exit;
}

$stmt = $conexao->prepare(
    "INSERT INTO ROTAS (origem, destino, horario, status)
     VALUES (?, ?, ?, ?)"
);

if (!$stmt) {

    header(
        "Location: cadastrar_rota.php?erro=" .
        urlencode("Erro ao preparar o cadastro.")
    );

    exit;
}

$stmt->bind_param(
    "ssss",
    $origem,
    $destino,
    $horario,
    $status
);

if ($stmt->execute()) {

    $stmt->close();

    header("Location: rotas.php");

    exit;

} else {

    $erro = $stmt->error;

    $stmt->close();

    header(
        "Location: cadastrar_rota.php?erro=" .
        urlencode("Erro ao cadastrar rota: " . $erro)
    );

    exit;
}