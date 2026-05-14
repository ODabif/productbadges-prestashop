<?php
return [
    'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'productbadges` (
        `id_productbadge`   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `active`            TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
        `background_color`  VARCHAR(7) NOT NULL DEFAULT \'#000000\',
        `text_color`        VARCHAR(7) NOT NULL DEFAULT \'#FFFFFF\',
        `position`          INT(10) UNSIGNED NOT NULL DEFAULT 0,
        `date_add`          DATETIME NOT NULL,
        `date_upd`          DATETIME NOT NULL,
        PRIMARY KEY (`id_productbadge`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',

    'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'productbadges_lang` (
        `id_productbadge`   INT(10) UNSIGNED NOT NULL,
        `id_lang`           INT(10) UNSIGNED NOT NULL,
        `text`              VARCHAR(255) NOT NULL,
        PRIMARY KEY (`id_productbadge`, `id_lang`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',

    'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'productbadges_product` (
        `id_productbadge`   INT(10) UNSIGNED NOT NULL,
        `id_product`        INT(10) UNSIGNED NOT NULL,
        PRIMARY KEY (`id_productbadge`, `id_product`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
];