<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";


exigirAdministrador();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

    header("Location: rotas.php");

    exit;
}

$id = intval($_GET["id"]);


$stmt = $conexao->prepare(
    "DELETE FROM ROTAS WHERE id = ?"
);


$stmt->bind_param("i", $id);


$stmt->execute();

$stmt->close();


header("Location: rotas.php");

exit;