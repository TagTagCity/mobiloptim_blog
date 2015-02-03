<?php
/**
 * Makron Theme Customizer
 *
 * @package Makron
 * @since Makron 1.0.0
*/

/**
 * Load $wp_customize object
 * Add our sections, add our settings, add our controls
 * @link https://codex.wordpress.org/Theme_Customization_API
*/
add_action( 'customize_register', 'makron_customize_register' );
function makron_customize_register( $wp_customize ) {

    /**
     * Add our sections.
     * @link http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
    */
    $wp_customize->add_section(
        'makron_layout_section',
        array(
            'title'       => __( 'Makron Layout', 'makron' ),
            'capability'  => 'edit_theme_options',
            'description' => __( 'Choose your theme\'s layout.', 'makron' )
        )
    );

    /**
     * Add our settings
     * @link http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
    */
    // Layout setting
    $wp_customize->add_setting(
        'makron_layout[layout_setting]',
        array(
            'default'           => 'right-sidebar',
            'type'              => 'option',
            'sanitize_callback' => 'makron_sanitize_radio_layout'
        )
    );

    // Header menu text color setting
    $wp_customize->add_setting(
        'makron_header_menu_color',
        array(
            'default'           => '#f1f1f1',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    // Header background color setting
    $wp_customize->add_setting(
        'makron_header_bg_color',
        array(
            'default'           => '#57677e',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    // Footer background color setting
    $wp_customize->add_setting(
        'makron_footer_bg_color',
        array(
            'default'           => '#57677e',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    /**
     * Add our controls
     * @link http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
    */

    // Layout control
    $wp_customize->add_control(
        'layout_control',
        array(
            'type'    => 'radio',
            'label'   => __( 'Theme layout', 'makron' ),
            'section' => 'makron_layout_section',
            'choices' => array(
                'left-sidebar'  => __( 'Left sidebar', 'makron' ),
                'right-sidebar' => __( 'Right sidebar', 'makron' )
            ),
            'settings' => 'makron_layout[layout_setting]'
        )
    );

    // Header menu color control
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_menu_color_control',
            array(
                'label'    => __( 'Header menu color', 'makron' ),
                'section'  => 'colors',
                'settings' => 'makron_header_menu_color'
            )
        )
    );

    // Header background color control
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_bg_color_control',
            array(
                'label'    => __( 'Header background color', 'makron' ),
                'section'  => 'colors',
                'settings' => 'makron_header_bg_color'
            )
        )
    );

    // Footer background color control
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_bg_color_control',
            array(
                'label'    => __( 'Footer background color', 'makron' ),
                'section'  => 'colors',
                'settings' => 'makron_footer_bg_color'
            )
        )
    );

}

/**
 * Add a CSS class to the body tag depending
 * on which layout is chosen in the customizer.
 * @link https://codex.wordpress.org/Function_Reference/body_class#Add_Classes_By_Filters
*/
add_filter( 'body_class', 'makron_body_classes' );
function makron_body_classes( $classes ) {

    $makron_layout = get_option( 'makron_layout' );
    $classes[]     = $makron_layout['layout_setting'];

    return $classes;

}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
add_action( 'customize_preview_init', 'makron_customize_preview_js' );
function makron_customize_preview_js() {
    wp_enqueue_script( 'mak_customizer', get_template_directory_uri() . '/js/customizer.min.js', array( 'customize-preview' ), '0.0.1', true );
}

/**
 * Sanitize some fields
*/
function makron_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function makron_sanitize_radio_layout( $input ) {
    $valid = array(
        'left-sidebar'  => __( 'Left sidebar', 'makron' ),
        'right-sidebar' => __( 'Right sidebar', 'makron' )
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

