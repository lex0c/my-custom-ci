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


INSERT INTO users(name, lastname, email, password, updated_at) VALUES ('Léo', 'Castro', 'leonardo_carvalho@outlook.com', '5JjVR9SSxMDRwcGTFFXZONGdRVHNSRmNO9kcWdlMkITYkADOk0kaBJjTUVFNNRVW08ERVRjTyUkMNV2L', '2017-01-28 13:28:40');
