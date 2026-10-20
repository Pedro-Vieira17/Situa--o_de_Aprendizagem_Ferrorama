```php
<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";


exigirAdministrador();


// Recebe os dados do formulário

$localizacao = trim($_POST['localizacao'] ?? '');

$tipoDado = trim($_POST['tipoDado'] ?? '');

$horario = trim($_POST['horario'] ?? '');

$status = trim($_POST['status'] ?? '');


// Validação dos campos

if (
    $localizacao === '' ||
    $tipoDado === '' ||
    $horario === '' ||
    $status === ''
) {

    header(
        'Location: cadastrar_trens.php?erro=' .
        urlencode('Preencha todos os campos obrigatórios.')
    );

    exit;
}


// Prepara o INSERT

$stmt = $conexao->prepare(
    'INSERT INTO TRENS
    (localizacao, tipo_de_dado, horario, status)
    VALUES (?, ?, ?, ?)'
);


// Verifica se a consulta foi preparada

if (!$stmt) {

    header(
        'Location: cadastrar_trens.php?erro=' .
        urlencode(
            'Erro ao preparar a consulta: ' .
            $conexao->error
        )
    );

    exit;
}


// Passa os valores para o SQL

$stmt->bind_param(
    'ssss',
    $localizacao,
    $tipoDado,
    $horario,
    $status
);


// Executa o cadastro

if ($stmt->execute()) {

    $stmt->close();

    header(
        'Location: cadastrar_trens.php?sucesso=1'
    );

    exit;

} else {

    $erro = $stmt->error;

    $stmt->close();

    header(
        'Location: cadastrar_trens.php?erro=' .
        urlencode(
            'Erro ao cadastrar trem: ' . $erro
        )
    );

    exit;
}

?>
```
