var extra_content_insert_video = {

    /* checking the category of the URL */
    parseVideo: function (url) {
        url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com)|dailymotion.com)\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);
        if (RegExp.$3.indexOf('youtu') > -1) {
            var type = 'youtube';
        }
        else if (RegExp.$3.indexOf('vimeo') > -1) {
            var type = 'vimeo';
        }
        else if (RegExp.$3.indexOf('dailymotion') > -1) {
            var type = 'dailymotion';
        }
        return {
            type: type,
            id: RegExp.$6
        };
    },

    /* passig the value of the URL to get the thumbnail preview */
    urlValidate: function () {
        jQuery('.url-validate').on('keyup', function(){
            var _self = jQuery(this);
            setTimeout(function(){
                var getVal = _self.val().trim();
                extra_content_insert_video.getVideoThumbnail(getVal);
            }, 200);
        });
    },

    /* extracting the thumbnail of the image from the url */
    getVideoThumbnail:function(url) {
        var videoObj = extra_content_insert_video.parseVideo(url);
        if (videoObj.type == 'youtube') {
            var imgYouTube = '//img.youtube.com/vi/' + videoObj.id + '/maxresdefault.jpg';
            jQuery('.insert-video-field').removeClass('has-error');
            jQuery("#preview-img").attr('src', imgYouTube);
            jQuery('.ex-content-video-block-area').show();
            jQuery('.btn-insert-image').attr('disabled', false);
        }

        else if (videoObj.type == 'vimeo') {
            $.ajax({
                type: 'GET',
                url: 'https://vimeo.com/api/oembed.json?url=https://vimeo.com/' + videoObj.id,
                dataType: 'json',
                success: function (data) {
                    jQuery('.insert-video-field').removeClass('has-error');
                    jQuery("#preview-img").attr('src', data.thumbnail_url);
                    jQuery('.ex-content-video-block-area').show();
                    jQuery('.btn-insert-image').attr('disabled', false);
                }
            })
        }

        else if (videoObj.type == 'dailymotion') {
            var imgDailyMotion = '//www.dailymotion.com/thumbnail/video/' + videoObj.id;
            jQuery('.insert-video-field').removeClass('has-error');
            jQuery("#preview-img").attr('src', imgDailyMotion);
            jQuery('.ex-content-video-block-area').show();
            jQuery('.btn-insert-image').attr('disabled', false);
        }

        else {
            jQuery('.insert-video-field').addClass('has-error');
            jQuery('.ex-content-video-block-area').hide();
            jQuery('.btn-insert-image').attr('disabled', true);
        }
    },

    /*
      ** init Function
    **/

    init: function() {
        extra_content_insert_video.urlValidate();
    },
};

jQuery(document).ready(function() {
    extra_content_insert_video.init();
});