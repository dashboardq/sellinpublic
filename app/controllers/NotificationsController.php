<?php

namespace app\controllers;

use app\models\Notification;
use app\models\Post;

use app\services\APIService;

use DateTime;

class NotificationsController {
    public function list($req, $res) {
        //$notifications = Notification::where('receiver_id', $req->user_id);

        try {
            $response = APIService::call('/notifications', [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        $pagination = $response['meta']['pagination'];
        $notifications = $response['data'];

        return compact('pagination', 'notifications');
    }
}
