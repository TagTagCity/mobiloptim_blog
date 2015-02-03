<?php
/**
 * Sidebars stuff (main and footer)
 *
 * @package Makron
 * @since Makron 1.0.0
*/

add_action( 'widgets_init', 'mak_sidebars_init' );
function mak_sidebars_init() {
    register_sidebar( array(
        'name'          => __( 'Main sidebar', 'makron' ),
        'id'            => 'sidebar-primary',
        'description'   => __( 'The main blog sidebar.', 'makron' ),
        'before_widget' => '<section class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ) );

    // Footer 1
    register_sidebar(array(
      'name' => __( 'Footer 1', 'makron' ),
      'id' => 'footer-one',
      'description' => __( 'Widgets in this area are used in the first footer region.', 'makron' ),
      'before_widget' => '<section class="footer-widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
    ));

    // Footer 2
    register_sidebar(array(
      'name' => __( 'Footer 2', 'makron' ),
      'id' => 'footer-two',
      'description' => __( 'Widgets in this area are used in the second footer region.', 'makron' ),
      'before_widget' => '<section class="footer-widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
    ));

    // Footer 3
    register_sidebar(array(
      'name' => __( 'Footer 3', 'makron' ),
      'id' => 'footer-three',
      'description' => __( 'Widgets in this area are used in the third footer region.', 'makron' ),
      'before_widget' => '<section class="footer-widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
    ));

}
