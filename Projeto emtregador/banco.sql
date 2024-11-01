-- Criação do banco de dados
CREATE DATABASE projetoquadra;

USE projetoquadra;

-- Tabela de clientes
CREATE TABLE tb_clientes (
    cli_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cli_nome VARCHAR(100) NOT NULL,
    cli_email VARCHAR(100),
    cli_cel VARCHAR(15),
    cli_status CHAR(1) DEFAULT 
);

-- Tabela de quadras
CREATE TABLE tb_quadras (
    qd_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    qd_nome VARCHAR(100) NOT NULL,
    qd_localizacao VARCHAR(100) NOT NULL,
    qd_capacidade VARCHAR(10) NOT NULL,
    qd_valor_hora DECIMAL(10, 2) NOT NULL,
    qd_disponibilidade TINYINT NOT NULL DEFAULT 1,
    qd_status CHAR(1) DEFAULT,  
    qd_imagem LONGBLOB
);

-- Tabela de reservas
CREATE TABLE tb_reservas (
    iv_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    iv_valortotal DECIMAL(10, 2) NOT NULL,
    iv_horas DECIMAL(5, 2) NOT NULL,
    iv_cod_iv VARCHAR(50) NOT NULL,
    fk_qd_id INT NOT NULL,
    fk_cli_id INT NOT NULL,
    iv_status CHAR(1) NOT NULL DEFAULT,
    FOREIGN KEY (fk_qd_id) REFERENCES tb_quadras(qd_id) ON DELETE CASCADE,
    FOREIGN KEY (fk_cli_id) REFERENCES tb_clientes(cli_id) ON DELETE CASCADE;
    horainicio TIME;
    horafim TIME
);