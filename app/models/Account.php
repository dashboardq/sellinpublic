<?php

namespace app\models;

use mavoc\core\Model;

class Account extends Model {
    public static $table = 'accounts';

    public function process($data) {
        $username = Username::by(['user_id' => $data['user_id'], 'primary' => 1]);
        if($username) {
            $data['username'] = $username->data;
            if(isset($data['media_id']) && $data['media_id']) {
                $media = Media::find($data['media_id']);
                $data['profile_image_url'] = $media->data['url_location'];
            } else {
                $letter = substr($data['username']['username'], 0, 1);
                $data['profile_image_url'] = ao()->env('APP_SITE') . '/media/alphabet/' . $letter . '.png';
            }
        } elseif(isset($data['media_id']) && $data['media_id']) {
            $media = Media::find($data['media_id']);
            $data['profile_image_url'] = $media->data['url_location'];
        } else {
            $data['profile_image_url'] = ao()->env('APP_SITE') . '/media/alphabet/' . 'blank' . '.png';
        }

        return $data;
    }
}
