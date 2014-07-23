<?php
	/*-----------------------------------------------------------------------------------*/
	/* This file will be referenced every time a template/page loads on your Wordpress site
	/* This is the place to define custom fxns and specialty code
	/*-----------------------------------------------------------------------------------*/

// Define the version so we can easily replace it throughout the theme
define( 'anagram_theme_version', 1.0 );

if ( ! function_exists( 'anagram_theme_setup' ) ) :
/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function anagram_theme_setup() {
    global $cap, $content_width;


    add_editor_style('/inc/editor-styles.css');

    if ( function_exists( 'add_theme_support' ) ) {

		/**
		 * Add default posts and comments RSS feed links to head
		*/
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		add_theme_support( 'post-thumbnails' );

			//set_post_thumbnail_size( 250, 160, true );
			//add_image_size( 'tiny', 75, '', false );
			//add_image_size( 'block-image', 300, 170, true );

		add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
    }


	/**
	 * This theme uses wp_nav_menu() in one location.
	*/
    register_nav_menus( array(
        'primary'  => __( 'Header bottom menu', 'anagram_theme' ),
    ) );

}
endif; // anagram_theme_setup
add_action( 'after_setup_theme', 'anagram_theme_setup' );





/**
 * Register widgetized area and update sidebar with default widgets
 */
function anagram_theme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'anagram_theme' ),
		'id'            => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'anagram_theme_widgets_init' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function anagram_theme_scripts()  {

	 // load bootstrap css
	wp_enqueue_style( 'anagram_theme-bootstrap', get_stylesheet_directory_uri().'/bootstrap/css/bootstrap.css', array(), filemtime( get_stylesheet_directory().'/bootstrap/css/bootstrap.css') );

	// get the theme directory style.css and link to it in the header
	wp_enqueue_style( 'anagram_theme-style', get_stylesheet_directory_uri().'/style.css', array(), filemtime( get_stylesheet_directory().'/style.css') );

	/*$my_query_args = array(
            'family' => 'Strait|Roboto:400,300,300italic,400italic,100'
            // 'family' => 'Strait|Roboto:400,300,300italic,400italic,100'
        );
    wp_enqueue_style('custom-google-fonts', add_query_arg( $my_query_args, "http://fonts.googleapis.com/css" ), array(), null );*/

	// load awesome font
	wp_enqueue_style( 'anagram-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' );


    // load bootstrap js
    wp_enqueue_script('anagram_theme-bootstrapjs', get_template_directory_uri().'/bootstrap/js/bootstrap.js', array('jquery') );

    // load bootstrap wp js
    wp_enqueue_script( 'anagram_theme-bootstrapwp', get_template_directory_uri() . '/js/bootstrap-wp.js', array('jquery') );

	// load plugins
	wp_enqueue_script('anagram_theme-plugins', (get_template_directory_uri()."/js/theme-plugins.js"),'jquery',filemtime( get_stylesheet_directory().'/js/theme-plugins.js'),true);

	// add theme scripts
	wp_enqueue_script('anagram_theme-scripts', (get_template_directory_uri()."/js/theme-scripts.js"),'jquery',filemtime( get_stylesheet_directory().'/js/theme-scripts.js'),true);

}
add_action( 'wp_enqueue_scripts', 'anagram_theme_scripts' ); // Register this fxn and allow Wordpress to call it automatcally in the header

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';


require get_template_directory() . '/inc/anagram-customs.php';

