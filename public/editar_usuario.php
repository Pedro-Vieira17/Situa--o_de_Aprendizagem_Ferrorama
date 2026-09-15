<?php

require_once "../infra/conexao.php";

$id = $_GET["id"];

$resultado = mysqli_query($conexao, "SELECT * FROM USUARIO WHERE id = $id");

$usuario = mysqli_fetch_assoc($resultado);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    $sql = "UPDATE USUARIO 
            SET nome = ?, CPF = ?, telefone = ?, email = ?
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param(
        "ssssi",
        $nome,
        $cpf,
        $telefone,
        $email,
        $id
    );

    $stmt->execute();

    header("Location: usuarios_cadastrados.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Editar Usuário</title>

    <link rel="stylesheet" href="../assets/style/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" href="../assets/icons/TREM_AZUL.svg">

</head>

<body>

    <div class="container vh-100 d-flex align-items-center">

        <div class="p-3" style="max-width: 400px; width: 100%;">

            <div class="titulo">

                <h1>Editar Usuário</h1>

            </div>

            <form method="POST">

                <label>Nome completo</label>

                <input
                    type="text"
                    name="nome"
                    class="form-control mb-3"
                    value="<?= $usuario["nome"] ?>"
                    required
                >

                <label>CPF</label>

                <input
                    type="text"
                    name="cpf"
                    class="form-control mb-3"
                    value="<?= $usuario["CPF"] ?>"
                    required
                >

                <label>Telefone</label>

                <input
                    type="text"
                    name="telefone"
                    class="form-control mb-3"
                    value="<?= $usuario["telefone"] ?>"
                    required
                >

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-control mb-3"
                    value="<?= $usuario["email"] ?>"
                    required
                >

                <button
                    type="submit"
                    class="btn btn-primary">
                    Salvar as alterações
                </button>

                <a
                    href="usuarios_cadastrados.php"
                    class="btn btn-secondary">
                    Voltar
                </a>

            </form>

        </div>

    </div>

</body>

</html>