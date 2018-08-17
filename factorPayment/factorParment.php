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
register_activation_hook(__FILE__, 'wpf_activation');
register_deactivation_hook(__FILE__, 'wpf_deactivation');
register_uninstall_hook(__FILE__, 'wpf_uninstall');

function wpf_activation()
{
    global $wpdb, $table_prefix;
    $wpdb_collate = $wpdb->collate;

    $factor_sql_query = 'CREATE TABLE IF NOT EXISTS `' . $table_prefix . 'factors` (
			  `factor_id` int(11) NOT NULL AUTO_INCREMENT,
			  `factor_code` varchar(50) COLLATE utf8_persian_ci NOT NULL,
			  `factor_user_id` int(11) NOT NULL,
			  `factor_amount` int(11) NOT NULL,
			  `factor_description` text COLLATE utf8_persian_ci,
			  `factor_created_at` datetime NOT NULL,
			  `factor_updated_at` datetime NOT NULL,
			  `factor_expired_at` datetime DEFAULT NULL,
			  `factor_status` tinyint(2) NOT NULL,
			  PRIMARY KEY (`factor_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;';
    $payment_sql_query = 'CREATE TABLE IF NOT EXISTS `' . $table_prefix . 'factor_payments` (
					  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
					  `payment_factor_id` int(11) NOT NULL,
					  `payment_amount` int(11) NOT NULL,
					  `payment_gateway` varchar(20) COLLATE utf8_persian_ci NOT NULL,
					  `payment_res_num` varchar(60) COLLATE utf8_persian_ci NOT NULL,
					  `payment_ref_num` varchar(60) COLLATE utf8_persian_ci DEFAULT NULL,
					  `payment_created_at` datetime NOT NULL,
					  `payment_paid_at` datetime DEFAULT NULL,
					  `payment_status` tinyint(1) NOT NULL,
					  PRIMARY KEY (`payment_id`)
					) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
					';
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($factor_sql_query);
    dbDelta($payment_sql_query);
}

function wpf_deactivation()
{

}

function wpf_uninstall()
{
    global $wpdb, $table_prefix;
//	$wpdb->query("DROP TABLE {$table_prefix}factors");
}

