<?php
/*
 * Plugin Name: Post icon
 * Plugin URI: https://github.com/VladimirMorozov1994/Post-icon
 * Description: WordPress plugin that adds an icon to the end of the post titles specified in the plugin settings.
 * Version: 1.0.0
 * Author: Vladimir Morozov 
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Include the dependencies needed to instantiate the plugin.
foreach ( glob( plugin_dir_path( __FILE__ ) . 'includes/*.php' ) as $file ) {
   include_once $file;
}

add_action( 'plugins_loaded', 'post_icon_custom_admin_settings' );
/**
* Starts the plugin.
*
* @since 1.0.0
*/
function post_icon_custom_admin_settings() {

   $plugin = new AdminMenu( new AdminMenu_Page() );
   $plugin->init();

}

// register jquery and style 
function enqueued_assets() {
    wp_enqueue_script('my-js-file', plugin_dir_url(__FILE__) . '/js/post-icon-script.js', '', time());
    wp_enqueue_style('my-css-file', plugin_dir_url(__FILE__) . '/css/post-icon-style.css', '', time());

    wp_register_script( 'update_post_title', plugin_dir_url(__FILE__) . '/js/update-post-title.js', array('jquery') );
	wp_localize_script( 'update_post_title', 'update_post_title', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php' 
    ) );
    wp_enqueue_script( 'update_post_title' );
}
add_action('admin_enqueue_scripts', 'enqueued_assets');

function load_dashicons(){
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'load_dashicons');
 
// Create table in database
register_activation_hook( __FILE__, 'my_plugin_create_db' );
function my_plugin_create_db() {
    global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'post_icon';
    
    if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name ) {
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT, 
		post_icon text NOT NULL, 
        icon_position text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );  
    $wpdb->insert($table_name, array('post_icon' => '0', 'icon_position' => "0"), array( '%s', '%s'));
    }
}
 
// function for links (activate/deactivate)
function na_action_link( $plugin, $action = 'activate' ) {
    if ( strpos( $plugin, '/' ) ) {
        $plugin = str_replace( '\/', '%2F', $plugin );
    }
    $url = sprintf( admin_url( 'plugins.php?action=' . $action . '&plugin=%s&plugin_status=all&paged=1&s' ), $plugin );
    $_REQUEST['plugin'] = $plugin;
    $url = wp_nonce_url( $url, $action . '-plugin_' . $plugin );
    return $url;
}

// Add link Settings
function plugin_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=post-icon-plugin">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
    return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );