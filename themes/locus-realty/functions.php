<?php
/**
 * Locus Realty functions and definitions
 *
 * @package Locus Realty
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'locus_realty_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function locus_realty_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Locus Realty, use a find and replace
	 * to change 'locus-realty' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'locus-realty', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
    /*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'locus-realty' ),
		'footer' => __( 'Footer Menu', 'locus-realty' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'locus_realty_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	add_filter('mpt_unprotect_meta', '__return_true');
}
endif; // locus_realty_setup

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function locus_realty_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'locus-realty' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
		register_sidebar( array(
		'name'          => __( 'Front Page Widgets', 'umc2014' ),
		'id'            => 'front-page',
		'description'	=> 'Add all home page widgets to this location.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Above Post Widgets', 'umc2014' ),
		'id'            => 'sidebar-top',
		'description'	=> 'Add widgets above the post',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Below Post Widgets', 'umc2014' ),
		'id'            => 'sidebar-bottom',
		'description'	=> 'Add widgets below the post',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Above Columns Widgets', 'umc2014' ),
		'id'            => 'sidebar-above-columns',
		'description'	=> 'Add widgets above columns in a two-column layout.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'locus_realty_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function locus_realty_scripts() {

	wp_enqueue_style( 'locus-realty-bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '20150207', 'all' );

	wp_enqueue_style( 'locus-realty-flexslider-style', '/wp-content/plugins/utah-banner-widget/flexslider.css', array(), '20150207', 'all' ); 

	wp_enqueue_style( 'locus-realty-style', get_stylesheet_uri() );

	wp_enqueue_script( 'locus-realty-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20150207', true );

	wp_enqueue_script( 'locus-realty-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20150207', true );

	wp_enqueue_script( 'jquery', '/wp-includes/js/jquery/jquery.js', false, '20150207', true);

	wp_enqueue_script( 'locus-realty-flexslider',  '/wp-content/plugins/utah-banner-widget/jquery.flexslider.js', array('jquery'), '20150207', true );

	wp_enqueue_script( 'locus-realty-global',  get_template_directory_uri() . '/js/global.js', array('jquery'), '20150207', true );

	wp_enqueue_script( 'locus-realty-global',  get_template_directory_uri() . '/js/retina.min.js', array('jquery'), '20150207', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'locus_realty_scripts' );

/**
 * Load CSS for IE 8 and lower
 */
function ie_style_sheets () {
	wp_register_style( 'ie8', get_template_directory_uri() . '/css/ie8.css', array('utah-grid-css'), '20140710', 'all' );
	$GLOBALS['wp_styles']->add_data( 'ie8', 'conditional', 'lte IE 8' );
	wp_enqueue_style( 'ie8');
}
add_action ('wp_enqueue_scripts','ie_style_sheets');
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Load theme customization file.
 */
require get_template_directory() . '/inc/theme-options.php';