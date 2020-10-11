<?php

add_action( 'wp_ajax_remove_icon_from_post', 'remove_icon_from_post' );

function remove_icon_from_post() {
    
    $post_id = $_POST['post_id'];  
    update_post_meta(  $post_id, 'icon_status', 0 ); 
    echo  $post_id;
    wp_die();  
    
}