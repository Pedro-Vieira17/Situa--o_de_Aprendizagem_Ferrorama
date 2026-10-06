<?php

$conexao = new mysqli(
    "localhost",
    "root",
    "",
    "sa_ferrorama",
<<<<<<< HEAD
    3306
=======
    3307
>>>>>>> c858e06fedcb7780d1020813bbb42ad52fd27de1

);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

$conexao->set_charset("utf8mb4");