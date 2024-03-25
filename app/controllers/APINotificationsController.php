<?php

namespace app\controllers;

use app\models\Notification;

use app\services\APIService;

use DateTime;

class APINotificationsController {
    public function count($req, $res) {
        $args = [];
        $args['receiver_id'] = $req->user_id;
        $count = Notification::count($args);

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = [];
        $output['data'] = $count;
        return $output;
    }

    public function countUnread($req, $res) {
        $args = [];
        $args['receiver_id'] = $req->user_id;
        $args['status'] = 'unread';
        $count = Notification::count($args);

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = [];
        $output['data'] = $count;
        return $output;
    }

    public function list($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;

        $args = [];
        $args['receiver_id'] = $req->user_id;

        $notifications = Notification::where($args, [$per_page, $page]);
        $notifications = APIService::cleanNotifications($notifications);
        $pagination = Notification::count($args, [$per_page, $page, 'pagination', $req->path]); 

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = ['pagination' => $pagination];
        $output['data'] = $notifications;
        return $output;
    }

    public function read($req, $res) {
        $args = [];
        $args['status'] = 'read';

        $where = [];
        $where['id'] = $req->params['notification_id'];
        $where['receiver_id'] = $req->user_id;
        Notification::updateWhere($args, $where);

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = ['Item marked as read.'];
        $output['meta'] = new \stdClass();
        $output['data'] = new \stdClass();
        return $output;
    }

    public function readAll($req, $res) {
        $args = [];
        $args['status'] = 'read';

        $where = [];
        $where['receiver_id'] = $req->user_id;
        Notification::updateWhere($args, $where);

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = ['All items marked as read.'];
        $output['meta'] = new \stdClass();
        $output['data'] = new \stdClass();
        return $output;
    }

    public function unread($req, $res) {
        $args = [];
        $args['status'] = 'unread';

        $where = [];
        $where['id'] = $req->params['notification_id'];
        $where['receiver_id'] = $req->user_id;
        Notification::updateWhere($args, $where);

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = ['Item marked as unread.'];
        $output['meta'] = new \stdClass();
        $output['data'] = new \stdClass();
        return $output;
    }

    public function unreadAll($req, $res) {
        $args = [];
        $args['status'] = 'unread';

        $where = [];
        $where['receiver_id'] = $req->user_id;
        Notification::updateWhere($args, $where);

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = ['All items marked as read.'];
        $output['meta'] = new \stdClass();
        $output['data'] = new \stdClass();
        return $output;
    }
}
