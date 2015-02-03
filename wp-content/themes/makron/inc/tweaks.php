<?php
/**
 * Tweaks and utils for Makron.
 * You can add your tweaks and utils functions here.
 *
 * @package Makron
 * @since Makron 1.0.0
 */

/**
 * Better wp_title
 * @since 1.0.0
 */
add_filter( 'wp_title', 'mak_wp_title', 10, 2 );
function mak_wp_title( $title, $sep ) {
    global $paged, $page;

    if( is_feed() )
        return $title;

    $title .= get_bloginfo( 'name' );

    $site_description = get_bloginfo( 'description', 'display' );
    if( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    if( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'makron' ), max( $paged, $page ) );

    return $title;
}

/**
 * Navigation for next/prev posts
 * @since 1.0.0
 */
if( ! function_exists( 'mak_page_nav' ) ) :
    function mak_page_nav() {

        echo '<nav class="mak-pagination">';

        global $wp_query;
        $big  = 999999999;
        $args = array(
            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format'    => '?page=%#%',
            'total'     => $wp_query->max_num_pages,
            'current'   => max( 1, get_query_var( 'paged' ) ),
            'show_all'  => false,
            'end_size'  => 3,
            'mid_size'  => 2,
            'prev_next' => true,
            'prev_text' => __( '<i class="gicn gicn-leftarrow"></i>' ),
            'next_text' => __( '<i class="gicn gicn-rightarrow"></i>' ),
            'type'      => 'plain',
        );

        echo paginate_links( $args );
        echo '</nav>';

    }
endif;

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 * This search form is used in the default search widget and the search page.
 */
add_filter( 'get_search_form', 'mak_get_search_form' );
function mak_get_search_form($form) {
    $form = '';
    locate_template( '/templates/searchform.php', true, false );
    return $form;
}

/**
 * Displays page links for paginated posts when applicable
 */
if( ! function_exists( 'mak_content_nav' ) ):
function mak_content_nav() {
    $args = array(
        'before'           => '<div class="mak-right page-links">' . __( 'Pages:', 'makron' ),
        'after'            => '</div><div class="clear"></div>',
        'text_before'      => '',
        'text_after'       => '',
        'next_or_number'   => 'number',
        'separator'        => ' ',
        'nextpagelink'     => __( 'Next page', 'makron' ),
        'previouspagelink' => __( 'Previous page', 'makron' ),
        'pagelink'         => '%',
        'echo'             => 1
    );
    wp_link_pages( $args );
}
endif; // mak_content_nav

/**
 * Sticky posts are displayed before the main query, just below the navigation menu.
 * We don't want sticky posts in the main posts container.
 * This function filter the main query to hide sticky posts.
 * @since 1.0.4
 */
add_action( 'pre_get_posts', 'exclude_sticky' );
function exclude_sticky( $query ) {
    if( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'ignore_sticky_posts', 'true' );
    }
}
