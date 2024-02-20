<?php

if (!defined('ABSPATH')) {
    // redirect to root
    header('Location: /');
    die;
}

// TINYURL API URL
define('TINYURL_API', 'https://api.tinyurl.com');

// TINYURL API Key
define('TINYURL_API_KEY', 'your-tinyurl-api-key-here');

// TINYURL API Create URL
define('TINYURL_API_CREATE', TINYURL_API . '/create');