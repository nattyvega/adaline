<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Setup Customizer
include_once( get_stylesheet_directory() . '/lib/color_customizer.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'adaline', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'adaline' ) );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Adaline Theme', 'adaline' ) );
define( 'CHILD_THEME_URL', 'http://darlingpixel.com/' );
define( 'CHILD_THEME_VERSION', '1.1' );

//* Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* woocommerce
add_theme_support( 'genesis-connect-woocommerce' );

//* WooCommerce NUMBER OF PRODICTS TO DISPLAY ON SHOP PAGE
add_filter('loop_shop_per_page', create_function('$cols', 'return 32;'));
 
//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'adaline_load_scripts' );
function adaline_load_scripts() {
	
	wp_enqueue_script( 'adaline-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	
	wp_enqueue_style( 'dashicons' );
	
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lora:400,700|Montserrat|Fredericka+the+Great', array(), CHILD_THEME_VERSION );
}

//* Add new image sizes
add_image_size( 'home-large', 740, 1100, TRUE );
add_image_size( 'home-medium', 740, 380, TRUE );
add_image_size( 'home-small', 266, 160, TRUE );

// Full Width Header and Nav
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before', 'genesis_header_markup_open', 5 );
add_action( 'genesis_before', 'genesis_do_header' );
add_action( 'genesis_before', 'genesis_header_markup_close', 15 );
add_action( 'genesis_before', 'genesis_do_nav', 20 );  

//* Making Footer Area Full Width
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_after', 'genesis_footer_widget_areas' );

remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
remove_action( 'genesis_footer', 'adaline_bottom_bar' );

add_action( 'genesis_after', 'genesis_footer_markup_open', 11 );
add_action( 'genesis_after', 'genesis_do_footer', 12 );
add_action( 'genesis_after', 'genesis_footer_markup_close', 13 );
add_action( 'genesis_after', 'adaline_bottom_bar', 10 );


//* Demo Color Options
add_filter('body_class', 'string_body_class');
function string_body_class( $classes ) {
	if ( isset( $_GET['color'] ) ) :
		$classes[] = 'adaline-' . sanitize_html_class( $_GET['color'] );
	endif;

	return $classes;
}

//* Remove Widgets
function remove_some_widgets(){

     // Unregsiter some of the TwentyTen sidebars
     unregister_sidebar( 'header-right' );
     unregister_sidebar( 'home-bottom-left' );
     unregister_sidebar( 'home-bottom-right' );
     unregister_sidebar( 'sidebar-alt' );
     unregister_sidebar( 'after-entry' );
}
add_action( 'widgets_init', 'remove_some_widgets', 11 );

//* Unregister Layouts
genesis_unregister_layout( 'content-sidebar-sidebar' ); 
genesis_unregister_layout( 'sidebar-sidebar-content' ); 
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Remove Nav Extras
add_action( 'genesis_theme_settings_metaboxes', 'child_remove_metaboxes' );
	function child_remove_metaboxes( $_genesis_theme_settings ) {
   	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings, 'main' );
}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">Continue Reading...</a>';
}

//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo ' Theme Design By <a href="http://www.studiomommy.com" title="Studio Mommy">Studio Mommy</a> &middot; ';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo '</p></div>';
}

//* Remove the post info function
remove_action( 'genesis_before_post_content', 'genesis_post_info' );

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date] [post_edit]';
	return $post_info;
}

//* Customize the post meta function
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
	$post_meta = '[post_comments] </br> [post_categories before="Filed Under: "] [post_tags before="Tagged: "] [post_edit]';
	return $post_meta;
}

//* Add support for custom background
add_theme_support( 'custom-background', array(
	'default-color' => 'ffffff',
) );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Reposition the primary navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'adaline_author_box_gravatar' );
function adaline_author_box_gravatar( $size ) {

	return 96;
		
}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'adaline_comments_gravatar' );
function adaline_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;
	
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'adaline_remove_comment_form_allowed_tags' );
function adaline_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add Fourth Footer Area
function adaline_bottom_bar() {

	echo '<div class="bottom-bar"><div class="wrap">';

	genesis_widget_area( 'bottom-bar-left', array(
		'before' => '<div class="bottom-bar-left">',
		'after' => '</div>',
	) );

	echo '</div></div>';
 
}

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-slider',
	'name'        => __( 'Home Slider', 'adaline' ),
	'description' => __( 'This is the top section of the homepage.', 'adaline' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home - Middle', 'adaline' ),
	'description' => __( 'This is the middle section of the homepage.', 'adaline' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom-left',
	'name'        => __( 'Home - Bottom Left', 'adaline' ),
	'description' => __( 'This is the bottom left section of the homepage.', 'adaline' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom-right',
	'name'        => __( 'Home - Bottom Right', 'adaline' ),
	'description' => __( 'This is the bottom right section of the homepage.', 'adaline' ),
) );
genesis_register_sidebar( array(
	'id'          => 'bottom-bar-left',
	'name'        => __( 'Bottom Bar', 'adaline' ),
	'description' => __( 'This is the bottom bar after the footer widgets. Can be used for a wide Instagram Widget.', 'adaline' ),
) );