<?php
/**
 * Jano Home Page.
 */

// Force full width content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

// Remove the default Genesis loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Add custom homepage content
add_action( 'genesis_loop', 'one_jan_homepage_content' );
function one_jan_homepage_content() { ?>

	<!-- About section -->

		<?php $page = get_page_by_title ( 'About' ); ?>
		<?php if ( $background = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), '' ) ) : ?>
			<div id="about" class="wrapper section" style="background: url('<?php echo $background[0]; ?>')">
						<div class="section-inner"><div class="wrap"><header class="home-title">
						<h1><?php echo apply_filters( 'the_title', $page->post_title); ?></h1>
						</header>
						<?php echo apply_filters( 'the_content', $page->post_content); ?>
						</div></div>
			</div>
			<?php else: ?>
			<div id="about" class="wrapper section">
						<div class="section-inner"><div class="wrap"><header class="home-title">
						<h1><?php echo apply_filters( 'the_title', $page->post_title); ?></h1>
						</header>
						<?php echo apply_filters( 'the_content', $page->post_content); ?>
						</div></div>
			</div>
			<?php endif; ?>
		<!-- End About section -->


	<!-- Service section -->
	
		<?php $page = get_page_by_title ( 'Service' ); ?>
		<?php if ( $background = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), '' ) ) : ?>
			<div id="service" class="wrapper section" style="background: url('<?php echo $background[0]; ?>')">
						<div class="section-inner"><div class="wrap"><header class="home-title">
						<h1><?php echo apply_filters( 'the_title', $page->post_title); ?></h1>
						</header>
						<?php echo apply_filters( 'the_content', $page->post_content); ?>
						</div></div>
			</div>
			<?php else: ?>
			<div id="service" class="wrapper section">
						<div class="section-inner"><div class="wrap"><header class="home-title">
						<h1><?php echo apply_filters( 'the_title', $page->post_title); ?></h1>
						</header>
						<?php echo apply_filters( 'the_content', $page->post_content); ?>
						</div></div>
			</div>
			<?php endif; ?>
	
	<!-- End Service section -->
	
	<!-- Portfolio section -->
	
		<?php $page = get_page_by_title ( 'Portfolio' ); ?>
		<?php if ( $background = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), '' ) ) : ?>
			<div id="portfolio" class="wrapper section" style="background: url('<?php echo $background[0]; ?>')">
						<div class="section-inner"><div class="wrap"><header class="home-title">
						<h1><?php echo apply_filters( 'the_title', $page->post_title); ?></h1>
						</header>
							<?php
							genesis_widget_area( 'portfolio', array(
							'before'	=> '<div class="portfolio-section">',
							'after'		=> '</div>',
							) );
							?>
						</div></div>
			</div>
			<?php else: ?>
			<div id="portfolio" class="wrapper section">
						<div class="section-inner"><div class="wrap"><header class="home-title">
						<h1><?php echo apply_filters( 'the_title', $page->post_title); ?></h1>
						</header>
							<?php
							genesis_widget_area( 'portfolio', array(
							'before'	=> '<div class="portfolio-section">',
							'after'		=> '</div>',
							) );
							?>
						</div></div>
			</div>
			<?php endif; ?>
	
	<!-- End Portfolio section -->
	
	<!-- Blog section -->
	
		<?php $page = get_page_by_title ( 'Blog' ); ?>
		<?php if ( $background = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), '' ) ) : ?>
			<div id="blog" class="wrapper section" style="background: url('<?php echo $background[0]; ?>')">
						<div class="section-inner"><div class="wrap"><header class="home-title">
						<h1><?php echo apply_filters( 'the_title', $page->post_title); ?></h1>
						</header>
							<?php
							genesis_widget_area( 'home-blog', array(
							'before'	=> '<div class="blog-section">',
							'after'		=> '</div>',
							) );
							?>
						</div></div>
			</div>
			<?php else: ?>
			<div id="blog" class="wrapper section">
						<div class="section-inner"><div class="wrap"><header class="home-title">
						<h1><?php echo apply_filters( 'the_title', $page->post_title); ?></h1>
						</header>
							<?php
							genesis_widget_area( 'home-blog', array(
							'before'	=> '<div class="blog-section">',
							'after'		=> '</div>',
							) );
							?>
						</div></div>
			</div>
			<?php endif; ?>
	
	<!-- End Blog section -->


	<!-- Contact section -->
	
		<?php $page = get_page_by_title ( 'Contact' ); ?>
		<?php if ( $background = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), '' ) ) : ?>
			<div id="contact" class="wrapper section" style="background: url('<?php echo $background[0]; ?>')">
						<div class="section-inner"><div class="wrap"><header class="home-title">
						<h1><?php echo apply_filters( 'the_title', $page->post_title); ?></h1>
						</header>
						<?php genesis_widget_area( 'home-social', array(
							'before'	=> '<div class="social-section">',
							'after'		=> '</div>',
							) ); ?>

						<?php echo apply_filters( 'the_content', $page->post_content); ?>
						</div></div>
			</div>
			<?php else: ?>
			<div id="contact" class="wrapper section">
						<div class="section-inner"><div class="wrap"><header class="home-title">
						<h1><?php echo apply_filters( 'the_title', $page->post_title); ?></h1>
						</header>
						<?php genesis_widget_area( 'home-social', array(
							'before'	=> '<div class="social-section">',
							'after'		=> '</div>',
							) ); ?>
						<?php echo apply_filters( 'the_content', $page->post_content); ?>
						</div></div>
			</div>
			<?php endif; ?>
	
	<!-- End Contact section -->

<?php }

genesis();
