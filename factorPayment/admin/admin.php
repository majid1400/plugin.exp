<?php
function wpf_main_page(){
    global $wpdb,$table_prefix;
    $table_factors = $table_prefix.'factors';
    $factors = $wpdb->get_results("SELECT * FROM {$table_factors}");
    wpf_load_view('admin.dashboard.index',compact('factors'));
}

function wpf_add_menu_page(){
    add_menu_page(
        'فاکتورها',
        'فاکتورها',
        'manage_options',
        'wpf_factors',
        'wpf_main_page'
    );
}

add_action('admin_menu','wpf_add_menu_page');