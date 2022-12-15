@php

    $tags_list = tag_list();
   //Funnels Stats filter @mzac90
    $filter_search = @$view->session->tag_filter;
    $excludeVisitor = (isset($filter_search->excludeVisitor) and $filter_search->excludeVisitor == "true")?1:0;
    $filterFunnelVisitor = (isset($filter_search->filterFunnelVisitor))?$filter_search->filterFunnelVisitor:config('lp.funnel_visitor');
    $excludeConversionRate = (isset($filter_search->excludeConversionRate) and $filter_search->excludeConversionRate == "true")?1:0;
    $filterConversionRate = (isset($filter_search->filterConversionRate) and $view->session->tag_filter->filterConversionRate !== 'undefined')?$filter_search->filterConversionRate:config('lp.conversion_rate');

    $video_info= isset($view->data->globalVideos['global-index']) ? $view->data->globalVideos['global-index'] : null;
    $videolink = @$video_info->url;
    $videotitle = @$video_info->title;
    $videothumbnail = @$video_info->thumbnail;
    $wistia_id = @$video_info->wistia_id;
    if(((@$videolink) && @$videolink) || ((@$wistia_id) && @$wistia_id)){
         if((@$videotitle) && @$videotitle) {
             $wistitle=@$videotitle;
         }
     $wisid=@$wistia_id;
    }
@endphp


