<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";

exigirAdministrador();

$id = filter_input(
    INPUT_GET,
    "id",
    FILTER_VALIDATE_INT
);

if ($id === false || $id === null || $id <= 0) {
    header("Location: usuarios_cadastrados.php");
    exit;
}

$stmt = $conexao->prepare(
    "SELECT id, nome, CPF, telefone, email
     FROM USUARIO
     WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    header("Location: usuarios_cadastrados.php");
    exit;
}

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    validarTokenCsrf();

    $nome = trim($_POST["nome"] ?? "");
    $cpf = preg_replace('/\D/', '', $_POST["cpf"] ?? "");
    $telefone = preg_replace('/\D/', '', $_POST["telefone"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if (
        $nome === "" ||
        $cpf === "" ||
        $telefone === "" ||
        $email === ""
    ) {

        $erro = "Preencha todos os campos.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $erro = "Informe um e-mail válido.";

    } elseif (strlen($cpf) !== 11) {

        $erro = "CPF inválido.";

    } else {

        $stmt = $conexao->prepare(
            "SELECT id
             FROM USUARIO
             WHERE (email = ? OR CPF = ?)
             AND id <> ?
             LIMIT 1"
        );

        $stmt->bind_param(
            "ssi",
            $email,
            $cpf,
            $id
        );

        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {

            $erro = "E-mail ou CPF já está cadastrado.";

        } else {

            $stmt = $conexao->prepare(
                "UPDATE USUARIO
                 SET nome = ?, CPF = ?, telefone = ?, email = ?
                 WHERE id = ?"
            );

            $stmt->bind_param(
                "ssssi",
                $nome,
                $cpf,
                $telefone,
                $email,
                $id
            );

            if ($stmt->execute()) {

                $sucesso = "Usuário atualizado com sucesso.";

                $usuario["nome"] = $nome;
                $usuario["CPF"] = $cpf;
                $usuario["telefone"] = $telefone;
                $usuario["email"] = $email;

            } else {

                $erro = "Não foi possível atualizar o usuário.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Usuário</title>

    <link rel="stylesheet" href="../assets/style/style.css">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >

    <link
        rel="icon"
        href="../assets/icons/TREM_AZUL.svg"
        type="image/x-icon"
    >

</head>

<body>

    <div class="container vh-100 d-flex align-items-center justify-content-center">

        <div
            class="p-4"
            style="max-width: 400px; width: 100%;"
        >

            <div class="titulo mb-4" style="color: white;">

                <h1>Editar Usuário</h1>

            </div>

            <?php if ($erro !== ""): ?>

                <div class="alert alert-danger">

                    <?= e($erro) ?>

                </div>

            <?php endif; ?>

            <?php if ($sucesso !== ""): ?>

                <div class="alert alert-success">

                    <?= e($sucesso) ?>

                </div>

            <?php endif; ?>

            <form method="POST">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e(gerarTokenCsrf()) ?>"
                >

                <label for="nome" class="form-label" style="color: white;">
                    Nome completo
                </label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    class="form-control mb-3"
                    value="<?= e($usuario["nome"]) ?>"
                    maxlength="200"
                    required
                >

                <label for="cpf" class="form-label" style="color: white;">
                    CPF
                </label>

                <input
                    type="text"
                    id="cpf"
                    name="cpf"
                    class="form-control mb-3"
                    value="<?= e($usuario["CPF"]) ?>"
                    maxlength="11"
                    inputmode="numeric"
                    required
                >

                <label for="telefone" class="form-label" style="color: white;">
                    Telefone
                </label>

                <input
                    type="text"
                    id="telefone"
                    name="telefone"
                    class="form-control mb-3"
                    value="<?= e($usuario["telefone"]) ?>"
                    maxlength="15"
                    inputmode="numeric"
                    required
                >

                <label for="email" class="form-label" style="color: white;">
                    E-mail
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control mb-3"
                    value="<?= e($usuario["email"]) ?>"
                    maxlength="200"
                    required
                >

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Salvar as alterações
                    </button>

                    <a
                        href="usuarios_cadastrados.php"
                        class="btn btn-secondary"
                    >
                        Voltar
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>