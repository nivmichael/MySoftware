CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `last_login` TIMESTAMP
    PRIMARY KEY (`id`)
);

INSERT INTO
    `users` (username, password)
VALUES
    ('testUser', 'password');