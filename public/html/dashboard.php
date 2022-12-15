<?php
    include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
    <?php
        include ("includes/sidebar-menu.php");
    ?>
    <!-- contain the main content of the page -->
    <div id="content">
        <!-- header of the page -->
        <?php
            include ("includes/header.php");
        ?>
        <!-- contain main informative part of the site -->
        <main class="main">
            <section class="main-content">
                <div class="heading-bar">
                    <div class="row">
                        <div class="col-8">
                            <div class="heading-bar__funnels">
                                <h2>Mortgage Funnels</h2>
                                <div class="heading-bar__funnels-info">
                                    <a data-lp-wistia-title="The Home Page" data-lp-wistia-key="kno9puyv5s" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                        <span class="icon ico-video"></span>
                                        Watch how to video
                                    </a>
                                </div>
                                <div class="heading-bar__funnels-info">
                                    Total Funnels: <span>118</span>
                                </div>
                                <div class="heading-bar__funnels-info">
                                    Total Leads: <span>427</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="heading-bar__sorting">
                                <span>Sort by:</span>
                                <div class="heading-bar__sorting-list">
                                    <select class="select-custom select-custom_sorting">
                                        <option value="1" selected>Creation Date</option>
                                        <option value="8">Conversion Rate</option>
                                        <option value="3">Funnel Name</option>
                                        <option value="9">Funnel Tags</option>
                                        <option value="4">Last Edit</option>
                                        <option value="5">Last Submission</option>
                                        <option value="6">Number of Leads</option>
                                        <option value="7">Number of Visitors</option>
                                    </select>
                                </div>
                                <ul class="heading-bar__sorting-links">
                                    <li class="active"><span class="icon ico-arrow-up"></span></li>
                                    <li><span class="icon ico-arrow-down"></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- funnels-block of the page -->
                <section class="funnels-block">
                    <div class="row">
                        <div class="funnels-block__column">
                            <span class="funnels-block__title">Funnel Name</span>
                        </div>
                        <div class="funnels-block__column">
                            <span class="funnels-block__title funnels-block__title_tag">Funnel Tags</span>
                        </div>
                        <div class="funnels-block__column">
                            <span class="funnels-block__title">Leads</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="funnels">
                                <div class="funnels-details">
                                    <div class="funnel-head">
                                        <div class="funnels-box">
                                        <div class="row">
                                            <div class="funnels-box__column">
                                                <span class="funnels-details__info-name funnels-box__name">203K Hybrid</span>
                                            </div>
                                            <div class="funnels-box__column">
                                                <div class="tags-holder">
                                                    <div class="tags-wrap">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags">
                                                                <li><span>203K</span></li>
                                                                <li><span>leadPops</span></li>
                                                                <li><span>Conventional</span></li>
                                                                <li><span>San Diego loans</span></li>
                                                                <li><span>California</span></li>
                                                                <li><span>92101</span></li>
                                                                <li><span>high-conversion</span></li>
                                                                <li><span>HARP</span></li>
                                                                <li><span>FHAH</span></li>
                                                                <li><span>ybrid</span></li>
                                                                <li><span>FHAH</span></li>
                                                            </ul>
                                                        </div>
                                                        <span class="more"><span class="more-tags">...</span></span>
                                                        <div class="tags-popup-wrap">
                                                            <div class="tags-popup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-box__column">
                                                <span class="funnels-box__number">142</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="funnels-details-area">
                                        <div class="funnels-details-wrap">
                                        <div class="funnels-details__content">
                                        <?php
                                            @include ("includes/dashboard-inner-menu.php");
                                        ?>
                                        <div class="funnels-details__box-wrapper">
                                            <div class="funnels-box">
                                                <div class="row">
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-details__info-name funnels-box__name funnels-box-inner__name"><span class="el-tooltip" title="203K Hybrid">203K Hybrid</span></span>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tags-holder-wrap">
                                                                    <ul class="funnels-box__tags funnels-box-inner__tags">
                                                                        <li><span>203K</span></li>
                                                                        <li><span>leadPops</span></li>
                                                                        <li><span>Conventional</span></li>
                                                                        <li><span>San Diego loans</span></li>
                                                                        <li><span>California</span></li>
                                                                        <li><span>92101</span></li>
                                                                        <li><span>high-conversion</span></li>
                                                                        <li><span>HARP</span></li>
                                                                        <li><span>FHAH</span></li>
                                                                        <li><span>ybrid</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tags">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-box__number">142</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-details__box">
                                                <div class="column">
                                                    <div class="funnel-stats">
                                                        <span class="funnel-stats__title">Funnel Stats</span>
                                                        <div class="row">
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">New <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">Total <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">14</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                    <span class="funnel-stats__box-title">Visitors <br>
Since Sunday</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                    <span class="funnel-stats__box-title">Visitors <br>
This Month</span>
                                                                    <span class="funnel-stats__box-number">5</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                    <span class="funnel-stats__box-title">Total <br>
