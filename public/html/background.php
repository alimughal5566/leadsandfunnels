
<?php
include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
<?php
include ("includes/sidebar-menu.php");
include ("includes/inner-sidebar-menu.php");
?>
    <!-- contain the main content of the page -->
    <div id="content">
        <!-- header of the page -->
        <?php
        include ("includes/header.php");
        ?>
        <!-- contain main informative part of the site -->
        <main class="main">
            <!-- content of the page -->
            <section class="main-content">
                <!-- Title wrap of the page -->
                <div class="main-content__head main-content__head_tabs">
                    <div class="col-left">
                        <h1 class="title">
                            <span class="inner__title">Page</span> Background / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title="Background" data-lp-wistia-key="g050iwwq0w" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span>
                            Watch how to video
                        </a>
                        <div class="tab__wrapper">
                            <ul class="nav nav__tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#main">Main</a>
                                </li>
                                <li class="nav-item disabled el-tooltip" title="This feature is coming soon!">
                                    <a class="nav-link" data-toggle="pill" href="#funnel">Funnel</a>
                                </li>
<!--                                <li class="nav-item">-->
<!--                                    <a class="nav-link" data-toggle="pill" href="#cards">Cards</a>-->
<!--                                </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
                <input type="hidden" id="bg-option-image-url" name="bg-option-image-url" value="">
                <input type="hidden" id="image-url" name="image-url" class="image-url" value="">
                <!-- Background color opacity -->
                <input type="hidden" id="bgPageOverlay_color_opacity" name="overlay_color_opacity" value="0.2">
                <input type="hidden" id="bgFormOverlay_color_opacity" name="overlay_color_opacity" value="0.2">
                <input type="hidden" id="bgCardsOverlay_color_opacity" name="overlay_color_opacity" value="0.2">
                <!-- Background color overlay -->
                <input type="hidden" id="bgPageImg-overlay" name="" value="">
                <input type="hidden" id="bgFormImg-overlay" name="" value="">
                <input type="hidden" id="bgCardsImg-overlay" name="" value="">
                <!-- Own color hidden inputs -->
                <input type="hidden" id="bgPage-modeowncolor-hex" name="" value="#34409E">
                <input type="hidden" id="bgPage-modeowncolor-rgb" name="" value="52, 64, 158">
                <input type="hidden" id="bgForm-modeowncolor-hex" name="" value="#34409E">
                <input type="hidden" id="bgForm-modeowncolor-rgb" name="" value="52, 64, 158">
                <input type="hidden" id="bgCards-modeowncolor-hex" name="" value="#34409E">
                <input type="hidden" id="bgCards-modeowncolor-rgb" name="" value="52, 64, 158">
                <div class="tab-content">
                    <div id="main" class="tab-pane active">
                        <div class="card background-card">
                            <div class="card-header">
                                <div class="card-link-wrap">
                                    <label class="card-link">
                                        <input type="radio" name="background-radio">
                                        <span class="card-circle"></span>
                                        <span class="h2 card-title">
                                            <span>Upload a</span> Background Image
                                            <span class="bg__el-tooltip" data-tooltip-content="#tooltip_content" title="Suggested background &#34;Cover&#34; image dimensions:<br> 1920 width x 1080 height.<br> Recommended size: smaller than 1 MB.<br> Use this free service: <a class='lp-tp-btn' href='http://www.TinyPNG.com' target='_blank'> www.TinyPNG.com </a> to compress<br> images prior to upload to reduce load time.">
                                                <img src="assets/images/ttip.png" alt="ttip">
                                            </span>
                                        </span>
                                    </label>
                                </div>
