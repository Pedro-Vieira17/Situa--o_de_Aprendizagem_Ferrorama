# PDO

O **PDO (PHP Data Objects)** é uma extensão do PHP utilizada para realizar a conexão entre sistemas PHP e bancos de dados. Ele permite executar consultas, inserir, alterar e excluir informações.

# Objetivos do PDO

O PDO busca facilitar a comunicação entre o sistema e o banco de dados, oferecendo:

Conexões com bancos de dados, execução de comandos SQL, segurança nas consultas, tratamento de erros e utilização de Prepared Statements.

# Principais Características

### Conexão com Banco de Dados

Permite conectar uma aplicação PHP a diferentes tipos de bancos de dados através de drivers.

Exemplo:

```php
$pdo = new PDO(
    "mysql:host=localhost;dbname=sa_ferrorama",
    "root",
    ""
);

 