Visitors</span>
                                                                    <span class="funnel-stats__box-number">89</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                    <span class="funnel-stats__box-title">Conversion <br>
Rate</span>
                                                                    <span class="funnel-stats__box-number">23 <sub>%</sub></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="leads-graph">
                                                        <span class="leads-graph__title">Leads by Day</span>
                                                        <div class="leads-graph__holder">
                                                            <div id="statsChart" style="height: 318px"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="funnels-details">
                                    <div class="funnel-head">
                                        <div class="funnels-box">
                                        <div class="row">
                                            <div class="funnels-box__column">
                                                <a href="#" class="tag-btn"><i class="ico ico-ban-solid"></i></a>
                                                <span class="funnels-details__info-name funnels-box__name" >203K Purchase</span>
                                            </div>
                                            <div class="funnels-box__column">
                                                <div class="tags-holder">
                                                    <div class="tags-wrap">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                        <span class="more"><span class="more-tags">...</span></span>
                                                        <div class="tags-popup-wrap">
                                                            <div class="tags-popup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-box__column">
                                                <span class="funnels-box__number">96</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="funnels-details-area">
                                        <div class="funnels-details-wrap">
                                        <div class="funnels-details__content">
                                        <?php
                                        @include ("includes/dashboard-inner-menu.php");
                                        ?>
                                        <div class="funnels-details__box-wrapper">
                                            <div class="funnels-box">
                                                <div class="row">
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-details__info-name funnels-box__name funnels-box-inner__name"><span class="el-tooltip" title="203K Purchase"></span>203K Purchase</span>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tags-holder-wrap">
                                                                    <ul class="funnels-box__tags funnels-box-inner__tags">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tags">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-box__number">96</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-details__box">
                                                <div class="column">
                                                    <div class="funnel-stats">
                                                        <span class="funnel-stats__title">Funnel Stats</span>
                                                        <div class="row">
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">New <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">Total <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">14</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
Since Sunday</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
This Month</span>
                                                                    <span class="funnel-stats__box-number">5</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Total <br>
Visitors</span>
                                                                    <span class="funnel-stats__box-number">89</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Conversion <br>
Rate</span>
                                                                    <span class="funnel-stats__box-number">23 <sub>%</sub></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="leads-graph">
                                                        <span class="leads-graph__title">Leads by Day</span>
                                                        <div class="leads-graph__holder">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="funnels-details">
                                    <div class="funnel-head">
                                        <div class="funnels-box">
                                        <div class="row">
                                            <div class="funnels-box__column">
                                                <span class="funnels-details__info-name funnels-box__name" >203K Refinance</span>
                                            </div>
                                            <div class="funnels-box__column">
                                                <div class="tags-holder">
                                                    <div class="tags-wrap">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                        <span class="more"><span class="more-tags">...</span></span>
                                                        <div class="tags-popup-wrap">
                                                            <div class="tags-popup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-box__column">
                                                <span class="funnels-box__number">89</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="funnels-details-area">
                                      <div class="funnels-details-wrap">
                                        <div class="funnels-details__content">
							            <?php
							            @include ("includes/dashboard-inner-menu.php");
							            ?>
                                        <div class="funnels-details__box-wrapper">
                                            <div class="funnels-box">
                                                <div class="row">
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-details__info-name funnels-box__name funnels-box-inner__name"><span class="el-tooltip" title="203K Refinance">203K Refinance</span></span>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tags-holder-wrap">
                                                                    <ul class="funnels-box__tags funnels-box-inner__tags">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tags">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-box__number">89</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-details__box">
                                                <div class="column">
                                                    <div class="funnel-stats">
                                                        <span class="funnel-stats__title">Funnel Stats</span>
                                                        <div class="row">
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">New <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">Total <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">14</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
Since Sunday</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
This Month</span>
                                                                    <span class="funnel-stats__box-number">5</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Total <br>
