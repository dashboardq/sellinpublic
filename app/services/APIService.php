<?php

namespace app\services;

use app\controllers\APIAccountsController;
use app\controllers\APIPostsController;

use mavoc\core\Exception;
use mavoc\core\Request;
use mavoc\core\Response;
use mavoc\core\REST;

use DateTime;
use DateTimeZone;

class APIService {
    public static function call($endpoint, $data = null, $req = null, $res = null) {
        $utc = new DateTimeZone('UTC');

        $output = [];
        if(ao()->env('API_TYPE') == 'client') {
            $username = ao()->env('API_REMOTE_USERNAME');
            $key = ao()->env('API_REMOTE_KEY');
            $base_url = ao()->env('API_BASE');
            $version = ao()->env('API_VERSION');

            $auth = $username . ':' . $key;
            $rest = new REST([], $auth);

            $page = '';
            if(isset($req->query['page']) && is_numeric($req->query['page'])) {
                $page = '?page=' . $req->query['page'];
            }
            if(count($data)) {
                $response = $rest->post($base_url . $version . $endpoint . $page, $data, [], 'array');
            } else {
                $response = $rest->get($base_url . $version . $endpoint . $page, [], 'array');
            }

            /*
            if($endpoint == '/account') {
                if(count($data)) {
                    $response = $rest->post($base_url . $version . $endpoint, $data, [], 'array');
                } else {
                    $response = $rest->get($base_url . $version . $endpoint, [], 'array');
                }
            } elseif($endpoint == '/latest') {
                $response = $rest->get($base_url . $version . $endpoint, [], 'array');
            } elseif($endpoint == '/pending') {
                $response = $rest->get($base_url . $version . $endpoint, [], 'array');
            } elseif($endpoint == '/post') {
                if(count($data)) {
                    $response = $rest->post($base_url . $version . $endpoint, $data, [], 'array');
                } else {
                    //$response = $rest->get($base_url . $version . $endpoint, [], 'array');
                }
            }
             */

        } else {
            $parts = explode('/', trim($endpoint, '/'));
            if(count($parts) > 2) {
                $first_slug = '/' . $parts[0];
                $second_slug = '/' . $parts[1];
            } elseif(count($parts) > 1) {
                $first_slug = '/' . $parts[0];
                $second_slug = '';
            } else {
                $first_slug = $endpoint;
                $second_slug = '';
            }
            if($endpoint == '/account') {
                $controller = new APIAccountsController();
                if(count($data)) {
                    // Create a fake request to pass the data.
                    $request = new Request();
                    $request->type = 'api';
                    $request->data = $data;
                    $request->user = $req->user;
                    $request->user_id = $req->user_id;

                    $response = $controller->update($request, $res);
                } else {
                    $response = $controller->account($req, $res);
                }
            } elseif($endpoint == '/latest') {
                $controller = new APIPostsController();
                $response = $controller->latest($req, $res);
            } elseif($endpoint == '/pending') {
                $controller = new APIPostsController();
                $response = $controller->pending($req, $res);
            } elseif($endpoint == '/post') {
                $controller = new APIPostsController();
                if(count($data)) {
                    // Create a fake request to pass the data.
                    $request = new Request();
                    $request->type = 'api';
                    $request->data = $data;
                    $request->user = $req->user;
                    $request->user_id = $req->user_id;

                    $response = $controller->create($request, $res);
                } else {
                    //$response = $controller->read($req, $res);
                }
            } elseif($first_slug == '/profile') {
                $controller = new APIAccountsController();
                $response = $controller->profile($req, $res);
            } elseif($first_slug . $second_slug == '/post/children') {
                $controller = new APIPostsController();
                $response = $controller->children($req, $res);
            } elseif($first_slug . $second_slug == '/post/single') {
                $controller = new APIPostsController();
                $response = $controller->single($req, $res);
            } elseif($first_slug . $second_slug == '/timeline/user') {
                $controller = new APIPostsController();
                $response = $controller->timelineUser($req, $res);
            } else {
                $response = self::error('The requested URL does not appear to be valid.');
            }
        }

        if(is_array($response['meta'])) {
            // Update the pagination URLs.
            if(isset($response['meta']['pagination']['url_next'])) {
                $url_stripped = preg_replace('/page=\d+&?/', '', $req->path);
                if(strpos($url_stripped, '?') === false) {
                    $response['meta']['pagination']['url_next'] = $url_stripped . '?page=' . urlencode($response['meta']['pagination']['page_next']);
                    $response['meta']['pagination']['url_previous'] = $url_stripped . '?page=' . urlencode($response['meta']['pagination']['page_previous']);
                } else {
                    $response['meta']['pagination']['url_next'] = $url_stripped . '&page=' . urlencode($response['meta']['pagination']['page_next']);
                    $response['meta']['pagination']['url_previous'] = $url_stripped . '&page=' . urlencode($response['meta']['pagination']['page_previous']);
                }
            }
        }

        if(is_array($response['data'])) {
            foreach($response['data'] as $i => $item) {
                if(is_array($item)) {
                    foreach($item as $key => $value) {
                        // Update DateTime to DateTime objects and set user timezone.
                        if(substr($key, -3) == '_at') {
                            $response['data'][$i][$key] = new DateTime($value);

                            $timezone = ao()->hook('ao_model_process_dates_timezone', 'UTC', '');
                            $tz = new DateTimeZone($timezone);
                            $dt_tz = new DateTime($value);
                            $dt_tz->setTimezone($tz);

                            $tz_key = substr($key, 0, -3) . '_tz';
                            $response['data'][$i][$tz_key] = $dt_tz;
                        }
                    }
                }
            }
        }

        if($response['status'] == 'error') {
            if(count($data)) {
                // if POST, pass the error so that it is shown as an error in the response.
                if(is_array($response['messages'])) {
                    throw new Exception(implode(' ', $response['messages']));
                } else {
                    throw new Exception($response['messages']);
                }
            } else {
                // if GET, return an error page otherwise could end up in an infinite loop.
                $res->session->flash['error'] = $response['messages'];
                $res->view('alt/error');
                exit;
            }
        }

        return $response;
    }

    public static function cleanPosts($posts) {
        foreach($posts as $i => $post) {
            $posts[$i]->data['display_name'] = $post->data['user']['account']['display_name'];
            $posts[$i]->data['username'] = $post->data['user']['account']['username']['name'];
            $posts[$i]->data['bio'] = $post->data['user']['account']['bio'];
            unset($posts[$i]->data['user']);
            unset($posts[$i]->data['created_tz']);
            unset($posts[$i]->data['updated_tz']);
            unset($posts[$i]->data['published_tz']);
        }
        return $posts;
    }

    public static function data($input, $meta = [], $messages = []) {
        $output = [];
        $output['status'] = 'success';
        $output['messages'] = $messages;
        if(
            is_array($meta) && count($meta) == 0
            || !$meta
        ) {
            $output['meta'] = new \stdClass();
        } else {
            $output['meta'] = $meta;
        }
        $output['data'] = $input;
        return $output;
    }

    public static function error($messages, $meta = [], $data = []) {
        $output = [];
        $output['status'] = 'error';
        if(is_array($messages)) {
            $output['messages'] = $messages;
        } else {
            $output['messages'] = [$messages];
        }
        if(
            is_array($meta) && count($meta) == 0
            || !$meta
        ) {
            $output['meta'] = new \stdClass();
        } else {
            $output['meta'] = $meta;
        }
        if(
            is_array($meta) && count($meta) == 0
            || !$meta
        ) {
            $output['data'] = new \stdClass();
        } else {
            $output['data'] = $meta;
        }
        return $output;
    }
}
