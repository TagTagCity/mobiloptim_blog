<?php
/**
 * Makron functions and definitions
 *
 * @package Makron
 * @since Makron 1.0.0
 */
if( !defined( 'ABSPATH' ) ) die( 'Love the blank page?' );

// Define some constants
define( 'THEME_URI',  get_template_directory_uri() );
define( 'THEME_JS',   THEME_URI . '/js' );
define( 'THEME_CSS',  THEME_URI . '/css' );

// Global theme functions
require_once locate_template( '/inc/init.php' );
require_once locate_template( '/inc/scripts.php' );
require_once locate_template( '/inc/comments.php' );
require_once locate_template( '/inc/navigation.php' );

// Tweaks and utils
require_once locate_template( '/inc/tweaks.php' );
require_once locate_template( '/inc/posts-tweaks.php' );
require_once locate_template( '/inc/custom-header.php' );
require_once locate_template( '/inc/customizer.php' );

// Sidebar and Widgets
require_once locate_template( '/inc/widgets.php' );
require_once locate_template( '/inc/widgets/copyright.php');
require_once locate_template( '/inc/widgets/recent-posts.php');
