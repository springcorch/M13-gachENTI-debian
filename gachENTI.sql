-- CREATE Database 
CREATE DATABASE IF NOT EXISTS gachenti_db;

-- USE database
USE gachenti_db;

-- CREATE TABLE user_types
CREATE TABLE user_types (
    id_user_type INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(16)
);

-- CREATE TABLE users
CREATE TABLE users (
    id_user INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(24),
    surname VARCHAR(24),
    username VARCHAR(16),
    email VARCHAR(32),
    password CHAR(32),
    birthdate DATE,
    funds DECIMAL(8,2),
    registered DATETIME,
    status INT,
    id_user_type INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_user_type) REFERENCES user_types(id_user_type)
);

-- CREATE TABLE card_types
CREATE TABLE card_types (
    id_card_type INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(16),
    abbrev VARCHAR(4),
    description TEXT,
    color CHAR(6)
);

-- CREATE TABLE card_rarities
CREATE TABLE card_rarities (
    id_card_rarity INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    rarity VARCHAR(16),
    abbrev VARCHAR(4),
    description TEXT,
    probability INT
);

-- CREATE TABLE card_templates
CREATE TABLE card_templates (
    id_card_template INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    card VARCHAR(32),
    initial_price DECIMAL(6,2),
    description TEXT NULL,
    image VARCHAR(32) NULL,
    id_card_type INT UNSIGNED NOT NULL,
    id_card_rarity INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_card_type) REFERENCES card_types(id_card_type),
    FOREIGN KEY (id_card_rarity) REFERENCES card_rarities(id_card_rarity)
);

-- CREATE TABLE cards
CREATE TABLE cards (
    id_card INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    price DECIMAL(6,2),
    discount INT,
    on_sale BOOL,
    state INT,
    creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_card_template INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_card_template) REFERENCES card_templates(id_card_template)
);

-- CREATE TABLE user_cards
CREATE TABLE user_cards (
    id_user_card INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    id_card INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (id_card) REFERENCES cards(id_card)
);

-- CREATE TABLE logs
CREATE TABLE logs (
    id_log INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    price DECIMAL(6,2),
    discount INT,
    transaction DATETIME DEFAULT CURRENT_TIMESTAMP,
    state INT,
    id_user_seller INT UNSIGNED NOT NULL,
    id_user_buyer INT UNSIGNED NOT NULL,
    id_card INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_user_seller) REFERENCES users(id_user),
    FOREIGN KEY (id_user_buyer) REFERENCES users(id_user),
    FOREIGN KEY (id_card) REFERENCES cards(id_card)
);

-- Tipos de usuario
INSERT INTO user_types(type) VALUES
('normal'),
('admin'),
('root');

-- Usuario root
INSERT INTO users(name, surname, username, email, password, birthdate, funds, registered, status, id_user_type)
VALUES ('enti', 'enti', 'enti', 'enti@gachenti.com', MD5('enti'), '2000-01-01', 1000.00, NOW(), 1, 3);

-- Tipos de cartas
INSERT INTO card_types(type, abbrev, description, color) VALUES
('Charlatan', 'YAP', 'Cartas que le gustan hablar en clase', 'FF4500'),
('Maquiavolico', 'EVIL', 'Cartas que se respetan en clase', '32CD32'),
('Callado', 'QUIET', 'Cartas que no hablan mucho en clase', '1E90FF');

-- Rarezas de cartas
INSERT INTO card_rarities(rarity, abbrev, description, probability) VALUES
('comun', 'COM', 'carta comun', 60),
('rara', 'RAR', 'carta rara', 30),
('epica', 'EPI', 'carta epica', 10);

-- Plantillas de cartas
INSERT INTO card_templates(card, initial_price, description, image, id_card_type, id_card_rarity) VALUES
('Rafa Laguna', 100.00, 'Carta epica de Rafa Laguna', 'rafa_laguna.png', 1, 3),
('Richard', 50.00, 'Carta rara de Richard', 'richard_shiny.png', 2, 2),
('Alberto Alegre', 20.00, 'Carta comun de Alberto Alegre', 'alberto_alegre.png', 3, 1);

-- Cartas a partir de plantillas
INSERT INTO cards(price, discount, on_sale, state, id_card_template) VALUES
(100.00, 0, 1, 1, 1),
(100.00, 0, 1, 1, 1),
(50.00, 0, 1, 1, 2),
(50.00, 0, 1, 1, 2),
(20.00, 0, 1, 1, 3);