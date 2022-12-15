<div class="lp-panel py-0">
    <div class="card-header">
        <div class="lp-panel__head border-0 p-0">
            <div class="col-left">
                <h2 class="card-title">
                    <span>
                        Secondary Footer Options
                    </span>
                </h2>
            </div>
            <div class="col-right">
                <div class="card-link collapsed expandable" data-toggle="collapse"
                     href="#secondaryfooter"></div>
            </div>
        </div>
    </div>
    <div id="secondaryfooter" class="collapse">
        <div class="card-body">
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <input class="form-control line-input lp-footer-textbox global-input-text" disabled
                               data-global_val="{{@$view->data->globalOptions['compliance_text']}}"
                               data-val="{{@$view->data->bottomlinks['compliance_text']}}"
                               value="{{@$view->data->bottomlinks['compliance_text']}}"
                               id="compliance_text"
                               placeholder="Compliance Text"
                               type="text" data-form-field>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item action__item_separator">
                                    <span class="action__span action__span_toggle">
                                        <a href="javascript:void(0)"
                                           data-togele="lp-footer-url-edit"
                                           class="action__link action__link_edit">
                                            <span class="ico ico-edit"></span>EDIT
                                        </a>
                                        <a href="javascript:void(0)"
                                           class="action__link action__link_cancel">
                                            <span class="ico ico-cross"></span>cancel
                                        </a>
                                    </span>
                                </li>
                                <li class="action__item global_switch_holder">
                                    @php $checked="";
                                        if($view->data->bottomlinks["compliance_active"]=="y"){
                                            // To fix default emtpy value issue
                                            if(empty($view->data->bottomlinks['compliance_text'])) {
                                                @$view->data->bottomlinks["compliance_active"] = 'n';
                                            } else {
                                                $checked="checked";
                                            }
                                        }
                                    @endphp

                                    <input @php echo $checked; @endphp class="sfobtn global-input-text global-switch gfooter-toggle"
                                           data-lpkeys="@php echo $view->data->lpkeys; @endphp~compliance_active"
                                           data-toggle="toggle"
                                           data-onstyle="active" data-offstyle="inactive"

                                           id="sec_fot_url_active_switch"
                                           data-global_val="{{@$view->data->globalOptions['sec_fot_url_active']}}"
                                           data-val="{{@$view->data->bottomlinks['compliance_active']}}"
                                           data-thelink="compliance_active"
                                           name="compliance_active"

                                           data-width="127" data-height="43" data-on="INACTIVE"
                                           data-off="ACTIVE" type="checkbox" data-form-field>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                @php
                    $checked="";
                    $disable="disabled";
                    if($view->data->bottomlinks['compliance_is_linked']=='y') {
                    $checked='checked';
                    $disable="";
                    }
                @endphp

                <div class="collapse-box hide border-top-0">
                    <div class="row align-items-center">
                        <div class="col-sm-4 col-xl-2">
                            <div class="checkbox mt-2">
                                <input @php echo $checked; @endphp type="checkbox"
                                       class="collapse-checkbox global-checkbox gfooter-toggle"
                                       id="compliance_is_linked" data-tarele="compliance_link"

                                       data-global_val="{{@$view->data->globalOptions['compliance_is_linked']}}"
                                       data-val="{{@$view->data->bottomlinks['compliance_is_linked']}}"

                                       value="y" data-form-field>
                                <label class="normal-font" for="compliance_is_linked">
                                    Link to URL
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xl-7">
                            <div class="form-group m-0">

                                <label class="col-sm-2 col-xl-1 pl-0">URL</label>
                                <input class="form-control collapse-next-input global-input-text" type="text"

                                       data-global_val="{{@$view->data->globalOptions['compliance_link']}}"
                                       data-val="{{@$view->data->bottomlinks['compliance_link']}}"

                                       value="{{@$view->data->bottomlinks['compliance_link']}}"
                                       id="compliance_link" @php echo $disable; @endphp data-form-field>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <input class="form-control line-input global-input-text" disabled
                               placeholder="License Number"

                               data-global_val="{{@$view->data->globalOptions['license_number_text']}}"
                               data-val="{{@$view->data->bottomlinks['license_number_text']}}"

                               value="{{@$view->data->bottomlinks['license_number_text']}}"
                               id="license_number_text"
                               type="text" data-form-field>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item action__item_separator">
                                        <span class="action__span action__span_toggle">
                                            <a href="javascript:void(0)"
                                               class="action__link action__link_edit">
                                                <span class="ico ico-edit"></span>EDIT
                                            </a>
                                            <a href="javascript:void(0)"
                                               class="action__link action__link_cancel">
                                                <span class="ico ico-cross"></span>cancel
                                            </a>
                                        </span>
                                </li>
                                <li class="action__item global_switch_holder">
                                    @php $checked="";
                                            if($view->data->bottomlinks["license_number_active"]=="y"){
                                                // To fix default emtpy value issue
                                                if(empty($view->data->bottomlinks['license_number_text'])) {
                                                    @$view->data->bottomlinks["license_number_active"] = 'n';
                                                } else {
                                                    $checked="checked";
                                                }
                                            }
                                    @endphp
                                    {{--id="fp-terms"--}}
                                    <input @php echo $checked; @endphp class="sfobtn global-switch gfooter-toggle"
                                           data-lpkeys="@php echo $view->data->lpkeys; @endphp~license_number_active"
                                           data-toggle="toggle"
                                           data-onstyle="active" data-offstyle="inactive"
                                           data-width="127" data-height="43" data-on="INACTIVE"

                                           id="sec_fot_license_number_active_switch"
                                           data-global_val="{{@$view->data->globalOptions['sec_fot_license_number_active']}}"
                                           data-val="{{@$view->data->bottomlinks['license_number_active']}}"
                                           data-thelink="license_number_active"
                                           name="license_number_active"

                                           data-off="ACTIVE" type="checkbox" data-form-field>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="collapse-box footer-option-license-collapse hide">
                    <div class="row align-items-center">
                        <div class="col-sm-4 col-xl-2">
                            <div class="checkbox mt-2">
                                @php
                                    $checked="";
                                    $disable="disabled";

                                    if($view->data->bottomlinks['license_number_is_linked']=='y') {
                                    $checked='checked';
                                    $disable="";
                                    }
                                @endphp

                                <input @php echo $checked; @endphp type="checkbox"
                                       class="collapse-checkbox global-checkbox gfooter-toggle"
                                       id="license_number_is_linked"

                                       data-global_val="{{@$view->data->globalOptions['license_number_is_linked']}}"
                                       data-val="{{@$view->data->bottomlinks['license_number_is_linked']}}"

                                       data-tarele="license_number_link" value="y" data-form-field>
                                <label class="normal-font" for="license_number_is_linked">
                                    Link to URL
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xl-7">
                            <div class="form-group m-0">
                                <label class="col-sm-2 col-xl-1 pl-0">URL</label>
                                <input class="form-control collapse-next-input global-input-text"

                                       data-global_val="{{@$view->data->globalOptions['license_number_link']}}"
                                       data-val="{{@$view->data->bottomlinks['license_number_link']}}"

                                       value="{{@$view->data->bottomlinks['license_number_link']}}"
                                       id="license_number_link"
                                       type="text" @php echo $disable; @endphp data-form-field>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
