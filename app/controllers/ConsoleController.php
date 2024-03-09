<?php

namespace app\controllers;

use app\models\APIKey;
use app\models\Notification;
use app\models\Post;
use app\models\Reaction;
use app\models\Setting;
use app\models\Timeline;
use app\models\User;
use app\models\Username;

use DateTime;

class ConsoleController {
    public function process($in, $out) {
        $args = [];
        $args['status'] = 'pending';
        $args['published_at'] = ['<', now()];
        $posts = Post::where($args);

        $out->write('Starting to process: ' . count($posts) . ' posts', 'green');

        foreach($posts as $i => $post) {
            $post->publish();
            $out->write(($i + 1) . '. Processing post: ' . $post->id, 'green');
        }

        $out->write('Processing complete.', 'green');
    }

    public function rsync($in, $out) {
        $error = '';
        $success = '';
        $servers = ao()->env('RSYNC_SERVERS');
        $sources = [];
        $destinations = [];

        if(isset($in->params[0]) && isset($in->params[1])) {
            $server = $in->params[0];
            if(isset($servers[$server])) {
                if(in_array($in->params[1], ['db'])) {
                    $dir = $in->params[1];
                    $sources[] = ao()->env('AO_DB_DIR') . '/';
                    $destinations[] = $servers[$server] . '/' . $dir . '/';
                } else {
                    $error = 'Please enter a valid directory like "db".';
                }
            } else {
                $error = 'The server entered is not valid.';
            }
        } elseif(isset($in->params[0])) {
            $server = $in->params[0];
            if(isset($servers[$server])) {
                $sources[] = ao()->env('AO_APP_DIR') . '/';
                $destinations[] = $servers[$server] . '/' . 'app' . '/';
                $sources[] = ao()->env('AO_DB_DIR') . '/';
                $destinations[] = $servers[$server] . '/' . 'db' . '/';
                $sources[] = ao()->env('AO_MAVOC_DIR') . '/';
                $destinations[] = $servers[$server] . '/' . 'mavoc' . '/';
                $sources[] = ao()->env('AO_PLUGIN_DIR') . '/';
                $destinations[] = $servers[$server] . '/' . 'plugins' . '/';
                $sources[] = ao()->env('AO_PUBLIC_DIR') . '/';
                $destinations[] = $servers[$server] . '/' . 'public' . '/';
            } else {
                $error = 'The server entered is not valid.';
            }
        } else {
            $error = 'Please include a server like "prod".';
        }

        if(count($sources)) {
            foreach($sources as $i => $source) {
                $destination = $destinations[$i];

                $out->write('rsync -avzh ' . $source . ' ' . $destination, 'green');
                $output = [];
                exec('rsync -avzh ' . $source . ' ' . $destination . ' 2>&1', $output, $exit_code);
                $out->write('exit_code: ' . $exit_code, 'green');
                $out->write(implode("\n", $output), 'green');
                $out->write('', 'green');
            }

            $success = 'The syncing is complete.';
        }

        if($error) {
            $out->write($error, 'red');
        }
        if($success) {
            $out->write($success, 'green');
        }
    }

