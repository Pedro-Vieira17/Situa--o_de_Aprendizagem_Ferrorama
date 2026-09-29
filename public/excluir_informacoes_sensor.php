<?php
 
require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";


exigirAdministrador();
 
 
// Verifica se o ID foi informado
$id = $_GET["id"] ?? null;
 
if (!$id || !ctype_digit((string)$id)) {
    header("Location: gerenciar_sensores.php");
    exit;
}
 
$id = (int)$id;
 
 
// Exclui o sensor
$stmt = $conexao->prepare("DELETE FROM SENSORES WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
 
 
// Volta para a lista de sensores
header("Location: gerenciar_sensores.php");
exit;
 