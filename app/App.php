<?php

namespace app;

use app\models\Restriction;
use app\models\Setting;
use app\models\User;

use app\services\APIService;

use mavoc\core\Exception;

use DateTime;
use DateTimeZone;

class App {
    public $debug;

    public function init() {
		// Run migrations if the user is not running a command line command and the db needs to be migrated.
		if(!defined('AO_CONSOLE_START') && ao()->env('DB_USE') && ao()->env('DB_INSTALL')) {
			ao()->once('ao_db_loaded', [$this, 'install']);
		} 

        ao()->filter('ao_response_partial_args', [$this, 'cacheDate']);
        ao()->filter('ao_response_partial_args', [$this, 'partials']);
        ao()->filter('ao_model_process_dates_timezone', [$this, 'processTimezone']);

        ao()->filter('helper_wordify_output', [$this, 'wordify']);
        ao()->filter('helper_split_input', [$this, 'splitInput']);

        ao()->filter('ao_router_logged_in_private', [$this, 'apiRestrictionCheck']);
    }

    // Checks if the API access allows private access.
    public function apiRestrictionCheck($user_id, $req, $res) {
        if($req->type == 'api') {
            $restriction = Restriction::get($user_id);
            if($restriction['premium_level'] == 0) {
                throw new Exception('In order to access a private endpoint you need to have a pro account. Please upgrade to a pro account to access this endpoint.', '', 401, 'json');
            }
        }
        return $user_id;
    }

    public function cacheDate($vars, $view, $req, $res) {
        if($view == 'head' || $view == 'foot') {
            $vars['cache_date'] = '2024-03-09';
        }

        return $vars;
    }

    public function install() {
        try {
            $count = User::count();
        } catch(\Exception $e) {
            //ao()->command('work');
            ao()->command('mig init');
            ao()->command('mig up');

            // Redirect to home page now that the database is installed.
            header('Location: /');
            exit;
        }
    } 

    public function partials($vars, $view, $req, $res) {
        if($view == 'sidebar_account') {
            $response = APIService::call('/notifications/count/unread', [], $req, $res);
            $vars['notification_count'] = $response['data'];
        }

        return $vars;
    }

    public function processTimezone($timezone, $table) {
        // We don't want to end up in an infinite loop call Setting::get() over and over 
        if($table == 'settings') {
            return $timezone;
        }

        $timezone = Setting::get(ao()->request->user_id, 'timezone');
        return $timezone;
    }

    public function splitInput($input) {
        if(substr($input, 0, 3) == 'API') {
            $input = 'Api' . substr($input, 3);
        }
        return $input;
    }

    // Uppercase the title
    public function wordify($input) {
        $output = str_replace('Sellinpublic', 'SellInPublic', $input);
        return $output;
    }
}

function handlify($input) {
    // Add handle links (similar to linkify)

    $base = ao()->env('APP_SITE');

    $output = preg_replace("/(?i)\b((?:(?<=@)[a-z0-9]+(?:[.\-][a-z0-9]+)*[.](?:com|net|org|edu|gov|mil|aero|asia|biz|cat|coop|info|int|jobs|mobi|museum|name|post|pro|tel|travel|xxx|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|dd|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|Ja|sk|sl|sm|sn|so|sr|ss|st|su|sv|sx|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)\b\/?(?!@)))/", '<a href="' . $base . '/$1">$1</a>', $input);

    // Parse non-domain based handles
    $output = preg_replace("/(?i)\b((?:(?<=@)[A-Za-z0-9_]+))/", '<a href="' . $base . '/$1">$1</a>', $output);

    return $output;
}
