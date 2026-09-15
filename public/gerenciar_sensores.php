<?php

require_once "../infra/conexao.php";

// Pesquisa
$pesquisa = isset($_GET["pesquisa"]) ? $_GET["pesquisa"] : "";

// Consulta dos sensores
if ($pesquisa != "") {

    $sql = "SELECT
                SENSORES.id,
                SENSORES.localizacao,
                SENSORES.tipo_de_dado,
                SENSORES.trens_id,
                TRENS.status
            FROM SENSORES
            INNER JOIN TRENS
                ON SENSORES.trens_id = TRENS.id
            WHERE SENSORES.tipo_de_dado LIKE ?
               OR SENSORES.localizacao LIKE ?
            ORDER BY SENSORES.id DESC";

    $stmt = $conexao->prepare($sql);

    $busca = "%" . $pesquisa . "%";

    $stmt->bind_param("ss", $busca, $busca);

    $stmt->execute();

    $resultado = $stmt->get_result();

} else {

    $sql = "SELECT
                SENSORES.id,
                SENSORES.localizacao,
                SENSORES.tipo_de_dado,
                SENSORES.trens_id,
                TRENS.status
            FROM SENSORES
            INNER JOIN TRENS
                ON SENSORES.trens_id = TRENS.id
            ORDER BY SENSORES.id DESC";

    $resultado = $conexao->query($sql);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gerenciar Sensores</title>

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

                <img src="../assets/icons/dashboard_branco.svg" alt="">

                Dashboard

            </a>


            <a href="gerenciar_sensores.php" class="item ativo">

                <img src="../assets/icons/sensor_preto.svg" alt="">

                Sensores

            </a>


            <a href="rotas.php" class="item">

                <img src="../assets/icons/rotas_branco.svg" alt="">

                Rotas

            </a>


            <a href="tela_de_cadastro.php" class="item">

                <img src="../assets/icons/cadastrar_branco.svg" alt="">

                Cadastrar Usuários

            </a>


            <a href="usuarios_cadastrados.php" class="item">

                <img src="../assets/icons/usuarios_branco.svg" alt="">

                Usuários Cadastrados

            </a>

        </aside>


        <!-- CONTEÚDO -->

        <main class="conteudo">


            <div class="titulo_sensores">


                <h2 class="titulo_do_sensores">
                    Gerenciar Sensores
                </h2>


                <!-- PESQUISA -->

                <form action="gerenciar_sensores.php"
                    method="GET"
                    class="pesquisa_sensor">

                    <input
                        type="search"
                        name="pesquisa"
                        class="campo-com-icone"
                        placeholder="Pesquisar sensor..."
                        value="<?= htmlspecialchars($pesquisa) ?>">

                </form>


                <!-- CADASTRAR -->

                <button
                    class="botao_cancelar"
                    onclick="window.location.href='cadastrar_sensores.php'">

                    Cadastrar

                </button>


            </div>


            <!-- TABELA -->

            <div class="planilha_dashboard">

                <table class="table table-borderless">


                    <thead>

                        <tr>

                            <th scope="col">
                                ID
                            </th>

                            <th scope="col">
                                NOME
                            </th>

                            <th scope="col">
                                LOCALIZAÇÃO
                            </th>

                            <th scope="col">
                                TREM
                            </th>

                            <th scope="col">
                                STATUS
                            </th>

                            <th scope="col">
                                AÇÕES
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php if ($resultado->num_rows > 0) { ?>


                            <?php while ($sensor = $resultado->fetch_assoc()) { ?>


                                <tr>


                                    <!-- ID -->

                                    <th scope="row">

                                        #<?= str_pad($sensor["id"], 3, "0", STR_PAD_LEFT) ?>

                                    </th>


                                    <!-- NOME -->

                                    <td>

                                        <?= htmlspecialchars($sensor["tipo_de_dado"]) ?>

                                    </td>


                                    <!-- LOCALIZAÇÃO -->

                                    <td>

                                        <?= htmlspecialchars($sensor["localizacao"]) ?>

                                    </td>


                                    <!-- TREM -->

                                    <td>

                                        Trem <?= str_pad($sensor["trens_id"], 2, "0", STR_PAD_LEFT) ?>

                                    </td>


                                    <!-- STATUS -->

                                    <td>

                                        <strong>

                                            <?= htmlspecialchars($sensor["status"]) ?>

                                        </strong>

                                    </td>


                                    <!-- AÇÕES -->

                                    <td>

                                        <button
                                            class="botao_dashboard"
                                            onclick="window.location.href='excluir_sensor.php?id=<?= $sensor["id"] ?>'">

                                            <img
                                                src="../assets/icons/DELETE.svg"
                                                alt="Excluir">

                                        </button>

                                    </td>


                                </tr>


                            <?php } ?>


                        <?php } else { ?>


                            <tr>

                                <td colspan="6">

                                    Nenhum sensor cadastrado.

                                </td>

                            </tr>


                        <?php } ?>


                    </tbody>


                </table>

            </div>


        </main>


    </div>


</body>

</html>