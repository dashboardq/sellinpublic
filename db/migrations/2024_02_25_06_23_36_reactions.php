<?php

// Up
$up = function($db) {
    $sql = $db->createTable('reactions', [
        'id' => 'id',
        'user_id' => 'id',
        'post_id' => 'id',
        'type' => 'string',
        'content' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('reactions');
    $db->query($sql);
};
