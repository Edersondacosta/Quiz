create database formulario;
use formulario;

-- Usuários
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Perguntas
CREATE TABLE perguntas (
    id_pergunta INT AUTO_INCREMENT PRIMARY KEY,
    enunciado TEXT NOT NULL
);

-- Respostas possíveis (4 por pergunta, cada uma com peso)
CREATE TABLE respostas (
    id_resposta INT AUTO_INCREMENT PRIMARY KEY,
    id_pergunta INT NOT NULL,
    texto_resposta VARCHAR(255) NOT NULL,
    valor INT NOT NULL, -- peso/pontuação
    FOREIGN KEY (id_pergunta) REFERENCES perguntas(id_pergunta)
        ON DELETE CASCADE
);

-- Respostas do usuário (agora tem id_pergunta e id_resposta)
CREATE TABLE respostas_usuario (
    id_resposta_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_pergunta INT NOT NULL,
    id_resposta INT NOT NULL,
    data_resposta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE,
    FOREIGN KEY (id_pergunta) REFERENCES perguntas(id_pergunta)
        ON DELETE CASCADE,
    FOREIGN KEY (id_resposta) REFERENCES respostas(id_resposta)
        ON DELETE CASCADE
);


-- Usuário
INSERT INTO usuarios (nome, email, senha)
VALUES ('Maria', 'maria@email.com', 'hash_aqui');

-- Pergunta
INSERT INTO perguntas (enunciado) 
VALUES 
('Quem descobriu o Brasil');

-- Respostas possíveis
INSERT INTO respostas (id_pergunta, texto_resposta, valor) VALUES
(2, 'Python', 10),
(2, 'Java', 8),
(2, 'C++', 7),
(2, 'JavaScript', 9);

-- Maria responde (duas alternativas)
INSERT INTO respostas_usuario (id_usuario, id_pergunta, id_resposta) VALUES
(1, 1, 1), -- Pergunta 1 → Python
(1, 1, 4); -- Pergunta 1 → JavaScript


select * from respostas_usuario;

