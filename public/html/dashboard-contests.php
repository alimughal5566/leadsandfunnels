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
        <main class="main dashboard-contest">
            <section class="main-content">
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <h1 class="title text-capitalize">Funnel Contests</h1>
                                </li>
                                <li class="action__item">
                                    <div class="form-group">
                                        <label for="sortby">Sort by:</label>
                                        <div class="select2js__funnel-sort-parent select2-parent">
                                            <select class="form-control select2js__funnel-sort">
                                                <option value="name">Contest Name</option>
                                                <option value="date">Contest Date</option>
                                                <option value="highest">Highest Converting Funnel</option>
                                                <option value="lowest">Lowest Converting Funnel</option>
                                                <option value="biggest">Biggest % Difference</option>
                                            </select>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <a data-lp-wistia-title="Contests / Funnel" data-lp-wistia-key="ji1qu22nfq" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                        <span class="icon ico-video"></span>
                                        Watch how to video
                                    </a>
                                </li>
                                <li class="action__item">
                                    <a href="create-contests-page.php" class="button button-primary">Create New contest</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- content of the page -->
                <div class="lp-panel lp-panel_contest-dashboard">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <div class="contest__name">MM Landing page test</div>
                            <div class="contest__tag tag-cm">completed</div>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <div class="action__list-controls">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <a class="action__link" href="#conteststatus" data-toggle="modal">
                                                <i class="ico ico-info"></i>status
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="#">
                                                <i class="ico ico-edit"></i>edit
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="#confirmContestDelete" data-toggle="modal">
                                                <i class="ico ico-cross"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="action__list-details">
                                    <ul class="action__list">
                                        <li class="action__item">
                                        <span class="contest__launch">
                                            Launched: <span class="launch__date">8/26/2019</span>
                                        </span>
                                        </li>
                                        <li class="action__item">
                                        <span class="contest__complete">
                                            Completed: <span class="complete__date">15/26/2019</span>
                                        </span>
                                        </li>
                                        <li class="action__item action__item_contest-btn-action">
                                        <span class="funnel-contest__action"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i>
                                        </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <div class="row row__a">
                                    <div class="col-6">
                                        <p class="contest__funnel-name">Funnel Version A</p>
                                        <p class="contest__funnel-version">pops28.funnel.com/to/eBM3Vi</p>
                                        <p class="contest__funnel-conversion">Conversion rate: <span class="conversion-rate">15.75%</span></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="contest__funnel-chart-wrapper">
                                            <input class="knob" data-linecap="round" data-thickness=".2" data-width="155" data-height="100" data-angleOffset="-100" data-angleArc="200" data-bgColor="#eef2f3" data-fgColor="#1dba43"  data-step=".1" value="15.75">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="row row__b">
                                    <div class="col-6">
                                        <p class="contest__funnel-name">Funnel Version B</p>
                                        <p class="contest__funnel-version">kw-feliz-mm-quote.secure-clix.com</p>
                                        <p class="contest__funnel-conversion">Conversion rate: <span class="conversion-rate gray">12.18%</span></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="contest__funnel-chart-wrapper">
                                            <input class="knob" data-linecap="round" data-thickness=".2" data-width="155" data-height="100" data-angleOffset="-100" data-angleArc="200" data-bgColor="#eef2f3" data-fgColor="#707d84"  data-step=".1" value="12.18">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__footer">
                        <div class="lp-panel__head border-0 p-0">
                            <div class="col-left">
                                    <span>
                                        Difference = <b>3.67%</b> (+/- 36.7 leads for every 1K visitors)
                                    </span>
                            </div>
                            <div class="col-right">
                                <span class="card-link toggle__note  collapsed" data-toggle="collapse" href="#toggle__note1" aria-expanded="false"></span>
                            </div>
                        </div>
                    </div>
                    <div id="toggle__note1" class="collapse toggle__note-body">
                        <div class="card-body">
                            Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit.
                            Proin efficitur sagittis lacinia.
                            Nam ut neque in ex condimentum consectetur.
                            Morbi eleifend nulla eu placerat sagittis.
                        </div>
                    </div>
                </div>
                <div class="lp-panel lp-panel_contest-dashboard">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <div class="contest__name">leadPops new homepage</div>
                            <div class="contest__tag tag-cm">completed</div>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <div class="action__list-controls">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <a class="action__link" href="#conteststatus" data-toggle="modal">
                                                <i class="ico ico-info"></i>status
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="#">
                                                <i class="ico ico-edit"></i>edit
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="#confirmContestDelete" data-toggle="modal">
                                                <i class="ico ico-cross"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="action__list-details">
                                    <ul class="action__list">
                                        <li class="action__item">
                                        <span class="contest__launch">
                                            Launched: <span class="launch__date">8/26/2019</span>
                                        </span>
                                        </li>
                                        <li class="action__item">
                                        <span class="contest__complete">
                                            Completed: <span class="complete__date">15/26/2019</span>
                                        </span>
                                        </li>
                                        <li class="action__item action__item_contest-btn-action">
                                        <span class="funnel-contest__action"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i>
                                        </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <div class="row row__a">
                                    <div class="col-6">
                                        <p class="contest__funnel-name">Funnel Version A</p>
                                        <p class="contest__funnel-version">mortgage.leadpops.com</p>
                                        <p class="contest__funnel-conversion">Conversion rate: <span class="conversion-rate gray">18.01%</span></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="contest__funnel-chart-wrapper">
                                            <input class="knob" data-linecap="round" data-thickness=".2" data-width="155" data-height="100" data-angleOffset="-100" data-angleArc="200" data-bgColor="#eef2f3" data-fgColor="#707d84"  data-step=".1" value="18.01">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="row row__b">
                                    <div class="col-6">
                                        <p class="contest__funnel-name">Funnel Version B</p>
                                        <p class="contest__funnel-version">beta-mortgage.leadpops.com</p>
                                        <p class="contest__funnel-conversion">Conversion rate: <span class="conversion-rate">36.17%</span></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="contest__funnel-chart-wrapper">
                                            <input class="knob" data-linecap="round" data-thickness=".2" data-width="155" data-height="100" data-angleOffset="-100" data-angleArc="200" data-bgColor="#eef2f3" data-fgColor="#1dba43"  data-step=".1" value="36.17">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__footer">
                        <div class="lp-panel__head border-0 p-0">
                            <div class="col-left">
                                    <span>
                                        Difference = <b>3.67%</b> (+/- 36.7 leads for every 1K visitors)
                                    </span>
                            </div>
                            <div class="col-right">
                                <span class="card-link toggle__note  collapsed" data-toggle="collapse" href="#toggle__note2" aria-expanded="false"></span>
                            </div>
                        </div>
                    </div>
                    <div id="toggle__note2" class="collapse toggle__note-body">
                        <div class="card-body">
                            Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit.
                            Proin efficitur sagittis lacinia.
                            Nam ut neque in ex condimentum consectetur.
                            Morbi eleifend nulla eu placerat sagittis.
                        </div>
                    </div>
                </div>
                <div class="lp-panel lp-panel_contest-dashboard">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <div class="contest__name">Fairway conversion test</div>
                            <div class="contest__tag tag-cn">cancelled</div>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <div class="action__list-controls">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <a class="action__link" href="#conteststatus" data-toggle="modal">
                                                <i class="ico ico-info"></i>status
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="#">
                                                <i class="ico ico-edit"></i>edit
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="#confirmContestDelete" data-toggle="modal">
                                                <i class="ico ico-cross"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="action__list-details">
                                    <ul class="action__list">
                                        <li class="action__item">
                                        <span class="contest__launch">
                                            Launched: <span class="launch__date">8/26/2019</span>
                                        </span>
                                        </li>
                                        <li class="action__item">
                                        <span class="contest__complete">
                                            Completed: <span class="complete__date">15/26/2019</span>
                                        </span>
                                        </li>
                                        <li class="action__item action__item_contest-btn-action">
                                        <span class="funnel-contest__action"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i>
                                        </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <div class="row row__a">
                                    <div class="col-6">
                                        <p class="contest__funnel-name">Funnel Version A</p>
                                        <p class="contest__funnel-version">www.fairway.com</p>
                                        <p class="contest__funnel-conversion">Conversion rate: <span class="conversion-rate gray">N/A</span></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="contest__funnel-chart-wrapper">
                                            <input class="knob" data-linecap="round" data-thickness=".2" data-width="155" data-height="100" data-angleOffset="-100" data-angleArc="200" data-bgColor="#eef2f3" data-fgColor="#c9d2d6"  data-step=".1" value="N/A">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="row row__b">
                                    <div class="col-6">
                                        <p class="contest__funnel-name">Funnel Version B</p>
                                        <p class="contest__funnel-version">fairway.com/test/conversionrate</p>
                                        <p class="contest__funnel-conversion">Conversion rate: <span class="conversion-rate gray">N/A</span></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="contest__funnel-chart-wrapper">
                                            <input class="knob" data-linecap="round" data-thickness=".2" data-width="155" data-height="100" data-angleOffset="-100" data-angleArc="200" data-bgColor="#eef2f3" data-fgColor="#c9d2d6"  data-step=".1" value="N/A">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__footer">
                        <div class="lp-panel__head border-0 p-0">
                            <div class="col-left">
                                    <span>
                                        Difference = <b>3.67%</b> (+/- 36.7 leads for every 1K visitors)
                                    </span>
                            </div>
                            <div class="col-right">
                                <span class="card-link toggle__note  collapsed" data-toggle="collapse" href="#toggle__note3" aria-expanded="false"></span>
                            </div>
                        </div>
                    </div>
                    <div id="toggle__note3" class="collapse toggle__note-body">
                        <div class="card-body">
                            Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit.
                            Proin efficitur sagittis lacinia.
                            Nam ut neque in ex condimentum consectetur.
                            Morbi eleifend nulla eu placerat sagittis.
                        </div>
                    </div>
                </div>
                <div class="lp-panel lp-panel_contest-dashboard">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <div class="contest__name">MM Landing page test</div>
                            <div class="contest__tag tag-cm">completed</div>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <div class="action__list-controls">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <a class="action__link" href="#conteststatus" data-toggle="modal">
                                                <i class="ico ico-info"></i>status
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="#">
                                                <i class="ico ico-edit"></i>edit
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="#confirmContestDelete" data-toggle="modal">
                                                <i class="ico ico-cross"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="action__list-details">
                                    <ul class="action__list">
                                        <li class="action__item">
                                        <span class="contest__launch">
                                            Launched: <span class="launch__date">8/26/2019</span>
                                        </span>
                                        </li>
                                        <li class="action__item">
                                        <span class="contest__complete">
                                            Completed: <span class="complete__date">15/26/2019</span>
                                        </span>
                                        </li>
                                        <li class="action__item action__item_contest-btn-action">
                                        <span class="funnel-contest__action"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i>
                                        </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <div class="row row__a">
                                    <div class="col-6">
                                        <p class="contest__funnel-name">Funnel Version A</p>
                                        <p class="contest__funnel-version">pops28.funnel.com/to/eBM3Vi</p>
                                        <p class="contest__funnel-conversion">Conversion rate: <span class="conversion-rate">15.75%</span></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="contest__funnel-chart-wrapper">
                                            <input class="knob" data-linecap="round" data-thickness=".2" data-width="155" data-height="100" data-angleOffset="-100" data-angleArc="200" data-bgColor="#eef2f3" data-fgColor="#1dba43"  data-step=".1" value="15.75">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="row row__b">
                                    <div class="col-6">
                                        <p class="contest__funnel-name">Funnel Version B</p>
                                        <p class="contest__funnel-version">kw-feliz-mm-quote.secure-clix.com</p>
                                        <p class="contest__funnel-conversion">Conversion rate: <span class="conversion-rate gray">12.18%</span></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="contest__funnel-chart-wrapper">
                                            <input class="knob" data-linecap="round" data-thickness=".2" data-width="155" data-height="100" data-angleOffset="-100" data-angleArc="200" data-bgColor="#eef2f3" data-fgColor="#707d84"  data-step=".1" value="12.18">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__footer">
                        <div class="lp-panel__head border-0 p-0">
                            <div class="col-left">
                                    <span>
                                        Difference = <b>3.67%</b> (+/- 36.7 leads for every 1K visitors)
                                    </span>
                            </div>
                            <div class="col-right">
                                <span class="card-link toggle__note  collapsed" data-toggle="collapse" href="#toggle__note1" aria-expanded="false"></span>
                            </div>
                        </div>
                    </div>
                    <div id="toggle__note1" class="collapse toggle__note-body">
                        <div class="card-body">
                            Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit.
                            Proin efficitur sagittis lacinia.
                            Nam ut neque in ex condimentum consectetur.
                            Morbi eleifend nulla eu placerat sagittis.
                        </div>
                    </div>
                </div>
                <div class="lp-panel lp-panel_contest-dashboard">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <div class="contest__name">leadPops new homepage</div>
                            <div class="contest__tag tag-cm">completed</div>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <div class="action__list-controls">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <a class="action__link" href="#conteststatus" data-toggle="modal">
                                                <i class="ico ico-info"></i>status
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="#">
                                                <i class="ico ico-edit"></i>edit
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="#confirmContestDelete" data-toggle="modal">
                                                <i class="ico ico-cross"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="action__list-details">
                                    <ul class="action__list">
                                        <li class="action__item">
                                        <span class="contest__launch">
                                            Launched: <span class="launch__date">8/26/2019</span>
                                        </span>
                                        </li>
                                        <li class="action__item">
                                        <span class="contest__complete">
                                            Completed: <span class="complete__date">15/26/2019</span>
                                        </span>
                                        </li>
                                        <li class="action__item action__item_contest-btn-action">
                                        <span class="funnel-contest__action"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i>
                                        </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <div class="row row__a">
                                    <div class="col-6">
                                        <p class="contest__funnel-name">Funnel Version A</p>
                                        <p class="contest__funnel-version">mortgage.leadpops.com</p>
                                        <p class="contest__funnel-conversion">Conversion rate: <span class="conversion-rate gray">18.01%</span></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="contest__funnel-chart-wrapper">
                                            <input class="knob" data-linecap="round" data-thickness=".2" data-width="155" data-height="100" data-angleOffset="-100" data-angleArc="200" data-bgColor="#eef2f3" data-fgColor="#707d84"  data-step=".1" value="18.01">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="row row__b">
                                    <div class="col-6">
                                        <p class="contest__funnel-name">Funnel Version B</p>
                                        <p class="contest__funnel-version">beta-mortgage.leadpops.com</p>
                                        <p class="contest__funnel-conversion">Conversion rate: <span class="conversion-rate">36.17%</span></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="contest__funnel-chart-wrapper">
                                            <input class="knob" data-linecap="round" data-thickness=".2" data-width="155" data-height="100" data-angleOffset="-100" data-angleArc="200" data-bgColor="#eef2f3" data-fgColor="#1dba43"  data-step=".1" value="36.17">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__footer">
                        <div class="lp-panel__head border-0 p-0">
                            <div class="col-left">
                                    <span>
                                        Difference = <b>3.67%</b> (+/- 36.7 leads for every 1K visitors)
                                    </span>
                            </div>
                            <div class="col-right">
                                <span class="card-link toggle__note  collapsed" data-toggle="collapse" href="#toggle__note2" aria-expanded="false"></span>
                            </div>
                        </div>
                    </div>
                    <div id="toggle__note2" class="collapse toggle__note-body">
                        <div class="card-body">
                            Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit.
                            Proin efficitur sagittis lacinia.
                            Nam ut neque in ex condimentum consectetur.
                            Morbi eleifend nulla eu placerat sagittis.
                        </div>
                    </div>
                </div>
                <div class="col__wrapper contest-pagination">
                    <div class="col-left contest-per-page">
                        <span class="pagination-label">Contests per page</span>
                        <ul class="action__list">
                            <li class="action__item">
                                <a class="action__link active" href="javascript:void(0)">5</a>
                            </li>
                            <li class="action__item">
                                <a class="action__link" href="javascript:void(0)">10</a>
                            </li>
                            <li class="action__item">
                                <a class="action__link" href="javascript:void(0)">25</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-right">
                        <span class="pagination-label">Page</span>
                        <ul class="action__list contest-page">
                            <li class="action__item">
                                <a class="action__link active" href="javascript:void(0)">1</a>
                            </li>
                            <li class="action__item">
                                <a class="action__link" href="javascript:void(0)">2</a>
                            </li>
                            <li class="action__item">
                                <a class="action__link" href="javascript:void(0)">3</a>
                            </li>
                            <li class="action__item">
                                <a class="action__link" href="javascript:void(0)">4</a>
                            </li>
                            <li class="action__item">
                                <a class="action__link" href="javascript:void(0)">5</a>
                            </li>
                            <li class="action__item">
                                <a class="action__link" href="javascript:void(0)">6</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- footer of the page -->
                <div class="footer">
                    <div class="row">
                        <img src="assets/images/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="modal fade" id="conteststatus">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Contest Status</h3>
                </div>
                <div class="modal-body py-0">
                    <div class="contest__status-wrapper">
                        <label>Select contest status:</label>
                        <div class="btn-group">
                            <button type="button" class="button button-status dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="contest__tag tag-cm">completed</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu_status">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <span class="contest__tag tag-lv">Live</span>
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <span class="contest__tag tag-cm">completed</span>
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <span class="contest__tag tag-ps">paused</span>
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <span class="contest__tag tag-cn">cancelled</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Cancel</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary">Save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="confirmContestDelete" class="modal fade lp-modal-box in">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title">Confirmation</h3>
                </div>
                <div class="modal-body model-action-body">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-sm-12 modal-action-msg-wrap">
                                <div id="notification_contestDelete" class="modal-msg mb-0">
                                    Do you want to delete Contest?
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer lp-modal-action-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel btnCancel_confirmPixelDelete" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary btnAction_confirmPixelDelete">Delete</button>
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
