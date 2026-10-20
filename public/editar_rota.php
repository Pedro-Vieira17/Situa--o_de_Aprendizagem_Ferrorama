<?php

require_once "../infra/seguranca.php";
require_once "../infra/conexao.php";

exigirAdministrador();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

    header("Location: rotas.php");

    exit;
}

$id = intval($_GET["id"]);

$stmt = $conexao->prepare(
    "SELECT id, origem, destino, horario, status
     FROM ROTAS
     WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

$rota = $resultado->fetch_assoc();

$stmt->close();

if (!$rota) {

    header("Location: rotas.php");

    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Editar Rota</title>

    <link
        rel="stylesheet"
        href="../assets/style/style.css">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

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

        <img
            src="../assets/icons/exit.svg"
            class="item"
            alt="Sair">

    </a>

</header>


<div class="layout">

    <aside class="menu-lateral">

        <a
            href="tela_inicial.php"
            class="item">

            <img
                src="../assets/icons/dashboard_branco.svg"
                alt="">

            Dashboard

        </a>


        <a
            href="gerenciar_sensores.php"
            class="item">

            <img
                src="../assets/icons/sensor_branco.svg"
                alt="">

            Sensores

        </a>


        <a
            href="rotas.php"
            class="item ativo">

            <img
                src="../assets/icons/relatorio_preto.svg"
                alt="">

            Rotas

        </a>


        <a
            href="cadastro_admin.php"
            class="item">

            <img
                src="../assets/icons/cadastrar_branco.svg"
                alt="">

            Cadastrar ADMs e Usuários

        </a>


        <a
            href="usuarios_cadastrados.php"
            class="item">

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

                Editar Rota

            </h1>


            <form
                class="form-sensor"
                method="POST"
                action="atualizar_rota.php">


                <input
                    type="hidden"
                    name="id"
                    value="<?= $rota["id"] ?>">


                <div class="linha-formulario">

                    <div class="grupo-input">

                        <label
                            style="color: white;"
                            for="origem">

                            Origem

                        </label>

                        <input
                            type="text"
                            id="origem"
                            name="origem"
                            value="<?= htmlspecialchars($rota["origem"]) ?>"
                            placeholder="Ex: Joinville - SC"
                            required>

                    </div>


                    <div class="grupo-input">

                        <label
                            style="color: white;"
                            for="destino">

                            Destino

                        </label>

                        <input
                            type="text"
                            id="destino"
                            name="destino"
                            value="<?= htmlspecialchars($rota["destino"]) ?>"
                            placeholder="Ex: Jaraguá do Sul - SC"
                            required>

                    </div>

                </div>


                <div class="linha-formulario">

                    <div class="grupo-input">

                        <label
                            style="color: white;"
                            for="horario">

                            Horário

                        </label>

                        <input
                            type="time"
                            id="horario"
                            name="horario"
                            value="<?= htmlspecialchars($rota["horario"]) ?>"
                            required>

                    </div>


                    <div class="grupo-input">

                        <label
                            style="color: white;"
                            for="status">

                            Status

                        </label>

                        <select
                            id="status"
                            name="status"
                            required>

                            <option
                                value="Ativa"
                                <?= $rota["status"] == "Ativa" ? "selected" : "" ?>>

                                Ativa

                            </option>

                            <option
                                value="Inativa"
                                <?= $rota["status"] == "Inativa" ? "selected" : "" ?>>

                                Inativa

                            </option>

                            <option
                                value="Manutenção"
                                <?= $rota["status"] == "Manutenção" ? "selected" : "" ?>>

                                Manutenção

                            </option>

                        </select>

                    </div>

                </div>


                <div class="botoes-formulario">

                    <a
                        href="rotas.php"
                        class="botao_cancelar">

                        Cancelar

                    </a>


                    <button
                        type="submit"
                        class="btn-salvar">

                        Salvar Alterações

                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

</body>

</html>