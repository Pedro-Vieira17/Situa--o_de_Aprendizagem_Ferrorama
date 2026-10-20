<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";

exigirAdministrador();

$erro = $_GET["erro"] ?? null;
$sucesso = $_GET["sucesso"] ?? null;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Rota</title>

    <link rel="stylesheet" href="../assets/style/style.css">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link
        rel="icon"
        href="../assets/icons/TREM_AZUL.svg">

    <style>

        .area-cadastro {
            width: 100%;
        }

        .formulario-rota {
            width: 100%;
            max-width: 850px;
            background: #0f172a;
            padding: 35px;
            border-radius: 16px;
        }

        .formulario-rota h3 {
            color: white;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .linha-formulario {
            display: flex;
            gap: 20px;
        }

        .grupo-input {
            width: 100%;
            margin-bottom: 20px;
        }

        .grupo-input label {
            display: block;
            color: white;
            margin-bottom: 7px;
        }

        .grupo-input input,
        .grupo-input select {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 7px;
            padding: 0 12px;
        }

        .botoes-formulario {
            margin-top: 10px;
        }

        .botao_cancelar {
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            background: #6c757d;
            color: white;
        }

        .btn-salvar {
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            background: #0d6efd;
            color: white;
        }

        @media (max-width: 700px) {

            .linha-formulario {
                display: block;
            }

            .formulario-rota {
                padding: 25px;
            }

        }

    </style>

</head>

<body>

<header class="cabecalho">

    <h2>

        <img
            src="../assets/icons/TREM_AZUL.svg"
            alt="">

        Bem vindo, Administrador

    </h2>

    <a href="../logout.php">

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


        <a href="rotas.php" class="item ativo">

            <img
                src="../assets/icons/relatorio_preto.svg"
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


    <main class="conteudo">

       


        <?php if ($erro): ?>

            <div class="alert alert-danger">

                <?= e($erro) ?>

            </div>

        <?php endif; ?>


        <?php if ($sucesso): ?>

            <div class="alert alert-success">

                Rota cadastrada com sucesso!

            </div>

        <?php endif; ?>


        <div class="area-cadastro">

            <div class="formulario-rota">

                <h3>

                    <i class="bi bi-signpost-2"></i>

                   Cadastrar Nova Rota

                </h3>


                <form
                    method="POST"
                    action="salvar_rota.php">

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= e(gerarTokenCsrf()) ?>">


                    <div class="linha-formulario">

                        <div class="grupo-input">

                            <label for="origem">
                                Origem
                            </label>

                            <input
                                type="text"
                                id="origem"
                                name="origem"
                                placeholder="Ex: Joinville - SC"
                                required>

                        </div>


                        <div class="grupo-input">

                            <label for="destino">
                                Destino
                            </label>

                            <input
                                type="text"
                                id="destino"
                                name="destino"
                                placeholder="Ex: Jaraguá do Sul - SC"
                                required>

                        </div>

                    </div>


                    <div class="linha-formulario">

                        <div class="grupo-input">

                            <label for="horario">
                                Horário
                            </label>

                            <input
                                type="time"
                                id="horario"
                                name="horario"
                                required>

                        </div>


                        <div class="grupo-input">

                            <label for="status">
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                required>

                                <option value="" disabled selected>
                                    Selecione
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

                            <i class="bi bi-check-circle"></i>

                            Salvar

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </main>

</div>

</body>

</html>