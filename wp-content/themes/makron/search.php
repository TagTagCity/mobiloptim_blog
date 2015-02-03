<?php
/**
 * The template for displaying search results
 *
 * @package Makron
 * @since Makron 1.0.0
 */

get_header(); ?>

    <div class="mak-content">
        <div class="mak-inner">

            <?php
                if( have_posts() ) : ?>

                    <header class="am-archive-header">
                        <h1 class="archive-title"><?php printf( __( 'Search Results for: %s', 'makron' ), get_search_query() ); ?></h1>
                    </header>

                <?php
                    while( have_posts() ) : the_post();

                        get_template_part( 'templates/content', get_post_format() );

                    endwhile;

                    mak_page_nav();

                else:

                    get_template_part( 'templates/content', 'nope' );

                endif;

            ?>

        </div>
    </div>

<?php
get_sidebar();
get_footer();