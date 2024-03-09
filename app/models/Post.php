<?php

namespace app\models;

use mavoc\core\Exception;
use mavoc\core\Model;

class Post extends Model {
    public static $table = 'posts';
    public static $order = ['published_at' => 'desc']; 

    public static function addFlag($post_id, $user_id, $create_notification = true) {
        $post = Post::find($post_id);
        $args = [];
        $args['flags'] = $post->data['flags'] + 1;
        if($create_notification) {
            // Create notification if the creator of the post is not the user who starred it.
            if($post->data['user_id'] != $user_id) {
                $args2 = [];
                $args2['receiver_id'] = $post->data['user_id'];
                $args2['receiver_post_id'] = $post->id;
                // Don't save the initiator info for the notification.
                $args2['initiator_id'] = 0;
                $args2['initiator_post_id'] = 0;
                $args2['type'] = 'flag';
                $args2['status'] = 'unread';
                Notification::create($args2);
            }
        }
        // Don't update the sorted_at date when a post is flagged.
        $post->update($args);
    }

    // The ancestors should be ordered from closest ancestor to farthest ancestor.
    public static function addReply($post, $ancestors) {
        $receivers = [];
        foreach($ancestors as $ancestor) {
            // Only create a notification if the receiver has not received any other notifications
            // and someone else made the post.
            if(!in_array($ancestor->data['user_id'], $receivers) && $post->data['user_id'] != $ancestor->data['user_id']) {
                $args = [];
                $args['receiver_id'] = $ancestor->data['user_id'];
                $args['receiver_post_id'] = $ancestor->id;
                $args['initiator_id'] = $post->data['user_id'];
                $args['initiator_post_id'] = $post->id;
                $args['type'] = 'reply';
                $args['status'] = 'unread';
                Notification::create($args);

                $receivers[] = $ancestor->data['user_id'];
            }

            $ancestor->data['replies'] += 1;
            $ancestor->save();
        }

    }

    // The $user_id is the user who created the star.
    public static function addStar($post_id, $user_id, $sorted_date = true) {
        $post = Post::find($post_id);
        $args = [];
        $args['stars'] = $post->data['stars'] + 1;
        // Don't update the sorted_at date when a post is flagged.
        if($sorted_date) {
            $args['sorted_at'] = now();

            // Create notification if the creator of the post is not the user who starred it.
            if($post->data['user_id'] != $user_id) {
                $args2 = [];
                $args2['receiver_id'] = $post->data['user_id'];
                $args2['receiver_post_id'] = $post->id;
                $args2['initiator_id'] = $user_id;
                $args2['initiator_post_id'] = 0;
                $args2['type'] = 'star';
                $args2['status'] = 'unread';
                Notification::create($args2);
            }
        }
        $post->update($args);
    }

    public static function create($args) {
        if(!isset($args['original_id'])) {
            $args['original_id'] = 0;
        }
        if(!isset($args['type'])) {
            if(isset($args['parent_id'])) {
                $args['type'] = 'reply';
            } else {
                $args['type'] = 'post';
            }
        }
        if(isset($args['parent_id'])) {
            $parent = Post::find($args['parent_id']);
            if(!$parent) {
                throw new Exception('The passed in parent id does not appear to be valid.');
            }

            // If the parent is a top level post, use its ID as the conversation id.
            // Otherwise, use the parent post's conversation id.
            if($parent->data['conversation_id'] == 0) {
                $args['conversation_id'] = $parent->id;
            } else {
                $args['conversation_id'] = $parent->data['conversation_id'];
            }
        }


        $post = parent::create($args);  

        return $post;
    }

    public function process($data) {
        $user = User::find($data['user_id']);
        $username = Username::primary($data['user_id']);

        $data['user'] = $user->data;
        $data['username'] = $username->data['name'];

        $replied = false;
        $flagged = false;
        $starred = false;

        $user_id = ao()->request->user_id ?? 0;
        if($user_id) {
            $args = [];
            $args['user_id'] = $user_id;
            $args['post_id'] = $data['id'];
            $reactions = Reaction::where($args);
            foreach($reactions as $reaction) {
                if($reaction->data['type'] == 'star') {
                    $starred = true;
                } elseif($reaction->data['type'] == 'reply') {
                    $replied = true;
                } elseif($reaction->data['type'] == 'flag') {
                    $flagged = true;
                }
            }
        }

        $data['replied'] = $replied;
        $data['flagged'] = $flagged;
        $data['starred'] = $starred;

        return $data;
    }