Visitors</span>
                                                                    <span class="funnel-stats__box-number">89</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Conversion <br>
Rate</span>
                                                                    <span class="funnel-stats__box-number">23 <sub>%</sub></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="leads-graph">
                                                        <span class="leads-graph__title">Leads by Day</span>
                                                        <div class="leads-graph__holder">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="funnels-details">
                                    <div class="funnel-head">
                                        <div class="funnels-box">
                                        <div class="row">
                                            <div class="funnels-box__column">
                                                <span class="funnels-details__info-name funnels-box__name" >Conventional Hybrid</span>
                                            </div>
                                            <div class="funnels-box__column">
                                                <div class="tags-holder">
                                                    <div class="tags-wrap">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                        <span class="more"><span class="more-tags">...</span></span>
                                                        <div class="tags-popup-wrap">
                                                            <div class="tags-popup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-box__column">
                                                <span class="funnels-box__number">31</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="funnels-details-area">
                                        <div class="funnels-details-wrap">
                                        <div class="funnels-details__content">
							            <?php
							            @include ("includes/dashboard-inner-menu.php");
							            ?>
                                        <div class="funnels-details__box-wrapper">
                                            <div class="funnels-box">
                                                <div class="row">
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-details__info-name funnels-box__name funnels-box-inner__name"><span class="el-tooltip" title="Conventional Hybrid">Conventional Hybrid</span></span>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tags-holder-wrap">
                                                                    <ul class="funnels-box__tags funnels-box-inner__tags">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tags">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-box__number">31</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-details__box">
                                                <div class="column">
                                                    <div class="funnel-stats">
                                                        <span class="funnel-stats__title">Funnel Stats</span>
                                                        <div class="row">
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">New <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">Total <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">14</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
Since Sunday</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
This Month</span>
                                                                    <span class="funnel-stats__box-number">5</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Total <br>
Visitors</span>
                                                                    <span class="funnel-stats__box-number">89</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Conversion <br>
Rate</span>
                                                                    <span class="funnel-stats__box-number">23 <sub>%</sub></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="leads-graph">
                                                        <span class="leads-graph__title">Leads by Day</span>
                                                        <div class="leads-graph__holder">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="funnels-details">
                                    <div class="funnel-head">
                                        <div class="funnels-box">
                                        <div class="row">
                                            <div class="funnels-box__column">
                                                <span class="funnels-details__info-name funnels-box__name" >Conventional Purchase</span>
                                            </div>
                                            <div class="funnels-box__column">
                                                <div class="tags-holder">
                                                    <div class="tags-wrap">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                        <span class="more"><span class="more-tags">...</span></span>
                                                        <div class="tags-popup-wrap">
                                                            <div class="tags-popup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-box__column">
                                                <span class="funnels-box__number">25</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="funnels-details-area">
                                        <div class="funnels-details-wrap">
                                        <div class="funnels-details__content">
							            <?php
							            @include ("includes/dashboard-inner-menu.php");
							            ?>
                                        <div class="funnels-details__box-wrapper">
                                            <div class="funnels-box">
                                                <div class="row">
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-details__info-name funnels-box__name funnels-box-inner__name"><span class="el-tooltip" title="Conventional Purchase">Conventional Purchase</span></span>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tags-holder-wrap">
                                                                    <ul class="funnels-box__tags funnels-box-inner__tags">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tags">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-box__number">25</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-details__box">
                                                <div class="column">
                                                    <div class="funnel-stats">
                                                        <span class="funnel-stats__title">Funnel Stats</span>
                                                        <div class="row">
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">New <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">Total <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">14</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
Since Sunday</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
This Month</span>
                                                                    <span class="funnel-stats__box-number">5</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Total <br>
