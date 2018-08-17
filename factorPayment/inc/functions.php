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

function wpf_show_factor($factor_code)
{
    global $wpdb, $table_prefix;
    $factor_item = $wpdb->get_row($wpdb->prepare(
        "
        SELECT *
        FROM {$table_prefix}factors
        WHERE factor_code = %s
        ", $factor_code
    ));
    if (is_null($factor_item)) {
        wp_redirect('/');
        exit();
    }
    if (isset($_POST['doPayment'])) {
        $payment_insert_result = $wpdb->insert($table_prefix . 'factor_payments', [
            'payment_factor_id' => $factor_item->factor_id,
            'payment_amount' => $factor_item->factor_amount,
            'payment_gateway' => 'سامان',
            'payment_res_num' => wpf_generate_res_num(),
            'payment_create_at' => date('Y-m-d H:i:s'),
            'payment_status' => 0,
        ]);
        if ($payment_insert_result) {
            $payment_id = $wpdb->insert_id;
            wpf_saman_payment_request($payment_id);
        }
    }
    wpf_load_view('front.factor.detail', compact('factor_item'));
}

function wpf_generate_res_num()
{
    return (int)microtime(true);
}

function wpf_verify_factor()
{
    global $wpdb, $table_prefix;

    $state = $_POST['State'];
    $ref_num = $_POST['RefNum'];
    $res_num = $_POST['ResNum'];
    $trace_number = $_POST['TRACENO'];

    $payment_item = $wpdb->get_row($wpdb->prepare("
    SELECT *
    FROM {$table_prefix}factor_payments
    WHERE payment_res_num = %s
    ", $res_num));

    $verify_result = wpf_saman_payment_verify($state, $ref_num, $res_num, $payment_item->payment_amount);
    if ($verify_result) {
        $wpdb->update($table_prefix . 'factor_payments', [
            'payment_ref_num' => $trace_number,
            'payment_paid_at' => date('Y-m-d H:i:s'),
            'payment_status' => 1
        ], [
            'payment_id' => $payment_item->payment_id
        ], ['%s', '%s', '%d'], ['%d']);
        $wpdb->update($table_prefix.'factors',[
            'factor_status' => 1
        ],[
            'factor_id' => $payment_item->payment_factor_id
        ],['%d'],['%d']);
    }
    wpf_load_view('front.payment.result', compact('payment_item','trace_number'));

}