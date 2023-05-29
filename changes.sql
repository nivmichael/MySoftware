CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `last_login` TIMESTAMP PRIMARY KEY (`id`)
);

INSERT INTO
    `users` (username, password)
VALUES
    ('testUser', 'password');

INSERT INTO
    `users` (username, password)
VALUES
    ('auser', 'apassword');

-- created by Shahar at 24-5
CREATE TABLE `blogs` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(100) NOT NULL,
    `text` VARCHAR(100) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `user_id` INT,
    PRIMARY KEY (`id`)
);

ALTER TABLE
    `blogs`
ADD
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

INSERT INTO
    `blogs` (title, text, user_id)
VALUES
    (
        'tititititititititititle',
        'texttstdtstststststst',
        1
    );

-- created by Shahar at 29-5
ALTER TABLE
    blogs
ADD
    `file_ext` varchar(100);