    public function publish() {
        $args = [];
        $args['user_id'] = 0;
        $args['post_id'] = $this->id;
        $args['author_id'] = $this->data['user_id'];
        $args['sort_order'] = 0;
        Timeline::create($args);

        // Process all the reply counts
        $ancestors = [];
        $parent = null;
        $parent_id = $this->data['parent_id'];
        $up_one_level_id = $parent_id;
        $first = true;
        $depth = 0;
        $sort_order = '';
        $parent_sort_order = '';
        $last_id = 0;
        while($up_one_level_id != 0) {
            $temp = Post::find($up_one_level_id);
            // There was a problem, break out of loop.
            if(!$temp) {
                break;
            }

            if($first) {
                $parent = $temp;
                $depth = $temp->data['depth'] + 1;
                $parent_sort_order = $temp->data['sort_order'];
            }

            $ancestors[] = $temp;

            $last_id = $temp->id;
            $up_one_level_id = $temp->data['parent_id'];
            $first = false;
        }

        // If the parent is the start of the conversation
        if($parent && $parent->data['parent_id'] == 0 && $parent->id == $this->data['conversation_id']) {
            // Is the author of the parent post the author of the current post?
            // Then we need to give it a higher priority sort.
            // Especially useful for posting about live events or posting updates over time.
            if($parent->data['user_id'] == $this->data['user_id']) {
                $result = ao()->db->query('SELECT sort_order FROM posts WHERE conversation_id = ? AND sort_order < ? ORDER BY sort_order DESC LIMIT 1', $this->data['conversation_id'], '0000000001/0000000000/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000');
                // First reply
                if(!$result || count($result) == 0 || (isset($result[0]['sort_order']) && !$result[0]['sort_order'])) {
                    $sort_order = '0000000000/0000000001/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000';
                } else {
                    $depths = explode('/', $result[0]['sort_order']);
                    if(count($depths) == 10) {
                        // PHP maxes out at 32 bit signed integers so max number is 2,147,483,647
                        // So just limiting to 1,999,999,999
                        $depths[1] = (int)$depths[1];
                        if($depths[1] >= 1999999999) {
                            $depths[1] = 1999999999;
                        } else {
                            $depths[1] = $depths[1] + 1;
                        }

                        $str = str_pad($depths[1], 10, '0', STR_PAD_LEFT);
                        $sort_order = '0000000000/' . $str . '/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000';
                    }
                }
            } else {
                $result = ao()->db->query('SELECT sort_order FROM posts WHERE conversation_id = ? ORDER BY sort_order DESC LIMIT 1', $parent->id);
                // First reply
                if(!$result || count($result) == 0) {
                    $sort_order = '0000000001/0000000000/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000';
                } else {
                    $depths = explode('/', $result[0]['sort_order']);
                    if(count($depths) == 10) {
                        // PHP maxes out at 32 bit signed integers so max number is 2,147,483,647
                        // So just limiting to 1,999,999,999
                        if($depths[0] >= 1999999999) {
                            $depths[0] = 1999999999;
                        } else {
                            $depths[0] += 1;
                        }

                        $str = str_pad($depths[0], 10, '0', STR_PAD_LEFT);
                        $sort_order = $str . '/0000000000/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000';
                    }
                }
            }
        } elseif($parent_sort_order && $this->data['conversation_id']) {
            $original_depths = explode('/', $parent_sort_order);
            $parent_depth = $depth - 2;
            $min = (int)$original_depths[$parent_depth];
            $max = $min + 1;

            $min_sort = '';
            $max_sort = '';

            // Loop 10 times
            $looper = array_fill(0, 10, 1);
            $first = true;
            foreach($looper as $i => $loop) {
                if(!$first) {
                    $min_sort .= '/';
                    $max_sort .= '/';
                }

                if($i < $parent_depth) {
                    $min_sort .= str_pad($original_depths[$i], 10, '0', STR_PAD_LEFT);
                    $max_sort .= str_pad($original_depths[$i], 10, '0', STR_PAD_LEFT);
                } elseif($i == $parent_depth) {
                    $min_sort .= str_pad($min, 10, '0', STR_PAD_LEFT);
                    $max_sort .= str_pad($max, 10, '0', STR_PAD_LEFT);
                } else {
                    $min_sort .= '0000000000';
                    $max_sort .= '0000000000';
                }

                $first = false;
            }

            $result = ao()->db->query('SELECT sort_order FROM posts WHERE conversation_id = ? AND sort_order >= ? AND sort_order < ? ORDER BY sort_order DESC LIMIT 1', $this->data['conversation_id'], $min_sort, $max_sort);

            // First reply
            if(!$result || count($result) == 0) {
                $sort_order = '';
                $first = true;
                foreach($looper as $i => $loop) {
                    if(!$first) {
                        $sort_order .= '/';
                    }

                    if($i < $depth) {
                        $sort_order .= str_pad($original_depths[$i], 10, '0', STR_PAD_LEFT);
                    } elseif($i == $depth) {
                        $sort_order .= '0000000001';
                    } else {
                        $sort_order .= '0000000000';
                    }

                    $first = false;
                }
            } else {
                $depths = explode('/', $result[0]['sort_order']);
                if(count($depths) == 10) {
                    // PHP maxes out at 32 bit signed integers so max number is 2,147,483,647
                    // So just limiting to 1,999,999,999
                    $depths[$depth - 1] = (int)$depths[$depth - 1];
                    if($depths[$depth - 1] >= 1999999999) {
                        $depths[$depth - 1] = 1999999999;
                    } else {
                        $depths[$depth - 1] += 1;
                    }

                    $first = true;
                    foreach($looper as $i => $loop) {
                        if(!$first) {
                            $sort_order .= '/';
                        }

                        if($i < $depth - 1) {
                            $sort_order .= $depths[$i];
                        } elseif($i == $depth - 1) {
                            $sort_order .= str_pad($depths[$i], 10, '0', STR_PAD_LEFT);
                        } else {
                            $sort_order .= '0000000000';
                        }

                        $first = false;
                    }
                }
            }
        }

        if($parent) {
            // Create a reaction
            $args = [];
            $args['user_id'] = $this->data['user_id'];
            $args['post_id'] = $parent->id;
            $args['type'] = 'reply';
            $reaction = Reaction::create($args);
        } else {
            // No parent so make sure the conversation_id is set to the item id.
            $this->data['conversation_id'] = $this->id;
        }

        $this->data['depth'] = $depth;
        $this->data['sort_order'] = $sort_order;
        $this->data['status'] = 'published';
        $this->save();

        self::addReply($this, $ancestors);
    }

