<?php
/**
 * This file adds the Home Page to the Adaline Theme.
 *
 * @author Darling Pixel
 * @package Adaline
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'adaline_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function adaline_genesis_meta() {

	if ( is_active_sidebar( 'home-slider' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-bottom-left' ) || is_active_sidebar( 'home-bottom-right' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

		// Add adaline-home body class
		add_filter( 'body_class', 'adaline_body_class' );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets
		add_action( 'genesis_loop', 'adaline_homepage_widgets' );

	}
}

function adaline_body_class( $classes ) {

	$classes[] = 'adaline-home';
	return $classes;
	
}

function adaline_homepage_widgets() {

	genesis_widget_area( 'home-slider', array(
		'before' => '<div class="home-slider widget-area">',
		'after'  => '</div>',
	) );
	
	genesis_widget_area( 'home-middle', array(
		'before' => '<div class="home-middle widget-area">',
		'after'  => '</div>',
	) );
	
	if ( is_active_sidebar( 'home-bottom-left' ) || is_active_sidebar( 'home-bottom-right' ) ) {

		echo '<div class="home-bottom">';

		genesis_widget_area( 'home-bottom-left', array(
			'before' => '<div class="home-bottom-left widget-area">',
			'after'  => '</div>',
		) );

		genesis_widget_area( 'home-bottom-right', array(
			'before' => '<div class="home-bottom-right widget-area">',
			'after'  => '</div>',
		) );

		echo '</div>';
	
	}

}

genesis();
