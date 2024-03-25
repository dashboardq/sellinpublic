<?php

// Up
$up = function($db) {
    $sql = $db->alterTableDrop('posts', [
        'content',
    ]);
    $db->query($sql);

    $sql = $db->alterTableAdd('posts', [
        'attachment_count' => ['type' => 'integer', 'default' => 0, 'after' => 'standing_calculated'],
    ]);
    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->alterTableDrop('posts', [
        'attachment_count',
    ]);
    $db->query($sql);

    $sql = $db->alterTableAdd('posts', [
        'content' => ['type' => 'text', 'after' => 'post'],
    ]);
    $db->query($sql);
};