    public static function removeFlag($post_id, $user_id) {
        $post = Post::find($post_id);
        $args = [];
        $args['flags'] = $post->data['flags'] - 1;
        // Don't update the sorted_at date when a post is unflagged.
        $post->update($args);
    }

    public static function removeStar($post_id, $user_id) {
        $post = Post::find($post_id);
        $args = [];
        $args['stars'] = $post->data['stars'] - 1;
        // Don't update the sorted_at date when a post is unflagged.
        $post->update($args);
    }

    public function standing() {
        $user_id = $this->data['user_id'];
        $delay = Setting::get($user_id, 'delay_post');
        // Expecting the dwindle to have an "x" variable that represents the current delay, like:
        // ceil(x/2)
        $dwindle = Setting::get($user_id, 'delay_dwindle');

        $new_delay = calculate($dwindle, $delay);

        Setting::set($user_id, 'delay_post', $new_delay);

        $this->data['standing_calculated'] = 1;
        $this->save();
    }

    public static function thread($args, $pagination) {
        // TODO: This probably should be a by() call and not have pagination data.
        $post = Post::where($args);
        if(!$post) {
            throw new Exception('The requested thread could not be found.');
        }

        $class = get_called_class();
        $quote = ao()->db->quote;
        $table = self::setTable($class);
        $limit = self::setLimit($pagination, $table);
        $page = self::setPage($pagination, $table);
        $offset = self::setOffset($pagination, $table);

        // Check if it is a child thread or the main thread.
        // If it has depth, it is a child thread.
        if($post[0]->data['depth']) {
            $depth = $post[0]->data['depth'] - 1;
            $sort_order = $post[0]->data['sort_order'];
            $depths = explode('/', $sort_order);

            $min = (int)$depths[$depth];
            $max = $min + 1;

            $min_sort = '';
            $max_sort = '';

            // Loop 10 times
            $looper = array_fill(0, 10, 1);
            $first = true;
            foreach($looper as $i => $loop) {
                if(!$first) {
                    $min_sort .= '/';
                    $max_sort .= '/';
                }

                if($i < $depth) {
                    $min_sort .= str_pad($depths[$i], 10, '0', STR_PAD_LEFT);
                    $max_sort .= str_pad($depths[$i], 10, '0', STR_PAD_LEFT);
                } elseif($i == $depth) {
                    $min_sort .= str_pad($min, 10, '0', STR_PAD_LEFT);
                    $max_sort .= str_pad($max, 10, '0', STR_PAD_LEFT);
                } elseif($i == $depth + 1) {
                    // The > comparison sometimes includes the current value so we are increasing the next level
                    // value and using >=
                    // I'm not sure if it is sometimes of conversion behind the scenes 
                    // but there is some kind of problem.
                    //
                    // Meaning:
                    // SELECT * FROM posts WHERE conversation_id = 1 AND sort_order > '0000000001/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000' ORDER BY sort_order ASC LIMIT 1;
                    // Returns:
                    // id: 4
                    // ...
                    // sort_order: 0000000001/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000
                    //
                    // And this:
                    // SELECT * FROM posts WHERE conversation_id = 1 AND sort_order > '000000000a/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000' ORDER BY sort_order ASC LIMIT 1;
                    // Returns:
                    // id: 4
                    // ...
                    // sort_order: 000000000a/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000
                    //
                    // But this:
                    // SELECT * FROM posts WHERE conversation_id = 1 AND sort_order > '0000000001/0000000001/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000' ORDER BY sort_order ASC LIMIT 1;
                    // Returns:
                    // id: 5
                    // ...
                    // sort_order: 0000000001/0000000001/0000000001/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000

                    // There is no consistency of whether or not it includes the matching item.
                    // So trying to eliminate the inconsistency by using the next level.
                    $min_sort .= '0000000001';
                    $max_sort .= '0000000000';
                } else {
                    $min_sort .= '0000000000';
                    $max_sort .= '0000000000';
                }

                $first = false;
            }

            //$replies = ao()->db->query('SELECT * FROM posts WHERE conversation_id = ? AND sort_order >= ? AND sort_order < ? ORDER BY sort_order DESC', $post[0]->data['conversation_id'], $min_sort, $max_sort);
            $sql = '
                SELECT * 
                FROM posts 
                WHERE conversation_id = ? 
                AND parent_id > 0 
                AND sort_order >= ? 
                AND sort_order < ? 
                ORDER BY sort_order ASC
            ';

            if(is_numeric($limit) && $limit > 0 && is_numeric($offset) && $offset > 0) {
                $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
            } elseif(is_numeric($limit) && $limit > 0) {
                $sql .= ' LIMIT ' . $limit;
            }

            $replies = Post::query($sql, $post[0]->data['conversation_id'], $min_sort, $max_sort);
            $posts = array_merge($post, $replies);
        } else {
            //$replies = Post::where(['conversation_id' => $args['id'], 'status' => 'published'], $pagination);
            $sql = '
                SELECT * 
                FROM posts 
                WHERE conversation_id = ? 
                AND parent_id > 0 
                AND status = ? 
                ORDER BY sort_order ASC
            ';

            if(is_numeric($limit) && $limit > 0 && is_numeric($offset) && $offset > 0) {
                $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
            } elseif(is_numeric($limit) && $limit > 0) {
                $sql .= ' LIMIT ' . $limit;
            }

            $replies = Post::query($sql, $args['id'], 'published');
            $posts = array_merge($post, $replies);
        }

        return $posts;
    }

