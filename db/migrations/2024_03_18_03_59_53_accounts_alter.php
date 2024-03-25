<?php

// Up
$up = function($db) {
    $sql = $db->alterTableAdd('accounts', [
        'media_id' => ['type' => 'integer', 'default' => 0, 'after' => 'user_id'],
    ]);
    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->alterTableDrop('accounts', [
        'media_id',
    ]);
    $db->query($sql);
};
