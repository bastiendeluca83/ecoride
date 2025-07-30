-- Suppression si existant
DROP TABLE IF EXISTS rides;
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS admins;

-- Table admins (créé manuellement, pas d'inscription possible)
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Ajout d'un admin par défaut : admin / test123
INSERT INTO admins (username, password)
VALUES ('admin', 'test123');

-- Table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    credits INT DEFAULT 20,
    role ENUM('user', 'admin', 'employe') DEFAULT 'user',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ajout admin dans users : admin@ecoride.com / admin123
INSERT INTO users (pseudo, email, password, role)
VALUES (
    'AdminEco',
    'admin@ecoride.com',
    '$2y$10$e0NRffQaeVWgHkQvKZ2h0e9.Ty3MXkl6tsnEPI8edFEUVaU4cH1nW',
    'admin'
);

-- Table employees
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    suspended BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table rides (trajets effectués)
CREATE TABLE IF NOT EXISTS rides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date DATE NOT NULL,
    credits INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);





