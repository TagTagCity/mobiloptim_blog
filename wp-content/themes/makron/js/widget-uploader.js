/**
 * Makron image uploader widget
 * @since 1.0.0
*/
(function($) {
    var image_field;

    $(document).on('click', 'input.upload_image_button', function(evt){
        image_field = $(this).siblings('.img');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
    });
    window.send_to_editor = function(html) {
        imgurl = $('img', html).attr('src');
        image_field.val(imgurl);
        tb_remove();
    }
})(jQuery);