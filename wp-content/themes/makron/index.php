<?php
/**
 * The main template file
 *
 * @package Makron
 * @since Makron 1.0.0
 */

get_header();

    /**
    $sticky = new WP_Query( array(
        'posts_per_page' => 1,
        'post__in' => get_option( 'sticky_posts' )
    ) );

    if( $sticky->have_posts() ) :

        while( $sticky->have_posts() ) : $sticky->the_post();

            get_template_part( 'templates/content', 'sticky' );

        endwhile;

    endif;
    wp_reset_postdata(); 
	*/

    ?>
   


    <div class="mak-content" style="font-family:Helvetica Neue;">

    <?php
        $loop = new WP_Query( array('post__not_in' => get_option( 'sticky_posts' ) ) );

        if( $loop->have_posts() ):

            while ( $loop->have_posts() ) : $loop->the_post();

                get_template_part( 'templates/content', get_post_format() );

            endwhile;

            mak_page_nav();

        else:

            get_template_part( 'templates/content', 'nope' );

        endif;
        wp_reset_postdata();
    ?>

    </div>

<?php
get_sidebar();
get_footer();