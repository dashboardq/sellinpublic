<?php

namespace app\models;

use mavoc\core\Model;

class Timeline extends Model {
    public static $table = 'timelines';

    public function process($data) {
        //$user = User::find($data['user_id']);
        //$username = Username::primary($data['user_id']);

        //$data['user'] = $user->data;
        //$data['username'] = $username->data['name'];

        return $data;
    }
}
