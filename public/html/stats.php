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
            <section class="main-content">

                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                Statistics / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Stats" data-lp-wistia-key="d3fj9pnvmv" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span> Watch how to video</a>
                        </div>
                    </div>
                    <!-- content of the page -->

                    <div class="lp-panel">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Funnel Stats
                                </h2>
                            </div>
                            <div class="col-right">
                                <div class="action">
                                    <ul class="action__list">
                                        <li class="action__item">
                                                <button class="button button-primary ip-block" data-toggle="modal" data-target="#ip-block">block ip</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="filter-wrapper">
                                <input type="hidden" name="startDate" id="startDate">
                                <input type="hidden" name="endDate" id="endDate">
                                <input type="hidden" name="clicked_by" id="clicked_by" value="U2ya1m0zycNVNA6HJd8KN1a6sxirBcHeL00lY/PB8nY=">
                                <div class="data-type">
                                    <label for="device_type">Device Type</label>
                                    <div class="select2__device-type-parent">
                                        <select class="select2__device-type" name="device_type">
                                            <option value="total">All</option>
                                            <option value="desktop">Desktop</option>
                                            <option value="mobile">Mobile</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="data-range">
                                    <span class="qa-select-menu">
                                        <label>Date Range</label>
                                        <div class="dropdown qa-dd qa-dropdown dropdown-toggle lp-date-range" id="reportrange"  role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="firstLabel qaLabel stats-data-range"><span class="qaText"><span>All Time</span></span> <span class="caret"></span></span>
                                            <input type="hidden" name="qa-dropdown">
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="lead__wrapper">
                                <div class="lead__box">
                                    <span class="lead__title">
                                        New Leads
                                    </span>
                                    <span class="lead__count">1</span>
                                </div>
                                <div class="lead__box">
                                    <span class="lead__title">
                                        Total Leads
                                    </span>
                                    <span class="lead__count">1</span>
                                </div>
                                <div class="lead__box">
                                    <span class="lead__title">
                                        Visitors Since Sunday
                                    </span>
                                    <span class="lead__count">2</span>
                                </div>
                                <div class="lead__box">
                                    <span class="lead__title">
                                        Visitors This Month
                                    </span>
                                    <span class="lead__count">2</span>
                                </div>
                                <div class="lead__box">
                                    <span class="lead__title">
                                        Total Visitors
                                    </span>
                                    <span class="lead__count">5</span>
                                </div>
                                <div class="lead__box">
                                    <span class="lead__title">
                                        Conversion Rate
                                    </span>
                                    <span class="lead__count">20<span class="lead__unit">%</span></span>
                                </div>
                            </div>
                            <div class="chart__wrapper">
                                <div class="filter__wrapper">
                                    <div class="filter__col filter__col-left">
                                        <h2 class="filter__title">Performance Metrics</h2>
                                    </div>
                                    <div class="filter__col filter__col-right">
                                        <label class="filter__label" for="chart_title">Display</label>
                                        <div class="select2__datatype-parent">
                                            <select class="select2__datatype" name="chart_title" id="chart_title">
                                                <option value="conversion">Conversion Rate</option>
                                                <option value="leads">Leads</option>
                                                <option value="visits">Visits</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
