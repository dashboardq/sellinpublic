<?php

namespace app\controllers;

use app\models\Account;
use app\models\Setting;
use app\models\User;
use app\models\Username;

use app\services\APIService;

class APIAccountsController {
    public function account($req, $res) {
        $usernames = Username::where('user_id', $req->user_id);

        // First time logging in, make sure they have a username
        if(count($usernames) == 0) {    
            return APIService::error('The user info requested does not appear to be valid.');
        }

        $settings = Setting::get($req->user_id); 

        $output = [];
        $output['user_id'] = $usernames[0]->data['user_id'];
        $output['username'] = $usernames[0]->data['name'];
        $output['display_name'] = $req->user->data['account']['display_name'];
        $output['bio'] = $req->user->data['account']['bio'];
        $output['delay_post'] = pluralize($settings['delay_post'], 'minute');
        $output['timezone'] = $settings['timezone'];

        return APIService::data($output);
    }

    public function profile($req, $res) {
        $username = Username::by('name', $req->params['username']);

        if(!$username) {    
            return APIService::error('The user info requested does not appear to be valid.');
        }

        $user = User::find($username->data['user_id']);
        if(!$username) {    
            return APIService::error('The user info requested does not appear to be valid.');
        }

        $output = [];
        $output['user_id'] = $username->data['user_id'];
        $output['username'] = $username->data['name'];
        $output['display_name'] = $user->data['account']['display_name'];
        $output['bio'] = $user->data['account']['bio'];

        return APIService::data($output);
    }

    public function update($req, $res) {
        if(ao()->env('APP_LOGIN_TYPE') == 'db') {
            $data = $req->val('data', [
                'email' => ['optional', 'email', ['dbUnique' => ['users', 'id', $req->user_id]]],
                'name' => ['optional'],
                'display_name' => ['optional'],
                'bio' => ['optional'],
            ]);

            $args = [];
            if(isset($data['email'])) {
                $args['email'] = $data['email'];
            }
            if(isset($data['name'])) {
                $args['name'] = $data['name'];
            }
            if(count($args)) {
                $req->user->update($args);
            }

            $args = [];
            if(isset($data['display_name'])) {
                $args['display_name'] = $data['display_name'];
            }
            if(isset($data['bio'])) {
                $args['bio'] = $data['bio'];
            }
            if(count($args)) {
                $account = Account::by('user_id', $req->user_id);
                $account->update($args);
            }
        } else {
            $data = $req->val('data', [
                'display_name' => ['optional'],
                'bio' => ['optional'],
            ]);

            $args = [];
            if(isset($data['display_name'])) {
                $args['display_name'] = $data['display_name'];
            }
            if(isset($data['bio'])) {
                $args['bio'] = $data['bio'];
            }
            if(count($args)) {
                $account = Account::by('user_id', $req->user_id);
                $account->update($args);
            }
        }

        $user = User::find($req->user_id);
        $settings = Setting::get($req->user_id); 

        $output = [];
        $output['user_id'] = $user->id;
        $output['username'] = $user->data['account']['username']['name'];
        $output['display_name'] = $user->data['account']['display_name'];
        $output['bio'] = $user->data['account']['bio'];
        $output['delay_post'] = pluralize($settings['delay_post'], 'minute');
        $output['timezone'] = $settings['timezone'];

        return APIService::data($output);
    }
}
