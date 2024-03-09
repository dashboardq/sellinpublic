<?php

namespace app\models;

use mavoc\core\Model;

class Reaction extends Model {
    public static $table = 'reactions';
    public static $order = ['created_at' => 'desc']; 

    public static function flag($post_id, $user_id) {
        $previously_flagged = false;

        $args = [];
        $args['user_id'] = $user_id;
        $args['post_id'] = $post_id;
        $args['type'] = 'flag';
        $reaction = Reaction::by($args);

        // If a flag already exists, just return it.
        if($reaction) {
            return $reaction;
        }

        $args['type'] = 'unflag';
        $unflags = Reaction::where($args);

        if(count($unflags)) {
            $previously_flagged = true;
            foreach($unflags as $unflag) {
                Reaction::delete($unflag->id);
            }
        }

        // Create a new flag
        $args['type'] = 'flag';
        $reaction = Reaction::create($args);

        if($previously_flagged) {
            // Don't create a notification (only one notification should be created per user)
            // Otherwise users could harass with constantly flagging and unflagging.
            Post::addFlag($post_id, $user_id, false);
        } else {
            Post::addFlag($post_id, $user_id);
        }

        return $reaction;
    }

    public function process($data) {
        //$user = User::find($data['user_id']);
        //$username = Username::primary($data['user_id']);

        //$data['user'] = $user->data;
        //$data['username'] = $username->data['name'];

        return $data;
    }

    // The user_id is the user is starred a post.
    public static function star($post_id, $user_id) {
        $previously_starred = false;

        $args = [];
        $args['user_id'] = $user_id;
        $args['post_id'] = $post_id;
        $args['type'] = 'star';
        $reaction = Reaction::by($args);

        // If a star already exists, just return it.
        if($reaction) {
            return $reaction;
        }

        $args['type'] = 'unstar';
        $unstars = Reaction::where($args);

        if(count($unstars)) {
            $previously_starred = true;
            foreach($unstars as $unstar) {
                Reaction::delete($unstar->id);
            }
        }

        // Create a new star
        $args['type'] = 'star';
        $reaction = Reaction::create($args);

        if($previously_starred) {
            // Don't update the sorted_at date
            Post::addStar($post_id, $user_id, false);
        } else {
            Post::addStar($post_id, $user_id);
        }

        return $reaction;
    }

    public static function unflag($post_id, $user_id) {
        $args = [];
        $args['user_id'] = $user_id;
        $args['post_id'] = $post_id;
        $args['type'] = 'unflag';
        $reaction = Reaction::by($args);

        // If a unflag already exists, just return it.
        if($reaction) {
            return $reaction;
        }

        $args['type'] = 'flag';
        $flags = Reaction::where($args);

        foreach($flags as $flag) {
            Reaction::delete($flag->id);
        }

        // Create a new unflag
        $args['type'] = 'unflag';
        $reaction = Reaction::create($args);

        Post::removeFlag($post_id, $user_id);

        return $reaction;
    }

    public static function unstar($post_id, $user_id) {
        $args = [];
        $args['user_id'] = $user_id;
        $args['post_id'] = $post_id;
        $args['type'] = 'unstar';
        $reaction = Reaction::by($args);

        // If a unstar already exists, just return it.
        if($reaction) {
            return $reaction;
        }

        $args['type'] = 'star';
        $stars = Reaction::where($args);

        foreach($stars as $star) {
            Reaction::delete($star->id);
        }

        // Create a new unstar
        $args['type'] = 'unstar';
        $reaction = Reaction::create($args);

        Post::removeStar($post_id, $user_id);

        return $reaction;
    }
}
