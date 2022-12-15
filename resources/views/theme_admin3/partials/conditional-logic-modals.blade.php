<!-- Conditional Logic Group Modal -->
<div class="modal fade conditional-logic-group-modal" id="conditional-logic-group" data-keyboard="false" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            {{--<div class="alert cl_model_notification hide"></div>--}}
            <form id="condition-logic-form" autocomplete="off" name="condition-logic-form" method="post"
                  data-actionmain="{{route('saveconditionlogic')}}"
                  class="condition-logic-form"
                  data-action="{{route('saveconditionlogic')}}"
                  action="">
                @csrf
                <input type="hidden" name="client_leadpop_id" id="client_leadpop_id" value="{{ $view->data->funnelData['client_leadpop_id'] }}">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash  }}">
                <div class="modal-header">
                    <div class="title-holder">
                        <strong class="modal-title">Conditional Logic</strong>
                        <span class="text">Offer intelligent Funnels to your users based on their selections</span>
                    </div>
                    <div class="switcher-min">
                        <div class="funnel-checkbox">
                            <label class="checkbox-label">
                                <input class="fb-field-label" id="active" name="active" type="checkbox" conditional-logic-checkbox checked>
                                <span class="checkbox-area">
                                    <span class="handle"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-body-wrap">
                    <div class="modal-body conditional-modal-quick-scroll">
                        <div class="modal-body-inner">
                            <div class="conditional-select-area">
                                <div class="conditional-select-wrap">
                                    <div class="form-group">
                                        <label class="label-text">IF</label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-question-parent select2-parent select2js__nice-scroll">
                                                    <select class="select-question" data-dropdown-entity="cl-questions" id="trigger_id" name="trigger_id" >
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Operators List -->
                                    <div class="form-group">
                                        <label class="label-text"></label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-conditional-parent select2-parent select2js__nice-scroll disabled">
                                                    <select data-dropdown="select2" data-dropdown-entity="cl-triggers" class="select-conditional" id="operator" name="operator" >
                                                        <option value="1">Select Conditional</option>
                                                        <option value="is">Is</option>
                                                        <option value="is-not">Is not</option>
                                                        <option value="is-any">Is any of</option>
                                                        <option value="is-none">Is none of</option>
                                                        <option value="is-known">Is known</option>
                                                        <option value="is-unknown">Is unknown</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Input Type: Menu (Single + Multiple) -->
                                    <div class="form-group mb-0" data-input-field-type="menu">
                                        <label class="label-text"></label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-answer-parent select2-parent select2js__nice-scroll disabled" data-input-markup>
                                                    <select class="select-answer" data-dropdown-entity="answers-options" >
                                                        <option value="answer-option">Select Answer</option>
                                                        <option value="zip-option">Enter Zip Code(s)</option>
                                                        <option value="state-option">Select States From a List</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Input Type: modal (Single + Multiple  Car Model) -->
                                    <div class="select-code-field-make" data-input-field-type="select-vehicle-model" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <a href="#" data-toggle="modal" data-target="#select-vehicle-model" class="select-vehicle-opener">Select Vehicle Model <i class="arrow"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Input Type: modal (Single + Multiple  Car Make) -->
                                    <div class="select-code-field-make" data-input-field-type="select-vehicle-make" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <a href="#" data-toggle="modal" data-target="#select-vehicle-make" class="select-vehicle-opener">Select Vehicle Make <i class="arrow"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Input Type: TEXT -->
                                    <div class="zip-code-field-slide" data-input-field-type="text" style="display: none">
                                        <div class="form-group" data-text-field="single">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field cl-zip-state-input-field cl-model-reopener" id="cl-zip-state-input-field" data-input-markup>

                                                        <!-- Dynamically append field here with JS -->
                                                        <textarea name="cl_value[]" class="form-control-textarea textarea-field" data-type="zipcode" placeholder="Type in Zip Code(s)"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Input Type: Number -->
                                    <div class="zip-code-field-slide" data-input-field-type="number" style="display:none">
                                        <div class="form-group" data-text-field="single">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field cl-zip-state-input-field cl-model-reopener" id="cl-zip-state-input-field" data-input-markup>
                                                        <!-- Dynamically append field here with JS -->
                                                        <input autocomplete="off" type="text" name="cl_value[]" class="form-control number-field" placeholder="Type in Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Input Type: Text-Multi - Input for Between Operator -->
                                    <div class="zip-code-field-slide" data-input-field-type="text-multiple" style="display: none">
                                        <div class="form-group" data-text-field="multiple">
                                            <label class="label-text"></label>
                                            <div class="select-area two-cols">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <input data-cl-range="start" autocomplete="off" type="text" name="cl_value[]" class="form-control"
                                                               placeholder="Type in Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <input data-cl-range="end" autocomplete="off" type="text" name="cl_value[]" class="form-control"
                                                               placeholder="Type in Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Input Type: Zipcode - States Modal -->
                                    <div class="select-code-field-slide" data-input-field-type="zipcode-states" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <a href="#" data-toggle="modal" data-target="#select-state-modal" class="select-states-opener">Select States <i class="arrow"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Input Type: bd-text Birthday text fields -->
                                    <div class="form-group mb-0 birthday-field" data-input-field-type="bd-text" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field date-picker-parent" date-picker-wrapper>
                                                    <div class="input-field" id="" data-input-markup>
                                                        <input cl-datepicker autocomplete="off" type="text" data-cl-bd-date="" id="cl-value" name="cl_value[]" class="form-control bdtext bd-field" placeholder="MM/DD/YYYY" maxlength="10">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Input Type: BD Text-Multi - Input for Between Operator BD -->
                                    <div class="form-group mb-0 birthday-field" data-input-field-type="bd-text-multiple"
                                         style="display: none">
                                        <div class="form-group" data-text-field="bd-multiple">
                                            <label class="label-text"></label>
                                            <div class="select-area two-cols">
                                                <div class="select-field date-picker-parent" cl-start-datepicker-wrapper>
                                                    <div class="input-field">
                                                        <input cl-start-datepicker data-cl-bw-bd-date="start" autocomplete="off" type="text" name="cl_value[]" class="form-control bd-field" placeholder="MM/DD/YYYY" maxlength="10">
                                                    </div>
                                                </div>
                                                <div class="select-field date-picker-parent" cl-end-datepicker-wrapper>
                                                    <div class="input-field">
                                                        <input cl-end-datepicker data-cl-bw-bd-date="end" autocomplete="off" type="text" name="cl_value[]" class="form-control bd-field" placeholder="MM/DD/YYYY" maxlength="10">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- THEN CASES -->
                            <div class="conditional-select-area then-cases">
                                <!-- Reapter Template -->
                                <div class="conditional-select-wrap hidden">
                                    <div class="form-group mb-0">
                                        <label class="label-text">THEN</label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-action-parent select2-parent select2js__nice-scroll">
                                                    <select data-dropdown-entity="cl-actions" data-actiontype="actions" class="select-action" name="actions[]">
                                                        <option value="">Select Action</option>
                                                        <option value="action.Show">Show Questions</option>
                                                        <option value="action.Hide">Hide Questions</option>
                                                        <option value="thankyou">Show Specific Thank You Page</option>
                                                        <option value="recipient">Change Lead Alert Recipient</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <span class="btn-wrap disabled">
                                                <a href="#" class="add-row" data-repeater-then="add"><i class="ico-plus"></i></a>
                                                <a href="#" class="remove-row" data-repeater-then="remove"><i class="ico-cross"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="show-queston-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="show-question-parent select2-parent select2js__nice-scroll">
                                                        <select class="show-question" data-dropdown-entity="cl-actions-questions" name="actions_question[]" >
                                                        </select>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap disabled">
                                                    <a href="#" class="add-row" data-repeater-then="add"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row" data-repeater-then="remove"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recipients-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <div data-receipient-opener="thencase" data-toggle="modal" data-url="{{route('get.all.recipients',[LP_Helper::getInstance()->getFunnelData()['current_hash']])}}"
                                                             class="select-receipient-opener quick-scroll">
                                                            <div class="scroll-wrap">
                                                                <span data-cl-then-recipient class="placeholder-text">Select Recipients</span>
                                                                <i class="arrow"></i>
                                                                <input data-cl-then-action-recipients type="hidden" name="actions_recipients[]" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap disabled">
                                                    <a href="#" class="add-row" data-repeater-then="add"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row" data-repeater-then="remove"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- First Then Criteria -->
                                <div class="conditional-select-wrap" data-repeater="1">
                                    <div class="form-group mb-0">
                                        <label class="label-text">THEN</label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-action-parent select2-parent select2js__nice-scroll">
                                                    <select data-dropdown-entity="cl-actions" data-actiontype="actions" class="select-action" name="actions[]">
                                                        <option value="">Select Action</option>
                                                        <option value="action.Show">Show Questions</option>
                                                        <option value="action.Hide">Hide Questions</option>
                                                        <option value="thankyou">Show Specific Thank You Page</option>
                                                        <option value="recipient">Change Lead Alert Recipient</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <span class="btn-wrap disabled">
                                                <a href="#" class="add-row" data-repeater-then="add"><i class="ico-plus"></i></a>
                                                <a href="#" class="remove-row" data-repeater-then="remove"><i class="ico-cross"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="show-queston-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="show-question-parent select2-parent select2js__nice-scroll">
                                                        <select class="show-question" data-dropdown-entity="cl-actions-questions" name="actions_question[]" >
                                                        </select>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap disabled">
                                                    <a href="#" class="add-row" data-repeater-then="add"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row" data-repeater-then="remove"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recipients-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <div data-receipient-opener="thencase" data-toggle="modal" data-url="{{route('get.all.recipients',[LP_Helper::getInstance()->getFunnelData()['current_hash']])}}"
                                                             class="select-receipient-opener quick-scroll">
                                                            <div class="scroll-wrap">
                                                                <span data-cl-then-recipient class="placeholder-text">Select Recipients</span>
                                                                <i class="arrow"></i>
                                                                <input data-cl-then-action-recipients type="hidden" id="actions_recipients" name="actions_recipients[]" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap disabled">
                                                    <a href="#" class="add-row" data-repeater-then="add"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row" data-repeater-then="remove"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Dynamic Reapter Input appends here -->
                            </div>

                            <!-- ALL OTHER CASES -->
                            <div class="conditional-select-area other-case-parent">
                                <div class="conditional-select-wrap">
                                    <div class="form-group other-case mb-0">
                                        <label class="label-text"><span>In</span> ALL <span>other cases</span></label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-action-other-parent select2-parent select2js__nice-scroll">
                                                    <select data-dropdown-entity="cl-actions" data-actiontype="alt_actions" class="select-action-other"  name="alt_actions[]" >
                                                        <option value="">Select Action</option>
                                                        <option value="action.Show">Show Questions</option>
                                                        <option value="action.Hide">Hide Questions</option>
                                                        <option value="thankyou">Show Specific Thank You Page</option>
                                                        <option value="recipient">Change Lead Alert Recipient</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-cl-all-action-select="show-queston-slide" class="show-queston-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="show-question-parent select2-parent select2js__nice-scroll">
                                                        <select class="show-question" data-dropdown-entity="cl-actions-questions" id="alt_actions_question" name="alt_actions_question[]" >
                                                        </select>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap">
                                                    <a href="#" class="add-row"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-cl-all-action-select="recipients-slide" class="recipients-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <div data-receipient-opener="allcases" data-toggle="modal"
                                                             {{--data-target="#select-recipient-modal"--}}
                                                             data-url="{{route('get.all.recipients',[LP_Helper::getInstance()->getFunnelData()['current_hash']])}}"
                                                             class="select-all-receipient-opener quick-scroll">
                                                            <div class="scroll-wrap">
                                                                <span data-cl-all-recipient class="placeholder-text">Select Recipients</span>
                                                                <i class="arrow"></i>
                                                                <input data-cl-all-action-recipients type="hidden" id="alt_actions_recipients" name="alt_actions_recipients[]">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap">
                                                    <a href="#" class="add-row"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" data-toggle="modal" data-get-listing-conditions data-target="#active-condition-modal" class="active-condition-link">active conditions</a>
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel close-cl-form" id="cancel-cl-form">cancel</button>
                            </li>
                            <li class="action__item">
                                <button type="submit" id="edit_cl" class="button button-bold button-primary
                                _add_cl_btn button-animation">
                                    <span class="spiner-wrap">Save<span class="spiner"></span></span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Select State Modal -->
