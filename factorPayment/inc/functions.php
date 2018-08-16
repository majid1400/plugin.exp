<?php
function wpf_load_view($view, $params = array()) // admin.dashboard.index
{
    $view = str_replace('.', DIRECTORY_SEPARATOR, $view);
    $view_file_path = WPF_VIEWS . $view . '.php';
    if (file_exists($view_file_path) && is_readable($view_file_path)) {
        !empty($params) ? extract($params) : null;
        include $view_file_path;
    }
}

function wpf_generator_code($length = 10)
{
    return bin2hex(random_bytes($length / 2));
}

function wpf_status($status_code)
{
    $class_css = 'wpf_status_error';
    $txt_name = 'پرداخت نشده';
    if ($status_code == 1) {
        $class_css = 'wpf_status_success';
        $txt_name = 'پرداخت شده';
    }
    return "<span class='wpf_status {$class_css}'>{$txt_name}</span>";
}

function wpf_amount($amount)
{

    $result = number_format($amount);
    return wpf_numbers_persian($result);
}

function wpf_numbers_persian($numbers)
{
    $persian_numbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $en_numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    return str_replace($en_numbers, $persian_numbers, $numbers);
}

function wpf_date_persian($en_date)
{
    if (!empty($en_date)) {
        list($date, $time) = explode(' ', $en_date);
        list($y, $m, $d) = explode('-', $date);
        $persian_date = gregorian_to_jalali($y, $m, $d);
        $result = implode('-', $persian_date) . ' ' . $time;
        return wpf_numbers_persian($result);
    }

}

function wpf_get_current_url()
{
    return $_SERVER['REQUEST_URI'];
}

function wpf_show_factor($factor_code){
    global $wpdb,$table_prefix;
    $factor_item = $wpdb->get_row($wpdb->prepare(
        "
        SELECT *
        FROM {$table_prefix}factors
        WHERE factor_code = %s
        ", $factor_code
    ));
    if (is_null($factor_item)){
        wp_redirect('/');
        exit();
    }
    wpf_load_view('front.factor.detail',compact('factor_item'));
}