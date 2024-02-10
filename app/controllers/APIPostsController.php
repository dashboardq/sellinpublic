<?php

namespace app\controllers;

use app\models\Post;
use app\models\Username;

use DateTime;

class APIPostsController {
    public function latest($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 10;

        $args = [];
        $args['status'] = 'published';

        $posts = Post::where($args, [$per_page, $page]);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['meta'] = meta($pagination);
        $output['data'] = data($posts);
        dd($output);
        return compact('pagination', 'posts');
    }
}
