<?php
$_SERVER['PHP_SELF'] = end(explode('/',$_SERVER['PHP_SELF']));
?>
<header class="header">
    <!-- header info-bar of the page -->
    <div class="info-bar">
        <div class="row justify-content-between">
            <div class="col-6">
                <div class="funnels-info">
                    <?php
                        if ($page_name == 'dashboard.php') {
                            ?>
                                <span class="d-block funnels-info__title">Funnels Home</span>
                            <?php
                        }
                        if(!in_array(str_replace('/','',$_SERVER['PHP_SELF']),$variation4)){
                            ?>
                            <div class="funnels-dropdown toggle-dropdown">
                                <a class="funnels-dropdown__button toggle-link" href="#">Select Funnel<span class="icon ico-arrow-down"></span></a>
                                <div class="megamenu toggle-menu">
                                    <div class="search-bar">
                                        <div class="search-bar__filter">
                                            <div class="row">
                                                <div class="search-bar__column megamenu__folder">
                                                    <select class="select-custom megamenu__folder_select">
                                                        <option value="1" selected>Mortgage</option>
                                                        <option value="2">Real Estate</option>
                                                        <option value="3">Insurance</option>
                                                        <option value="4">Legal</option>
                                                    </select>
                                                </div>
                                                <div class="search-bar__column megamenu__category">
                                                    <select class="select-custom megamenu__category_select">
                                                        <option value="1" selected>Search by Funnel Name</option>
                                                        <option value="2">Search by Funnel Tag</option>
                                                    </select>
                                                </div>
                                                <div class="search-bar__column megamenu__tag" style="display: none;">
                                                    <select class="select-custom megamenu__tag_select">
                                                        <option value="0" selected>Has ANY of these tags</option>
                                                        <option value="1">Has ALL of these tags</option>
                                                    </select>
                                                </div>
                                                <div class="search-bar__column funnel-name-search">
                                                    <div class="input-holder">
                                                        <input type="search" class="form-control" placeholder="Type in the Funnel Name ...">
                                                        <span class="icon ico-search"></span>
                                                    </div>
                                                </div>
                                                <div class="search-bar__column funnel-tag-search lp-tag">
                                                    <div class="input-holder tag-result-common top-tag-result">
                                                        <select class="top-tag-search" multiple="multiple">
                                                            <option value="al">Alabama</option>
                                                            <option value="wy">Wyoming</option>
                                                        </select>
                                                        <span class="icon ico-search"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="total-funnels">Total Funnels: <b>118</b></div>
                                    <!--megamenu funnels-->
                                    <div class="megamenu-funnels">
                                        <div class="megamenu-funnels__holder">
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="heading">Funnel Name</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <span class="heading">Funnel URL</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <span class="heading">Funnel Tags</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name el-tooltip" title="203K Hybrid">203K Hybrid</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">
                                                            <span class="el-tooltip" title="tutorial-funnelssz.itclix.com">tutorial-funnelssz.itclix.com</span>
                                                        </a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tag-select-wrap">
                                                                    <ul class="tags-list">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                        <li><span>Fith tag?</span></li>
                                                                        <li><span>Six tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tag">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name el-tooltip" title="203K Purchase">203K Purchase</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">
                                                            <span class="el-tooltip" title="kw-feliz-mm-quote.secure-clix.com">kw-feliz-mm-quote.secure-clix.com</span></a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tag-select-wrap">
                                                                    <ul class="tags-list">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                        <li><span>Fith tag?</span></li>
                                                                        <li><span>Six tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tag">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name el-tooltip" title="203K Refinance">203K Refinance</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">
                                                            <span class="el-tooltip" title="mortgage.leadpops.com">
                                                                mortgage.leadpops.com
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tag-select-wrap">
                                                                    <ul class="tags-list">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                        <li><span>Fith tag?</span></li>
                                                                        <li><span>Six tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tag">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name el-tooltip" title="Conventional Hybrid">Conventional Hybrid</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">
                                                            <span class="el-tooltip" title="network.itclix.com">network.itclix.com</span>
                                                        </a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tag-select-wrap">
                                                                    <ul class="tags-list">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                        <li><span>Fith tag?</span></li>
                                                                        <li><span>Six tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tag">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name el-tooltip" title="Conventional Purchase">Conventional Purchase</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">
                                                            <span class="el-tooltip" title="tutorial-funnelssz.itclix.com">tutorial-funnelssz.itclix.com</span>
                                                        </a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tag-select-wrap">
                                                                    <ul class="tags-list">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                        <li><span>Fith tag?</span></li>
                                                                        <li><span>Six tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tag">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name el-tooltip" title="203K Hybrid">203K Hybrid</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">
                                                            <span class="el-tooltip" title="tutorial-funnelssz.itclix.com">tutorial-funnelssz.itclix.com</span>
                                                        </a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tag-select-wrap">
                                                                    <ul class="tags-list">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                        <li><span>Fith tag?</span></li>
                                                                        <li><span>Six tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tag">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name el-tooltip" title="203K Purchase">203K Purchase</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">
                                                            <span class="el-tooltip" title="kw-feliz-mm-quote.secure-clix.com">kw-feliz-mm-quote.secure-clix.com</span>
                                                        </a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tag-select-wrap">
                                                                    <ul class="tags-list">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                        <li><span>Fith tag?</span></li>
                                                                        <li><span>Six tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tag">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name el-tooltip" title="203K Refinance">203K Refinance</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">
                                                            <span class="el-tooltip" title="mortgage.leadpops.com">mortgage.leadpops.com</span>
                                                        </a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tag-select-wrap">
                                                                    <ul class="tags-list">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                        <li><span>Fith tag?</span></li>
                                                                        <li><span>Six tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tag">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name el-tooltip" title="Conventional Hybrid">Conventional Hybrid</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">
                                                            <span class="el-tooltip" title="network.itclix.com">network.itclix.com</span>
                                                        </a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tag-select-wrap">
                                                                    <ul class="tags-list">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tag">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name el-tooltip" title="Conventional Purchase">Conventional Purchase</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">
                                                            <span class="el-tooltip" title="tutorial-funnelssz.itclix.com">tutorial-funnelssz.itclix.com</span>
                                                        </a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tag-select-wrap">
                                                                    <ul class="tags-list">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tag">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="megamenu-funnels-msg">
                                        <div class="top-messge">No matching Funnels found.</div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }else{
                            ?>
                                <div class="action action_dresponsive">
                                    <ul class="action__list">
                                        <li class="action__item desktop active">
                                            <i class="ico ico-devices"></i>
                                        </li>
                                        <li class="action__item mobile">
                                            <i class="ico ico-mobile"></i>
                                        </li>
                                        <li class="action__item">
                                            <div class="range-slider">
                                                <div class="input__wrapper">
                                                    <input id="" class="form-control ex1" data-slider-id='ex1Slider' type="text"/>
                                                    <span class="ex1SliderVal">75%</span>
                                                    <input type="hidden" class="defaultSize" value="75">
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            <?php
                        }
                        if ($page_name == 'accounts.php' || $page_name == 'support.php') {
                            ?>
                            <ul class="actions-button">
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_fhomepage" href="dashboard.php" title="Funnels Homepage">
                                        <span class="actions-button__icon ico-home"></span>
                                        <span class="actions-button__text">Funnels Homepage</span>
                                    </a>
                                </li>
                            </ul>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="col-6">
                <div class="client-setting">
                    <div class="client-setting__button">
                        <ul class="actions-button">
	                        <?php
	                        if($page_name == 'create-funnel-modal.php'){
		                        ?>
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_create-funnels actions-button__link_create-funnels--item" href="#create-funnel" data-toggle="modal" title="Create New Funnel">
                                        <span class="actions-button__icon ico-plus"></span>
                                        <span class="actions-button__text">create new funnel</span>
                                    </a>
                                </li>
		                        <?php
	                        }
	                        ?>
                            <?php
                                if (in_array(str_replace('/','',$_SERVER['PHP_SELF']), $variation1)) {
                            ?>
                                    <li class="actions-button__list">
                                        <a class="actions-button__link actions-button__link_create-funnels actions-button__link_create-funnels--item" href="#create-funnel" data-toggle="modal" title="Create New Funnel">
                                            <span class="actions-button__icon ico-plus"></span>
                                            <span class="actions-button__text">create new funnel</span>
                                        </a>
                                    </li>
                                    <li class="actions-button__list">
                                        <a class="actions-button__link actions-button__link_global" data-toggle="modal" href="#global-setting-placeholder-pop" title="Global Settings">
                                            <span class="actions-button__icon ico-settings"></span>
                                            <span class="actions-button__text">global settings</span>
                                        </a>
                                    </li>
                            <?php
                                }
	                            if (in_array(str_replace('/','',$_SERVER['PHP_SELF']), $variation2)) {
		                    ?>
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_create-funnels actions-button__link_create-funnels--item" href="#create-funnel" data-toggle="modal" title="Create New Funnel">
                                        <span class="actions-button__icon ico-plus"></span>
                                        <span class="actions-button__text">create new funnel</span>
                                    </a>
                                </li>

                                    <?php
                                    if (!in_array(str_replace('/','',$_SERVER['PHP_SELF']), $notGlobalOption)) {
                                    ?>
                                            <li class="actions-button__list">
                                                <a class="actions-button__link actions-button__link_global" data-toggle="modal" href="#global-setting-placeholder-pop" title="Global Settings">
                                                    <span class="actions-button__icon ico-settings"></span>
                                                    <span class="actions-button__text">global settings</span>
                                                </a>
                                            </li>
                                    <?php
                                        }
                                    ?>

                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_view-funnels" data-toggle="modal" href="#global-confirmation-pop" title="View My Funnel">
                                        <span class="actions-button__icon ico-view"></span>
                                        <span class="actions-button__text">view my funnel</span>
                                    </a>
                                </li>
                            <?php
	                            }
                                if (in_array(str_replace('/','',$_SERVER['PHP_SELF']), $variation3)) {
                                    ?>
                                        <li class="actions-button__list">
                                            <a class="actions-button__link actions-button__link_create-funnels actions-button__link_create-funnels--item" href="#create-funnel" data-toggle="modal" title="Create New Funnel">
                                                <span class="actions-button__icon ico-plus"></span>
                                                <span class="actions-button__text">create new funnel</span>
                                            </a>
                                        </li>
                                        <li class="actions-button__list">
                                            <a class="actions-button__link actions-button__link_view-funnels" href="#" title="View My Funnel">
                                                <span class="actions-button__icon ico-view"></span>
                                                <span class="actions-button__text">view my funnel</span>
                                            </a>
                                        </li>
                                    <?php
                            }
                                if (in_array(str_replace('/','',$_SERVER['PHP_SELF']), $variation4)) {
                                    ?>
                                        <li class="actions-button__list">
                                            <a class="actions-button__link actions-button__link_close-funnels" href="#" title="Close Funnel">
                                                <span class="actions-button__icon ico-cross"></span>
                                                <span class="actions-button__text">Close</span>
                                            </a>
                                        </li>
                                        <li class="actions-button__list">
                                            <a class="actions-button__link actions-button__link_view-funnels" href="#" title="View My Funnel">
                                                <span class="actions-button__icon ico-view"></span>
                                                <span class="actions-button__text">view my funnel</span>
                                            </a>
                                        </li>
                                    <?php
                                }
                                if (in_array(str_replace('/','',$_SERVER['PHP_SELF']), $variation5)) {
                            ?>
                                    <li class="actions-button__list">
                                        <a class="actions-button__link actions-button__link_view-funnels" href="#" title="View My Funnel">
                                            <span class="actions-button__icon ico-view"></span>
                                            <span class="actions-button__text">view my funnel</span>
                                        </a>
                                    </li>
                            <?php
                                }
                                if(!in_array(str_replace('/','',$_SERVER['PHP_SELF']), $notSaveButton)){
                                    if($page_name == 'background-advance.php'){
                                    ?>
                                                <li class="actions-button__list">
                                                    <button class="button button-secondary button-save"
                                                            type="submit" data-toggle="modal"
                                                            data-target="#color-setting-modal">Save</button>
                                                </li>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <li class="actions-button__list">
                                                    <button class="button button-secondary button-save" type="submit">Save</button>
                                                </li>
                                    <?php
                                     }
                                }
                            ?>
                        </ul>
                    </div>
                    <?php
                        if (!in_array(str_replace('/','',$_SERVER['PHP_SELF']), $variation4)) {
                    ?>
                            <div class="client-setting__profile">
                                <div class="account-setting">
                                    <div class="account-setting__info">
                                        <div class="user-info">
					                        <?php
					                        if ($page_name == 'top-nav-variations.php') {
						                        ?>
                                                <div class="user-image no-image">AP</div>
						                        <?php
					                        }else {
						                        ?>
                                                <div class="user-image">
                                                    <img src="assets/images/profile-image.png" alt="Andrew Palak" title="Andrew Palak">
                                                </div>
						                        <?php
					                        }
					                        ?>
                                            <div class="user-detail">
                                                <span class="user-name">Andrew Pawlak</span>
                                                <span class="user-id">ID# 5873</span>
                                                <a href="#" class="toggle-link"><span class="icon ico-arrow-down"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="settings__dropdown">
                                        <li class="settings__dropdown__list">
                                            <a href="accounts.php" class="settings__dropdown__link">
                                                <span class="icon ico-settings"></span>
                                                Account Settings
                                            </a>
                                        </li>
                                        <li class="settings__dropdown__list">
                                            <a href="support.php" class="settings__dropdown__link">
                                                <span class="icon ico-message"></span>
                                                Support
                                            </a>
                                        </li>
                                        <li class="settings__dropdown__list">
                                            <a href="#" class="settings__dropdown__link">
                                                <span class="icon ico-logout"></span>
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                    <?php
                        if ($page_name == 'dashboard.php') {
                          ?>
                            <ul class="list-actions">
                              <li class="list-actions__li item-stats"><a href="#" class="list-actions__link stats-trigger"><i class="icon ico-stats el-tooltip" title="<p class='global-tooltip font-small'>FUNNELS STATS SUMMARY</p>"></i></a></li>
                              <li class="list-actions__li item-search"><a href="#" class="list-actions__link search-trigger"><i class="icon ico-search el-tooltip" title="<p class='global-tooltip font-small'>SEARCH</p>"></i></a></li>
                            </ul>
                          <?php
                        }
                        if (in_array(str_replace('/','',$_SERVER['PHP_SELF']), $variation4)) {
                    ?>
                            <div class="client-setting__quick">
                                <div class="quick-opener-wrap">
                                    <a href="#" class="client-setting__opener">
                                        <span class="ico ico-order-list"></span>
                                        Quick Access
                                        <span class="client-setting__arrow-wrap">
                                        <span class="ico ico-arrow-down"></span>
                                    </span>
                                    </a>
                                </div>
                                <div class="quick-dropdown">
                                    <div class="quick-head">
                                        <span class="quick-head__heading">203K Hybrid Loans</span>
                                        <span class="quick-head__questions">Total Questions: <span class="quick-head__num">15</span></span>
                                    </div>
                                    <div class="quick-scroll">
                                        <ul class="quick-links">
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">1.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-location"></i>
                                                        Zip Code
                                                    </div>
                                                    <div class="quick-links__description">FREE Down Payment Assistance Finder</div>
                                                </a>
                                            </li>
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">2.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-hamburger"></i>
                                                        Menu
                                                    </div>
                                                    <div class="quick-links__description">What type of property are you purchasing?</div>
                                                </a>
                                            </li>
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">3.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-select-text"></i>
                                                        Text Field
                                                    </div>
                                                    <div class="quick-links__description">What is your favorite movie?</div>
                                                </a>
                                            </li>
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">4.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-expand"></i>
                                                        Slider
                                                    </div>
                                                    <div class="quick-links__description">Slider heading</div>
                                                </a>
                                            </li>
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">5.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-expand"></i>
                                                        Non-numeric Slider
                                                    </div>
                                                    <div class="quick-links__description">How would you describe your personality? <span class="quick-links__icon"><i class="ico ico-globe"></i></span></div>
                                                </a>
                                            </li>
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">6.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-calander"></i>
                                                        Date / Calendar
                                                    </div>
                                                    <div class="quick-links__description">What's your date of birth?</div>
                                                </a>
                                            </li>
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">7.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-location"></i>
                                                        List of United States
                                                    </div>
                                                    <div class="quick-links__description">In which state of the United States do you live?<span class="quick-links__icon"><i class="ico ico-start-rate"></i></span></div>
                                                </a>
                                            </li>
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">8.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-message"></i>
                                                        Custom message
                                                    </div>
                                                    <div class="quick-links__description">Thank you for using leadpops funnels admin!<span class="quick-links__icon"><i class="ico ico-globe"></i></span></div>
                                                </a>
                                            </li>
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">9.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-location"></i>
                                                        Zip Code
                                                    </div>
                                                    <div class="quick-links__description">FREE Down Payment Assistance Finder</div>
                                                </a>
                                            </li>
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">10.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-hamburger"></i>
                                                        Menu
                                                    </div>
                                                    <div class="quick-links__description">What type of property are you purchasing?</div>
                                                </a>
                                            </li>
                                            <li class="quick-links__item">
                                                <a href="#" class="quick-links__link">
                                                    <span class="quick-links__item-num">11.</span>
                                                    <div class="quick-links__heading">
                                                        <i class="ico ico-select-text"></i>
                                                        Text Field
                                                    </div>
                                                    <div class="quick-links__description">What is your favorite movie?</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- header Search of the page -->
    <?php
        if ($page_name == 'dashboard.php') {
    ?>
    <div class="search-bar-slide">
      <div class="search-bar">
          <div class="search-bar-wrap">
            <span class="search-bar__caption font-italic">Filter by:</span>
            <div class="search-bar__filter">
                <div class="row">
                    <div class="search-bar__column funnel-type">
                        <select class="select-custom select-custom_type">
                            <option value="0" selected>All Funnels</option>
                            <option value="3">Mortgage Funnels</option>
                            <option value="w">Website Funnels</option>
                            <option value="5">Real Estate Funnels</option>
                            <option value="1">Insurance Funnels</option>
                        </select>
                    </div>
                    <div class="search-bar__column funnel-category">
                        <select class="select-custom select-custom_category">
                            <option value="1" selected>Search by Funnel Name</option>
                            <option value="2">Search by Funnel Tag</option>
                        </select>
                    </div>
                    <div class="search-bar__column funnel-tag" style="display:none;">
                        <select class="select-custom select-custom_tag">
                            <option value="0" selected>Has ANY of these tags</option>
                            <option value="1">Has ALL of these tags</option>
                        </select>
                    </div>
                    <div class="search-bar__column funnel-name-search">
                        <div class="input-holder">
                            <input type="search" class="form-control" placeholder="Type in the Funnel Name ...">
                            <span class="icon ico-search"></span>
                        </div>
                    </div>
                    <div class="search-bar__column funnel-tag-search">
                        <div class="input-holder">
    <!--                        <select class="custom-search" multiple="multiple">-->
    <!--                            <option value="al">Alabama</option>-->
    <!--                            <option value="wy">Wyoming</option>-->
    <!--                        </select>-->
                            <div class="input__wrapper lp-tag">
                                <div class="select2js__tags-parent tag-result-common tag-result">
                                    <select class="form-control tag-drop-down" multiple="multiple" name="tag_list" id="tag_list">
                                        <option value="1">203k</option>
                                        <option value="2">leadPops</option>
                                    </select>
                                    <span class="icon ico-search"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              <span class="close-link-wrap">
                <a href="#" class="close-link search-trigger"><i class="icon ico-cross el-tooltip" title="<p class='global-tooltip font-small'>CLOSE</p>"></i></a>
              </span>
          </div>
    </div>
    </div>
    <div class="stats-area-slide">
      <div class="stats-area">
        <div class="stats-head">
            <strong class="stats-area__title"><i class="icon ico-stats"></i>Funnels Stats Summary</strong>
            <a href="#" class="close-stats stats-trigger"><i class="icon ico-cross el-tooltip" title="<p class='global-tooltip font-small'>CLOSE</p>"></i></a>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="stats-box">
                    <div class="stats-box__head">
                        <span class="stats-box__title">Total Funnels</span>
                        <a href="#total-funnels-setting" data-toggle="modal" class="stats-box__link-settings"><i class="icon ico-settings el-tooltip" title="<p class='global-tooltip font-small'>SETTINGS</p>"></i></a>
                    </div>
                    <div class="stats-box__body">
                        <strong class="stats-box__num">118</strong>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="stats-box">
                    <div class="stats-box__head">
                        <span class="stats-box__title">Total Visitors</span>
                    </div>
                    <div class="stats-box__body">
                        <strong class="stats-box__num">15,329</strong>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="stats-box">
                    <div class="stats-box__head">
                        <span class="stats-box__title">Total Leads</span>
                    </div>
                    <div class="stats-box__body">
                        <strong class="stats-box__num">4,270</strong>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="stats-box">
                    <div class="stats-box__head">
                        <span class="stats-box__title">Total Conversion Rate</span>
                      <a href="#conversion-setting" data-toggle="modal" class="stats-box__link-settings"><i class="icon ico-settings el-tooltip" title="<p class='global-tooltip font-small'>SETTINGS</p>"></i></a>
                    </div>
                    <div class="stats-box__body">
                        <strong class="stats-box__num">27.85<span class="unit">%</span></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
        }
    ?>
</header>
