CREATE DATABASE IF NOT EXISTS adocao_animais;
USE adocao_animais;

-- Tabela de ONGs
CREATE TABLE ONGs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telefone VARCHAR(20),
    senha VARCHAR(255) NOT NULL,
    endereco TEXT
);

-- Tabela de Usuários
CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
);

-- Tabela de Animais
CREATE TABLE Animais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    especie ENUM('Cachorro', 'Gato', 'Outro') NOT NULL,
    idade INT,
    saude TEXT,
    ong_id INT NOT NULL,
    disponivel BOOLEAN DEFAULT TRUE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ong_id) REFERENCES ONGs(id) ON DELETE CASCADE
);

-- Tabela de Reservas
CREATE TABLE Reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    animal_id INT NOT NULL,
    status ENUM('Pendente', 'Aprovada', 'Recusada', 'Finalizada') DEFAULT 'Pendente',
    data_reserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (animal_id) REFERENCES Animais(id) ON DELETE CASCADE
);
