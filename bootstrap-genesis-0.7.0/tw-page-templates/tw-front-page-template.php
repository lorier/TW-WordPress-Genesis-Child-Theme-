<?php
/**
* Template Name: AAAA Front Page
* Description: Used as a page template to show page contents
* Source: http://www.carriedils.com/custom-page-template-genesis/
*/

/* Ensure any edits occur AFTER the genesis setup/bsg_load_lib_files (listed above) runs */
add_action( 'genesis_setup', 'tw_frontpage_edits', 16);

function tw_frontpage_edits(){
    remove_action( 'template_redirect', 'bsg_title_area_jumbotron_unit_on_front_page' );

}
//ensure remove the page title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );



//Giant Home Page Header
//Hard coding the text as an image
add_action( 'genesis_before_header', 'add_giant_header_image' );

function add_giant_header_image(){
    $output =
    '<div class="jumbotron">
        <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="';
    $output .= get_stylesheet_directory_uri();
    $output .= '/tw-images/hero-text.svg"/>
                </div>
            <div class="col-md-12 main-cta"><a href="#" class="btn btn-primary btn-lg">Why rent from us?</a>
            </div>
        </div>
    </div>
    </div>';
    echo $output;
}
//////////////////////////////////////////////////
//Add MAP IMAGES if supplied on the front end via Advanced Custom Field plugin
add_action( 'genesis_after_content', 'tw_add_location_boxes');

//see metabox setup in my plant project, twentyfifteen-child >functions.php, add_custom_meta_content callback function
//string concatenation per http://www.phptherightway.com/pages/The-Basics.html
function tw_add_location_boxes(){
    global $post;
    echo '<div id="locations" class="col-md-12">';
    echo '<div class="row">';

    //find out if these 2 fields are set
    $loc_1_image = get_field('loc_1_image');
    $loc_1_post_object = get_field('loc_1_obj');
    $loc_2_image = get_field('loc_2_image');
    $loc_2_post_object = get_field('loc_2_obj');

    //if only one is set, we do 12 columns. If two, 6 columns
    if( $loc_1_post_object && $loc_2_post_object ){
        $cols = 'col-md-6';
    }else{
        $cols = 'col-md-12';
    }
        // override post object per http://www.advancedcustomfields.com/resources/post-object/
        // this requires defining global $post at the begining of the fuction!
        if($loc_1_post_object){
            $loc_image = get_field('loc_1_image');
            //override post
            $post = $loc_1_post_object;
            setup_postdata( $post );
            if( !empty($post) ):
            tw_print_loc_box($loc_image, $cols);
            ?>
           <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
            </div>
            <?php endif;
        };
         if($loc_2_post_object){
            $loc_image = get_field('loc_2_image');
            //override post
            $post = $loc_2_post_object;
            setup_postdata( $post );
            if( !empty($post) ):
            tw_print_loc_box($loc_image, $cols);
            ?>
           <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
            </div>
            <?php endif;
        };


      echo '</div></div></div></div><!--end container-->';
};

function tw_print_loc_box($loc_image, $cols){
   ?> <div class="<?php echo $cols ?>">
            <div class="home-loc-boxes">
            <a href="<?php get_permalink(); ?>">


                <h3 class="location-link"><?php the_title(); ?><span class="glyphicon glyphicon-menu-right"></span></h3>
                <img src="<?php echo $loc_image ?>">
                </a>
            </div>  <?php
}


// *------------
//
//Add tertiary content as a third row
//Theses are text area blocks within the admin. Allows markup to
//be added in the admin so it's not here
//
add_action( 'genesis_after_content', 'tw_add_tertiary_boxes');

function tw_add_tertiary_boxes(){?>
<div class="tertiary-boxes">
    <div class="container">
        <div class="row ">
            <div class="col-md-5 col-md-offset-1 col-sm-6" id="unit-sizes">
                <div><?php print_r(get_field('unit_sizes') );?></div>
                <button class="btn btn-primary"><a href="<?php print_r(get_field('unit_sizes_link') );?>">  <?php print_r(get_field('unit_sizes_link_text') );?>  </a></button>
            </div>
            <div class="col-md-5 col-sm-6" id="rates">
                <div><?php print_r(get_field('rates') );?></div>
                <button class="btn btn-primary"><a href="<?php print_r(get_field('chat_url') );?>">  <?php print_r(get_field('chat_link_text') );?>  </a></button>
            </div>

        </div>
    </div>
</div>
<?php }

add_action( 'genesis_after_content', 'tw_add_bill_pay');

function tw_add_bill_pay(){?>
<div class="bill-pay">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-1 col-sm-6">
                <div class="row">
                    <div class="col-md-12  bp-content">
                        <h3>Pay Your Bill Online</h3>
                    </div>
                </div>
                </div>
            <div class="col-md-5 col-sm-6">
                <div class="row">
                    <div class="col-md-6 bp-content">
                        <a href="#">Burien</a>
                    </div>
                    <div class="col-md-6 bp-content">
                        <a href="#">South Seattle</a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php }

//footer is managed via functions.php and the admin


//////////DEAD CODE//////////
function tw_test_loop() {
     echo '<h3>';
           echo 'Here is the test content';
        echo '</h3>';
    //sample loop from the tutorial
    $args = array(
        'category_name' => 'genesis-office-hours', // replace with your category slug
        'orderby'       => 'post_date',
        'order'         => 'DESC',
        'posts_per_page'=> '12', // overrides posts per page in theme settings
    );

    $loop = new WP_Query( $args );
    if( $loop->have_posts() ) {

        // loop through posts
        while( $loop->have_posts() ): $loop->the_post();

        echo '<h3>';
           echo 'Here is the test content';
        echo '</h3>';
        endwhile;
    };

    wp_reset_postdata();

}

genesis();

