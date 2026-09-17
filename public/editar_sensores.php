```php
<?php

require_once "../infra/conexao.php";


// Verifica se o ID foi informado
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: gerenciar_sensores.php");
    exit;
}

$id = intval($_GET["id"]);


// Busca os dados do sensor
$sql = "SELECT id, localizacao, tipo_de_dado, trens_id
        FROM SENSORES
        WHERE id = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();


// Verifica se o sensor existe
if ($resultado->num_rows == 0) {
    header("Location: gerenciar_sensores.php");
    exit;
}

$sensor = $resultado->fetch_assoc();


// Busca os trens cadastrados
$sqlTrens = "SELECT id, localizacao
             FROM TRENS
             ORDER BY id";

$resultadoTrens = $conexao->query($sqlTrens);


// Mensagem de erro
$erro = $_GET['erro'] ?? null;

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Editar Sensor</title>

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
        href="../assets/icons/TREM_AZUL.svg"
        type="image/x-icon">

</head>


<body>


    <!-- CABEÇALHO -->

    <header class="cabecalho">

        <h2>

            <img
                src="../assets/icons/TREM_AZUL.svg"
                alt="">

            Bem vindo, Administrador

        </h2>


        <a href="login.html">

            <img
                src="../assets/icons/exit.svg"
                class="item"
                alt="">

        </a>

    </header>


    <div class="layout">


        <!-- MENU LATERAL -->

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
                href="gerenciar_trens.php"
                class="item">

                <img
                    src="../assets/icons/trem_branco.svg"
                    alt="">

                Trens

            </a>


            <a
                href="gerenciar_sensores.php"
                class="item ativo">

                <img
                    src="../assets/icons/sensor_preto.svg"
                    alt="">

                Sensores

            </a>


            <a
                href="rotas.php"
                class="item">

                <img
                    src="../assets/icons/relatorio_branco.svg"
                    alt="">

                Rotas

            </a>


            <a
                href="tela_de_cadastro.php"
                class="item">

                <img
                    src="../assets/icons/cadastrar_branco.svg"
                    alt="">

                Cadastrar Usuários

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


        <!-- CONTEÚDO -->

        <main class="conteudo">


            <div class="container-sensor">


                <h1 class="titulo-sensor">

                    Editar Sensor

                </h1>


                <!-- MENSAGEM DE ERRO -->

                <?php if ($erro): ?>

                    <div class="alert alert-danger">

                        <?= htmlspecialchars($erro) ?>

                    </div>

                <?php endif; ?>


                <!-- FORMULÁRIO -->

                <form
                    class="form-sensor"
                    method="POST"
                    action="salvar_edicao_sensor.php">


                    <!-- ID DO SENSOR -->

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $sensor['id'] ?>">


                    <!-- PRIMEIRA LINHA -->

                    <div class="linha-formulario">


                        <!-- LOCALIZAÇÃO -->

                        <div class="grupo-input">

                            <label for="localizacao">

                                Localização

                            </label>


                            <input
                                type="text"
                                id="localizacao"
                                name="localizacao"
                                value="<?= htmlspecialchars($sensor['localizacao']) ?>"
                                required
                                placeholder="Ex: Estação central - Eixo B">

                        </div>


                        <!-- TIPO DE DADO -->

                        <div class="grupo-input">

                            <label for="tipoDado">

                                Tipo de Dado

                            </label>


                            <select
                                id="tipoDado"
                                name="tipoDado"
                                required>


                                <option
                                    value=""
                                    disabled>

                                    Selecione o tipo de dado

                                </option>


                                <option
                                    value="Velocidade"
                                    <?= $sensor['tipo_de_dado'] == 'Velocidade' ? 'selected' : '' ?>>

                                    Velocidade

                                </option>


                                <option
                                    value="Temperatura"
                                    <?= $sensor['tipo_de_dado'] == 'Temperatura' ? 'selected' : '' ?>>

                                    Temperatura

                                </option>


                                <option
                                    value="Pressão"
                                    <?= $sensor['tipo_de_dado'] == 'Pressão' ? 'selected' : '' ?>>

                                    Pressão

                                </option>


                            </select>

                        </div>

                    </div>


                    <!-- SEGUNDA LINHA -->

                    <div class="linha-formulario">


                        <!-- TREM VINCULADO -->

                        <div class="grupo-input">

                            <label for="tremVinculado">

                                Trem Vinculado

                            </label>


                            <select
                                id="tremVinculado"
                                name="tremVinculado"
                                required>


                                <option
                                    value=""
                                    disabled>

                                    Selecione um trem

                                </option>


                                <?php while (
                                    $trem = $resultadoTrens->fetch_assoc()
                                ): ?>


                                    <option
                                        value="<?= $trem['id'] ?>"
                                        <?= $trem['id'] == $sensor['trens_id'] ? 'selected' : '' ?>>

                                        Trem
                                        <?= str_pad(
                                            $trem['id'],
                                            2,
                                            "0",
                                            STR_PAD_LEFT
                                        ) ?>

                                        -

                                        <?= htmlspecialchars(
                                            $trem['localizacao']
                                        ) ?>

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

                            Salvar Alterações

                        </button>


                    </div>


                </form>


            </div>


        </main>


    </div>


</body>

</html>
```
