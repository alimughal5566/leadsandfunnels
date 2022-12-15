var giphyImages = [
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy1.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy2.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy3.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy4.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy5.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy6.jpg"},

]
var giphyRecentImages = [
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy1.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy2.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy3.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy4.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy5.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy6.jpg"},

]
var giphyFavoriteImages = [
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy1.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy2.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy3.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy4.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy5.jpg"},
    {"url": "https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/giphy6.jpg"},

]
var extra_content_giphy = {
    /* giphy images fuction */
    giphy_images: function () {
        var urlList = jQuery('#giphy_browse-images');
        giphyImages.map( (item,i) => {
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

    /* giphy recent images fuction */
    giphy_recent_images: function () {
        var urlList = jQuery('#giphy_recent-images');
        giphyRecentImages.map( (item,i) => {
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

    /* giphy favorite images fuction */
    giphy_favorite_images: function () {
        var urlList = jQuery('#giphy_favorite-images');
        giphyFavoriteImages.map( (item,i) => {
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

    /*
      ** init Function
    **/

    init: function() {
        extra_content_giphy.giphy_images();
        extra_content_giphy.giphy_recent_images();
        extra_content_giphy.giphy_favorite_images();
    },
};

jQuery(document).ready(function() {
    extra_content_giphy.init();
});