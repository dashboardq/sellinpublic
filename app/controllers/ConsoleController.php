<?php

namespace app\controllers;

use app\models\Post;
use app\models\Timeline;

class ConsoleController {
    public function process($in, $out) {
        $args = [];
        $args['status'] = 'pending';
        $args['published_at'] = ['<', now()];
        $posts = Post::where($args);

        $out->write('Starting to process: ' . count($posts) . ' posts', 'green');

        foreach($posts as $i => $post) {
            $post->publish();
            $out->write(($i + 1) . '. Processing post: ' . $post->id, 'green');
        }

        $out->write('Processing complete.', 'green');
    }
}
