<?php

require_once "../infra/seguranca.php";
require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";


exigirAdministrador();

$id = $_GET["id"];

$sql = "DELETE FROM USUARIO WHERE id = ?";

$stmt = $conexao->prepare(
    "DELETE FROM USUARIO WHERE id = ?"
);

$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    http_response_code(500);
    exit("Não foi possível excluir o usuário.");
}

header("Location: usuarios_cadastrados.php");
exit;
