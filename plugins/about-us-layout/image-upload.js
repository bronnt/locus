jQuery(document).ready( function( jQuery ) {
    jQuery('.img-upload-btn').click(function() {
        buttonId = jQuery(this);
        boxId = jQuery(this).prev('input');
        formfield = jQuery(boxId).attr('name');
        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
        return false;
    });

    window.send_to_editor = function(html) {
        imgurl = jQuery('img',html).attr('src');
        jQuery(boxId).val(imgurl);
        tb_remove();
    }
});