<div class="modal fade select-state-modal conditional-logic-modals" id="select-state-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title">Select States</strong>
            </div>
            <div class="modal-body">
                <div class="search-area">
                    <div class="input-holder">
                        <input type="search" id="cl-state-search-txt" class="form-control states-search" placeholder="Type in the State Name...">
                        <button type="button" id="cl-state-search-btn" class="search-btn"><i class="ico-search"></i></button>
                        <span class="clear-search-field" clear-search-states>Clear Search</span>
                    </div>
                </div>
                <div class="check-area">
                    <div class="check-head"data-state-top-box>
                        <div class="checkbox-wrap">
                            <label class="checkbox-label">
                                <input type="checkbox" class="state-all-checked">
                                <span class="checkbox-text"><i class="icon"></i> Select all States</span>
                            </label>
                        </div>
                        <a href="#" class="reset-btn state-reset-btn"><i class="ico-undo"></i>reset</a>
                    </div>
                    <div class="check-body">
                        <div class="check-list-wrap">
                            <ul class="check-list" id="cl-state-list">
                                @foreach ($view->data->states as $state)
                                    <li data-states-list>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox" value="{{ $state['StateFullName'] }}">
                                                <span class="checkbox-text"><i class="icon"></i>{{ $state['StateFullName'] }}</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div data-empty-states class="item-wrap condition-message-block-parent d-none">
                               <div class="condition-message-block">
                                  <span class="icon-wrap"><i class="ico-search"></i></span>
                                  <span class="condition-message-text" data-states-empty-case-span>No states Available</span>
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
                            <button type="button" class="button button-bold button-cancel state-modal-close" data-dismiss="modal">close</button>
                        </li>
                        <li class="action__item">
                            <button id="cl-state-save-btn" class="button button-bold button-primary state-save-btn" type="button" disabled>select</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Select Vehicle Model -->
