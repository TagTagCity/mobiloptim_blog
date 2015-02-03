/**
 * Our Theme Customizer enhancements
*/
(function($) {
    // Header menu color
    wp.customize( 'makron_header_menu_color',function( value ) {
        value.bind( function( to ) {
            $( '.mak-nav li a' ).css( 'color', to );
        });
    });

    // Header background color
    wp.customize( 'makron_header_bg_color',function( value ) {
        value.bind( function( to ) {
            $( '.mak-header' ).css( 'background', to );
        });
    });
})(jQuery);
