@php
        $clientVerticals = LP_Helper::getInstance()->getVerticals();
        $funnelTypes = LP_Helper::getInstance()->getFunnelTypes(LP_Helper::getInstance()->getClientType());
        $default_vert_val = str_replace(' ','-', strtolower($clientVerticals[LP_Helper::getInstance()->clientTypeOrLandingPages()]));
        $arr = $tags_list = array();
        $funnel_type_name = $funnelTypes['f'];
        $search_type = 1;
        $search_type_name = 'Search by Funnel Name';
        $tag_type = 1;
        $tag_type_name = 'Has ANY of these tags';
        $tag = array();
        $funnel_option = '';
        $tag_option = '';
        $bottom_bar_wrap = '';
        $filter_search = @$view->session->tag_filter;
        if(isset($_COOKIE['tag']) and @$_COOKIE['tag'] == 1) {
        $arr = folder_list();
        $tags_list = tag_list();
        if($arr){
        $funnel = array_search($funnelTypes['f'],array_column($arr, 'folder_name'));
        if(isset($arr[$funnel]) and !empty($arr[$funnel])){
        $funnel = $arr[$funnel]->id;
        }
        }
        else{
        $funnel = 0;
        }
        $filter_search = @$_COOKIE['folder_filter_'.$view->session->clientInfo->client_id];
        if($filter_search){
        $filter_arr = explode('&',$filter_search);
        if($filter_arr){
        foreach($filter_arr as $k){
            $arr_ex = explode('=',$k);
            ${$arr_ex[0]} = $arr_ex[1];
        }
        if(!empty($funnel_type_name)){
            $funnel = $funnel;
             $funnel_type_name = filterStrReplace($funnel_type_name);
        }
        if(!empty($search_type)){
            $search_type = $search_type;
            $search_type_name = $search_type_name;
            $funnel_search = filterStrReplace($funnel_search);
            if($search_type == 1){
            $tag = array();
            }
           }
        if($search_type == 2 && !empty($tag_type)){
            $tag_type = $tag_type;
            $tag_type_name = $tag_type_name;
            $tag = explode(',',$tag);
            $funnel_option = 'style=display:none;';
            $tag_option = 'style=display:inline-block;';
            $bottom_bar_wrap = 'bottom-bar_wrap';
          }

        if(isset($_COOKIE['debug_tag']) and $_COOKIE['debug_tag'] ==1){
            echo '<pre>';
            print_r($arr);
            echo $funnel;
        }
        }
        }
        }else{
        if(@$view->session->clientInfo->tag_folder == 1){
        $arr = folder_list();
        $tags_list = tag_list();
        if($arr){
        $funnel = array_search($funnelTypes['f'],array_column($arr, 'folder_name'));
        if(isset($arr[$funnel]) and !empty($arr[$funnel])){
        $funnel = $arr[$funnel]->id;
        }
        }
        else{
        $funnel = 0;
        }
            }else{
         $arr = LP_Helper::getInstance()->funnel_type_list();
         $tags_list = LP_Helper::getInstance()->GetClientTag();
         $funnel = array_search($funnelTypes['f'],$arr);
         }
         if($filter_search){
        if(!empty($filter_search->funnel_type_name)){
            $funnel = $filter_search->funnel;
            $funnel_type_name = $filter_search->funnel_type_name;
        }
        if(!empty($filter_search->search_type)){
            $search_type = $filter_search->search_type;
            $search_type_name = $filter_search->search_type_name;
            $funnel_search = $filter_search->funnel_search;
        }
        if($filter_search->search_type == 2 && !empty($filter_search->tag_type)){
            $tag_type = $filter_search->tag_type;
            $tag_type_name = $filter_search->tag_type_name;
            $tag = explode(',',$filter_search->tag);
            $funnel_option = 'style=display:none;';
            $tag_option = 'style=display:inline-block;';
            $bottom_bar_wrap = 'bottom-bar_wrap';
        }
        }
        }
@endphp
    <div class="bottom-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 bottom-bar_v2 {{ $bottom_bar_wrap }}">
                    @php
                        if(isset($view->session->clientInfo->tag_folder)
                        and (@$view->session->clientInfo->tag_folder == 1 OR @$_COOKIE['tag'] == 1)) {
                    @endphp
                    <div class="za-dropdown">
                    <select class="form-control folder-drop-down funnel-type">
                        <option value="0" data-value="0" data-website="0">All Funnels</option>
                        @php
                        if($arr){
                            foreach($arr as $v){
                            if(isset($v->is_website) and $v->is_website == 1){
                             $vl = 'w';
                            }else{
                             $vl = $v->id;
                            }
                            $ret = count(dashboardEmptyFolderSkip($v->id));
                            if($vl == $funnel){
                            $selected = 'selected';
                            }else{
                            $selected = '';
                            }
                            echo "<option value=".$vl." ".$selected." data-value=".$v->id." data-count=".$ret.">$v->folder_name</option>";
                       }
                            }
                        @endphp
                       </select>
                    </div>
                    @php
                        }else {
                    @endphp

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

                                                   echo "<li class=\"selectable\" data-value=\"$v_id\"><span>$name</span></li>";
                                         }
                                           @endphp
                                    </ul>
                                </div>
                            </span>
                    @php
                        }
                    @endphp
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
                            <input type="search" class="funnel-search" placeholder="Type in Funnel name..." value="{{ @$funnel_search }}">
                        </div>
                        <div class="search-top search-icon" onclick="_search(true);"><i class="fa fa-search"></i></div>
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
                                @php
                                    if(isset($view->session->clientInfo->tag_folder)
                                    and (@$view->session->clientInfo->tag_folder == 1 OR @$_COOKIE['tag'] == 1)){
                                @endphp

                                <select class="form-control tag-search" multiple="multiple" >
                                    @if($tags_list)
                                    @foreach($tags_list as $t)

                                    <option value="{!! $t->tag_name !!}" {{ getSelectedArr($t->tag_name,$tag) }}>{!! $t->tag_name !!}</option>
                                    @endforeach
                                        @endif
                                </select>

                                @php
                                    }else{
                                @endphp

                                <select class="form-control tag-search" multiple="multiple" >
                                    @foreach($tags_list as $t)
                                        <option value="{{ $t['client_tag_name'] }}"  {{ getSelectedArr($t['client_tag_name'],$tag) }}>{{ $t['client_tag_name'] }}</option>
                                    @endforeach
                                </select>
                                @php
                                    }
                                @endphp
                            </div>
                            <div class="search-top search-icon"><i class="fa fa-search"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
