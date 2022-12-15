@extends("layouts.dashboard")
@php
    use App\Constants\LP_Constants;
    $funnelTypes = LP_Helper::getInstance()->getFunnelTypes(LP_Helper::getInstance()->getClientType());
    $funnel_type_name = $funnelTypes['f'];
    $filter_search = @$view->session->tag_filter;
    $sort = 3;
    $sort_name = 'Funnel Name';
    $asc = 'active';
    $desc = 'inactive';
    if($filter_search){
    if(!empty($filter_search->funnel_type_name)){
        $funnel_type_name = $filter_search->funnel_type_name;
    }
    if(!empty($filter_search->sort)){
         $sort = $filter_search->sort;
         $sort_name = $filter_search->sort_name;
    }
    if(!empty($filter_search->order) and $filter_search->order == 'asc'){
           $asc = 'active';
           $desc = 'inactive';
    }
    if(!empty($filter_search->order) and $filter_search->order == 'desc'){
            $asc = 'inactive';
            $desc = 'active';
     }
    }
@endphp
@section('content')
    @include("partials.flashmsgs")
    <!-- contain main informative part of the site -->
    <main class="main">
        <section class="main-content">
            <!-- page inner heading bar -->
            <div class="heading-bar">
                <div class="row">
                    <div class="col-8">
                        <div class="heading-bar__funnels">
                            <h2 class="heading-bar__folder-label">{{$funnel_type_name}}</h2>
                            @if(isset($view->session->clientInfo->tag_folder) && (@$view->session->clientInfo->tag_folder == 1 || @$_COOKIE['tag'] == 1))
                                @php
                                    if (isset($view->data->wistia_id) && !empty($view->data->wistia_id)) {
                                        if (isset($view->data->videotitle) && !empty($view->data->videotitle)) {
                                            $wistitle = $view->data->videotitle;
                                        }else{
                                            $wistitle = 'Name & Tags';
                                        }

                                        echo '<div class="heading-bar__funnels-info">
                                            <a data-lp-wistia-title="' . $wistitle. '" data-lp-wistia-key="' . $view->data->wistia_id. '" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                                <span class="icon ico-video"></span>
                                                WATCH HOW-TO VIDEO
                                            </a>
                                        </div>';
                                    } elseif ((isset($view->data->videolink) && $view->data->videolink)) {
                                        echo '<div class="heading-bar__funnels-info">
                                            <a class="video-link" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                                <span class="icon ico-video"></span>
                                                WATCH HOW-TO VIDEO
                                            </a>
                                        </div>';
                                    }
                                @endphp
                            @endif
                            <div class="heading-bar__funnels-info total_funnels">
                                Total Funnels: <span></span>
                            </div>
                            <div class="heading-bar__funnels-info total-leads">
                                Total Leads: <span>{{LP_Helper::getInstance()->total_leads}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="heading-bar__sorting">
                            <span>Sort by:</span>
                            <div class="heading-bar__sorting-list">
                                <select class="select-custom select-custom_sorting funnel-sorting">
                                    <option value="8" @if(8 == $sort) {{'selected'}} @endif>Conversion Rate</option>
                                    <option value="1" @if(1 == $sort) {{'selected'}} @endif>Creation Date</option>
                                    <option value="3" @if(3 == $sort) {{'selected'}} @endif>Funnel Name</option>
                                    <option value="9" @if(9 == $sort) {{'selected'}} @endif>Funnel Tags</option>
                                    <option value="4" @if(4 == $sort) {{'selected'}} @endif>Last Edit</option>
                                    <option value="5" @if(5 == $sort) {{'selected'}} @endif>Last Submission</option>
                                    <option value="6" @if(6 == $sort) {{'selected'}} @endif>Number of Leads</option>
                                    <option value="7" @if(7 == $sort) {{'selected'}} @endif>Number of Visitors</option>
                                </select>
                            </div>
                            <ul class="heading-bar__sorting-links">
                                <li class="{{$asc}}" data-sort="asc"><span class="icon ico-arrow-up"></span></li>
                                <li class="{{$desc}}" data-sort="desc"><span class="icon ico-arrow-down"></span></li>
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
                        <div class="funnels dashboard-funnels">
                            {{--dashboard funnel load--}}
                        </div>
                    </div>
                </div>
                <!-- pagination-block of the page -->
                <div class="pagination-block">
                    <div class="row main-pagination">
                    </div>
                </div>
            </section>
            <div class="message-block funnel-empty-message" style="display: none;">
            </div>
        </section>
    </main>
    <!-- footer-copyright of the page -->
    <footer class="footer-copyright">
        <div class="row">
            <div class="col-12">
                <img src="{{ config('view.rackspace_default_images').'/footer-logo.png'}}" alt="leadPops" title="leadPops">
            </div>
        </div>
    </footer>

    <div class="modal fade" id="modal_mortgageWebsiteFunnel" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">leadPops ConversionPro&#8482; Websites</h5>
                </div>
                <div class="modal-body text-center">
                    <p class="modal-msg modal-msg_light"> We'd love to talk to you about leadPops ConversionPro <i style="font-size:10px;vertical-align: text-top;" class="fa fa-trademark" aria-hidden="true"></i><span class="modal_mortgageWebsiteFunnel_client_type"></span> Websites</p>

                    <a class="button button-secondary" href="{{  LP_Constants::URL_TO_SCHEDULE_LEADPOP_CALL }}" target="_blank">Click here to schedule a call with us.</a>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" id="website_funnel_modal_hide" data-dismiss="modal">Close</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
