<!-- Funnel Builder Dashboard: reset to default -->
<div class="modal fade reset-default" id="reset-default-pop">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset to Default Provided Questions</h5>
            </div>
            <div class="modal-body">
                <p class="modal-msg modal-msg_light">
                    Are you sure you want to reset your Funnel questions back <br>
                    to the default provided questions?
                </p>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No,
                                Never Mind
                            </button>
                        </li>
                        <li class="action__item">
                            <button class="button button-bold button-primary" id="resetQuestionsToDefaultBtn"
                                    type="submit">Yes, Reset
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Partial Leads modal -->
<div class="modal fade partial-leads" id="partial-leads-pop">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Partial Leads</h5>
            </div>
            <div class="modal-body">
                <p class="modal-msg modal-msg_light">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit craseuise
                    mod efficitur tincidunt quis enim velit sed varius ante mi.
                </p>
                <div class="partial-leads">
                    <div class="checkbox pl-2 ml-1">
                        <input type="checkbox" id="partialLeadsCheckbox" class="all-check-box"
                               name="partialLeadsCheckbox" value="">
                        <label class="lead-label" for="partialLeadsCheckbox">
                            Yes, Receive Partial Leads
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Cancel
                            </button>
                        </li>
                        <li class="action__item">
                            <button class="button button-bold button-primary" type="submit">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Question delete modal -->
<div class="modal fade confirmation-delete" id="confirmation-delete">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Your Question</h5>
            </div>
            <div class="modal-body">
                <p class="modal-msg modal-msg_light">
                    Are you sure, you want to delete the Question
                </p>
              <div class="condition-list-area"data-condition-list-area>
                <div class="active-condition-modal">
                  <ul class="active-condition-list" data-active-condition-list>
                      <!-- Dynamic Data rendering Of CL  -->

                  </ul>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No,
                                Never Mind
                            </button>
                        </li>
                        <li class="action__item">
                            <input type="hidden" data-id="deleteId">
                            <button class="button button-bold button-primary" data-id="delete-question" type="submit">
                                Yes, Delete
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Question Confirmation delete modal -->
<div class="modal fade question-confirmation-close" id="question-confirmation-close">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Save Your Question</h5>
            </div>
            <div class="modal-body">
                <p class="modal-msg modal-msg_light">
                    You currently have some unsaved changes! Do you want to save changes before closing question?
                </p>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No, Never Mind</button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-bold button-primary" id="save-changes">Yes, Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Question Confirmation delete modal -->
<div class="modal fade question-confirmation-close" id="question-confirmation-close">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Save Your Question</h5>
            </div>
            <div class="modal-body">
                <p class="modal-msg modal-msg_light">
                    You currently have some unsaved changes! Do you want to save changes before closing question?
                </p>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No, Never Mind</button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-bold button-primary" id="save-changes">Yes, Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Question Confirmation delete modal -->
<div class="modal fade integration-active-modal" id="integration-active-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="modal-msg modal-msg_light">
                    You cannot edit this funnel since there is an existing integration
                </p>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <a href="{{route('dashboard')}}" class="button button-bold button-cancel">Close</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Message Saving Confirmation modal -->
<div class="modal fade cta-message-confirmation" id="save-confirmation">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Save Your Changes</h5>
      </div>
      <div class="modal-body">
        <p class="modal-msg modal-msg_light">
          Do you want to save changes before closing Modal?
        </p>
      </div>
      <div class="modal-footer">
        <div class="action">
          <ul class="action__list">
            <li class="action__item">
              <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No, Never Mind</button>
            </li>
            <li class="action__item">
              <button type="button" class="button button-bold button-primary" data-cta-confirmed data-dismiss="modal">Yes, Save</button>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- transition delete modal -->
<div class="modal fade confirmation-delete" id="delete-tranistion">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remove Transition</h5>
            </div>
            <div class="modal-body">
                <p class="modal-msg modal-msg_light">
                    Are you sure, you want to remove the Transition
                </p>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No,
                                Never Mind
                            </button>
                        </li>
                        <li class="action__item">
                            <button class="button button-bold button-primary" type="submit">Yes, Delete</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- create-transition-pop modal -->
