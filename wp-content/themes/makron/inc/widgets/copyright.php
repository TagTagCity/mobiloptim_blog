<?php
/**
 * Register our Copyright widget
 *
 * @package Makron
 * @since Makron 1.0.0
*/
add_action( 'widgets_init', create_function( '', 'register_widget( "Makron_copyright_widget" );' ) );
class Makron_copyright_widget extends WP_Widget {

    function __construct() {

        parent::__construct(
            'Makron_copyright_widget',
            __('Makron Copyright - Footer', 'makron'),
            array( 'description' => __( 'Your Copyright stuff. Add your logo and customize copyright content.', 'makron' ), ) );
    }

    function widget( $args, $instance ) {

        extract( $args );

        $title      = apply_filters(
                        'widget_title',
                        empty( $instance['title'] ) ?
                            __( 'Copyright', 'makron' ) :
                            $instance['title']
                    );

        if ( empty( $instance['branding'] ) ) {
            $branding = '';
        } else {
            $branding = $instance['branding'];
        }

        if ( empty( $instance['copyright'] ) ) {
            $copyright = __( 'Your name/site name', 'makron' );
        } else {
            $copyright = $instance['copyright'];
        }

        if( empty( $instance['theme_copy'] ) ) {
            $theme_copy = '<a target="_blank" href="http://athemes.com/theme/makron">Makron</a>'.__( ' by aThemes', 'makron' );
        } else {
            $theme_copy = $instance['theme_copy'];
        }

        echo $before_widget;

        if( $title ) echo $before_title . $title . $after_title;

        if( $branding ) { ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <img src="<?php echo esc_url( $branding ); ?>" alt=""/>
            </a>
        <?php } else { ?>
            <h4><?php bloginfo( 'name' ); ?></h4>
            <span><?php bloginfo( 'description' ); ?></span>
        <?php }

        echo '<p>'.esc_attr( $copyright ).'</p>';
        echo '<p>'.$theme_copy.'</p>';

        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance['title']      = ( ! empty( $new_instance['title'] ) )      ? strip_tags( $new_instance['title'] ) : '';
        $instance['branding']   = ( ! empty( $new_instance['branding'] ) )   ? strip_tags( $new_instance['branding'] ) : '';
        $instance['copyright']  = ( ! empty( $new_instance['copyright'] ) )  ? strip_tags( $new_instance['copyright'] ) : '';
        $instance['theme_copy'] = ( ! empty( $new_instance['theme_copy'] ) ) ? stripslashes( wp_filter_post_kses( addslashes($new_instance['theme_copy']) ) ) : '';

        return $instance;

    }

    function form( $instance ) {

        $defaults = array(
            'title'      => __( 'Copyright', 'makron' ),
            'branding'   => '',
            'copyright'  => __( 'Your name/site name', 'makron' ),
            'theme_copy' => '<a target="_blank" href="http://athemes.com/theme/makron">Makron</a>'.__( ' by aThemes', 'makron' )
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

    ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'makron' ) ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'branding' ); ?>"><?php _e( 'Image:', 'makron' ); ?></label>
            <input class="widefat img" id="<?php echo $this->get_field_id( 'branding' ); ?>" name="<?php echo $this->get_field_name( 'branding' ); ?>" type="text" size="36" value="<?php echo esc_url( $instance['branding'] ); ?>" />
            <input class="upload_image_button" type="button" value="<?php _e( 'Upload logo:', 'makron' ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'copyright' ); ?>"><?php _e( 'Copyright text:', 'makron' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'copyright' ); ?>" name="<?php echo $this->get_field_name( 'copyright' ); ?>" type="text" value="<?php echo esc_attr( $instance['copyright'] ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'theme_copy' ); ?>"><?php _e( 'Theme owner text:', 'makron' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'theme_copy' ); ?>" name="<?php echo $this->get_field_name( 'theme_copy' ); ?>" type="text" value="<?php echo esc_attr( $instance['theme_copy'] ); ?>" />
        </p>

    <?php
    }

}

add_action('admin_enqueue_scripts', 'mak_widget_enqueue');
function mak_widget_enqueue( $hook ) {

    if( $hook != 'widgets.php' )
        return;

    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('mak-img-upload', get_template_directory_uri() . '/js/widget-uploader.min.js', null, null, true);
}
