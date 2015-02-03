<?php
/**
 * The template file for our single posts
 *
 * @package Makron
 * @since Makron 1.0.0
 */

get_header(); ?>

    <div class="mak-content">
        <div class="mak-inner">

            <?php

                while( have_posts() ) : the_post();

                    get_template_part( 'templates/content', get_post_format() );
                    mak_author_info();
                    mak_related_box();

                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }

                endwhile;

                // mak_posts_nav();

            ?>

        </div>
    </div>

<?php
get_sidebar();
get_footer();