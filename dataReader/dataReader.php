<?php
/*
Plugin Name: Data Reader Widget
Plugin URI: https://www.7learn.com
Description:  نمایش مطلب وب سایت های دیگر
Author: Kaivan Alimohammadi<keivan.amohamadi@gmail.com>
Version: 1.0.0
Author URI: https://www.7learn.com
*/

function data_reader_widget_callback()
{
    $response = wp_remote_get('https://hamyarwp.com/wp-json/wp/v2/posts');
    if(is_array($response) && !is_wp_error($response))
    {
        $content = $response['body'];
        $posts = json_decode($content);
    }
    ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li><a href="<?php echo $post->link; ?>">
                    <?php
                    $title = $post->title;
                    echo $title->rendered;
                    ?>
                </a></li>
        <?php endforeach; ?>
    </ul>
    <?php
}
function add_data_reader_widget()
{
    wp_add_dashboard_widget('data_reader_widget','اطلاعات وب سایت','data_reader_widget_callback');
}
add_action('wp_dashboard_setup','add_data_reader_widget');