<!--                                <div class="tooltip tooltip_templates">-->
<!--                                    <span id="tooltip_content">-->
<!--                                        Suggested background "Cover" image dimensions:<br>-->
<!--                                        1920 width x 1080 height.<br> Recommended size: smaller than 4 MB.<br>-->
<!--                                        Use this free service: <a class="lp-tp-btn" href="http://www.TinyPNG.com" target="_blank"> www.TinyPNG.com </a> to compress<br>-->
<!--                                        images prior to upload to reduce load time.-->
<!--                                    </span>-->
<!--                                </div>-->
                            </div>
                            <div class="background-slide">
                                <div class="card-body">
                                    <div class="browse__content">
                                            <div class="browse__step1">
                                                <div class="browse__desc">
                                                    <p>
                                                        You have not added any background image yet.
                                                    </p>
                                                    <div class="lp-image__browse">
                                                        Click
                                                        <label class="lp-image__button" for="Pagebrowse_img1">
                                                            <input id="Pagebrowse_img1" name="Pagebrowse_img1" class="lp-image__input" type="file" accept="image/*" required="" value="">
                                                            Browse
                                                        </label>
                                                        to start uploading.
                                                    </div>
                                                    <div class="file__control">
                                                        <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                        <p class="file__size">Maximum file size limit is 4MB.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="browse__step2">
                                                <div class="bg__wrapper">
                                                    <div class="bg__image">
                                                        <div class="browse__bg-image">
                                                            <div id="bgPagePreview-overlay" class="bg-image"></div>
                                                            <div class="action">
                                                                <ul class="action__list">
                                                                    <li class="action__item del__img">
                                                                        <button class="btn-image__del button button-cancel">
                                                                            delete
                                                                        </button>
                                                                    </li>
                                                                    <li class="action__item">
                                                                        <div class="lp-image__browse">
                                                                            <label class="button button-primary" for="Pagebrowse_img2">
                                                                                <input id="Pagebrowse_img2" class="lp-image__input" type="file" accept="image/*" required="" value="">
                                                                                Browse
                                                                            </label>
                                                                        </div>
                                                                        <div class="file__control">
                                                                            <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                                            <p class="file__size">Maximum file size limit is 4MB.</p>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg__controls">
                                                        <div class="form-group">
                                                            <label for="bgPage__active-overlay">Background Overlay Color</label>
                                                            <div class="main__control bg__control_overlay-wrapper">
                                                                <div class="text-color-parent">
                                                                    <div class="color-picker bgPageColor-picker__overlay" style="background-color: rgb(106, 153, 148);"></div>
                                                                </div>
                                                                <input id="bgPage__active-overlay" class="bgoverly" id="bgoverly" name="bgoverly"
                                                                       data-toggle="toggle" data-onstyle="active"
                                                                       data-offstyle="inactive" data-width="127" data-height="43"
                                                                       data-on="INACTIVE" data-off="ACTIVE" type="checkbox" checked>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Overlay Color Opacity</label>
                                                            <div class="main__control bg__control_slider">
                                                                <input id="ex1" class="form-control select2__bgPage-overlay" data-slider-id='ex1Slider' type="text"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Background Repeat</label>
                                                            <div class="main__control">
                                                                <div class="select2__bgPage-repeat-parent">
                                                                    <select class="select2__bgPage-repeat">
                                                                        <option value="no-repeat" selected="">No Repeat</option>
                                                                        <option value="repeat">Repeat</option>
                                                                        <option value="repeat-x">Repeat-X</option>
                                                                        <option value="repeat-y">Repeat-Y</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Background Position</label>
                                                            <div class="main__control">
                                                                <div class="select2__bgPage-postion-parent select2js__nice-scroll">
                                                                    <select class="select2__bgPage-postion">
                                                                        <option value="center center" selected="">Center Center</option>
                                                                        <option value="center left">Center Left</option>
                                                                        <option value="center right">Center Right</option>
                                                                        <option value="top center">Top Center</option>
                                                                        <option value="top left">Top Left</option>
                                                                        <option value="top right">Top Right</option>
                                                                        <option value="bottom center">Bottom Center</option>
                                                                        <option value="bottom left">Bottom Left</option>
                                                                        <option value="bottom right">Bottom Right</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Background Size</label>
                                                            <div class="main__control">
                                                                <div class="select2__bgPage-cover-parent">
                                                                    <select class="select2__bgPage-cover">
                                                                        <option value="cover" selected="">Cover</option>
                                                                        <option value="contain">Contain</option>
                                                                        <option value="auto">Default</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="card background-card">
                            <div class="card-header">
                                <div class="card-link-wrap">
                                    <label class="card-link">
                                        <input type="radio" name="background-radio">
                                        <span class="card-circle"></span>
                                        <span class="h2 card-title"><span>Customize Your</span> Own Colors</span>
                                    </label>
                                </div>
                            </div>
                            <div class="background-slide">
                                <div class="card-body">
                                    <div class="owncolor">
                                        <div class="owncolor__wrapper">
                                            <div class="bgPageowncolor__box owncolor__box"></div>
                                            <div class="owncolor__info">
                                                <label for="selectedcolor">Selected Color</label>
                                                <div class="last-selected">
                                                    <div class="last-selected__box"></div>
                                                    <div class="last-selected__code">#e6eef3</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="owncolor__controls">
                                            <div class="head">
                                                <h2>Add custom color code</h2>
                                            </div>
                                            <div class="owncolor__inner">
                                                <div class="form-group">
                                                    <label>Color Mode</label>
                                                    <div class="main__control">
                                                        <div class="select2__bgPage-colormode-parent">
                                                            <select class="select2__bgPage-colormode">
                                                                <option value="hex" selected="">HEX</option>
                                                                <option value="rbg">RGB</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bgPage-colorval">Color Value</label>
                                                    <div class="main__control">
                                                        <input id="bgPage-colorval" class="form-control" value="#34409E" type="text">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Color Opacity</label>
                                                    <div class="main__control">
                                                        <div class="range-slider">
                                                            <div class="input__wrapper ex2-wrap">
                                                                <input class="form-control opacity-slider" data-slider-id='opacity-slider' type="text"/>
                                                                <span class="opacity-slider-val">1%</span>
                                                                <input type="hidden" class="defaultSize" value="1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card background-card">
                            <div class="card-header">
                                <div class="card-link-wrap">
                                    <label class="card-link">
                                        <input type="radio" name="background-radio">
                                        <span class="card-circle"></span>
                                        <span class="h2 card-title"><span>Automatically Pull</span> Logo Colors</span>
                                    </label>
                                </div>
                            </div>
                            <div class="background-slide">
                                <div class="card-body">
                                    <div class="card-body__row">
                                        <div id="ics-gradient-editor-1-div" >
                                            <div class="gradient" id="ics-gradient-editor-1">
                                            </div>
                                        </div>
