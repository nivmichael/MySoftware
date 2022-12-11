-- Rotem 2022-12-07
CREATE DATABASE blog;
use blog;
CREATE TABLE users(
   id INT NOT NULL AUTO_INCREMENT,
   username VARCHAR(100) NOT NULL,
   password VARCHAR(100) NOT NULL,
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   last_login TIMESTAMP null,
   PRIMARY KEY ( id )
);
INSERT INTO users (username, password) VALUES ('rotem@makemydayapp.com', 'rotem123');
INSERT INTO users (username, password) VALUES ('xx@gmail.com', 'xx');
ALTER TABLE users ADD COLUMN address VARCHAR(100) AFTER password;