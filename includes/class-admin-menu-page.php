<?php
/**
 * Creates the AdminMenu page for the plugin.
 *
 * @package Custom_Admin_Settings
 */
 
/**
 * Creates the AdminMenu page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the AdminMenu with which this page is associated.
 *
 * @package Custom_Admin_Settings
 */
class AdminMenu_Page {
 
    /**
     * This function renders the contents of the page associated with the AdminMenu
     * that invokes the render method. In the context of this plugin, this is the
     * AdminMenu class.
     */
    public function render() { 
        echo '<a class="deactivate-link" href="'.na_action_link( 'post-icon/post-icon.php', 'deactivate').'">Disable</a>';
        global $wpdb;
        $table_name = $wpdb->prefix . 'post_icon';
        $resultat = $wpdb->get_results( "SELECT * FROM {$table_name}");

        $active_icon = $resultat[0]->post_icon;

        // Takes raw data from the request
        $url = plugin_dir_path( __FILE__ ) ."icons.json"; // original file url https://github.com/WordPress/dashicons/blob/master/codepoints.json
        $string = file_get_contents($url);
        if ($string === false) {
            echo "error";
        }
        
        $json_a = json_decode($string, true);
        
        echo '<div class="posts-dashicons-icon-list"><h1>Select Icon:</h1><br><div class="icon-box">';
        foreach ($json_a as $key => $v) {
            if($key == $active_icon){
                echo '<span id="'.$key.'" class="dashicons dashicons-'.$key.' active"></span>';
            } else {
                echo '<span id="'.$key.'" class="dashicons dashicons-'.$key.'"></span>';
            }
            
        }
        echo '</div></div>';

        // the query
        
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'post',
            'post_status' => 'publish'
        );
        $the_query = new WP_Query( $args ); 
        $i = 0;
        $posts_vith_icon = [];
        if ( $the_query->have_posts() ) { ?>
        <div class="post-icon-box">
            <h1>Select Post Title : </h1> 
            
            <div class="post-icon-post-titles">

            <div class="dropdown">
            <button onclick="openPostsDropdown()" class="dropbtn-post-icon">Posts</button>
            <div id="PostsDropdown" class="dropdown-content show">
                <input type="text" placeholder="Search.." id="PostsInput" onkeyup="filterFunction()">

                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); $i++;
                $values = get_post_meta( get_the_ID(), 'icon_status' ); 
                if($values[0] != '1'){
                ?>

                    <a href="<?php echo get_the_ID();?>"><?php the_title(); ?></a>  
                     
                <?php 
                } else {
                    echo '<a href="'. get_the_ID().'" class="hidden">'.get_the_title().'</a>';  
                    $posts_vith_icon[$i] = get_the_ID();
                }
                endwhile;  

            echo'</div></div></div></div>';
            wp_reset_postdata();  
        }  ?>
        <div class="post-icon-box">
            
        <div class='selected-posts'>
            <?php 
                foreach ($posts_vith_icon as $value) {
                    echo '<p id="'.$value.'">'.get_the_title($value).'<button>Remove</button></p>';
                }
            ?>
        </div>
        <div class='icon-position'>
            <h1>Icon Position : </h1> 
            <button class='position-left <?php if($resultat[0]->icon_position == "Left"){ echo ' active';}?> '>Left</button>
            <button class='position-right <?php if($resultat[0]->icon_position == "Right"){ echo ' active';}?> '>Right</button>
        </div>
        
        <button class="save save-posts-info">Save</button>

        </div>
        <?php
    }
}