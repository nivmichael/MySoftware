CREATE TABLE `blog`.`new_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NULL,
  `password` VARCHAR(100) NULL,
  `created_at` DATETIME NULL,
  `last_login` DATETIME NULL,
  PRIMARY KEY (`id`)
);



INSERT INTO users (username, password, created_at, last_login)
VALUES ('a@yahoo.com', 'aaa', CURRENT_TIMESTAMP , '2023-05-02 12:34:02');



ALTER TABLE users
ADD address VARCHAR(100);

