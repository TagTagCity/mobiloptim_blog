<?php
/**
 * Our theme footer
 *
 * @package Makron
 * @since Makron 1.0.0
 */
?>

    </main>

    <footer class="mak-footer" role="contentinfo">
        <div class="mak-inner mak-cf">
            <div class="widgets-wrapper">

			<div class="socialnetwork">
			<a href="https://twitter.com/mobiloptim"><img style="width:50px; height:50px;" src="http://blog.mobiloptim.com/wp-content/uploads/2015/01/twitter-icon.png"></a>
				
			<a href="https://plus.google.com/+Mobiloptim/posts"><img style="width:50px; height:50px;" src="http://blog.mobiloptim.com/wp-content/uploads/2015/01/Googleplus.png"></a>
			
			<a href="https://www.facebook.com/MobilOptim?fref=ts"><img style="width:50px; height:50px;" src="http://blog.mobiloptim.com/wp-content/uploads/2015/01/Facebook.png"></a>
			</div>

                <div class="footer-box one">
                    <?php dynamic_sidebar('footer-one'); ?>
                </div>
                <div class="footer-box two">
                    <?php dynamic_sidebar('footer-two'); ?>
                </div>
                <div class="footer-box three">
                    <?php dynamic_sidebar('footer-three'); ?>
                </div>

            </div>

            <div class="mak-right">

            <?php
                if( has_nav_menu( 'social_navigation' ) ) :
                    wp_nav_menu( array(
                        'theme_location'  => 'social_navigation',
                        'container'       => 'div',
                        'container_class' => 'social-wrap',
                        'menu_class'      => 'menu-social',
                        'depth'           => 1,
                        'link_before'     => '<span class="screen-reader-text">',
                        'link_after'      => '</span>'
                    ) );
                endif;
            ?>

            </div>
        </div>
    </footer>

</div> <!-- ./mak-wrapper -->

<?php wp_footer(); ?>

</body>
</html>