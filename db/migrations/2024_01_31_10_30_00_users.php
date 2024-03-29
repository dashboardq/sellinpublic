<?php

// Up
$up = function($db) {
    /*
    $sql = <<<'SQL'
CREATE TABLE `users` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `data` longtext,
    `encrypted` tinyint(1) NOT NULL DEFAULT '0',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
);
SQL;
*/
    $sql = $db->createTable('users', [
        'id' => 'id',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'data' => 'text',
        'encrypted' => ['type' => 'boolean', 'default' => 0],
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);
    $db->query($sql);
};

// Down
$down = function($db) {
    /*
    $sql = <<<'SQL'
DROP TABLE `users`;
SQL;
*/
    $sql = $db->dropTable('users');
    $db->query($sql);

};

