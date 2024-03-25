<?php

namespace app\controllers;

use app\models\Upload;

use app\services\APIService;

use mavoc\core\Exception;

use DateTime;

class APIUploadsController {
    public function chunked($req, $res) {
        // Max size is 1MB
        $max_total_bytes = 1 * 1024 * 1024;
        $data = $req->val($req->data, [
            'index' => ['required', 'integer'],
        ]);

        if(!isset($_FILES['chunk']['tmp_name'])) {
            throw new Exception('There was a problem accessing the file contents.');
        }

        $upload = Upload::find($req->params['upload_id']);
        $upload->chunked($_FILES['chunk']['tmp_name'], $data['index']);

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = new \stdClass();
        return $output;
    }

    public function create($req, $res) {
        // Max size is 1MB
        $max_total_bytes = 1 * 1024 * 1024;
        $data = $req->val($req->data, [
            'total_bytes' => ['required', 'integer', ['maxValue' => $max_total_bytes]],
            'original_name' => ['required'],
            'original_extension' => ['required', ['in' => ['.jpg', '.png']]],
            'file_type' => ['required', ['in' => ['image']]],
            'upload_type' => ['required', ['in' => ['profile']]],
        ]);

        $dt = new DateTime();
        $dt->modify('+24 hours');

        $data['user_id'] = $req->user_id;
        $data['status'] = 'created';
        $data['expired_at'] = $dt;
        $upload = Upload::create($data);
        $upload = APIService::cleanUpload($upload);

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = $upload;
        return $output;
    }

    public function completed($req, $res) {
        // Max size is 1MB
        $max_total_bytes = 1 * 1024 * 1024;
        $data = $req->val($req->data, [
            'total_chunks' => ['required', 'integer'],
        ]);

        $upload = Upload::find($req->params['upload_id']);
        $upload->completed($data['total_chunks']);
        $upload = APIService::cleanUpload($upload);

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = $upload;
        return $output;
    }

}
