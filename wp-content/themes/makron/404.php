<?php
/**
 * Template for 404 page
 *
 * @package Makron
 * @since Makron 1.0.0
 */

get_header(); ?>

    <div class="mak-content content404">
        <div class="mak-inner">

            <i class="404 gicn gicn-404"></i>
            <h2><?php _e( 'page not found', 'makron' ); ?></h2>
            <p>
                <?php _e( 'The page you were trying to reach wasn\'t there', 'makron' ); ?><br>
                <?php _e( 'Maybe you can try with the search form below?', 'makron' ); ?>

            </p>

            <?php get_search_form(); ?>

        </div>
    </div>

<?php
get_sidebar();
get_footer();