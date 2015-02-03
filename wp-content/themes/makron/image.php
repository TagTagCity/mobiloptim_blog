<?php
/**
 * Template for displaying image attachments
 *
 * @package Makron
 * @since Makron 1.0.0
 */
$metadata = wp_get_attachment_metadata();

get_header();
?>

    <div class="mak-content full-width">
        <div class="mak-inner">

            <?php while( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <header class="post-header">
                        <div class="header-metas">

                            <?php the_title( '<h1 class="post-title">', '</h1>' ); ?>

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

                        </div>

                    </header>

                    <div class="post-content" style="text-align: center;">
                        <?php
                            $post            = get_post();
                            $attachment_size = apply_filters( 'mak_attachment_size', array( 820, 820 ) );
                            $metadata        = wp_get_attachment_metadata();

                            printf( wp_get_attachment_image( $post->ID, $attachment_size ) );
                        ?>

                        <ul class="attachment-metas" style="text-align: left;">
                            <li><?php _e( 'Parent post:', 'makron' ); ?> <a href="<?php echo get_permalink( $post->post_parent ); ?>" rel="gallery"><?php echo get_the_title( $post->post_parent ); ?></a></li>
                            <li><?php _e( 'Full width image:', 'makron' ); ?> <a target="_blank" href="<?php echo wp_get_attachment_url(); ?>"><?php echo $metadata['width']; ?> &times; <?php echo $metadata['height']; ?></a></li>
                        </ul>
                    </div>

                </article>

                <nav class="image-nav">
                    <div class="nav-links mak-cf">
                    <?php previous_image_link( false, '<div class="previous-img"><i class="gicn gicn-leftarrow"></i>' . __( 'Previous Image', 'makron' ) . '</div>' ); ?>
                    <?php next_image_link( false, '<div class="next-img">' . __( 'Next Image', 'makron' ) . '<i class="gicn gicn-rightarrow"></i></div>' ); ?>
                    </div>
                </nav>

                <?php if ( comments_open() || get_comments_number() ) {
                    comments_template();
                } ?>

            <?php endwhile; ?>

        </div>
    </div>


<?php
get_footer();