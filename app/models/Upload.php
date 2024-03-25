<?php

namespace app\models;

use mavoc\core\Exception;
use mavoc\core\Model;

class Upload extends Model {
    public static $table = 'uploads';

    public function chunked($file, $index) {
        if(!in_array($this->data['status'], ['created', 'uploading', 'completing'])) {
            $this->error('status');
        }
        if($this->data['expired_at'] < now(true)) {
            $this->error('expired');
        }

        $temp_file = ao()->env('AO_STORAGE_DIR'). DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'media_' . $this->id . '_' . $index . '.tmp';

        if (!move_uploaded_file($file, $temp_file)) {
            throw new Exception('There was a problem copying the contents of the file to the server.');
        }

        $this->data['current_chunks'] = $this->data['current_chunks'] + 1;
        $this->data['current_bytes'] = $this->data['current_bytes'] + filesize($temp_file);

        if($this->data['current_bytes'] > $this->data['total_bytes']) {
            $this->error('bytes');
        }

        if($this->data['status'] == 'completing' && $this->data['current_chunks'] == $this->data['total_chunks']) {
            $this->completing();
        } else {
            $this->data['status'] = 'uploading';
        }
        $this->save();
    }

    public function completed($total_chunks) {
        $this->data['total_chunks'] = $total_chunks;

        if($this->data['current_chunks'] == $this->data['total_chunks']) {
            $this->completing();
        } else {
            $this->data['status'] = 'completing';
        }
        $this->save();
    }

    public function completing() {
        $this->data['extension'] = $this->data['original_extension'];
        if(in_array($this->data['upload_type'], ['profile'])) {
            $subdirectory = ceil($this->id / 100) * 100;
            $directory = ao()->env('AO_STORAGE_DIR') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . $subdirectory;

            $this->data['name'] = 'profile_' . $this->id . $this->data['extension'];
            $file = $directory . DIRECTORY_SEPARATOR . $this->data['name'];
        }

        // Recursively make the directory
        if(!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        for($i = 0; $i < $this->data['total_chunks']; $i++) {
            $temp_file = ao()->env('AO_STORAGE_DIR'). DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'media_' . $this->id . '_' . $i . '.tmp';

            file_put_contents($file, file_get_contents($temp_file), FILE_APPEND | LOCK_EX);
            unlink($temp_file);
        }

        $this->data['file_location'] = $file;

        if(in_array($this->data['upload_type'], ['profile'])) {
            $media = Media::uploaded($this);
            $this->data['item_id'] = $media->id;
        }

        $this->data['status'] = 'completed';
    }

    public function error($type) {
        if($type == 'bytes') {
            $this->data['status'] = 'error_bytes';
            $this->save();
            throw new Exception('The bytes uploaded do not match what was initially described. Please try again, if you continue to have issues, please contact support.');
        } elseif($type == 'expired') {
            $this->data['status'] = 'error_expired';
            $this->save();
            throw new Exception('The upload has expired. Please try again, if you continue to have issues, please contact support.');
        } elseif($type == 'status') {
            throw new Exception('The upload previously experienced an error and cannot continue. Please try again, if you continue to have issues, please contact support.');
        }
    }

    public function process($data) {
        //$user = User::find($data['user_id']);
        //$username = Username::primary($data['user_id']);

        //$data['user'] = $user->data;
        //$data['username'] = $username->data['name'];

        return $data;
    }
}
