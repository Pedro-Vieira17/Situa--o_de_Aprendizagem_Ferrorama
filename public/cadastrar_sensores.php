<?php

require_once "../infra/conexao.php";

// Busca os trens cadastrados
$sql = "SELECT id, localizacao FROM TRENS ORDER BY id";

$resultadoTrens = $conexao->query($sql);

// Mensagens vindas do salvar_sensor.php
$erro = $_GET['erro'] ?? null;
$sucesso = $_GET['sucesso'] ?? null;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Sensores</title>

    <link rel="stylesheet" href="../assets/style/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon"
        href="../assets/icons/TREM_AZUL.svg"
        type="image/x-icon">

</head>


<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous">
    </script>


    <!-- CABEÇALHO -->

    <header class="cabecalho">

        <h2>

            <img src="../assets/icons/TREM_AZUL.svg" alt="">

            Bem vindo, Administrador

        </h2>


        <a href="login.html">

            <img src="../assets/icons/exit.svg"
                class="item"
                alt="">

        </a>

    </header>


    <div class="layout">


        <!-- MENU LATERAL -->

        <aside class="menu-lateral">

        <a href="tela_inicial.php" class="item">

            <img
                src="../assets/icons/dashboard_branco.svg"
                alt="">

            Dashboard

        </a>


        <a href="gerenciar_sensores.php" class="item ativo">

            <img
                src="../assets/icons/sensor_preto.svg"
                alt="">

            Sensores

        </a>


        <a href="rotas.php" class="item">

            <img
                src="../assets/icons/rotas_branco.svg"
                alt="">

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


        <!-- CONTEÚDO -->

        <main class="conteudo">


            <div class="container-sensor">


                <h1 class="titulo-sensor">

                    Cadastrar Novo Sensor

                </h1>


                <!-- MENSAGEM DE ERRO -->

                <?php if ($erro): ?>

                    <div class="alert alert-danger">

                        <?= htmlspecialchars($erro) ?>

                    </div>

                <?php endif; ?>


                <!-- MENSAGEM DE SUCESSO -->

                <?php if ($sucesso): ?>

                    <div class="alert alert-success">

                        Sensor cadastrado com sucesso!

                    </div>

                <?php endif; ?>


                <!-- FORMULÁRIO -->

                <form
                    class="form-sensor"
                    method="POST"
                    action="salvar_sensor.php">


                    <!-- PRIMEIRA LINHA -->

                    <div class="linha-formulario">


                        <div class="grupo-input">

                            <label for="localizacao">

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

                            <label for="tipoDado">

                                Tipo de Dado

                            </label>


                            <select
                                id="tipoDado"
                                name="tipoDado"
                                required>


                                <option value="" disabled selected>

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


                    <!-- SEGUNDA LINHA -->

                    <div class="linha-formulario">


                        <div class="grupo-input">


                            <label for="tremVinculado">

                                Trem Vinculado

                            </label>


                            <select
                                id="tremVinculado"
                                name="tremVinculado"
                                required>


                                <option value="" disabled selected>

                                    Selecione um trem

                                </option>


                                <?php while ($trem = $resultadoTrens->fetch_assoc()): ?>


                                    <option value="<?= $trem['id'] ?>">

                                        Trem <?= str_pad($trem['id'], 2, "0", STR_PAD_LEFT) ?>

                                        -

                                        <?= htmlspecialchars($trem['localizacao']) ?>

                                    </option>


                                <?php endwhile; ?>


                            </select>


                        </div>


                    </div>


                    <!-- BOTÕES -->

                    <div class="botoes-formulario">


                        <button
                            type="button"
                            class="botao_cancelar"
                            onclick="window.location.href='gerenciar_sensores.php'">

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