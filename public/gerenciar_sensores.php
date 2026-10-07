<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";


exigirAdministrador();

$pesquisa = isset($_GET["pesquisa"]) ? trim($_GET["pesquisa"]) : "";
$filtroTipo = isset($_GET["tipo"]) ? trim($_GET["tipo"]) : "";
$filtroTrem = isset($_GET["trem"]) ? trim($_GET["trem"]) : "";
$filtroStatus = isset($_GET["status"]) ? trim($_GET["status"]) : "";


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

if ($tipos != "") {
    $stmt->bind_param($tipos, ...$valores);
}

$stmt->execute();
$resultado = $stmt->get_result();


$listaTipos = $conexao->query(
    "SELECT DISTINCT tipo_de_dado FROM SENSORES ORDER BY tipo_de_dado"
);

$listaTrens = $conexao->query(
    "SELECT id FROM TRENS ORDER BY id"
);

$listaStatus = $conexao->query(
    "SELECT DISTINCT status FROM TRENS ORDER BY status"
);


$statusCount = $conexao->query("
    SELECT TRENS.status AS status, COUNT(*) AS total
    FROM SENSORES
    INNER JOIN TRENS ON SENSORES.trens_id = TRENS.id
    GROUP BY TRENS.status
");

$statusData = [];

while ($linha = $statusCount->fetch_assoc()) {
    $statusData[$linha["status"]] = (int) $linha["total"];
}

$sensoresAtivos = $statusData["Ativo"] ?? 0;
$sensoresManutencao = $statusData["Manutenção"] ?? 0;
$sensoresInativos = $statusData["Inativo"] ?? 0;

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

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

</head>


<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous">
    </script>

    <header class="cabecalho">

        <h2>
            <img src="../assets/icons/TREM_AZUL.svg" alt="">
            Bem vindo, Administrador
        </h2>

        <a href="logout.php">
            <img src="../assets/icons/exit.svg" class="item" alt="Sair">
        </a>

    </header>


    <div class="layout">

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

            <?php if (!empty($_GET["erro"])): ?>
                <div class="alert alert-danger">
                    <?= e($_GET["erro"]) ?>
                </div>
            <?php endif; ?>


            <div class="d-flex justify-content-between align-items-center mb-3">

                <h2 class="titulo_do_sensores m-0">
                    Gerenciar Sensores
                </h2>

                <a href="cadastrar_sensores.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Cadastrar Sensor
                </a>

            </div>


            <div class="planilha_dashboard mb-4" style="max-width: 480px; padding: 28px;">

                <h3 class="fs-5 text-center mb-3" style="color: #d9d9d9 !important;">
                    Funcionamento dos Sensores
                </h3>

                <div style="width: 320px; height: 320px; margin: 0 auto;">
                    <canvas id="graficoSensores"></canvas>
                </div>

                <div class="d-flex justify-content-around text-center mt-3" style="color: #d9d9d9;">

                    <div>
                        <div style="font-size: 1.8rem; font-weight: bold; color: #2ecc71;">
                            <?= $sensoresAtivos ?>
                        </div>
                        <small>Ativo</small>
                    </div>

                    <div>
                        <div style="font-size: 1.8rem; font-weight: bold; color: #f1c40f;">
                            <?= $sensoresManutencao ?>
                        </div>
                        <small>Manutenção</small>
                    </div>

                    <div>
                        <div style="font-size: 1.8rem; font-weight: bold; color: #95a5a6;">
                            <?= $sensoresInativos ?>
                        </div>
                        <small>Inativo</small>
                    </div>

                </div>

            </div>


            <form action="gerenciar_sensores.php"
                method="GET"
                class="filtros_sensor d-flex flex-wrap gap-2 align-items-end mb-3">

                <input type="hidden" name="pesquisa" value="<?= htmlspecialchars($pesquisa) ?>">

                <div>
                    <label for="tipo" class="form-label" style="color: white;">Tipo de Dado</label>
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
                    <label for="trem" class="form-label" style="color: white;">Trem</label>
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
                    <label for="status" class="form-label" style="color: white;">Status</label>
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


            <div class="planilha_dashboard">

                <table class="table table-borderless">

                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOME</th>
                            <th scope="col">LOCALIZAÇÃO</th>
                            <th scope="col">TREM</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">AÇÕES</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if ($resultado->num_rows > 0) { ?>

                            <?php while ($sensor = $resultado->fetch_assoc()) { ?>

                                <tr>

                                    <th scope="row">
                                        #<?= str_pad($sensor["id"], 3, "0", STR_PAD_LEFT) ?>
                                    </th>

                                    <td><?= htmlspecialchars($sensor["tipo_de_dado"]) ?></td>

                                    <td><?= htmlspecialchars($sensor["localizacao"]) ?></td>

                                    <td>
                                        Trem <?= str_pad($sensor["trens_id"], 2, "0", STR_PAD_LEFT) ?>
                                    </td>

                                    <td>
                                        <strong><?= htmlspecialchars($sensor["status"]) ?></strong>
                                    </td>

                                    <td>

                                        <a
                                            href="editar_sensores.php?id=<?= (int)$sensor['id'] ?>"
                                            class="btn btn-sm btn-warning">

                                            <i class="bi bi-pencil"></i>

                                            Editar

                                        </a>

                                        <form
                                            method="POST"
                                            action="excluir_informacoes_sensor.php"
                                            style="display:inline;"
                                            onsubmit="return confirm('Deseja realmente excluir este sensor?');">

                                            <input type="hidden" name="id" value="<?= (int)$sensor['id'] ?>">
                                            <input type="hidden" name="csrf_token" value="<?= e(gerarTokenCsrf()) ?>">

                                            <button type="submit" class="btn btn-sm btn-danger">

                                                <i class="bi bi-trash"></i>

                                                Excluir

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="6" style="text-align: center; color: #b3b3b3;">
                                    Nenhum sensor encontrado.
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>


            <p class="text-muted mt-2" style="margin-top: 12px; color: #b3b3b3 !important;">
                <?= $resultado->num_rows ?> sensor(es) encontrado(s).
            </p>

        </main>

    </div>


    <script>

        new Chart(document.getElementById("graficoSensores"), {
            type: "doughnut",
            data: {
                labels: ["Ativo", "Manutenção", "Inativo"],
                datasets: [{
                    data: [<?= $sensoresAtivos ?>, <?= $sensoresManutencao ?>, <?= $sensoresInativos ?>],
                    backgroundColor: ["#2ecc71", "#f1c40f", "#95a5a6"],
                    borderWidth: 0,
                    spacing: 3,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: "70%",
                plugins: {
                    legend: { display: false }
                }
            }
        });

    </script>

</body>

</html>