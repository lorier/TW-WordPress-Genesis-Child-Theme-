<?php
/**
 * functions.php
 *
 */

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Tiny Whale Genesis Child' );
define( 'CHILD_THEME_URL', 'http://www.tinywhalecreative.com/' );
define( 'CHILD_THEME_VERSION', '0.0.1' );

/* Ensure any edits occur AFTER the genesis setup/bsg_load_lib_files (listed above) runs */
add_action( 'genesis_setup', 'tw_sitewide_edits', 16);
/* giant function of all my edits */
function tw_sitewide_edits(){
    remove_action( 'template_redirect', 'bsg_title_area_jumbotron_unit_on_front_page' );
    remove_filter('genesis_footer_creds_text', 'bsg_footer_creds_filter');
    add_filter ('genesis_footer_creds_text', 'tw_footer_creds_filter');
    remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
    add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
    remove_theme_support( 'genesis-inpost-layouts' );
    //unregister the secondary menu
    add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );
}

/* Include all php files in the /includes directory.
 * https://gist.github.com/theandystratton/5924570
 */
add_action( 'genesis_setup', 'bsg_load_lib_files', 15 );
function bsg_load_lib_files() {
    foreach ( glob( dirname( __FILE__ ) . '/lib/*.php' ) as $file ) { include $file; }
}

//add fonts via http://premium.wpmudev.org/blog/custom-google-fonts/
add_action('wp_enqueue_scripts', 'tw_google_fonts');
function tw_google_fonts() {
    $query_args = array(
    'family' => 'Open+Sans:400italic,600italic,700italic,400,700,600|Roboto+Slab:400,700',
    'subset' => 'latin,latin-ext',
    );
wp_register_style( 'google_fonts', add_query_arg( $query_args, "http://fonts.googleapis.com/css" ), array(), null );
}

add_action('genesis_before', 'add_facebook_button_header');
function add_facebook_button_header(){
    echo '<a href="https://www.facebook.com/pages/AAAA-Mini-Storage/212538458854664" id="facebook-button-header"><img src="'.get_stylesheet_directory_uri().'/tw-images/facebook.svg"/></a>';
}
add_action('genesis_before_footer', 'add_facebook_button_footer');
function add_facebook_button_footer(){
    echo '<a href="https://www.facebook.com/pages/AAAA-Mini-Storage/212538458854664" id="facebook-button-footer"><img src="'.get_stylesheet_directory_uri().'/tw-images/facebook.svg"/></a>';
}



// add_filter( 'genesis_do_subnav', 'genesis_child_nav', 10, 3 );
// function genesis_child_nav($nav_output, $nav, $args){
//     return $nav;
// }
/**
 * Section Menu
 * Displays the subpages of the current section
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/custom-secondary-menu
 */
add_action( 'genesis_before_header', 'be_section_menu' );
function be_section_menu() {
    // Only run on pages
    if( !is_page() )
        return;

    global $post;
    // LR The line below uses a deprecated method. Substituted a separate function to get the section id.
    //$section_id = empty( get_post_ancestors($post) ) ? $post->ID : end( $post->ancestors );
    $section_id = get_top_parent_page_id();
     // echo "<pre>The section id. This is the current page or its highest parent: "; print_r($section_id); echo "</pre>";

    // Get all the menu locations
    $locations = get_nav_menu_locations();
    // echo "<pre>Get the all the menu locations: "; print_r($locations); echo"</pre>";

    // Find out which menu is in the 'primary' location
    $menu = wp_get_nav_menu_object( $locations[ 'primary' ] );
     //echo "<pre>Contents of the menu object: "; print_r($menu); echo"</pre>";

    // Grab all menu items in this menu that have a parent of the current section.
    // This grabs the subpages, assuming the current section is a top level page
    // LR Get nav menu items from menu 2, where the post parent equals the section id
    // which is the ID of the current post we are viewing
    $menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'post_parent' => $section_id ) );
        // echo "<pre> Current menu item id "; print_r($all_menu_items); echo"</pre>";

    //get all menu items in the menu
    $all_menu_items = wp_get_nav_menu_items( $menu->term_id);
        // echo "<pre> Current menu item id "; print_r($all_menu_items); echo"</pre>";

    //is this the locations page? Using the page id since we have no title
    $locationsPage = get_the_ID($post->ID) == 18;
    $dbID = null;

    // If there are menu items, or if this is the locations page, build the menu
    if( !empty( $menu_items ) || ($locationsPage)) {
        echo '<div class="tw-submenu navbar-default">';
        echo '<div class="container">';
        echo '<div class="collapse navbar-collapse navbar-ex1-collapse">';
        echo '<ul class="nav navbar-nav">';
        $first = true;
        //get the custom links for the Locations page and put them in a subnav
        if($locationsPage){
            echo '<li class="locations-title menu-item"><h5>Two Locations: </h5></li>';
            foreach($all_menu_items as $item){
                if($item->title == 'Locations'){
                    $dbID = $item->db_id;
                }
                if ($item->menu_item_parent == $dbID){ //32 is the magic number. Need to get this programmatically
                    echo '<li class="subnav menu-item"><a href="' .get_permalink( $post->ID).$item->url . '">' . $item->title . '</a></li>';
                }
            }
        };
        //get and output the submenus for items that have them
        foreach( $menu_items as $menu_item ) {
            $classes = 'menu-item';
            // This adds a class to the first item so I can style it differently
            if( $first )
                $classes .= ' first-menu-item';
            $first = false;
            // This marks the current menu item
            if( get_the_ID() == $menu_item->object_id )
                $classes .= ' current-page-item';

            echo '<li class="' . $classes . '"><a href="' . $menu_item->url . '">' . $menu_item->title . '</a></li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

    }
}
//Utility function used by be_section_menu.
//Necessary due to a change in core since the
//above function was originally written
function get_top_parent_page_id() {
    global $post;
    $ancestors = $post->ancestors;
    // Check if page is a child page (any level)
    if ($ancestors) {
        //  Grab the ID of top-level page from the tree
        return end($ancestors);
    } else {
        // Page is the top level, so use  it's own id
        return $post->ID;
    }
}



