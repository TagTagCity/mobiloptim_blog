<?php
/**
 * The template for tags pages
 *
 * @package Makron
 * @since Makron 1.0.0
 */

get_header(); ?>

    <div class="mak-content">
        <div class="mak-inner">

            <?php
                if( have_posts() ) : ?>

                    <header class="mak-archive-header">
                        <h1 class="archive-title"><?php printf( __( 'Tags Archives: %s', 'makron' ), single_cat_title( '', false ) ); ?></h1>
                        <?php
                            $term_desc = term_description();
                            if( !empty( $term_desc ) ) :
                                printf( '<div class="taxonomy-desc">%s</div>', $term_desc );
                            endif;
                        ?>
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