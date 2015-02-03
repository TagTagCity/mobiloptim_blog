<?php
/**
 * Video posts
 *
 * @package Makron
 * @since Makron 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-date">
        <span class="day"><?php the_time( 'j' ); ?></span>
        <span class="month"><?php the_time( 'M' ); ?></span>
    </div>

    <header class="post-header">
        <div class="header-metas">

            <?php
                if ( is_single() ) :
                    the_title( '<h1 class="post-title">', '</h1>' );
                else:
                    the_title( '<h1 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
                endif;
            ?>

            <span class="post-author">
                <?php _e( 'Published by ', 'makron' ); ?><a title="<?php _e('See other posts by ', 'makron'); the_author_meta( 'display_name' ); ?>" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta('display_name'); ?></a>
            </span>

            <span class="post-comments">
                <?php comments_popup_link( __( 'No comments yet', 'makron' ), __( '1 comment', 'makron' ), __( '% comments', 'makron' ), '', __( 'Comments are closed', 'makron' ) ); ?></span>
            </span>

            <span class="post-permalink">
                <a title="<?php _e( 'Permalink to ', 'makron' ); the_title(); ?>" href="<?php the_permalink(); ?>"><?php _e( 'Permalink', 'makron' ); ?></a>
            </span>

            <?php if( is_singular() ) { edit_post_link( __( 'Edit', 'makron' ), '<span class="edit-link">', '</span>' ); } ?>

            <?php mak_display_thumbnails(); ?>

        </div>

    </header>

    <div class="post-content">

        <?php the_content(''); ?>
        <?php mak_content_nav(); ?>
        <?php if( !is_single() ) : ?>
        <a class="read-more" href="<?php the_permalink(); ?>" title="<?php echo _e( 'Read more', 'antimony' ); ?>"><?php echo _e( 'Read more', 'antimony' ); ?></a>
        <?php endif; ?>

    </div>

    <?php if( is_single() ) : ?>
    <footer class="post-footer">
        <ul class="taxo-metas">
            <?php if( get_the_category() ) { ?><li class="category"><i class="gicn gicn-category"></i><?php the_category(' &#8226; '); ?></li><?php } ?>

            <li class="tag-links"><i class="gicn gicn-tag"></i><?php
                $tags_list = get_the_tag_list( '', __( ' ', 'makron' ) );
                if ( $tags_list ) :
                    printf( __( '%1$s', 'makron' ), $tags_list );
                else :
                    _e( 'No tags', 'makron' );
                endif; ?>
            </li>
        </ul>
    </footer>
    <?php endif; ?>

</article>