////////////////////////////////////////////
//register sidebar for footer content
// http://my.studiopress.com/tutorials/register-widget-area/
// what's missing from the above tutorial is that you must add the genesis_register_sidebar to the genesis setup queue
add_action( 'genesis_setup', 'tw_register_sidebars');
function tw_register_sidebars(){
    genesis_register_sidebar( array(
        'name' => 'Ratings and Affiliations',
        'id' => 'footer-sidebar-1',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class=" %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
        ) );
    genesis_register_sidebar( array(
        'name' => 'Burien Location Address/Hours',
        'id' => 'footer-sidebar-2',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class=" %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
        ) );
    genesis_register_sidebar( array(
        'name' => 'South Seattle Location Address/Hours',
        'id' => 'footer-sidebar-3',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class=" %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
        ) );
};


/* Enable LiveReload. Compatible with MAMP Source: http://robandlauren.com/2014/02/05/live-reload-grunt-wordpress/ */

add_action( 'wp_enqueue_scripts', 'tw_setup_livereload');
function tw_setup_livereload(){

    if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
      wp_register_script('livereload', 'http://localhost:35729/livereload.js?snipver=1', null, false, true);
      wp_enqueue_script('livereload');
    }
}



//Wrap the footer in markup so we can have a full-width border on top
add_action('genesis_before_footer', 'add_footer_wrap');
function add_footer_wrap(){
    echo '<div id="footer-wrap">';
}
add_action('genesis_after_footer', 'end_footer_wrap');
function end_footer_wrap(){
    echo '</div">';
}

////Footer information
// Hard-coding this for now. Could use http://www.advancedcustomfields.com/add-ons/options-page/ plugin to
// create sitewide options for use in the footer
add_action('genesis_footer', 'add_footer_content');
function add_footer_content(){
    //register a  widget for the footer addresses


    echo '<div class="container"><div class="row">';

            echo '<div id="footer-sidebar" class="secondary">';
               echo  '<div class="col-md-8 col-md-push-4">';
               echo '<div class="row">';
                echo '<div class="col-md-6 footer-cols" id="footer-sidebar2">';

                        if(is_active_sidebar('footer-sidebar-2')){
                            dynamic_sidebar('footer-sidebar-2');
                        }

                    echo '</div>';
                    echo '<div class="col-md-6 footer-cols" id="footer-sidebar3">';

                        if(is_active_sidebar('footer-sidebar-3')){
                            dynamic_sidebar('footer-sidebar-3');
                        }
                    echo '</div>';

            echo '</div><!--end inner row-->';
            echo '</div><!--end outer col-->';
            echo  '<div class="col-md-4 col-md-pull-8">';
                   echo '<div class="row">';

                    echo '<div class="col-md-12 footer-cols" id="footer-sidebar1">';
                        if(is_active_sidebar('footer-sidebar-1')){
                            dynamic_sidebar('footer-sidebar-1');
                        }
                    echo '</div>';
                echo '</div><!--end inner row-->';
            echo '</div>';
        echo '</div><!--end footer-sidebar-->';
    echo '</div></div><!--end row and container-->';
}

function tw_footer_creds_filter( $creds ) {
    echo '<div class="creds"><p>';
    echo 'Copyright &copy; ';
    echo date('Y');
    echo ' &middot; AAAA Ministorage. All rights reserved.';
    echo '</p></div>';
}


////////////////////////////
//Miscellaneous Page functions