<div class="modal fade select-vehicle-modal conditional-logic-modals" id="select-vehicle-model">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title">Select Vehicle Model</strong>
            </div>
            <div class="modal-body">
                <div class="search-area">
                    <div class="input-holder">
                        <input type="search" id="cl-model-search-field"  data-vehicle_model_search_field class="form-control " placeholder="Type Model Name...">
                        <button type="button"  data-vehicle_model_search_btn onclick="vehicleMakeModel.makeAndModelSearch(event,'model')" class="search-btn"><i class="ico-search"></i></button>
                         <span class="clear-search-field" data-clearmodel-search onclick="vehicleMakeModel.clearSearchField('model')">Clear Search</span>
                    </div>
                </div>
                <div class="check-area">
                    <div class="check-head"data-model-top-box>
                        <div class="checkbox-wrap">
                            <label class="checkbox-label">
                                <input type="checkbox" class="model-all-checked">
                                <span class="checkbox-text"><i class="icon"></i> Select all Models</span>
                            </label>
                        </div>
                        <a href="#" class="reset-btn model-reset-btn"><i class="ico-undo"></i>reset</a>
                    </div>
                    <div class="check-body">
                        <div class="check-list-wrap">
                            <ul class="check-list" id="cl-model-list">
                                @foreach ($view->data->vehicleModels as $model)
                                    <li data-model-list="{{  trim($model['model']) }}">
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input data-input-checkbox-vehicle="model" class="model-checkbox" value="{{ trim($model['model']) }}">
                                                <span class="checkbox-text"><i class="icon"></i>{{ trim($model['model']) }}</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div data-empty-model class="item-wrap condition-message-block-parent d-none">
                                <div class="condition-message-block">
                                    <span class="icon-wrap"><i class="ico-search"></i></span>
                                    <span class="condition-message-text" data-model-empty-case-span>No Model Available</span>
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
                            <button type="button" class="button button-bold button-cancel model-modal-close" data-dismiss="modal">close</button>
                        </li>
                        <li class="action__item">
                            <button id="cl-model-save-btn" class="button button-bold button-primary model-save-btn" type="button" >select</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Select Vehicle Make -->
