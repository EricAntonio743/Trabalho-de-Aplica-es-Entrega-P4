<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conecta ao banco de dados
    $servername = "localhost"; // Endereço do servidor MySQL 
    $username = "root"; // Nome de usuário do MySQL
    $password = ""; // Senha do MySQL
    $dbname = "Banco_TA"; // Nome do banco de dados

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Recebe os dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $cargoFuncao = $_POST["cargo_funcao"];

    // Prepara a declaração SQL para inserir os dados na tabela Usuário
    $sql = "INSERT INTO Usuario (Nome, Email, Senha, CargoFuncao) VALUES (?, ?, ?, ?)";

    // Prepara a declaração
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Preparação da consulta falhou: " . $conn->error);
    }

    // Vincula os parâmetros
    $stmt->bind_param("ssss", $nome, $email, $senha, $cargoFuncao);

    // Executa a declaração
    if ($stmt->execute()) {
        // Redireciona para a página de login com uma mensagem de sucesso
        header("Location: index.php?cadastro=sucesso");
        exit();
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    // Fecha a conexão
    $stmt->close();
    $conn->close();
}
?>