<!--                                            <div class="color__wrapper">-->
<!--                                                <div class="color__block color__block-black"></div>-->
<!--                                                <div class="color__block color__block-purple"></div>-->
<!--                                                <div class="color__block color__block-orange"></div>-->
<!--                                                <div class="color__block"></div>-->
<!--                                            </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="funnel" class="tab-pane">
                        <div class="lp-panel lp-panel_activation">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Activate Funnel Background?
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item">
                                                <input id="bgform" name="bgform" data-toggle="toggle"
                                                        data-onstyle="active" data-offstyle="inactive"
                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                        data-off="ACTIVE" type="checkbox"  >
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="collapsed card-link" data-toggle="collapse" href="#bgImageForm">
                                    <span class="card-circle"></span>
                                    <h2 class="card-title">
                                        <span>Upload a</span> Background Image
                                        <span class="bg__el-tooltip" data-tooltip-content="#tooltip_content">
                                            <img src="assets/images/ttip.png" alt="ttip">
                                        </span>
                                    </h2>
                                </div>
                                <div class="tooltip tooltip_templates">
                                    <span id="tooltip_content">
                                        Suggested background "Cover" image dimensions:<br>
                                        1920 width x 1080 height.<br> Recommended size: smaller than 1 MB.<br>
                                        Use this free service: <a class="lp-tp-btn" href="http://www.TinyPNG.com" target="_blank"> www.TinyPNG.com </a> to compress<br>
                                        images prior to upload to reduce load time.
                                    </span>
                                </div>
                            </div>
                            <div id="bgImageForm" class="collapse" data-parent="#funnel">
                                <div class="card-body">
                                    <div class="browse__content">
                                        <div class="browse__step1">
                                            <div class="browse__desc">
                                                <p>
                                                    You have not added any background image yet.
                                                </p>
                                                <div class="lp-image__browse">
                                                    Click
                                                    <label class="lp-image__button" for="Formbrowse_img1">
                                                        <input id="Formbrowse_img1" name="Formbrowse_img1" class="lp-image__input" type="file" accept="image/*" required="" value="">
                                                        Browse
                                                    </label>
                                                    to start uploading.
                                                </div>
                                                <div class="file__control">
                                                    <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                    <p class="file__size">Maximum file size limit is 4MB.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="browse__step2">
                                            <div class="bg__wrapper">
                                                <div class="bg__image">
                                                    <div class="browse__bg-image">
                                                        <div id="bgFormPreview-overlay" class="bg-image"></div>
                                                        <div class="action">
                                                            <ul class="action__list">
                                                                <li class="action__item del__img">
                                                                    <button class="btn-image__del button button-cancel">
                                                                        delete
                                                                    </button>
                                                                </li>
                                                                <li class="action__item">
                                                                    <div class="lp-image__browse">
                                                                        <label class="button button-primary" for="Formbrowse_img2">
                                                                            <input id="Formbrowse_img2" class="lp-image__input" type="file" accept="image/*" required="" value="">
                                                                            Browse
                                                                        </label>
                                                                    </div>
                                                                    <div class="file__control">
                                                                        <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                                        <p class="file__size">Maximum file size limit is 4MB.</p>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg__controls">
                                                    <div class="form-group">
                                                        <label for="bgForm__active-overlay">Background Overlay Color</label>
                                                        <div class="main__control bg__control_overlay-wrapper">
                                                            <div class="text-color-parent">
                                                                <div class="color-picker bgFormColor-picker__overlay" style="background-color: rgb(106, 153, 148);"></div>
                                                            </div>
                                                            <input id="bgForm__active-overlay" class="bgoverly" id="bgoverly" name="bgoverly"
                                                                   data-toggle="toggle" data-onstyle="active"
                                                                   data-offstyle="inactive" data-width="127" data-height="43"
                                                                   data-on="INACTIVE" data-off="ACTIVE" type="checkbox" checked>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Overlay Color Opacity</label>
                                                        <div class="main__control bg__control_slider">
                                                            <input id="ex2" class="form-control" data-slider-id='ex2Slider' type="text"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Background Repeat</label>
                                                        <div class="main__control">
                                                            <div class="select2__bgForm-repeat-parent">
                                                                <select class="select2__bgForm-repeat">
                                                                    <option value="no-repeat" selected="">No Repeat</option>
                                                                    <option value="repeat">Repeat</option>
                                                                    <option value="repeat-x">Repeat-X</option>
                                                                    <option value="repeat-y">Repeat-Y</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Background Position</label>
                                                        <div class="main__control">
                                                            <div class="select2__bgForm-postion-parent select2js__nice-scroll">
                                                                <select class="select2__bgForm-postion">
                                                                    <option value="center center" selected="">Center Center</option>
                                                                    <option value="center left">Center Left</option>
                                                                    <option value="center right">Center Right</option>
                                                                    <option value="top center">Top Center</option>
                                                                    <option value="top left">Top Left</option>
                                                                    <option value="top right">Top Right</option>
                                                                    <option value="bottom center">Bottom Center</option>
                                                                    <option value="bottom left">Bottom Left</option>
                                                                    <option value="bottom right">Bottom Right</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Background Size</label>
                                                        <div class="main__control">
                                                            <div class="select2__bgForm-cover-parent">
                                                                <select class="select2__bgForm-cover">
                                                                    <option value="cover" selected="">Cover</option>
                                                                    <option value="contain">Contain</option>
                                                                    <option value="auto">Default</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="collapsed card-link" data-toggle="collapse" href="#bgOwnColorForm">
                                    <span class="card-circle"></span>
                                    <h2 class="card-title"><span>Customize Your</span> Own Colors</h2>
                                </div>
                            </div>
                            <div id="bgOwnColorForm" class="collapse" data-parent="#funnel">
                                <div class="card-body">
                                    <div class="owncolor">
                                        <div class="owncolor__wrapper">
                                            <div class="bgFormowncolor__box owncolor__box"></div>
                                            <div class="owncolor__info">
                                                <label for="selectedcolor">Selected Color</label>
                                                <div class="last-selected">
                                                    <div class="last-selected__box"></div>
                                                    <div class="last-selected__code">#e6eef3</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="owncolor__controls">
                                            <div class="head">
                                                <h2>Add custom color code</h2>
                                            </div>
                                            <div class="owncolor__inner">
                                                <div class="form-group">
                                                    <label>Color Mode</label>
                                                    <div class="main__control">
                                                        <div class="select2__bgForm-colormode-parent">
                                                            <select class="select2__bgForm-colormode">
                                                                <option value="hex" selected="">HEX</option>
                                                                <option value="rbg">RGB</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="colorval">Color Value</label>
                                                    <div class="main__control">
                                                        <input id="bgForm-colorval" class="form-control" value="#34409E" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-link" data-toggle="collapse" href="#bgLogoColorForm">
                                    <span class="card-circle"></span>
                                    <h2 class="card-title"><span>Automatically Pull</span> Logo Colors</h2>
                                </div>
                            </div>
                            <div id="bgLogoColorForm" class="collapse show" data-parent="#funnel">
                                <div class="card-body">
                                    <div class="card-body__row">
                                        <div id="ics-gradient-editor-2-div" >
                                            <div class="gradient" id="ics-gradient-editor-2">
                                            </div>
                                        </div>
                                        <!--                                            <div class="color__wrapper">-->
                                        <!--                                                <div class="color__block color__block-black"></div>-->
                                        <!--                                                <div class="color__block color__block-purple"></div>-->
                                        <!--                                                <div class="color__block color__block-orange"></div>-->
                                        <!--                                                <div class="color__block"></div>-->
                                        <!--                                            </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div id="cards" class="tab-pane">
                        <div class="lp-panel lp-panel_activation">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Activate Cards Background?
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item">
                                                <input  id="bgcards" name="bgcards" data-toggle="toggle"
                                                        data-onstyle="active" data-offstyle="inactive"
                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                        data-off="ACTIVE" type="checkbox" checked >
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="collapsed card-link" data-toggle="collapse" href="#bgImageCards">
                                    <span class="card-circle"></span>
                                    <h2 class="card-title">
                                        <span>Upload a</span> Background Image
                                        <span class="bg__el-tooltip" data-tooltip-content="#tooltip_content" title="Suggested background &#34;Cover&#34; image dimensions:<br> 1920 width x 1080 height.<br> Recommended size: smaller than 4 MB.<br> Use this free service: <a class='lp-tp-btn' href='http://www.TinyPNG.com' target='_blank'> www.TinyPNG.com </a> to compress<br> images prior to upload to reduce load time.">
                                            <img src="assets/images/ttip.png" alt="ttip">
                                        </span>
                                    </h2>
                                </div>
                                <div class="tooltip tooltip_templates">
                                    <span id="tooltip_content">
                                        Suggested background "Cover" image dimensions:<br>
                                        1920 width x 1080 height.<br> Recommended size: smaller than 4 MB.<br>
                                        Use this free service: <a class="lp-tp-btn" href="http://www.TinyPNG.com" target="_blank"> www.TinyPNG.com </a> to compress<br>
                                        images prior to upload to reduce load time.
                                    </span>
                                </div>
                            </div>
                            <div id="bgImageCards" class="collapse" data-parent="#cards">
                                <div class="card-body">
                                    <div class="browse__content">
                                        <div class="browse__step1">
                                            <div class="browse__desc">
                                                <p>
                                                    You have not added any background image yet.
                                                </p>
                                                <div class="lp-image__browse">
                                                    Click
                                                    <label class="lp-image__button" for="Cardsbrowse_img1">
                                                        <input id="Cardsbrowse_img1" name="Cardsbrowse_img1" class="lp-image__input" type="file" accept="image/*" required="" value="">
                                                        Browse
                                                    </label>
                                                    to start uploading.
                                                </div>
                                                <div class="file__control">
                                                    <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                    <p class="file__size">Maximum file size limit is 4MB.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="browse__step2">
                                            <div class="bg__wrapper">
                                                <div class="bg__image">
                                                    <div class="browse__bg-image">
                                                        <div id="bgCardsPreview-overlay" class="bg-image"></div>
                                                        <div class="action">
                                                            <ul class="action__list">
                                                                <li class="action__item del__img">
                                                                    <button class="btn-image__del button button-cancel">
                                                                        delete
                                                                    </button>
                                                                </li>
                                                                <li class="action__item">
                                                                    <div class="lp-image__browse">
                                                                        <label class="button button-primary" for="Cardsbrowse_img2">
                                                                            <input id="Cardsbrowse_img2" class="lp-image__input" type="file" accept="image/*" required="" value="">
                                                                            Browse
                                                                        </label>
                                                                    </div>
                                                                    <div class="file__control">
                                                                        <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                                        <p class="file__size">Maximum file size limit is 4MB.</p>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg__controls">
                                                    <div class="form-group">
                                                        <label for="bgCards__active-overlay">Background Overlay Color</label>
                                                        <div class="main__control bg__control_overlay-wrapper">
                                                            <div class="text-color-parent">
                                                                <div class="color-picker bgCardsColor-picker__overlay" style="background-color: rgb(106, 153, 148);"></div>
                                                            </div>
                                                            <input id="bgCards__active-overlay" class="bgoverly" id="bgoverly" name="bgoverly"
                                                                   data-toggle="toggle" data-onstyle="active"
                                                                   data-offstyle="inactive" data-width="127" data-height="43"
                                                                   data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Overlay Color Opacity</label>
                                                        <div class="main__control bg__control_slider">
                                                            <input id="ex3" class="form-control" data-slider-id='ex3Slider' type="text"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Background Repeat</label>
                                                        <div class="main__control">
                                                            <div class="select2__bgCards-repeat-parent">
                                                                <select class="select2__bgCards-repeat">
                                                                    <option value="no-repeat" selected="">No Repeat</option>
                                                                    <option value="repeat">Repeat</option>
                                                                    <option value="repeat-x">Repeat-X</option>
                                                                    <option value="repeat-y">Repeat-Y</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Background Position</label>
                                                        <div class="main__control">
                                                            <div class="select2__bgCards-postion-parent select2js__nice-scroll">
                                                                <select class="select2__bgCards-postion">
                                                                    <option value="center center" selected="">Center Center</option>
                                                                    <option value="center left">Center Left</option>
                                                                    <option value="center right">Center Right</option>
                                                                    <option value="top center">Top Center</option>
                                                                    <option value="top left">Top Left</option>
                                                                    <option value="top right">Top Right</option>
                                                                    <option value="bottom center">Bottom Center</option>
                                                                    <option value="bottom left">Bottom Left</option>
                                                                    <option value="bottom right">Bottom Right</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Background Size</label>
                                                        <div class="main__control">
                                                            <div class="select2__bgCards-cover-parent">
                                                                <select class="select2__bgCards-cover">
                                                                    <option value="cover" selected="">Cover</option>
                                                                    <option value="contain">Contain</option>
                                                                    <option value="auto">Default</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="collapsed card-link" data-toggle="collapse" href="#bgOwnColorCards">
                                    <span class="card-circle"></span>
                                    <h2 class="card-title"><span>Customize Your</span> Own Colors</h2>
                                </div>
                            </div>
                            <div id="bgOwnColorCards" class="collapse" data-parent="#cards">
                                <div class="card-body">
                                    <div class="owncolor">
                                        <div class="owncolor__wrapper">
                                            <div class="bgCardsowncolor__box owncolor__box"></div>
                                            <div class="owncolor__info">
                                                <label for="selectedcolor">Selected Color</label>
                                                <div class="last-selected">
                                                    <div class="last-selected__box"></div>
                                                    <div class="last-selected__code">#e6eef3</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="owncolor__controls">
                                            <div class="head">
                                                <h2>Add custom color code</h2>
                                            </div>
                                            <div class="owncolor__inner">
                                                <div class="form-group">
                                                    <label>Color Mode</label>
                                                    <div class="main__control">
                                                        <div class="select2__bgCards-colormode-parent">
                                                            <select class="select2__bgCards-colormode">
                                                                <option value="hex" selected="">HEX</option>
                                                                <option value="rbg">RGB</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Color Value</label>
                                                    <div class="main__control">
                                                        <input id="bgCards-colorval" class="form-control" value="#34409E" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-link" data-toggle="collapse" href="#bgLogoColorCards">
                                    <span class="card-circle"></span>
                                    <h2 class="card-title"><span>Automatically Pull</span> Logo Colors</h2>
                                </div>
                            </div>
                            <div id="bgLogoColorCards" class="collapse show" data-parent="#cards">
                                <div class="card-body">
                                    <div class="card-body__row">
                                        <div id="ics-gradient-editor-3-div" >
                                            <div class="gradient" id="ics-gradient-editor-3">
                                            </div>
                                        </div>
                                                                                    <div class="color__wrapper">
                                                                                        <div class="color__block color__block-black"></div>
                                                                                        <div class="color__block color__block-purple"></div>
                                                                                        <div class="color__block color__block-orange"></div>
                                                                                        <div class="color__block"></div>
                                                                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!-- footer of the page -->
                <div class="footer">
