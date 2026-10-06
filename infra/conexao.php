<?php

$conexao = new mysqli(
    "localhost",
    "root",
    "",
    "sa_ferrorama",
<<<<<<< HEAD
    3308
=======
    3307
>>>>>>> 46ba139ac63c836940dc726ae41440bb6f894035

);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

$conexao->set_charset("utf8mb4");