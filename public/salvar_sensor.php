<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";

exigirAdministrador();
validarTokenCsrf();

$localizacao = trim($_POST["localizacao"] ?? "");
$tipoDado = trim($_POST["tipoDado"] ?? "");
$tremVinculado = filter_input(
    INPUT_POST,
    "tremVinculado",
    FILTER_VALIDATE_INT
);

if (
    $localizacao === "" ||
    $tipoDado === "" ||
    $tremVinculado === false ||
    $tremVinculado === null ||
    $tremVinculado <= 0
) {
    header(
        "Location: cadastrar_sensores.php?erro=" .
        urlencode("Informe dados válidos.")
    );
    exit;
}

// Verifica se o trem realmente existe.
$stmt = $conexao->prepare(
    "SELECT id FROM TRENS WHERE id = ?"
);

$stmt->bind_param("i", $tremVinculado);
$stmt->execute();

if ($stmt->get_result()->num_rows === 0) {
    header(
        "Location: cadastrar_sensores.php?erro=" .
        urlencode("Trem não encontrado.")
    );
    exit;
}

$stmt = $conexao->prepare(
    "INSERT INTO SENSORES
     (localizacao, tipo_de_dado, trens_id)
     VALUES (?, ?, ?)"
);

$stmt->bind_param(
    "ssi",
    $localizacao,
    $tipoDado,
    $tremVinculado
);

if ($stmt->execute()) {

    header(
        "Location: cadastrar_sensores.php?sucesso=1"
    );

} else {

    header(
        "Location: cadastrar_sensores.php?erro=" .
        urlencode("Não foi possível cadastrar o sensor.")
    );
}

exit;