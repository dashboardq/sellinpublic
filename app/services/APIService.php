<?php

namespace app\services;

use app\controllers\APIAccountsController;
use app\controllers\APINotificationsController;
use app\controllers\APIPostsController;
use app\controllers\APIReactionsController;

use app\models\Post;
use app\models\User;

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
                $third_slug = '/' . $parts[2];
            } elseif(count($parts) > 1) {
                $first_slug = '/' . $parts[0];
                $second_slug = '/' . $parts[1];
                $third_slug = '';
            } else {
                $first_slug = $endpoint;
                $second_slug = '';
                $third_slug = '';
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
            } elseif($endpoint == '/notifications') {
                $controller = new APINotificationsController();
                $response = $controller->list($req, $res);
            } elseif($endpoint == '/notifications/count') {
                $controller = new APINotificationsController();
                $response = $controller->count($req, $res);
            } elseif($endpoint == '/notifications/count/unread') {
                $controller = new APINotificationsController();
                $response = $controller->countUnread($req, $res);
            } elseif($endpoint == '/notifications/read') {
                $controller = new APINotificationsController();
                $response = $controller->readAll($req, $res);
            } elseif($endpoint == '/notifications/unread') {
                $controller = new APINotificationsController();
                $response = $controller->unreadAll($req, $res);
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
            } elseif($endpoint == '/reactions/flags/all') {
                $controller = new APIReactionsController();
                $response = $controller->flagsAll($req, $res);
            } elseif($endpoint == '/reactions/stars') {
                $controller = new APIReactionsController();
                $response = $controller->stars($req, $res);
            } elseif($endpoint == '/reactions/stars/all') {
                $controller = new APIReactionsController();
                $response = $controller->starsAll($req, $res);
            } elseif($first_slug == '/profile') {
                $controller = new APIAccountsController();
                $response = $controller->profile($req, $res);
            } elseif($first_slug . $second_slug == '/notification/read') {
                $controller = new APINotificationsController();
                $response = $controller->read($req, $res);
            } elseif($first_slug . $second_slug == '/notification/unread') {
                $controller = new APINotificationsController();
                $response = $controller->unread($req, $res);
            } elseif($first_slug . $second_slug == '/post/children') {
                $controller = new APIPostsController();
                $response = $controller->children($req, $res);
            } elseif($first_slug . $second_slug == '/post/single') {
                $controller = new APIPostsController();
                $response = $controller->single($req, $res);
            } elseif($first_slug . $second_slug == '/reactions/flags') {
                $controller = new APIReactionsController();
                $response = $controller->flagsPost($req, $res);
            } elseif($first_slug . $second_slug == '/reactions/stars') {
                $controller = new APIReactionsController();
                $response = $controller->starsPost($req, $res);
            } elseif($first_slug . $second_slug == '/timeline/user') {
                $controller = new APIPostsController();
                $response = $controller->timelineUser($req, $res);
            } elseif($first_slug . $third_slug == '/post' . '/flag') {
                $controller = new APIReactionsController();
                $response = $controller->flag($req, $res);
            } elseif($first_slug . $third_slug == '/post' . '/unflag') {
                $controller = new APIReactionsController();
                $response = $controller->unflag($req, $res);
            } elseif($first_slug . $third_slug == '/post' . '/star') {
                $controller = new APIReactionsController();
                $response = $controller->star($req, $res);
            } elseif($first_slug . $third_slug == '/post' . '/unstar') {
                $controller = new APIReactionsController();
                $response = $controller->unstar($req, $res);
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
                        // May need to change this to recursive if it gets multiple levels deep.
                        if(is_array($value)) {
                            foreach($value as $k => $v) {
                                if(substr($k, -3) == '_at') {
                                    $response['data'][$i][$key][$k] = new DateTime($v);

                                    $timezone = ao()->hook('ao_model_process_dates_timezone', 'UTC', '');
                                    $tz = new DateTimeZone($timezone);
                                    $dt_tz = new DateTime($v);
                                    $dt_tz->setTimezone($tz);

                                    $tz_k = substr($k, 0, -3) . '_tz';
                                    $response['data'][$i][$key][$tz_k] = $dt_tz;
                                }
                            }
                        } else {
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

    public static function cleanNotification($notification) {
        $initiator = [];
        $initiator['display_name'] = $notification->data['initiator']['account']['display_name'];
        $initiator['username'] = $notification->data['initiator']['account']['username']['name'];
        $initiator['bio'] = $notification->data['initiator']['account']['bio'];
        $notification->data['initiator'] = $initiator;

        if($notification->data['initiator_post_id']) {
            $initiator_post = Post::find($notification->data['initiator_post_id']);
            $initiator_post = self::cleanPost($initiator_post);
            $notification->data['initiator_post'] = $initiator_post->data;
        } else {
            $notification->data['initiator_post'] = [];
        }

        $receiver_post = Post::find($notification->data['receiver_post_id']);
        $receiver_post = self::cleanPost($receiver_post);
        $notification->data['receiver_post'] = $receiver_post->data;

        unset($notification->data['created_tz']);
        unset($notification->data['updated_tz']);
        return $notification;
    }

    public static function cleanNotifications($notifications) {
        foreach($notifications as $i => $notification) {
            $notifications[$i] = self::cleanNotification($notification);
        }
        return $notifications;
    }

    public static function cleanPost($post) {
        $post->data['display_name'] = $post->data['user']['account']['display_name'];
        $post->data['username'] = $post->data['user']['account']['username']['name'];
        $post->data['bio'] = $post->data['user']['account']['bio'];
        unset($post->data['user']);
        unset($post->data['created_tz']);
        unset($post->data['updated_tz']);
        unset($post->data['published_tz']);
        return $post;
    }

    public static function cleanPosts($posts) {
        foreach($posts as $i => $post) {
            $posts[$i] = self::cleanPost($post);

            /*
            $posts[$i]->data['display_name'] = $post->data['user']['account']['display_name'];
            $posts[$i]->data['username'] = $post->data['user']['account']['username']['name'];
            $posts[$i]->data['bio'] = $post->data['user']['account']['bio'];
            unset($posts[$i]->data['user']);
            unset($posts[$i]->data['created_tz']);
            unset($posts[$i]->data['updated_tz']);
            unset($posts[$i]->data['published_tz']);
             */
        }
        return $posts;
    }

    public static function cleanReaction($reaction) {
        $post = Post::find($reaction->data['post_id']);
        $post = self::cleanPost($post);
        $reaction->data['post'] = $post->data;

        $user = User::find($reaction->data['user_id']);
        $user = self::cleanUser($user);
        $reaction->data['user'] = $user->data;

        return $reaction;
    }

    public static function cleanReactions($reactions) {
        foreach($reactions as $i => $reaction) {
            $reactions[$i] = self::cleanReaction($reaction);
        }
        return $reactions;
    }

    public static function cleanUser($user) {
        $output = new \stdClass();
        $output->data = [];
        $output->data['user_id'] = $user->id;
        $output->data['username'] = $user->data['account']['username']['name'];
        $output->data['display_name'] = $user->data['account']['display_name'];
        $output->data['bio'] = $user->data['account']['bio'];

        return $output;
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
