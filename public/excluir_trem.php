<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";

exigirAdministrador();
validarTokenCsrf();

$id = filter_input(
    INPUT_POST,
    "id",
    FILTER_VALIDATE_INT
);

if ($id === false || $id === null || $id <= 0) {
    header("Location: tela_inicial.php");
    exit;
}

// Verifica se existem sensores vinculados.
$stmt = $conexao->prepare(
    "SELECT COUNT(*) AS total
     FROM SENSORES
     WHERE trens_id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$totalSensores = $stmt
    ->get_result()
    ->fetch_assoc()["total"];

if ((int) $totalSensores > 0) {
    header(
        "Location: tela_inicial.php?erro=" .
        urlencode("Não é possível excluir um trem que possui sensores vinculados.")
    );
    exit;
}

$stmt = $conexao->prepare(
    "DELETE FROM TRENS
     WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: tela_inicial.php");
exit;