CREATE DATABASE address CHARSET = UTF8 COLLATE = utf8_general_ci;
USE address;

CREATE TABLE `countries` (
    `id`            smallint(3)     UNSIGNED NOT NULL AUTO_INCREMENT,
    `code_a2`       char(2)         NOT NULL,
    `code_a3`       char(3)         NOT NULL,
    `code_number`   char(3)         NOT NULL,
    `name_en`       varchar(60)     NOT NULL,
    `name_local`    varchar(60),
    PRIMARY KEY (`id`)
);

CREATE TABLE `states` (
    `id`            int(10)         UNSIGNED NOT NULL AUTO_INCREMENT,
    `country`       smallint(3)     UNSIGNED NOT NULL,
    `code`          varchar(3)      NOT NULL,
    `name`          varchar(60)     NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`country`) REFERENCES `countries` (`id`)
);

CREATE TABLE `counties` (
    `id`            int(10)         UNSIGNED NOT NULL AUTO_INCREMENT,
    `state`         int(10)         UNSIGNED NOT NULL,
    `name`          varchar(60)     NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`state`) REFERENCES `states` (`id`)
);