<div class="modal fade create-question" id="create-transition-pop">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="new-transition" class="form-pop" method="get" action="">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Transition</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="transition_name" class="modal-lbl">Transition Name</label>
                        <div class="input__holder">
                            <input id="transition_name" name="transition_name" class="form-control" type="text"
                                   placeholder="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="transition-type" class="modal-lbl">Transition Type</label>
                        <div class="input__holder">
                            <div class="select2js__transition-type-parent select2js__nice-scroll w-100">
                                <select class="select2js__transition-type" name="transition-type" id="transition-type">
                                    <option value="">Short Transition</option>
                                    <option value="">Circle Transition</option>
                                    <option value="">3 Dots</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">
                                    Close
                                </button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary" type="submit">Next</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- manage-transition-pop modal -->
<div class="modal fade manage-question" id="manage-transition-pop">
    <div class="modal-dialog modal-extra__dailog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Manage Transitions
                </h5>
            </div>
            <div class="modal-body p-0">
                <div class="lp-table__head">
                    <ul class="lp-table__list">
                        <li class="lp-table__item">
                            <div class="item-wrap">
                                Transition Name
                            </div>
                        </li>
                        <li class="lp-table__item">
                            <div class="item-wrap">
                                Date Created
                            </div>
                        </li>
                        <li class="lp-table__item">Options</li>
                    </ul>
                </div>
                <div class="lp-table__body">
                    <ul class="lp-table sorting ui-sortable">
                        <li class="lp-table__list ">
                            <span class="lp-table__item">Short Transition</span>
                            <span class="lp-table__item"><span class="item-wrap">12/18/2019</span></span>
                            <span class="lp-table__item">
                                        <a href="javascript:void(0);" class="show_nav">
                                            <i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle"
                                                                                              aria-hidden="true"></i><i
                                                class="fa fa-circle" aria-hidden="true"></i>
                                        </a>
                                        <ul class="action_nav">
                                            <li> <a href="javascript:void(0);" class="edit"><i class="ico ico-edit"></i></a></li>
                                            <li> <a href="javascript:void(0);" class="clone"><i
                                                        class="ico ico-copy"></i></a></li>
                                        </ul>
                                    </span>
                        </li>
                        <li class="lp-table__list ">
                            <span class="lp-table__item">Circle Loader</span>
                            <span class="lp-table__item"><span class="item-wrap">12/19/2019</span></span>
                            <span class="lp-table__item">
                                        <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle"
                                                                                          aria-hidden="true"></i><i
                                                class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle"
                                                                                               aria-hidden="true"></i></a>
                                        <ul class="action_nav">
                                            <li> <a href="javascript:void(0);" class="edit"><i class="ico ico-edit"></i></a></li>
                                            <li> <a href="javascript:void(0);" class="clone"><i
                                                        class="ico ico-copy"></i></a></li>
                                        </ul>
                                    </span>
                        </li>
                        <li class="lp-table__list ">
                            <span class="lp-table__item">3 dots</span>
                            <span class="lp-table__item"><span class="item-wrap">11/05/2019</span></span>
                            <span class="lp-table__item">
                                        <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle"
                                                                                          aria-hidden="true"></i><i
                                                class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle"
                                                                                               aria-hidden="true"></i></a>
                                        <ul class="action_nav">
                                            <li> <a href="javascript:void(0);" class="edit"><i class="ico ico-edit"></i></a></li>
                                            <li> <a href="javascript:void(0);" class="clone"><i
                                                        class="ico ico-copy"></i></a></li>
                                        </ul>
                                    </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer d-block m-0">
                <div class="row">
                    <div class="col">
                        <a href="javascript:void(0);" class="pop-transition-question">
                            create new transition
                        </a>
                    </div>
                    <div class="col">
                        <div class="action d-flex justify-content-end">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-bold button-cancel" data-dismiss="modal">
                                        Close
                                    </button>
                                </li>
                                <li class="action__item">
                                    <input class="button button-bold button-primary" value="Save" type="submit">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- icon-color-modal -->
<div class="modal fade" id="icon-color-modal" tabindex="-1" role="dialog" aria-labelledby="icon-color-modal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Question Group</h5>
            </div>
            <div class="modal-body">
                <div class="color-picker-field">
                    <label>Group Name</label>
                    <div class="field-area">
                        <div class="field-holder">
                            <span class="question-icon-text title-tooltip" title="Loan Type: Purchase">Loan Type: Purchase</span>
                        </div>
                        <div class="last-selected icon-color-opener">
                            <div class="last-selected__box" style="background:#b6c7cd"></div>
                            <div class="last-selected__code">#b6c7cd</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-cancel" data-dismiss="modal">cancel</button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-primary" data-dismiss="modal">finish</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main icon color picker -->
