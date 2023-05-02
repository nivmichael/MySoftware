-- CR no need for ``
-- no need for blog, just name the table name. example:
-- CREATE TABLE connection_type (
--     id                   MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     name                 VARCHAR(255) NOT NULL,
--     fast                 TINYINT(1) NULL
-- ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- Created at, we use this:      created_at          TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
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

