<?php

// Up
$up = function($db) {
    $sql = $db->alterTableModify('posts', [
        'post' => 'text',
    ]);
    $db->query($sql);


    $sql = $db->alterTableAdd('posts', [
        'bumps' => ['type' => 'integer', 'after' => 'reactions'],
    ]);
    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->alterTableModify('posts', [
        'post' => 'string',
    ]);
    $db->query($sql);


    $sql = $db->alterTableDrop('posts', [
        'bumps',
    ]);
    $db->query($sql);
};
