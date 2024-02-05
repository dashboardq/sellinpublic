<?php

// Up
$up = function($db) {
    $sql = $db->createTable('posts', [
        'id' => 'id',
        'user_id' => 'id',
        'post' => 'string',
        'content' => 'text',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'published_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('posts');
    $db->query($sql);
};
