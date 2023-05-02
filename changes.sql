-- CR no need for ``
-- no need for blog, just name the table name. example:
-- CREATE TABLE connection_type (
--     id                   MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     name                 VARCHAR(255) NOT NULL,
--     fast                 TINYINT(1) NULL
-- ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- Created at, we use this:      created_at          TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
CREATE TABLE `blog`.`new_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NULL,
  `password` VARCHAR(100) NULL,
  `created_at` DATETIME NULL,
  `last_login` DATETIME NULL,
  PRIMARY KEY (`id`)
);


-- We use this format for update
-- UPDATE locations SET country = 'China', city= 'Hong Kong' WHERE id > 0 and category = 'Charging Station' and country='Hong Kong';
INSERT INTO users (username, password, created_at, last_login)
VALUES ('a@yahoo.com', 'aaa', CURRENT_TIMESTAMP , '2023-05-02 12:34:02');



ALTER TABLE users
ADD address VARCHAR(100);

