<?php

// Up
$up = function($db) {
    $sql = $db->createTable('accounts', [
        'id' => 'id',
        'user_id' => 'id',
        'display_name' => 'string',
        'bio' => 'text',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('accounts');
    $db->query($sql);
};
