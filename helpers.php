<?php

use Recruitee\Log;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit();
}

if (!function_exists('write_log')) {
    function write_log($message, $message_type = null) {
        if (is_array($message) || is_object($message)) {
            $message = json_encode($message);
        }
        (new Log(REC_PLUGIN_DIR . '/logs'))->notice($message);
    }
}

if (!function_exists('get_wp_version')) {
    function get_wp_version() {
        global $wp_version;
        return $wp_version;
    }
}

if (!function_exists('htmlspecialchars_array_recursive')) {
    function htmlspecialchars_array_recursive($array) {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = htmlspecialchars_array_recursive($value);
            } else {
                $value = htmlspecialchars($value, ENT_QUOTES);
            }
        }
        unset($value);
        return $array;
    }
}