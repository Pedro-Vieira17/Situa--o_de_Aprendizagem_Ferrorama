<?php

require_once "../infra/conexao.php";

// Filtros vindos da URL
$pesquisa = isset($_GET["pesquisa"]) ? trim($_GET["pesquisa"]) : "";
$filtroTipo = isset($_GET["tipo"]) ? trim($_GET["tipo"]) : "";
$filtroTrem = isset($_GET["trem"]) ? trim($_GET["trem"]) : "";
$filtroStatus = isset($_GET["status"]) ? trim($_GET["status"]) : "";

// Monta a consulta conforme os filtros preenchidos
$sql = "SELECT
            SENSORES.id,
            SENSORES.localizacao,
            SENSORES.tipo_de_dado,
            SENSORES.trens_id,
            TRENS.status
        FROM SENSORES
        INNER JOIN TRENS
            ON SENSORES.trens_id = TRENS.id
        WHERE 1 = 1";

$tipos = "";
$valores = [];

if ($pesquisa != "") {
    $sql .= " AND (SENSORES.tipo_de_dado LIKE ? OR SENSORES.localizacao LIKE ?)";
    $busca = "%" . $pesquisa . "%";
    $tipos .= "ss";
    $valores[] = $busca;
    $valores[] = $busca;
}

if ($filtroTipo != "") {
    $sql .= " AND SENSORES.tipo_de_dado = ?";
    $tipos .= "s";
    $valores[] = $filtroTipo;
}

if ($filtroTrem != "") {
    $sql .= " AND SENSORES.trens_id = ?";
    $tipos .= "i";
    $valores[] = $filtroTrem;
}

if ($filtroStatus != "") {
    $sql .= " AND TRENS.status = ?";
    $tipos .= "s";
    $valores[] = $filtroStatus;
}

$sql .= " ORDER BY SENSORES.id DESC";

$stmt = $conexao->prepare($sql);

// Só faz bind se algum filtro foi usado
if ($tipos != "") {
    $stmt->bind_param($tipos, ...$valores);
}

$stmt->execute();
$resultado = $stmt->get_result();

// Opções dos selects de filtro (vindas do próprio banco)
$listaTipos = $conexao->query(
    "SELECT DISTINCT tipo_de_dado FROM SENSORES ORDER BY tipo_de_dado"
);

$listaTrens = $conexao->query(
    "SELECT id FROM TRENS ORDER BY id"
);

$listaStatus = $conexao->query(
    "SELECT DISTINCT status FROM TRENS ORDER BY status"
);

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

                <img src="../assets/icons/relatorio_branco.svg" alt="">

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

                    <!-- mantém os outros filtros ao pesquisar por texto -->
                    <input type="hidden" name="tipo" value="<?= htmlspecialchars($filtroTipo) ?>">
                    <input type="hidden" name="trem" value="<?= htmlspecialchars($filtroTrem) ?>">
                    <input type="hidden" name="status" value="<?= htmlspecialchars($filtroStatus) ?>">

                </form>


                <!-- CADASTRAR -->

                <button
                    class="botao_cancelar"
                    onclick="window.location.href='cadastrar_sensores.php'">

                    Cadastrar

                </button>


  <button
                    class="botao_cancelar"
                    onclick="window.location.href='editar_sensores.php'">

                    Editar

                </button>


            </div>


            <!-- FILTROS DE CONSULTA -->

            <form action="gerenciar_sensores.php"
                method="GET"
                class="filtros_sensor d-flex flex-wrap gap-2 align-items-end mb-3">

                <!-- mantém a pesquisa de texto ao aplicar os filtros -->
                <input type="hidden" name="pesquisa" value="<?= htmlspecialchars($pesquisa) ?>">


                <div>

                    <label for="tipo" class="form-label">Tipo de Dado</label>

                    <select name="tipo" id="tipo" class="form-select">

                        <option value="">Todos</option>

                        <?php while ($t = $listaTipos->fetch_assoc()) { ?>

                            <option
                                value="<?= htmlspecialchars($t["tipo_de_dado"]) ?>"
                                <?= $filtroTipo === $t["tipo_de_dado"] ? "selected" : "" ?>>

                                <?= htmlspecialchars($t["tipo_de_dado"]) ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>


                <div>

                    <label for="trem" class="form-label">Trem</label>

                    <select name="trem" id="trem" class="form-select">

                        <option value="">Todos</option>

                        <?php while ($tr = $listaTrens->fetch_assoc()) { ?>

                            <option
                                value="<?= (int)$tr["id"] ?>"
                                <?= $filtroTrem === (string)$tr["id"] ? "selected" : "" ?>>

                                Trem <?= str_pad($tr["id"], 2, "0", STR_PAD_LEFT) ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>


                <div>

                    <label for="status" class="form-label">Status</label>

                    <select name="status" id="status" class="form-select">

                        <option value="">Todos</option>

                        <?php while ($s = $listaStatus->fetch_assoc()) { ?>

                            <option
                                value="<?= htmlspecialchars($s["status"]) ?>"
                                <?= $filtroStatus === $s["status"] ? "selected" : "" ?>>

                                <?= htmlspecialchars($s["status"]) ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>


                <button type="submit" class="botao_cancelar">
                    Filtrar
                </button>

                <a href="gerenciar_sensores.php" class="btn btn-secondary">
                    Limpar
                </a>

            </form>


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

                                    Nenhum sensor encontrado.

                                </td>

                            </tr>


                        <?php } ?>


                    </tbody>


                </table>

            </div>


            <p class="text-muted mt-2">

                <?= $resultado->num_rows ?> sensor(es) encontrado(s).

            </p>


        </main>


    </div>


</body>

</html>