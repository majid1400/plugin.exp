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