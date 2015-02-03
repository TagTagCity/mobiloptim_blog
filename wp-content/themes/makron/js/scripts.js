/**
 * Makron scripts
 * @since 1.0.0
 * @version 1.1
*/

/* --------------------------------------
  =Better count for categories
---------------------------------------- */
(function($) {

    $('.widget_categories li.cat-item').each(function() {
        var $contents = $(this).contents();
        if ($contents.length > 1) {
            $contents.eq(1).wrap('<div class="cat-num"><span class="inner-num"></span></div>');

            $contents.eq(1).each(function() {});
        }
    }).contents();

    $('.widget_categories li.cat-item .cat-num .inner-num').each(function() {
        $(this).html($(this).text().substring(2));
        $(this).html($(this).text().replace(/\)/gi, ""));
    });

    if ($('.widget_categories li.cat-item').length) {
        $('.widget_categories li.cat-item .cat-num .inner-num').each(function() {
            if ($(this).is(':empty')) {
                $(this).parent().hide();
            }
        });
    }

})(jQuery);

/* -------------------------------------------
  =Equalize the sidebar and the content sizes
-------------------------------------------- */
jQuery(document).ready(function($) {

    function mak_equalize() {
        $('.mak-sidebar').css( 'min-height', $('.mak-content').height() );
    }

    // Init the function
    mak_equalize();

    // Equalize the sidebar each time the content is resized.
    $( '.mak-content' ).resize( function() {
        mak_equalize();
    });

});