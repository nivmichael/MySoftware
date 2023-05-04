
CREATE TABLE users (
  id            MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  username      VARCHAR(100) NULL,
  password      VARCHAR(100) NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_login    DATETIME NULL,
  PRIMARY KEY (id)
);


INSERT INTO users (username, password)
VALUES ('a@yahoo.com', 'aaa');


ALTER TABLE users
ADD address VARCHAR(100);


CREATE TABLE posts(    
   id           MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,    
   user_id      MEDIUMINT UNSIGNED NOT NULL,    
   title        VARCHAR(100) NOT NULL,    
   body         TEXT NOT NULL,    
   file_path    VARCHAR(255),    
   PRIMARY KEY ( id ),
   FOREIGN KEY (user_id) REFERENCES users(id)
);