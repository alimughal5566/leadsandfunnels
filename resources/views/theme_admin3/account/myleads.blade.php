@extends("layouts.leadpops-inner-sidebar")
@section('content')
    <main class="main">
        <section class="main-content">

            <form action="#" name="mylead" id="mylead" class="" method="post">
                <input type="hidden" name="myleadstart" id="myleadstart" value="" />
                <input type="hidden" name="myleadend" id="myleadend" value="" />
                <input type="hidden" name="allfunnelkey" id="allfunnelkey" value='' />
                <input type="hidden" name="target_ele" id="target_ele" value='' />
                <input type="hidden" name="allfunnelkeytotal" id="allfunnelkeytotal" value='' />
                @if ( (defined("MYLEAD_SRC") &&  MYLEAD_SRC=="keydb") || @$_COOKIE['myleads_src'] == "keydb" )
                    <input type="hidden" name="myleads_src" id="myleads_src" value='keydb' />
                @else
                    <input type="hidden" name="myleads_src" id="myleads_src" value='db' />
            @endif
                {{csrf_field()}}
                <input type="hidden" name="client_id" id="client_id" value="{{ $view->data->client_id }}">
                <input type="hidden" name="leadpop_id" id="leadpop_id"  value="{{ $view->data->customLeadpopid }}">
                <input type="hidden" name="leadpop_version_seq" id="leadpop_version_seq"  value="{{ $view->data->customLeadpopVersionseq }}">
                <input type="hidden" name="vertical_id" id="vertical_id"  value="{{ $view->data->customVertical_id }}">
                <input type="hidden" name="vertical_sub_id" id="vertical_sub_id"  value="{{ $view->data->customSubvertical_id }}">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ $view->data->currenthash }}">
                <input type="hidden" name="result_per_page_val" id="result_per_page_val" value="{{ $view->data->result_per_page }}">
                <input type="hidden" name="page" id="page" value="{{ $view->data->page }}">
                <input type="hidden" name="letter" id="letter" value="{{ $view->data->letter }}">
                <input type="hidden" name="sortby" id="sortby" value="{{ $view->data->sortby }}">
                <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $view->data->clickedkey }}">
                <input type="hidden" name="zclickedcategory" id="zclickedcategory" value="{{ $view->data->customLeadpopid.'~'.$view->data->customLeadpopVersionseq.'~'.$view->data->client_id }}">
                <input type="hidden" name="funnel_url" id="funnel_url" value="https://{{ $view->data->workingLeadpop }}">
                <!-- Title wrap of the page -->
            @php
                LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view)
            @endphp
            <!-- content of the page -->
                <div class="lp-panel lp-panel_loader-wrapper">
                    <div class="lp-panel__head">
                        <div class="col-left my-lead-title">
                            <h2 class="lp-panel__title el-tooltip" title="<p>This is the total number of leads available <br/>(below). Deleted leads are not included.</p>">
                                Available Leads: <span id="avllead" class="lead-counter">0</span>
                            </h2>
                            <div class="leads-data-range ml-5">
                                    <span class="qa-select-menu">
                                        <label>Data Range</label>
                                        <div class="dropdown qa-dd qa-dropdown dropdown-toggle lp-date-range" id="leadrange"  role="button" aria-haspopup="true" aria-expanded="false">
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
                                New Leads: <span class="leads__new-count" id="lp-new-lead">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="d-flex">
                            <input id="title__tag search" placeholder="Search your leads by first or last name..." name="search" class="form-control" type="text">
                            <input class="button button-primary ml-4 w-auto lp-search-btn"  id="lp-search-btn"  value="Search" type="submit">
                        </div>
                        <div class="row">
                            <div class="col">
                                <ul class="alpha__search alpha-search">
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
                                            <a id="expswdlnk" href="javascript:void(0);" onclick="exportsdata('word');" class="action__link">
                                                <span class="ico ico-ms-word"></span>export as .doc
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a id="expsexelnk" href="javascript:void(0);" onclick="exportsdata('excel');" class="action__link">
                                                <span class="ico ico-adobe-xs"></span>export excel
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a id="expspdflnk" href="javascript:void(0);" onclick="exportsdata('pdf');" class="action__link">
                                                <span class="ico ico-adobe"></span>export as pdf
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a href="javascript:void(0);" id="printmailtolefthref" class="action__link">
                                                <span class="ico ico-print"></span>print
                                            </a>
                                        </li>
                                        <li class="action__item">
                                            <a href="javascript:void(0);" id="mailtolefthref" class="action__link">
                                                <span class="ico ico-email"></span>email
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-right">
                                <ul class="action__list">
                                    <li class="action__item">
                                        <a href="#" id="delmyleads"  class="action__link lead__btn-del my-lead-del-btn">
                                            <span class="ico ico-cross"></span>delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col__wrapper lead-selection">
                            <div class="col-left">
                                <div class="checkbox pl-2 ml-1">
                                    <input type="checkbox" id="selactionall" class="all-check-box" name="selactionall">
                                    <label class="lead-label" for="selactionall">
                                        Select All
                                    </label>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="lead-sorting text-right">
                                    <span>Date</span>
                                    <a href="#" class="leadsort @if($view->data->sortby=="desc") {{ 'sort-active' }} @endif" data-sortvalue="desc">
                                        <i class="ico ico-caret-down"></i>
                                    </a>
                                    <a href="#" class="leadsort @if($view->data->sortby=="asc") {{ 'sort-active' }} @endif" data-sortvalue="asc">
                                        <i class="ico ico-caret-up"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="leads-result" id="myleads_results">
                        </div>
                        <div class="col__wrapper lead-pagination">
                            <div class="col-left lead-per-page">
                                <span class="pagination-label">Leads per page</span>
                                <ul class="action__list result_per_page" id="result_per_page">
                                    <li class="action__item">
                                        <a class="action__link @if($view->data->result_per_page==10) {{ 'active' }} @endif" href="javascript:void(0)" data-value="10">10</a>
                                    </li>
                                    <li class="action__item">
                                        <a class="action__link @if($view->data->result_per_page==25) {{ 'active' }} @endif" href="javascript:void(0)" data-value="25">25</a>
                                    </li>
                                    <li class="action__item">
                                        <a class="action__link @if($view->data->result_per_page==50) {{ 'active' }} @endif" href="javascript:void(0)" data-value="50">50</a>
                                    </li>
                                    <li class="action__item">
                                        <a class="action__link @if($view->data->result_per_page==100) {{ 'active' }} @endif" href="javascript:void(0)" data-value="100">100</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-right">
                                <span class="pagination-label">Page</span>
                                <div  id="leadpop-pagination">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mask-inside">
                        <div class="preloader"><div class="spin base_clr_brd"><div class="clip left"><div class="circle"></div></div><div class="gap"><div class="circle"></div></div><div class="clip right"><div class="circle"></div></div></div></div>
                    </div>
                </div>
                <!-- footer of the page -->
                <div class="footer">
                    <div class="row">
                        <img src="{{ config('view.rackspace_default_images').'/footer-logo.png'}}" alt="footer logo">
                    </div>
                </div>
            </form>
        </section>
    </main>
    <div class="modal fade" id="single-lead-modal" data-backdrop="static" >
    </div>

    <div id="deleteleads" class="modal fade lp-modal-box in" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title">Delete Lead</h3>
                </div>
                <div class="modal-body model-action-body">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-sm-12 modal-action-msg-wrap">
                                <div class="funnel-message modal-msg"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer lp-modal-action-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel btnCancel_confirmPixelDelete" data-dismiss="modal">No, Never Mind</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary btnAction_confirmPixelDelete" id="deletethelead">Yes, Delete</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myleadsemail" class="modal fade lp-modal-box in" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title">Export lead data</h3>
                </div>
                <div class="modal-body model-action-body">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-sm-12 modal-action-msg-wrap">
                                <div class="funnel-message modal-msg">You will be notified at @if($view->session->clientInfo->contact_email) {{ $view->session->clientInfo->contact_email }} @endif when the exported file is ready for you to download.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer lp-modal-action-footer">
                    <div class="action">
                        <input type="hidden"  name="newemail" class="form-control custom-control" id="newemail" value="@if($view->session->clientInfo->contact_email) {{ $view->session->clientInfo->contact_email }} @endif">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel btnCancel_confirmPixelDelete" data-dismiss="modal">No, Never Mind</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary _add_recipient_btn" id="myleademail">Send Mail</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
