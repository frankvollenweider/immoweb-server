<?php

require getcwd() . '/../application/library/bootstrap.php';

// start session
session_start();

// define route
$route = str_replace('?' . $_SERVER['QUERY_STRING'], '', explode('/', $_SERVER['REQUEST_URI']));

// whitelisting, the pragmatic way...
define('API_EXAMPLE', 'example');

$api = $route[1];

switch ($api) {
    case API_EXAMPLE:
        if (!is_file(LIBRARY . 'api/' . strtolower($api) . '.php')) {
            die('api not available');
        }
        $action = $api . '.' . $route[2];
        require LIBRARY . 'api/' . strtolower($api) . '.php';
        break;
}
