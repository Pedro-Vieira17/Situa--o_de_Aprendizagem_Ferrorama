<?php

require_once "../infra/conexao.php";

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
        Bem vindo, Administrador
    </h2>

    <a href="../index.php">
        <img src="../assets/icons/exit.svg" class="item" alt="">
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

    ```php
<?php

require_once "../infra/conexao.php";

$sql = "SELECT id, localizacao, horario, status
        FROM TRENS
        ORDER BY horario ASC";

$trens = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rotas</title>

    <link rel="stylesheet" href="../assets/style/style.css">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="../assets/icons/TREM_AZUL.svg">

</head>

<body>

<header class="cabecalho">

    <h2>

        <img
            src="../assets/icons/TREM_AZUL.svg"
            alt="">

        Rotas dos Trens

    </h2>

    <a href="../index.php">

        <img
            src="../assets/icons/exit.svg"
            class="item"
            alt="">

    </a>

</header>


<div class="layout">

    <aside class="menu-lateral">

        <a href="tela_inicial.php" class="item">

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


        <a href="rotas.php" class="item ativo">

            <img
                src="../assets/icons/relatorio_branco.svg"
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


    <main class="container-fluid p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h1>Rotas dos Trens</h1>

                <p class="text-muted">
                    Consulte a localização e o horário dos trens.
                </p>

            </div>

        </div>


        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Localização</th>

                                <th>Horário</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if ($trens && $trens->num_rows > 0): ?>

                                <?php while ($trem = $trens->fetch_assoc()): ?>

                                    <tr>

                                        <td>
                                            <?= $trem["id"] ?>
                                        </td>

                                        <td>

                                            <i class="bi bi-geo-alt-fill"></i>

                                            <?= htmlspecialchars($trem["localizacao"]) ?>

                                        </td>

                                        <td>

                                            <i class="bi bi-clock"></i>

                                            <?= date("H:i", strtotime($trem["horario"])) ?>

                                        </td>

                                        <td>

                                            <?php if ($trem["status"] == "Manutenção"): ?>

                                                <span class="badge bg-warning text-dark">
                                                    Manutenção
                                                </span>

                                            <?php elseif ($trem["status"] == "Alerta"): ?>

                                                <span class="badge bg-danger">
                                                    Alerta
                                                </span>

                                            <?php else: ?>

                                                <span class="badge bg-success">
                                                    Ativo
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="4" class="text-center">

                                        Nenhum trem cadastrado.

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</div>

</body>

</html>
```

