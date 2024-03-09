<?php

namespace app\controllers;

use app\services\APIService;

class AjaxController {
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
