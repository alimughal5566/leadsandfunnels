@extends("layouts.leadpops")

@section('content')
    @php
        $s_url = array();
        /* if  User Have Lite Package*/
        if(@$view->session->clientInfo->is_lite=='1'){
            $str_lite_funnels=$view->session->clientInfo->lite_funnels;
            $lite_funnels=explode(",",$str_lite_funnels);
        }
        /* End if  User Have Lite Package*/

        $funnelTypes = LP_Helper::getInstance()->getFunnelTypes(LP_Helper::getInstance()->getClientType());
         $funnel_type_name = $funnelTypes['f'];
            $filter_search = $view->session->tag_filter;
            $sort = 3;
            $sort_name = 'Funnel Name';
            $asc = 'active';
            $desc = 'inactive';
            $perpage = '25';
            $page = '1';
             if(isset($_COOKIE['tag']) and @$_COOKIE['tag'] == 1) {
                $filter_search = @$_COOKIE['folder_filter_'.$view->session->clientInfo->client_id];
                if($filter_search){
                $filter_arr = explode('&',$filter_search);
                if($filter_arr){
                foreach($filter_arr as $k){
                    $arr_ex = explode('=',$k);
                    ${$arr_ex[0]} = filterStrReplace($arr_ex[1]);
                    }
                 if(!empty($sort)){
                        $sort = $sort;
                        $sort_name = $sort_name;
                    }
                    if(!empty($order) and $order == 'asc'){
                        $asc = 'active';
                        $desc = 'inactive';
                    }
                    if(!empty($order) and $order == 'desc'){
                        $asc = 'inactive';
                        $desc = 'active';
                    }
                    if(!empty($page)){
                        $page  = $page;
                    }
                    if(!empty($perPage)){
                        $perpage = $perPage;
                    }
                 }
                }
             }else{
                 $arr = LP_Helper::getInstance()->funnel_type_list();
                 $funnel = array_search($funnelTypes['f'],$arr);
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
                    if(!empty($filter_search->page)){
                        $page  = $filter_search->page;
                    }
                    if(!empty($filter_search->perPage)){
                        $perpage = $filter_search->perPage;
                    }
                  }
                }


    @endphp
    <section id="main-content">

        <div id="funnels-section" class="Mortgage funnels-section_v2" data-perpage="{{$perpage}}" data-page="{{$page}}">
            <input type="hidden" id="is_lite_package" value="{{@$view->session->clientInfo->is_lite}}">
            <input type="hidden" id="is_lite_funnels" value="{{@$view->session->clientInfo->lite_funnels}}">
            <div class="funnels vertical_container active">
                <div class="container">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="section-title-wrapper">
                                <h2 class="section-title"> {{$funnel_type_name}}</h2>
                                @php
                                    if(isset($view->session->clientInfo->tag_folder)
                                     and (@$view->session->clientInfo->tag_folder == 1 OR @$_COOKIE['tag'] == 1)) {
                                       echo getTagFolderVideo($view);
                                       }
                                @endphp
                                <div class="funnel-status total-leads">
                                    Total Leads: <span>{{LP_Helper::getInstance()->total_leads}}</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="funnels-details">
                        <div class="mk-record">
                            <div class="row">
                                <div class="funnels-header">
                                    <div class="col-sm-4">
                                        <h2 class="funnels-header-title">
                                            Total Funnels: <span></span>
                                        </h2>
                                    </div>
                                    <div id="sort-filter" data-loadaction="" class="col-sm-8 text-right">
                                        <span class="qa-select-menu">
                                        <span class="dropdown-label">Sort By</span>
                                        <div class="dropdown qa-dd qa-dropdown dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-value="{{$sort}}">
                                            <span class="firstLabel qaLabel sort"><span class="qaText"><span>{{$sort_name}}</span></span> <span class="caret"></span></span>
                                            <ul class="qa-list dropdown-list">

                                                {{--
                                                Note: 1st hide because its not working now.
                                                    working on client ids 6546  6666  5243   5006
                                                    not working on 	4005  4009  3002
                                                --}}

                                                <li data-slug="creation-date" class="hide" data-value="1"><span>Creation Date</span></li>
                                                 <li data-slug="conversion-rate" data-value="8" class="{{($sort ==  8)?' hide-sort':'' }}"><span>Conversion Rate</span></li>
                                                <!--<li data-slug="domain-name" data-value="2"><span>Domain Name</span></li>-->
                                                <li data-slug="funnel-name" data-value="3" class="{{($sort ==  3)?' hide-sort':'' }}"><span>Funnel Name</span></li>
                                                <li data-slug="funnel-tags" data-value="9" class="{{($sort ==  9)?' hide-sort':'' }}"> <span>Funnel Tags</span></li>
                                                {{--
                                                Note: 4th and 5th are hide because these are not working now.
                                                --}}
                                                <li data-slug="last-edit" class="hide" data-value="4" class="{{($sort ==  4)?' hide-sort':'' }}"><span>Last Edit</span></li>
                                                <li data-slug="last-submission" class="hide" data-value="5" class="{{($sort ==  5)?' hide-sort':'' }}"><span>Last Submission</span></li>
                                                <li data-slug="number-leads" data-value="6" class="{{($sort ==  6)?' hide-sort':'' }}"><span>Number of Leads</span></li>
                                                <li data-slug="number-visitors" data-value="7" class="{{($sort ==  7)?' hide-sort':'' }}"><span>Number of Visitors</span></li>

                                            </ul>

                                        </div>
                                    </span>
                                        <ul class="nav navbar-nav za-sort">
                                            <li><a href="#sort_by" class="sortdir_asc sort-by {{$asc}}" data-sort="asc" data-status="{{$asc}}"><i class="fa fa-chevron-up" aria-hidden="true"></i></a></li>
                                            <li><a href="#sort_by" class="sortdir_desc sort-by {{$desc}}" data-sort="desc" data-status="{{$desc}}"><i class="fa fa-chevron-down" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="funnels-body za-pagination">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h2 class="funnels-titles">Funnel Name</h2>
                                    </div>
                                    <div class="col-sm-4">
                                        <h2 class="funnels-titles funnels-titles_center">Funnel Tags <!--<a href="#" class="tag-setting"><i class="fa fa-eye"></i></a>--></h2>
                                    </div>
                                    <div class="col-sm-4">
                                        <h2 class="funnels-titles text-right">Leads</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="funnels-list">
                                            <ul>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pagination-wrap-border">
                                    <div class="row">
                                        <div class="pagination-section">
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="mk-record-no-found" style="display: none;">
                            No matching Funnels found.
                        </div>
                        <div class="mk-record-no-found folder-empty" style="display: none;">
                            This folder is empty.
                        </div>
                    </div>

                </div>
            </div>
            <input type="hidden" id="s-url" value='{{json_encode($s_url)}}'>
        </div>
        <img src="{{LP_ASSETS_PATH}}/adminimages/icons/css_sprites.png" class="hide-sprite">
        @include('partials.watch_video_popup')
    </section>
@endsection
