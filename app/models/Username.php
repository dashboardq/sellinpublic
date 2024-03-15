<?php

namespace app\models;

use mavoc\core\Model;

class Username extends Model {
    public static $table = 'usernames';

    public static function primary($user_id) {
        return Username::by(['user_id' => $user_id, 'primary' => 1]);
    }

    public function process($data) {
        // Add default domain if it is set and another domain is not set for the user.
        $user_domain = ao()->env('APP_USER_DOMAIN');
        if($user_domain && strpos($data['name'], '.') == false) {
            $data['username'] = $data['name'] . $user_domain;
        } else {
            $data['username'] = $data['name'];
        }

        return $data;
    }

}
