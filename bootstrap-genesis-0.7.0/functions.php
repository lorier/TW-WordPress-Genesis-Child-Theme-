<?php
/**
 * functions.php
 *
 */

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Tiny Whale Genesis Child' );
define( 'CHILD_THEME_URL', 'http://www.tinywhalecreative.com/' );
define( 'CHILD_THEME_VERSION', '0.0.1' );
/**
 * Include all php files in the /includes directory
 *
 * https://gist.github.com/theandystratton/5924570
 */
add_action( 'genesis_setup', 'bsg_load_lib_files', 15 );


function bsg_load_lib_files() {
    foreach ( glob( dirname( __FILE__ ) . '/lib/*.php' ) as $file ) { include $file; }
}


/** LR/TW Functions start here */
/* Enable LiveReload. Compatible with MAMP Source: http://robandlauren.com/2014/02/05/live-reload-grunt-wordpress/ */

add_action( 'wp_enqueue_scripts', 'tw_setup_livereload');


function tw_setup_livereload(){

    if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
      wp_register_script('livereload', 'http://localhost:35729/livereload.js?snipver=1', null, false, true);
      wp_enqueue_script('livereload');
    }
}

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
    add_theme_support ( 'genesis-menus' , array ( 'primary' => 'Primary Navigation Menu' , 'secondary' => 'Secondary Navigation Menu' ,'tertiary' => 'Footer Navigation Menu' ) );
}

////footer information
// Hard-coding this for now. Could use http://www.advancedcustomfields.com/add-ons/options-page/ plugin to
// create sitewide options for use in the footer
add_action('genesis_footer', 'add_footer_content');

function add_footer_content(){
    echo '<div class="row">';
    $output = <<<EOT
         <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">[LOGO]</div>
                <div class="col-md-4">[LOGO]</div>
                <div class="col-md-4">[LOGO]</div>
            </div>
        </div>
        <div class="col-md-3">
            <p>Address 1</p>
        </div>
        <div class="col-md-3">
            <p>Address 2</p>
        </div>
EOT;
    echo $output;
    echo '</div>';
}

function tw_footer_creds_filter( $creds ) {
    echo '<div class="creds"><p>';
    echo 'Copyright &copy; ';
    echo date('Y');
    echo ' &middot; AAAA Ministorage. All rights reserved.';
    echo '</p></div>';
}


////////DEAD CODE//////

//Footer Menu
//Courtesy https://wpbeaches.com/add-footer-menu-genesis-child-theme/
function tw_footer_menu () {
  echo '<div class="footer-menu-container">';
    $args = array(
            'theme_location'  => 'tertiary',
            'container'       => 'nav',
            'container_class' => 'wrap',
            'menu_class'      => 'menu genesis-nav-menu menu-tertiary',
            'depth'           => 1,
        );
    wp_nav_menu( $args );
  echo '</div>';
}

