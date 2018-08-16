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

function wpf_amount($amount){
    $persian_numbers = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    $en_numbers = ['0','1','2','3','4','5','6','7','8','9'];
    $result = number_format($amount);
    return str_replace($en_numbers,$persian_numbers,$result);
}