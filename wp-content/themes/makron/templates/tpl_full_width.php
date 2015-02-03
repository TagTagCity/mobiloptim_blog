<?php
/*
Template Name: Full Width
*/

get_header(); ?>

    <div class="mak-content full-width">
        <div class="mak-inner">

            <?php

                while( have_posts() ) : the_post();

                    get_template_part( 'templates/content', get_post_format() );

                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }

                endwhile;

            ?>

        </div>
    </div>

<?php
get_footer();