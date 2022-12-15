var browseImages = [
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image1.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image2.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image3.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image4.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image5.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image6.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image7.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image8.jpg"},
]
var recentImages = [
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image1.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image2.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image3.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image4.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image5.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image6.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image7.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image8.jpg"},
]
var favoriteImages = [
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image1.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image2.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image3.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image4.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image5.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image6.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image7.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/gallery-image8.jpg"},
]
var extra_content_gallery = {
    /* browse images fuction */
    browse_images: function () {
        var urlList = jQuery('#browse-images');
        browseImages.map( (item,i) => {
            jQuery(`<li class="gallery-list__item">
                        <div class="gallery-list__holder">
                            <div class="gallery-list__overlay">
                                <div class="gallery-list__overlay__box">
                                    <div class="gallery-list__overlay__item">
                                        <a href="#" class="gallery-list__selection">
                                            <span class="gallery-list__selection__select">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-check"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">SELECT</span>
                                            </span>
                                            <span class="gallery-list__selection__unselect">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-cross"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">DESELECT</span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="gallery-list__overlay__item">
                                        <a href="#" class="gallery-list__favourite">
                                            <span class="gallery-list__favourite__select">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-start-rate"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">mark as favorite</span>
                                            </span>
                                            <span class="gallery-list__favourite__unselect">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-cross"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">unmark favorite</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <span class="gallery-list__item__selected">
                                <i class="icon ex-content-ico-check"></i>
                            </span>
                            <span class="gallery-list__overlay__favourite">
                                <i class="icon ex-content-ico-start-rate"></i>
                            </span>
                            <img src="${item.url}" alt="gallery image">
                        </div>
                    </li>`).appendTo(urlList);
        });
    },

    /* browse recent images fuction */
    recent_images: function () {
        var urlList = jQuery('#recent-images');
        recentImages.map( (item,i) => {
            jQuery(`<li class="gallery-list__item">
                        <div class="gallery-list__holder">
                            <div class="gallery-list__overlay">
                                <div class="gallery-list__overlay__box">
                                    <div class="gallery-list__overlay__item">
                                        <a href="#" class="gallery-list__selection">
                                            <span class="gallery-list__selection__select">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-check"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">SELECT</span>
                                            </span>
                                            <span class="gallery-list__selection__unselect">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-cross"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">DESELECT</span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="gallery-list__overlay__item">
                                        <a href="#" class="gallery-list__favourite">
                                            <span class="gallery-list__favourite__select">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-start-rate"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">mark as favorite</span>
                                            </span>
                                            <span class="gallery-list__favourite__unselect">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-cross"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">unmark favorite</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <span class="gallery-list__item__selected">
                                <i class="icon ex-content-ico-check"></i>
                            </span>
                            <span class="gallery-list__overlay__favourite">
                                <i class="icon ex-content-ico-start-rate"></i>
                            </span>
                            <img src="${item.url}" alt="gallery image">
                        </div>
                    </li>`).appendTo(urlList);
        });
    },

    /* browse favorite images fuction */
    favorite_images: function () {
        var urlList = jQuery('#favorite-images');
        favoriteImages.map( (item,i) => {
            jQuery(`<li class="gallery-list__item">
                        <div class="gallery-list__holder">
                            <div class="gallery-list__overlay">
                                <div class="gallery-list__overlay__box">
                                    <div class="gallery-list__overlay__item">
                                        <a href="#" class="gallery-list__selection">
                                            <span class="gallery-list__selection__select">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-check"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">SELECT</span>
                                            </span>
                                            <span class="gallery-list__selection__unselect">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-cross"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">DESELECT</span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="gallery-list__overlay__item">
                                        <a href="#" class="gallery-list__favourite">
                                            <span class="gallery-list__favourite__select" style="display:
                                             none;">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-start-rate"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">mark as favorite</span>
                                            </span>
                                            <span class="gallery-list__favourite__unselect"  style="display: block;">
                                                <span class="gallery-list__overlay__icon">
                                                    <i class="icon ex-content-ico-cross"></i>
                                                </span>
                                                <span class="gallery-list__overlay__text">unmark favorite</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <span class="gallery-list__item__selected">
                                <i class="icon ex-content-ico-check"></i>
                            </span>
                            <span class="gallery-list__overlay__favourite" style="display: block;">
                                <i class="icon ex-content-ico-start-rate"></i>
                            </span>
                            <img src="${item.url}" alt="gallery image">
                        </div>
                    </li>`).appendTo(urlList);
        });
    },

    /* sb favorite images fuction */
    favouriteSelection: function () {
        jQuery(document).on('click', '.gallery-list__favourite', function(e) {
            e.preventDefault();
            var _self = jQuery(this);
            _self.parents('.gallery-list__holder').find('.gallery-list__overlay__favourite').toggle();
            _self.find('.gallery-list__favourite__select').toggle();
            _self.find('.gallery-list__favourite__unselect').toggle();
            var selectionLenght = _self.parents('.gallery-list').find('.gallery-list__overlay__favourite').is(":visible");
            if(selectionLenght) {
                jQuery('.btn-insert-image').prop("disabled", false);
            }
            else {
                jQuery('.btn-insert-image').prop("disabled", true);
            }
        });
    },

    /* sb gallery select function */
    gallerySelect: function () {
        jQuery(document).on('click', '.gallery-list__selection', function(e) {
            e.preventDefault();
            var _self = jQuery(this);
            if(_self.parents('.gallery-list__holder').hasClass('image-selected')) {
                _self.parents('.gallery-list__holder').removeClass('image-selected');
                _self.find('.gallery-list__selection__unselect').hide();
                _self.find('.gallery-list__selection__select').show();
            }
            else {
                _self.parents('.gallery-list').find('.image-selected').removeClass('image-selected');
                _self.parents('.gallery-list__holder').addClass('image-selected');
                _self.parents('.gallery-list').find('.gallery-list__selection__unselect').hide();
                _self.parents('.gallery-list').find('.gallery-list__selection__select').show();
                _self.find('.gallery-list__selection__unselect').show();
                _self.find('.gallery-list__selection__select').hide();
            }

            var selectionLenght =  jQuery(this).parents('.gallery-list').find('.image-selected').length;
            if(selectionLenght) {
                var _parent_self = jQuery(this).parents('.ex-content-gallery-modal').find('.btn-insert-image');
                _parent_self.prop("disabled", false);
            }
            else {
                _parent_self.prop("disabled", true);
            }
        });
    },

    /*
      ** init Function
    **/

    init: function() {
        extra_content_gallery.browse_images();
        extra_content_gallery.recent_images();
        extra_content_gallery.favorite_images();
        extra_content_gallery.favouriteSelection();
        extra_content_gallery.gallerySelect();
    },
};

jQuery(document).ready(function() {
    extra_content_gallery.init();
});