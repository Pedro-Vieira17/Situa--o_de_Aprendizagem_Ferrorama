<?php

$conexao = new mysqli(
    "localhost",
    "root",
    "",
    "sa_ferrorama",
<<<<<<< HEAD
    3306

=======
    3308
>>>>>>> 5c1c51bfe014207b56c20f09a72f2563fa2b9766
);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

$conexao->set_charset("utf8mb4");