<?php

namespace app\controllers;

use app\models\Post;
use app\models\Username;

class APIMetricsController {
    public function posts($req, $res) {
        $count = Post::count('status', 'published');
        return compact('count');
    }

    public function pendings($req, $res) {
        $count = Post::count('status', 'pending');
        return compact('count');
    }

    public function usernames($req, $res) {
        $count = Username::count();
        return compact('count');
    }
}
