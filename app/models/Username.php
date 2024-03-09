<?php

namespace app\models;

use mavoc\core\Model;

class Username extends Model {
    public static $table = 'usernames';

    public static function primary($user_id) {
        return Username::by(['user_id' => $user_id, 'primary' => 1]);
    }

    public function process($data) {
        /*
        if(strpos($data['name'], '.') == false) {
            $data['name'] = $data['name'] . '.sip.name';
        }
         */

        return $data;
    }

}
