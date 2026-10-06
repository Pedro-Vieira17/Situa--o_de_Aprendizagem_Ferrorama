<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";

exigirAdministrador();

$id = intval($_POST["id"] ?? 0);

$origem = trim($_POST["origem"] ?? "");

$destino = trim($_POST["destino"] ?? "");

$horario = trim($_POST["horario"] ?? "");

$status = trim($_POST["status"] ?? "");


if (
    $id <= 0 ||
    $origem === "" ||
    $destino === "" ||
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
     SET origem = ?,
         destino = ?,
         horario = ?,
         status = ?
     WHERE id = ?"
);


$stmt->bind_param(
    "ssssi",
    $origem,
    $destino,
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