<?php 
/**
 * Creates the AdminMenu item for the plugin.
 *
 * @package Custom_Admin_Settings
 */
 
/**
 * Creates the AdminMenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package Custom_Admin_Settings
 */
class AdminMenu {
 
    /**
* A reference the class responsible for rendering the AdminMenu page.
 *
 * @var    AdminMenu_Page
 * @access private
 */
private $AdminMenu_Page;

/**
 * Initializes all of the partial classes.
 *
 * @param AdminMenu_Page $AdminMenu_Page A reference to the class that renders the
 * page for the plugin.
 */
public function __construct( $AdminMenu_Page ) {
    $this->AdminMenu_Page = $AdminMenu_Page;
}

/**
 * Adds a AdminMenu for this plugin to the 'Tools' menu.
 */
public function init() {
     add_action( 'admin_menu', array( $this, 'add_options_page' ) );
}

/**
 * Creates the AdminMenu item and calls on the AdminMenu Page object to render
 * the actual contents of the page.
 */
public function add_options_page() {

    add_options_page(
        'Post icon',
        'Post icon',
        'manage_options',
        'post-icon-plugin',
        array( $this->AdminMenu_Page, 'render' )
    );
   
}
}
?>  