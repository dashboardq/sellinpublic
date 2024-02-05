<?php

namespace app\controllers;

use app\models\Post;
use app\models\Username;

use DateTime;

class PostsController {
    public function post($req, $res) {
       $usernames = Username::where('user_id', $req->user->data['id']);
      
        // First time logging in, make sure they have a username
        if(count($usernames) == 0) {    
            $res->redirect('/username/add');
        }

        //$res->view('main/home');
        return [];
    }

    public function postPost($req, $res) {
        $val = $req->val($req->data, [
            'post' => ['required'],
            'content' => ['optional'],
        ]);

        $username = Username::primary($req->user_id);
        $published_at = new DateTime();
        $published_at->modify('+48 hours');

        $val['user_id'] = $req->user_id;
        $val['username_id'] = $username->id;
        $val['status'] = 'pending';
        $val['published_at'] = $published_at;

        $post = Post::create($val);

        $res->success('Thank you for submitting your post. It will be publicly displayed in 48 hours. New accounts have a delay in publishing to help protect against spam.', '/pending');
    }

    public function pending($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 10;

        $args = [];
        $args['user_id'] = $req->user_id;
        $args['status'] = 'pending';

        $posts = Post::where($args, [$per_page, $page]);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        return compact('pagination', 'posts');
    }
}
