<?php

session_start();

require_once "../infra/conexao.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php");
    exit;
}

$sql = "SELECT id, localizacao, horario, status
        FROM ROTAS
        ORDER BY horario ASC";

$rotas = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rotas</title>

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
        href="../assets/icons/TREM_AZUL.svg">

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


    <!-- MENU -->

    <aside class="menu-lateral">

        <a href="tela_inicial_usuario.php" class="item">

            <img src="../assets/icons/dashboard_branco.svg" alt="">

            Dashboard

        </a>


        <a href="gerenciar_sensores_usuario.php" class="item">

            <img src="../assets/icons/sensor_branco.svg" alt="">

            Sensores

        </a>


        <a href="rotas_usuario.php" class="item ativo">

            <img src="../assets/icons/relatorio_preto.svg" alt="">

            Rotas

        </a>

    </aside>


    <!-- CONTEÚDO -->

    <main class="conteudo">

        <div class="container-sensor">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h1
                        class="titulo-sensor"
                        style="color: white;">

                        <i class="bi bi-signpost-2"></i>

                        Rotas

                    </h1>


                </div>


            

            </div>


            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Localização</th>

                            <th>Horário</th>

                            <th>Status</th>


                        </tr>

                    </thead>


                    <tbody>

                        <?php if ($rotas && $rotas->num_rows > 0): ?>

                            <?php while ($rota = $rotas->fetch_assoc()): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($rota["id"]) ?>
                                    </td>


                                    <td>

                                        <i class="bi bi-geo-alt-fill"></i>

                                        <?= htmlspecialchars($rota["localizacao"]) ?>

                                    </td>


                                    <td>

                                        <i class="bi bi-clock"></i>

                                        <?= date(
                                            "H:i",
                                            strtotime($rota["horario"])
                                        ) ?>

                                    </td>


                                    <td>

                                        <?php if ($rota["status"] == "Ativa"): ?>

                                            <span class="badge bg-success">
                                                Ativa
                                            </span>

                                        <?php elseif ($rota["status"] == "Manutenção"): ?>

                                            <span class="badge bg-warning text-dark">
                                                Manutenção
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-secondary">
                                                <?= htmlspecialchars($rota["status"]) ?>
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                  

                                </tr>

                            <?php endwhile; ?>


                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center">

                                    Nenhuma rota cadastrada.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>

</html>