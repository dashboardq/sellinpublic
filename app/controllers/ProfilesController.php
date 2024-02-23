<?php

namespace app\controllers;

use app\models\Account;
use app\models\Post;
use app\models\Username;

use app\services\APIService;

use mavoc\core\Exception;

class ProfilesController {
    public function profile($req, $res) {
        /*
        $username = Username::by('name', $req->params['username']);
        if(!$username) {
            $res->status(404);
            exit;
        }
        $account = Account::by('user_id', $username->data['user_id']);
        if(!$account) {
            $res->status(404);
            exit;
        }
         */

        try {
            $res_profile = APIService::call('/profile/' . $req->params['username'], [], $req, $res);

            $res_timeline = APIService::call('/timeline/user/' . $req->params['username'], [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }

        $profile = $res_profile['data'];

        $pagination = $res_timeline['meta']['pagination'];
        $posts = $res_timeline['data'];

        return compact('pagination', 'posts', 'profile');
    }
}
