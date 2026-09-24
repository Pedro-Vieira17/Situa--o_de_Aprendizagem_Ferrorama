DROP DATABASE IF EXISTS sa_ferrorama;

CREATE DATABASE sa_ferrorama
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE sa_ferrorama;

CREATE TABLE USUARIO (
    id INT AUTO_INCREMENT PRIMARY KEY,
    CPF VARCHAR(11) NOT NULL UNIQUE,
    telefone VARCHAR(15) NOT NULL,
    nome VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('usuario', 'administrador') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE TRENS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    localizacao VARCHAR(200) NOT NULL,
    tipo_de_dado VARCHAR(200) NOT NULL,
    status VARCHAR(200) NOT NULL
);

CREATE TABLE SENSORES (
    id INT AUTO_INCREMENT PRIMARY KEY,
    localizacao VARCHAR(200) NOT NULL,
    tipo_de_dado VARCHAR(200) NOT NULL,
    trens_id INT NOT NULL,

    CONSTRAINT fk_sensores_trens
    FOREIGN KEY (trens_id)
    REFERENCES TRENS(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

INSERT INTO USUARIO (
    CPF,
    telefone,
    nome,
    email,
    senha,
    tipo
) VALUES (
    '00000000000',
    '47999999999',
    'Administrador',
    'admin@ferrovia.com.br',
    '$2y$12$IIUBheIqm208Lwwm8HGLa.2jMx7Zynkh31fQox1wtCtpQrLv5gTqS',
    'administrador'
);

INSERT INTO TRENS (
    localizacao,
    tipo_de_dado,
    status
) VALUES
(
    'Joinville - SC',
    'Localização',
    'Ativo'
),
(
    'São Francisco do Sul - SC',
    'Velocidade',
    'Ativo'
),
(
    'Jaraguá do Sul - SC',
    'Temperatura',
    'Manutenção'
);

INSERT INTO SENSORES (
    localizacao,
    tipo_de_dado,
    trens_id
) VALUES
(
    'Joinville - SC',
    'GPS',
    1
),
(
    'São Francisco do Sul - SC',
    'Velocidade',
    2
),
(
    'Jaraguá do Sul - SC',
    'Temperatura',
    3
);