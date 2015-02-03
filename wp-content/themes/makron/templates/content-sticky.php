<?php
/**
 * A custom template for displaying sticky posts
 * Display the thumbnail (if post have it) and title only
 *
 * @package Makron
 * @since Makron 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" class="mak-cf post sticky">
    <header class="post-header">
        <div class="header-metas">

            <?php
                mak_display_thumbnails();
                if ( is_single() ) :
                    the_title( '<h1 class="post-title">', '</h1>' );
                else:
                    the_title( '<h1 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
                endif;
            ?>

        </div>
    </header>

</article>