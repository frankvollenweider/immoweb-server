<?php

define('VIEW_API', 'api');
define('VIEW_INDEX', 'index');

/**
 * Get a configuration variable by path.
 * 
 * Usage:
 * $title = config('application.title'); 
 *
 * @param var Name of the variable
 * @param value Default value to return if the variable is not set
 */
function config($var, $value = null) {
    global $config;
    if ($config == null) {
        require CONFIG . 'config.php';
        $private_config = CONFIG . 'config-private.php';
        if (file_exists($private_config)) {
        	require $private_config;
        }
    }
    return isset($config[$var]) ? $config[$var] : $value;
}

/**
 * Perform application shutdown tasks.
 */
function shutdown() {
    global $start;
    echo "\n<!-- " . round(microtime(true) - $start, 4) . "s -->";
}

/**
 * Returns current users ID. If anonymous, null will be returned.
 */
function userid() {
    return user('id');
}

/**
 * Returns current users name. If anonymous, null will be returned.
 */
function user($field) {
    return $_SESSION['user'][$field];
}

/**
 * Returns, whether the current user is authenticated or not
 * @return true if authenticated, false otherwise
 */
function authenticated() {
    return $_SESSION['auth'] == md5(config('security.password.hash') . $_SESSION['user']['id']);
}

/**
 * Locks a specific script for unauthenticated requests.
 */
function lock() {
    if (!authenticated()) {
        header('Location: ' . R . 'auth/?referer=' . $_SERVER['REQUEST_URI']);
        exit();
    }
}

?>