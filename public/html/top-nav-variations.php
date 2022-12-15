<?php
include ("includes/head.php");
?>
<!-- contain sidebar of the page -->

<!-- contain the main content of the page -->
<div id="content" class="w-100">
    <!-- account page -->
    <br>
    <h2 class="text-center">Account page</h2>
    <header class="header">
        <!-- header info-bar of the page -->
        <div class="info-bar">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <div class="funnels-info">
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
                                                    <option value="0" selected>Doesn't have ANY of these tags</option>
                                                    <option value="1">Doesn't have ALL of these tags</option>
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
                                                    <select class="custom-search" multiple="multiple">
                                                        <option value="al">Alabama</option>
                                                        <option value="wy">Wyoming</option>
                                                    </select>
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
                                                    <span class="funnel-name">203K Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">kw-feliz-mm-quote.secure-clix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Refinance</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">mortgage.leadpops.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">network.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">kw-feliz-mm-quote.secure-clix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Refinance</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">mortgage.leadpops.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">network.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="client-setting">
                        <div class="client-setting__button">
                            <ul class="actions-button">
                                <!-- Create new funnel -->
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_create-funnels el-tooltip" href="#" title="This feature is coming soon!">
                                        <span class="actions-button__icon ico-plus"></span>
                                        <span class="actions-button__text">create new funnel</span>
                                    </a>
                                </li>
                                <!-- Global settings -->
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_global" data-toggle="modal" href="#global-setting-placeholder-pop" title="Global Settings">
                                        <span class="actions-button__icon ico-settings"></span>
                                        <span class="actions-button__text">global settings</span>
                                    </a>
                                </li>
                                <li class="actions-button__list">
                                    <button class="button button-secondary">Save</button>
                                </li>
                            </ul>
                        </div>
                        <div class="client-setting__profile">
                            <div class="account-setting">
                                <div class="account-setting__info">
                                    <div class="user-info">
                                        <div class="user-image">
                                            <img src="assets/images/profile-image.png" alt="Andrew Palak" title="Andrew Palak">
                                        </div>
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
                                        <a href="#" class="settings__dropdown__link">
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
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- variantion 1 -->
    <br>
    <h2 class="text-center">Variation 1</h2>
    <header class="header">
        <!-- header info-bar of the page -->
        <div class="info-bar">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <div class="funnels-info">
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
                                                    <option value="0" selected>Doesn't have ANY of these tags</option>
                                                    <option value="1">Doesn't have ALL of these tags</option>
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
                                                    <select class="custom-search" multiple="multiple">
                                                        <option value="al">Alabama</option>
                                                        <option value="wy">Wyoming</option>
                                                    </select>
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
                                                    <span class="funnel-name">203K Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">kw-feliz-mm-quote.secure-clix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Refinance</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">mortgage.leadpops.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">network.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">kw-feliz-mm-quote.secure-clix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Refinance</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">mortgage.leadpops.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">network.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="client-setting">
                        <div class="client-setting__button">
                            <ul class="actions-button">
                                <!-- Create new funnel -->
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_create-funnels el-tooltip" href="#" title="This feature is coming soon!">
                                        <span class="actions-button__icon ico-plus"></span>
                                        <span class="actions-button__text">create new funnel</span>
                                    </a>
                                </li>
                                <!-- global setting -->
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_global" data-toggle="modal" href="#global-setting-placeholder-pop" title="Global Settings">
                                        <span class="actions-button__icon ico-settings"></span>
                                        <span class="actions-button__text">global settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="client-setting__profile">
                            <div class="account-setting">
                                <div class="account-setting__info">
                                    <div class="user-info">
                                        <div class="user-image no-image">AP</div>
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
                                        <a href="#" class="settings__dropdown__link">
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
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br>
    <!-- variantion 2 -->
    <h2 class="text-center">Variation 2</h2>
    <header class="header">
        <!-- header info-bar of the page -->
        <div class="info-bar">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <div class="funnels-info">
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
                                                        <option value="0" selected>Doesn't have ANY of these tags</option>
                                                        <option value="1">Doesn't have ALL of these tags</option>
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
                                                        <select class="custom-search" multiple="multiple">
                                                            <option value="al">Alabama</option>
                                                            <option value="wy">Wyoming</option>
                                                        </select>
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
                                                        <span class="funnel-name">203K Hybrid</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <ul class="tags-list">
                                                            <li><span>First tag</span></li>
                                                            <li><span>Second tag</span></li>
                                                            <li><span>A bit longer tag</span></li>
                                                            <li><span>Fourth tag?</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name">203K Purchase</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">kw-feliz-mm-quote.secure-clix.com</a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <ul class="tags-list">
                                                            <li><span>First tag</span></li>
                                                            <li><span>Second tag</span></li>
                                                            <li><span>A bit longer tag</span></li>
                                                            <li><span>Fourth tag?</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name">203K Refinance</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">mortgage.leadpops.com</a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <ul class="tags-list">
                                                            <li><span>First tag</span></li>
                                                            <li><span>Second tag</span></li>
                                                            <li><span>A bit longer tag</span></li>
                                                            <li><span>Fourth tag?</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name">Conventional Hybrid</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">network.itclix.com</a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <ul class="tags-list">
                                                            <li><span>First tag</span></li>
                                                            <li><span>Second tag</span></li>
                                                            <li><span>A bit longer tag</span></li>
                                                            <li><span>Fourth tag?</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name">Conventional Purchase</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <ul class="tags-list">
                                                            <li><span>First tag</span></li>
                                                            <li><span>Second tag</span></li>
                                                            <li><span>A bit longer tag</span></li>
                                                            <li><span>Fourth tag?</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name">203K Hybrid</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <ul class="tags-list">
                                                            <li><span>First tag</span></li>
                                                            <li><span>Second tag</span></li>
                                                            <li><span>A bit longer tag</span></li>
                                                            <li><span>Fourth tag?</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name">203K Purchase</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">kw-feliz-mm-quote.secure-clix.com</a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <ul class="tags-list">
                                                            <li><span>First tag</span></li>
                                                            <li><span>Second tag</span></li>
                                                            <li><span>A bit longer tag</span></li>
                                                            <li><span>Fourth tag?</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name">203K Refinance</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">mortgage.leadpops.com</a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <ul class="tags-list">
                                                            <li><span>First tag</span></li>
                                                            <li><span>Second tag</span></li>
                                                            <li><span>A bit longer tag</span></li>
                                                            <li><span>Fourth tag?</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name">Conventional Hybrid</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">network.itclix.com</a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <ul class="tags-list">
                                                            <li><span>First tag</span></li>
                                                            <li><span>Second tag</span></li>
                                                            <li><span>A bit longer tag</span></li>
                                                            <li><span>Fourth tag?</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="megamenu-funnels__box">
                                                <div class="row">
                                                    <div class="megamenu-funnels__column">
                                                        <span class="funnel-name">Conventional Purchase</span>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                    </div>
                                                    <div class="megamenu-funnels__column">
                                                        <ul class="tags-list">
                                                            <li><span>First tag</span></li>
                                                            <li><span>Second tag</span></li>
                                                            <li><span>A bit longer tag</span></li>
                                                            <li><span>Fourth tag?</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="client-setting">
                        <div class="client-setting__button">
                            <ul class="actions-button">
                                <!-- Create new funnel -->
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_create-funnels el-tooltip" href="#" title="This feature is coming soon!">
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
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_view-funnels" href="#" title="view my funnel">
                                        <span class="actions-button__icon ico-view"></span>
                                        <span class="actions-button__text">view my funnel</span>
                                    </a>
                                </li>
                                <li class="actions-button__list">
                                    <button class="button button-secondary">Save</button>
                                </li>
                            </ul>
                        </div>
                        <div class="client-setting__profile">
                            <div class="account-setting">
                                <div class="account-setting__info">
                                    <div class="user-info">
                                        <div class="user-image no-image">AP</div>
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
                                        <a href="#" class="settings__dropdown__link">
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
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br>
    <!-- variantion 3 -->
    <h2 class="text-center">Variation 3</h2>
    <header class="header">
        <!-- header info-bar of the page -->
        <div class="info-bar">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <div class="funnels-info">
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
                                                    <option value="0" selected>Doesn't have ANY of these tags</option>
                                                    <option value="1">Doesn't have ALL of these tags</option>
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
                                                    <select class="custom-search" multiple="multiple">
                                                        <option value="al">Alabama</option>
                                                        <option value="wy">Wyoming</option>
                                                    </select>
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
                                                    <span class="funnel-name">203K Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">kw-feliz-mm-quote.secure-clix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Refinance</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">mortgage.leadpops.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">network.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">kw-feliz-mm-quote.secure-clix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Refinance</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">mortgage.leadpops.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">network.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="client-setting">
                        <div class="client-setting__button">
                            <ul class="actions-button">
                                    <!-- Create new funnel -->
                                    <li class="actions-button__list">
                                        <a class="actions-button__link actions-button__link_create-funnels el-tooltip" href="#" title="This feature is coming soon!">
                                            <span class="actions-button__icon ico-plus"></span>
                                            <span class="actions-button__text">create new funnel</span>
                                        </a>
                                    </li>
                                    <li class="actions-button__list">
                                        <a class="actions-button__link actions-button__link_view-funnels" href="#" title="view my funnel">
                                            <span class="actions-button__icon ico-view"></span>
                                            <span class="actions-button__text">view my funnel</span>
                                        </a>
                                    </li>
                            </ul>
                        </div>
                        <div class="client-setting__profile">
                            <div class="account-setting">
                                <div class="account-setting__info">
                                    <div class="user-info">
                                        <div class="user-image no-image">AP</div>
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
                                        <a href="#" class="settings__dropdown__link">
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
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br>
    <!-- variantion 4 -->

    <h2 class="text-center">Variation 4</h2>
    <header class="header">
        <!-- header info-bar of the page -->
        <div class="info-bar">
            <div class="row justify-content-between">
                <div class="col-lg-4">
                    <div class="funnels-info">
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
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="client-setting">
                        <div class="client-setting__button">
                            <ul class="actions-button">
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
                                <li class="actions-button__list">
                                    <button class="button button-secondary">Save</button>
                                </li>
                            </ul>
                        </div>
                        <div class="client-setting__profile">
                            <div class="account-setting">
                                <div class="account-setting__info">
                                    <div class="user-info">
                                        <div class="user-image no-image">AP</div>
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
                                        <a href="#" class="settings__dropdown__link">
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
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br>
    <!-- variantion 5 -->
    <h2 class="text-center">Variation 5</h2>
    <header class="header">
        <!-- header info-bar of the page -->
        <div class="info-bar">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <div class="funnels-info">
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
                                                    <option value="0" selected>Doesn't have ANY of these tags</option>
                                                    <option value="1">Doesn't have ALL of these tags</option>
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
                                                    <select class="custom-search" multiple="multiple">
                                                        <option value="al">Alabama</option>
                                                        <option value="wy">Wyoming</option>
                                                    </select>
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
                                                    <span class="funnel-name">203K Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">kw-feliz-mm-quote.secure-clix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Refinance</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">mortgage.leadpops.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">network.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">kw-feliz-mm-quote.secure-clix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">203K Refinance</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">mortgage.leadpops.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Hybrid</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">network.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="funnel-name">Conventional Purchase</span>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <a href="#" class="funnel-link">tutorial-funnelssz.itclix.com</a>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <ul class="tags-list">
                                                        <li><span>First tag</span></li>
                                                        <li><span>Second tag</span></li>
                                                        <li><span>A bit longer tag</span></li>
                                                        <li><span>Fourth tag?</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="client-setting">
                        <div class="client-setting__button">
                            <ul class="actions-button">
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_view-funnels" href="#" title="view my funnel">
                                        <span class="actions-button__icon ico-view"></span>
                                        <span class="actions-button__text">view my funnel</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="client-setting__profile">
                            <div class="account-setting">
                                <div class="account-setting__info">
                                    <div class="user-info">
                                        <div class="user-image no-image">AP</div>
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
                                        <a href="#" class="settings__dropdown__link">
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
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>




    <!-- contain main informative part of the site -->
    <main class="main">
        <div class="main-content"></div>
    </main>
</div>

<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>

