<?php

namespace app\controllers;

use app\models\Post;

use app\services\APIService;

use mavoc\core\Exception;

class MainController {
    public function about($req, $res) {
        //$res->view('main/home');
        return [];
    }

    public function building($req, $res) {
        //$res->view('main/home');
        return [];
    }

    public function home($req, $res) {
        /*
        $page = clean($req->query['page'] ?? 1, 'int', 1); 
        $per_page = 20;
         */

        try {
            $response = APIService::call('/latest', [], $req, $res);
        } catch(Exception $e) {
            $req->session->flash['error'] = $e->getMessage();
            $res->view('alt/error');
            exit;
        }
        $pagination = $response['meta']['pagination'];
        $posts = $response['data'];

        /*
        $args = [];
        $args['status'] = 'published';
        $posts = Post::where($args, [$per_page, $page]);
        $pagination = Post::count($args, [$per_page, $page, 'pagination', $req->path]); 
         */

        return compact('pagination', 'posts');
    }

    public function pricing($req, $res) {
        // Various ways to return the data
        // Returning data and then automapping to views based on controllers would make testing easier.
        // return [];
        // return compact('list');
        // return get_defined_vars();
        $title = 'Pricing';
        return compact('title');
    }

    public function privacy($req, $res) {
        //$res->view('main/privacy', ['title' => 'Privacy Policy']);
        return ['title' => 'Privacy Policy'];
    }

    public function terms($req, $res) {
        //$res->view('main/terms', ['title' => 'Terms of Use']);
        return ['title' => 'Terms of Use'];
    }
}
