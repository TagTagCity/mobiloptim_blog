<?php
/**
 * Enqueue scripts and stylesheets
 *
 * @package Makron
 * @since Makron 1.0.0
 */

// Enqueue stylesheets
add_action( 'wp_enqueue_scripts', 'mak_styles' );
function mak_styles() {
    // Define some variables for webfonts
    // Fonts variables (Ex: $source_sans) are only here to improve the code readability.
    $prot        = is_ssl() ? 'https' : 'http';
    $open_sans   = 'Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700';
    $source_code = 'Source+Code+Pro';

    wp_enqueue_style( 'mak_norma',   THEME_CSS . '/norma.min.css',      false, '3.0.1' );
    wp_enqueue_style( 'mak_main',    THEME_CSS . '/main.min.css',       false, '1.2' );
    wp_enqueue_style( 'mak_fonts',   THEME_CSS . '/genericons.min.css', false, '3.0.3' );
    wp_enqueue_style( 'mak_webfont', "$prot://fonts.googleapis.com/css?family=Nunito|$open_sans|$source_code", false, '1.2' );
}

// Enqueue scripts
add_action( 'wp_enqueue_scripts', 'mak_scripts' );
function mak_scripts() {

    if( is_single() && comments_open() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
    wp_enqueue_script( 'mak_scripts', THEME_JS . '/scripts.min.js',   array( 'jquery' ), '1.2', true );
    wp_enqueue_script( 'mak_moderni', THEME_JS . '/modernizr-2.8.0.min.js', '2.8.0', true );

}
