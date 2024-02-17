<?php

namespace app\models;

use mavoc\core\Model;

class Restriction extends Model {
    public static $table = 'restrictions';

    public static function get($user_id, $return_type = 'all') {
        $restriction = self::by('user_id', $user_id);

        // If no restriction has been created for the user, they should have full access.
        if(!$restriction) {
            $args['user_id'] = $user_id;
            $args['premium_level'] = 100;
            $restriction = new Restriction($args);
        }

        return $restriction->data;
    }
}
