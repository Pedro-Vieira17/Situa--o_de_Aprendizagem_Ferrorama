<?php

session_start();

require_once "infra/conexao.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"] ?? "";
    $senha = $_POST["senha"] ?? "";

    if ($email == "" || $senha == "") {

        $erro = "Preencha o e-mail e a senha.";

    } else {

        $sql = "SELECT * FROM USUARIO WHERE email = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {

            $usuario = $resultado->fetch_assoc();

            if (password_verify($senha, $usuario["senha"])) {

                $_SESSION["usuario_id"] = $usuario["id"];
                $_SESSION["usuario_nome"] = $usuario["nome"];

                header("Location: public/tela_inicial.php");
                exit;

            } else {

                $erro = "E-mail ou senha incorretos.";

            }

        } else {

            $erro = "E-mail ou senha incorretos.";

        }

    }
}

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tela de Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="assets/style/style.css">

    <link rel="icon" href="assets/icons/TREM_AZUL.svg" type="image/x-icon">
</head>

<body>

    <div class="container vh-100 d-flex align-items-center">

        <div class="p-3" style="max-width: 400px; width: 100%;">

            <div class="titulo">

                <h1 class="text-nowrap">🚄Sistema Ferroviário</h1>

                <p>Monitoramento em tempo real</p>

            </div>

            <?php if ($erro != ""): ?>

                <div class="alert alert-danger">
                    <?= $erro ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="formulario">

                    <div class="mb-3">

                        <label class="form-label">
                            E-mail
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="operador@ferrovia.com.br"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Senha
                        </label>

                        <input
                            type="password"
                            name="senha"
                            class="form-control"
                            placeholder="Digite sua senha"
                            required>

                    </div>

                </div>

                <div class="botao">

                    <div class="d-grid gap-2">

                        <button
                            class="btn btn-primary"
                            type="submit">

                            Entrar

                        </button>

                    </div>

                </div>

                <div class="text-center mt-3">

                    <span>Não tem login?</span>

                    <a href="tela_de_cadastro.php" class="text-decoration-none">
                        Crie uma conta
                    </a>

                </div>

            </form>

        </div>

        <img
            src="assets/img/trem-png novo.webp"
            alt="Trem"
            style="margin-left:auto">

    </div>

</body>

</html>