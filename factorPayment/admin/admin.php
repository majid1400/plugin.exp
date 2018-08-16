<?php
function wpf_new_factors_page()
{
    global $wpdb, $table_prefix;
    if (isset($_POST['save_new_factor'])) {
        $user_id = $_POST['user_id'];
        $amount = $_POST['amount'];
        $description = $_POST['description'];
        $expired_at = $_POST['expired_at'];
        $newDAtaFactor = [
            'factor_code' => wpf_generator_code(),
            'factor_user_id' => $user_id,
            'factor_amount' => $amount,
            'factor_description' => $description,
            'factor_created_at' => date('Y-m-d H:i:s'),
            'factor_updated_at' => date('Y-m-d H:i:s'),
            'factor_expired_at' => !empty($expired_at) ? $expired_at : null,
            'factor_status' => 0
        ];
        $wpdb->insert($table_prefix . 'factors', $newDAtaFactor, [
            '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%d'
        ]);
    }
    wpf_load_view('admin.factor.newFactor');
}

function wpf_main_page()
{
    global $wpdb, $table_prefix;
    $table_factors = $table_prefix . 'factors';
    $factors = $wpdb->get_results("SELECT * FROM {$table_factors}");
    wpf_load_view('admin.dashboard.index', compact('factors'));
}

function wpf_add_menu_page()
{
    add_menu_page(
        'فاکتورها',
        'فاکتورها',
        'manage_options',
        'wpf_factors',
        'wpf_main_page'
    );

    add_submenu_page(
        'wpf_factors',
        'ایجاد فاکتور',
        'ایجاد فاکتور',
        'manage_options',
        'wpf_new_factors',
        'wpf_new_factors_page'
    );
}

add_action('admin_menu', 'wpf_add_menu_page');