<?php

// Up
$up = function($db) {
    $sql = $db->alterTableAdd('posts', [
        'original_id' => ['type' => 'id', 'after' => 'user_id'],
        'parent_id' => ['type' => 'id', 'after' => 'user_id'],
        'conversation_id' => ['type' => 'id', 'after' => 'user_id'],
        'reactions' => ['type' => 'integer', 'default' => 0, 'after' => 'status'],
        'flags' => ['type' => 'integer', 'default' => 0, 'after' => 'status'],
        'stars' => ['type' => 'integer', 'default' => 0, 'after' => 'status'],
        'quotes' => ['type' => 'integer', 'default' => 0, 'after' => 'status'],
        'reposts' => ['type' => 'integer', 'default' => 0, 'after' => 'status'],
        'replies' => ['type' => 'integer', 'default' => 0, 'after' => 'status'],
        'standing_calculated' => ['type' => 'boolean', 'default' => 0, 'after' => 'status'],
        'sort_order' => ['type' => 'string', 'default' => '', 'after' => 'status'],
        'depth' => ['type' => 'integer', 'default' => 0, 'after' => 'status'],
        'type' => ['type' => 'string', 'after' => 'status'],
        'sorted_at' => ['type' => 'datetime'],
    ]);
    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->alterTableDrop('posts', [
        'original_id',
        'parent_id',
        'conversation_id',
        'reactions',
        'flags',
        'stars',
        'quotes',
        'reposts',
        'replies',
        'standing_calculated',
        'sort_order',
        'depth',
        'type',
        'sorted_at',
    ]);
    $db->query($sql);
};
