<?php
/*
Plugin Name: سیستم فاکتور وردپرس
Plugin URI: http://www.tarminet.com
Description: مدیریت فاکتورها و پرداخت ها
Version: 1.0.0
Author: majid
Author URI: http://www.tarminet.com
Text Domain: tarminet.com
Domain Path: /languages
*/

defined('ABSPATH') || die('access denied!');

define('WPF_DIR', plugin_dir_path(__FILE__));
define('WPF_URL', plugin_dir_url(__FILE__));
define('WPF_VIEWS', WPF_DIR . 'views/');
define('WPF_ADMIN', WPF_DIR . 'admin/');
define('WPF_INC', WPF_DIR . 'inc/');
define('WPF_ASSETS', WPF_URL . 'assets/');

include WPF_INC . "gateways.php";
include WPF_INC . "functions.php";
include WPF_INC . "nusoap.php";
include WPF_ADMIN . "admin.php";

function wpf_check_factor_link()
{
    $current_url = wpf_get_current_url();
    if (preg_match('/factor\/([A-Za-z0-9]+)/', $current_url, $matches) != false) {
        $factor_code = $matches[1];
        wpf_show_factor($factor_code);
        exit();
    }
}

function wpf_verify_payment()
{
    $current_url = wpf_get_current_url();
    if (preg_match('/payment\/saman\/verify/', $current_url, $matches) != false) {
        wpf_verify_factor();
        exit();
    }
}

add_action('parse_request', 'wpf_check_factor_link');
add_action('parse_request', 'wpf_verify_payment');
