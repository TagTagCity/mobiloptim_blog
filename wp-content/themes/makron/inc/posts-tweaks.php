<?php
/**
 * Posts tweaks
 * All tweaks related to posts (about author box, related posts, etc...)
 *
 * @package   Makron
 * @since     Makron 1.0.0
 * @author    Kevin Legrand
 * @copyright Copyright (c) 2014, Kevin Legrand
 * @link      http://k-legrand.fr
 * @license   http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * **********************************************
 * Display our post thumbnails
 * @since 1.0.0
************************************************* */

function mak_display_thumbnails() {

    $get_thumb = wp_get_attachment_url( get_post_thumbnail_id() );
    $size      = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
    $width     = $size[1];
    $height    = $size[2];

    if( has_post_thumbnail() ) { ?>

        <div class="mak-thumbnail">

            <?php if( ! is_singular() ) { ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
            <?php } ?>
                    <img width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="<?php the_title_attribute(); ?>" src="<?php echo $get_thumb; ?>" <?php if( $height > $width ) {echo 'class="vertical"';} ?> >

            <?php if( !is_singular() ) { ?>
                </a>
            <?php } ?>

        </div>

    <?php }

}

/**
 * **********************************************
 * Display the author info box
 * @since 1.0.0
************************************************* */
function mak_author_info() {

    $social_names = array( 'user_url', 'twitter', 'facebook', 'googleplus', 'linkedin', 'dribbble', 'pinterest', 'instagram', 'github' );
    $social_urls  = array();

    foreach( $social_names as $social_name ) {
        $link = get_the_author_meta( $social_name );
        if( !empty( $link ) ) {
            if( strpos( $link, "http" ) === 0) {
                $new_url = 'http://' . $link;
            }
            $social_urls[$social_name] = $link;
        }
    } ?>

<div class="author-infobox">
    <?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
    <div class="author-description mak-cf">
        <h3><?php echo __( 'About', 'makron' );?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></h3>
        <?php if( !empty( $social_urls ) ) { ?>
            <div class="author-social">
                <ul>

                <?php
                    foreach( $social_urls as $social_name => $social_url ) {
                        echo '<li><a href="'.$social_url.'"><i class="gicn gicn-'.$social_name.'"></i></a></li>';
                    }
                 ?>

                 </ul>
            </div>
        <?php } ?>
        <p><?php the_author_meta( 'user_description' ); ?></p>
    </div>
</div>

<?php }

/**
 * **********************************************
 * Display the related posts box.
 * @since 1.0.0
************************************************* */
function mak_related_box() {
    global $post;
    $orig_post = $post;
    $tags      = wp_get_post_tags( $post->ID );

    if( $tags ) :
        $tag_ids = array();
        foreach( $tags as $tag )
            $tag_ids[] = $tag->term_id;

        $args = array(
            'tag__in'             => $tag_ids,
            'post__not_in'        => array( $post->ID ),
            'posts_per_page'      => 3,
            'ignore_sticky_posts' => 1
        );

        $mak_query = new wp_query( $args );

        if( $mak_query->have_posts() ) : ?>

            <h3 class="related-title"><?php _e( 'Related posts:', 'makron' ); ?></h3>
            <div class="related-posts">
                <div class="mak-related mak-cf">
                <?php
                    while( $mak_query->have_posts() ) : $mak_query->the_post();
                        $thumb = get_post_thumbnail_id();
                        $img   = wp_get_attachment_url( $thumb, 'thumbnail' );
                ?>

                    <div class="related-box">
                        <?php if( $img ) : ?>
                        <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                            <img src="<?php echo $img; ?>">
                        </a>
                        <?php endif; ?>

                        <a class="related-link" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                    </div>

                <?php endwhile; ?>

                </div>
            </div>

        <?php endif; ?>

    <?php endif;

    $post = $orig_post;
    wp_reset_query();

}
