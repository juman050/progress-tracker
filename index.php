<?php
/**
 * Plugin Name: Training Progress
 * Plugin URI: https://www.fiverr.com/ahmedjuman
 * Description: The plugin is created to track user progress
 * Version: 1.0
 * Author: juman
 * Author URI: https://www.fiverr.com/ahmedjuman
 */

add_action('init', 'my_register_styles');
function my_register_styles() {

    add_action('admin_menu', 'menu_page_name');
}
function menu_page_name()
{
	$page_title = 'Training Progress';
    $menu_title = 'Progress';
    $capability = 'manage_options';
    $menu_slug = 'training-progress';
    $function = 'callback_main_menu';

    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function);
}
function callback_main_menu(){
	echo '<h3>Thank you for reading!</h3>';
	echo "<p>Please use shortcode <b>[training_progress]</b> to display data.</p>"; //for display
}


function training_progress_short_code(){
	//Return your functionality here
	include('t_progress.php');  

}

add_shortcode('training_progress', 'training_progress_short_code');


register_activation_hook( __FILE__, 't_progress_install' );
function t_progress_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'training_progress';
    $pf_parts_db_version = '1.0.0';
    $charset_collate = $wpdb->get_charset_collate();

    if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {

        $sql = "CREATE TABLE $table_name (
                        t_id int(11) NOT NULL AUTO_INCREMENT,
                        t_day int(11) NOT NULL,
					    t_morning int(11) NOT NULL,
					    t_evening int(11) NOT NULL,
					    user_id int(11) NOT NULL,
                        PRIMARY KEY  (t_id)
                        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        add_option( 'pf_parts_db_version', $pf_parts_db_version );
    }
}