<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";


exigirAdministrador();

$sql = "SELECT id, origem, destino, horario, status
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

        <img
            src="../assets/icons/TREM_AZUL.svg"
            alt="">

        Bem vindo, Administrador

    </h2>

    <a href="logout.php">
    <img src="../assets/icons/exit.svg" class="item" alt="Sair">
</a>

</header>


<div class="layout">


    <!-- MENU -->

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

            <img src="../assets/icons/relatorio_preto.svg" alt="">

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

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h1
                        class="titulo-sensor"
                        style="color: white;">

                        <i class="bi bi-signpost-2"></i>

                        Rotas

                    </h1>

                    <p style="color: white;">

                        Gerenciamento das rotas dos trens.

                    </p>

                </div>


                <a
                    href="cadastrar_rota.php"
                    class="btn btn-primary">

                    <i class="bi bi-plus-circle"></i>

                    Cadastrar Rota

                </a>

            </div>


            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle">

                    <thead>

  <tr>

    <th>ID</th>
    <th>Origem</th>
    <th>Destino</th>
    <th>Horário</th>
    <th>Status</th>
    <th>Ações</th>

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

    <?= htmlspecialchars($rota["origem"]) ?>

</td>

<td>

    <i class="bi bi-geo-alt-fill"></i>

    <?= htmlspecialchars($rota["destino"]) ?>

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


                                    <td>

                                        <a
                                            href="editar_rota.php?id=<?= $rota['id'] ?>"
                                            class="btn btn-sm btn-warning">

                                            <i class="bi bi-pencil"></i>

                                            Editar

                                        </a>


                                        <a
                                            href="excluir_rota.php?id=<?= $rota['id'] ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir esta rota?');">

                                            <i class="bi bi-trash"></i>

                                            Excluir

                                        </a>

                                    </td>

                                </tr>

                            <?php endwhile; ?>


                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="6"
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