    public static function threadCount($args, $pagination) {
        // TODO: This probably should be a by() call and not have pagination data.
        $post = Post::where($args);

        $class = get_called_class();
        $quote = ao()->db->quote;
        $table = self::setTable($class);
        $limit = self::setLimit($pagination, $table);
        $page = self::setPage($pagination, $table);
        $offset = self::setOffset($pagination, $table);
        $url_default = self::setURL($pagination, $table);

        // Check if it is a child thread or the main thread.
        if($post[0]->data['depth']) {
            $depth = $post[0]->data['depth'] - 1;
            $sort_order = $post[0]->data['sort_order'];
            $depths = explode('/', $sort_order);

            $min = (int)$depths[$depth];
            $max = $min + 1;

            $min_sort = '';
            $max_sort = '';

            // Loop 10 times
            $looper = array_fill(0, 10, 1);
            $first = true;
            foreach($looper as $i => $loop) {
                if(!$first) {
                    $min_sort .= '/';
                    $max_sort .= '/';
                }

                if($i < $depth) {
                    $min_sort .= str_pad($depths[$i], 10, '0', STR_PAD_LEFT);
                    $max_sort .= str_pad($depths[$i], 10, '0', STR_PAD_LEFT);
                } elseif($i == $depth) {
                    $min_sort .= str_pad($min, 10, '0', STR_PAD_LEFT);
                    $max_sort .= str_pad($max, 10, '0', STR_PAD_LEFT);
                } else {
                    $min_sort .= '0000000000';
                    $max_sort .= '0000000000';
                }

                $first = false;
            }

            $sql = '
                SELECT * 
                FROM posts 
                WHERE conversation_id = ? 
                AND sort_order >= ? 
                AND sort_order < ? 
                ORDER BY sort_order ASC
            ';
            $raw = ao()->db->query($sql, $post[0]->data['conversation_id'], $min_sort, $max_sort);
        } else {
            $sql = '
                SELECT COUNT(id) AS total
                FROM posts 
                WHERE conversation_id = ? 
                AND status = ? 
                ORDER BY sort_order ASC
            ';
            $raw = ao()->db->query($sql, $args['id'], 'published');
        }

        $output = [];
        if(!isset($raw[0]['total'])) {
            $total_results = 0;
        } else {
            $total_results = $raw[0]['total'];
        }

        $output = [];
        $output['total_results'] = $total_results;
        $output['total_pages'] = ceil($total_results / $limit);
        if($page > 1) {
            $output['page_previous'] = $page - 1;
        } else {
            $output['page_previous'] = 1;
        }
        if($page < $output['total_pages']) {
            $output['page_next'] = $page + 1;
        } else {
            $output['page_next'] = $output['total_pages'];
        }
        $output['page_current'] = (int) $page;
        $output['current_page'] = (int) $page;
        $output['current_result'] = (($page - 1) * $limit) + 1;
        $output['current_result_first'] = (($page - 1) * $limit) + 1;
        if($page < $output['total_pages']) {
            $output['current_result_last'] = $page * $limit;
        } else {
            $output['current_result_last'] = $total_results;
        }
        $url_stripped = preg_replace('/page=\d+&?/', '', $url_default);
        if(strpos($url_stripped, '?') === false) {
            $output['url_next'] = $url_stripped . '?page=' . urlencode($output['page_next']);
            $output['url_previous'] = $url_stripped . '?page=' . urlencode($output['page_previous']);
        } else {
            $output['url_next'] = $url_stripped . '&page=' . urlencode($output['page_next']);
            $output['url_previous'] = $url_stripped . '&page=' . urlencode($output['page_previous']);
        }

        return $output;
    }
}
