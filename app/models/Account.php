<?php

namespace app\models;

use mavoc\core\Model;

class Account extends Model {
    public static $table = 'accounts';

    public function process($data) {
        $username = Username::by(['user_id' => $data['user_id'], 'primary' => 1]);
        if($username) {
            $data['username'] = $username->data;
        }

        return $data;
    }
}
