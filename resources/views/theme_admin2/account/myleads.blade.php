@extends("layouts.leadpops")

@section('content')
<section id="leadpopovery" >
    <div id="overlay">
        <i class="fa fa-spinner fa-spin spin-big"></i>
    </div>
</section>
<div class="container">
    @php  LP_Helper::getInstance()->getFunnelHeader($view) @endphp
    <form action="#" name="mylead" id="mylead" class="" method="post">
    <div class="my-lead-section my_leads">
        <div class="my-lead-title">
            <div class="row">
                <div class="col-sm-9 my-lead-title">
                    <h4 class="lp-new-title lp-leads-tooltip">Available Leads: <span></span>
                        <div class="lp-leads-tooltiptext">This is the total number of leads available (below). Deleted leads are not included.</div>
                    </h4>
                    <div id="mylead-date-range" class="lead-date-range">
                        <div class="lp-parent">
                            <!--<input type="text" name="datefilter" value="" />-->
                            <span class="qa-select-menu">
                                <span class="dropdown-label">Date Range</span>
                                <div class="dropdown qa-dd qa-dropdown dropdown-toggle lp-date-range" id="leadrange" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="firstLabel qaLabel stats-data-range"><i class="fa fa-calendar cal-size" aria-hidden="true"></i>Select Date<span class="caret"></span></span>
                                    <input type="hidden" name="qa-dropdown">
                                </div>
                            </span>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="lead-info">
                        New leads: <span id="lp-new-lead"></span>
                    </div>
                </div>
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

            </div>
        </div>
        <div class="my-leads-main">
            <div class="lp-lead-layer lp-lead-layer__inner">
                <div class="middle"></div>
                <div class="lead-layer-text"><i class="fa fa-spinner fa-spin"></i>Please wait processing data ...</div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-11 search-box-width">
                        <input type="text" placeholder="Search your leads..." class="form-control custom-control" id="search" name="search">
                    </div>
                    <div class="col-sm-1 text-right">
                        <button id="lp-search-btn" type="button" class="btn btn-info lp-search-btn">Search</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <ul class="alpha-search">
                        <li><a href="#">A</a></li>
                        <li class="remove-border"><a href="#">B</a></li>
                        <li class="remove-border"><a href="#">C</a></li>
                        <li class="remove-border"><a href="#">D</a></li>
                        <li class="remove-border"><a href="#">E</a></li>
                        <li class="remove-border"><a href="#">F</a></li>
                        <li class="remove-border"><a href="#">G</a></li>
                        <li class="remove-border"><a href="#">H</a></li>
                        <li class="remove-border"><a href="#">I</a></li>
                        <li class="remove-border"><a href="#">J</a></li>
                        <li class="remove-border"><a href="#">K</a></li>
                        <li class="remove-border"><a href="#">L</a></li>
                        <li class="remove-border"><a href="#">M</a></li>
                        <li class="remove-border"><a href="#">N</a></li>
                        <li class="remove-border"><a href="#">O</a></li>
                        <li class="remove-border"><a href="#">P</a></li>
                        <li class="remove-border"><a href="#">Q</a></li>
                        <li class="remove-border"><a href="#">R</a></li>
                        <li class="remove-border"><a href="#">S</a></li>
                        <li class="remove-border"><a href="#">T</a></li>
                        <li class="remove-border"><a href="#">U</a></li>
                        <li class="remove-border"><a href="#">V</a></li>
                        <li class="remove-border"><a href="#">W</a></li>
                        <li class="remove-border"><a href="#">X</a></li>
                        <li class="remove-border"><a href="#">Y</a></li>
                        <li class="remove-border"><a href="#">Z</a></li>
                        <li class="view-all"><a href="#">ALL</a></li>
                    </ul>
                </div>
            </div>
            <div class="my-lead-action-box">
                <div class="alert alert-success" id="success-alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Success:</strong>
                        <span></span>
                </div>
                <div class="row my-lead-result">
                    <div class="col-sm-10">
                        <ul class="my-lead-action">
                            <li>
                                <a id="expswdlnk" href="javascript:void(0);" onclick="exportsdata('word');"><i class="lp-icon-strip doc-icon"></i>
                                    <span class="action-title">Export As Doc</span>
                                </a>
                            </li>
                            <li><a id="expsexelnk" href="javascript:void(0);" onclick="exportsdata('excel');" ><i class="lp-icon-strip excel-icon"></i>
                                    <span class="action-title">Export Excel</span></a></li>
                            <li><a id="expspdflnk" href="javascript:void(0);" onclick="exportsdata('pdf');" ><i class="lp-icon-strip pdf-icon"></i>
                                    <span class="action-title">Export As Pdf</span></a></li>
                            <li><a href="javascript:void(0);" id="printmailtolefthref" ><i class="lp-icon-strip print-icon"></i>
                                    <span class="action-title">Print</span></a></li>
                            <li><a href="javascript:void(0);" id="mailtolefthref" ><i class="lp-icon-strip email-icon"></i>
                                    <span class="action-title">Email</span></a></li>
                        </ul>
                    </div>
                    <div class="col-sm-2 text-right">
                        <a id="delmyleads" class="btn btn-default my-lead-del-btn" data-toggle="modal" data-target="#deleteleads"><i class="fa fa-times danger" aria-hidden="true"></i> Delete</a>
                    </div>
                </div>
            </div>
                <div class="row" id="mylead-top-sect">
                    <div class="lead-order-by">
                        <div class="col-sm-10">
                            <div class="col-sm-3" >
                                <input type="checkbox" class="all-check-box" id="selactionall" name="selactionall" />
                                <label for="selactionall"><span></span>Select All</label>
                            </div>
                        </div>
                        <div class="col-sm-2 lead-sorting text-right">
                            <span>Date</span>
                            <a href="#" class="leadsort @if($view->data->sortby=="desc") {{ 'sort-active' }} @endif" data-sortvalue="desc" ><i class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></i></a>
                            <a href="#" class="leadsort @if($view->data->sortby=="asc") {{ 'sort-active' }} @endif" data-sortvalue="asc"><i class="glyphicon glyphicon-triangle-top" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div id="myleads_results">

                </div>
                <div class="my-lead-pagination">
                    <div class="row">
                        <div class="ptitle col-sm-1">
                            <span class="per-page-title" >Page</span>
                        </div>
                        <div id="leadpop-pagination" class="col-sm-5 funnel-pagination">
                            <!-- <ul id="leadpop-pagination" class="pagination lp-pagination">
                                <li><a href="#" class="pag-active">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                            </ul> -->
                        </div>
                        <div id="funnel-pagination-page" class="col-sm-6 funnel-pagination text-right">
                            <span class="per-page-title">Leads per page</span>&nbsp;&nbsp;
                            <ul id="result_per_page" class="pagination result_per_page">
                                <li><a data-value="10" href="javascript:void(0)" class="@if($view->data->result_per_page==10) {{ 'pag-active' }} @endif">10</a></li>
                                <li><a data-value="25" href="javascript:void(0)" class="@if($view->data->result_per_page==25) {{ 'pag-active' }} @endif">25</a></li>
                                <li><a data-value="50" href="javascript:void(0)" class="@if($view->data->result_per_page==50) {{ 'pag-active' }} @endif">50</a></li>
                                <li><a data-value="100" href="javascript:void(0)" class="@if($view->data->result_per_page==100) {{ 'pag-active' }} @endif">100</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
    </div>
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
    </form>
    <iframe id="excelIframe" src="" width="0" height="0" style="visibility:hidden"></iframe>