<!-- funnel list pop-->
<div class="modal fade global-setting-pop global-setting-pop-funnel" data-backdrop="static" id="global-setting-funnel-list-pop">
    <div class="modal-dialog modal-extra__dailog" role="document">
        <div class="modal-content">
            <div class="modal-header main-setting" data-global-setting>
                <div class="modal__head-col">
                    <h5 class="modal-title">Global Settings
                        <span class="question-mark el-tooltip" title="<p class='global-tooltip text-left font-medium'>Global Settings allows you to make changes across multiple Funnels.<br/>Keep in mind that while Global Settings mode is on, all the changes you make <br/>on the current Funnel will be applied to all selected Funnels. </p>"><span class="ico ico-question"></span></span>
                    </h5>
                </div>
                <div class="modal__head-col">
                    <ul class="global-setting-list">
                        <li class="global-setting-list__li">
                            <a data-lp-wistia-title="{{$wistitle}}" data-lp-wistia-key="{{$wisid}}" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-dismiss="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                WATCH HOW-TO VIDEO
                            </a>
                        </li>
                        <li class="global-setting-list__li">
                            <div class="switcher-min">
                                <input   id="global_mode_bar" name="global_mode_bar"
                                       data-toggle="toggle min"
                                       data-route="{{$currentRoute}}"
                                       class="global_mode_chkbox"
                                       data-onstyle="active" data-offstyle="inactive"
                                       data-width="92" data-height="28" data-on="INACTIVE"
                                       data-off="ACTIVE" type="checkbox">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-header" data-funnel-builder style="display: none;">
                <div class="modal__head-col">
                    <h5 class="modal-title">Select a Funnel for the CTA Button to Point to
                        <span class="question-mark el-tooltip" title="<p class='global-tooltip text-left font-medium'>Select a Funnel for the CTA Button to Point to</p>"><span class="ico ico-question"></span></span>
                    </h5>
                </div>
                <div class="modal__head-col">
                </div>
            </div>
            <div class="modal-header confimation-setting" style="display: none;">
                <div class="title__w-desc w-100">
                    <h5 class="modal-title">Confirm Global Settings Update
                        <span class="question-mark el-tooltip" title="<p class='global-tooltip'>Confrimation Tooltip</p>">
                        <span class="ico ico-question"></span></span>
                    </h5>
                    <P>Confirm you'd like to update the settings of these Funnels.</P>
                </div>
            </div>
            <div class="modal-body quick-scroll"  id="funnel-selection-modal-body">
                <div class="modal-body-wrap">
                    <div class="funnel-search main-setting">
                        <div class="funnel-search__category">
                            <div class="funnel-search-global-parent">
                                <select name="funnel-search__by" id="funnel-search__by">
                                    <option value="n">Search by Funnel Name</option>
                                    <option value="t">Search by Funnel Tags</option>
                                </select>
                            </div>
                        </div>
                        <div class="funnel-search__input">
                            <div class="funnel-search__input-name" id="global-funnel-search-by-name">
                                <div class="input__wrapper modal__funnel-search m-0">
                                    <input class="form-control search-bar" id="modal-search-bar"
                                           placeholder="Type in the Funnel Name ..." type="text">
                                    <span class="search" id="searchIcon"><i class="ico ico-search"></i></span>
                                </div>
                            </div>
                            <div class="funnel-search__input-tag" id="global-funnel-search-by-tag">
                                <div class="input__holder lp-tag modal__funnel-search m-0">
                                    <div class="select2js__tags-parent tag-result-common tag-result-pop w-100">
                                        <select class="form-control tag-drop-down-pop" multiple name="tag_list-pop"
                                                id="tag_list-pop">
                                            {{--<option value="1">203k</option>
                                            <option value="2">leadPops</option>--}}
                                            @if($tags_list)
                                                @foreach($tags_list as $t)

                                                    <option value="{!! $t->tag_name !!}">{!! $t->tag_name !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <span class="search" id="searchIcon-tag"><i class="ico ico-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="funnel__wrapper">
                    <div class="selection-setting main-setting" data-global-setting>
                        <div class="checkbox">
                            <input type="checkbox" id="selectAllFunnelSelectionModal" name="funnelName" value="">
                            <label class="funnel-label" for="selectAllFunnelSelectionModal"></label>
                            <span class="text">Select all Funnels</span>
                        </div>
                        <a href="#" class="reset" id="resetGlobalFunnels"><i class="ico ico-undo"></i>Reset</a>
                        <span class="funnel-no-text">Total Funnels Selected: <span class="no"  id="global_all_selected"></span></span>
                    </div>
                    <div class="accordion" id="funnelsExample">
                        {{--
                            Folders and Funnels added dynamically
                        --}}
                    </div>
                    <div class="empty-result">
                        <span class="empty-result__icon ico ico-search"></span>
                        <p class="empty-result__p">No results were found for this search. Try something else.</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer" data-global-setting>
                <div class="action">
                    <ul class="action__list confimation-setting" style="display: none;">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel"
                                    onclick="setglobalConfirmationCurrentFormToDefault()" data-dismiss="modal">No, Never Mind
                            </button>
                        </li>
                        <li class="action__item">
                            <button type="button" onclick="submitGlobalForm()"
                                    class="button button-bold button-primary">yes, update funnels
                            </button>
                        </li>
                    </ul>
                    <ul class="action__list main-setting">
                        <li class="action__item">
                            <button type="button" id="funnelSelectionCloseBtn" class="button button-bold button-cancel" data-dismiss="modal">Close
                            </button>
                        </li>
                        <li class="action__item">
                            <button type="button" id="funnelSelectionFinish" class="button button-bold button-primary">
                                SAVE &amp; CONTINUE
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer" data-funnel-builder style="display:none;">
                <div class="action">
                    <ul class="action__list main-setting">
                        <li class="action__item">
                            {{--<div class="open-url-checkbox">
                                <label for="funnel-lightbox" class="fb-checkbox__label">
                                    <div class="fb-checkbox__box">
                                        <div class="fb-checkbox__inner-box"></div>
                                    </div>
                                    <div class="fb-checkbox__caption">
                                        Open Funnel in lightbox <span class="question-mark el-tooltip" title="Tooltip here!"><span class="ico ico-question"></span></span>

                                    </div>
                                </label>
                                <input class="fb-checkbox__input" type="checkbox" id="funnel-lightbox">
                            </div>--}}
                            <div class="open-funnel-checkbox">
                                <div class="checkbox-wrap">
                                    <input class="fb-checkbox__input" type="checkbox" id="funnel-lightbox">
                                    <label for="funnel-lightbox" class="fb-checkbox__label">
                                        <div class="fb-checkbox__caption">
                                            Open Funnel in lightbox
                                        </div>
                                    </label>
                                </div>
                                <span class="question-mark el-tooltip" title="Tooltip here!"><span class="ico ico-question"></span></span>
                            </div>
                        </li>
                        <li class="action__item">
                            <button type="button" id="funnelSelectionCloseBtn" class="button button-bold button-cancel" data-dismiss="modal">Close
                            </button>
                        </li>
                        <li class="action__item">
                            <button type="button" id="funnelBuilderSelection" class="button button-bold button-primary" disabled>
                                SELECT
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- conversion rate pop-->
<div class="modal fade conversion-setting" data-backdrop="static" id="conversion-setting">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <div class="title__w-desc w-100">
                    <h5 class="modal-title text-gray">Conversion Rate Settings</h5>
                </div>
            </div>
            <div class="modal-body p-0 quick-scroll">
                <ul class="list-funnels">
                    <li class="list-funnels__item">
                        <div class="list-funnels__item__wrap">
                            <div class="checkbox">
                                <input type="checkbox" id="conversionRate" name="conversionRate" value="" {{($excludeConversionRate ==1)?"checked":""}}>
                                <label class="funnel-label" for="conversionRate"></label>
                            </div>
                            <span class="text">
                                Exclude Funnels with a conversion rate higher than <span class="input-holder"><input type="text" class="form-control" id="filter_conversion_rate"  value="{{$filterConversionRate}}"></span> %
                                <span class="question-mark el-tooltip" title="<p class='global-tooltip text-left font-medium'>Usually, a conversion rate of 60%+ means you <br >opened the Funnel yourself to view it and test it by <br >putting in a test lead.</p><p class='global-tooltip text-left font-medium'>In some cases, clients test multiple times... so your <br >conversion rate might be something like 50% or 75%, <br >which is also not data we want to factor into the <br >conversion rate calculation.</p><p class='global-tooltip text-left font-medium'>In order to help keep your stats as accurate as <br >possible, we recommend not including Funnels that <br >you're not really using in marketing and have <br >only tested. </p>"><span class="ico ico-question"></span></span>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal" data-value="{{$filterConversionRate}}" data-status="{{$excludeConversionRate}}">Close</button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-bold button-primary" onclick="conversionRate(true);">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- total funnnels pop-->
<div class="modal fade conversion-setting" data-backdrop="static" id="total-funnels-setting">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <div class="title__w-desc w-100">
                    <h5 class="modal-title text-gray">Total Funnels Settings</h5>
                </div>
            </div>
            <div class="modal-body p-0 quick-scroll">
                <ul class="list-funnels">
                    <li class="list-funnels__item">
                        <div class="list-funnels__item__wrap">
                            <div class="checkbox">
                                <input type="checkbox" id="exclude_visitor" name="testLead" value="" {{($excludeVisitor ==1)?"checked":""}}>
                                <label class="funnel-label" for="exclude_visitor"></label>
                            </div>
                            <span class="text">
                                Hide Funnels that aren't "Live" with less than <span class="input-holder"><input type="text" class="form-control" id="filter_funnel_visitor" value="{{$filterFunnelVisitor}}"></span>visitors
                                <span class="question-mark el-tooltip" title="<p class='global-tooltip text-left font-medium'>Usually, less than 5 visitors means you're not really <br >using the Funnel and may have viewed it yourself <br >when customizing.</p><p class='global-tooltip text-left
                                font-medium'>In order to keep your Funnels Dashboard focused<br> on just your &ldquo;Live&rdquo; Funnels, we recommend checking<br> this box to hide the Funnels you're not using.</p>"><span class="ico ico-question"></span></span>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal" data-value="{{$filterFunnelVisitor}}" data-status="{{$excludeVisitor}}">Close</button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-bold button-primary" onclick="_search();">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- email fire Modal -->
<div class="modal fade email_fire_popup" data-backdrop="static" id="email_fire_popup">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Fire Dashboard Login</h5>
            </div>
            <form  target="_blank" name="goemma" id="goemma" action="https://app.e2ma.net/app2/login/" method="post" class="login-wrapper">
                <div class="form-group login-border">
                    <div class="login-lable">
                        <label class="control-label" for="email">Email Address</label>
                    </div>
                    <div class="">
                        <input type="email" name="username" class="form-control fire-control" id="emmaUsername" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="login-lable">
                        <label class="control-label" for="password">Password</label>
                    </div>
                    <div class="">
                        <input type="password" autocomplete="off" rel="" class="form-control fire-control" id="emmaPass" name="password" required>
                    </div>
                </div>
                <!--data-toggle="modal" data-target="#email-forgot"-->
                <div class="forgot"><a href="https://app.e2ma.net/app2/login/" id="emma-forgot-password" target="_blank">Forgot Password ?</a></div>
                <div class="lp-modal-footer footer-border text-center">
                    <a data-dismiss="modal" class="btn lp-btn-cancel" id="modal-close">Close</a>
                    <!-- <a id="edit_rcpt" class="btn lp-btn-add" href="#">sign in</a>-->
                    <input type="submit" class="btn lp-btn-add" value ="Sign in">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal emails -->
<div id="emailfire" class="modal fade lp-modal-box in" data-backdrop="static">
    <div class="modal-dialog modal-dialog--email modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Email Fire</h3>
            </div>
            <div class="modal-body model-action-body text-center">
                <div class="modal-email">
                    <span class="ico ico-fire"></span>
                    <p>We'd love to talk to you about Email Fire.</p>
                    <a href="https://book-demo.leadpops.com" target="_blank" class="button button-primary">click here to
                        schedule a call with us</a>
                </div>
            </div>
            <div class="modal-footer lp-modal-action-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Model Boxes - Delete short url - End -->

<div class="modal fade add_recipient home_popup" data-backdrop="static" id="deleteSlugName" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Delete Short URL</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="popup-wrapper modal-action-msg-wrap">
                                <div class="funnel-message modal-msg modal-msg_mb-0">
                                    Are you sure you want to delete your Short Link?
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">
                                Never Mind
                            </button>

                        </li>
                        <li class="action__item">
                            <button id="doDeletePopUpBtn" class="button button-bold button-primary" type="button">
                                Delete
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--create funnel question modal-->
<div class="modal fade create-funnel" id="create-funnel" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content create-new-funnel funnel-tag-result">
            <form id="create-funnel-pop" class="form-pop" action="{{route('create-funnel')}}" method="post">
                {{csrf_field()}}
                <div class="modal-header">
                    <h5 class="modal-title">Create New Funnel</h5>
                </div>
                <div class="modal-body quick-scroll-holder">
                    <div class="form-group">
                        <label for="funnel_name" class="modal-lbl">New Funnel Name</label>
                        <div class="input__holder">
                            <input id="funnel_name" name="funnel_name" class="form-control create-new-funnel-validate" type="text" placeholder="Enter the Funnel Name" autocomplete="off" tabindex="1" onkeyup="createFunnelButtonEnable()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tag_list" class="modal-lbl">Funnel Tag(s)</label>
                        <div class="input__holder lp-tag lp-tag-scroll quick-scroll">
                            <div class="select2js__tags-parent tag-result-common w-100">
                                <select id="create_funnel_tag_list" class="form-control create_funnel_tag_list" multiple name="tag_list[]" tabindex="2">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="folder" class="modal-lbl">Folder</label>
                        <div class="input__holder">
                            <div class="lp-custom-select">
                                <a href="#" class="lp-custom-select__opener">Select Folder</a>
                                <div class="lp-custom-select-slide">
                                    <div class="lp-custom-select-slide__wrap">
                                        <input type="hidden" id="create_funnel_folder_id" class="create-new-funnel-validate" name="create_funnel_folder_id">
                                        <div class="quick-scroll">
                                            <ul class="lp-custom-select__list">
                                                <li class="lp-custom-select__list__item" data-id="0" disabled>select folder</li>
                                                @php
                                                    $folders = folder_list();
                                                    foreach ($folders as $i => $folder) {
                                                @endphp
                                                <li class="lp-custom-select__list__item" data-id="{{ $folder->id }}">{{ $folder->folder_name }}</li>
                                                @php
                                                    }
                                                @endphp
                                            </ul>
                                        </div>
                                        <div class="new-tags-holder">
                                            <a href="#" class="new-tags-opener"><i class="ico ico-plus"></i>Add New folder</a>
                                            <div class="new-tag-field">
                                                <input type="text" id="new_folder" value="" placeholder="Type in Funnel Folder...">
                                                <ul class="tags-action-list">
                                                    <li><a href="#" class="lp-add-custom-tag"><i class="ico ico-check"></i></a></li>
                                                    <li><a href="#" class="lp-close-custom-tag"><i class="ico ico-cross"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" id="btn-cancel-funnel-pop" class="button button-bold button-cancel" data-dismiss="modal">Cancel</button>
                            </li>
                            <li class="action__item">
                                <button type="submit" class="button button-bold button-primary" disabled>Next</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Exit Alert modal -->
<div class="modal fade exit-alert-modal" id="exit-alert-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exit Confirmation</h5>
            </div>
            <div class="modal-body">
                <p class="modal-msg">
                    You are about to leave this section. Any unsaved changes will be permanently lost.
                </p>
                <p class="modal-msg">
                    Do you want to save your changes?
                </p>
                <div class="checkbox-area">
                    <label class="checkbox-wrap">
                        <input type="checkbox">
                        <span class="checkbox-text"><i class="check-icon"></i> Don't show this message again</span>
                    </label>
                    <span class="question-mark el-tooltip" title="Tooltip Content">
                        <span class="ico ico-question"></span>
                    </span>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">cancel</button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-bold button-primary">yes</button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-bold button-primary">no</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>