<div class="modal fade select-vehicle-make conditional-logic-modals" id="select-vehicle-make">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title">Select Vehicle Make</strong>
            </div>
            <div class="modal-body">
                <div class="search-area">
                    <div class="input-holder">
                        <input type="search" id="cl-make-search-field" data-vehicle_make_search_field class="form-control" placeholder="Type Make Name...">
                        <button type="button" data-vehicle_make_search_btn onclick="vehicleMakeModel.makeAndModelSearch(event,'make')" class="search-btn"><i class="ico-search"></i></button>
                        <span class="clear-search-field" data-clearMake-search  onclick="vehicleMakeModel.clearSearchField('make')">Clear Search</span>
                    </div>
                </div>
                <div class="check-area">
                    <div class="check-head"data-make-top-box>
                        <div class="checkbox-wrap">
                            <label class="checkbox-label">
                                <input type="checkbox" class="make-all-checked">
                                <span class="checkbox-text"><i class="icon"></i> Select all Makes</span>
                            </label>
                        </div>
                        <a href="#" class="reset-btn model-reset-btn"><i class="ico-undo"></i>reset</a>
                    </div>
                    <div class="check-body">
                        <div class="check-list-wrap">
                            <ul class="check-list" id="cl-make-list">
                            @foreach ($view->data->vehicleMake as $make)
                                    <li data-make-list ={{ trim($make['make'])}}>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input  data-input-checkbox-vehicle="make"   class="make-checkbox" value="{{ trim($make['make']) }}">
                                                <span class="checkbox-text" ><i class="icon"></i>{{ trim($make['make'])}}</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div data-empty-make class="item-wrap condition-message-block-parent d-none">
                                <div class="condition-message-block">
                                    <span class="icon-wrap"><i class="ico-search"></i></span>
                                    <span class="condition-message-text" data-make-empty-case-span>No Make Available.</span>
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
                            <button type="button" class="button button-bold button-cancel make-modal-close" data-dismiss="modal">close</button>
                        </li>
                        <li class="action__item">
                            <button id="cl-make-save-btn" class="button button-bold button-primary make-save-btn" type="button" >select</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Select Recipient Modal -->
