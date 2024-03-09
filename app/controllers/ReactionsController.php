<?php

namespace app\controllers;

use app\models\Post;
use app\models\Username;

use app\services\APIService;

use DateTime;

class ReactionsController {
    public function flag($req, $res) {
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

        return compact('posts');
    }

    public function flagsAll($req, $res) {
        try {
            $response = APIService::call('/reactions/flags/all', [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        $pagination = $response['meta']['pagination'];
        $reactions = $response['data'];

        return compact('pagination', 'reactions');
    }

    public function flagsPost($req, $res) {
        try {
            $res_post = APIService::call('/post/single/' . $req->params['post_id'], [], $req, $res);
            $response = APIService::call('/reactions/flags/' . $req->params['post_id'], [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        if(!isset($res_post['data'][0])) {
            $res->error('The requested post does not appear to exist.');
            exit;
        }

        $post = $res_post['data'][0];
        $pagination = $response['meta']['pagination'];
        $reactions = $response['data'];

        return compact('pagination', 'post', 'reactions');
    }

    public function flagSave($req, $res) {
        try {
            $response = APIService::call('/post/' . $req->params['post_id'] . '/flag', ['method' => 'POST'], $req, $res);
        } catch(Exception $e) {
            $res->error($e->getMessage());
        }

        // The conversation_id should always be set going forward but it was not always set at the beginning.
        if($req->ajax) {
            return ['status' => 'success'];
        } else {
            if($response['data']['conversation_id']) {
                $res->redirect('/thread/' . $response['data']['conversation_id']);
            } else {
                $res->redirect('/thread/' . $response['data']['id']);
            }
        }
    }

    public function stars($req, $res) {
        try {
            $response = APIService::call('/reactions/stars', [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        $pagination = $response['meta']['pagination'];
        $reactions = $response['data'];

        return compact('pagination', 'reactions');
    }

    public function starsAll($req, $res) {
        try {
            $response = APIService::call('/reactions/stars/all', [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        $pagination = $response['meta']['pagination'];
        $reactions = $response['data'];

        return compact('pagination', 'reactions');
    }

    public function starsPost($req, $res) {
        try {
            $res_post = APIService::call('/post/single/' . $req->params['post_id'], [], $req, $res);
            $response = APIService::call('/reactions/stars/' . $req->params['post_id'], [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        if(!isset($res_post['data'][0])) {
            $res->error('The requested post does not appear to exist.');
            exit;
        }

        $post = $res_post['data'][0];
        $pagination = $response['meta']['pagination'];
        $reactions = $response['data'];

        return compact('pagination', 'post', 'reactions');
    }

    public function star($req, $res) {
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

        return compact('posts');
    }

    public function starSave($req, $res) {
        try {
            $response = APIService::call('/post/' . $req->params['post_id'] . '/star', ['method' => 'POST'], $req, $res);
        } catch(Exception $e) {
            $res->error($e->getMessage());
        }

        // The conversation_id should always be set going forward but it was not always set at the beginning.
        if($req->ajax) {
            return ['status' => 'success'];
        } else {
            if($response['data']['conversation_id']) {
                $res->redirect('/thread/' . $response['data']['conversation_id']);
            } else {
                $res->redirect('/thread/' . $response['data']['id']);
            }
        }
    }

    public function unflag($req, $res) {
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

        return compact('posts');
    }

    public function unflagSave($req, $res) {
        try {
            $response = APIService::call('/post/' . $req->params['post_id'] . '/unflag', ['method' => 'POST'], $req, $res);
        } catch(Exception $e) {
            $res->error($e->getMessage());
        }

        // The conversation_id should always be set going forward but it was not always set at the beginning.
        if($req->ajax) {
            return ['status' => 'success'];
        } else {
            if($response['data']['conversation_id']) {
                $res->redirect('/thread/' . $response['data']['conversation_id']);
            } else {
                $res->redirect('/thread/' . $response['data']['id']);
            }
        }
    }

    public function unstar($req, $res) {
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

        return compact('posts');
    }

    public function unstarSave($req, $res) {
        try {
            $response = APIService::call('/post/' . $req->params['post_id'] . '/unstar', ['method' => 'POST'], $req, $res);
        } catch(Exception $e) {
            $res->error($e->getMessage());
        }

        // The conversation_id should always be set going forward but it was not always set at the beginning.
        if($req->ajax) {
            return ['status' => 'success'];
        } else {
            if($response['data']['conversation_id']) {
                $res->redirect('/thread/' . $response['data']['conversation_id']);
            } else {
                $res->redirect('/thread/' . $response['data']['id']);
            }
        }
    }

}
