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
            <section class="main-content">
                <!-- Title wrap of the page -->
                <div class="main-content__head main-content__head_tabs">
                    <div class="col-left">
                        <h1 class="title">
                            New Contests / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <a href="create-contests-page.php" class="back-link"><span class="icon icon-back ico-caret-up"></span> Back to Contests</a>
                        <div class="tab__wrapper">
                            <ul class="nav nav__tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="basictab" data-toggle="pill" href="#tbBasicSetup">Basic Setup</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="finalizetab" data-toggle="pill" href="#tbFinalize">Finalize</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
                <div class="tab-content">
                    <div id="tbBasicSetup" class="tab-pane active">
                        <div class="lp-panel lp-panel_contest">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Basic Details
                                    </h2>
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <div class="form-group">
                                    <label for="contest_name">Contest Name</label>
                                    <div class="input__wrapper">
                                        <input id="contest_name" name="contest_name" class="form-control" placeholder="MM landing page test" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel__footer">
                                <div class="form-group">
                                    <label for="funnel-version-a">Funnel Version A</label>
                                    <div class="input__wrapper">
                                        <div class="input-holder input-holder_icon flex-grow-1">
                                            <span class="ico-lock"></span>
                                            <div id="funnel-version-a" class="form-control border-0 pl-5">
                                                http://pops28.funnel.com/to/eBM3Vi
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0 mt-4 pt-1">
                                    <label for="funnel-version-b">Funnel Version B</label>
                                    <div class="input__wrapper">
                                        <div class="select2__funnel-version-parent select2-parent">
                                            <select name="funnel-version-b" class="form-control select2__funnel-version">
                                                <option value="a">Select Funnel</option>
                                                <option value="a">Select Funnel A</option>
                                                <option value="b">Select Funnel B</option>
                                                <option value="c">Select Funnel C</option>
                                                <option value="d">Select Funnel D</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <div class="row">
                                <button type="submit" id="next-step" class="button button-secondary">Next step</button>
                            </div>
                            <div class="row">
                                <img src="assets/images/footer-logo.png" alt="footer logo">
                            </div>
                        </div>
                    </div>
                    <div id="tbFinalize" class="tab-pane">
                        <div class="lp-panel lp-panel_contest">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Scheduling
                                    </h2>
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <div class="form-group">
                                    <label for="contest_name">Start at</label>
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item action__item_c-name">
                                                <div class="input__wrapper">
                                                    <div class="has__icon has__icon_right">
                                                        <input id="popstartdatepicker" value="03/25/2020" class="form-control" type="text">
                                                        <label for="popstartdatepicker" class="ico ico-calander"></label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="action__item action__item_hours">
                                                <div class="select2__str-hours-parent select2-parent select2js__nice-scroll">
                                                    <select class="form-control select2__str-hours">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="action__item action__item_min">
                                                <div class="select2__str-min-parent select2-parent select2js__nice-scroll">
                                                    <select class="select2__str-min">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="action__item action__item_timezone">
                                                <div class="select2__str-timezone-parent select2-parent">
                                                    <select class="form-control select2__str-timezone">
                                                        <option value="cst">CST</option>
                                                        <option value="est">EST</option>
                                                        <option value="hst">HST</option>
                                                        <option value="mst">MST</option>
                                                        <option value="pst">PST</option>
                                                    </select>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group m-0">
                                    <label for="funnel-version-a">End at</label>
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item action__item_dt-picker">
                                                <div class="select2__datetime-parent select2-parent">
                                                    <select class="form-control select2__datetime">
                                                        <option>Date & Time</option>
                                                        <option>Total Number of Visitors</option>
                                                        <option>Total Number of Leads</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="action__item action__item_dt">
                                                <div class="input__wrapper">
                                                    <div class="has__icon has__icon_right">
                                                        <input id="popenddatepicker" value="03/25/2020" class="form-control" type="text">
                                                        <label for="popenddatepicker" class="ico ico-calander"></label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="action__item action__item_hours">
                                                <div class="select2__end-hours-parent select2-parent select2js__nice-scroll">
                                                    <select class="form-control select2__end-hours">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="action__item action__item_min">
                                                <div class="select2__end-min-parent select2-parent select2js__nice-scroll">
                                                    <select class="select2__end-min">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="action__item action__item_timezone">
                                                <div class="select2__end-timezone-parent select2-parent">
                                                    <select class="form-control select2__end-timezone">
                                                        <option value="cst">CST</option>
                                                        <option value="est">EST</option>
                                                        <option value="hst">HST</option>
                                                        <option value="mst">MST</option>
                                                        <option value="pst">PST</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="action__item action__item_expand">
                                                <span class="total_num expand-or el-tooltip" title="Click expand">
                                                    <span class="ico ico-plus"></span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="scheduling-expand">
                                    <div class="form-group m-0">
                                        <label for="funnel-version-a">OR</label>
                                        <div class="action">
                                            <ul class="action__list">
                                                <li class="action__item action__item_nf-visitor">
                                                    <div class="select2__datetime-or-parent select2-parent">
                                                        <select class="form-control select2__datetime-or">
                                                            <option>Total Number of Visitors</option>
                                                            <option>Total Number of Leads</option>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="action__item action__item_nf-input">
                                                    <div class="input__wrapper">
                                                        <input id="contest_name" name="contest_name" class="form-control" type="text">
                                                    </div>
                                                </li>
                                                <li class="action__item action__item_expand">
                                                <span class="total_num collapse-or el-tooltip" title="Click close">
                                                    <span class="ico ico-cross"></span>
                                                </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel py-0">
                            <div class="card-header">
                                <div class="lp-panel__head border-0 p-0">
                                    <div class="col-left">
                                        <h2 class="card-title">
                                            <span>Contest Notes</span>
                                        </h2>
                                    </div>
                                    <div class="col-right">
                                        <div class="action">
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <div class="card-link collapsed add__note"  data-toggle="collapse" href="#addnote"></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="addnote" class="collapse" >
                                <div class="card-body">
                                    <textarea class="text-area">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin efficitur sagittis lacinia. Nam ut neque in ex condimentum consectetur. Morbi eleifend nulla eu placerat sagittis. </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <div class="row">
                                <a href="dashboard-contests.php" class="button button-secondary">run the contest</a>
                            </div>
                            <div class="row">
                                <img src="assets/images/footer-logo.png" alt="footer logo">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="modal fade" id="startdatemodal">
        <div class="modal-dialog modal-datepicker__dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Select Date</h3>
                </div>
                <div class="modal-body p-0 dd-parent dd-start-parent">

                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary" data-dismiss="modal">Select</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="enddatemodal">
        <div class="modal-dialog modal-datepicker__dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Select Date</h3>
                </div>
                <div class="modal-body p-0 dd-parent dd-end-parent">

                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary" data-dismiss="modal">Select</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="selectfunnel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Select Funnel</h3>
                </div>
                <div class="modal-body pt-2 ">
                    <div class="funnel__wrapper">
                        <div class="input__wrapper modal__funnel-search">
                            <input class="form-control search-bar" placeholder="Search for desired funnel ..." type="text">
                        </div>
                        <ul class="funnel__list">
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> combomortgagejbx.clixonit.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName" checked>
                                        <span class="label-text"><i class="icon"></i> sebonic-financial-purchase.secure-clix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> tutorial-funnelssz.itclix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> tutorial-funnelssz.itclix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> tutorial-funnelssz.itclix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> tutorial-funnelssz.itclix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> kw-los-feliz-mm-quote.secure-clix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> network.itclix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> combomortgagejbx.clixonit.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> sebonic-financial-purchase.secure-clix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> tutorial-funnelssz.itclix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> kw-los-feliz-mm-quote.secure-clix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> network.itclix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> combomortgagejbx.clixonit.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> sebonic-financial-purchase.secure-clix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> tutorial-funnelssz.itclix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> kw-los-feliz-mm-quote.secure-clix.com</span>
                                    </label>
                                </div>
                            </li>
                            <li class="funnel__item">
                                <div class="checkbox">
                                    <label class="funnel-label">
                                        <input type="checkbox" name="funnelName">
                                        <span class="label-text"><i class="icon"></i> network.itclix.com</span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary">Finish</button>
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
