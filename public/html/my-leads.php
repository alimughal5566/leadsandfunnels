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

                <form id="add-seo"  method="post">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                My Leads / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="My Leads" data-lp-wistia-key="31uskalsne" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="lp-panel">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title el-tooltip" data-toggle="tooltip" data-container="#avllead" data-html="true" data-original-title="<p>This is the total number of leads available (below). Deleted leads are not included.</p>">
                                    Available Leads: <span id="avllead" class="lead-counter">21</span>
                                </h2>
                                <div class="leads-data-range ml-5">
                                    <span class="qa-select-menu">
                                        <label>Data Range</label>
                                        <div class="dropdown qa-dd qa-dropdown dropdown-toggle lp-date-range large" id="leadrange"  role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="firstLabel qaLabel">
                                                <i class="fa fa-calendar cal-size" aria-hidden="true"></i>
                                                Select Date
                                                <span class="caret"></span>
                                            </span>
                                            <input type="hidden" name="qa-dropdown">
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="lead__info">
                                    New Leads: <span class="leads__new-count">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="d-flex">
                                <input id="title__tag" placeholder="Search your leads..." name="title__tag" class="form-control" type="text">
                                <input class="button button-primary ml-4 w-auto" value="Search" type="submit">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <ul class="alpha__search">
                                        <li class="alpha__item">
                                            <span class="alpha__link">A</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">B</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">C</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">D</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">E</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">F</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">G</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">H</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">I</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">J</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">K</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">L</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">M</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">N</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">O</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">P</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">Q</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">R</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">S</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">T</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">U</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">V</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">W</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">X</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">Y</span>
                                        </li>
                                        <li class="alpha__item">
                                            <span class="alpha__link">Z</span>
                                        </li>
                                        <li class="alpha__item view-all">
                                            <span class="alpha__link">ALL</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col__wrapper lead__options">
                                <div class="col-left">
                                    <div class="lead__action">
                                        <ul class="action__list">
                                            <li class="action__item">
                                                <a href="#" class="action__link">
                                                    <span class="ico ico-ms-word"></span>export as .doc
                                                </a>
                                            </li>
                                            <li class="action__item">
                                                <a href="#" class="action__link">
                                                    <span class="ico ico-adobe-xs"></span>export excel
                                                </a>
                                            </li>
                                            <li class="action__item">
                                                <a href="#" class="action__link">
                                                    <span class="ico ico-adobe"></span>export as pdf
                                                </a>
                                            </li>
                                            <li class="action__item">
                                                <a href="#" class="action__link">
                                                    <span class="ico ico-print"></span>print
                                                </a>
                                            </li>
                                            <li class="action__item">
                                                <a href="#" class="action__link">
                                                    <span class="ico ico-email"></span>email
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-right">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <a href="#" id="delmyleads" data-toggle="modal" data-target="#deleteleads" class="action__link lead__btn-del">
                                                <span class="ico ico-cross"></span>delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col__wrapper lead-selection">
                                <div class="col-left">
                                    <div class="checkbox pl-2 ml-1">
                                        <input type="checkbox" id="selactionall" class="all-check-box" name="selactionall" value="">
                                        <label class="lead-label" for="selactionall">
                                            Select All
                                        </label>
                                    </div>
                                </div>
                                <div class="col-right">
                                    <div class="lead-sorting text-right">
                                        <span>Date</span>
                                        <a href="#" class="leadsort" data-sortvalue="desc">
                                            <i class="ico ico-caret-down"></i>
                                        </a>
                                        <a href="#" class="leadsort sort-active" data-sortvalue="asc">
                                            <i class="ico ico-caret-up"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="leads-result">
                                <div class="leads-panel">
                                    <div class="leads-panel__info">
                                        <div class="col__wrapper">
                                            <div class="col-left">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="lead1" name="lead1" value="">
                                                    <label class="lead-label" for="lead1"></label>
                                                    <a class="lead__name" data-toggle="modal" href="#single-lead-modal">Charles McDonovan</a>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <span class="lead-date">
                                                            July 08, 2019
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leads-panel__details">
                                        <ul class="action__list">
                                            <li class="action__item">(619) 886-6984</li>
                                            <li class="action__item">charles.mcdonovan@gmail.com</li>
                                            <li class="action__item">San Diego - CA - 92124</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="leads-panel new-lead">
                                    <div class="leads-panel__info">
                                        <div class="col__wrapper">
                                            <div class="col-left">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="lead2" name="lead2" value="">
                                                    <label class="lead-label" for="lead2"></label>
                                                    <a class="lead__name" href="#">Charles McDonovan</a>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <span class="lead-date">
                                                            July 08, 2019
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leads-panel__details">
                                        <ul class="action__list">
                                            <li class="action__item">(619) 886-6984</li>
                                            <li class="action__item">charles.mcdonovan@gmail.com</li>
                                            <li class="action__item">San Diego - CA - 92124</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="leads-panel new-lead">
                                    <div class="leads-panel__info">
                                        <div class="col__wrapper">
                                            <div class="col-left">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="lead3" name="lead3" value="">
                                                    <label class="lead-label" for="lead3"></label>
                                                    <a class="lead__name" href="#">Charles McDonovan</a>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <span class="lead-date">
                                                            July 08, 2019
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leads-panel__details">
                                        <ul class="action__list">
                                            <li class="action__item">(619) 886-6984</li>
                                            <li class="action__item">charles.mcdonovan@gmail.com</li>
                                            <li class="action__item">San Diego - CA - 92124</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="leads-panel">
                                    <div class="leads-panel__info">
                                        <div class="col__wrapper">
                                            <div class="col-left">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="lead4" name="lead4" value="">
                                                    <label class="lead-label" for="lead4"></label>
                                                    <a class="lead__name" href="#">Charles McDonovan</a>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <span class="lead-date">
                                                            July 08, 2019
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leads-panel__details">
                                        <ul class="action__list">
                                            <li class="action__item">(619) 886-6984</li>
                                            <li class="action__item">charles.mcdonovan@gmail.com</li>
                                            <li class="action__item">San Diego - CA - 92124</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="leads-panel">
                                    <div class="leads-panel__info">
                                        <div class="col__wrapper">
                                            <div class="col-left">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="lead5" name="lead5" value="">
                                                    <label class="lead-label" for="lead5"></label>
                                                    <a class="lead__name" href="#">Charles McDonovan</a>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <span class="lead-date">
                                                            July 08, 2019
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leads-panel__details">
                                        <ul class="action__list">
                                            <li class="action__item">(619) 886-6984</li>
                                            <li class="action__item">charles.mcdonovan@gmail.com</li>
                                            <li class="action__item">San Diego - CA - 92124</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="leads-panel">
                                    <div class="leads-panel__info">
                                        <div class="col__wrapper">
                                            <div class="col-left">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="lead6" name="lead6" value="">
                                                    <label class="lead-label" for="lead6"></label>
                                                    <a class="lead__name" href="#">Charles McDonovan</a>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <span class="lead-date">
                                                            July 08, 2019
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leads-panel__details">
                                        <ul class="action__list">
                                            <li class="action__item">(619) 886-6984</li>
                                            <li class="action__item">charles.mcdonovan@gmail.com</li>
                                            <li class="action__item">San Diego - CA - 92124</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="leads-panel">
                                    <div class="leads-panel__info">
                                        <div class="col__wrapper">
                                            <div class="col-left">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="lead7" name="lead7" value="">
                                                    <label class="lead-label" for="lead7"></label>
                                                    <a class="lead__name" href="#">Charles McDonovan</a>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <span class="lead-date">
                                                            July 08, 2019
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leads-panel__details">
                                        <ul class="action__list">
                                            <li class="action__item">(619) 886-6984</li>
                                            <li class="action__item">charles.mcdonovan@gmail.com</li>
                                            <li class="action__item">San Diego - CA - 92124</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="leads-panel">
                                    <div class="leads-panel__info">
                                        <div class="col__wrapper">
                                            <div class="col-left">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="lead8" name="lead8" value="">
                                                    <label class="lead-label" for="lead8"></label>
                                                    <a class="lead__name" href="#">Charles McDonovan</a>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <span class="lead-date">
                                                            July 08, 2019
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leads-panel__details">
                                        <ul class="action__list">
                                            <li class="action__item">(619) 886-6984</li>
                                            <li class="action__item">charles.mcdonovan@gmail.com</li>
                                            <li class="action__item">San Diego - CA - 92124</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="leads-panel">
                                    <div class="leads-panel__info">
                                        <div class="col__wrapper">
                                            <div class="col-left">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="lead9" name="lead9" value="">
                                                    <label class="lead-label" for="lead9"></label>
                                                    <a class="lead__name" href="#">Charles McDonovan</a>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <span class="lead-date">
                                                            July 08, 2019
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leads-panel__details">
                                        <ul class="action__list">
                                            <li class="action__item">(619) 886-6984</li>
                                            <li class="action__item">charles.mcdonovan@gmail.com</li>
                                            <li class="action__item">San Diego - CA - 92124</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="leads-panel">
                                    <div class="leads-panel__info">
                                        <div class="col__wrapper">
                                            <div class="col-left">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="lead10" name="lead10" value="">
                                                    <label class="lead-label" for="lead10"></label>
                                                    <a class="lead__name" href="#">Charles McDonovan</a>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <span class="lead-date">
                                                            July 08, 2019
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leads-panel__details">
                                        <ul class="action__list">
                                            <li class="action__item">(619) 886-6984</li>
                                            <li class="action__item">charles.mcdonovan@gmail.com</li>
                                            <li class="action__item">San Diego - CA - 92124</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col__wrapper lead-pagination">
                                <div class="col-left lead-per-page">
                                    <span class="pagination-label">Leads per page</span>
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <a class="action__link active" href="javascript:void(0)">10</a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="javascript:void(0)">25</a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="javascript:void(0)">50</a>
                                        </li>
                                        <li class="action__item">
                                            <a class="action__link" href="javascript:void(0)">100</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-right">
                                    <span class="pagination-label">Page</span>
                                    <ul class="action__list lead-page">
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
                        </div>
                    </div>
                    <!-- footer of the page -->
                    <div class="footer">
                        <div class="row">
                            <img src="assets/images/footer-logo.png" alt="footer logo">
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>


    <div class="modal fade" id="single-lead-modal">
        <div class="modal-dialog modal-max__dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h3 class="modal-title">Charles McDonovan</h3>
                    <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                </div>
                <div class="modal-body pt-2 quick-scroll">
                    <div class="col__wrapper lead__options border-0 p-0 h-auto">
                        <div class="col-left">
                            <div class="lead__action">
                                <ul class="action__list">
                                    <li class="action__item">
                                        <a href="#" class="action__link">
                                            <span class="ico ico-ms-word"></span>export as .doc
                                        </a>
                                    </li>
                                    <li class="action__item">
                                        <a href="#" class="action__link">
                                            <span class="ico ico-adobe-xs"></span>export excel
                                        </a>
                                    </li>
                                    <li class="action__item">
                                        <a href="#" class="action__link">
                                            <span class="ico ico-adobe"></span>export as pdf
                                        </a>
                                    </li>
                                    <li class="action__item">
                                        <a href="#" class="action__link">
                                            <span class="ico ico-print"></span>print
                                        </a>
                                    </li>
                                    <li class="action__item">
                                        <a href="#" class="action__link">
                                            <span class="ico ico-email"></span>email
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-right">
                            <ul class="action__list">
                                <li class="action__item">
                                    <a href="#deleteleads" data-toggle="modal" data-dismiss="modal" class="action__link lead__btn-del">
                                        <span class="ico ico-cross"></span>delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-lead__info">
                        <div class="lead-modal-wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="lead-modal-des">
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>First Name:</h5></div>
                                            <div class="modal-right">
                                                <h5>Charles</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Last Name:</h5></div>
                                            <div class="modal-right">
                                                <h5>McDonovan</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Phone Number:</h5></div>
                                            <div class="modal-right">
                                                <h5>(619) 886-6985</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Email Address:</h5></div>
                                            <div class="modal-right">
                                                <h5>charles.mcdonovan@mail.com</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Funnel URL:</h5></div>
                                            <div class="modal-right">
                                                <h5>combomortgagejbx.clixonit.com</h5></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="lead-modal-des-2">
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Zip Code:</h5></div>
                                            <div class="modal-right">
                                                <h5>92124-SAN DIEGO-CA</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Working Real Estate Agent:</h5></div>
                                            <div class="modal-right">
                                                <h5>Yes</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Show Proof Of Income:</h5></div>
                                            <div class="modal-right">
                                                <h5>Yes</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Bankruptcy Last 3 Years:</h5></div>
                                            <div class="modal-right">
                                                <h5>Yes</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Employment Status:</h5></div>
                                            <div class="modal-right">
                                                <h5>Self Employed</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Estimated Annual Household Income:</h5></div>
                                            <div class="modal-right">
                                                <h5>Adjustable</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Estimated Down Payment:	</h5></div>
                                            <div class="modal-right">
                                                <h5>Zero Down</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Purchase Price:</h5></div>
                                            <div class="modal-right">
                                                <h5>$85,001-$90,000</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Property Used For:</h5></div>
                                            <div class="modal-right">
                                                <h5>Primary Residence</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Purchase Situation:</h5></div>
                                            <div class="modal-right">
                                                <h5>Offer Pending / Found Property</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>First Purchase:</h5></div>
                                            <div class="modal-right">
                                                <h5>Yes</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Credit Score:</h5></div>
                                            <div class="modal-right">
                                                <h5>Good (700-739)</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Property Type:</h5></div>
                                            <div class="modal-right">
                                                <h5>Multi-Family Home</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Device Type:</h5></div>
                                            <div class="modal-right">
                                                <h5>Tablet / Smartphone</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Sticky Bar Lead:</h5></div>
                                            <div class="modal-right">
                                                <h5>No</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Sticky Bar URL:</h5></div>
                                            <div class="modal-right">
                                                <h5>N/A</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Date:</h5></div>
                                            <div class="modal-right">
                                                <h5>October 1, 2020</h5></div>
                                        </div>
                                        <div class="outer">
                                            <div class="modal-left">
                                                <h5>Time:</h5></div>
                                            <div class="modal-right">
                                                <h5>8:10 am PDT</h5></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-none">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteleads" class="modal fade lp-modal-box in">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title">Delete Lead</h3>
                </div>
                <div class="modal-body model-action-body">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-sm-12 modal-action-msg-wrap">
                                <div class="funnel-message modal-msg">
                                    Are you sure to delete Lead?
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer lp-modal-action-footer">
                    <form id="form_confirmpixelDelete" method="post" action="">
                        <input type="hidden" id="id_confirmPixelDelete" value="" />
                        <input id="current_hash_confirmPixelDelete" type="hidden" value="#" />
                        <input id="client_id_confirmPixelDelete" type="hidden" value="#" />
                    </form>
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel btnCancel_confirmPixelDelete" data-dismiss="modal">No, Never Mind</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary btnAction_confirmPixelDelete">Yes, Delete</button>
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