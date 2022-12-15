<div class="modal fade add_recipient funnel-selector" id="funnel-selector" data-action="off">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Funnel Selector</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="search-box">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div id="search__wrapper">
                                    <input type="text" class="form-control search-control" name="search" id="search" placeholder="Search for a desired Funnel URL...">
                                    <button class="search-btn"><i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="all-funnel">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="all">
                                <input type="checkbox"  id="all-funnel-checkbox" name="all" />
                                <label  for="all-funnel-checkbox"><span></span>Select All Funnels</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="reset">
                                <a href="#" id="reset"><i class="fa fa-rotate-left"></i>Reset</a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="funnel_select_count" id="funnel_select_count">
                </div>
                @php

                /*
                 * Note: if a vertical don't have stock funnels, it should not in pop up for selection of funnels.
                 * $arr_of_veriticals_have_SF  array is use to check the verticals have stock funnels.
                 * */

                $arr_of_veriticals_have_SF = array();
                foreach (LP_Helper::getInstance()->funnel_type_list() as $nvertical_id => $nvertical){
                    array_push($arr_of_veriticals_have_SF,$nvertical_id);
                }

                foreach (LP_Helper::getInstance()->getVerticals() as $vertical_id => $vertical){

                    if(!in_array($vertical_id,$arr_of_veriticals_have_SF)){
                        continue;
                    }

                    $selected = "";
                    if($vertical_id==@$view->session->clientInfo->client_type){
                        $selected = "active";
                    }

                    $funnels = LP_Helper::getInstance()->getFunnels();
                    $group_ids = $funnels[$vertical_id];
                    @endphp
                    <div class="funnel-group" data-sub-group="{{ strtolower(str_replace(" ","-",$vertical)) }}">
                        <div class="funnel-head">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="all-mortgage">
                                        <input type="checkbox" class="sub-group"  id="{{ strtolower(str_replace(" ","-",$vertical)) }}" data-key="{{ strtolower(str_replace(" ","-",$vertical)) }}" name="{{ strtolower(str_replace(" ","-",$vertical)) }}" />
                                        <label  for="{{ strtolower(str_replace(" ","-",$vertical)) }}"><span></span>All {{ $vertical }} Funnels</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="funnel-caret">
                                        <a data-toggle="collapse" href="#grf{{ strtolower(str_replace(" ","-",$vertical)) }}"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="grf{{ strtolower(str_replace(" ","-",$vertical)) }}" class="panel-collapse collapse">
                            <div class="funnel-scroll mCustomScrollbar funnel-height">
                                <div class="funnel-body">
                                    @php

                                    foreach($group_ids as $group_id=>$group_item){
                                        foreach($group_item as $sv_id=>$sub_verticals){
                                            $subvertical="";
                                            $fs_subvertical="";
                                            foreach ($sub_verticals as $funnel){
                                                if ( $funnel['funnel_market'] == 'w' ) {
                                                    continue;
                                                }
                                                if($subvertical!=$funnel["lead_pop_vertical_sub"]){
                                                    ## $subvertical = $funnel["lead_pop_vertical_sub"];
	                                                ## $subvertical = implode(' ',array_unique(explode(' ', str_replace(array("Loans"), array(""), LP_Helper::getInstance()->getGroupName($group_id))." ".LP_Helper::getInstance()->getSubVerticalName($sv_id) )));
                                                    $subvertical = $funnel['display_label'];
	                                                $fs_subvertical = $funnel['fs_display_label'];
	                                                }
                                                $fkey =  $funnel['leadpop_vertical_id']."~".$funnel['leadpop_vertical_sub_id']."~".$funnel['leadpop_id']."~".$funnel['leadpop_version_seq'];
                                                $zkey =  $funnel['leadpop_id']."~".$funnel['leadpop_vertical_id']."~".$funnel['leadpop_vertical_sub_id']."~".$funnel['leadpop_template_id']."~".$funnel['leadpop_version_id']."~".$funnel['leadpop_version_seq']."~".strtolower($funnel['domain_name']);
                                                $filed_ref="gfunnel".$funnel['client_leadpop_id'];
                                            @endphp
                                            <!-- Domain Item -->
                                            <div class="item gfunnel{{  $funnel['domain_id'] }}">
                                                <input type="checkbox" data-value="{{  strtolower($funnel['domain_name']) }}"
                                                       class="{{  strtolower(str_replace(" ","-",$vertical)) }}
                                                            {{  strtolower(str_replace(" ","-",$subvertical)) }}
                                                            domain_{{ $funnel['domain_id'] }}
                                                            {{  ($funnel["funnel_market"] == "w" ? "website " : "").$funnel["funnel_market"]."_".strtolower(str_replace(" ","-",$subvertical)) }}"
                                                       id="{{  $filed_ref }}" name="domains[]"
                                                       data-domainid="{{  strtolower($funnel['domain_id']) }}"
                                                       value="{{  strtolower($funnel['domain_id']) }}"
                                                       data-fkey="{{  $fkey }}"
                                                       data-zkey="{{  $zkey }}" />
                                                <label for="{{  $filed_ref }}"><span></span><strong>{{  $fs_subvertical }}</strong></label>
                                                <label class="pull-right" for="{{  $filed_ref }}">{{  strtolower($funnel['domain_name']) }}</label>
                                            </div>
                                            @php
                                                }
                                        }
                                    }
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                }
                    $website_funnels = array();
                    foreach (LP_Helper::getInstance()->getFunnels() as $vertical_id => $groups) {
                        foreach ( $groups as $group_id => $group_item ) {
                            foreach ( $group_item as $sub_verticals ) {
                                $subvertical = "";
                                foreach ( $sub_verticals as $funnel ) {
                                    if ( $funnel['funnel_market'] == 'w' ) {
                                        $website_funnels[] = $funnel;
                                    }
                                }
                            }
                        }
                    }
                    if( LP_Helper::getInstance()->checkHaveWebsiteFunnels() == true && !empty($website_funnels) ){
                    @endphp
                    <div class="funnel-group" data-sub-group="website">
                        <div class="funnel-head">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="all-mortgage">
                                        <input type="checkbox" class="sub-group"  id="website" data-key="website" name="website" />
                                        <label for="website"><span></span>All Website Funnels</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="funnel-caret">
                                        <a data-toggle="collapse" href="#grfwebsite"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="grfwebsite" class="panel-collapse collapse">
                            <div class="funnel-scroll mCustomScrollbar funnel-height">
                                <div class="funnel-body">
    					            @php
                                    $subvertical = "";
                                    foreach($website_funnels as $funnel) {
                                        if ( $subvertical != $funnel["lead_pop_vertical_sub"] ) {
                                            $subvertical = $funnel["lead_pop_vertical_sub"];
                                            $subvertical_market_class = "w_" . strtolower( $subvertical );
	                                        $fs_subvertical = $funnel['funnel_name'];
                                        }
                                        $fkey      = $funnel['leadpop_vertical_id'] . "~" . $funnel['leadpop_vertical_sub_id'] . "~" . $funnel['leadpop_id'] . "~" . $funnel['leadpop_version_seq'];
                                        $zkey      = $funnel['leadpop_id'] . "~" . $funnel['leadpop_vertical_id'] . "~" . $funnel['leadpop_vertical_sub_id'] . "~" . $funnel['leadpop_template_id'] . "~" . $funnel['leadpop_version_id'] . "~" . $funnel['leadpop_version_seq'] . "~" . strtolower( $funnel['domain_name'] );
                                        $filed_ref = "wfunnel" . $funnel['client_leadpop_id'];
                                        @endphp
                                        <!-- Domain Item -->
                                        <div class="item wfunnel{{  $funnel['domain_id'] }}">
                                            <input type="checkbox" data-value="{{  strtolower( $funnel['domain_name'] ) }}"
                                                   class="website
                                                       {{  strtolower( str_replace( " ", "-", $subvertical ) ) }}
                                                       {{  strtolower( str_replace( " ", "-", $subvertical_market_class ) ) }}
                                                       domain_{{ $funnel['domain_id'] }}"
                                                   id="{{  $filed_ref }}" name="domains[]"
                                                   data-domainid="{{  strtolower( $funnel['domain_id'] ) }}" value="{{  strtolower( $funnel['domain_id'] ) }}" data-fkey="{{  $fkey }}"
                                                   data-zkey="{{  $zkey }}"/>
                                            <label for="{{  $filed_ref }}"><span></span><strong>{{ $funnel['funnel_name'] }}</strong></label>
                                            <label class="pull-right" for="{{  $filed_ref }}">{{  strtolower($funnel['domain_name']) }}</label>
                                        </div>
                                        @php
                                    }
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                @php } @endphp
            </div>
            <div class="lp-modal-footer">
                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                <input type="submit" id="finish" class="btn lp-btn-add" value ="Finish">
                <input type="submit" id="zap_save_integrations" class="btn lp-btn-add" style="display: none;" value ="Save">
            </div>
        </div>
    </div>
</div>










<!--Select Funnel message modal-->
<div class="modal fade add_recipient home_popup" id="funnle_selector-lp-alert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Alert!</h3>
            </div>
            <div class="modal-body model-action-body">
                <form action="" method="post" id="add-code-popup" class="form-inline lp-popup-form">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="popup-wrapper modal-action-msg-wrap">
                                    <div class="funnel-message modal-msg">You Must Select a Funnel <br>Please select at least one Funnel.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-modal-footer footer-border">
                                <a data-dismiss="modal" class="btn lp-btn-cancel funnel_selector_alert_close">Close</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>












<!-- Preconfigured ZAP Templates -->
<div class="modal fade add_recipient home_popup" id="lp_zap_templates">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">leadPops Zap Templates</h3>
            </div>
            <div class="modal-body model-action-body">
                <form action="" method="post" id="add-code-popup" class="form-inline lp-popup-form">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-md-12">
                                <script type="text/javascript" src="https://zapier.com/apps/embed/widget.js?services=leadpops&limit=15"></script>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-modal-footer footer-border">
                                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
