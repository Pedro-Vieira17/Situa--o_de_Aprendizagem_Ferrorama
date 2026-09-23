<?php

require_once "../infra/conexao.php";

$mensagem = null;
$sucesso = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO USUARIO (nome, CPF, telefone, email, senha)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssss", $nome, $cpf, $telefone, $email, $senha);

    try {
        $stmt->execute();
        $sucesso = true;
        $mensagem = "Cadastro realizado com sucesso!";
    } catch (mysqli_sql_exception $e) {
        // Código 1062 = violação de UNIQUE (CPF ou e-mail já cadastrado)
        if ($conexao->errno === 1062) {
            if (str_contains($e->getMessage(), 'CPF')) {
                $mensagem = "Já existe um usuário cadastrado com esse CPF.";
            } elseif (str_contains($e->getMessage(), 'email')) {
                $mensagem = "Já existe um usuário cadastrado com esse e-mail.";
            } else {
                $mensagem = "Esse usuário já está cadastrado.";
            }
        } else {
            $mensagem = "Erro ao cadastrar. Tente novamente.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tela de Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="../assets/style/style.css">

    <link rel="icon" href="../assets/icons/TREM_AZUL.svg">

</head>

<body>

    <div class="container vh-100 d-flex align-items-center">

        <div class="p-3" style="max-width: 400px; width: 100%;">

            <div class="titulo">

                <h1>Cadastrar-se como Usuário</h1>

            </div>

            <?php if ($mensagem): ?>
                <div class="alert <?= $sucesso ? 'alert-success' : 'alert-danger' ?>">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-2">

                    <label>Nome Completo:</label>

                    <input
                        type="text"
                        name="nome"
                        class="form-control"
                        required>

                </div>

                <div class="mb-2">

                    <label>CPF:</label>

                    <input
                        type="text"
                        name="cpf"
                        class="form-control"
                        required>

                </div>

                <div class="mb-2">

                    <label>Telefone:</label>

                    <input
                        type="text"
                        name="telefone"
                        class="form-control"
                        required>

                </div>

                <div class="mb-2">

                    <label>E-mail:</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label>Senha:</label>

                    <input
                        type="password"
                        name="senha"
                        class="form-control"
                        required>

                </div>

                <div class="d-grid">

                    <button
                        class="btn btn-primary"
                        type="submit">

                        Cadastrar!

                    </button>

                </div>

                <div class="text-center mt-3">

                    <a href="../index.php">

                        Voltar para o login

                    </a>

                </div>

            </form>

        </div>

        <img
            src="../assets/img/trem-png novo.webp"
            alt="Trem"
            style="margin-left:auto">

    </div>

</body>

</html>