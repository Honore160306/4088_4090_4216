DROP DATABASE IF EXISTS 4088_4090_4216;
CREATE DATABASE 4088_4090_4216 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE 4088_4090_4216;

-- Set session for proper emoji support
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ======================
-- TABLE USERS
-- ======================
CREATE TABLE users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    pwd VARCHAR(255) NOT NULL
);

-- ======================
-- TABLE CATEGORIES
-- ======================
CREATE TABLE categories (
    id_category INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- ======================
-- TABLE EMOJIS
-- ======================

CREATE TABLE emojis (
    id_emoji INT PRIMARY KEY AUTO_INCREMENT,
    img VARCHAR(100) NOT NULL
);

-- ======================
-- TABLE FOODS
-- ======================
CREATE TABLE foods (
    id_food INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NULL,
    name VARCHAR(50) NOT NULL,
    id_emoji INT NOT NULL,
    img VARCHAR(100) NOT NULL,
    id_category INT NOT NULL,
    time INT NOT NULL,
    cal INT NOT NULL,
    rating INT NOT NULL,
    description VARCHAR(255) NOT NULL,

    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE SET NULL,
    FOREIGN KEY (id_category) REFERENCES categories(id_category) ON DELETE CASCADE,
    FOREIGN KEY (id_emoji) REFERENCES emojis(id_emoji) ON DELETE CASCADE
);

-- ======================
-- TABLE STATS
-- ======================
CREATE TABLE stats (
    id_stat INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_food INT NOT NULL, 
    type ENUM('like', 'skip', 'super') NOT NULL,

    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_food) REFERENCES foods(id_food) ON DELETE CASCADE,

    UNIQUE KEY user_food_interaction (id_user, id_food)
);

-- ======================
-- INSERT CATEGORIES
-- ======================
INSERT INTO categories (name) VALUES
('Français'),
('Italien'),
('Japonais'),
('Mexicain'),
('Indien'),
('Thaïlandais'),
('Américain'),
('Oriental'),
('Maghrébin'),
('Hawaïen'),
('Dessert'),
('Autre');

-- ======================
-- INSERT EMOJIS
-- ======================
INSERT INTO emojis (img) VALUES
    ('🍕'),('🍔'),('🌮'),('🌯'),('🍜'),('🍝'),('🍣'),('🍱'),('🍛'),('🍲'),
    ('🥘'),('🍚'),('🥗'),('🍳'),('🥞'),('🧆'),('🥙'),('🫔'),('🍢'),
    ('🥩'),('🍗'),('🥚'),('🧀'),('🥓'),('🌭'),('🥪'),('🫕'),('🍮'),('🧁'),
    ('🎂'),('🍰'),('🍩'),('🍪'),('🍫'),('🍦'),('🍧'),('🍨'),('🥧'),('🍡'),
    ('🍷'),('🥂'),('🍺'),('🧋'),('🥤'),('☕'),('🍵'),('🥛'),('🍹'),('🧃');  

-- ======================
-- INSERT FOODS (CORRIGÉ)
-- ======================
INSERT INTO foods (id_user, name, id_emoji, img, id_category, time, cal, rating, description) VALUES
(NULL, 'Ramen Tonkotsu',
 (SELECT id_emoji FROM emojis WHERE img = '🍜' LIMIT 1),
 'images/ramen.jpg',
 (SELECT id_category FROM categories WHERE name = 'Japonais' LIMIT 1),
 45, 620, 5, 'Ramen crémeux au bouillon de porc'),

(NULL, 'Pizza Margherita',
 (SELECT id_emoji FROM emojis WHERE img = '🍕' LIMIT 1),
 'images/pizza.jpg',
 (SELECT id_category FROM categories WHERE name = 'Italien' LIMIT 1),
 30, 540, 5, 'Pizza italienne classique'),

(NULL, 'Tacos al Pastor',
 (SELECT id_emoji FROM emojis WHERE img = '🌮' LIMIT 1),
 'images/tacos.jpg',
 (SELECT id_category FROM categories WHERE name = 'Mexicain' LIMIT 1),
 20, 480, 5, 'Tacos mexicains au porc mariné'),

(NULL, 'Pad Thaï',
 (SELECT id_emoji FROM emojis WHERE img = '🍝' LIMIT 1),
 'images/padthai.jpg',
 (SELECT id_category FROM categories WHERE name = 'Thaïlandais' LIMIT 1),
 25, 550, 5, 'Nouilles sautées thaïlandaises'),

(NULL, 'Burger Smash',
 (SELECT id_emoji FROM emojis WHERE img = '🍔' LIMIT 1),
 'images/burger.jpg',
 (SELECT id_category FROM categories WHERE name = 'Américain' LIMIT 1),
 15, 750, 5, 'Burger américain croustillant'),

(NULL, 'Sushi Omakase',
 (SELECT id_emoji FROM emojis WHERE img = '🍣' LIMIT 1),
 'images/sushi.jpg',
 (SELECT id_category FROM categories WHERE name = 'Japonais' LIMIT 1),
 60, 420, 5, 'Sélection de sushis japonais'),

(NULL, 'Shakshuka',
 (SELECT id_emoji FROM emojis WHERE img = '🍳' LIMIT 1),
 'images/shakshuka.jpg',
 (SELECT id_category FROM categories WHERE name = 'Oriental' LIMIT 1),
 20, 390, 5, 'Oeufs pochés dans une sauce tomate épicée'),

(NULL, 'Crêpe Suzette',
 (SELECT id_emoji FROM emojis WHERE img = '🥞' LIMIT 1),
 'images/crepes.jpg',
 (SELECT id_category FROM categories WHERE name = 'Français' LIMIT 1),
 15, 310, 5, 'Crêpe sucrée flambée à l''orange'),

(NULL, 'Biryani d''agneau',
 (SELECT id_emoji FROM emojis WHERE img = '🍚' LIMIT 1),
 'images/biryani.jpg',
 (SELECT id_category FROM categories WHERE name = 'Indien' LIMIT 1),
 90, 680, 5, 'Riz épicé à l''agneau indien'),

(NULL, 'Poke Bowl Saumon',
 (SELECT id_emoji FROM emojis WHERE img = '🥗' LIMIT 1),
 'images/pokebowl.jpg',
 (SELECT id_category FROM categories WHERE name = 'Hawaïen' LIMIT 1),
 10, 490, 5, 'Bol hawaïen au saumon frais'),

(NULL, 'Couscous Royal',
 (SELECT id_emoji FROM emojis WHERE img = '🍲' LIMIT 1),
 'images/couscous.jpg',
 (SELECT id_category FROM categories WHERE name = 'Maghrébin' LIMIT 1),
 75, 720, 5, 'Couscous maghrébin avec viandes'),

(NULL, 'Tiramisu',
 (SELECT id_emoji FROM emojis WHERE img = '🍮' LIMIT 1),
 'images/tiramisu.jpg',
 (SELECT id_category FROM categories WHERE name = 'Dessert' LIMIT 1),
 20, 380, 5, 'Dessert italien au mascarpone');

-- Reset foreign key checks
SET FOREIGN_KEY_CHECKS = 1;