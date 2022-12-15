<!--************Stats POPUP************-->
<div class="modal fade add_recipient stats" id="stats">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title stats-title">Stats Report</h3>
                <div class="p-header-menu text-right">
                    <div class="links top-links">
                        <a id="stats-lp-video" data-lp-wistia-title="" data-lp-wistia-key="" class="btn-video lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal"><i class="lp-icon-strip camera-icon"></i> &nbsp;<span class="action-title">Watch how to video</span></a>
                        <a href="#" data-toggle="modal" data-target="#ip-block" class="ip-block">Block IP</a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="stats_model_notification hide"></div>
                <div class="reportContent hide">
                    <input type="hidden" name="startDate" id="startDate">
                    <input type="hidden" name="endDate" id="endDate">
                    <input type="hidden" name="clicked_by" id="clicked_by">
                    <div class="filter-wrapper">
                        <div class="data-type">
                             <span class="device-select-menu">
                                <span class="dropdown-label">Device Type</span>
                                <div class="dropdown qa-dd dropdown-toggle device-dropdown" data-value="total" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="firstLabel qaLabel"><span class="displayText"><span>All</span></span> <span class="caret"></span></span>
                                    <input type="hidden" name="device-dropdown">
                                    <ul class="device-list dropdown-list">
                                        <li data-value="total" data-label="All"><span>All</span></li>
                                        <li data-value="desktop" data-label="Desktop"><span>Desktop</span></li>
                                        <li data-value="mobile" data-label="Mobile"><span>Mobile</span></li>
                                    </ul>
                                </div>
                             </span>
                        </div>
                        <div class="data-range">
                                <span class="qa-select-menu">
                                <span class="dropdown-label">Date Range</span>
                                <div class="dropdown qa-dd qa-dropdown dropdown-toggle lp-date-range" id="reportrange" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="firstLabel qaLabel stats-data-range"><span class="qaText"><span>All Time</span></span> <span class="caret"></span></span>
                                    <input type="hidden" name="qa-dropdown">
                                </div>
                            </span>
                        </div>
                    </div>

                    <div class="row seven-cols">
                        <div class="lead-wrapper statsSummary stats_total">
                            <div class="col-sm-1">
                                <div class="leadbox first">
                                    <span class="lead-title">New<span class="nl">Leads</span></span>
                                    <span class="count new_leads">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Total<span class="nl">Leads</span></span>
                                    <span class="count leads">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Visitors Since<span class="nl">Sunday</span></span>
                                    <span class="count current_week_visitor">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Visitors This<span class="nl">Month</span></span>
                                    <span class="count current_month_visitor">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Total<span class="nl">Visitors</span></span>
                                    <span class="count visits">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Conversion<span class="nl">Rate</span></span>
                                    <span class="count conversion">-</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="lead-wrapper statsSummary stats_desktop hide">
                            <div class="col-sm-1">
                                <div class="leadbox first">
                                    <span class="lead-title">New<span class="nl">Leads</span></span>
                                    <span class="count new_leads">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Total<span class="nl">Leads</span></span>
                                    <span class="count leads">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Visitors Since<span class="nl">Sunday</span></span>
                                    <span class="count current_week_visitor">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Visitors This<span class="nl">Month</span></span>
                                    <span class="count current_month_visitor">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Total<span class="nl">Visitors</span></span>
                                    <span class="count visits">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Conversion<span class="nl">Rate</span></span>
                                    <span class="count conversion">-</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="lead-wrapper statsSummary stats_mobile hide">
                            <div class="col-sm-1">
                                <div class="leadbox first">
                                    <span class="lead-title">New<span class="nl">Leads</span></span>
                                    <span class="count new_leads">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Total<span class="nl">Leads</span></span>
                                    <span class="count leads">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Visitors Since<span class="nl">Sunday</span></span>
                                    <span class="count current_week_visitor">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Visitors This<span class="nl">Month</span></span>
                                    <span class="count current_month_visitor">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Total<span class="nl">Visitors</span></span>
                                    <span class="count visits">-</span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="leadbox">
                                    <span class="lead-title">Conversion<span class="nl">Rate</span></span>
                                    <span class="count conversion">-</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="lp-graph">
                        <div class="graph-title">Performance Metrics</div>
                        <div class="display">
                            <span class="display-select-menu">
                                <span class="dropdown-label">Data Type</span>
                                <div class="dropdown qa-dd dropdown-toggle display-dropdown" data-value="conversion" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="firstLabel qaLabel"><span class="displayText"><span>Conversion Rate</span></span> <span class="caret"></span></span>
                                    <input type="hidden" name="display-dropdown">
                                    <ul class="display-list dropdown-list">
                                       <li data-value="conversion"><span>Conversion Rate</span></li>
                                       <li data-value="leads"><span>Leads</span></li>
                                       <li data-value="visits"><span>Visits</span></li>
                                    </ul>
                                </div>
                             </span>
                        </div>
                        <div class="clearfix"></div>
                        <canvas id="myChart" class="graph" width="400" height="200"></canvas>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="links">
                                {{--<a href="#" data-toggle="modal" data-target="#google-analysis" class="google-analytics">add google analytics</a>--}}
                                                                {{--<a href="#" data-toggle="modal" data-target="#ip-block" class="ip-block">Block IP</a>--}}
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="lp-modal-footer">
                                <a data-dismiss="modal" class="btn lp-btn-cancel ip-btn">Close</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--************Google Analysis POPUP************-->
<div class="modal fade add_recipient home_popup google-analytics" id="google-analysis">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Google Analytics</h3>
            </div>



            <div class="modal-body">
                <form action="" method="post" id="add-code-popup" class="form-inline lp-popup-form google-form">

                    <div class="form-group lp-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label" for="google_anal">Google Tracking ID</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="google-tracking" class="form-control google-control" id="google_tracking">
                                <input type="hidden" class="form-control google-control" id="google_domain">
                                <input type="hidden" class="form-control google-control" id="google_clientid">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-modal-footer footer-border">
                                <a data-dismiss="modal" class="btn lp-btn-cancel ip-btn">Close</a>
                                <a href="#" class="btn lp-btn-add google-delete">Delete</a>
                                <input type="button" class="btn lp-btn-add google_code_cta" value ="Save">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--************IP Block POPUP************-->
<div class="modal fade add_recipient block-ip" id="ip-block">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Block IP</h3>
            </div>
            <div class="ip-block-notifcations" style="display: none; opacity: 500;">
                <div class="alert alert-success" style="opacity: 500; display: none;">
                </div>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="add-code-popup" class="form-inline lp-popup-form ip-block-form">
                    <input type="hidden"  name="funnel_hash" class="form-control google-control" id="funnel_hash">
                    <input type="hidden"  name="ip_action" class="form-control google-control" id="ip_action" value="add">
                    <input type="hidden"  name="ip_id" class="form-control google-control" id="ip_id" value="">
                    <div class="add-ip">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group lp-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="ip_name">Name of IP</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text"  name="ip_name" class="form-control google-control" id="ip_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group lp-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="ip_address">IP Address</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text"  name="ip_address" class="form-control google-control" id="ip_address" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="btn-wrapper">
                                    <input type="submit" class="btn block-btn block_ip_cta" value ="Block IP">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
                <form class="form-inline" method="post">

                    <div class="lead-alert-section lead-alert">
                        <div class="ref-title">
                            List of Blocked IP's
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
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-modal-footer block-footer">
                            <a data-dismiss="modal" class="btn lp-btn-cancel ip-btn">Close</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="startDate" id="startDate">
<input type="hidden" name="endDate" id="endDate">
