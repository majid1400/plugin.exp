<?php
function wpf_main_page(){
    wpf_load_view('admin.dashboard.index');
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