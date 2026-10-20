<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";

exigirAdministrador();

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    validarTokenCsrf();

    $localizacao = trim($_POST["localizacao"] ?? "");
    $tipo_de_dado = trim($_POST["tipo_de_dado"] ?? "");
    $horario = trim($_POST["horario"] ?? "");
    $status = trim($_POST["status"] ?? "");

    if ($localizacao === "" || $tipo_de_dado === "" || $horario === "" || $status === "") {
        $erro = "Preencha todos os campos.";
    } else {

        $sql = "INSERT INTO TRENS (localizacao, tipo_de_dado, horario, status)
                VALUES (?, ?, ?, ?)";

        $stmt = $conexao->prepare($sql);

        if ($stmt) {

            $stmt->bind_param(
                "ssss",
                $localizacao,
                $tipo_de_dado,
                $horario,
                $status
            );

            if ($stmt->execute()) {
                $sucesso = "Trem cadastrado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar o trem.";
            }

            $stmt->close();

        } else {
            $erro = "Erro ao preparar o cadastro.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Trem</title>

    <link rel="stylesheet" href="../assets/style/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="../assets/icons/TREM_AZUL.svg">

    <style>

        .formulario-trem {
            background: #0f172a;
            padding: 30px;
            border-radius: 15px;
            max-width: 700px;
        }

        .formulario-trem h3 {
            color: white;
            margin-bottom: 25px;
        }

        .campo {
            margin-bottom: 18px;
        }

        .campo label {
            color: white;
            display: block;
            margin-bottom: 6px;
        }

        .campo input,
        .campo select {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 7px;
        }

        .botoes {
            margin-top: 20px;
        }

    </style>

</head>

<body>

<header class="cabecalho">

    <h2>
        <img src="../assets/icons/TREM_AZUL.svg" alt="">
        Bem vindo, Administrador
    </h2>

    <a href="../logout.php">
        <img src="../assets/icons/exit.svg" class="item" alt="Sair">
    </a>

</header>

<div class="layout">

    <aside class="menu-lateral">

        <a href="tela_inicial.php" class="item ativo">
            <img src="../assets/icons/dashboard_preto.svg" alt="">
            Dashboard
        </a>

        <a href="gerenciar_sensores.php" class="item">
            <img src="../assets/icons/sensor_branco.svg" alt="">
            Sensores
        </a>

        <a href="rotas.php" class="item">
            <img src="../assets/icons/relatorio_branco.svg" alt="">
            Rotas
        </a>

        <a href="cadastro_admin.php" class="item">
            <img src="../assets/icons/cadastrar_branco.svg" alt="">
            Cadastrar ADMs e Usuários
        </a>

        <a href="usuarios_cadastrados.php" class="item">
            <img src="../assets/icons/usuarios_branco.svg" alt="">
            Usuários Cadastrados
        </a>

    </aside>

    <main class="conteudo">

    
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

        <div class="formulario-trem">

            <h3>
                <i class="bi bi-train-front"></i>
               Cadastrar Trem
            </h3>

            <form method="POST">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e(gerarTokenCsrf()) ?>"
                >

                <div class="campo">

                    <label for="localizacao">
                        Localização
                    </label>

                    <input
                        type="text"
                        id="localizacao"
                        name="localizacao"
                        placeholder="Ex.: Estação Central"
                        required
                    >

                </div>

                <div class="campo">

                    <label for="tipo_de_dado">
                        Tipo de Dado
                    </label>

                    <select
                        id="tipo_de_dado"
                        name="tipo_de_dado"
                        required
                    >

                        <option value="">
                            Selecione
                        </option>

                        <option value="Temperatura">
                            Temperatura
                        </option>

                        <option value="Velocidade">
                            Velocidade
                        </option>

                        <option value="Localização">
                            Localização
                        </option>

                    </select>

                </div>

                <div class="campo">

                    <label for="horario">
                        Horário
                    </label>

                    <input
                        type="time"
                        id="horario"
                        name="horario"
                        required
                    >

                </div>

                <div class="campo">

                    <label for="status">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option value="">
                            Selecione
                        </option>

                        <option value="Ativo">
                            Ativo
                        </option>

                        <option value="Inativo">
                            Inativo
                        </option>

                        <option value="Manutenção">
                            Manutenção
                        </option>

                    </select>

                </div>

                <div class="botoes">

                    <a
                        href="tela_inicial.php"
                        class="btn btn-secondary"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-check-circle"></i>
                        Salvar
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

</body>

</html>