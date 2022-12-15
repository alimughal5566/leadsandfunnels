@extends("layouts.leadpops-inner-sidebar")
@section('content')
    <main class="main">
        <section class="main-content">
            @php
                LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view);
            @endphp
            @include("partials.flashmsgs")

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
                        <input type="hidden" name="clicked_by" id="clicked_by" value="{{ @$view->data->currenthash }}">
                        <div class="data-type">
                            <label for="device_type">Device Type</label>
                            <div class="select2__device-type-parent">
                                <select class="select2__device-type" name="device_type" id="device_type">
                                    <option value="total">All</option>
                                    <option value="desktop">Desktop</option>
                                    <option value="mobile">Mobile</option>
                                </select>
                            </div>
                        </div>
                        <div class="data-range">
                                    <span class="qa-select-menu">
                                        <label>Data Range</label>
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
                            <span class="lead__count" id="new_leads">--</span>
                        </div>
                        <div class="lead__box">
                                    <span class="lead__title">
                                        Total Leads
                                    </span>
                            <span class="lead__count" id="leads">--</span>
                        </div>
                        <div class="lead__box">
                                    <span class="lead__title">
                                        Visitors Since Sunday
                                    </span>
                            <span class="lead__count" id="current_week_visitor">--</span>
                        </div>
                        <div class="lead__box">
                                    <span class="lead__title">
                                        Visitors This Month
                                    </span>
                            <span class="lead__count" id="current_month_visitor">--</span>
                        </div>
                        <div class="lead__box">
                                    <span class="lead__title">
                                        Total Visitors
                                    </span>
                            <span class="lead__count" id="visits">--</span>
                        </div>
                        <div class="lead__box">
                                    <span class="lead__title">
                                        Conversion Rate
                                    </span>
                            <span class="lead__count" ><span id="conversion">--</span><span class="lead__unit">%</span></span>
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
                        {{--<canvas id="myChart" class="graph" width="400" height="200"></canvas>--}}
                        <div id="myhighchart"></div>
                    </div>
                </div>
            </div>


            <!-- content of the page -->
            <!-- footer of the page -->
            <div class="footer">
                @include("partials.footerlogo")
            </div>
        </section>
    </main>
    <input type="hidden" name="startDate" id="startDate">
    <input type="hidden" name="endDate" id="endDate">

    <!-- ===== Model Boxes - Delete Blocked IP - Start ===== -->
    <div id="modal_confirmDeleteIp"  data-backdrop="static"  class="modal fade lp-modal-box in" style="z-index: 200000">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title">Remove IP</h3>
                </div>
                <div class="modal-body modal-body-notif-msg model-action-body">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-sm-12 modal-action-msg-wrap">
                                <div class="notification_confirmDeleteIp">Remove IP Address from block list.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <form id="form_confirmDeleteIp" method="post" action="">
                        <input type="hidden" id="action_confirmDeleteIp" value="" />
                    </form>
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                                <button type="button" class="button button-secondary" id="btnAction_confirmDeleteIp">Remove</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===== Model Boxes - Delete Blocked IP - End ===== -->
    <!--************IP Block POPUP************-->
    <div class="modal fade add_recipient block-ip"  data-backdrop="static"  id="ip-block">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Block IP
                        <span class="fb-tooltip">
                            <span class="question-mark question-mark_modal el-tooltip" title="Lorem Ipsum">?</span>
                        </span>
                    </h3>
                    <a data-lp-wistia-title="{{$view->data->videotitle}}" data-lp-wistia-key="{{$view->data->wistia_id}}" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                        <span class="icon ico-video"></span> WATCH HOW-TO VIDEO</a>
                </div>
                <div class="modal-body pb-0">
                    <form action="" method="post" id="add-code-popup" class="form-pop ip-block-form">
                        <input type="hidden"  name="funnel_hash" class="form-control google-control" id="funnel_hash" value="{{ $view->data->currenthash }}">
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
                                        <input type="submit" class="button button-primary" id="addUpdateIpAddress" value ="Block IP">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div id="ip-block_header" class="col d-none">
                                    <h2 class="head-list">List of Blocked IPs</h2>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="lp-table w-100">
                        <div class="lp-table__head d-none">
                            <ul class="lp-table__list">
                                <li class="lp-table__item"><span>IP Name</span></li>
                                <li class="lp-table__item"><span>IP Address</span></li>
                                <li class="lp-table__item"><span>Options</span></li>
                            </ul>
                        </div>
                        <div class="lp-table__body ">
                            <div class="message-block" id="message-block" style="display: flex">(You're not currently blocking any IPs)</div>
                            <div class="ip-quick-scroll-wrap">
                             <div class="ip-quick-scroll"></div>
                            </div>
                            {{--quick-scroll--}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel lp-btn-cancel ip-btn" data-dismiss="modal">Close</button>
                            </li>
                            {{--<li class="action__item">--}}
                            {{--<button type="button" class="button button-cancel lp-btn-cancel ip-btn" data-dismiss="modal">Cancel</button>--}}
                            {{--</li>--}}
                            {{--<li class="action__item">--}}
                            {{--<button type="submit" class="button button-primary">Save</button>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footerScripts')
    <script>
        let hash ='{!! @$view->data->currenthash !!}';
        let stats_graph_steps = {!! json_encode(config('lp.stats_graph_steps')) !!};
    </script>
    <script src="{{ config('view.theme_assets') }}/pages/statistics.js?v={{ LP_VERSION }}"></script>


@endpush
