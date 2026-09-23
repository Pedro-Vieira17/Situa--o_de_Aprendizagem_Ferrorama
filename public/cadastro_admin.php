<?php

session_start();

require_once "../infra/conexao.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_tipo"] != "administrador") {
    header("Location: ../index.php");
    exit;
}

$mensagem = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $cpf = trim($_POST["cpf"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";
    $tipo = $_POST["tipo"] ?? "";

    if ($nome == "" || $cpf == "" || $telefone == "" || $email == "" || $senha == "" || $tipo == "") {

        $erro = "Preencha todos os campos.";

    } elseif ($tipo != "usuario" && $tipo != "administrador") {

        $erro = "Tipo de acesso inválido.";

    } else {

        $verificar = $conexao->prepare(
            "SELECT id FROM USUARIO WHERE email = ?"
        );

        $verificar->bind_param("s", $email);
        $verificar->execute();

        $resultado = $verificar->get_result();

        if ($resultado->num_rows > 0) {

            $erro = "Já existe um usuário cadastrado com esse e-mail.";

        } else {

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO USUARIO 
                    (nome, CPF, telefone, email, senha, tipo)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conexao->prepare($sql);

            $stmt->bind_param(
                "ssssss",
                $nome,
                $cpf,
                $telefone,
                $email,
                $senhaHash,
                $tipo
            );

            if ($stmt->execute()) {

                $mensagem = "Cadastro realizado com sucesso!";

                $_POST = [];

            } else {

                $erro = "Erro ao cadastrar usuário.";

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

    <title>Cadastrar ADMs e Usuários</title>

    <link rel="stylesheet" href="../assets/style/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon"
        href="../assets/icons/TREM_AZUL.svg">

</head>

<body>

<header class="cabecalho">

    <h2>

        <img src="../assets/icons/TREM_AZUL.svg" alt="">

        Bem vindo, <?= htmlspecialchars($_SESSION["usuario_nome"]) ?>

    </h2>

    <a href="../index.php">

        <img
            src="../assets/icons/exit.svg"
            class="item"
            alt="Sair">

    </a>

</header>


<div class="layout">

    <aside class="menu-lateral">

        <a href="tela_inicial.php" class="item">

            <img
                src="../assets/icons/dashboard_branco.svg"
                alt="">

            Dashboard

        </a>


        <a href="gerenciar_sensores.php" class="item">

            <img
                src="../assets/icons/sensor_branco.svg"
                alt="">

            Sensores

        </a>


        <a href="rotas.php" class="item">

            <img
                src="../assets/icons/rotas_branco.svg"
                alt="">

            Rotas

        </a>


        <a href="cadastro_admin.php" class="item ativo">

            <img
                src="../assets/icons/cadastrar_preto.svg"
                alt="">

            Cadastrar ADMs e Usuários

        </a>


        <a href="usuarios_cadastrados.php" class="item">

            <img
                src="../assets/icons/usuarios_branco.svg"
                alt="">

            Usuários Cadastrados

        </a>

    </aside>


    <main class="conteudo">

        <div class="planilha_dashboard"
            style="max-width: 800px; margin: 0 auto; padding: 30px;">

            <h2 style="margin-bottom: 25px; color: white;">

                Cadastrar ADMs e Usuários

            </h2>


            <?php if ($mensagem != ""): ?>

                <div class="alert alert-success">

                    <?= htmlspecialchars($mensagem) ?>

                </div>

            <?php endif; ?>


            <?php if ($erro != ""): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($erro) ?>

                </div>

            <?php endif; ?>


            <form method="POST">


                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label" style="color: white;">

                            Nome completo

                        </label>

                        <input
                            type="text"
                            name="nome"
                            class="form-control"
                            placeholder="Digite o nome completo"
                            value="<?= htmlspecialchars($_POST["nome"] ?? "") ?>"
                            required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label" style="color: white;">

                            CPF

                        </label>

                        <input
                            type="text"
                            name="cpf"
                            class="form-control"
                            placeholder="Digite o CPF"
                            value="<?= htmlspecialchars($_POST["cpf"] ?? "") ?>"
                            required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label" style="color: white;">

                            Telefone

                        </label>

                        <input
                            type="text"
                            name="telefone"
                            class="form-control"
                            placeholder="Digite o telefone"
                            value="<?= htmlspecialchars($_POST["telefone"] ?? "") ?>"
                            required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label" style="color: white;">

                            E-mail

                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Digite o e-mail"
                            value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
                            required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label" style="color: white;">

                            Senha

                        </label>

                        <input
                            type="password"
                            name="senha"
                            class="form-control"
                            placeholder="Digite a senha"
                            required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label" style="color: white;">

                            Tipo de acesso

                        </label>

                        <select
                            name="tipo"
                            class="form-select"
                            required>

                            <option value="">
                                Selecione o tipo
                            </option>

                            <option
                                value="usuario"
                                <?= ($_POST["tipo"] ?? "") == "usuario" ? "selected" : "" ?>>

                                Usuário

                            </option>

                            <option
                                value="administrador"
                                <?= ($_POST["tipo"] ?? "") == "administrador" ? "selected" : "" ?>>

                                Administrador

                            </option>

                        </select>

                    </div>

                </div>


                <div class="d-flex gap-2 mt-3">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Cadastrar

                    </button>

                    <a
                        href="usuarios_cadastrados.php"
                        class="btn btn-secondary">

                        Ver usuários cadastrados

                    </a>

                </div>


            </form>

        </div>

    </main>

</div>

</body>

</html>