<!--                    <div class="row">-->
<!--                        <button type="submit" class="button button-secondary">Save</button>-->
<!--                    </div>-->
                    <div class="row">
                        <img src="assets/images/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </section>
        </main>
    </div>
    <!-- main tab color picker -->
    <div class="color-box__panel-wrapper main-bg-clr">
        <div class="picker-block" id="mian-bg-colorpicker">
        </div>
        <label class="color-box__label">Add custom color code</label>
        <div class="color-box__panel-rgb-wrapper">
            <div class="color-box__r">
                R: <input class="color-box__rgb" value="106"/>
            </div>
            <div class="color-box__g">
                G: <input class="color-box__rgb" value="153"/>
            </div>
            <div class="color-box__b">
                B: <input class="color-box__rgb" value="148"/>
            </div>
        </div>
        <div class="color-box__panel-hex-wrapper">
            <label class="color-box__hex-label">Hex code:</label>
            <input class="color-box__hex-block" value="#6a9994" />
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>
    <!-- funnel tab color picker -->
    <div class="color-box__panel-wrapper funnel-bg-clr">
        <div class="picker-block" id="funnel-bg-colorpicker">
        </div>
        <label class="color-box__label">Add custom color code</label>
        <div class="color-box__panel-rgb-wrapper">
            <div class="color-box__r">
                R: <input class="color-box__rgb" value="106"/>
            </div>
            <div class="color-box__g">
                G: <input class="color-box__rgb" value="153"/>
            </div>
            <div class="color-box__b">
                B: <input class="color-box__rgb" value="148"/>
            </div>
        </div>
        <div class="color-box__panel-hex-wrapper">
            <label class="color-box__hex-label">Hex code:</label>
            <input class="color-box__hex-block" value="#6a9994" />
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>
