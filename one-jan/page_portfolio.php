<?php
/*
Template Name: Portfolio
*/

/** Force the full width layout on the portfolio page */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/** Remove the standard loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );

/** Add the portfolio widget area */
add_action( 'genesis_loop', 'jano_portfolio_widget' );
function jano_portfolio_widget() {
	dynamic_sidebar( 'portfolio' );
}

genesis();