<?php

add_filter('the_title', 'new_title', 10, 2);

function new_title($title, $id) {
    $values = get_post_meta($id, 'icon_status' ); 

    if($values[0] != '1'){
        return $title;
    } else {
        global $wpdb;
        $table_name = $wpdb->prefix . 'post_icon';
        $resultat = $wpdb->get_results( "SELECT * FROM {$table_name}");
        
        if($resultat[0]->icon_position == "Left"){
            $title = '<span class="dashicons dashicons-'.$resultat[0]->post_icon.'"> </span>'.$title; 
        } else {
            $title = $title.'<span class="dashicons dashicons-'.$resultat[0]->post_icon.'"></span>'; 
        }
    
      return $title;
    } 
}