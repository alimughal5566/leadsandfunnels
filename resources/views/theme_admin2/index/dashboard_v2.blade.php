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

    if($view->session->clientInfo->dashboard_v2 == 1){
        $arr = LP_Helper::getInstance()->funnel_type_list();
        $funnel_type_name = $funnelTypes['f'];
        $filter_search = $view->session->tag_filter;
        $sort = 3;
        $sort_name = 'Funnel Name';
        $asc = 'active';
        $desc = 'inactive';

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
    @endphp
    <section id="main-content">

        <div id="funnels-section" class="Mortgage funnels-section_v2">
            <input type="hidden" id="is_lite_package" value="{{@$view->session->clientInfo->is_lite}}">
            <input type="hidden" id="is_lite_funnels" value="{{@$view->session->clientInfo->lite_funnels}}">
            <div class="funnels vertical_container active">
                <div class="container">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="section-title-wrapper">
                                <h2 class="section-title"> {{$funnel_type_name}}</h2>
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
                                    <div class="col-sm-8 text-right">
                                    <span class="qa-select-menu">
                                        <span class="dropdown-label">Sort By</span>
                                        <div class="dropdown qa-dd qa-dropdown dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-value="{{$sort}}">
                                            <span class="firstLabel qaLabel sort"><span class="qaText"><span>{{$sort_name}}</span></span> <span class="caret"></span></span>
                                            <ul class="qa-list dropdown-list">
                                                <li data-slug="creation-date" data-value="1"><span>Creation Date</span></li>
                                                 <li data-slug="conversion-rate" data-value="8"><span>Conversion Rate</span></li>
                                                <!--                                                <li data-slug="domain-name" data-value="2"><span>Domain Name</span></li>-->
                                                <li data-slug="funnel-name" data-value="3" class="active"><span>Funnel Name</span></li>
                                                <li data-slug="funnel-tags" data-value="9"> <span>Funnel Tags</span></li>
                                                <li data-slug="last-edit" data-value="4"><span>Last Edit</span></li>
                                                <li data-slug="last-submission" data-value="5"><span>Last Submission</span></li>
                                                <li data-slug="number-leads" data-value="6"><span>Number of Leads</span></li>
                                                <li data-slug="number-visitors" data-value="7"><span>Number of Visitors</span></li>

                                            </ul>

                                        </div>
                                    </span>
                                        <ul class="nav navbar-nav za-sort">
                                            <li><a href="#sort_by" class="sort-by {{$asc}}" data-sort="asc"><i class="fa fa-chevron-up" aria-hidden="true"></i></a></li>
                                            <li><a href="#sort_by" class="sort-by {{$desc}}" data-sort="desc"><i class="fa fa-chevron-down" aria-hidden="true"></i></a></li>
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
                    </div>

                </div>
            </div>
            <input type="hidden" id="s-url" value='{{json_encode($s_url)}}'>
        </div>
        <img src="{{LP_ASSETS_PATH}}/adminimages/icons/css_sprites.png" class="hide-sprite">
        @include('partials.watch_video_popup')
    </section>

    @php
    }else {
    @endphp
    <section id="main-content">

        <div id="funnels-section" class="Mortgage">
            <input type="hidden" id="is_lite_package" value="<?php echo @$this->session->clientInfo->is_lite?>">
            <?php
            // $current_hash = LP_Helper::getInstance()->getCurrentHash();

            //debug(LP_Helper::getInstance()->getCurrentHashData($current_hash));
            $i = 1;
            $index = 0;
            foreach (LP_Helper::getInstance()->getVerticals() as $vertical_id => $vertical){
            $selected = "";

            if($vertical_id == LP_Helper::getInstance()->clientTypeOrLandingPages()){
                $selected = "active";
            };
            if($vertical_id ==LP_Constants::VERTICAL_ID_FOR_LANDING_PAGES){$lable='';}else {$lable='Funnels';}
            ?>
            <div class="<?php echo str_replace(' ','-', strtolower($vertical)); ?>-funnels vertical_container <?php echo ($vertical_id == LP_Constants::VERTICAL_ID_FOR_LANDING_PAGES ? "product_landingpages" : "product_funnels"); ?> <?php echo $selected; ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="section-title-wrapper">
                                <h2 class="section-title"><?php echo $vertical; ?> <?php echo $lable;?> </h2>
                                <div class="funnel-status">
                                    <span class="traffic">Traffic</span>
                                    <span class="newLeads lp-leads">New Leads</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    #debug($vertical_id,'',0);
                    #debug(LP_Helper::getInstance()->getFunnelsByVertical($vertical_id));

                    foreach (LP_Helper::getInstance()->getFunnelsByVertical($vertical_id) as $group_id => $group_item){
                    ?>
                    <div class="funnels-details" data-funnel-row="<?php echo "funnel_row_group_$group_id"; ?>">
                        <div class="row">
                            <div class="funnels-header">
                                <div class="col-sm-4">
                                    <h2 class="funnels-header-title">
                                        <?php echo LP_Helper::getInstance()->getGroupName($group_id); ?>: <span><?php echo @LP_Helper::getInstance()->getGroupCount($group_id)?></span>
                                    </h2>
                                </div>
                                <div class="col-sm-8 text-right">
                                    <span class="qa-select-menu">
                                        <span class="dropdown-label">Q&A Version</span>
                                        <div class="dropdown qa-dd qa-dropdown dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="firstLabel qaLabel"><span class="qaText"><span>All</span></span> <span class="caret"></span></span>
                                            <input type="hidden" name="qa-dropdown">
                                            <ul class="qa-list dropdown-list">
                                                <li data-slug="all" data-value="1" class="active"><span>All</span></li>
                                                <?php
                                                $tmp = array();

                                                foreach ($group_item as $sv_id=>$funnel_item){
                                                    if(!in_array(LP_Helper::getInstance()->getSubVerticalName($sv_id), $tmp)){
                                                        array_push($tmp, LP_Helper::getInstance()->getSubVerticalName($sv_id));
                                                        echo "<li data-slug=\"".LP_Helper::getInstance()->getSubVerticalSlug($sv_id)."\" data-value=\"".$sv_id."\" ><span>".LP_Helper::getInstance()->getSubVerticalName($sv_id)."</span></li>";
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="funnels-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h2 class="funnels-titles">Funnel URL</h2>
                                </div>
                                <div class="col-sm-6">
                                    <h2 class="funnels-titles text-right">Q&A Version</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="funnels-list">
                                        <ul>
                                            <?php
                                            $disable_is_lite_class="";
                                            $count_disable_is_lite="";
                                            foreach($group_item as $sv_id=>$sub_verticals){
                                            /* if  User Have Lite Package*/
                                            if(@$this->session->clientInfo->is_lite=='1'){
                                            if(!in_array($sv_id,$lite_funnels)){
                                            $disable_is_lite_class="disable_lite_package";
                                            /*For Count of Disable Funnels in Light package*/
                                            $count_disable_is_lite="count_disable_is_lite";
                                            }
                                            }
                                            /* End if  User Have Lite Package*/
                                            $v_slug = LP_Helper::getInstance()->getSubVerticalSlug($sv_id);
                                            if(@$_COOKIE['sdebug'] == '1'){
                                            echo "<pre>" . print_r($sub_verticals) . "</pre>";
                                            exit;
                                            }
                                            foreach ($sub_verticals as $funnel){
                                            //                                                        echo '<pre>';
//                                                        print_r($funnel);
//                                                        die;
                                                        if(!empty($funnel['sticky_url'])){
                                                            $s_url[$funnel['sticky_url']] = $funnel['sticky_funnel_url'];
                                                        }
                                                        if($funnel['leadpop_vertical_id'] == $this->session->clientInfo->client_type){
                                                            $ft_slug = $funnel["funnel_type"];
                                                        } else {
                                                            if($funnel["funnel_type"] == 'w') $ft_slug = "f modified_from_w";
                                                            else $ft_slug = $funnel["funnel_type"];
                                                        }

                                                        $sticky_id = $sticky_status = $sticky_js_file = $sticky_funnel_url = $sticky_url = $sticky_button = $sticky_cta = $sticky_bar = "";
                                                        $pending_flag = 0;
                                                        $funnel_sticky_status = '';
                                                        $sticky_script_type = 'a';
                                                        $sticky_page_path = '/';
                                                        $sticky_website_flag = 0;
                                                        $stickybar_number_flag = 0;
                                                        $stickybar_number = '';
                                                        if(!empty($funnel['sticky_id'])){
                                                            $sticky_bar = 'sticky-bar-inactive';
                                                            if($funnel['sticky_status'] != 0){
                                                                $sticky_bar = 'sticky-bar-active';
                                                            }
                                                            $sticky_id = $funnel['sticky_id'];
                                                            $sticky_cta = $funnel['sticky_cta'];
                                                            $sticky_button = $funnel['sticky_button'];
                                                            $sticky_url = $funnel['sticky_url'];
                                                            $sticky_funnel_url = $funnel['sticky_funnel_url'];
                                                            $sticky_js_file = $funnel['sticky_js_file'];
                                                            $sticky_status = $funnel['sticky_status'];
                                                            $pending_flag = $funnel['pending_flag'];
                                                            $show_cta = $funnel['show_cta'];
                                                            $sticky_size = $funnel['sticky_size'];

                                                            $sticky_updated = $funnel['sticky_updated'];
                                                            $sticky_script_type = $funnel['sticky_script_type'];

                                                            $sticky_zindex = $funnel['zindex'];
                                                            $sticky_zindex_type = $funnel['zindex_type'];
                                                            $stickybar_number = $funnel['stickybar_number'];
                                                            $stickybar_number_flag = $funnel['stickybar_number_flag'];
                                                            if($sticky_updated){
                                                                if($sticky_status==0){
                                                                    $funnel_sticky_status = '(Inactive)';
                                                                }else if($pending_flag == 0){
                                                                    $funnel_sticky_status = '(Pending Installation)';
                                                                }else{
                                                                    $funnel_sticky_status = '(Active)';
                                                                }
                                                            }

                                                            $sticky_page_path = $funnel['sticky_url_pathname'];
                                                            $sticky_website_flag = $funnel['sticky_website_flag'];
                                                        }

                                                        $_leads = $_traffic = "";
                                                        if($funnel['new_leads']!=0 || $funnel['new_leads']!=''){
                                                            $_leads = " _newLeads ";
                                                            $_traffic = " _traffic ";
                                                        }

                                                        if($funnel['visits_month']!=0 || $funnel['visits_month']!=''){
                                                            $_traffic = " _traffic ";
                                                        }

                                                        ?>
                                                <?php
                                                $domain_name=strtolower($funnel['domain_name']);
                                                $pos = strpos($domain_name, "temporary");
                                                $fun_show_hide="show";
                                                if ($pos !== false) {
                                                    $fun_show_hide="hide";
                                                    /*var_dump($domain_name);
                                                    exit;*/
                                                }
                                                ?>
                                                <li class="funnel-row <?php echo $v_slug; ?> <?php echo $ft_slug; ?> <?php echo $fun_show_hide; ?>  <?php echo $count_disable_is_lite?>">
                                                            <a class="f-expand <?php echo $_leads.$_traffic; ?> <?php echo $disable_is_lite_class?>">
                                                                <div class="row">
                                                                    <div class="col-sm-9">
                                                                        <h3 class="funnel-text funnel-url lp-funnel-url"><?php echo strtolower($funnel['domain_name']); ?></h3>
                                                                        <?php
                                                                        if($this->session->clientInfo->stickybar_flag===null || $this->session->clientInfo->stickybar_flag==1)
                                                                        {
                                                                        ?>
                                                                        <div id="sticky-bar-btn<?php echo $i;?>" class="sticky-bar-btn"
                                                                             data-index="<?php echo $index;?>"
                                                                             data-field="<?php echo $funnel['domain_name']; ?>"
                                                                             data-id="<?php echo $funnel['client_leadpop_id']; ?>"
                                                                             data-element_id = "sticky-bar-btn<?php echo $i++;?>"
                                                                             data-sticky_id = "<?php echo $sticky_id;?>"
                                                                             data-sticky_cta = "<?php echo $sticky_cta;?>"
                                                                             data-sticky_button = "<?php echo $sticky_button;?>"
                                                                             data-sticky_url = "<?php echo $sticky_url;?>"
                                                                             data-sticky_funnel_url = "<?php echo $sticky_funnel_url;?>"
                                                                             data-sticky_js_file = "<?php echo $sticky_js_file;?>"
                                                                             data-sticky_status = "<?php echo $sticky_status;?>"
                                                                             data-sticky_show_cta = "<?php echo $show_cta;?>"
                                                                             data-sticky_size = "<?php echo $sticky_size;?>"
                                                                             data-pending_flag = "<?php echo $pending_flag;?>"
                                                                             data-v_sticky_button = "<?php echo str_replace('###','\'' , $funnel['v_sticky_button'] );?>"
                                                                             data-v_sticky_cta = "<?php echo str_replace('###','\'' , $funnel['v_sticky_cta'] );?>"
                                                                             data-sticky_page_path = "<?php echo $sticky_page_path;?>"
                                                                             data-sticky_website_flag = "<?php echo $sticky_website_flag;?>"
                                                                             data-sticky_location = "<?php echo $funnel['sticky_location'];?>"
                                                                             data-sticky_script_type = "<?php echo $sticky_script_type;?>"
                                                                             data-sticky_zindex = "<?php echo $sticky_zindex;?>"
                                                                             data-sticky_zindex_type = "<?php echo $sticky_zindex_type;?>"
                                                                             data-sticky_phone_number = "<?php echo $stickybar_number;?>"
                                                                             data-sticky_phone_number_checked = "<?php echo $stickybar_number_flag;?>"
                                                                        >
                                                                                <i class="fa fa-thumb-tack lp-fa-thumb-tack"></i>Sticky Bar
                                                                                <span class="funnel-sticky-status"><?php echo $funnel_sticky_status;?></span>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <h3 class="funnel-text funnel-text_lead funnel-version text-right"><?php echo LP_Helper::getInstance()->getSubVerticalName($sv_id); ?></h3>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                    <?php
                                                    if(@$disable_is_lite_class==""){
                                                            ?>
                                                            <div class="f-detail">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="edit-menu-wrapper">
                                                                            <div class="funnels-menu">
                                                                                <ul class="edit-menu home-menu">
                                                                                    <li class="view"><a target="_blank" href="<?php echo LP_Helper::getInstance()->getFunnelUrl($funnel['domain_name']); ?>">View</a></li>
                                                                                    <li class="edit drop-menu"><a class="" href="javascript:void()"><span>Edit</span> <span class="caret"></span></a>
                                                                                        <ul class="drop-menu-down lp-version-2">
                                                                                            <?php
                                                                                            if($vertical_id==LP_Constants::VERTICAL_ID_FOR_LANDING_PAGES){
                                                                                            ?>
                                                                                            <li class="sub-drop-down"><span>Content</span>
                                                                                                    <ul class="sub-drop-menu-down">
                                                                                                        <div class="sub-menu-wrapper">
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/seo/".$funnel['hash']; ?>">SEO</a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/thankyou/".$funnel['hash']; ?>">Thank You</a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/autoresponder/".$funnel['hash']; ?>">Autoresponder</a></li>
                                                                                                        </div>
                                                                                                    </ul>
                                                                                                </li>
                                                                                            <?php
                                                                                            }else{
                                                                                            ?>
                                                                                            <li class="sub-drop-down"><span>Content</span>
                                                                                                    <ul class="sub-drop-menu-down">
                                                                                                        <div class="sub-menu-wrapper">
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/calltoaction/".$funnel['hash']; ?>">Call-to-Action</a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/footeroption/".$funnel['hash']; ?>">Footer <span style = 'font-weight: 700;font-size: 9px;font-style: italic;'>(new feature inside!)</span></a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/autoresponder/".$funnel['hash']; ?>">Autoresponder</a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/seo/".$funnel['hash']; ?>">SEO</a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/contact/".$funnel['hash']; ?>">Contact Info</a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/thankyou/".$funnel['hash']; ?>">Thank You</a></li>
                                                                                                        </div>
                                                                                                    </ul>
                                                                                                </li>
                                                                                                <li class="sub-drop-down"><span>Design</span>
                                                                                                    <ul class="sub-drop-menu-down">
                                                                                                        <div class="sub-menu-wrapper">
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/logo/".$funnel['hash']; ?>">Logo <span style = 'font-weight: 700;font-size: 9px;font-style: italic;'>(new feature inside!)</span></a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/background/".$funnel['hash']; ?>">Background</a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/featuredmedia/".$funnel['hash']; ?>">Featured Image</a></li>
                                                                                                        </div>
                                                                                                    </ul>
                                                                                                </li>
                                                                                                <li class="sub-drop-down"><span>Settings</span>
                                                                                                    <ul class="sub-drop-menu-down">
                                                                                                        <div class="sub-menu-wrapper">
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/domain/".$funnel['hash']; ?>">Domains</a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/pixels/".$funnel['hash']; ?>">Pixels</a></li>
                                                                                                            <li><a href="<?php echo LP_BASE_URL.LP_PATH."/popadmin/integration/".$funnel['hash']; ?>">Integrations</a></li>
                                                                                                        </div>
                                                                                                    </ul>
                                                                                                </li>

                                                                                            <?php
                                                                                            }
                                                                                            ?>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <li class="alerts"><a href="<?php echo LP_BASE_URL.LP_PATH."/account/contacts/".$funnel['hash']; ?>">Lead Alerts</a></li>
                                                                                    <li class="stats"><a href="#" class="statsPopupCta" data-hash="<?php echo $funnel['hash']; ?>">Stats</a></li>
                                                                                    <li class="my-leads"><a href="<?php echo LP_BASE_URL.LP_PATH."/myleads/index/".$funnel['hash']; ?>">My Leads</a></li>
                                                                                    <li class="status status-icon"><a class="funnelStatusBtn funnelstatus_<?php echo $funnel['domain_id']; ?>" href="#" data-status="<?php echo $funnel['leadpop_active']; ?>" data-leadpop_version_seq="<?php echo $funnel['leadpop_version_seq']; ?>" data-domain_id="<?php echo $funnel['domain_id']; ?>" data-leadpop_id="<?php echo $funnel['leadpop_id']; ?>" data-leadpop_version_id="<?php echo $funnel['leadpop_version_id']; ?>">Status</a></li>
                                                                                    <?php
                                                                                    /**
                                                                                     * Check if vertical ID is for RELP & clone flag is enabled.
                                                                                     */
                                                                                    if(LP_Helper::getInstance()->getCloneFlag()=='y' && $vertical_id !=LP_Constants::VERTICAL_ID_FOR_LANDING_PAGES){ ?>
                                                                                    <li class="clone"><a href="#" data-ctalink="<?php echo LP_BASE_URL.LP_PATH."/index/clonefunnel/".$funnel['hash']; ?>" data-subdomain="<?php echo LP_Helper::getInstance()->generateSubdDomain($funnel['subdomain_name']); ?>" data-top-domain="<?php echo $funnel['top_level_domain']; ?>" class="cloneFunnelSubdomainBtn <?=(@$this->session->clientInfo->is_lite == '1') ? 'disable_lite_package' : '';?>">Clone</a></li>
                                                                                    <?php
                                                                                    } else if(LP_Helper::getInstance()->getCloneFlag()=='n' && $vertical_id !=LP_Constants::VERTICAL_ID_FOR_LANDING_PAGES){
                                                                                    ?>
                                                                                    <li class="clone"><a href="#" class="cloneFunnelReqBtn">Clone</a></li>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                    <?php if(LP_Helper::getInstance()->getCloneFlag()=='y' && $funnel['leadpop_version_seq'] > 1){ ?>
                                                                                    <li class="right-btns"><a href="#" data-ctalink="<?php echo LP_BASE_URL.LP_PATH."/index/deletefunnel/".$funnel['hash']; ?>" class="funnel-btn delete-btn deleteFunnelBtn">Delete</a></li>
                                                                                    <?php } ?>
                                                                                    <div class="clearfix"></div>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row seven-cols">
                                                                    <div class="lead-wrapper">
                                                                        <div class="col-sm-1">
                                                                            <div class="leadbox">
                                                                                <span class="lead-title">New<span class="nl">Leads</span></span>
                                                                                <span class="count"><?php echo ($funnel['new_leads']) ? $funnel['new_leads'] : '-'; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <div class="leadbox">
                                                                                <span class="lead-title">Total<span class="nl">Leads</span></span>
                                                                                <span class="count"><?php echo ($funnel['total_leads']) ? $funnel['total_leads'] : '-'; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <div class="leadbox">
                                                                                <span class="lead-title">Visitors Since<span class="nl">Sunday</span></span>
                                                                                <span class="count"><?php echo ($funnel['visits_sunday']) ? $funnel['visits_sunday'] : '-'; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <div class="leadbox">
                                                                                <span class="lead-title">Visitors This<span class="nl">Month</span></span>
                                                                                <span class="count"><?php echo ($funnel['visits_month']) ? $funnel['visits_month'] : '-'; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <div class="leadbox">
                                                                                <span class="lead-title">Total<span class="nl">Visitors</span></span>
                                                                                <span class="count"><?php echo ($funnel['total_visits']) ? $funnel['total_visits'] : '-'; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <div class="leadbox last">
                                                                                <span class="lead-title">Conversion<span class="nl">Rate</span></span>
                                                                                <span class="count"><?php echo ($funnel['conversion_rate']) ? $funnel['conversion_rate'].'%' : '-'; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php }?>
                                                        </li>
                                            <?php
                                            $index++;
                                            }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            }
            ?>
            <input type="hidden" id="s-url" value='<?php echo json_encode($s_url);?>'>
        </div>
        <img src="<?php echo LP_ASSETS_PATH; ?>/adminimages/icons/css_sprites.png" class="hide-sprite">
        <?php
        //watch to video
        include_once(APPLICATION_PATH.'/modules/lp/layouts/scripts/partials/watch_video_popup.phtml');
        ?>
    </section>

    @php
    }
    @endphp
@endsection