<?php 

// initialize benchmarking
global $start;
$start = microtime(true);

// configure error reporting level
error_reporting(E_ALL ^ E_NOTICE);

// set library and class location
define('APP', dirname(__FILE__) . '/../');
define('LIBRARY', APP . 'library/');
define('VIEWS', APP . 'views/');
define('CONFIG', APP . 'config/');

// load core function library
require LIBRARY . 'core.php';
require LIBRARY . 'db.php';
require LIBRARY . 'cache.php';

// define additional constants
define('R', config('application.baseurl'));
define('S', R . 'static/');

// create database connection instance
global $db;
$db = new Database(
    config('database.server.host'), 
    config('database.server.username'), 
    config('database.server.password'), 
    config('database.name')
);

global $cache;
if (class_exists('Memcache')) {
    $cache = new Memcache;
    $cache->connect(
        config('memcached.server.name'),
        config('memcached.server.port')
    );
    
    require LIBRARY . 'session.php';
    
    // set session save handler
    session_set_save_handler(
        "sess_open", 
        "sess_close", 
        "sess_read", 
        "sess_write", 
        "sess_destroy", 
        "sess_gc"
    );

    // register shutdown functions
    register_shutdown_function('session_write_close'); 
    
} else {
    $cache = new Cache;
}

// set timezone to UTC
date_default_timezone_set('UTC');

// register shutdown function
register_shutdown_function('shutdown');

?>
