<?php

add_action( 'wp_ajax_update_post_title', 'update_post_title' );

function update_post_title() {
 

    $icon_name = $_POST['icon_name'];
    $arrPosts = $_POST['arrPosts'];
    $icon_position = $_POST['icon_position'];
    
    foreach ($arrPosts as $value) {
        update_post_meta( $value, 'icon_status', 1 ); 
    } 

    global $wpdb;
    $table_name = $wpdb->prefix . 'post_icon';

    $wpdb->update($table_name, array('post_icon' => $icon_name, 'icon_position' => $icon_position),array( 'ID' => 1 ), array( '%s', '%s'));

	wp_die();  
}