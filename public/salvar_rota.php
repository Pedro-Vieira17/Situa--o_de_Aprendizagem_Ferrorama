<?php

require_once "../infra/conexao.php";

$localizacao = trim($_POST["localizacao"] ?? "");
$horario = trim($_POST["horario"] ?? "");
$status = trim($_POST["status"] ?? "");


if (
    $localizacao === "" ||
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
    "INSERT INTO ROTAS (localizacao, horario, status)
     VALUES (?, ?, ?)"
);


if (!$stmt) {

    header(
        "Location: cadastrar_rota.php?erro=" .
        urlencode("Erro ao preparar o cadastro.")
    );

    exit;
}


$stmt->bind_param(
    "sss",
    $localizacao,
    $horario,
    $status
);


if ($stmt->execute()) {

    $stmt->close();

    header(
        "Location: rotas.php"
    );

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