<?php

// Up
$up = function($db) {
    $sql = $db->createTable('uploads', [
        'id' => 'id',
        'user_id' => 'id',
        'name' => 'string',
        'extension' => 'string',
        'file_location' => 'string',
        'total_bytes' => ['type' => 'integer', 'default' => 0],
        'current_bytes' => ['type' => 'integer', 'default' => 0],
        'total_chunks' => ['type' => 'integer', 'default' => 0],
        'current_chunks' => ['type' => 'integer', 'default' => 0],
        'file_type' => 'string',
        'upload_type' => 'string',
        'original_name' => 'string',
        'original_extension' => 'string',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expired_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('uploads');
    $db->query($sql);
};