<!--                                <canvas id="myChart" class="graph" width="400" height="200"></canvas>-->
                                <div id="myhighchart"></div>
                            </div>
                        </div>
                    </div>


                    <!-- content of the page -->
                    <!-- footer of the page -->
                    <div class="footer">
                        <div class="row">
                            <img src="assets/images/footer-logo.png" alt="footer logo">
                        </div>
                    </div>
            </section>
        </main>
    </div>
    <input type="hidden" name="startDate" id="startDate">
    <input type="hidden" name="endDate" id="endDate">

    <!--************IP Block POPUP************-->
    <div class="modal fade add_recipient block-ip" id="ip-block">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Block IP
                        <span class="fb-tooltip">
                            <span class="question-mark question-mark_modal el-tooltip" title="Lorem Ipsum">?</span>
                        </span>
                    </h3>
                    <a data-lp-wistia-title="Stats" data-lp-wistia-key="d3fj9pnvmv" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                        <span class="icon ico-video"></span> Watch how to video</a>
                </div>
                <div class="modal-body pb-0">
                    <form action="" method="post" id="add-code-popup" class="form-pop ip-block-form">
                        <input type="hidden"  name="funnel_hash" class="form-control google-control" id="funnel_hash">
                        <input type="hidden"  name="ip_action" class="form-control google-control" id="ip_action" value="add">
                        <input type="hidden"  name="ip_id" class="form-control google-control" id="ip_id" value="">
                        <div class="add-ip w-100">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group lp-group">
                                        <div class="row align-items-center w-100">
                                            <div class="col-sm-4">
                                                <label class="control-label control-label justify-content-start" for="ip_name">Name of IP</label>
                                            </div>
                                            <div class="col-sm-8 input__holder p-0">
                                                <input type="text"  name="ip_name" class="form-control google-control" id="ip_name" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group lp-group">
                                        <div class="row align-items-center w-100">
                                            <div class="col-sm-4">
                                                <label class="control-label control-label justify-content-start" for="ip_address">IP Address</label>
                                            </div>
                                            <div class="col-sm-8 input__holder p-0">
                                                <input type="text"  name="ip_address" class="form-control google-control" id="ip_address" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-wrapper">
                                        <input type="submit" class="button button-primary block_ip_cta" value ="Block IP">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col">
                                    <h2 class="head-list">List of Blocked IPs</h2>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="lp-table w-100">
                        <div class="lp-table__head">
                            <ul class="lp-table__list">
                                <li class="lp-table__item">IP Name</li>
                                <li class="lp-table__item">IP Address</li>
                                <li class="lp-table__item">Options</li>
                            </ul>
                        </div>
                        <div class="lp-table__body">
                            <div class="message-block">(You're not currently blocking any IPs)</div>
                            <div class="mcustom__scroll">
                                <div class="lp-table-item">
                                    <ul class="lp-table__list">
                                        <li class="lp-table__item">Harvard University</li>
                                        <li class="lp-table__item">www.hsph.harvard.edu</li>
                                        <li class="lp-table__item">
                                            <div class="action action_options">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <a href="#" class="action__link edit-recipient"
                                                           data-id="158673" data-name="" data-email="john@mortgage.com" data-cell="(618) 886 - 6984"
                                                           data-carrier="messaging.sprintpcs.com" data-text="Edit">
                                                            <span class="ico ico-edit"></span>edit
                                                        </a>
                                                    </li>
                                                    <li class="action__item">
                                                        <a href="#" class="action__link remove-recipient">
                                                            <span class="ico ico-cross"></span>delete
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="lp-table__item-msg">
                                        <div class="lp-table__item-confirmation">
                                            <p>Are you sure you want to remove this IP?</p>
                                            <ul class="control">
                                                <li class="control__item">
                                                    <a href="javascript:void();" class="lp-table_yes">Yes</a>
                                                </li>
                                                <li class="control__item">
                                                    <a href="javascript:void();" class="lp-table_no">No</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-table-item">
                                    <ul class="lp-table__list ">
                                        <li class="lp-table__item">US Major IP Block</li>
                                        <li class="lp-table__item">13.111.255.255 </li>
                                        <li class="lp-table__item">
                                            <div class="action action_options">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <a href="#" class="action__link edit-recipient"
                                                           data-id="158673" data-name="" data-email="john@mortgage.com" data-cell="(618) 886 - 6984"
                                                           data-carrier="messaging.sprintpcs.com" data-text="Edit">
                                                            <span class="ico ico-edit"></span>edit
                                                        </a>
                                                    </li>
                                                    <li class="action__item">
                                                        <a href="#" class="action__link remove-recipient">
                                                            <span class="ico ico-cross"></span>delete
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="lp-table__item-msg">
                                        <div class="lp-table__item-confirmation">
                                            <p>Are you sure you want to remove this IP?</p>
                                            <ul class="control">
                                                <li class="control__item">
                                                    <a href="javascript:void();" class="lp-table_yes">Yes</a>
                                                </li>
                                                <li class="control__item">
                                                    <a href="javascript:void();" class="lp-table_no">No</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-table-item">
                                    <ul class="lp-table__list ">
                                        <li class="lp-table__item">Harvard University</li>
                                        <li class="lp-table__item">www.hsph.harvard.edu</li>
                                        <li class="lp-table__item">
                                            <div class="action action_options">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <a href="#" class="action__link edit-recipient"
                                                           data-id="158673" data-name="" data-email="john@mortgage.com" data-cell="(618) 886 - 6984"
                                                           data-carrier="messaging.sprintpcs.com" data-text="Edit">
                                                            <span class="ico ico-edit"></span>edit
                                                        </a>
                                                    </li>
                                                    <li class="action__item">
                                                        <a href="#" class="action__link remove-recipient">
                                                            <span class="ico ico-cross"></span>delete
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="lp-table__item-msg">
                                        <div class="lp-table__item-confirmation">
                                            <p>Are you sure you want to remove this IP?</p>
                                            <ul class="control">
                                                <li class="control__item">
                                                    <a href="javascript:void();" class="lp-table_yes">Yes</a>
                                                </li>
                                                <li class="control__item">
                                                    <a href="javascript:void();" class="lp-table_no">No</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-table-item">
                                    <ul class="lp-table__list ">
                                        <li class="lp-table__item">Marketing Spam</li>
                                        <li class="lp-table__item">168.212.226.204</li>
                                        <li class="lp-table__item">
                                            <div class="action action_options">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <a href="#" class="action__link edit-recipient"
                                                           data-id="158673" data-name="" data-email="john@mortgage.com" data-cell="(618) 886 - 6984"
                                                           data-carrier="messaging.sprintpcs.com" data-text="Edit">
                                                            <span class="ico ico-edit"></span>edit
                                                        </a>
                                                    </li>
                                                    <li class="action__item">
                                                        <a href="#" class="action__link remove-recipient">
                                                            <span class="ico ico-cross"></span>delete
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="lp-table__item-msg">
                                        <div class="lp-table__item-confirmation">
                                            <p>Are you sure you want to remove this IP?</p>
                                            <ul class="control">
                                                <li class="control__item">
                                                    <a href="javascript:void();" class="lp-table_yes">Yes</a>
                                                </li>
                                                <li class="control__item">
                                                    <a href="javascript:void();" class="lp-table_no">No</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lead-alert-section lead-alert d-none">
                        <div class="ref-title">
                            List of Blocked IPs
                        </div>
                        <div class="blocked-list mCustomScrollbar">
                            <div class="lead-alert-col ip-block-col">
                                <div class="row">
                                    <div class="col-sm-4"><h3 class="lead-alert-caption lead-alert-email-address">IP Name</h3></div>
                                    <div class="col-sm-4"><h3 class="lead-alert-caption lead-alert-cell" >IP Address</h3></div>
                                    <div class="col-sm-4"><h3 class="lead-alert-caption lead-alert-option">Options</h3></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-cancel lp-btn-cancel ip-btn" data-dismiss="modal">Cancel</button>
                                </li>
                                <li class="action__item">
                                    <button type="submit" class="button button-primary">Save</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>