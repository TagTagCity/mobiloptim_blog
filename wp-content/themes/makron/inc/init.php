<?php
/**
 * Makron - Theme init stuff
 *
 * @package Makron
 * @since Makron 1.0.0
 */
add_action( 'after_setup_theme', 'mak_setup' );
function mak_setup() {

    // Set the content width
    global $content_width;
    if ( ! isset( $content_width ) ) {
        $content_width = 750;
    }

    // Load our textdomain
    load_theme_textdomain( 'makron', get_template_directory() . '/languages' );

    // Register our two navigation menus
    register_nav_menus( array(
        'primary_navigation' => __( 'Main navigation', 'makron' ),
        'social_navigation'  => __( 'Footer social navigation', 'makron' )
    ) );

    // Add some theme support
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'caption') );
    add_editor_style( '/css/editor-style.min.css' );

    // Custom header arguments
    $args_head = array(
        'width'                  => 1920,
        'height'                 => 90,
        'flex-height'            => true,
        'flex-width'             => true,
        'uploads'                => true,
        'default-text-color'     => 'f1f1f1',
        'header-text'            => true
    );
    add_theme_support( 'custom-header', $args_head );

    // Custom background arguments
    $args_bg = array(
        'default-color'          => 'ffffff',
        'default-image'          => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => ''
    );
    add_theme_support( 'custom-background', $args_bg );

    // Add social networks fields to author profil and author info box
    add_filter( 'user_contactmethods', 'mak_profile_fields' );
    function mak_profile_fields( $profile_fields ) {
        $profile_fields['twitter']    = __( 'Twitter URL',   'makron' );
        $profile_fields['facebook']   = __( 'Facebook URL',  'makron' );
        $profile_fields['googleplus'] = __( 'Google+ URL',   'makron' );
        $profile_fields['linkedin']   = __( 'LinkedIn URL',  'makron' );
        $profile_fields['dribbble']   = __( 'Dribbble URL',  'makron' );
        $profile_fields['pinterest']  = __( 'Pinterest URL', 'makron' );
        $profile_fields['instagram']  = __( 'Instagram URL', 'makron' );
        $profile_fields['github']     = __( 'Github URL',    'makron' );

        return $profile_fields;
    }

}
