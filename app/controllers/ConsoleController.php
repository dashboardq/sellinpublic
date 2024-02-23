<?php

namespace app\controllers;

use app\models\Post;
use app\models\Timeline;

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
}
