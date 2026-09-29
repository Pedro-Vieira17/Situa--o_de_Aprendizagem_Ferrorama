<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";


exigirAdministrador();

// Mensagens vindas de salvar_trem.php
$erro = $_GET['erro'] ?? null;
$sucesso = $_GET['sucesso'] ?? null;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Trens</title>

    <link
        rel="stylesheet"
        href="../assets/style/style.css">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link
        rel="icon"
        href="../assets/icons/TREM_AZUL.svg"
        type="image/x-icon">

</head>

<body>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>


<header class="cabecalho">

    <h2>

        <img
            src="../assets/icons/TREM_AZUL.svg"
            alt="">

        Bem vindo, Administrador

    </h2>

    <a href="login.html">

        <img
            src="../assets/icons/exit.svg"
            class="item"
            alt="">

    </a>

</header>


<div class="layout">

    <aside class="menu-lateral">

        <a href="tela_inicial.php" class="item ativo">

            <img
                src="../assets/icons/dashboard_preto.svg"
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

            <img src="../assets/icons/relatorio_branco.svg" alt="">

            Rotas

        </a>


        <a href="cadastro_admin.php" class="item">

            <img
                src="../assets/icons/cadastrar_branco.svg"
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

        <div class="container-sensor">

            <h1
                class="titulo-sensor"
                style="color: white;">

                Cadastrar Novo Trem

            </h1>


            <?php if ($erro): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($erro) ?>

                </div>

            <?php endif; ?>


            <?php if ($sucesso): ?>

                <div class="alert alert-success">

                    Trem cadastrado com sucesso!

                </div>

            <?php endif; ?>


            <form
                class="form-sensor"
                method="POST"
                action="salvar_trem.php">


                <!-- LOCALIZAÇÃO + TIPO DE DADO -->

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
                            required
                            placeholder="Ex: Estação central - Eixo B">

                    </div>


                    <div class="grupo-input">

                        <label
                            for="tipoDado"
                            style="color: white;">

                            Tipo de Dado

                        </label>

                        <select
                            id="tipoDado"
                            name="tipoDado"
                            required>

                            <option
                                value=""
                                disabled
                                selected>

                                Selecione o tipo de dado

                            </option>

                            <option value="Velocidade">
                                Velocidade
                            </option>

                            <option value="Temperatura">
                                Temperatura
                            </option>

                            <option value="Pressão">
                                Pressão
                            </option>

                        </select>

                    </div>

                </div>


                <!-- HORÁRIO + STATUS -->

                <div class="linha-formulario">

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

                </div>


                <!-- BOTÕES -->

                <div class="botoes-formulario">

                    <button
                        type="button"
                        class="botao_cancelar"
                        onclick="window.location.href='tela_inicial.php'">

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
```
