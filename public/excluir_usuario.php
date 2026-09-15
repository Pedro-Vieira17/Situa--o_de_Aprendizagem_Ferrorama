<?php

require_once "../infra/conexao.php";

$id = $_GET["id"];

$sql = "DELETE FROM USUARIO WHERE id = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: usuarios_cadastrados.php");

exit;

?>