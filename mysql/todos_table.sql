CREATE TABLE `todos` (
    `todo_id` VARCHAR(36) PRIMARY KEY NOT NULL,
    `message` LONGTEXT NOT NULL,
    `status` ENUM('pending', 'done') DEFAULT 'pending' NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME DEFAULT NULL
) ENGINE="InnoDb" CHARACTER SET="utf8";
