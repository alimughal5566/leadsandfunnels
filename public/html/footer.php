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
        <!-- content of the page -->
        <main class="main">
            <section class="main-content footer-advance">

                <form id="footer-page" action="" class="global-content-form">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head main-content__head_tabs">
                        <div class="col-left">
                            <h1 class="title">
                                Footer / Funnel:
                                <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
                            </h1>
                            <input  id="footer-page" name="footer-page" data-toggle="toggle"
                                    data-onstyle="active" data-offstyle="inactive"
                                    data-width="127" data-height="43" data-on="INACTIVE"
                                    data-off="ACTIVE" type="checkbox" checked>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Footer" data-lp-wistia-key="csu0gemvgx" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                            <div class="tab__wrapper">
                                <ul class="nav nav__tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tbOptions">Options</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tbImages">Images</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="lp-panel lp-panel_tabs">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Primary Footer Preview
                                </h2>
                            </div>
                            <div class="col-right">
                                <ul class="nav nav__tab" role="tablist">
                                    <li class="nav-item">
                                        <div class="col-clr nav-link">
                                            <label>Background</label>
                                            <div class="text-color-parent">
                                                <div class="color-picker" id="clr_bg_footer" style="background-color: #ffffff;"></div>
                                            </div>
                                            <!--  color picker -->
                                            <div class="color-box__panel-wrapper footer-background-clr">

                                                <div class="color-box__panel-dropdown">
                                                    <select class="color-picker-options">
                                                        <option value="1">Color Selection:  Pick My Own</option>
                                                        <option value="2">Color Selection:  Pull from Logo</option>
                                                    </select>
                                                </div>
                                                <div class="color-picker-block">
                                                    <div class="picker-block" id="footer-background-clr">
                                                    </div>
                                                    <label class="color-box__label">Add custom color code</label>
                                                    <div class="color-box__panel-rgb-wrapper">
                                                        <div class="color-box__r">
                                                            R: <input class="color-box__rgb" value="255"/>
                                                        </div>
                                                        <div class="color-box__g">
                                                            G: <input class="color-box__rgb" value="255"/>
                                                        </div>
                                                        <div class="color-box__b">
                                                            B: <input class="color-box__rgb" value="255"/>
                                                        </div>
                                                    </div>
                                                    <div class="color-box__panel-hex-wrapper">
                                                        <label class="color-box__hex-label">Hex code:</label>
                                                        <input class="color-box__hex-block" id="footer-background-clr-trigger" value="#ffffff" />
                                                        <input type="hidden" class="color-opacity" value="1">
                                                    </div>
                                                </div>
                                                <div class="color-pull-block">
                                                    <label class="color-box__label">Pulled colors</label>
                                                    <ul class="color-box__list">
                                                        <li class="color-box__item"></li>
                                                        <li class="color-box__item red"></li>
                                                        <li class="color-box__item green"></li>
                                                        <li class="color-box__item black"></li>
                                                        <li class="color-box__item blue"></li>
                                                        <li class="color-box__item orange"></li>
                                                        <li class="color-box__item yellow"></li>
                                                        <li class="color-box__item parrot"></li>
                                                    </ul>
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
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="col-clr nav-link">
                                            <label>Text</label>
                                            <div class="text-color-parent">
                                                <div class="color-picker" id="clr_txt_footer" style="background-color: #b4bbbc;"></div>
                                            </div>
                                            <!--  color picker -->
                                            <div class="color-box__panel-wrapper footer-text-clr">

                                                <div class="color-box__panel-dropdown">
                                                    <select class="color-picker-options">
                                                        <option value="1">Color Selection:  Pick My Own</option>
                                                        <option value="2">Color Selection:  Pull from Logo</option>
                                                    </select>
                                                </div>
                                                <div class="color-picker-block">
                                                    <div class="picker-block" id="footer-text-clr">
                                                    </div>
                                                    <label class="color-box__label">Add custom color code</label>
                                                    <div class="color-box__panel-rgb-wrapper">
                                                        <div class="color-box__r">
                                                            R: <input class="color-box__rgb" value="180"/>
                                                        </div>
                                                        <div class="color-box__g">
                                                            G: <input class="color-box__rgb" value="187"/>
                                                        </div>
                                                        <div class="color-box__b">
                                                            B: <input class="color-box__rgb" value="188"/>
                                                        </div>
                                                    </div>
                                                    <div class="color-box__panel-hex-wrapper">
                                                        <label class="color-box__hex-label">Hex code:</label>
                                                        <input class="color-box__hex-block" id="footer-text-clr-trigger" value="#b4bbbc" />
                                                        <input type="hidden" class="color-opacity" value="1">
                                                    </div>
                                                </div>
                                                <div class="color-pull-block">
                                                    <label class="color-box__label">Pulled colors</label>
                                                    <ul class="color-box__list">
                                                        <li class="color-box__item"></li>
                                                        <li class="color-box__item red"></li>
                                                        <li class="color-box__item green"></li>
                                                        <li class="color-box__item black"></li>
                                                        <li class="color-box__item blue"></li>
                                                        <li class="color-box__item orange"></li>
                                                        <li class="color-box__item yellow"></li>
                                                        <li class="color-box__item parrot"></li>
                                                    </ul>
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
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tbcomputer" data-toggle="pill" href="#computer">
                                            <span class="ico ico-devices el-tooltip" title="Computer & Tablet"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tbmobile" data-toggle="pill" href="#mobile">
                                            <span class="ico ico-Mobile el-tooltip" title="Mobile"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="tab-content">
                                <div id="computer" class="tab-pane fade in show active">
                                    <div class="fp-area">
                                        <div class="fp-area__left">
                                            <ul class="logo-list-left"></ul>
                                            <p class="fp-copyright">
                                                Equinox Mortgage &#169; 2021. All Rights Reserved
                                            </p>
                                        </div>
                                        <div class="fp-area__right">
                                            <ul class="fp-nav__list">
                                                <li class="fp-nav__item">
                                                    <a class="fp-nav__link" href="#">
                                                        Privacy Policy
                                                    </a>
                                                </li>
                                                <li class="fp-nav__item">
                                                    <a class="fp-nav__link" href="#">
                                                        Terms & Conditions
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul class="logo-list-right"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="mobile" class="tab-pane fade">
                                    <div class="fp-area">
                                        <div class="fp-area__left">
                                            <ul class="logo-list-left"></ul>
                                            <p class="fp-copyright">
                                                Equinox Mortgage &#169; 2020. All Rights Reserved
                                            </p>
                                        </div>
                                        <div class="fp-area__right">
                                            <ul class="fp-nav__list">
                                                <li class="fp-nav__item">
                                                    <a class="fp-nav__link" href="#">
                                                        Privacy Policy
                                                    </a>
                                                </li>
                                                <li class="fp-nav__item">
                                                    <a class="fp-nav__link" href="#">
                                                        Terms & Conditions
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul class="logo-list-right"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="tab-content">
                        <div id="tbOptions" class="tab-pane active">
                            <div class="lp-panel py-0">
                                <div class="card-header">
                                    <div class="lp-panel__head border-0 heading-wrap">
                                        <div class="col-left">
                                            <h2 class="card-title">
                                            <span>
                                                Primary Footer Options
                                            </span>
                                            </h2>
                                        </div>
                                        <div class="col-right">
                                            <div class="card-link expandable" data-toggle="collapse"
                                                 href="#primaryfooter">
                                                <span class="expand-overlay">
                                                    <span class="icon ico-full-screen el-tooltip" title='<div
                                                    class="f-edit-tooltip">Expand</div>'></span>
                                                    <span class="icon ico-cross el-tooltip" title='<div
                                                    class="f-edit-tooltip">Collapse</div>'></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="primaryfooter" class="footer-advance-area collapse show" >
                                    <div class="card-body page-panel__sortable">
                                        <div class="lp-panel open-close-parent">
                                            <div class="lp-panel__head drag-feature">
                                                <div class="col-left">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item action__item_separator">
                                                                <span class="action__span">
                                                                    <span class="ico ico-drag-dots"></span>
                                                                </span>
                                                            </li>
                                                            <li class="action__item">
                                                                <h3 class="lp-panel__title">Privacy Policy</h3>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-right">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <input  id="fp-privacy-policy" name="fp-privacy-policy" data-toggle="toggle"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                                        data-off="ACTIVE" type="checkbox">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="privacy-policy.php" class="action__link
                                                                el-tooltip" title='<div class="f-edit-tooltip">edit</div>'>
                                                                    <span class="ico ico-edit"></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lp-panel">
                                            <div class="lp-panel__head drag-feature">
                                                <div class="col-left">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item action__item_separator">
                                                                <span class="action__span">
                                                                    <span class="ico ico-drag-dots"></span>
                                                                </span>
                                                            </li>
                                                            <li class="action__item">
                                                                <h3 class="lp-panel__title">Terms of Use</h3>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-right">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <input  id="fp-terms" name="fp-terms" data-toggle="toggle"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                                        data-off="ACTIVE" type="checkbox">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#modal_terms" data-toggle="modal" class="action__link
                                                                el-tooltip"
                                                                   title='<div class="f-edit-tooltip">edit</div>'>
                                                                    <span class="ico ico-edit"></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lp-panel">
                                            <div class="lp-panel__head drag-feature">
                                                <div class="col-left">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item action__item_separator">
                                                                <span class="action__span">
                                                                    <span class="ico ico-drag-dots"></span>
                                                                </span>
                                                            </li>
                                                            <li class="action__item">
                                                                <h3 class="lp-panel__title">Disclosures</h3>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-right">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <input  id="fp-disclosures" name="fp-disclosures" data-toggle="toggle"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                                        data-off="ACTIVE" type="checkbox">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link el-tooltip" title='<div class="f-edit-tooltip">edit</div>'>
                                                                    <span class="ico ico-edit"></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lp-panel">
                                            <div class="lp-panel__head drag-feature">
                                                <div class="col-left">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item action__item_separator">
                                                                <span class="action__span">
                                                                    <span class="ico ico-drag-dots"></span>
                                                                </span>
                                                            </li>
                                                            <li class="action__item">
                                                                <h3 class="lp-panel__title">Licensing Information</h3>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-right">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <input  id="fp-disclosures1" name="fp-disclosures1" data-toggle="toggle"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                                        data-off="ACTIVE" type="checkbox">
                                                               <!-- <input  id="fp-licensing" name="fp-licensing"
                                                                         data-toggle="toggle"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                                        data-off="ACTIVE" type="checkbox" checked> -->
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link el-tooltip" title='<div class="f-edit-tooltip">edit</div>'>
                                                                    <span class="ico ico-edit"></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lp-panel">
                                            <div class="lp-panel__head drag-feature">
                                                <div class="col-left">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item action__item_separator">
                                                                <span class="action__span">
                                                                    <span class="ico ico-drag-dots"></span>
                                                                </span>
                                                            </li>
                                                            <li class="action__item">
                                                                <h3 class="lp-panel__title">About Us</h3>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-right">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <input  id="fp-about-us" name="fp-about-us"
                                                                        data-thelink="header-page_active" data-toggle="toggle"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                                        data-off="ACTIVE" type="checkbox">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link el-tooltip" title='<div class="f-edit-tooltip">edit</div>'>
                                                                    <span class="ico ico-edit"></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lp-panel">
                                            <div class="lp-panel__head drag-feature">
                                                <div class="col-left">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item action__item_separator">
                                                                <span class="action__span">
                                                                    <span class="ico ico-drag-dots"></span>
                                                                </span>
                                                            </li>
                                                            <li class="action__item">
                                                                <h3 class="lp-panel__title">Contact Us</h3>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-right">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <input  id="fp-contact-us" name="fp-contact-us"
                                                                        data-thelink="header-page_active" data-toggle="toggle"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                                        data-off="ACTIVE" type="checkbox">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link el-tooltip" title='<div class="f-edit-tooltip">edit</div>'>
                                                                    <span class="ico ico-edit"></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel py-0">
                                <div class="card-header">
                                    <div class="lp-panel__head heading-wrap border-0">
                                        <div class="col-left">
                                            <h2 class="card-title">
                                            <span>
                                                Secondary Footer Options
                                            </span>
                                            </h2>
                                        </div>
                                        <div class="col-right">
                                            <div class="card-link collapsed expandable" data-toggle="collapse" href="#secondaryfooter">
                                                <span class="expand-overlay">
                                                    <span class="icon ico-full-screen el-tooltip" title='<div
                                                    class="f-edit-tooltip">Expand</div>'></span>
                                                    <span class="icon ico-cross el-tooltip" title='<div
                                                    class="f-edit-tooltip">Collapse</div>'></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="secondaryfooter" class="footer-advance-area collapse" >
                                    <div class="card-body page-panel__sortable">
                                        <div class="lp-panel">
                                            <div class="lp-panel__head drag-feature">
                                                <div class="col-left">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item action__item_separator">
                                                                <span class="action__span">
                                                                    <span class="ico ico-drag-dots"></span>
                                                                </span>
                                                            </li>
                                                            <li class="action__item">
                                                                <h3 class="lp-panel__title">Compliance Text</h3>
                                                                <input class="form-control line-input" value="Compliance Text" type="text">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-right">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <input  id="fp-disclosures" name="fp-disclosures" data-toggle="toggle"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                                        data-off="ACTIVE" type="checkbox">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <span class="action__span action__span_toggle">
                                                                    <a href="javascript:void(0)" class="action__link
                                                                    action__link_edit el-tooltip" title='<div
                                                                    class="f-edit-tooltip">Edit</div>'>
                                                                        <span class="ico ico-edit"></span>
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="action__link
                                                                    action__link_cancel el-tooltip" title='<div
                                                                    class="f-edit-tooltip">Close</div>'>
                                                                        <span class="ico ico-cross"></span>
                                                                    </a>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse-box hide border-top-0">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-4 col-xl-2">
                                                        <div class="checkbox mt-2">
                                                            <input type="checkbox" class="collapse-checkbox" id="checkboxcomplainlink" name="checkboxcomplainlink" checked value="">
                                                            <label class="normal-font" for="checkboxcomplainlink">
                                                                Link to URL
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8 col-xl-7">
                                                        <div class="form-group m-0">
                                                            <label class="col-sm-2 col-xl-1 pl-0">URL</label>
                                                            <input class="form-control collapse-next-input" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lp-panel">
                                            <div class="lp-panel__head drag-feature">
                                                <div class="col-left">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item action__item_separator">
                                                                <span class="action__span">
                                                                    <span class="ico ico-drag-dots"></span>
                                                                </span>
                                                            </li>
                                                            <li class="action__item">
                                                                <h3 class="lp-panel__title">License Number</h3>
                                                                <input class="form-control line-input" value="License Number" type="text">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-right">
                                                    <div class="action">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <input  id="fp-disclosures" name="fp-disclosures" data-toggle="toggle"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                                        data-off="ACTIVE" type="checkbox">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <span class="action__span action__span_toggle">
                                                                    <a href="javascript:void(0)" class="action__link
                                                                    action__link_edit el-tooltip" title='<div
                                                                    class="f-edit-tooltip">Edit</div>'>
                                                                        <span class="ico ico-edit"></span>
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="action__link
                                                                    action__link_cancel el-tooltip" title='<div
                                                                    class="f-edit-tooltip">Close</div>'>
                                                                        <span class="ico ico-cross"></span>
                                                                    </a>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse-box hide">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-4 col-xl-2">
                                                        <div class="checkbox mt-2">
                                                            <input type="checkbox" class="collapse-checkbox" id="checkboxcomplainlink" name="checkboxcomplainlink" checked value="">
                                                            <label class="normal-font" for="checkboxcomplainlink">
                                                                Link to URL
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8 col-xl-7">
                                                        <div class="form-group m-0">
                                                            <label class="col-sm-2 col-xl-1 pl-0">URL</label>
                                                            <input class="form-control collapse-next-input" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <div class="row">
                                    <img src="assets/images/footer-logo.png" alt="footer logo">
                                </div>
                            </div>
                        </div>
                        <div id="tbImages" class="tab-pane">
                            <div class="lp-panel-wrapper">
                                <div class="lp-panel-left">
                                    <div class="lp-panel">
                                        <div class="lp-panel__head">
                                            <div class="col-left">
                                                <h2 class="lp-panel__title">
                                                    Images <span>/ Left Side</span>
                                                </h2>
                                            </div>
                                        </div>
                                        <div class="lp-panel__body">
                                            <ul class="logo__list left">
                                                <li data-index="0" class="logo__item">
                                                    <div class="dz-logo dropzone needsclick bg-main__dropzone" id="bg-image1">
                                                        <div class="dz-message needsclick">
                                                            <i class="icon ico-plus"></i>
                                                            <span class="dz-caption">upload image</span>
                                                        </div>
                                                    </div>
                                                    <div class="slider-wrapper">
                                                        <input class="logo-slider" type="text" data-slider-min="0" data-slider-max="100" value="75"/>
                                                    </div>
                                                </li>
                                                <li data-index="1" class="logo__item">
                                                    <div class="dropzone needsclick bg-main__dropzone" id="bg-image2">
                                                        <div class="dz-message needsclick">
                                                            <i class="icon ico-plus"></i>
                                                            <span class="dz-caption">upload image</span>
                                                        </div>
                                                    </div>
                                                    <div class="slider-wrapper">
                                                        <input class="logo-slider" type="text" data-slider-min="0" data-slider-max="100" value="65"/>
                                                    </div>
                                                </li>
                                                <li data-index="2" class="logo__item">
                                                    <div class="dropzone needsclick bg-main__dropzone" id="bg-image3">
                                                        <div class="dz-message needsclick">
                                                            <i class="icon ico-plus"></i>
                                                            <span class="dz-caption">upload image</span>
                                                        </div>
                                                    </div>
                                                    <div class="slider-wrapper">
                                                        <input class="logo-slider" type="text" data-slider-min="0" data-slider-max="100" value="75"/>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel-right">
                                    <div class="lp-panel">
                                        <div class="lp-panel__head">
                                            <div class="col-left">
                                                <h2 class="lp-panel__title">
                                                    Images <span>/ Right Side</span>
                                                </h2>
                                            </div>
                                        </div>
                                        <div class="lp-panel__body">
                                            <ul class="logo__list right">
                                                <li data-index="4" class="logo__item">
                                                    <div class="dropzone needsclick bg-main__dropzone" id="bg-image4">
                                                        <div class="dz-message needsclick">
                                                            <i class="icon ico-plus"></i>
                                                            <span class="dz-caption">upload image</span>
                                                        </div>
                                                    </div>
                                                    <div class="slider-wrapper">
                                                        <input class="logo-slider" type="text" data-slider-min="0" data-slider-max="100" value="100"/>
                                                    </div>
                                                </li>
                                                <li data-index="5" class="logo__item">
                                                    <div class="dropzone needsclick bg-main__dropzone" id="bg-image5">
                                                        <div class="dz-message needsclick">
                                                            <i class="icon ico-plus"></i>
                                                            <span class="dz-caption">upload image</span>
                                                        </div>
                                                    </div>
                                                    <div class="slider-wrapper">
                                                        <input class="logo-slider" type="text" data-slider-min="0" data-slider-max="100" value="100"/>
                                                    </div>
                                                </li>
                                                <li data-index="6" class="logo__item">
                                                    <div class="dropzone needsclick bg-main__dropzone" id="bg-image6">
                                                        <div class="dz-message needsclick">
                                                            <i class="icon ico-plus"></i>
                                                            <span class="dz-caption">upload image</span>
                                                        </div>
                                                    </div>
                                                    <div class="slider-wrapper">
                                                        <input class="logo-slider" type="text" data-slider-min="0" data-slider-max="100" value="75"/>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <div class="row">
                                    <img src="assets/images/footer-logo.png" alt="footer logo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <!-- footer of the page -->
                </form>
            </section>
        </main>
    </div>
    <!-- Model Boxes - Start -->
    <div class="modal fade modal-terms" id="modal_terms" tabindex="-1" role="dialog" aria-labelledby="modal_terms"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal__head-col">
                        <h5 class="modal-title">Terms of Use</h5>
                    </div>
                    <div class="modal__head-col">
                        <ul class="global-setting-list">
                            <li class="global-setting-list__li">
                                <div class="switcher">
                                    <input id="terms" name="terms"
                                             data-toggle="toggle"
                                             data-onstyle="active" data-offstyle="inactive"
                                             data-width="126" data-height="42" data-on="INACTIVE"
                                             data-off="ACTIVE" type="checkbox">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-body quick-scroll">
                    <div class="modal-body-wrap">
                        <div class="selection-row">
                            <div class="select-area">
                                <label>Link Terms of Use to
                                    <span class="question-mark el-tooltip" title='<div
                                    class="global-setting-tooltip">Link Terms of Use to</div>'>
                                        <i class="ico-question"></i>
                                    </span>
                                </label>
                                <div class="terms-select-parent select2-parent">
                                    <select class="terms-select"></select>
                                </div>
                            </div>
                            <div class="field-area">
                                <label for="link-text">Link text</label>
                                <input type="text" class="form-control" placeholder="Enter Link Text" id="link-text">
                            </div>
                        </div>
                        <div id="webaddress">
                            <div class="footer-advance-msg-box">
                                <label for="web-url">Website URL</label>
                                <input type="text" class="form-control" name="web-url"  id="web-url"
                                       placeholder="www.anotherwebsiteURL.com/">
                            </div>
                        </div>
                        <div id="webmodal">
                        <div class="footer-advance-editor">
                            <textarea name="footereditor" class="lp-pp-section lp-froala-textbox"></textarea>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary" disabled>Save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>
