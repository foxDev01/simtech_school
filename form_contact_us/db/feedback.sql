-- Схема базы данных для формы обратной связи.
-- Импортируйте этот файл через phpMyAdmin (вкладка "Импорт").

CREATE DATABASE IF NOT EXISTS `form_contact_us`
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE `form_contact_us`;

CREATE TABLE IF NOT EXISTS `feedback` (
    `id`       INT(11)      NOT NULL AUTO_INCREMENT,
    `fname`    VARCHAR(255) NOT NULL,
    `lname`    VARCHAR(255) NOT NULL,
    `email`    VARCHAR(255) NOT NULL,
    `tel`      VARCHAR(50)  NOT NULL,
    `tim`      VARCHAR(100) NOT NULL,
    `occasion` VARCHAR(100) NOT NULL,
    `files`    VARCHAR(255) NOT NULL DEFAULT '',
    `msg`      TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