<div class="modal fade select-recipient-modal conditional-logic-modals" id="select-recipient-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title">Select Recipient(s)</strong>
            </div>
            <div class="modal-body">
                <form onsubmit="pressEnterSearch(event)" method="post" autocomplete="off" id="select_recipient_search_form">
                    <div class="search-area">

                        <div class="input-holder">
                            <input type="search" data-recipients_search_field  onkeyup="pressEnterSearch(event)" name="recipients_search_field" class="form-control recipient-search" placeholder="Type in the Recipient name or email">
                            <button type="button" data-search-btn-leadrecipient onclick="searchRecipients(event)" class="search-btn"><i class="ico-search"></i></button>
                            <span class="clear-search-field" clear-search-recipient>Clear Search</span>
                        </div>
                    </div>
                </form>
                <div class="check-area">
                    <div class="check-head">
                        <div class="checkbox-wrap"
                             id="recipient-all-checked">
                            <label class="checkbox-label">
                                <input type="checkbox"  data-all-checked class="recipient-all-checked">
                                <span class="checkbox-text"><i class="icon"></i>Select all Recipients</span>
                            </label>
                        </div>
                        <a href="#" class="reset-btn recipient-reset-btn"><i class="ico-undo"></i>reset</a>
                    </div>
                    <div class="check-body">
                        <div class="check-list-wrap" data-recipients-html data-id="checkLists">
                            <!-- Dynamic Data -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="new-recipient-opener" data-toggle="modal" data-target="#lead-recipients">add new recipient</a>
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel recipient-modal-close" data-dismiss="modal">close</button>
                        </li>
                        <li class="action__item">
                            <button data-recipient-caller="" data-recipient-num="1" class="button button-bold button-primary recipient-save-btn" type="button">save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lead Recipient Modal -->
