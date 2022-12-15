@php
    use App\Constants\LP_Constants;
    $s_url = array();
    $funnel_url = LP_Helper::getInstance()->getClientFunnelUrl();
    foreach ($funnel_url as $fu){
        $s_url[$fu['sticky_url']] = $fu['sticky_funnel_url'];
    }
@endphp
<div class="bottom-bar inner header-menu">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="funnels-menu header-inner">
                    <ul class="edit-menu main-inner-menu">
                        @php
                        foreach (LP_Constants::getInnerMenusV2() as $slug=>$menu){
                        $active = "";
                        if(@$view->data->active_menu==$slug){
                        $active = " lp-menu-active";
                        }
                        echo "<li class='".$menu['class'].$active."'>".$menu['html']."</li>";
                        }
                        @endphp
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="s-url" value='{{ json_encode($s_url) }}'>