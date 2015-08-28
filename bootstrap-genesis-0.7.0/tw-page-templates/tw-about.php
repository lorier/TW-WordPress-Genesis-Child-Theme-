<?php
/**
* Template Name: AAAA About Page
* Description: Used as a page template to show page contents
* Source: http://www.carriedils.com/custom-page-template-genesis/
*/

/* Ensure any edits occur AFTER the genesis setup/bsg_load_lib_files (listed above) runs */
add_action( 'genesis_setup', 'tw_frontpage_edits', 16);

function tw_frontpage_edits(){
    remove_action( 'template_redirect', 'bsg_title_area_jumbotron_unit_on_front_page' );
    // add_action('genesis_after_content', 'tw_add_mcb_content_block');
}
//ensure remove the page title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );



//add testimonial custom fields
add_action('genesis_before_footer', 'tw_add_testimonial_blocks');

function tw_add_testimonial_blocks(){
    echo '<div class="full-width">';
    echo '<div class="container"';
    echo '<div class="row">';
    echo '<h3>Testimonials</h3>';
    echo '<div class="col-md-6 testimonials">'.get_field('left_column').'</div>';
        echo '<div class="col-md-6 testimonials">'.get_field('right_column').'</div>';
    echo '</div></div></div>';
}
genesis();
