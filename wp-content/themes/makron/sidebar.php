<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package Makron
 * @since Makron 1.0.0
 */
?>

<aside class="mak-sidebar" role="complementary">

    <?php
        do_action( 'before_sidebar' );
        if( !dynamic_sidebar( 'sidebar-primary' ) ) : ?>

        <p style="text-align: center; padding: 0 10px;"><?php _e( 'There is no widgets yet. Add them in your admin panel.', 'makron' ) ?></p>

    <?php endif; ?>

</aside>