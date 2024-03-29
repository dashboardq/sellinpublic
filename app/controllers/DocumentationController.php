<?php

namespace app\controllers;


class DocumentationController {
    public function introduction($req, $res) {
        return [];
    }

    public function authentication($req, $res) {
        return [];
    }

    public function download($req, $res) {
        $file = ao()->env('AO_STORAGE_DIR') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'demo' . DIRECTORY_SEPARATOR . 'd.png';
        header('Content-Type: image/png');
        header("Content-Transfer-Encoding: Binary"); 
        header('Content-disposition: attachment; filename="demo.png"'); 
        readfile($file); 
        exit;
    }

    public function request($req, $res) {
        return [];
    }

    public function response($req, $res) {
        return [];
    }

    public function sandbox($req, $res) {
        return [];
    }

    public function client($req, $res) {
        return [];
    }

    public function cli($req, $res) {
        return [];
    }

    public function changelog($req, $res) {
        return [];
    }

    public function endpoints($req, $res) {
        return [];
    }

    public function account($req, $res) {
        return [];
    }

    public function accountGet($req, $res) {
        return [];
    }

    public function accountUpdate($req, $res) {
        return [];
    }

    public function metrics($req, $res) {
        return [];
    }

    public function metricsPublished($req, $res) {
        return [];
    }

    public function metricsPending($req, $res) {
        return [];
    }

    public function metricsUsernames($req, $res) {
        return [];
    }

    public function miscellaneous($req, $res) {
        return [];
    }

    public function notifications($req, $res) {
        return [];
    }

    public function posts($req, $res) {
        return [];
    }

    public function postsLatest($req, $res) {
        return [];
    }

    public function postsPending($req, $res) {
        return [];
    }

    public function postsCreate($req, $res) {
        return [];
    }

    public function profile($req, $res) {
        return [];
    }

    public function reactions($req, $res) {
        return [];
    }

    public function settings($req, $res) {
        return [];
    }

    public function settingsGet($req, $res) {
        return [];
    }

    public function settingsTimezones($req, $res) {
        return [];
    }

    public function settingsUpdate($req, $res) {
        return [];
    }

    public function uploads($req, $res) {
        return [];
    }
}
