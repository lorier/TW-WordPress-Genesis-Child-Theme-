<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.0.1' );

//* Enqueue styles
add_action( 'wp_enqueue_scripts', 'genesis_jano_styles' );
function genesis_jano_styles() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'google-font-droidserif', '//fonts.googleapis.com/css?family=Droid+Serif:400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'one-jan', get_stylesheet_directory_uri() . '/css/one-jan.css' );
}

//** Enqueue scripts for smooth scrolling
 
add_action( 'wp_enqueue_scripts', 'one_jan_smooth_scroll' );
function one_jan_smooth_scroll() {
 
	wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
	wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
	wp_enqueue_script( 'scrollto-init', get_stylesheet_directory_uri() . '/js/scrollto-init.js', array( 'localScroll' ), '', true );
 
}


// Register responsive menu script
add_action( 'wp_enqueue_scripts', 'jano_enqueue_scripts' );
function jano_enqueue_scripts() {
 
	wp_enqueue_script( 'jano-responsive-menu', get_stylesheet_directory_uri() . '/js/mobile-menu.js', array( 'jquery' ), '1.0.0', true ); // Change 'prefix' to your theme's prefix
 
}

//* Enqueue Parallax on non handhelds i.e., desktops, laptops etc. and not on tablets and mobiles
add_action( 'wp_enqueue_scripts', 'enqueue_animate' );
function enqueue_animate() {
	// Source: http://daneden.github.io/animate.css/
	wp_enqueue_style( 'animate', get_stylesheet_directory_uri() . '/css/animate.css' );
		wp_enqueue_script( 'waypoints', get_stylesheet_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'waypoints-init', get_stylesheet_directory_uri() .'/js/waypoints-init.js' , array( 'jquery', 'waypoints' ), '1.0.0' );
}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );



// Customize breadcrumbs display
add_filter( 'genesis_breadcrumb_args', 'jano_breadcrumb_args' );
 
// Reposition the breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' );
 
// Customize breadcrumbs display
function jano_breadcrumb_args( $args ) {
	$args['home'] = 'Home';
	$args['sep'] = ' / ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb"><div class="wrap">';
	$args['suffix'] = '</div></div>';
	$args['labels']['prefix'] = '<span class="home"></span>';
	return $args;
}

add_filter ( 'genesis_home_crumb', 'jano_breadcrumb_home_link' ); // Genesis >= 1.5
function jano_breadcrumb_home_link( $crumb ) {
     $crumb = '<a href="' . home_url() . '" title="' . get_bloginfo('name') . '"><i class="fa fa-home"></i></a>';
     return $crumb;
}

add_image_size( 'post-thumb', 800, 450, TRUE );
add_image_size( 'portfolio', 800, 600, TRUE );


//* Register Widgets
genesis_register_sidebar( array(
	'id'				=> 'portfolio',
	'name'			=> __( 'Portfolio', 'jano' ),
	'description'	=> __( 'This is the Portfolio page.', 'jano' ),
) );

genesis_register_sidebar( array(
	'id'				=> 'home-blog',
	'name'			=> __( 'Home Blog', 'jano' ),
	'description'	=> __( 'This is the Home Blog Widget.', 'jano' ),
) );

genesis_register_sidebar( array(
	'id'				=> 'home-social',
	'name'			=> __( 'Social Contact', 'Jano' ),
	'description'	=> __( 'This is the Home Social Widget.', 'jano' ),
) );


//* Remove tagline from header
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );



// Inner Header thanks to Sridhar Katakam @srikat

//* Register widget areas

//* Register Header Right Inner Primary sidebar for use on inner pages

genesis_register_sidebar( array(
	'id'          => 'header-right-inner',
	'name'        => __( 'Header Right Inner', 'jano' ),
	'description' => __( 'This is the header right inner sidebar.', 'jano' ),
) );

//* Show Header Right Inner widget area in Header Right location on all pages other than homepage
add_action( 'genesis_before_header', 'jano_repace_header_right_sidebar' );
function jano_repace_header_right_sidebar() {

	if( is_home() )
		return;

	remove_action( 'genesis_header', 'genesis_do_header' );
	add_action( 'genesis_header', 'genesis_do_inner_header' );

}

function genesis_do_inner_header() {

	genesis_markup( array(
		'html5'   => '<div %s>',
		'xhtml'   => '<div id="title-area">',
		'context' => 'title-area',
	) );
	do_action( 'genesis_site_title' );
	// do_action( 'genesis_site_description' );
	echo '</div>';

	genesis_markup( array(
		'html5'   => '<aside %s>',
		'xhtml'   => '<div class="widget-area header-widget-area">',
		'context' => 'header-widget-area',
	) );

		do_action( 'genesis_header_right' );
		add_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
		add_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
		dynamic_sidebar( 'header-right-inner' );
		remove_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
		remove_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );

	genesis_markup( array(
		'html5' => '</aside>',
		'xhtml' => '</div>',
	) );

}





