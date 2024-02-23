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
        $posts = APIService::cleanPosts($posts);
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
        $posts = APIService::cleanPosts($posts);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        //$output['meta'] = meta($pagination);
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = data($posts);
        return $output;
    }

    public function timelineUser($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $username = Username::by('name', $req->params['username']);
        if(!$username) {
            return APIService::error('The user is not available.');
        }

        $args = [];
        $args['status'] = 'published';
        $args['user_id'] = $username->data['user_id'];

        $posts = Post::where($args, [$per_page, $page]);
        $posts = APIService::cleanPosts($posts);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
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

        $data = [];
        $data['id'] = $post->id;
        $data['user_id'] = $req->user_id;
        $data['post'] = $post->data['post'];
        $data['status'] = $post->data['status'];
        $data['created_at'] = $post->data['created_at']->format('c');
        $data['updated_at'] = $post->data['updated_at']->format('c');
        $data['published_at'] = $post->data['published_at']->format('c');
        $data['username'] = $req->user->data['account']['username']['name'];
        $data['display_name'] = $req->user->data['account']['display_name'];
        $data['bio'] = $req->user->data['account']['bio'];

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = ['Thank you for submitting your post. It will be publicly displayed in ' . $delay . '. New accounts have a delay in publishing to help protect against spam.'];
        $output['meta'] = new \stdClass();
        $output['data'] = $data;
        return $output;
    }

    public function children($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['id'] = $req->params['post_id'];
        $args['status'] = 'published';

        $posts = Post::where($args, [$per_page, $page]);
        $posts = APIService::cleanPosts($posts);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        // If no posts, check if it is not published but is owned by the user.


        // Get all the published replies


        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = data($posts);
        return $output;
    }

    public function single($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['id'] = $req->params['post_id'];
        $args['status'] = 'published';

        $posts = Post::where($args, [$per_page, $page]);
        $posts = APIService::cleanPosts($posts);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        // If no posts, check if it is not published but is owned by the user.

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = data($posts);
        return $output;
    }
}
