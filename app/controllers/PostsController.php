<?php

namespace app\controllers;

use app\models\Post;
use app\models\Username;

use app\services\APIService;

use DateTime;

class PostsController {
    public function add($req, $res) {
        $usernames = Username::where('user_id', $req->user->data['id']);

        // First time logging in, make sure they have a username
        if(count($usernames) == 0) {    
            $res->redirect('/username/add');
        }

        try {
            $response = APIService::call('/account', [], $req, $res);
        } catch(Exception $e) {
            $res->error($e->getMessage());
        }

        $delay = $response['data']['delay_post'];

        //$res->view('main/home');
        return compact('delay');
    }

    public function create($req, $res) {
        $rules = [];
        $rules['post'] = ['required', ['maxLength' => 240]];
        $rules['attachment_count'] = ['required', 'integer'];

        $pass1 = $req->val('data', $rules);

        for($i = 0; $i < $pass1['attachment_count']; $i++) {
            $rules['attachment_type_' . $i] = ['required', ['in' => ['text']]];
        }

        $pass2 = $req->val('data', $rules);

        for($i = 0; $i < $pass1['attachment_count']; $i++) {
            if($pass2['attachment_type_' . $i] == 'text') {
                $rules['attachment_text_' . $i] = ['required'];
            }
        }

        $data = $req->val('data', $rules);

        try {
            $response = APIService::call('/post', $data, $req, $res);
        } catch(Exception $e) {
            $res->error($e->getMessage());
        }

        $res->success($response['messages'][0], '/pending');
    }

    public function pending($req, $res) {
        /*
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 10;

        $args = [];
        $args['user_id'] = $req->user_id;
        $args['status'] = 'pending';

        $posts = Post::where($args, [$per_page, $page]);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        return compact('pagination', 'posts');
*/
        try {
            $response = APIService::call('/pending', [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        $pagination = $response['meta']['pagination'];
        $posts = $response['data'];

        return compact('pagination', 'posts');
    }

    public function post($req, $res) {
        try {
            $response = APIService::call('/post/children/' . $req->params['post_id'], [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        $pagination = $response['meta']['pagination'];
        $posts = $response['data'];

        return compact('pagination', 'posts');
    }

    public function reply($req, $res) {
        $usernames = Username::where('user_id', $req->user->data['id']);

        // First time logging in, make sure they have a username
        if(count($usernames) == 0) {    
            $res->redirect('/username/add');
        }

        try {
            $response = APIService::call('/post/single/' . $req->params['post_id'], [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        $posts = $response['data'];

        try {
            $response = APIService::call('/account', [], $req, $res);
        } catch(Exception $e) {
            $res->error($e->getMessage());
        }

        $delay = $response['data']['delay_post'];

        return compact('delay', 'posts');
    }

    public function replySave($req, $res) {
        $data = $req->val('data', [
            'post' => ['required'],
            'content' => ['optional'],
        ]);

        $rules = [];
        $rules['post'] = ['required'];
        $rules['attachment_count'] = ['required', 'integer'];

        $pass1 = $req->val('data', $rules);

        for($i = 0; $i < $pass1['attachment_count']; $i++) {
            $rules['attachment_type_' . $i] = ['required', ['in' => ['text']]];
        }

        $pass2 = $req->val('data', $rules);

        for($i = 0; $i < $pass1['attachment_count']; $i++) {
            if($pass2['attachment_type_' . $i] == 'text') {
                $rules['attachment_text_' . $i] = ['required'];
            }
        }

        $data = $req->val('data', $rules);
        $data['parent_id'] = $req->params['post_id'];

        try {
            $response = APIService::call('/post', $data, $req, $res);
        } catch(Exception $e) {
            $res->error($e->getMessage());
        }

        $res->success($response['messages'][0], '/thread/' . $response['data']['conversation_id']);
    }
}
