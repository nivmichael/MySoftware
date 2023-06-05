CREATE TABLE users(
    id          INT NOT NULL AUTO_INCREMENT,
    username    VARCHAR(100) NOT NULL,
    password    VARCHAR(100) NOT NULL,
    created_at  DATETIME NOT NULL,
    last_login  TIMESTAMP DEFAULT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE posts(
    post_id	INT NOT NULL AUTO_INCREMENT,
    user_id	INT NOT NULL,
    title	VARCHAR(255) NOT NULL,
    body    TEXT DEFAULT NULL,
    PRIMARY KEY(post_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);