<div class="color-box__panel-wrapper icon-color-picker-parent">
    <div class="color-box__panel-dropdown">
        <select class="color-picker-options">
            <option value="1">Color Selection: Pick My Own</option>
            <option value="2">Color Selection: Pull from Logo</option>
        </select>
    </div>
    <div class="color-picker-block">
        <div class="picker-block icon-color-picker">
        </div>
        <label class="color-box__label">Add custom color code</label>
        <div class="color-box__panel-rgb-wrapper">
            <div class="color-box__r">
                R: <input class="color-box__rgb" value="182"/>
            </div>
            <div class="color-box__g">
                G: <input class="color-box__rgb" value="199"/>
            </div>
            <div class="color-box__b">
                B: <input class="color-box__rgb" value="205"/>
            </div>
        </div>
        <div class="color-box__panel-hex-wrapper">
            <label class="color-box__hex-label">Hex code:</label>
            <input class="color-box__hex-block" value="#b6c7cd"/>
        </div>
    </div>
    <div class="color-pull-block">
        <label class="color-box__label">Pulled Colors</label>
        <ul class="color-box__list">
            <li class="color-box__item"></li>
            <li class="color-box__item red"></li>
            <li class="color-box__item green"></li>
            <li class="color-box__item black"></li>
            <li class="color-box__item blue"></li>
            <li class="color-box__item orange"></li>
            <li class="color-box__item yellow"></li>
            <li class="color-box__item parrot"></li>
        </ul>
    </div>
    <div class="color-box__panel-pre-wrapper">
        <label class="color-box__label">Previously used colors</label>
        <ul class="color-box__list">
            <li class="color-box__item"></li>
            <li class="color-box__item"></li>
            <li class="color-box__item"></li>
            <li class="color-box__item"></li>
            <li class="color-box__item"></li>
            <li class="color-box__item"></li>
            <li class="color-box__item"></li>
            <li class="color-box__item"></li>
        </ul>
    </div>
</div>

