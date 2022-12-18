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
-- Rotem 2022-12-12
ALTER TABLE users ADD COLUMN name VARCHAR(100) AFTER password;
CREATE TABLE posts(    
   id INT NOT NULL AUTO_INCREMENT,    
   username VARCHAR(100) NOT NULL,    
   title VARCHAR(100) NOT NULL,    
   body TEXT NOT NULL,    
   file_name VARCHAR(255),    
   uploaded_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,    
   PRIMARY KEY ( id ) 
);
ALTER TABLE posts ADD COLUMN user_id INT AFTER id;
ALTER TABLE posts DROP COLUMN username;
ALTER TABLE posts ADD FOREIGN KEY (user_id) REFERENCES users(id);
-- Rotem 2022-12-13
delete all tables above
CREATE TABLE users(
   id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
   username     VARCHAR(50) UNIQUE NOT NULL,
   password     VARCHAR(50) NOT NULL,
   name         VARCHAR(50) NOT NULL,
   address      VARCHAR(100),
   created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   last_login   TIMESTAMP NULL,
   PRIMARY KEY ( id )
);
CREATE TABLE posts(    
   id           INT UNSIGNED NOT NULL AUTO_INCREMENT,    
   user_id      INT UNSIGNED NOT NULL,    
   title        VARCHAR(100) NOT NULL,    
   body         TEXT NOT NULL,    
   file_path    VARCHAR(255),    
   uploaded_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,    
   PRIMARY KEY ( id ),
   FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE INDEX user_id_index
ON posts (user_id);


