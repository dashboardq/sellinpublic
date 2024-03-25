<?php

namespace app\models;

use mavoc\core\Exception;
use mavoc\core\Image;
use mavoc\core\Model;

class Media extends Model {
    public static $table = 'media';

    public static function uploaded($upload) {
        if(in_array($upload->data['upload_type'], ['profile'])) {
            $image = new Image($upload->data['file_location']);
            $image->resize(400, 400);
            $image->stripMeta();
            $image->save();

            $subdirectory = ceil($upload->id / 100) * 100;

            $args = [];
            $args['user_id'] = $upload->data['user_id'];
            $args['upload_id'] = $upload->id;
            $args['file_location'] = $upload->data['file_location'];
            if($upload->data['upload_type'] == 'profile') {
                $args['url_location'] = ao()->env('APP_SITE') . '/media/' . $subdirectory . '/profile_' . $upload->id . $upload->data['extension'];
            }
            $args['type'] = $upload->data['upload_type'];
            $media = self::create($args);
            return $media;
        }
    }

}
