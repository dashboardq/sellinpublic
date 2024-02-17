<?php

namespace app\controllers;

use app\models\Post;
use app\models\Username;

use app\services\APIService;

use DateTime;

class APIPostsController {
    public function latest($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['status'] = 'published';

        $posts = Post::where($args, [$per_page, $page]);
        $posts = APIService::clean($posts);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = data($posts);
        return $output;
    }

    public function pending($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['user_id'] = $req->user_id;
        $args['status'] = 'pending';

        $posts = Post::where($args, [$per_page, $page]);
        $posts = APIService::clean($posts);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        //$output['meta'] = meta($pagination);
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = data($posts);
        return $output;
    }

    public function create($req, $res) {
        $val = $req->val($req->data, [
            'post' => ['required'],
            'content' => ['optional'],
        ]);

        $delay = '48 hours';

        $published_at = new DateTime();
        $published_at->modify('+' . $delay);

        $val['user_id'] = $req->user_id;
        $val['username_id'] = $req->user->account->username;
        $val['status'] = 'pending';
        $val['published_at'] = $published_at;

        $post = Post::create($val);

        return success('Thank you for submitting your post. It will be publicly displayed in ' . $delay . '. New accounts have a delay in publishing to help protect against spam.');
    }
}
