@php
$clientVerticals = LP_Helper::getInstance()->getVerticals();
$funnelTypes = LP_Helper::getInstance()->getFunnelTypes(LP_Helper::getInstance()->getClientType());
$default_vert_val = str_replace(' ','-', strtolower($clientVerticals[LP_Helper::getInstance()->clientTypeOrLandingPages()]));
$tags_list = LP_Helper::getInstance()->GetClientTag();

    if($view->session->clientInfo->dashboard_v2 == 1){
    $arr = LP_Helper::getInstance()->funnel_type_list();
    $funnel = array_search($funnelTypes['f'],$arr);
    $funnel_type_name = $funnelTypes['f'];
    $search_type = 1;
    $search_type_name = 'Search by Funnel Name';
    $tag_type = 1;
    $tag_type_name = 'Has ANY of these tags';
    $tag = array();
    $funnel_option = '';
    $tag_option = '';
    $bottom_bar_wrap = '';
    $filter_search = $view->session->tag_filter;
    if($filter_search){
    if(!empty($filter_search->funnel_type_name)){
        $funnel = $filter_search->funnel;
        $funnel_type_name = $filter_search->funnel_type_name;
    }
    if(!empty($filter_search->search_type)){
        $search_type = $filter_search->search_type;
        $search_type_name = $filter_search->search_type_name;
    }
    if($filter_search->search_type == 2 && !empty($filter_search->tag_type)){
        $tag_type = $filter_search->tag_type;
        $tag_type_name = $filter_search->tag_type_name;
        $tag = explode(',',$filter_search->tag);
        $funnel_option = 'style="display: none;"';
        $tag_option = 'style="display:inline-block;"';
        $bottom_bar_wrap = 'bottom-bar_wrap';
    }
}
@endphp
    <div class="bottom-bar">
        <div class="container">
            <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 bottom-bar_v2 {{ $bottom_bar_wrap }}">
                        <span class="vertical-select-menu lp-type-dropdown">
                            <div class="dropdown mk-dropdown bottom-dd tag-vertical-dropdown funnel-type dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-value="{{ $funnel }}">
                                <span class="firstLabel verLabel">
                                       <span class="verText">
                                       {{ $funnel_type_name }}
                                    </span>
                                    <span class="caret"></span>
                                </span>
                                <ul class="vertical-list dropdown-list">
                                    <li class="selectable" data-value="0"><span>All Funnels</span></li>
                                    @php
                                    foreach($arr as $v_id=>$name){
                                        if($v_id == 7) continue;
                                        if(strpos(strtolower($name),'website')  !== false){
                                            $name  = 'Website Funnels';
                                        }
                                        echo "<li class=\"selectable\" data-value=\"$v_id\"><span>$name</span></li>";
                                    }
                                    @endphp
                                </ul>
                            </div>
                        </span>
                    <span class="ft-select-menu lp-type-dropdown">
                            <div class="dropdown mk-dropdown bottom-dd tag-vertical-dropdown funnel-filter dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-value="{{ $search_type }}">
                                <span class="firstLabel verLabel">
                                    <span class="verText">
                                       {{ $search_type_name }}
                                    </span>
                                    <span class="caret"></span>
                                </span>
                                <ul class="vertical-list dropdown-list">
                                    <li class="selectable" data-value="1"><span>Search by Funnel Name</span></li>
                                    <li class="selectable" data-value="2"><span>Search by Funnel Tags</span></li>
                                </ul>
                            </div>
                        </span>
                    <div class="dropdown mk-dropdown mk-dropdown_last bottom-dd search-tag-box funnel-option" {{ $funnel_option }}>
                        <div class="search-top">
                            <input type="search" class="funnel-search" placeholder="Type in Funnel name..." value="{{ @$filter_search->funnel_search }}">
                        </div>
                        <div class="search-top search-icon" onclick="_search();"><i class="fa fa-search"></i></div>
                    </div>
                    <div class="tag-option" {{ $tag_option }}>
                        <span class="ft-select-menu lp-type-dropdown">
                            <div class="dropdown mk-dropdown bottom-dd tag-vertical-dropdown za-tag-type dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-value="{{ $tag_type }}">
                                <span class="firstLabel verLabel">
                                    <span class="verText">
                                     {{ $tag_type_name }}
                                    </span>
                                    <span class="caret"></span>
                                </span>
                                <ul class="vertical-list dropdown-list">
                                    <li class="selectable" data-value="1"><span>Has ANY of these tags</span></li>
                                    <li class="selectable" data-value="2"><span>Has ALL of these tags</span></li>
                                </ul>
                            </div>
                        </span>
                        <div class="dropdown mk-dropdown_select2 bottom-dd search-tag-box">
                            <div class="search-top">

                                <select class="form-control tag-search" multiple="multiple" >
                                    @foreach($tags_list as $t)
                                    <option value="{{ $t['client_tag_name'] }}"  {{ LP_Helper::getInstance()->getSelectedArr($t['client_tag_name'],$tag) }}>{{ $t['client_tag_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="search-top search-icon"><i class="fa fa-search"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@php
    } else {
@endphp
<div class="bottom-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                    <span class="vertical-select-menu">
                        <span class="vertical-label">Select Your Vertical:</span>
                        <div class="dropdown bottom-dd vertical-dropdown dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-value="{{ $default_vert_val }}">
                            <span class="firstLabel verLabel">
                                <span class="verText">
                                    {{ $clientVerticals[LP_Helper::getInstance()->clientTypeOrLandingPages()] }}
                                </span>
                                <span class="caret"></span>
                            </span>
                            <input type="hidden" name="cd-dropdown" value="{{ $default_vert_val }}">

                            <ul class="vertical-list dropdown-list">
                                @php
                                foreach($clientVerticals as $v_id=>$name){
                                    if($v_id == 7) continue;
                                    $_name = str_replace(' ','-', strtolower($name));
                                    echo "<li class=\"selectable\" data-vid=\"$v_id\" data-value=\"$_name\"><span>$name</span></li>";
                                }
                                @endphp
                            </ul>
                        </div>
                    </span>
                <span class="ft-select-menu lp-type-dropdown">
                        <span class="vertical-label">Type:</span>
                        <div class="dropdown bottom-dd vertical-dropdowntype dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="firstLabel verLabel">
                                <span class="verText">
                                    {{ $funnelTypes['f'] }}
                                </span>
                                <span class="caret"></span>
                            </span>
                            <input type="hidden" name="cd-dropdown" value="{{ str_replace(' ','-', strtolower($funnelTypes['f'])) }}">

                            <ul class="vertical-list dropdown-list mortgage-funnel-type">
                                @php
                                $active = 'active';
                                foreach($funnelTypes as $v_id=>$name){
                                    $_name = str_replace(' ','-', strtolower($name));
                                    $_ftslug = str_replace(' ','-', strtolower($v_id));

                                    if(strtolower($v_id) == "w"){
                                        if( LP_Helper::getInstance()->checkHaveWebsiteFunnels() == true && !empty(LP_Helper::getInstance()->websiteFunnelsList()) )
                                            $type_available = 1;
                                        else
                                            $type_available = 0;
                                    } else {
                                        $type_available = 1;
                                    }

                                    echo "<li class=\"".$active."\" data-ftslug=\"".$_ftslug."\" data-type_available=\"".$type_available."\" data-value=\"$_name\" data-client-type=\"".LP_Helper::getInstance()->getClientType()."\" ><span>$name</span></li>";
                                    $active="";
                                }
                                @endphp
                            </ul>
                        </div>
                    </span>
                <div class="watch-video">

                    @php
                    if((isset($view->data->videolink) && $view->data->videolink) || (isset($view->data->wistia_id) && $view->data->wistia_id)){
                    if(isset($view->data->videotitle) && $view->data->videotitle) {
                        $wistitle=$view->data->videotitle;
                    }
                    $wisid=$view->data->wistia_id;
                        @endphp
                    <a data-lp-wistia-title="{{ $wistitle }}" data-lp-wistia-key="{{ $wisid }}" class="btn-video lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal"><i class="lp-icon-strip camera-icon"></i> &nbsp;<span class="action-title">Watch how to video</span></a>
                        @php } @endphp
                </div>
            </div>
        </div>
    </div>
</div>
@php
    }
@endphp