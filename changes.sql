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


-- 2023-06-04 Diana, altered users table with NOT NULL and DEFAULT NULL values
ALTER TABLE users MODIFY COLUMN username	VARCHAR(100) NOT NULL;
ALTER TABLE users MODIFY COLUMN password	VARCHAR(100) NOT NULL;
ALTER TABLE users MODIFY COLUMN created_at	VARCHAR(100) NOT NULL;
ALTER TABLE users MODIFY COLUMN last_login	VARCHAR(100) DEFAULT NULL;

-- 2023-06-04 Diana, create and init posts table
CREATE TABLE posts(
    post_id	INT NOT NULL AUTO_INCREMENT,
    user_id	INT NOT NULL,
    title	VARCHAR(255) NOT NULL,
    body    TEXT DEFAULT NULL,
    PRIMARY KEY(post_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
