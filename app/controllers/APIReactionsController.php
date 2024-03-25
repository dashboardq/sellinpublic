<?php

namespace app\controllers;

use app\models\Post;
use app\models\Reaction;
use app\models\Setting;
use app\models\Username;

use app\services\APIService;

use DateTime;

class APIReactionsController {
    public function flag($req, $res) {
        Reaction::flag($req->params['post_id'], $req->user_id);

        $post = Post::find($req->params['post_id']);

        $data = [];
        $data['id'] = $post->id;
        $data['user_id'] = $req->user_id;
        $data['conversation_id'] = $post->data['conversation_id'];
        $data['parent_id'] = $post->data['parent_id'];
        $data['original_id'] = $post->data['original_id'];
        $data['post'] = $post->data['post'];
        $data['status'] = $post->data['status'];
        $data['created_at'] = $post->data['created_at']->format('c');
        $data['updated_at'] = $post->data['updated_at']->format('c');
        $data['published_at'] = $post->data['published_at']->format('c');
        $data['username'] = $req->user->data['account']['username']['username'];
        $data['display_name'] = $req->user->data['account']['display_name'];
        $data['bio'] = $req->user->data['account']['bio'];

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = $data;
        return $output;
    }

    public function flagsAll($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['type'] = 'flag';
        $reactions = Reaction::where($args, [$per_page, $page]);
        $reactions = APIService::cleanReactions($reactions);
        $pagination = Reaction::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        //$output['meta'] = meta($pagination);
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = $reactions;
        return $output;
    }

    public function flagsPost($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['type'] = 'flag';
        $args['post_id'] = $req->params['post_id'];
        $reactions = Reaction::where($args, [$per_page, $page]);
        $posts = APIService::cleanReactions($reactions);
        $pagination = Reaction::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        //$output['meta'] = meta($pagination);
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = $posts;
        return $output;
    }

    public function star($req, $res) {
        Reaction::star($req->params['post_id'], $req->user_id);

        $post = Post::find($req->params['post_id']);

        $data = [];
        $data['id'] = $post->id;
        $data['user_id'] = $req->user_id;
        $data['conversation_id'] = $post->data['conversation_id'];
        $data['parent_id'] = $post->data['parent_id'];
        $data['original_id'] = $post->data['original_id'];
        $data['post'] = $post->data['post'];
        $data['status'] = $post->data['status'];
        $data['created_at'] = $post->data['created_at']->format('c');
        $data['updated_at'] = $post->data['updated_at']->format('c');
        $data['published_at'] = $post->data['published_at']->format('c');
        $data['username'] = $req->user->data['account']['username']['username'];
        $data['display_name'] = $req->user->data['account']['display_name'];
        $data['bio'] = $req->user->data['account']['bio'];

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = $data;
        return $output;
    }

    public function stars($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['type'] = 'star';
        $args['user_id'] = $req->user_id;
        $reactions = Reaction::where($args, [$per_page, $page]);
        $posts = APIService::cleanReactions($reactions);
        $pagination = Reaction::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        //$output['meta'] = meta($pagination);
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = $posts;
        return $output;
    }

    public function starsAll($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['type'] = 'star';
        $reactions = Reaction::where($args, [$per_page, $page]);
        $posts = APIService::cleanReactions($reactions);
        $pagination = Reaction::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        //$output['meta'] = meta($pagination);
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = $posts;
        return $output;
    }

    public function starsPost($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['type'] = 'star';
        $args['post_id'] = $req->params['post_id'];
        $reactions = Reaction::where($args, [$per_page, $page]);
        $posts = APIService::cleanReactions($reactions);
        $pagination = Reaction::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        //$output['meta'] = meta($pagination);
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = $posts;
        return $output;
    }

    public function unflag($req, $res) {
        Reaction::unflag($req->params['post_id'], $req->user_id);

        $post = Post::find($req->params['post_id']);

        $data = [];
        $data['id'] = $post->id;
        $data['user_id'] = $req->user_id;
        $data['conversation_id'] = $post->data['conversation_id'];
        $data['parent_id'] = $post->data['parent_id'];
        $data['original_id'] = $post->data['original_id'];
        $data['post'] = $post->data['post'];
        $data['status'] = $post->data['status'];
        $data['created_at'] = $post->data['created_at']->format('c');
        $data['updated_at'] = $post->data['updated_at']->format('c');
        $data['published_at'] = $post->data['published_at']->format('c');
        $data['username'] = $req->user->data['account']['username']['username'];
        $data['display_name'] = $req->user->data['account']['display_name'];
        $data['bio'] = $req->user->data['account']['bio'];

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = $data;
        return $output;
    }

    public function unstar($req, $res) {
        Reaction::unstar($req->params['post_id'], $req->user_id);

        $post = Post::find($req->params['post_id']);

        $data = [];
        $data['id'] = $post->id;
        $data['user_id'] = $req->user_id;
        $data['conversation_id'] = $post->data['conversation_id'];
        $data['parent_id'] = $post->data['parent_id'];
        $data['original_id'] = $post->data['original_id'];
        $data['post'] = $post->data['post'];
        $data['status'] = $post->data['status'];
        $data['created_at'] = $post->data['created_at']->format('c');
        $data['updated_at'] = $post->data['updated_at']->format('c');
        $data['published_at'] = $post->data['published_at']->format('c');
        $data['username'] = $req->user->data['account']['username']['username'];
        $data['display_name'] = $req->user->data['account']['display_name'];
        $data['bio'] = $req->user->data['account']['bio'];

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = $data;
        return $output;
    }
}
