<?php

// Up
$up = function($db) {
    $sql = $db->createTable('notifications', [
        'id' => 'id',
        'receiver_id' => 'id',
        'receiver_post_id' => 'id',
        'initiator_id' => 'id',
        'initiator_post_id' => 'id',
        'type' => 'string',
        'status' => 'string',
        'content' => 'text',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('notifications');
    $db->query($sql);
};
