<?php

require_once "../infra/conexao.php";

$erro = $_GET["erro"] ?? null;
$sucesso = $_GET["sucesso"] ?? null;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Rota</title>

    <link
        rel="stylesheet"
        href="../assets/style/style.css">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<header class="cabecalho">

    <h2>

        <img
            src="../assets/icons/TREM_AZUL.svg"
            alt="">

        Bem vindo, Administrador

    </h2>

</header>


<div class="layout">

    <aside class="menu-lateral">

        <a href="tela_inicial.php" class="item">

            <img src="../assets/icons/dashboard_branco.svg">

            Dashboard

        </a>


        <a href="gerenciar_trens.php" class="item">

            <img src="../assets/icons/trem_branco.svg">

            Trens

        </a>


        <a href="gerenciar_sensores.php" class="item">

            <img src="../assets/icons/sensor_branco.svg">

            Sensores

        </a>


        <a href="rotas.php" class="item ativo">

            <img src="../assets/icons/relatorio_branco.svg">

            Rotas

        </a>

    </aside>


    <main class="conteudo">

        <div class="container-sensor">

            <h1
                class="titulo-sensor"
                style="color: white;">

                Cadastrar Nova Rota

            </h1>


            <?php if ($erro): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($erro) ?>

                </div>

            <?php endif; ?>


            <?php if ($sucesso): ?>

                <div class="alert alert-success">

                    Rota cadastrada com sucesso!

                </div>

            <?php endif; ?>


            <form
                class="form-sensor"
                method="POST"
                action="salvar_rota.php">


                <div class="linha-formulario">

                    <div class="grupo-input">

                        <label
                            for="localizacao"
                            style="color: white;">

                            Localização

                        </label>

                        <input
                            type="text"
                            id="localizacao"
                            name="localizacao"
                            placeholder="Ex: Joinville - SC"
                            required>

                    </div>


                    <div class="grupo-input">

                        <label
                            for="horario"
                            style="color: white;">

                            Horário

                        </label>

                        <input
                            type="time"
                            id="horario"
                            name="horario"
                            required>

                    </div>

                </div>


                <div class="linha-formulario">

                    <div class="grupo-input">

                        <label
                            for="status"
                            style="color: white;">

                            Status

                        </label>

                        <select
                            id="status"
                            name="status"
                            required>

                            <option
                                value=""
                                disabled
                                selected>

                                Selecione um status

                            </option>

                            <option value="Ativa">
                                Ativa
                            </option>

                            <option value="Inativa">
                                Inativa
                            </option>

                            <option value="Manutenção">
                                Manutenção
                            </option>

                        </select>

                    </div>

                </div>


                <div class="botoes-formulario">

                    <button
                        type="button"
                        class="botao_cancelar"
                        onclick="window.location.href='rotas.php'">

                        Cancelar

                    </button>


                    <button
                        type="submit"
                        class="btn-salvar">

                        Salvar

                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

</body>

</html>