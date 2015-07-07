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
add_action( 'genesis_before_header', 'add_giant_header_image' );

function add_giant_header_image(){
    echo '<div class="jumbotron">
        <div class="container main-cta" >
            <a href="#" class="btn btn-primary btn-lg">bibbity babity boo</a>
            </div>
        </div>';
}
//////////////////////////////////////////////////
//Add MAP IMAGES if supplied on the front end via Advanced Custom Field plugin
add_action( 'genesis_after_content', 'tw_add_location_boxes');

//see metabox setup in my plant project, twentyfifteen-child >functions.php, add_custom_meta_content callback function
//string concatenation per http://www.phptherightway.com/pages/The-Basics.html
function tw_add_location_boxes(){

    echo '<div class="row">';

    //find out if these 2 fields are set
    $field1 = get_field('map_1');
    $field2 = get_field('map_2');

    //if only one is set, we do 12 columns. If two, 6 columns
    if( $field1 && $field2 ){
        $cols = 'col-md-6';
    }else{
        $cols = 'col-md-12';
    }
    // $locations_content = null;
        if($field1){
            $location = get_field('map_1');

            if( !empty($location) ):
            ?>
         <div class="<?php echo $cols ?>">
            <div class="acf-map">
                <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
            </div>
        </div>
            <?php endif;
        };

        if($field2){
            $location = get_field('map_2');

            if( !empty($location) ):
            ?>
            <div class="<?php echo $cols ?>">
            <div class="acf-map <?php echo $cols?>">
                <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
            </div>
            </div>
            <?php endif;
        };

        // if($field2){
        //     $locations_content = '<div class="';
        //     $locations_content .= $cols;
        //     $locations_content .= '"><img class="location-img img-responsive" src="';
        //     $locations_content .= $field2;
        //     $locations_content .= '" alt=""/>';
        //     $locations_content .= '</div>';

        //     echo $locations_content;
        //}

      echo '</div>';
};
// *------------
//
//Add tertiary content as a third row
//Theses are text area blocks within the admin. Allows markup to
//be added in the admin so it's not here
//
add_action( 'genesis_after_content', 'tw_add_tertiary_boxes');

function tw_add_tertiary_boxes(){?>
    <div class="row">
        <?php print_r(get_field('unit_sizes') );?>
        <?php print_r(get_field('rates') );?>
        <?php echo (get_field('pay_your_bill') );?>
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