<div class="modal fade lead-recipients-modal conditional-logic-modals-modals" id="lead-recipients-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="lead-recipients-form" method="post" autocomplete="off" data-actionmain="{{route('save.recipients')}}" class="lead-recipient-form" action="{{route('save.recipients')}}" >
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Recipient</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="newkeys" id="newkeys" value="{{ $view->data->recipients['keys'] }}">
                    <input type="hidden" name="newclient_id" id="newclient_id" value="{{ $view->data->recipients['client_id'] }}">
                    <input type="hidden" name="clickedkey" id="clickedkey" value="{{ @$view->data->recipients['lpkeys'] }}">
                    <input type="hidden" name="editrowid" id="editrowid" value="">
                    <input type="hidden" name="isnewrowid" id="isnewrowid" value="y">
                    <input type="hidden" name="current_hash" id="current_hash" value="{{@$view->data->recipients['currenthash']}}">
                    <input type="hidden" name="lp_auto_recipients_id" id="lp_auto_recipients_id" value="">
                    <input name="lpkey_recip" id="lpkey_recip" type="hidden" value="">
                    <input name="old_email" id="old_email" type="hidden" value="">

                    <div class="form-group">
                        <label for="full-name" class="modal-lbl">Full Name</label>
                        <div class="input__holder">
                            <input type="text" id="full_name" name="full_name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email-address" class="modal-lbl">Email Address</label>
                        <div class="input__holder">
                            <input type="text" id="email_address" name="newemail" data-email-leadrecipents class="form-control">
                        </div>
                    </div>
                    <div class="form-group cell-phone-field">
                        <label class="modal-lbl">Text Cellphone</label>
                        <div class="input__holder">
                            <div class="radio">
                                <ul class="radio__list">
                                    <li class="radio__item">
                                        <input class="lp-popup-radio celphone-radio" type="radio" id="cell-text-yes" name="new-cell" value="y">
                                        <label class="radio__lbl" for="cell-text-yes" val="yes">Yes</label>
                                    </li>
                                    <li class="radio__item">
                                        <input class="lp-popup-radio celphone-radio" type="radio" id="cell-text-no" name="new-cell" value="n" checked>
                                        <label class="radio__lbl" for="cell-text-no" val="no">No</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="cell-number-slide">
                        <div class="form-group">
                            <label class="modal-lbl">Cellphone Number</label>
                            <div class="input__holder">
                                <input id="cel-number"  name="cell_number" placeholder="(___) ___-____"
                                       class="form-control" type="tel" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="modal-lbl">
                                Cell Carrier <a href="https://freecarrierlookup.com/" target="popup"
                                                class="carrier-lookup-link">(Carrier Lookup)</a>
                            </label>
                            <div class="input__holder">
                                <div class="select2 select2js__cell-carrier-parent select2js__nice-scroll">
                                    <select id="cell_carrier" name="carrier"
                                            class="form-control select2js__cell-carrier"  data-dropdown="select2"   data-form-field>
                                        <option value="">Select</option>
                                        {!! View_Helper::getInstance()->getCarriers() !!}
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel lead-recipients-modal-close" data-dismiss="modal">Cancel</button>
                            </li>
                            <li class="action__item">
                                <button id="add-recipient-btn" type="submit" class="button button-primary add-recipient-btn">add recipient</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Active Condition Modal -->
