<?php

session_start();

require_once "../infra/conexao.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_tipo"] != "usuario") {
    header("Location: ../index.php");
    exit;
}

$sensores = $conexao->query("SELECT COUNT(*) AS total FROM SENSORES")->fetch_assoc()["total"];

$trens = $conexao->query("SELECT COUNT(*) AS total FROM TRENS")->fetch_assoc()["total"];

$alertas = $conexao->query("SELECT COUNT(*) AS total FROM TRENS WHERE status = 'Manutenção'")->fetch_assoc()["total"];

$sensores_ativos = $sensores;

if ($trens > 0) {

    $trens_cadastrados = $conexao->query("SELECT * FROM TRENS ORDER BY id DESC");

}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link rel="stylesheet" href="../assets/style/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="../assets/icons/TREM_AZUL.svg">

</head>

<body>

<header class="cabecalho">

    <h2>

        <img src="../assets/icons/TREM_AZUL.svg" alt="">

        Bem vindo, <?= htmlspecialchars($_SESSION["usuario_nome"]) ?>

    </h2>

    <a href="../index.php">

        <img src="../assets/icons/exit.svg" class="item" alt="Sair">

    </a>

</header>


<div class="layout">

    <aside class="menu-lateral">

        <a href="tela_inicial_usuario.php" class="item ativo">

            <img src="../assets/icons/dashboard_preto.svg" alt="">

            Dashboard

        </a>


        <a href="gerenciar_sensores_usuario.php" class="item">

            <img src="../assets/icons/sensor_branco.svg" alt="">

            Sensores

        </a>


        <a href="rotas_usuario.php" class="item">

            <img src="../assets/icons/relatorio_branco.svg" alt="">

            Rotas

        </a>

    </aside>


    <main class="conteudo">

        <div class="informacoes_dashboard">

            <div class="informacoes">

                <h4>

                    <img src="../assets/icons/ENGRENAGEM.svg" alt="">

                    Sensores Cadastrados

                </h4>

                <h3>

                    <?= $sensores ?>

                </h3>

            </div>


            <div class="informacoes">

                <h4>

                    <img src="../assets/icons/TREM_AZUL.svg" alt="">

                    Trens Cadastrados

                </h4>

                <h3>

                    <?= $trens ?>

                </h3>

            </div>


            <div class="informacoes">

                <h4>

                    <img src="../assets/icons/ALERTA.svg" alt="">

                    Alertas

                </h4>

                <h3>

                    <?= $alertas ?>

                </h3>

            </div>


            <div class="informacoes">

                <h4>

                    <img src="../assets/icons/OK_VERDE.svg" alt="">

                    Sensores Funcionando

                </h4>

                <h3>

                    <?= $sensores_ativos ?>

                </h3>

            </div>

        </div>


        <div class="planilha_dashboard">

            <div class="cabecalho_planilha">

                <h3 style="color: white;">Trens Cadastrados</h3>

            </div>


            <table class="table table-borderless">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>LOCALIZAÇÃO</th>

                        <th>TIPO DE DADO</th>

                        <th>STATUS</th>

                

                    </tr>

                </thead>


                <tbody>

                    <?php if ($trens > 0): ?>

                        <?php while ($trem = $trens_cadastrados->fetch_assoc()): ?>

                            <tr>

                                <th>

                                    #<?= str_pad($trem["id"], 3, "0", STR_PAD_LEFT) ?>

                                </th>


                                <td>

                                    <?= htmlspecialchars($trem["localizacao"]) ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars($trem["tipo_de_dado"]) ?>

                                </td>


                                <td>

                                    <?php if ($trem["status"] == "Manutenção"): ?>

                                        <span class="status-alerta">

                                            <?= htmlspecialchars($trem["status"]) ?>

                                        </span>

                                    <?php elseif ($trem["status"] == "Inativo"): ?>

                                        <span class="status-inativo">

                                            <?= htmlspecialchars($trem["status"]) ?>

                                        </span>

                                    <?php else: ?>

                                        <span class="status-ativo">

                                            <?= htmlspecialchars($trem["status"]) ?>

                                        </span>

                                    <?php endif; ?>

                                </td>


                                

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5" class="text-center">

                                Nenhum trem cadastrado.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </main>

</div>

</body>

</html>