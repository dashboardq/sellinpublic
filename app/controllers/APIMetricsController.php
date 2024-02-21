<?php

namespace app\controllers;

use app\models\Post;
use app\models\Username;

class APIMetricsController {
    public function posts($req, $res) {
        $count = Post::count('status', 'published');

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = ['count' => $count];
        return $output;
    }

    public function pendings($req, $res) {
        $count = Post::count('status', 'pending');

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = ['count' => $count];
        return $output;
    }

    public function usernames($req, $res) {
        $count = Username::count();

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = ['count' => $count];
        return $output;
    }

    public function originalPosts($req, $res) {
        $count = Post::count('status', 'published');
        return compact('count');
    }

    public function originalPendings($req, $res) {
        $count = Post::count('status', 'pending');
        return compact('count');
    }

    public function originalUsernames($req, $res) {
        $count = Username::count();
        return compact('count');
    }
}