<!-- Home CTA message modal -->
<div class="modal fade homepage-cta-message funnel-group-home-modal" id="homepage-cta-message-pop">
    <form id="ctaform" name="ctaform" method="POST"
          class="global-content-form"
          data-global_action="{{ LP_BASE_URL.LP_PATH."/popadmin/calltoactionsave" }}"
          data-action="{{ LP_BASE_URL.LP_PATH."/popadmin/calltoactionsave" }}"
          action="{{ LP_BASE_URL.LP_PATH."/popadmin/calltoactionsave" }}">
        {{ csrf_field() }}
        @php
            $noimage = "noimage";
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            if($funnel_data){
            $imagesrc = \View_Helper::getInstance()->getCurrentFrontImageSource($view->data->client_id,$funnel_data['funnel']);
            if($imagesrc){
            list($imagestatus,$theimage, $noimage) = explode("~",$imagesrc);
            }
            }
            $descriptionClass = '';
            $_class = 'old_admin_homepage_on';
            if(config('lp.show_new_feature') == 1){
                $_class = 'homepage_on';
            }
            if($noimage=="noimage"){
                $featured_image_active="n";
                $_class = $descriptionClass = 'homepage_off';
            }
            else {
                $featured_image_active="y";
            }
            if(isset($view->data->clickedkey) && $view->data->clickedkey != "") {
                $firstkey = $view->data->clickedkey;
            }else {
                $firstkey = "";
            }
            $treecookie = \View_Helper::getInstance()->getTreeCookie($view->data->client_id,$firstkey);
        @endphp
        <input name="saved" id="saved" value="{{ @$view->saved }}" type="hidden">
        <input type="hidden" name="firstkey" id="firstkey" value="{{ $firstkey }}">
        <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $firstkey }}">
        <input type="hidden" name="treecookie" id="treecookie" value="{{ $treecookie }}">
        <input type="hidden" name="mlineheight" id="mlineheight" value="{{@$view->data->lineheight}}" data-form-field>
        <input type="hidden" name="dlineheight" id="dlineheight" value="{{@$view->data->dlineheight}}" data-form-field>
        <input type="hidden" name="client_id" value="{{$view->data->client_id}}">
        <input type="hidden" id="current_hash" name="current_hash" value="{{ $view->data->currenthash }}">
        <img class="hide d-none" name="default_logo" id="default_logo" src="{{$view->data->thankyoupageLogo}}">
        <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
        <input type="hidden" name="featured_image_active" id="featured_image_active"
               value="{{ $featured_image_active }}">
        <!-- hidden variables to manage cta message popup state in DOM -->
        <input type="hidden" id="selected_cta_main_message"
               value="{{trim(textCleaner($view->data->homePageMessageMainMessage))}}">
        <input type="hidden" id="selected_cta_description" value="{{trim($view->data->homePageMessageDescription)}}">
        <input type="hidden" id="selected_font_main_message" value="{{@$view->data->fontfamily}}">
        <input type="hidden" id="selected_font_size_main_message" value="{{@$view->data->fontsize}}">
        <input type="hidden" id="selected_line_spacing_main_message" value="{{@$view->data->lineheight}}">
        <input type="hidden" id="selected_color_main_message"
               value="{{@(isset($view->data->color) && ($view->data->color)) ? $view->data->color : ''}}">
        <input type="hidden" id="selected_font_description" value="{{@$view->data->dfontfamily}}">
        <input type="hidden" id="selected_font_size_description" value="{{@$view->data->dfontsize}}">
        <input type="hidden" id="selected_line_spacing_description" value="{{@$view->data->dlineheight}}">
        <input type="hidden" id="selected_color_description"
               value="{{@(isset($view->data->dcolor) && ($view->data->dcolor)) ? $view->data->dcolor : ''}}">
        <input type="hidden" id="selected_cta_toggle" value="{{@$view->data->enable_cta_class == 'active' ? 1 : 0}}">
        <input type="hidden" name="submit_from_cta_popup" value="1">

        <div class="modal-dialog modal-dialog-centered modal-max__dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Funnel Homepage CTA Message</h5>
                    <div class="fb-toggle">
                        <input
                            @php if($view->data->enable_cta_class == 'active') echo 'checked' @endphp class="fb-field-label"
                            type="checkbox" data-toggle-cta data-form-field data-toggle="toggle"
                            data-on="Inactive" data-enable-cta-toggle name="enable_cta_toggle" data-off="Active"
                            data-onstyle="off" data-offstyle="on">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="lp-panel m-0 px-0 rounded-0">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Main Message
                                </h2>
                            </div>
                            <div class="col-right">
                                <div class="action">
                                    <ul class="action__list">
                                        <li class="action__item action__item_separator">
                                        <span class="action__span">
                                            <a href="javascript:void(0)"
                                               onclick="return resethomepagemessage('1', this);"
                                               class="action__link">
                                                <span class="ico ico-undo"></span>Reset
                                            </a>
                                        </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="cta">
                                <div class="cta__message-control">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <div class="font-type">
                                                <label>Font Type</label>
                                                <div class="select2__parent-font-type select2js__nice-scroll">
                                                    <select class="form-control font-type" name="mthefont"
                                                            id="msgfonttype" data-form-field>
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="action__item">
                                            <div class="font-size">
                                                <label>Font Size</label>
                                                <div class="select2__parent-font-size select2js__nice-scroll">
                                                    <select class="form-control msgfontsize" name="mthefontsize"
                                                            id="msgfontsize" data-form-field>
                                                        @php
                                                            $data='';
                                                            for ($i=10;$i<=80;$i++) {
                                                                $selected = ($i."px" === $view->data->fontsize) ? 'selected="selected"': '';
                                                                $data.='<option value="'.$i.'px" '.$selected.'>'.$i.' px</option>';
                                                            }
                                                            echo $data;
                                                        @endphp
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="action__item">
                                            <div class="font-linehight">
                                                <label>Line Spacing</label>
                                                <div class="select2-linehight-mian-msg-parent">
                                                    <select class="select2-linehight-main-msg"
                                                            data-main-message-line-spacing></select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="action__item">
                                            <div class="text-color">
                                                <label>Text Color</label>
                                                <div class="text-color-parent color-picker-parent-wrap">
                                                    <div
                                                        class="color-picker colorSelector-mmessagecp cta-color-selector"></div>
                                                    <input type="hidden" name="mmessagecpval" id="mmessagecpval"
                                                           value="@php if(isset($view->data->color) && ($view->data->color)) echo $view->data->color @endphp"
                                                           data-form-field>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="cta__message">
                                    <textarea data-form-field data-cta-main-message
                                              class="@php if($view->data->featured_image_active != '') echo 'form-control text-area cta-text cta-text-format old_admin_homepage_on'; else echo 'form-control text-area cta-text cta-text-format homepage_off'; @endphp"
                                              name="mmainheadingval" id="mian__message"
                                              style="{{ @$view->data->messageStyle }}">@php if(isset($view->data->homePageMessageMainMessage)){ echo trim(textCleaner($view->data->homePageMessageMainMessage));} @endphp</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel border-bottom-0 m-0 px-0 rounded-0">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Description
                                </h2>
                            </div>
                            <div class="col-right">
                                <div class="action">
                                    <ul class="action__list">
                                        <li class="action__item action__item_separator">
                                        <span class="action__span">
                                            <a href="javascript:void(0)"
                                               onclick="return resethomepagemessage('2', this);"
                                               class="action__link">
                                                <span class="ico ico-undo"></span>Reset
                                            </a>
                                        </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="cta">
                                <div class="cta__message-control">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <div class="font-type">
                                                <label>Font Type</label>
                                                <div class="select2__parent-dfont-type select2js__nice-scroll">
                                                    <select class="form-control font-type" id="dfonttype"
                                                            name="dthefont" data-form-field>
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="action__item">
                                            <div class="font-size">
                                                <label>Font Size</label>
                                                <div class="select2__parent-dfont-size select2js__nice-scroll">
                                                    <select class="form-control dfontsize" name="dthefontsize"
                                                            id="dfontsize" data-form-field>
                                                        @php
                                                            $data='';
                                                            for ($i=10;$i<=80;$i++) {
                                                                $selected = ($i."px" === $view->data->dfontsize) ? 'selected="selected"': '';
                                                                $data.='<option value="'.$i.'px" '.$selected.'>'.$i.' px</option>';
                                                            }
                                                            echo $data;
                                                        @endphp
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="action__item">
                                            <div class="font-linehight">
                                                <label>Line Spacing</label>
                                                <div class="select2-linehight-dsc-msg-parent">
                                                    <select class="select2-linehight-dsc-msg"
                                                            data-description-line-spacing></select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="action__item text-color-holder">
                                            <div class="text-color">
                                                <label for="textcolor">Text Color</label>
                                                <div class="text-color-parent color-picker-parent-wrap description">
                                                    <div class="color-picker colorSelector-mdescp cta-color-selector"
                                                         data-ctaid="dmessagecpval"
                                                         data-ctavalue="dmainheadingval"></div>
                                                    <input type="hidden" name="dmessagecpval" id="dmessagecpval"
                                                           value="@php if(isset($view->data->dcolor) && ($view->data->dcolor)) echo $view->data->dcolor; @endphp"
                                                           data-form-field>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="cta__message">
                                    <textarea data-form-field data-cta-description
                                              class="@php if($view->data->featured_image_active != '') echo 'form-control text-area cta-textarea cta-text-format'; else echo 'form-control text-area cta-textarea cta-text-format homepage_off'; @endphp"
                                              name="dmainheadingval" id="desc__message"
                                              style="{{ @$view->data->dmessageStyle }}">@php if(isset($view->data->homePageMessageDescription)){  echo trim($view->data->homePageMessageDescription); } @endphp</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" id="cta-cancel-btn" data-dismiss="modal">
                                    Close
                                </button>
                            </li>
                            <li class="action__item">
                                <button class="button button-primary button-animation" data-save-cta-btn><span
                                        class="spiner-wrap">Save<span class="spiner"></span></span></button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Thank you page modal -->
