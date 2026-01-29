
--primero me cree la estructura que queria implmentar en sql para luego tenerla clara para sequelize
CREATE DATABASE IF NOT EXISTS node_jankenpo;
USE node_jankenpo;


--tabla usuarios
CREATE TABLE IF NOT EXISTS users(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    soft_delete BOOLEAN DEFAULT FALSE
);

--tabla partidas 

CREATE TABLE IF NOT EXISTS games(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    creator_id INT,
    opponent_id INT,
    finished BOOLEAN DEFAULT FALSE,
    winner_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creator_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (opponent_id) REFERENCES users(id) ON DELETE SET NULL
);


--tabla rondas

CREATE TABLE IF NOT EXISTS rounds(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    game_id INT NOT NULL, 
    creator_choice ENUM('rock', 'paper', 'scissors') NOT NULL,
    opponent_choice ENUM('rock', 'paper', 'scissors') NOT NULL,
    round_number INT NOT NULL,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);
