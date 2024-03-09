<?php

namespace app\models;

use mavoc\core\Model;

class Notification extends Model {
    public static $table = 'notifications';
    public static $order = ['created_at' => 'desc']; 

    public function process($data) {
        $initiator_user = User::find($data['initiator_id']);
        $initiator_username = Username::primary($data['initiator_id']);

        $data['initiator'] = $initiator_user->data;

        return $data;
    }
}