<div class="modal fade fb-thank-you-modal" id="fb-thank-you">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="thankyou-page-from" method="post" action="#">

                {{ csrf_field() }}
                <input type="hidden" name="submission_id">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Thank You
                    </h5>
                </div>
                <div class="modal-body thank-you-modal-scroll">
                    <div class="modal-body-wrap">
                        <div class="lp-panel funnel-thankyou-page-pannel">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        <span class="page-title">Thank You Page</span>
                                        <span class="page-title-update">Thank You Page Detail</span>
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item action__item_separator">
                                        <span class="action__span">
                                            <a href="#" class="action__link thankyou-edit-page">
                                                <span class="ico ico-edit"></span>Edit
                                            </a>
                                            <a href="#" class="action__link thankyou-page-cancel">
                                                <span class="ico ico-cross"></span>cancel
                                            </a>
                                        </span>
                                            </li>
                                            <li class="action__item">
                                                <div class="button-switch">
                                                    <input class="thktogbtn" id="thankyou" name="thankyou"
                                                           data-thelink="thankyou_active" data-toggle="toggle"
                                                           data-onstyle="active" data-offstyle="inactive"
                                                           data-width="127" data-height="43" data-on="INACTIVE"
                                                           data-off="ACTIVE" type="checkbox">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <p class="lp-custom-para">
                                    Upon submission, your Funnel will take potential clients to a customizable "Thank
                                    You" page.
                                </p>
                                <div class="thankyou-page-text-area">
                                    <div class="action-list-holder">
                                        <ul class="action__list">
                                            <li class="action__item action__item_en-logo">
                                                <input
                                                    class="responder-toggle typ_logo" for="typ_logo" id="typ_logo"
                                                    onchange="logo_trigger()"
                                                    name="thankyou_logo"
                                                    value="0"
                                                    data-thelink="en-logo_active" data-field="typ_logo"
                                                    data-toggle="toggle"
                                                    data-onstyle="active" data-offstyle="inactive"
                                                    data-width="182" data-height="50" data-on="logo disabled"
                                                    data-off="logo enabled" type="checkbox"
                                                     data-form-field>
                                            </li>
                                            <li class="action__item">
                                                <a target="_blank"
                                                   href=""
                                                   class="button button-secondary" data-preview >
                                                    preview
                                                </a>
                                            </li>
                                            <div class="thank-you-slug" id="url-text" data-copy
                                                 style="display:none;"></div>
                                            <li class="action__item">
                                                <button type="button" id="clone-url" class="button button-primary">
                                                    Copy URL
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="form-group">
                                        <label>Thank You Page Title</label>
                                        <div class="field-holder">
                                            <input class="form-control" id="thankyou-title" type="text"
                                                   name="thankyou_title"
                                                   placeholder="Thank You! Sebonix Funnel Version1" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="slug_url">/</label>
                                        <div class="field-holder">
                                            <input id="thankyou_slug" onkeypress="return AvoidSpace(event)"
                                                   class="form-control" type="text" name="thankyou_slug"
                                                   placeholder="thank-you" value="">
                                        </div>
                                    </div>
                                    <div class="update-version thankyou-modal-editor">
                                        <textarea class="lp-froala-textbox classic-editor update-version"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Third Party URL
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item action__item_separator">
                                        <span class="action__span action__span_3rd-party">
                                            <a id="eurllink" href="javascript:void(0)"
                                               class="action__link action__link_edit lp_thankyou_toggle">
                                                <span class="ico ico-edit"></span>edit url
                                            </a>
                                            <a href="javascript:void(0)" class="action__link action__link_cancel">
                                                <span class="ico ico-cross"></span>cancel
                                            </a>
                                        </span>
                                            </li>
                                            <li class="action__item">
                                                <div class="button-switch">
                                                    <input checked class="thktogbtn" id="thirldparty" name="thirldparty"
                                                           data-thelink="thirdparty_active" data-toggle="toggle"
                                                           data-onstyle="active" data-offstyle="inactive"
                                                           data-width="127" data-height="43" data-on="INACTIVE"
                                                           data-off="ACTIVE" type="checkbox">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <div class="default__panel">
                                    <p class="lp-custom-para">
                                        This simple option gives your potential clients a quick thank you message,
                                        and then forwards them to a third party website of your choice. You can forward
                                        your potential clients to your company website, personal website, blog,
                                        Facebook page, or other&nbsp;website.
                                    </p>
                                </div>
                                <div class="third-party__panel">
                                    <div class="select2__parent-url-prefix">
                                        <select name="https_flag" class="form-control flex-grow-0 url-prefix"
                                                id="https_flag">
                                            <option value="https://" selected>https://</option>
                                            <option value="http://">http://</option>
                                        </select>
                                    </div>
                                    <div class="input-holder flex-grow-1">
                                        <input id="thrd_url" name="footereditor" class="form-control" type="text"
                                               placeholder="Enter 3rd Party URL">
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
                                <button type="button" class="button button-cancel" data-dismiss="modal">close</button>
                            </li>
                            <li class="action__item">
                                <button type="submit" class="button button-primary save-third-party" disabled>save
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- delete modal -->
<div class="modal fade confirmation-delete" id="confirmation-delete-funnel">
    <form action="{{route('thankyou.pages.delete')}}" method="post">
        @csrf
        @method('delete')
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Thank You Page</h5>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light">
                        Are you sure, you want to delete the thank you page?
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">
                                    No, Never Mind
                                </button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary" type="button" id="deleteSubmit">Yes,
                                    Delete
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Hidden Field modal -->
<div class="modal fade hidden-field-modal" id="hidden-field-modal">
    <input data-id="ques_id" hidden>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ico-hidden"></i> Hidden Field</h5>
            </div>
            <div class="modal-body-wrap">
                <div class="modal-body quick-scroll">
                    <div class="modal-body-inner">
                        <div class="form-group hidden-field">
                            <div class="label-wrap">
                                <label>Field Label</label>
                                <span class="question-mark el-tooltip"
                                      title='<div class="hidden-field-tooltip">tooltip content</div>'>
                                        <span class="ico ico-question"></span>
                                    </span>
                            </div>
                            <div class="field-holder">
                                <div class="field">
                                    <input type="text" data-change-hidden-field-label
                                           data-field-name="hidden.field-label"
                                           class="form-control hidden-field-modal__field-label"
                                           placeholder="Enter Field Label">
                                    <label data-hidden-field-label-error style="display: none;" class="error">Please
                                        enter the field label.</label>
                                    <span class="tag-box">
                                            <i class="fa fa-tag"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label-wrap">
                                <label>Default Value <span class="optional">(optional)</span></label>
                                <span class="question-mark el-tooltip"
                                      title='<div class="hidden-field-tooltip">tooltip content</div>'>
                                        <span class="ico ico-question"></span>
                                    </span>
                            </div>
                            <div class="field-holder">
                                <div class="field">
                                    <input type="text" data-change-hidden-field-default
                                           data-field-name="hidden.default-value"
                                           class="form-control hidden-field-modal__value"
                                           placeholder="Enter Default Value">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" data-parent>
                            <div class="label-wrap">
                                <div class="fb-checkbox">
                                    <input class="fb-checkbox__input" data-field-name="hidden.enable-dynamic-population"
                                           type="checkbox" id="hidden-field-option">
                                    <label for="hidden-field-option" class="fb-checkbox__label">
                                        <div class="fb-checkbox__box">
                                            <div class="fb-checkbox__inner-box"></div>
                                        </div>
                                        <div class="fb-checkbox__caption">
                                            Allow field to be populated dynamically
                                        </div>
                                    </label>
                                </div>
                                <span class="question-mark el-tooltip"
                                      title='<div class="hidden-field-tooltip">tooltip content</div>'>
                                        <span class="ico ico-question"></span>
                                    </span>
                            </div>
                            <div class="hidden-parameter-slide" data-slide>
                                <div class="field-holder">
                                    <div class="field">
                                        <input class="form-control hidden-field-modal__parameter"
                                               data-change-hidden-parameter data-field-name="hidden.parameter"
                                               type="text" placeholder="Parameter">
                                        <label data-hidden-parameter-error style="display: none;" class="error">Already
                                            exists, Please enter different parameter.</label>
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
                            <button type="button" class="button button-cancel actions-button__link_close-funnels"
                                    data-dismiss="modal">Close
                            </button>
                        </li>
                        <li class="action__item">
                            <button class="button button-primary button-animation" data-hidden-save-btn><span
                                    class="spiner-wrap">Save<span class="spiner"></span></span></button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Security message modal -->
