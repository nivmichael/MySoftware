-- This file registers all queries chronologically 
-- 2023-05-28 Diana, create and init users table
CREATE TABLE users(
    id          int NOT NULL AUTO_INCREMENT,
    username    varchar(100),
    password    varchar(100),
    created_at  datetime,
    last_login  timestamp,
    PRIMARY KEY(id)
);

INSERT INTO users (username, password, created_at)
VALUES ("admin", "1234", NOW());

-- 2023-05-31 Diana, add address to users
ALTER TABLE users ADD address VARCHAR (100) DEFAULT NULL AFTER password;

