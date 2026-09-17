```php
<?php

require_once "../infra/conexao.php";


// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: gerenciar_sensores.php");

    exit;
}


// Recebe os dados do formulário
$id = intval($_POST["id"] ?? 0);

$localizacao = trim($_POST["localizacao"] ?? "");

$tipoDado = trim($_POST["tipoDado"] ?? "");

$tremVinculado = intval($_POST["tremVinculado"] ?? 0);


// Verifica se os campos estão preenchidos
if (
    $id <= 0 ||
    $localizacao === "" ||
    $tipoDado === "" ||
    $tremVinculado <= 0
) {

    header(
        "Location: editar_sensor.php?id=" .
        $id .
        "&erro=Preencha todos os campos."
    );

    exit;
}


// Atualiza o sensor
$sql = "UPDATE SENSORES
        SET
            localizacao = ?,
            tipo_de_dado = ?,
            trens_id = ?
        WHERE id = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ssii",
    $localizacao,
    $tipoDado,
    $tremVinculado,
    $id
);


// Executa a atualização
if ($stmt->execute()) {

    header(
        "Location: gerenciar_sensores.php?sucesso=Sensor atualizado com sucesso!"
    );

    exit;

} else {

    header(
        "Location: editar_sensor.php?id=" .
        $id .
        "&erro=Erro ao atualizar o sensor."
    );

    exit;
}
```
