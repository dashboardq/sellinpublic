<?php

namespace app;

// Useful for temporary code additions. This file is in the .gitignore file.
class Debug {
    public function init() {
        //ao()->filter('ao_some_hook', [$this, 'debug']);

        ao()->filter('ao_final_exception_redirect', [$this, 'finalException']);
    }

    public function finalException($redirect, $e) {
        echo 'died before redirect';
        dd($e);
    }

    public function debug($data) {
        // Add some debug code here.

        return $data;
    }
}
