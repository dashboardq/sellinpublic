<?php

namespace app\models;

use mavoc\core\Model;

class Attachment extends Model {
    public static $table = 'attachments';
    public static $order = ['sort_order' => 'asc']; 
}
