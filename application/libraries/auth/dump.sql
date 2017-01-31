DROP TABLE IF EXISTS 'users';
CREATE TABLE users (
    id INT unsigned AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    lastname VARCHAR(100),
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(80) NOT NULL,
    remember_token VARCHAR(80),
    created_at TIMESTAMP,
    updated_at TIMESTAMP

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