Visitors</span>
                                                                    <span class="funnel-stats__box-number">89</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Conversion <br>
Rate</span>
                                                                    <span class="funnel-stats__box-number">23 <sub>%</sub></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="leads-graph">
                                                        <span class="leads-graph__title">Leads by Day</span>
                                                        <div class="leads-graph__holder">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="funnels-details">
                                    <div class="funnel-head">
                                        <div class="funnels-box">
                                        <div class="row">
                                            <div class="funnels-box__column">
                                                <span class="funnels-details__info-name funnels-box__name" >Conventional Refinance</span>
                                            </div>
                                            <div class="funnels-box__column">
                                                <div class="tags-holder">
                                                    <div class="tags-wrap">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                        <span class="more"><span class="more-tags">...</span></span>
                                                        <div class="tags-popup-wrap">
                                                            <div class="tags-popup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-box__column">
                                                <span class="funnels-box__number">19</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="funnels-details-area">
                                     <div class="funnels-details-wrap">
                                        <div class="funnels-details__content">
							            <?php
							            @include ("includes/dashboard-inner-menu.php");
							            ?>
                                        <div class="funnels-details__box-wrapper">
                                            <div class="funnels-box">
                                                <div class="row">
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-details__info-name funnels-box__name funnels-box-inner__name"><span class="el-tooltip" title="Conventional Refinance">Conventional Refinance</span></span>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tags-holder-wrap">
                                                                    <ul class="funnels-box__tags funnels-box-inner__tags">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tags">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-box__number">19</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-details__box">
                                                <div class="column">
                                                    <div class="funnel-stats">
                                                        <span class="funnel-stats__title">Funnel Stats</span>
                                                        <div class="row">
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">New <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">Total <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">14</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
Since Sunday</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
This Month</span>
                                                                    <span class="funnel-stats__box-number">5</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Total <br>
Visitors</span>
                                                                    <span class="funnel-stats__box-number">89</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Conversion <br>
Rate</span>
                                                                    <span class="funnel-stats__box-number">23 <sub>%</sub></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="leads-graph">
                                                        <span class="leads-graph__title">Leads by Day</span>
                                                        <div class="leads-graph__holder">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="funnels-details">
                                    <div class="funnel-head">
                                        <div class="funnels-box">
                                        <div class="row">
                                            <div class="funnels-box__column">
                                                <a href="#" class="tag-btn"><i class="ico ico-ban-solid"></i></a>
                                                <span class="funnels-details__info-name funnels-box__name" >FHA Hybrid</span>
                                            </div>
                                            <div class="funnels-box__column">
                                                <div class="tags-holder">
                                                    <div class="tags-wrap">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                        <span class="more"><span class="more-tags">...</span></span>
                                                        <div class="tags-popup-wrap">
                                                            <div class="tags-popup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-box__column">
                                                <span class="funnels-box__number">12</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="funnels-details-area">
                                     <div class="funnels-details-wrap">
                                        <div class="funnels-details__content">
							            <?php
							            @include ("includes/dashboard-inner-menu.php");
							            ?>
                                        <div class="funnels-details__box-wrapper">
                                            <div class="funnels-box">
                                                <div class="row">
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-details__info-name funnels-box__name funnels-box-inner__name"><span class="el-tooltip" title="FHA Hybrid">FHA Hybrid</span></span>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tags-holder-wrap">
                                                                    <ul class="funnels-box__tags funnels-box-inner__tags">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tags">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-box__number">12</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-details__box">
                                                <div class="column">
                                                    <div class="funnel-stats">
                                                        <span class="funnel-stats__title">Funnel Stats</span>
                                                        <div class="row">
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">New <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">Total <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">14</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
Since Sunday</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
This Month</span>
                                                                    <span class="funnel-stats__box-number">5</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Total <br>
