<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";


exigirAdministrador();

$id = intval($_POST["id"] ?? 0);

$localizacao = trim($_POST["localizacao"] ?? "");

$horario = trim($_POST["horario"] ?? "");

$status = trim($_POST["status"] ?? "");


if (
    $id <= 0 ||
    $localizacao === "" ||
    $horario === "" ||
    $status === ""
) {

    header(
        "Location: rotas.php"
    );

    exit;
}


$stmt = $conexao->prepare(
    "UPDATE ROTAS
     SET localizacao = ?,
         horario = ?,
         status = ?
     WHERE id = ?"
);


$stmt->bind_param(
    "sssi",
    $localizacao,
    $horario,
    $status,
    $id
);


if ($stmt->execute()) {

    $stmt->close();

    header("Location: rotas.php");

    exit;

} else {

    $stmt->close();

    header("Location: rotas.php");

    exit;
}