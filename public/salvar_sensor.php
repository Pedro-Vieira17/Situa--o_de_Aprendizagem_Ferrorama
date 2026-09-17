<?php

require_once "../infra/conexao.php";

$localizacao = $_POST["localizacao"] ?? "";
$tipoDado = $_POST["tipoDado"] ?? "";
$tremVinculado = $_POST["tremVinculado"] ?? "";


if ($localizacao == "" || $tipoDado == "" || $tremVinculado == "") {

    header("Location: cadastrar_sensores.php?erro=Preencha todos os campos.");

    exit;
}


$sql = "INSERT INTO SENSORES 
        (localizacao, tipo_de_dado, trens_id)
        VALUES (?, ?, ?)";


$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ssi",
    $localizacao,
    $tipoDado,
    $tremVinculado
);


if ($stmt->execute()) {

    header("Location: cadastrar_sensores.php?sucesso=1");

} else {

    header("Location: cadastrar_sensores.php?erro=Erro ao cadastrar o sensor.");

}

exit;

?>