<div class="modal fade active-condition-modal conditional-logic-modals" id="active-condition-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Total Conditions: <span id="cl_total" class="total-no"></span></h5>
                <div class="switcher-wrap">
                    <div class="switcher-min">
                        <div class="funnel-checkbox">
                            <label class="checkbox-label">
                                <input class="fb-field-label" type="checkbox" cl-listing-checkbox >
                                <span class="checkbox-area">
                                        <span class="handle"></span>
                                    </span>
                            </label>
                        </div>
                    </div>
                    <div class="status-tooltip-block">
                        <div class="status-tooltip-wrap">
                            <strong class="title">conditions status </strong>
                            <ul class="condition-status-list">
                                <li class="active">Active: <strong id="cl_total_active">4</strong> Conditions </li>
                                <li class="inactive">Inactive: <strong id="cl_total_inactive">1</strong> Condition </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="search-area">
                    <div class="input-holder">
                        <input type="search" search-field-conidition-lisiting class="form-control query-search" placeholder="Enter a search query...">
                        <button type="button" search-btn-conidition-lisiting class="search-btn"><i class="ico-search"></i></button>
                        <span class="clear-search-field" clear-search-conidition>Clear Search</span>
                    </div>
                </div>
                <div class="check-area">
                    <div class="check-head" data-condition-list-global-controls>
                        <div class="checkbox-wrap" data-check-all-cl>
                            <label class="checkbox-label">
                                <input type="checkbox" class="condition-all-checked">
                                <span class="checkbox-text"><i class="icon"></i>Select all Conditions</span>
                            </label>
                        </div>
                        <a href="#cl-confirmation-delete" id="multi-delete-btn" data-toggle="modal" class="delete-select-btn reset-btn" data-deleteBtn><i class="ico-cross"></i>Delete selected</a>
                    </div>
                    <div class="check-body-holder">
                        <div class="check-body-sorting">
                            <div class="check-list-wrap">
                                <ul class="active-condition-list" data-show-condition-list>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <ul class="links-list">
                    <li><a href="#" class="active-condition-modal-close" data-dismiss="modal">back</a></li>
                    <li><a href="#" class="add-condition-link">add new condition</a></li>
                </ul>
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" data-condition-modal-close="" class="button button-cancel active-condition-modal-close">Cancel</button>
                        </li>
                        <li class="action__item">
                            <button id="edit-rcpt" type="submit" class="button button-primary cl_btn_finish">finish</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Condition Status Modal -->
<div class="modal fade condition-modal-status" id="condition-modal-status">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Condition Status</h5>
            </div>
            <div class="modal-body">
                <div class="form-group ">
                    <label class="label-text" >Select Condition Status</label>
                    <input id="toggle-status" name="toggle-status" data-toggle="toggle" data-value data-onstyle="active" data-offstyle="inactive" data-width="127" data-height="43" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                </div>
            </div>
            <div class="modal-footer">
                <a href="#cl-confirmation-delete" data-toggle="modal"  id="cl-status-delete" class="delete-condition-btn single-delete-btn"  >delete condition</a>
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-cancel status-modal-close" data-dismiss="modal">cancel</button>
                        </li>
                        <li class="action__item">
                            <button type="button" id="status-save-btn"  class="button button-primary">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Question Conditional Logic modal -->
<div class="modal fade confirmation-delete" id="cl-confirmation-delete">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Condition</h5>
            </div>
            <div class="modal-body">
                <p class="modal-msg modal-msg_light mb-0">
                    Are you sure, you want to delete?
                </p>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" id="" data-from value="no" data-no-never-mind-btn
                                    data-dismiss="modal" >
                                No, Never Mind
                            </button>
                        </li>
                        <li class="action__item">
                            <input type="hidden" data-id="deleteId">
                            <button data-span-value class="button button-bold button-primary confirm-delete delete-select-button" id="delete-condition-btn" type="button">
                                Yes, Delete
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

