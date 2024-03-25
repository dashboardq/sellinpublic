<?php

namespace app\controllers;

use app\models\Attachment;
use app\models\Post;
use app\models\Reaction;
use app\models\Setting;
use app\models\Username;

use app\services\APIService;

use DateTime;

class APIPostsController {
    public function latest($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['status'] = 'published';
        $args['type'] = 'post';

        ao()->once('ao_model_order_posts', function($order) {
            $order = ['sorted_at' => 'DESC'];
            return $order;
        });
        $posts = Post::where($args, [$per_page, $page]);
        $posts = APIService::cleanPosts($posts);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = $posts;
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
        $output['data'] = $posts;
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
        $args['type'] = 'post';
        $args['user_id'] = $username->data['user_id'];

        $posts = Post::where($args, [$per_page, $page]);
        $posts = APIService::cleanPosts($posts);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = $posts;
        return $output;
    }

    public function create($req, $res) {
        $rules = [];
        $rules['post'] = ['required', ['maxLength' => 240]];
        $rules['attachment_count'] = ['optional', 'integer'];
        $rules['parent_id'] = ['optional'];

        $pass1 = $req->val('data', $rules);
        $pass1 = $req->clean($pass1, [
            'attachment_count' => 'int',
            'parent_id' => 'int',
        ]);

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
        $data = $req->clean($data, [
            'attachment_count' => 'int',
            'parent_id' => 'int',
        ]);

        $delay = Setting::get($req->user_id, 'delay_post');
        $delay_time = pluralize($delay, 'minute');

        $published_at = new DateTime();
        $published_at->modify('+' . $delay_time);

        $args = [];
        $args['user_id'] = $req->user_id;
        $args['status'] = 'pending';
        $args['published_at'] = $published_at;
        $args['sorted_at'] = $published_at;
        $args['post'] = $data['post'];
        $args['parent_id'] = $data['parent_id'];
        $args['attachment_count'] = $data['attachment_count'];
        $post = Post::create($args);
        
        // Create any attachments
        for($i = 0; $i < $data['attachment_count']; $i++) {
            if($data['attachment_type_' . $i] == 'text') {
                $args = [];
                $args['user_id'] = $req->user_id;
                $args['post_id'] = $post->id;
                $args['type'] = 'text';
                $args['content'] = $data['attachment_text_' . $i];
                $args['sort_order'] = $i;
                $attachment = Attachment::create($args);
            }
        }

        // Reload the post to get the attachments
        $post->reload();
        $post = APIService::cleanPost($post);

        $output = [];
        $output['status'] = 'success';
        if($delay_time == '1 minute') {
            $output['messages'] = ['Thank you for submitting your post. It will be publicly displayed in ' . $delay_time . '.'];
        } else {
            $output['messages'] = ['Thank you for submitting your post. It will be publicly displayed in ' . $delay_time . '. New accounts have a delay in publishing to help protect against spam.'];
        }
        $output['meta'] = new \stdClass();
        $output['data'] = $post;
        return $output;
    }

    public function children($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['id'] = $req->params['post_id'];
        $args['status'] = 'published';

        //$posts = Post::where($args, [$per_page, $page]);
        $posts = Post::thread($args, [$per_page, $page]);
        $posts = APIService::cleanPosts($posts);
        $pagination = Post::threadCount($args, [$per_page, $page, 'pagination', $req->path]); 

        // If no posts, check if it is not published but is owned by the user.


        // Get all the published replies

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = $posts;
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
        $output['data'] = $posts;
        return $output;
    }
}
