<?php

// Up
$up = function($db) {
    $sql = $db->createTable('media', [
        'id' => 'id',
        'user_id' => 'id',
        'upload_id' => 'id',
        'file_location' => 'string',
        'url_location' => 'string',
        'type' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('media');
    $db->query($sql);
};
