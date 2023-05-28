CREATE TABLE users(
    id          int NOT NULL AUTO_INCREMENT,
    username    varchar(100),
    password    varchar(100),
    fname       VARCHAR(100) DEFAULT NULL,
    created_at  datetime,
    last_login  timestamp,
    PRIMARY KEY(id)
);