<?php

require_once "../infra/conexao.php";

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax'
]);

ini_set('session.use_strict_mode', '1');

session_start();

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $cpf = preg_replace('/\D/', '', $_POST["cpf"] ?? "");
    $telefone = preg_replace('/\D/', '', $_POST["telefone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";
    $confirmarSenha = $_POST["confirmar_senha"] ?? "";

    if (
        $nome === "" ||
        $cpf === "" ||
        $telefone === "" ||
        $email === "" ||
        $senha === "" ||
        $confirmarSenha === ""
    ) {

        $erro = "Preencha todos os campos.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $erro = "Digite um e-mail válido.";

    } elseif (strlen($cpf) !== 11) {

        $erro = "CPF inválido.";

    } elseif ($senha !== $confirmarSenha) {

        $erro = "As senhas não coincidem.";

    } elseif (strlen($senha) < 6) {

        $erro = "A senha deve ter pelo menos 6 caracteres.";

    } else {

        $stmt = $conexao->prepare(
            "SELECT id FROM USUARIO WHERE email = ? OR CPF = ? LIMIT 1"
        );

        if (!$stmt) {

            $erro = "Não foi possível realizar o cadastro.";

        } else {

            $stmt->bind_param("ss", $email, $cpf);
            $stmt->execute();

            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {

                $erro = "E-mail ou CPF já cadastrado.";

            } else {

                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                $stmtInsert = $conexao->prepare(
                    "INSERT INTO USUARIO 
                    (CPF, telefone, nome, email, senha, tipo)
                    VALUES (?, ?, ?, ?, ?, 'usuario')"
                );

                if (!$stmtInsert) {

                    $erro = "Não foi possível realizar o cadastro.";

                } else {

                    $stmtInsert->bind_param(
                        "sssss",
                        $cpf,
                        $telefone,
                        $nome,
                        $email,
                        $senhaHash
                    );

                    if ($stmtInsert->execute()) {

                        $sucesso = "Cadastro realizado com sucesso! Você já pode fazer login.";

                    } else {

                        $erro = "Erro ao cadastrar usuário.";
                    }

                    $stmtInsert->close();
                }
            }

            $stmt->close();
        }
    }
}

?>

<!doctype html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Criar conta</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="../assets/style/style.css">

    <link
        rel="icon"
        href="../assets/icons/TREM_AZUL.svg"
        type="image/x-icon">

</head>

<body>

    <div class="container vh-100 d-flex align-items-center">

        <div
            class="p-3"
            style="max-width: 400px; width: 100%;">

            <div class="titulo">

                <h1 class="text-nowrap">
                    🚄Sistema Ferroviário
                </h1>

                <p>
                    Criar nova conta
                </p>

            </div>

            <?php if ($erro !== ""): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>

                </div>

            <?php endif; ?>

            <?php if ($sucesso !== ""): ?>

                <div class="alert alert-success">

                    <?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?>

                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="formulario">

                    <div class="mb-3">

                        <label class="form-label">
                            Nome
                        </label>

                        <input
                            type="text"
                            name="nome"
                            class="form-control"
                            placeholder="Digite seu nome"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            CPF
                        </label>

                        <input
                            type="text"
                            name="cpf"
                            class="form-control"
                            placeholder="Digite seu CPF"
                            maxlength="11"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Telefone
                        </label>

                        <input
                            type="text"
                            name="telefone"
                            class="form-control"
                            placeholder="Digite seu telefone"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            E-mail
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Digite seu e-mail"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Senha
                        </label>

                        <input
                            type="password"
                            name="senha"
                            class="form-control"
                            placeholder="Digite sua senha"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Confirmar senha
                        </label>

                        <input
                            type="password"
                            name="confirmar_senha"
                            class="form-control"
                            placeholder="Digite a senha novamente"
                            required>

                    </div>

                </div>

                <div class="botao">

                    <div class="d-grid gap-2">

                        <button
                            class="btn btn-primary"
                            type="submit">

                            Cadastrar

                        </button>

                    </div>

                </div>

                <p class="mt-3">

                    <a href="../index.php">
                        Já tenho uma conta
                    </a>

                </p>

            </form>

        </div>

        <img
            src="../assets/img/trem-png novo.webp"
            alt="Trem"
            style="margin-left:auto">

    </div>

</body>

</html>