<?php
/**
 * Quote posts
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

    <div class="post-content">

        <?php the_content(''); ?>

    </div>

</article>