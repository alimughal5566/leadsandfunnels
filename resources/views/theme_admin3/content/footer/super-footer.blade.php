<div class="lp-panel py-0">
    <div class="card-header">
        <div class="lp-panel__head border-0 p-0">
            <div class="col-left">
                <h2 class="card-title">
                    <span>
                        Super Footer Options
                        <!-- <span class="new">(new feature!)</span> -->
                    </span>
                </h2>
            </div>
            <div class="col-right">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <div class="card-link collapsed expandable ml-3 col-super-footer"
                                 data-toggle="collapse" href="#superfooter"></div>
                        </li>
                        <li class="action__item global_switch_holder">
                            @php $checked="";
                                    if($view->data->bottomlinks["advanced_footer_active"]=="y"){
                                    $checked="checked";
                                    }
                            @endphp
                            <input @php echo $checked; @endphp class="pfobtn global-switch global_super_status_btn"
                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~advanced_footer_active"
                                   id="global_super_status_btn"
                                   data-toggle="toggle"

                                   data-thelink="advanced_footer_active"
                                   name="advanced_footer_active"
                                   data-global_val="{{@$view->data->globalOptions['advanced_footer_active']}}"
                                   data-val="{{@$view->data->bottomlinks["advanced_footer_active"]}}"

                                   data-onstyle="active" data-offstyle="inactive"
                                   data-width="127" data-height="43" data-on="INACTIVE"
                                   data-off="ACTIVE" type="checkbox" data-form-field>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="superfooter" class="collapse">
        <div class="card-body">
            <div class="lp-panel lp-thankyou">
                <div class="lp-panel-wrap">
                    <div class="classic-editor__wrapper froala-editor-fixed-width lp-thankyou-head funnel-setting-pages-editor">
                        <div class="classic-editor-wrap local-super-footer">
                            <textarea class="lp-froala-textbox" data-form-field>
                                @php  echo $view->data->bottomlinks["advancehtml"]; @endphp
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="lp-panel__footer mt-4 pt-4">
                    <div class="row">
                        <div class="col super-footer-bottom-controls d-flex align-items-center">
                            <div class="superfooter">
                                 <span class="reset-froala" style="cursor: pointer;"
                                       onclick="resetSuperFooterOptions()">
                                                <i class="ico ico-undo"></i> reset default
                                       </span>
                            </div>
                        </div>
                        <div class="col super-footer-bottom-controls flex-row-reverse d-flex align-items-center footer-content-text">
                            <div class="checkbox h-100 ml-3 mt-2">

                                @php $checked="";
                                            if($view->data->bottomlinks["hide_primary_footer"] == "y"){
                                            $checked="checked";
                                            }
                                @endphp

                                <input @php echo $checked; @endphp class="sub-group"
                                       id="hideofooter"
                                       data-key="hideofooter" name="hideofooter"
                                       type="checkbox" data-form-field>
                                <label class="normal-font" for="hideofooter">Hide Primary and Secondary footer&nbsp;content</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Super Footer Reset Default PopUP - Start -->
<div id="model_confirmPixelDelete" class="modal fade lp-modal-box in">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Reset To Default Footer Content</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-sm-12 modal-action-msg-wrap">
                            <div id="notification_confirmPixelDelete" class="modal-msg"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer lp-modal-action-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-cancel btnCancel_confirmPixelDelete"
                                    data-dismiss="modal">Close
                            </button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-primary" id="_reset_default_btn">YES
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Super Footer Reset Default PopUP - End -->
