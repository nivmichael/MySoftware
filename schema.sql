CREATE TABLE users(
    id          int NOT NULL AUTO_INCREMENT,
    username    varchar(100) NOT NULL,
    password    varchar(100) NOT NULL,
    created_at  datetime NOT NULL,
    last_login  timestamp DEFAULT NULL,
    PRIMARY KEY(id)
);