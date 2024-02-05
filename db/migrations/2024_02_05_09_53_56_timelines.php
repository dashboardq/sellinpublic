<?php

// Up
$up = function($db) {
    $sql = $db->createTable('timelines', [
        'id' => 'id',
        'user_id' => 'id',
        'post_id' => 'id',
        'author_id' => 'id',
        'sort_order' => ['type' => 'integer', 'default' => 0],
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('timelines');
    $db->query($sql);
};