Visitors</span>
                                                                    <span class="funnel-stats__box-number">89</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Conversion <br>
Rate</span>
                                                                    <span class="funnel-stats__box-number">23 <sub>%</sub></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="leads-graph">
                                                        <span class="leads-graph__title">Leads by Day</span>
                                                        <div class="leads-graph__holder">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="funnels-details">
                                    <div class="funnel-head">
                                        <div class="funnels-box">
                                        <div class="row">
                                            <div class="funnels-box__column">
                                                <span class="funnels-details__info-name funnels-box__name" >FHA Purchase</span>
                                            </div>
                                            <div class="funnels-box__column">
                                                <div class="tags-holder">
                                                    <div class="tags-wrap">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                        <span class="more"><span class="more-tags">...</span></span>
                                                        <div class="tags-popup-wrap">
                                                            <div class="tags-popup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-box__column">
                                                <span class="funnels-box__number">9</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="funnels-details-area">
                                     <div class="funnels-details-wrap">
                                        <div class="funnels-details__content">
							            <?php
							            @include ("includes/dashboard-inner-menu.php");
							            ?>
                                        <div class="funnels-details__box-wrapper">
                                            <div class="funnels-box">
                                                <div class="row">
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-details__info-name funnels-box__name funnels-box-inner__name"><span class="el-tooltip" title="FHA Purchase">FHA Purchase</span></span>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <div class="tags-holder">
                                                            <div class="tags-wrap">
                                                                <div class="tags-holder-wrap">
                                                                    <ul class="funnels-box__tags funnels-box-inner__tags">
                                                                        <li><span>First tag</span></li>
                                                                        <li><span>Second tag</span></li>
                                                                        <li><span>A bit longer tag</span></li>
                                                                        <li><span>Fourth tag?</span></li>
                                                                    </ul>
                                                                </div>
                                                                <span class="more"><span class="more-tags">...</span></span>
                                                                <div class="tags-popup-wrap">
                                                                    <div class="tags-popup"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-box__number">9</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-details__box">
                                                <div class="column">
                                                    <div class="funnel-stats">
                                                        <span class="funnel-stats__title">Funnel Stats</span>
                                                        <div class="row">
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">New <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">Total <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">14</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
Since Sunday</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
This Month</span>
                                                                    <span class="funnel-stats__box-number">5</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Total <br>
Visitors</span>
                                                                    <span class="funnel-stats__box-number">89</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Conversion <br>
Rate</span>
                                                                    <span class="funnel-stats__box-number">23 <sub>%</sub></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="leads-graph">
                                                        <span class="leads-graph__title">Leads by Day</span>
                                                        <div class="leads-graph__holder">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="funnels-details">
                                    <div class="funnel-head">
                                        <div class="funnels-box">
                                        <div class="row">
                                            <div class="funnels-box__column">
                                                <span class="funnels-details__info-name funnels-box__name" >VA Refinance</span>
                                            </div>
                                            <div class="funnels-box__column">
                                                <div class="tags-holder">
                                                    <div class="tags-wrap">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                        <span class="more"><span class="more-tags">...</span></span>
                                                        <div class="tags-popup-wrap">
                                                            <div class="tags-popup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-box__column">
                                                <span class="funnels-box__number">7</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="funnels-details-area">
                                        <div class="funnels-details-wrap">
                                        <div class="funnels-details__content">
							            <?php
							            @include ("includes/dashboard-inner-menu.php");
							            ?>
                                        <div class="funnels-details__box-wrapper">
                                            <div class="funnels-box">
                                                <div class="row">
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-details__info-name funnels-box__name funnels-box-inner__name"><span class="el-tooltip" title="VA Refinance">VA Refinance</span></span>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags funnels-box-inner__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-box__number">7</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-details__box">
                                                <div class="column">
                                                    <div class="funnel-stats">
                                                        <span class="funnel-stats__title">Funnel Stats</span>
                                                        <div class="row">
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">New <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">Total <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">14</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
Since Sunday</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
This Month</span>
                                                                    <span class="funnel-stats__box-number">5</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Total <br>