    public function sandbox($in, $out) {
        if(ao()->env('APP_HOST') == 'sandbox.sellinpublic.com') {
            $confirm = 'y';
        } else {
            $confirm = $out->prompt('You are not currently on the sandbox server. Please confirm that you want to proceed. (y/n) (Default: n): ', ['y', 'n'], 'n');
        }
        if(in_array(strtolower($confirm), ['y', 'yes'])) {
            $dt = new DateTime();

            $out->write('Truncating tables', 'green');
            // Truncate the tables
            $tables = [];
            $tables[] = 'accounts';
            $tables[] = 'api_keys';
            $tables[] = 'attachments';
            $tables[] = 'notifications';
            $tables[] = 'password_resets';
            $tables[] = 'posts';
            $tables[] = 'reactions';
            $tables[] = 'restrictions';
            $tables[] = 'settings';
            $tables[] = 'subscriptions';
            $tables[] = 'timelines';
            $tables[] = 'usernames';
            $tables[] = 'users';

            foreach($tables as $table) {
                $out->write('Truncate ' . $table, 'green');
                ao()->db->query(ao()->db->truncateTable($table));
            }

            // Create the users
            $out->write('Creating users', 'green');
            $names = [];
            $names[] = 'demo';
            $names[] = 'sandbox';
            $names[] = 'good';
            $names[] = 'bad';

            foreach($names as $name) {
                $out->write('Create ' . $name, 'green');
                $args = [];
                $args['name'] = ucfirst($name);
                $args['email'] = $name . '@example.com';
                $args['password'] = 'password';
                $user = User::create($args);

                $args = [];
                $args['name'] = $name;
                $args['user_id'] = $user->id;
                $args['primary'] = 1;
                Username::create($args); 
            }

            $out->write('Create API Keys', 'green');
            // Creat API Keys for demo
            $args = [];
            $args['user_id'] = 1;
            $args['name'] = 'Demo';
            $key = APIKey::create($args);

            // Manually set the API Key
            $args = [];
            $prefix = ao()->env('API_PREFIX');
            $suffix = ao()->env('API_SUFFIX');
            $token = '01234demo56789';
            $args['last4'] = substr($token, -4);
            $args['api_key'] = password_hash($prefix . $token . $suffix, PASSWORD_DEFAULT);
            $key->update($args);


            // Set the delay_post values
            $out->write('Set the delay_post settings', 'green');
            Setting::set(3, 'delay_post', 1);
            Setting::set(4, 'delay_post', 1440);

            // Create posts
            $out->write('Create Posts', 'green');

            $dt->modify('-5 hours');
            $future = new DateTime();
            $future->modify('+48 hours');
            $args = [];
            $args['user_id'] = 1;
            $args['conversation_id'] = 1;
            $args['standing_calculated'] = 0;
            $args['status'] = 'pending';
            $args['post'] = 'This is a delayed post. When new accounts are created or when an account has been penalized, there is a delay until their posts are published publicly. Until then, the posts are listed under pending.';
            $args['replies'] = 0;
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $args['published_at'] = $future;
            $args['sorted_at'] = $future;
            $delayed_post = Post::create($args);

            $posts = [];


            $dt->modify('+1 hours');
            $args = [];
            $args['user_id'] = 1;
            $args['conversation_id'] = 2;
            $args['standing_calculated'] = 1;
            $args['status'] = 'published';
            $args['post'] = 'Welcome to the Sandbox server where you can test the interface and API interactions!';
            $args['replies'] = 3;
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $args['published_at'] = $dt;
            $args['sorted_at'] = $dt;
            $posts[] = Post::create($args);

            $dt->modify('+1 hour');
            $args = [];
            $args['user_id'] = 2;
            $args['conversation_id'] = 2;
            $args['parent_id'] = 2;
            $args['standing_calculated'] = 1;
            $args['status'] = 'published';
            $args['type'] = 'reply';
            $args['depth'] = 1;
            $args['sort_order'] = '0000000001/0000000000/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000';
            $args['post'] = 'You can post replies.';
            $args['replies'] = 1;
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $args['published_at'] = $dt;
            $args['sorted_at'] = $dt;
            $posts[] = Post::create($args);

            $args = [];
            $args['receiver_id'] = 1;
            $args['receiver_post_id'] = 2;
            $args['initiator_id'] = 2;
            $args['initiator_post_id'] = 3;
            $args['type'] = 'reply';
            $args['status'] = 'read';
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            Notification::create($args);

            $dt->modify('+15 minutes');
            $args = [];
            $args['user_id'] = 3;
            $args['conversation_id'] = 2;
            $args['parent_id'] = 2;
            $args['standing_calculated'] = 1;
            $args['status'] = 'published';
            $args['type'] = 'reply';
            $args['depth'] = 1;
            $args['sort_order'] = '0000000002/0000000000/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000';
            $args['post'] = "Feel free to start testing today! Checkout the API documentation if you need help:\nhttps://sellinpublic.com/documentation";
            $args['replies'] = 0;
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $args['published_at'] = $dt;
            $args['sorted_at'] = $dt;
            $posts[] = Post::create($args);

            $args = [];
            $args['receiver_id'] = 1;
            $args['receiver_post_id'] = 2;
            $args['initiator_id'] = 3;
            $args['initiator_post_id'] = 4;
            $args['type'] = 'reply';
            $args['status'] = 'unread';
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            Notification::create($args);


            $dt->modify('+15 minutes');
            $args = [];
            $args['user_id'] = 1;
            $args['conversation_id'] = 2;
            $args['parent_id'] = 3;
            $args['standing_calculated'] = 1;
            $args['status'] = 'published';
            $args['type'] = 'reply';
            $args['depth'] = 2;
            $args['sort_order'] = '0000000001/0000000001/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000';
            $args['post'] = 'And you can thread replies.';
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $args['published_at'] = $dt;
            $args['sorted_at'] = $dt;
            $posts[] = Post::create($args);

            $args = [];
            $args['receiver_id'] = 2;
            $args['receiver_post_id'] = 3;
            $args['initiator_id'] = 1;
            $args['initiator_post_id'] = 4;
            $args['type'] = 'reply';
            $args['status'] = 'unread';
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            Notification::create($args);


            $dt->modify('+1 hours');
            $args = [];
            $args['user_id'] = 4;
            $args['conversation_id'] = 6;
            $args['standing_calculated'] = 1;
            $args['status'] = 'published';
            $args['post'] = 'Sometimes bad posts make it through moderation. If that happens they can be flagged. This post was flagged by the demo user.';
            $args['flags'] = 1;
            $args['replies'] = 1;
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $args['published_at'] = $dt;
            $args['sorted_at'] = $dt;
            $posts[] = Post::create($args);


            $dt->modify('+1 hours');
            $args = [];
            $args['user_id'] = 2;
            $args['conversation_id'] = 7;
            $args['standing_calculated'] = 1;
            $args['status'] = 'published';
            $args['post'] = 'The Sandbox server is regenerated every 24 hours.';
            $args['stars'] = 0;
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $args['published_at'] = $dt;
            $args['sorted_at'] = $dt;
            $posts[] = Post::create($args);


            $dt = new DateTime();
            $dt->modify('-5 minute');
            $args = [];
            $args['user_id'] = 3;
            $args['conversation_id'] = 8;
            $args['standing_calculated'] = 1;
            $args['status'] = 'published';
            $args['post'] = 'The Sandbox was regenerated five minutes after the time of this post.';
            $args['stars'] = 0;
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $args['published_at'] = $dt;
            $args['sorted_at'] = $dt;
            $posts[] = Post::create($args);

            $dt->modify('+1 minutes');
            $args = [];
            $args['user_id'] = 1;
            $args['conversation_id'] = 6;
            $args['parent_id'] = 6;
            $args['standing_calculated'] = 1;
            $args['status'] = 'published';
            $args['type'] = 'reply';
            $args['depth'] = 1;
            $args['sort_order'] = '0000000001/0000000000/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000';
            $args['post'] = 'This post should be moderated. I am going to flag it.';
            $args['replies'] = 0;
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $args['published_at'] = $dt;
            $args['sorted_at'] = $dt;
            $posts[] = Post::create($args);

            $args = [];
            $args['receiver_id'] = 4;
            $args['receiver_post_id'] = 6;
            $args['initiator_id'] = 1;
            $args['initiator_post_id'] = 9;
            $args['type'] = 'reply';
            $args['status'] = 'unread';
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            Notification::create($args);

            $dt->modify('+1 minute');
            $args = [];
            $args['user_id'] = 1;
            $args['post_id'] = 6;
            $args['type'] = 'flag';
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $reactions[] = Reaction::create($args);
            $posts[4]->data['sorted_at'] = $dt;
            $posts[4]->save();

            $args = [];
            $args['receiver_id'] = 4;
            $args['receiver_post_id'] = 6;
            $args['initiator_id'] = 1;
            $args['type'] = 'flag';
            $args['status'] = 'unread';
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            Notification::create($args);


            $dt->modify('+1 minute');
            $args = [];
            $args['user_id'] = 1;
            $args['post_id'] = 7;
            $args['type'] = 'star';
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $reactions[] = Reaction::create($args);
            $posts[5]->data['stars'] += 1;
            $posts[5]->data['sorted_at'] = $dt;
            $posts[5]->save();

            $args = [];
            $args['receiver_id'] = 2;
            $args['receiver_post_id'] = 7;
            $args['initiator_id'] = 1;
            $args['type'] = 'star';
            $args['status'] = 'unread';
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            Notification::create($args);


            $dt->modify('+1 minute');
            $args = [];
            $args['user_id'] = 1;
            $args['post_id'] = 2;
            $args['type'] = 'star';
            $args['created_at'] = $dt;
            $args['updated_at'] = $dt;
            $reactions[] = Reaction::create($args);
            $posts[0]->data['stars'] += 1;
            $posts[0]->data['sorted_at'] = $dt;
            $posts[0]->save();
        } else {
            $out->write('Did not confirm', 'red');
        }
        $out->write('Completed', 'green');
    }

    public function standing($in, $out) {
        // Only updates standing 48 hours after the published date.
        $offset = '-48 hours';
        $dt = new DateTime();
        $dt->modify($offset);
        $args = [];
        $args['status'] = 'published';
        $args['standing_calculated'] = 0;
        $args['published_at'] = ['<', $dt];
        $posts = Post::where($args);

        $out->write('Updating standing: ' . count($posts) . ' posts', 'green');

        foreach($posts as $i => $post) {
            $post->standing();
            $out->write(($i + 1) . '. Processing post: ' . $post->id, 'green');
        }

        $out->write('Updating standing complete.', 'green');
    }

}
