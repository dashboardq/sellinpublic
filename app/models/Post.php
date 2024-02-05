<?php

namespace app\models;

use mavoc\core\Model;

class Post extends Model {
    public static $table = 'posts';
    public static $order = ['published_at' => 'desc']; 

    public function process($data) {
        $user = User::find($data['user_id']);
        $username = Username::primary($data['user_id']);

        $data['user'] = $user->data;
        $data['username'] = $username->data['name'];

        return $data;
    }

    public function publish() {
        $args = [];
        $args['user_id'] = 0;
        $args['post_id'] = $this->id;
        $args['author_id'] = $this->data['user_id'];
        $args['sort_order'] = 0;
        Timeline::create($args);


        $this->data['status'] = 'published';
        $this->save();
    }
}
