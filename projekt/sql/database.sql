CREATE DATABASE IF NOT EXISTS dinamo_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dinamo_shop;

-- USERS
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100),
    password VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- PRODUCTS
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    stock INT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, price, stock, image) VALUES
('Dinamo Home 2024', 'Plavi domaći dres GNK Dinamo za sezonu 2024/2025.', 89.99, 50, 'dres_home.jpg'),
('Dinamo Away 2024', 'Bijeli gostujući dres Dinama, premium kvaliteta.', 89.99, 40, 'dres_away.jpg'),
('Šal Dinamo', 'Originalni šal GNK Dinamo Zagreb.', 14.99, 100, 'sal.jpg'),
('Kapa Dinamo', 'Zimska kapa sa Dinamovim grbom.', 19.99, 80, 'kapa.jpg'),
('Privjesak Dinamo', 'Metalni privjesak s Dinamo logotipom.', 6.99, 200, 'privjesak.jpg'),
('Hoodie Dinamo', 'Plava dukserica s Dinamo printom.', 49.99, 30, 'hoodie.jpg');


-- ORDERS (log)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

