<?php

/*
Plugin Name: ERE Property Shorten URL
Description: Property Shorten URL plugin
Version: 1.0
Author: Techpad Solutions Inc.
Author URI: https://techpadsolutions.com
*/

require_once __DIR__ . '/env.php';

// Shorten URL
if (!function_exists('shorten_url')) {
    function shorten_url($url) {
        // create curl resource
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, TINYURL_API_CREATE);
        // set method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // set headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . TINYURL_API_KEY
        ]);
        // set post data
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['url' => $url]));
        // $output contains the output string
        $output = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch);
        // decode output
        $output = json_decode($output, true);
        // return shorten url
        return $output['data']['tiny_url'];
    }
}

// Add Shorten URL Meta Box
if (!function_exists('add_shorten_url_meta_box')) {
    function add_shorten_url_meta_box() {
        global $pagenow;
        if ('post-new.php' == $pagenow) {
            // do not show meta box on add new property
            return;
        }
        add_meta_box(
            'shorten_url_meta_box', // id
            'Shorten URL', // title
            'shorten_url_meta_box', // callback
            'property', // post type
            'side', // context (normal, advanced, side)
            'high' // priority (high, core, default, low)
        );
    }
}

// Shorten URL Meta Box
if (!function_exists('shorten_url_meta_box')) {
    function shorten_url_meta_box($post) {
        // get current post url
        $post_url = get_permalink($post->ID);
        // shorten url
        $shorten_url = shorten_url($post_url);
        // show url
        echo '<p>Shorten URL: <a href="' . $shorten_url . '" target="_blank">' . $shorten_url . '</a></p>';
    }
}

// Add Shorten URL Meta Box
add_action('add_meta_boxes', 'add_shorten_url_meta_box');