<?php
/**
 * Register our recent posts widget
 *
 * @package Makron
 * @since Makron 1.0.0
*/

add_action( 'widgets_init', array( 'Makron_Recent_Posts', 'register_recent_sidebar' ) );
class Makron_Recent_Posts extends WP_Widget {

    function __construct() {
        parent::__construct(
            'mak_recent_sidebar',
            __( 'Makron Recent Posts', 'makron' ),
            array(
                'classname'   => 'mak-recent',
                'description' => __( 'A better recent posts widget for your sidebar.', 'makron' )
            )
        );

        $this->alt_option_name = 'mak-recent';

        add_action( 'save_post',    array( $this, 'flush_widget_cache') );
        add_action( 'deleted_post', array( $this, 'flush_widget_cache') );
        add_action( 'switch_theme', array( $this, 'flush_widget_cache') );
    }

    public static function register_recent_sidebar() {
        register_widget( 'Makron_Recent_Posts' );
    }

    function widget( $args, $instance ) {
        $cache = wp_cache_get( 'widget_recent_posts', 'widget' );

        if( !is_array( $cache ) )
            $cache = array();

        if( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract( $args );

        $title = apply_filters(
            'widget_title',
            empty( $instance['title'] ) ?
                __( 'Recent Posts', 'makron' ) :
                $instance['title'], $instance, $this->id_base
        );

        if( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
            $number = 3;

        $r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ) ) );

        if( $r->have_posts() ) :

        echo $before_widget;

        if( $title ) echo $before_title . $title . $after_title; ?>

            <div class="recent-posts-widget">

            <?php while ( $r->have_posts() ) : $r->the_post(); ?>

                <div class="recent-post mak-cf">
                    <?php if( has_post_thumbnail() ) { ?>
                        <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>">
                            <?php echo '<img alt="'. get_the_title() . '" src="' . wp_get_attachment_url( get_post_thumbnail_id() ) . '">'; ?>
                        </a>
                    <?php } ?>
                    <h6><a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if( get_the_title() ) the_title(); else the_ID(); ?></a></h6>
                    <p class="recent-date"><i class="gicn gicn-month"></i><?php echo get_the_date(); ?></p>
                </div>

            <?php endwhile; ?>

            </div>

        <?php echo $after_widget;

        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {

        $instance           = $old_instance;
        $instance['title']  = strip_tags( $new_instance['title'] );
        $instance['number'] = (int) $new_instance['number'];

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if( isset( $alloptions['mak_recent_sidebar'] ) )
            delete_option( 'mak_recent_sidebar' );

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete( 'widget_recent_posts', 'widget' );
    }

    function form( $instance ) {
        $title  = isset( $instance['title'] )  ? esc_attr( $instance['title'] ) : '';
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        ?>

            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'makron' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'makron' ); ?></label>
                <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
            </p>

        <?php
    }
}
