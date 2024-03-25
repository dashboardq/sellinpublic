<?php

namespace app\controllers;

use app\services\APIService;

use Exception;

class AjaxController {
    public function uploadCreate($req, $res) {
        // Max size is 1MB
        $max_total_bytes = 1 * 1024 * 1024;
        $val = $req->val($req->data, [
            'total_bytes' => ['required', 'integer', ['maxValue' => $max_total_bytes]],
            'name' => ['required'],
            'extension' => ['required', ['in' => ['.jpg', '.png']]],
            'upload_type' => ['required', ['in' => ['profile']]],
        ]);

        $data = [];
        $data['total_bytes'] = $val['total_bytes'];
        $data['original_name'] = $val['name'];
        $data['original_extension'] = $val['extension'];
        $data['upload_type'] = $val['upload_type'];
        if(in_array($val['extension'], ['.jpg', '.png'])) {
            $data['file_type'] = 'image';
        }

        try {
            $response = APIService::call('/upload', $data, $req, $res);
        } catch(Exception $e) {
            $output = [];
            $output['status'] = 'error';
            $output['messages'] = $e->getMessage();
            return $output;
        }

        return ['status' => 'success', 'id' => $response['data']['id']];
    }

    public function uploadChunked($req, $res) {
        $val = $req->val($req->data, [
            'index' => ['required', 'integer'],
        ]);


        try {
            if(!isset($_FILES['chunk']['tmp_name'])) {
                throw new Exception('There was a problem accessing the file contents.');
            }

            $response = APIService::call('/upload/' . $req->params['upload_id'] . '/chunked', $val, $req, $res);
        } catch(Exception $e) {
            http_response_code(400);
            $output = [];
            $output['status'] = 'error';
            $output['messages'] = [$e->getMessage()];
            return $output;
        }
        return ['status' => 'success'];
    }

    public function uploadCompleted($req, $res) {
        $val = $req->val('data', [
            'total_chunks' => ['required', 'integer'],
        ]);

        try {
            $response = APIService::call('/upload/' . $req->params['upload_id'] . '/completed', $val, $req, $res);
        } catch(Exception $e) {
            http_response_code(400);
            $output = [];
            $output['status'] = 'error';
            $output['messages'] = [$e->getMessage()];
            return $output;
        }

        if(isset($response['data']['media'][0]['url_location'])) {
            $id = $response['data']['media'][0]['id'];
            $url = $response['data']['media'][0]['url_location'];
            return ['status' => 'success', 'id' => $id, 'url' => $url];
        } else {
            http_response_code(400);
            $output = [];
            $output['status'] = 'error';
            $output['messages'] = ["There was a problem loading the uploaded file's URL."];
            return $output;
        }

    }

    public function read($req, $res) {
        try {
            $response = APIService::call('/notification/read/' . $req->params['notification_id'], 'POST', $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        if($req->ajax) {
            return ['status' => 'success'];
        } else {
            $res->success('Item marked as read.', '/notifications#notification_' . $req->params['notification_id']);
        }
    }

    public function readAll($req, $res) {
        try {
            $response = APIService::call('/notifications/read', 'POST', $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }
        if($req->ajax) {
            return ['status' => 'success'];
        } else {
            $res->success('All items marked as read.');
        }
    }

    public function unread($req, $res) {
        try {
            $response = APIService::call('/notification/unread/' . $req->params['notification_id'], 'POST', $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        if($req->ajax) {
            return ['status' => 'success'];
        } else {
            $res->success('Item marked as unread.', '/notifications#notification_' . $req->params['notification_id']);
        }
    }

    public function unreadAll($req, $res) {
        try {
            $response = APIService::call('/notifications/unread', 'POST', $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }
        if($req->ajax) {
            return ['status' => 'success'];
        } else {
            $res->success('All items marked as unread.');
        }
    }
}
