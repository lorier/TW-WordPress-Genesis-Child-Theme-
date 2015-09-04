<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Archives
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

add_filter( 'genesis_term_intro_text_output', 'wpautop' );
add_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
/**
 * Add custom headline and / or description to category / tag / taxonomy archive pages.
 *
 * If the page is not a category, tag or taxonomy term archive, or there's no term, or
 * no term meta set, then nothing extra is displayed.
 *
 * If there's a title to display, it is marked up as a level 1 heading.
 *
 * If there's a description to display, it runs through `wpautop()` before being added to a div.
 *
 * @since 1.3.0
 *
 * @global WP_Query $wp_query Query object.
 *
 * @return null Return early if not the correct archive page, not page one, or no term meta is set.
 */
function genesis_do_taxonomy_title_description() {

	global $wp_query;

	if ( ! is_category() && ! is_tag() && ! is_tax() )
		return;

	if ( ! genesis_a11y() ) {
		return;
	}

	$term = is_tax() ? get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : $wp_query->get_queried_object();

	if ( ! $term || ! isset( $term->meta ) )
		return;

	$headline = $intro_text = '';

	if ( $term->meta['headline'] ) {
		$headline = sprintf( '<h1 class="archive-title">%s</h1>', strip_tags( $term->meta['headline'] ) );
	} else {
		if ( genesis_a11y() ) {
			$headline = sprintf( '<h1 class="archive-title">%s</h1>', strip_tags( $term->name ) );
		}
	}

	if ( $term->meta['intro_text'] )
		$intro_text = apply_filters( 'genesis_term_intro_text_output', $term->meta['intro_text'] );

	if ( $headline || $intro_text )
		printf( '<div class="archive-description taxonomy-description">%s</div>', $headline . $intro_text );

}

add_filter( 'genesis_author_intro_text_output', 'wpautop' );
add_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
/**
 * Add custom headline and description to author archive pages.
 *
 * If we're not on an author archive page, then nothing extra is displayed.
 *
 * If there's a custom headline to display, it is marked up as a level 1 heading.
 *
 * If there's a description (intro text) to display, it is run through `wpautop()` before being added to a div.
 *
 * @since 1.4.0
 *
 * @return null Return early if not author archive or not page one.
 */
function genesis_do_author_title_description() {

	if ( ! is_author() )
		return;

	if ( ! genesis_a11y() ) {
		return;
	}

	$headline = get_the_author_meta( 'headline', (int) get_query_var( 'author' ) );

	if ( '' == $headline && genesis_a11y() ) {
		$headline = get_the_author_meta( 'display_name', (int) get_query_var( 'author' ) );
	}

	$intro_text = get_the_author_meta( 'intro_text', (int) get_query_var( 'author' ) );

	$headline   = $headline ? sprintf( '<h1 class="archive-title">%s</h1>', strip_tags( $headline ) ) : '';
	$intro_text = $intro_text ? apply_filters( 'genesis_author_intro_text_output', $intro_text ) : '';

	if ( $headline || $intro_text )
		printf( '<div class="archive-description author-description">%s</div>', $headline . $intro_text );

}

add_action( 'genesis_before_loop', 'genesis_do_author_box_archive', 15 );
/**
 * Add author box to the top of author archive.
 *
 * If the headline and description are set to display the author box appears underneath them.
 *
 * @since 1.4.0
 *
 * @uses genesis_author_box() Echo the author box and its contents.
 *
 * @see genesis_do_author_title_and_description Author title and description.
 *
 * @return Return early if not author archive or not page one.
 */
function genesis_do_author_box_archive() {

	if ( ! is_author() || get_query_var( 'paged' ) >= 2 )
		return;

	if ( get_the_author_meta( 'genesis_author_box_archive', get_query_var( 'author' ) ) )
		genesis_author_box( 'archive' );

}

add_filter( 'genesis_cpt_archive_intro_text_output', 'wpautop' );
add_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
/**
 * Add custom headline and description to relevant custom post type archive pages.
 *
 * If we're not on a post type archive page, then nothing extra is displayed.
 *
 * If there's a custom headline to display, it is marked up as a level 1 heading.
 *
 * If there's a description (intro text) to display, it is run through wpautop() before being added to a div.
 *
 * @since 2.0.0
 *
 * @uses genesis_has_post_type_archive_support() Check if a post type should potentially support an archive setting page.
 * @uses genesis_get_cpt_option()                Get list of custom post types which need an archive settings page.
 *
 * @return null Return early if not on relevant post type archive.
 */
function genesis_do_cpt_archive_title_description() {

	if ( ! is_post_type_archive() || ! genesis_has_post_type_archive_support() )
		return;

	if ( ! genesis_a11y() )
		return;

	$headline = genesis_get_cpt_option( 'headline' );

	if ( empty( $headline ) && genesis_a11y() ) {
		$headline = post_type_archive_title( '', false );
	}

	$intro_text = genesis_get_cpt_option( 'intro_text' );

	$headline   = $headline ? sprintf( '<h1 class="archive-title">%s</h1>', $headline ) : '';
	$intro_text = $intro_text ? apply_filters( 'genesis_cpt_archive_intro_text_output', $intro_text ) : '';

	if ( $headline || $intro_text )
		printf( '<div class="archive-description cpt-archive-description">%s</div>', $headline . $intro_text );

}


add_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
/**
 * Add custom headline and description to date archive pages.
 *
 * If we're not on a date archive page, then nothing extra is displayed.
 *
 * @since 2.2.0
 *
 * @uses genesis_has_post_type_archive_support() Check if a post type should potentially support an archive setting page.
 * @uses genesis_get_cpt_option()                Get list of custom post types which need an archive settings page.
 *
 * @return null Return early if not on relevant post type archive.
 */
function genesis_do_date_archive_title() {

	if ( ! is_date() ) {
		return;
	}

	if ( ! genesis_a11y( 'headings' ) ) {
		return;
	}

	if ( is_day() ) {
		$headline = __( 'Archives for ', 'genesis' ) . get_the_date();
	} elseif ( is_month() ) {
		$headline = __( 'Archives for ', 'genesis' ) . single_month_title( ' ', false );
	} elseif ( is_year() ) {
		$headline = __( 'Archives for ', 'genesis' ) . get_query_var( 'year' );
	}

	if ( $headline ) {
		printf( '<div class="archive-description archive-date"><h1 class="archive-title">%s</h1></div>', $headline );
	}

}

add_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
/**
 * Add custom headline and description to blog template pages.
 *
 * If we're not on a blog template page, then nothing extra is displayed.
 *
 * @since 2.2.0
 *
 * @uses genesis_a11y() Check if a post type should potentially support an archive setting page.
 * @uses genesis_do_post_title() Get list of custom post types which need an archive settings page.
 *
 * @return null Return early if not on relevant blog template archive.
 */
function genesis_do_blog_template_heading() {

	if ( ! is_page_template( 'page_blog.php' ) || ! genesis_a11y( 'headings' ) ) {
		return;
	}

	echo '<div class="archive-description page-blog">';
		genesis_do_post_title();
	echo '</div>';

}
