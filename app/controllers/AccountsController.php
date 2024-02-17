<?php

namespace app\controllers;

use app\models\Account;
use app\models\User;
use app\models\Username;

use app\services\APIService;

class AccountsController {

    // Part of the information is pulled locally and part of the information is pulled from the API.
    public function account($req, $res) {
        /*
       $usernames = Username::where('user_id', $req->user->data['id']);
      
        // First time logging in, make sure they have a username
        if(count($usernames) == 0) {    
            $res->redirect('/username/add');
        }

        $res->fields['username'] = $usernames[0]->data['name'];
        $res->fields['display_name'] = $req->user->data['account']['display_name'];
        $res->fields['bio'] = $req->user->data['account']['bio'];

        return [];
         */

        $res->fields['email'] = $req->user->all['email'];
        $res->fields['name'] = $req->user->data['name'];

        $response = APIService::call('/account', [], $req, $res);

        $res->fields['username'] = $response['data']['username'];
        $res->fields['display_name'] = $response['data']['display_name'];
        $res->fields['bio'] = $response['data']['bio'];

        return [];
    }

    public function update($req, $res) {
        if(ao()->env('APP_LOGIN_TYPE') == 'db') {
            $data = $req->val('data', [
                'email' => ['required', 'email', ['dbUnique' => ['users', 'id', $req->user_id]]],
                'name' => ['required'],
                'display_name' => ['required'],
                'bio' => ['optional'],
            ]);

            $args = [];
            $args['display_name'] = $data['display_name'];
            if(isset($data['bio'])) {
                $args['bio'] = $data['bio'];
            }
            APIService::call('/account', $args, $req, $res);

            $args = [];
            $args['email'] = $data['email'];
            $args['name'] = $data['name'];
            $req->user->update($args);
        } else {
            $data = $req->val('data', [
                'display_name' => ['required'],
                'bio' => ['optional'],
            ]);

            APIService::call('/accounts', $data, $req, $res);
        }

        $res->success('Account updated successfully.', '/account');
    }
}
