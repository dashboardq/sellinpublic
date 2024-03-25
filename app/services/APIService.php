<?php

namespace app\services;

use app\controllers\APIAccountsController;
use app\controllers\APINotificationsController;
use app\controllers\APIPostsController;
use app\controllers\APIReactionsController;
use app\controllers\APIUploadsController;

use app\models\Media;
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

        $parts = explode('/', trim($endpoint, '/'));
        if(count($parts) > 3) {
            $first_slug = '/' . $parts[0];
            $second_slug = '/' . $parts[1];
            $third_slug = '/' . $parts[2];
            $fourth_slug = '/' . $parts[3];
        } elseif(count($parts) > 2) {
            $first_slug = '/' . $parts[0];
            $second_slug = '/' . $parts[1];
            $third_slug = '/' . $parts[2];
            $fourth_slug = '';
        } elseif(count($parts) > 1) {
            $first_slug = '/' . $parts[0];
            $second_slug = '/' . $parts[1];
            $third_slug = '';
            $fourth_slug = '';
        } else {
            $first_slug = $endpoint;
            $second_slug = '';
            $third_slug = '';
            $fourth_slug = '';
        }
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
                if($first_slug . $third_slug == '/upload' . '/chunked') {
                    $data['chunk'] = curl_file_create($_FILES['chunk']['tmp_name']);
                }
                $response = $rest->post($base_url . $version . $endpoint . $page, $data, [], 'array');
            } else {
                $response = $rest->get($base_url . $version . $endpoint . $page, [], 'array');
            }
        } else {
            if($endpoint == '/account') {
                $controller = new APIAccountsController();
                if(count($data)) {
                    // Create a fake request to pass the data.
                    $request = new Request();
                    $request->res = $res;
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
            } elseif($endpoint == '/upload') {
                $controller = new APIUploadsController();
                // Create a fake request to pass the data.
                $request = new Request();
                $request->res = $res;
                $request->type = 'api';
                $request->data = $data;
                $request->user = $req->user;
                $request->user_id = $req->user_id;
                $response = $controller->create($request, $res);
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
                    $request->res = $res;
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
            } elseif($first_slug . $third_slug == '/upload' . '/chunked') {
                $controller = new APIUploadsController();
                // Create a fake request to pass the data.
                $request = new Request();
                $request->res = $res;
                $request->params = $req->params;
                $request->type = 'api';
                $request->data = $data;
                $request->user = $req->user;
                $request->user_id = $req->user_id;
                $response = $controller->chunked($request, $res);
            } elseif($first_slug . $third_slug == '/upload' . '/completed') {
                $controller = new APIUploadsController();
                // Create a fake request to pass the data.
                $request = new Request();
                $request->res = $res;
                $request->params = $req->params;
                $request->type = 'api';
                $request->data = $data;
                $request->user = $req->user;
                $request->user_id = $req->user_id;
                $response = $controller->completed($request, $res);
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

    public static function cleanAttachment($item) {
        if(isset($item->data)) {
            $temp = $item->data;
        } else {
            $temp = $item;
        }
        $output = [];
        $output['id'] = $temp['id'];
        $output['user_id'] = $temp['user_id'];
        $output['post_id'] = $temp['post_id'];
        $output['type'] = $temp['type'];
        $output['content'] = $temp['content'];
        $output['sort_order'] = $temp['sort_order'];
        $output['created_at'] = $temp['created_at']->format('c');
        $output['updated_at'] = $temp['updated_at']->format('c');
        return $output;
    }

    public static function cleanMedia($item) {
        if(isset($item->data)) {
            $temp = $item->data;
        } else {
            $temp = $item;
        }

        $output = [];
        $output['id'] = $temp['id'];
        $output['user_id'] = $temp['user_id'];
        $output['url_location'] = $temp['url_location'];
        $output['type'] = $temp['type'];
        return $output;
    }

    public static function cleanNotification($item) {
        if(isset($item->data)) {
            $temp = $item->data;
        } else {
            $temp = $item;
        }

        $output = [];
        $output['id'] = $temp['id'];
        $output['receiver_id'] = $temp['receiver_id'];
        $output['receiver_post_id'] = $temp['receiver_post_id'];
        $output['initiator_id'] = $temp['initiator_id'];
        $output['initiator_post_id'] = $temp['initiator_post_id'];
        $output['type'] = $temp['type'];
        $output['status'] = $temp['status'];
        $output['content'] = $temp['content'];
        $output['created_at'] = $temp['created_at']->format('c');
        $output['updated_at'] = $temp['updated_at']->format('c');

        $initiator = [];
        $initiator['display_name'] = $temp['initiator']['account']['display_name'];
        $initiator['username'] = $temp['initiator']['account']['username']['name'];
        $initiator['bio'] = $temp['initiator']['account']['bio'];
        $initiator['profile_image_url'] = $temp['initiator']['account']['profile_image_url'];
        $output['initiator'] = $initiator;

        if($item->data['initiator_post_id']) {
            $initiator_post = Post::find($temp['initiator_post_id']);
            $initiator_post = self::cleanPost($initiator_post);
            $output['initiator_post'] = $initiator_post;
        } else {
            $output['initiator_post'] = [];
        }

        $receiver_post = Post::find($temp['receiver_post_id']);
        $receiver_post = self::cleanPost($receiver_post);
        $output['receiver_post'] = $receiver_post;

		return $output;
    }

    public static function cleanNotifications($notifications) {
        foreach($notifications as $i => $notification) {
            $notifications[$i] = self::cleanNotification($notification);
        }
        return $notifications;
    }

    public static function cleanPost($item) {
        if(isset($item->data)) {
            $temp = $item->data;
        } else {
            $temp = $item;
        }

        $output = [];
        $output['id'] = $temp['id'];
        $output['user_id'] = $temp['user_id'];
        $output['conversation_id'] = $temp['conversation_id'];
        $output['parent_id'] = $temp['parent_id'];
        $output['original_id'] = $temp['original_id'];
        $output['post'] = $temp['post'];
        $output['status'] = $temp['status'];
        $output['type'] = $temp['type'];
        $output['depth'] = $temp['depth'];
        $output['sort_order'] = $temp['sort_order'];
        $output['attachment_count'] = $temp['attachment_count'];
        $output['replies'] = $temp['replies'];
        $output['reposts'] = $temp['reposts'];
        $output['quotes'] = $temp['quotes'];
        $output['stars'] = $temp['stars'];
        $output['flags'] = $temp['flags'];
        $output['reactions'] = $temp['reactions'];
        $output['bumps'] = $temp['bumps'];
        $output['created_at'] = $temp['created_at']->format('c');
        $output['updated_at'] = $temp['updated_at']->format('c');
        $output['published_at'] = $temp['published_at']->format('c');
        $output['sorted_at'] = $temp['sorted_at']->format('c');
        $output['username'] = $temp['username'];
        $output['replied'] = $temp['replied'];
        $output['flagged'] = $temp['flagged'];
        $output['starred'] = $temp['starred'];

        $attachments = [];
        foreach($temp['attachments'] as $attachment) {
            $attachments[] = self::cleanAttachment($attachment);
        }
        $output['attachments'] = $attachments;

        $user = self::cleanUser($temp['user']);
        $output['user'] = $user;

        return $output;
    }

    public static function cleanPosts($posts) {
        foreach($posts as $i => $post) {
            $posts[$i] = self::cleanPost($post);
        }
        return $posts;
    }

    public static function cleanReaction($item) {
        if(isset($item->data)) {
            $temp = $item->data;
        } else {
            $temp = $item;
        }

        $output = [];
        $output['id'] = $temp['id'];
        $output['user_id'] = $temp['user_id'];
        $output['post_id'] = $temp['post_id'];
        $output['type'] = $temp['type'];
        $output['content'] = $temp['content'];
        $output['created_at'] = $temp['created_at']->format('c');
        $output['updated_at'] = $temp['updated_at']->format('c');

        $post = Post::find($temp['post_id']);
        $post = self::cleanPost($post);
        $output['post'] = $post;

        $user = User::find($temp['user_id']);
        $user = self::cleanUser($user);
        $output['user'] = $user;

        return $output;
    }

    public static function cleanReactions($reactions) {
        foreach($reactions as $i => $reaction) {
            $reactions[$i] = self::cleanReaction($reaction);
        }
        return $reactions;
    }

    public static function cleanUpload($item) {
        if(isset($item->data)) {
            $temp = $item->data;
        } else {
            $temp = $item;
        }

        $output = [];
        $output['id'] = $temp['id'];
        $output['user_id'] = $temp['user_id'];
        $output['status'] = $temp['status'];
        $output['expired_at'] = $temp['expired_at']->format('c');
        if(in_array($temp['upload_type'], ['profile'])) {
            $output['media'] = [];
            $media = Media::where('upload_id', $item->id);
            foreach($media as $med) {
                $output['media'][] = self::cleanMedia($med);
            }
        } else {
            $output['media'] = [];
        }
        return $output;
    }

    public static function cleanUser($item) {
        if(isset($item->data)) {
            $temp = $item->data;
        } else {
            $temp = $item;
        }

        $output = [];
        $output['user_id'] = $temp['id'];
        $output['username'] = $temp['account']['username']['username'];
        $output['display_name'] = $temp['account']['display_name'];
        $output['bio'] = $temp['account']['bio'];
        $output['profile_image_url'] = $temp['account']['profile_image_url'];

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