<div class="modal fade select-security-message-modal" id="security-message-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/lp/ajax/savesecuritymessage/{{ @$view->data->currenthash }}"
                  global-action="/lp/ajax/savesecuritymessage/{{ @$view->data->currenthash }}" method="post"
                  data-action="/lp/ajax/savesecuritymessage/{{ @$view->data->currenthash }}" class="security-popup-handler">
                <div class="modal-header">
                    <h5 class="modal-title" data-security-message-title>Edit Security Message</h5>
                </div>
                <div class="security-modal-body">
                    <div class="security-message">
                        <div class="preview-panel">
                            <div class="preview-panel__head">
                                <div class="form-group">
                                    <h3 class="preview-panel__title">
                                        Security Message Icon
                                    </h3>
                                    <div class="switcher-min">
                                        <input class="message-icon" data-security-message-icon name="message-icon"
                                               data-toggle="toggle" data-onstyle="active" data-offstyle="inactive"
                                               data-width="72" data-height="26" data-on="OFF" data-off="ON" type="checkbox" data-form-field>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-panel__body">
                                <div class="icon-setting" data-icon-setting>
                                    <div class="form-group">
                                        <label for="preview-button-pop">Select an Icon</label>
                                        <div class="btn-icon-wrapper" data-dismiss="modal">
                                            <div class="icon-block"  data-security-message-icon-class>
                                                <i class="ico ico-shield-2"></i>
                                            </div>
                                            <span class="arrow"></span>
                                            <input type="hidden" name="ico-shield-form-field" id="ico-shield-form-field" data-form-field>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="preview-button-pop">Icon Color</label>
                                        <div class="text-color-parent color-picker-parent-wrap color-icon-wrap">
                                            <div id="clr-icon" class="last-selected" data-security-message-icon-color>
                                                <div class="last-selected__box custom-color-bg" style="background: #24b928" ></div>
                                                <div class="last-selected__code custom-color-code">#24b928</div>
                                                <input type="hidden" name="icon_color" class="custom-color-value" value="#24b928" data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="preview-button-pop">Icon Position</label>
                                        <div class="select2js__icon-position-parent select2-parent">
                                            <select  name="select2js__icon-position" id="select2js__icon-position"
                                                     data-security-message-icon-position  data-form-field>
                                                <option>Left Align</option>
                                                <option>Right Align</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group icon-size-wrap">
                                        <label for="preview-button-pop">Icon Size</label>
                                        <div class="icon-range-slider">
                                            <div class="range-slider">
                                                <div class="input__wrapper">
                                                    <input class="form-control security-icon-size-parent"
                                                           data-security-message-icon-size data-slider-id='ex1Slider'
                                                           type="text" id="security-icon-size" data-form-field   />
                                                    <input type="hidden" class="security-icon-size" value="28"  />
                                                </div>
                                            </div>
                                            <span class="icon-size-reset"><i class="ico-undo"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="default-setting">
                                    <div class="form-group form-group_security-message">
                                        <label for="buttontext">
                                            Security Message Text
                                            <span class="question-mark el-tooltip" title="Tooltip Content">
                                                <span class="ico ico-question"></span>
                                            </span>
                                        </label>
                                        <div class="font-opitons-area security-font-option">
                                            <div class="input__wrapper">
                                                <input  type="text" id="buttontext" data-security-message-button-text
                                                        class="form-control" placeholder="Enter Security Message Text" data-form-field>
                                                <label data-security-message-text-error style="display: none;"
                                                       class="error">Please enter the message text.</label>
                                            </div>
                                            <div class="font-bold">
                                                <button type="button" class="form-control txt-cta-bold"
                                                        data-security-message-bold><i class="ico ico-alphabet-b"></i>
                                                </button>
                                                <input type="hidden"  id="cta-text-bold-form-field" name="cta-text-bold"  value="active" data-form-field >
                                            </div>
                                            <div class="font-italic">
                                                <button type="button" class="form-control txt-cta-italic"
                                                        data-security-message-italic><i class="ico ico-alphabet-i"></i>
                                                </button>
                                                <input type="hidden"  id="cta-text-itelic-form-field" name="cta-text-itelic"  value="itelic" data-form-field >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="preview-button-pop">Text Color</label>
                                        <div class="text-color-parent text-picker color-picker-parent-wrap color-text-wrap">
                                            <div id="clr-text" class="last-selected" data-security-message-text-color>
                                                <div class="last-selected__box custom-color-bg" style="background: #b4bbbc"></div>
                                                <div class="last-selected__code custom-color-code">#b4bbbc</div>
                                                <input type="hidden" name="text_color" class="custom-color-value" value="#b4bbbc" data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <ul class="btns-list">
                        <li>
                            <button type="button" class="button button-cancel btn-cancel-icon"
                                    data-security-message-close-btn data-dismiss="modal">Close
                            </button>
                        </li>
                        <li>
                            <button class="button button-secondary button-animation" data-security-message-save><span
                                    class="spiner-wrap">Save<span class="spiner"></span></span></button>
                        </li>
                    </ul>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- icon picker modal -->
<div class="modal fade" id="icon-picker">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Icon</h5>
            </div>
            <div class="modal-body pb-0">
                <ul class="icon-wrapper"></ul>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" data-target="#security-message-modal" data-toggle="modal"
                                    class="button button-bold button-cancel" data-dismiss="modal">Close
                            </button>
                        </li>
                        <li class="action__item">
                            <button class="button button-bold button-primary btn-add-security-icon"
                                    data-btn-add-security-icon>Select
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
