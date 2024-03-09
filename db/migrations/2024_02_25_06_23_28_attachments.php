<?php

// Up
$up = function($db) {
    $sql = $db->createTable('attachments', [
        'id' => 'id',
        'user_id' => 'id',
        'post_id' => 'id',
        'item_id' => 'id',
        'type' => 'string',
        'content' => 'text',
        'sort_order' => ['type' => 'integer', 'default' => 0],
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('attachments');
    $db->query($sql);
};
