@extends("layouts.leadpops-inner-sidebar")

@section('content')

    @include("partials.flashmsgs")
    @php
  //  dd($view);

    @endphp
    <!-- contain main informative part of the site -->
    <main class="main">
        <!-- content of the page -->
        <section class="main-content">
            <!-- Title wrap of the page -->
        @php LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view); @endphp

        <!-- content of the page -->
            <div class="lp-panel lp-panel__pb-0 lp-panel__body_lead-alert">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h2 class="lp-panel__title">
                            Current Lead Recipients
                        </h2>
                    </div>
                    <div class="col-right">
                        <a class="button button-primary lp-btn-addRecipient" href="#" data-toggle="modal"
                           data-target="#lead-recipients">add recipient</a>
                    </div>
                </div>
                <div class="lp-panel__body p-0 lp-panel__body_lead-alert">
                    <div class="lp-table">
                        <div class="lp-table__head">
                            <ul class="lp-table__list">
                                <li class="lp-table__item"><span>Full Name</span></li>
                                <li class="lp-table__item"><span>Email Address</span></li>
                                <li class="lp-table__item"><span>Cell Number</span></li>
                                <li class="lp-table__item"><span>Options</span></li>
                            </ul>
                        </div>
                        <div class="lp-table__body">
                            @php
                                if($view->data->recipients){
                                    $emailrecipients = array();
                                    foreach ($view->data->recipients as $i=>$recipient){
                                        //if (!in_array($recipient['email_address'],$emailrecipients)){
                                            //$emailrecipients[] = $recipient['email_address'];
                            @endphp
                            <div class="lp-table-item lead-alert-data">
                                <ul class="lp-table__list" id="rcp_{{ $recipient['id'] }}">
                                    <li class="lp-table__item lead-alert-full-name"><span>@if(!empty($recipient['full_name'])) {{ $recipient['full_name'] }} @else {{ "N/A" }} @endif</span></li>
                                    <li class="lp-table__item"><span class="lead-alert-email-address">{{ $recipient['email_address'] }}</span></li>
                                    <li class="lp-table__item lead-alert-cell"><span>@if($recipient['phone_number'] != "") {{ $recipient['phone_number'] }} @else {{ "N/A" }} @endif</span></li>
                                    <li class="lp-table__item">
                                        <div class="action action_options">
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <a href="#" class="action__link edit-recipient"
                                                       data-id="{{ $recipient['id'] }}" data-name="{{ $recipient['full_name'] }}" data-email="{{ $recipient['email_address'] }}"
                                                       data-cell="{{ $recipient['phone_number'] }}"
                                                       data-carrier="{{ $recipient['carrier'] }}" data-text="Edit">
                                                        <span class="ico ico-edit"></span>edit
                                                    </a>
                                                </li>
                                                @if($recipient['is_primary'] == 'n')
                                                    <li class="action__item">
                                                        <a href="#" class="action__link remove-recipient"
                                                           data-id="{{ $recipient['id'] }}"
                                                           data-clientid="{{ $recipient['client_id'] }}">
                                                            <span class="ico ico-cross"></span>delete
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                                <div class="lp-table__item-msg">
                                    <div class="lp-table__item-confirmation">
                                        <p>Are you sure you want to remove this lead recipient?</p>
                                        <ul class="control">
                                            <li class="control__item">
                                                <a href="javascript:void(0);" class="lp-table_yes">Yes</a>
                                            </li>
                                            <li class="control__item">
                                                <a href="javascript:void(0);" class="lp-table_no">No</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @php    // }
                                }
                            }else{ @endphp
                                <div class="lead-alert-col lead-alert-data" id="0">
                                    <div class="alert alert-info">No recipients for this leadPop</div>
                                </div>
                            @php } @endphp

                        </div>
                    </div>
                </div>
            </div>
            <!-- content of the page -->

            <!-- footer of the page -->
            <div class="footer">
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                </div>
            </div>
        </section>
    </main>


    <!-- Model Boxes - Start -->
    <div class="modal fade" id="modal_delete_domain" data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="modal_delete_domain"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                </div>
                <div class="modal-body">
                    <div class="modal-msg mb-0"></div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary _delete_btn">Delete</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="lead-recipients" data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="lead-recipients"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="fnewrecipient" name="fnewrecipient" method="post"

                      data-global_action="{{ LP_BASE_URL.LP_PATH }}/global/saveNewRecipientGlobalAdminThree"
                      data-action="{{LP_PATH}}/account/saveNewRecipientAdminThree"
                      action=""
                      class="form-pop recipient-form global-content-form">
                    {{csrf_field()}}
                    <div class="modal-header">
                        <h5 class="modal-title">Add Recipient</h5>
                    </div>
                    <div class="modal-body pb-0 quick-scroll">
                        <div class="alert d-none model_notification"></div>
                        <input type="hidden" name="newkeys" id="newkeys" value="{{ $view->data->keys }}">
                        <input type="hidden" name="newclient_id" id="newclient_id" value="{{ $view->data->client_id }}">
                        <input type="hidden" name="clickedkey" id="clickedkey" value="{{ @$view->data->lpkeys }}">
                        <input type="hidden" name="editrowid" id="editrowid" value="">
                        <input type="hidden" name="isnewrowid" id="isnewrowid" value="">
                        <input type="hidden" name="current_hash" id="current_hash"
                               value="@php echo @$view->data->currenthash @endphp">
                        <input type="hidden" name="lp_auto_recipients_id" id="lp_auto_recipients_id" value="">
                        <input name="lpkey_recip" id="lpkey_recip" type="hidden" value="">
                        <input name="old_email" id="old_email" type="hidden" value="">
                        <div class="form-group">
                            <label for="full_name" class="modal-lbl">Full Name</label>
                            <div class="input__holder">
                                <input id="full_name" name="full_name" class="form-control" type="text" autocomplete="off" data-form-field>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="modal-lbl">Email Address</label>
                            <div class="input__holder">
                                <input id="newemail" name="newemail" class="form-control" type="text" autocomplete="off" data-form-field>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="modal-lbl">Text Cellphone</label>
                            <div class="input__holder">
                                <div class="radio">

                                    <ul class="radio__list">
                                        <li class="radio__item">
                                            <input class="lp-popup-radio" type="radio" id="newtextcell_yes"
                                                   name="newtextcell" value="y" data-form-field>
                                            <label class="radio__lbl" for="newtextcell_yes">Yes</label>
                                        </li>
                                        <li class="radio__item">
                                            <input class="lp-popup-radio" type="radio" id="newtextcell_no"
                                                   name="newtextcell" value="n" checked="" data-form-field>
                                            <label class="radio__lbl" for="newtextcell_no" val="no">No</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="textToggleCtrl pb-4">
                            <div class="form-group">
                                <label class="modal-lbl">Cellphone Number</label>
                                <div class="input__holder">
                                    <input id="cell_number" name="cell_number" placeholder="(___) ___-____"
                                           class="form-control" type="text" data-form-field>
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
                                                class="form-control select2js__cell-carrier" data-form-field>
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
                                    <button type="button" class="button button-cancel" data-dismiss="modal">Cancel
                                    </button>
                                </li>
                                <li class="action__item">
                                    <input id="edit_rcpt" class="button button-primary _add_recipient_btn" type="submit"
                                           value="add recipient">
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <form id="deleteRecipientForm" name="deleteRecipientForm" method="post"

          data-global_action="{{ LP_BASE_URL.LP_PATH }}/global/deleteRecipientGlobalAdminThree"
          data-action="{{LP_PATH}}/account/deleteleadrecipient"
          action=""
          class="form-pop recipient-form global-content-form">
        {{csrf_field()}}
        <input name="recipient_id" id="del_recipient_id" type="hidden">
        <input name="client_id" id="del_client_id" type="hidden">
        <input type="hidden" name="current_hash" id="current_hash"
               value="@php echo @$view->data->currenthash @endphp">
        <input type="hidden" name="clickedkey" id="clickedkey" value="{{ @$view->data->lpkeys }}">

    </form>
    <!-- Model Boxes - End -->
@endsection