Visitors</span>
                                                                    <span class="funnel-stats__box-number">89</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Conversion <br>
Rate</span>
                                                                    <span class="funnel-stats__box-number">23 <sub>%</sub></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="leads-graph">
                                                        <span class="leads-graph__title">Leads by Day</span>
                                                        <div class="leads-graph__holder">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="funnels-details">
                                    <div class="funnel-head">
                                        <div class="funnels-box">
                                        <div class="row">
                                            <div class="funnels-box__column">
                                                <span class="funnels-details__info-name funnels-box__name" >HARP Loans</span>
                                            </div>
                                            <div class="funnels-box__column">
                                                <div class="tags-holder">
                                                    <div class="tags-wrap">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                        <span class="more"><span class="more-tags">...</span></span>
                                                        <div class="tags-popup-wrap">
                                                            <div class="tags-popup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-box__column">
                                                <span class="funnels-box__number">2</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="funnels-details-area">
                                        <div class="funnels-details-wrap">
                                        <div class="funnels-details__content">
							            <?php
							            @include ("includes/dashboard-inner-menu.php");
							            ?>
                                        <div class="funnels-details__box-wrapper">
                                            <div class="funnels-box">
                                                <div class="row">
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-details__info-name funnels-box__name funnels-box-inner__name"><span class="el-tooltip" title="HARP Loans">HARP Loans</span></span>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <div class="tags-holder-wrap">
                                                            <ul class="funnels-box__tags funnels-box-inner__tags">
                                                                <li><span>First tag</span></li>
                                                                <li><span>Second tag</span></li>
                                                                <li><span>A bit longer tag</span></li>
                                                                <li><span>Fourth tag?</span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="funnels-box__column">
                                                        <span class="funnels-box__number">2</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnels-details__box">
                                                <div class="column">
                                                    <div class="funnel-stats">
                                                        <span class="funnel-stats__title">Funnel Stats</span>
                                                        <div class="row">
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">New <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                                    <span class="funnel-stats__box-title">Total <br> Leads</span>
                                                                    <span class="funnel-stats__box-number">14</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
Since Sunday</span>
                                                                    <span class="funnel-stats__box-number">2</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Visitors <br>
This Month</span>
                                                                    <span class="funnel-stats__box-number">5</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Total <br>
Visitors</span>
                                                                    <span class="funnel-stats__box-number">89</span>
                                                                </div>
                                                            </div>
                                                            <div class="funnel-stats__column">
                                                                <div class="funnel-stats__box">
                                                        <span class="funnel-stats__box-title">Conversion <br>
Rate</span>
                                                                    <span class="funnel-stats__box-number">23 <sub>%</sub></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="leads-graph">
                                                        <span class="leads-graph__title">Leads by Day</span>
                                                        <div class="leads-graph__holder">
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
                        </div>
                    </div>
                    <!-- pagination-block of the page -->
                    <div class="pagination-block">
                        <div class="row">
                            <div class="col-6">
                                <div class="pagination-block__box">
                                    <span>Funnels per page</span>
                                    <ul class="pagination">
                                        <li class="active"><a href="#">10</a></li>
                                        <li><a href="#">25</a></li>
                                        <li><a href="#">50</a></li>
                                        <li><a href="#">100</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="pagination-block__box justify-content-end">
                                    <span>Page</span>
                                    <ul class="pagination">
                                        <li class="active"><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>
                                        <li><a href="#">6</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </main>
        <!-- footer-copyright of the page -->
        <footer class="footer-copyright">
            <div class="row">
                <div class="col-12">
                    <img src="assets/images/footer-logo.png" alt="leadPops" title="leadPops">
                </div>
            </div>
        </footer>
    </div>

<?php
    include ('includes/video-modal.php');
    include ("includes/footer.php");
?>

