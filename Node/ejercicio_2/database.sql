CREATE DATABASE IF NOT EXISTS node_lingoGame;
USE node_lingoGame;

DROP TABLE IF EXISTS dictionary;
DROP TABLE IF EXISTS history;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS games;



-- tabla de usuarios


CREATE TABLE IF NOT EXISTS users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- tabla diccionario de palabras
CREATE TABLE IF NOT EXISTS dictionary (
    id INT AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(5) NOT NULL UNIQUE
);


-- tabla basica para las partidas
CREATE TABLE IF NOT EXISTS games(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    target_word VARCHAR(5) NOT NULL,
    attempts_count INT DEFAULT 0,
    is_solved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE IF NOT EXISTS history(
    id INT AUTO_INCREMENT PRIMARY KEY,
    game_id INT NOT NULL,
    attempt_word VARCHAR(5) NOT NULL,
    attempt_number INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_game FOREIGN KEY (game_id) REFERENCES games(id)

);





