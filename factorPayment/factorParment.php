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

include WPF_INC . "functions.php";
include WPF_ADMIN . "admin.php";
