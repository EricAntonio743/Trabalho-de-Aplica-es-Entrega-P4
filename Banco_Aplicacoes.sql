 DROP DATABASE IF EXISTS `Banco_TA`;

-------------------------------------------------------
-- Schema bd_atividade_pratica
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Banco_TA` DEFAULT CHARACTER SET utf8;
USE `Banco_TA` ;

-- Criação da tabela Usuário
CREATE TABLE Usuario (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Senha VARCHAR(50) NOT NULL,
    CargoFuncao VARCHAR(50)
);

-- Criação da tabela Tarefa
CREATE TABLE Tarefa (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Descricao VARCHAR(255) NOT NULL,
    Prazo DATETIME NOT NULL,
    Status VARCHAR(20) NOT NULL,
    Prioridade VARCHAR(20) NOT NULL
);

-- Criação da tabela Inventário
CREATE TABLE Inventario (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    NomeItem VARCHAR(100) NOT NULL,
    QuantidadeDisponivel FLOAT NOT NULL,
    Descricao VARCHAR(255),
    Categoria VARCHAR(50)
);