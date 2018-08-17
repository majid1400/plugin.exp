<?php
function wpf_saman_payment_request($payment_id)
{
    global $wpdb, $table_prefix;
    $payment_item = $wpdb->get_row($wpdb->prepare(
        "SELECT *
        FROM {$table_prefix}factor_payments
        WHERE payment_id = %d",
        $payment_id));

    if (is_null($payment_item)) {
        return false;
    }

    $mid = '12345678';
    $amount = $payment_item->payment_amount;
    $res_num = $payment_item->payment_res_num;
    $callback_url = home_url('/payment/saman/verify');

    $send_atu = "<script language='JavaScript' type='text/javascript'>
                    document.getElementById('checkout_confirmation').submit();
                 </script>";

    echo '<form id="checkout_confirmation" method="post" action="https://sep.shaparak.ir/Payment.aspx">
<input type="hidden" id="Amount" name="Amount" value="' . esc_attr($amount) . '">
<input type="hidden" id="MID" name="MID" value="' . esc_attr($mid) . '">
<input type="hidden" id="ResNum" name="ResNum" value="' . esc_attr($res_num) . '">
<input type="hidden" id="RedirectURL" name="RedirectURL" value="' . esc_attr($callback_url) . '">
</form>' . $send_atu;

}

function wpf_saman_payment_verify($state, $ref_num, $res_num, $factor_amount)
{

    if (!class_exists('nusoap_client')) {
        require_once WPF_INC . 'nusoap.php';
    }

    $mid = '';

    if ($state != 'OK') {
        return false;
    }
    $soap_client = new nusoap_client('https://sep.shaparak.ir/payments/referencepayment.asmx?wsdl', 'wsdl');
    $soapProxy = $soap_client->getProxy();
    $amount = $soapProxy->VerifyTransaction($ref_num, $mid);
    if ($amount <= 0) {
        return false;
    }
    if ($factor_amount != $amount){
        return false;
    }
    return true;
}