</div>
<!--****************Export MY LEADS POPUP HTML*****************-->

<div class="modal fade add_recipient home_popup" id="myleadsemail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Export lead data</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="popup-wrapper modal-action-msg-wrap">
                                <div class="funnel-message modal-msg">You will be notified at @if($view->session->clientInfo->contact_email) {{ $view->session->clientInfo->contact_email }} @endif when the exported file is ready for you to download.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden"  name="newemail" class="form-control custom-control" id="newemail" value="@if($view->session->clientInfo->contact_email) {{ $view->session->clientInfo->contact_email }} @endif">
                <div class="lp-modal-footer footer-border">
                    <a data-dismiss="modal" class="btn lp-btn-cancel" id="modal-close">Close</a>
                    <input type="button" id="myleademail" class="btn lp-btn-add _add_recipient_btn" value ="SEND EMAIL">
                </div>
            </div>
        </div>
    </div>
</div>



<!--****************MY LEADS DELETE POPUP HTML*****************-->


<div class="modal fade add_recipient home_popup" id="deleteleads">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Delete Lead</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="popup-wrapper modal-action-msg-wrap">
                                <div class="funnel-message modal-msg">Are you sure to delete this lead?</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-modal-footer footer-border">
                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                    <input type="button" class="btn lp-btn-add" id="deletethelead" value ="delete">
                </div>
            </div>
        </div>
    </div>
</div>



<!--****************MY LEADS POPUP HTML*****************-->

<div class="modal fade add_recipient lp-single-lead-modal" id="single-lead-modal" tabindex="-1">

</div>

<!--****************LEADS DETAIL POPUP DELETE POPUP HTML*****************-->
<div class="modal fade add_recipient home_popup" id="leadpopconfirm" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Delete Lead</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="popup-wrapper modal-action-msg-wrap">
                                <div class="funnel-message modal-msg">Are you sure to delete this lead?</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-modal-footer footer-border">
                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                    <input type="button" class="btn lp-btn-add" id="leadpopcondelete" value ="Delete">
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.watch_video_popup')
@endsection
