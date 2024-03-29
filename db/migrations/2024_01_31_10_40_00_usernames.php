<?php

// Up
$up = function($db) {
    /*
    $sql = <<<'SQL'
CREATE TABLE `usernames` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint unsigned NOT NULL DEFAULT '0',
    `name` varchar(255) NOT NULL DEFAULT '',
    `primary` tinyint(1) NOT NULL DEFAULT '0',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
);
SQL;
*/

    $sql = $db->createTable('usernames', [
        'id' => 'id',
        'user_id' => 'id',
        'name' => 'string',
        'primary' => ['type' => 'boolean', 'default' => 0],
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);
    $db->query($sql);
};

// Down
$down = function($db) {
    /*
    $sql = <<<'SQL'
DROP TABLE `usernames`;
SQL;
*/

    $sql = $db->dropTable('usernames');
    $db->query($sql);

};
