<?php
require_once "../infra/conexao.php";

// Mensagens vindas de salvar_trem.php via query string
$erro = $_GET['erro'] ?? null;
$sucesso = $_GET['sucesso'] ?? null;
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastrar trens</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

      <link rel="icon" href="../assets/icons/TREM_AZUL.svg" type="image/x-icon">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <header class="cabecalho">
        <h2><img src="../assets/icons/TREM_AZUL.svg" alt=""> Bem vindo, Administrador</h2>
        <a href="login.html">
            <img src="../assets/icons/exit.svg" class="item" alt=""> 
        </a>
    </header>

    <div class="layout">

        <aside class="menu-lateral">
            <a href="tela_inicial.php" class="item">
                <img src="../assets/icons/dashboard_branco.svg" alt=""> Dashboard
            </a>
            <a href="gerenciar_trens.php" class="item ativo">
                <img src="../assets/icons/trem_branco.svg" alt=""> Trens
            </a>
            <a href="gerenciar_sensores.php" class="item">
                <img src="../assets/icons/sensor_branco.svg" alt=""> Sensores
            </a>
            <a href="rotas.php" class="item">
                <img src="../assets/icons/relatorio_branco.svg" alt=""> Rotas
            </a>
            <a href="tela_de_cadastro.php" class="item">
                <img src="../assets/icons/cadastrar_branco.svg" alt=""> Cadastrar Usuários
            </a>
            <a href="usuarios_cadastrados.php" class="item">
                <img src="../assets/icons/usuarios_branco.svg" alt=""> Usuários Cadastrados
            </a>
        </aside>

           <main class="conteudo">

    <div class="container-sensor">

        <h1 class="titulo-sensor">Cadastrar Novo Trem</h1>

        <?php if ($erro): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <div class="alert alert-success">Trem cadastrado com sucesso!</div>
        <?php endif; ?>

        <form class="form-sensor" method="POST" action="salvar_trem.php">

            <div class="linha-formulario">

                <div class="grupo-input">
                    <label for="localizacao">Localização</label>
                    <input type="text" id="localizacao" name="localizacao" required
                        placeholder="Ex: Estação central - Eixo B">
                </div>

                <div class="grupo-input">
                    <label for="tipoDado">Tipo de Dado</label>

                    <select id="tipoDado" name="tipoDado" required>
                        <option value="" disabled selected>Selecione o tipo de dado</option>
                        <option value="Velocidade">Velocidade</option>
                        <option value="Temperatura">Temperatura</option>
                        <option value="Pressão">Pressão</option>
                    </select>
                </div>

            </div>

            <div class="linha-formulario">

                <div class="grupo-input">
                    <label for="status">Status</label>

                    <select id="status" name="status" required>
                        <option value="" disabled selected>Selecione um status</option>
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                        <option value="Manutenção">Manutenção</option>
                    </select>
                </div>

            </div>

            <div class="botoes-formulario">

                <button type="button" class="botao_cancelar"
                    onclick="window.location.href='tela_inicial.php'">Cancelar</button>

                <button type="submit" class="btn-salvar">
                    salvar
                </button>

            </div>

        </form>

    </div>

</main>

    </div>

</body>

</html>