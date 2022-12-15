@extends("layouts.leadpops")

@section('content')

<div class="container">
    @php
        LP_Helper::getInstance()->getFunnelHeader($view);
    @endphp

    <form class="form-inline" method="post">
        {{csrf_field()}}
        <div class="lead-alert-section lead-alert">
            <div class="lead-alert-heading">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="lead-alert-title">Current Lead Recipients</h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a class="btn btn-default pull-right lp-btn-addRecipient" data-text="Add">ADD Recipient</a>
                    </div>
                </div>
            </div>

            <div class="lead-alert-col">
                <div class="row">
                    <div class="col-sm-4"><h3 class="lead-alert-caption lead-alert-email-address">Email Address</h3></div>
                    <div class="col-sm-4"><h3 class="lead-alert-caption lead-alert-cell" >Cell Number</h3></div>
                    <div class="col-sm-4"><h3 class="lead-alert-caption lead-alert-option">Options</h3></div>
                </div>
            </div>

            <div id="RecipientRowTemplate" class="hide">
                <div class="lead-alert-col lead-alert-data" id="#rcp_ROWID#">
                    <div class="row">
                        <div class="col-sm-4"><h4 class="lead-alert-email-address">#EMAIL#</h4></div>
                        <div class="col-sm-4"><h4 class="lead-alert-cell">#CELL#</h4></div>
                        <div class="col-sm-4">
                            <h5 class="lead-alert-action">
                                <a href="#" data-id="#EDIT-ROWID#" data-email="#EMAIL2#" data-cell="#CELL2#" data-carrier="#CARRIER#" data-text="Edit" class="edit-form edit-recipient"><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                <a href="#" data-id="#DELETE-ROWID#" data-clientid="#DELETE-CLIENTID#" class="del remove-recipient"><i class="fa fa-remove"></i>DELETE</a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            @php
            if($view->data->recipients){
                $emailrecipients = array();
	            foreach ($view->data->recipients as $i=>$recipient){
                    if (!in_array($recipient['email_address'],$emailrecipients)){
                        $emailrecipients[] = $recipient['email_address'];
                 @endphp
                    <div class="lead-alert-col lead-alert-data" id="rcp_{{ $recipient['id'] }}">
                        <div class="row">
                            <div class="col-sm-4"><h4 class="lead-alert-email-address">{{ $recipient['email_address'] }}<em>@if($recipient['is_primary']=='y') {{ " (Primary)" }} @endif</em></h4></div>
                            <div class="col-sm-4"><h4 class="lead-alert-cell">@if($recipient['phone_number'] != "") {{ $recipient['phone_number'] }} @else {{ "-" }} @endif</h4></div>
                            <div class="col-sm-4">
                                <h5 class="lead-alert-action">
                                    <a href="#" data-id="{{ $recipient['id'] }}" data-email="{{ $recipient['email_address'] }}" data-cell="{{ $recipient['phone_number'] }}" data-carrier="{{ $recipient['carrier'] }}" data-text="Edit" class="edit-form edit-recipient"><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                    @php
                                    if($recipient['is_primary'] == 'n') {
                                        @endphp
                                        <a href="#" data-id="{{ $recipient['id'] }}" data-clientid="{{ $recipient['client_id'] }}" class="del remove-recipient"><i class="fa fa-remove"></i>DELETE</a>
                                        @php
                                    }
                                     @endphp
                                </h5>
                            </div>
                        </div>
                    </div>
                    @php
                    }
		        }
            }else{
	             @endphp
                <div class="lead-alert-col lead-alert-data" id="0">
                    <div class="alert alert-info">No recipients for this leadPop</div>
                </div>
	            @php
            }
                @endphp
        </div>
    </form>
</div>
<div class="modal fade add_recipient" id="recipient_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Recipient</h3>
            </div>
            <div class="modal-body recipient-body">
                <div class="row">
                    <form name="fnewrecipient"  id="fnewrecipient" action="{{LP_PATH}}/account/savenewrecipient" method="POST" class="lp-popup-form recipient-form">
                       {{csrf_field()}}
                        <input type="hidden" name="newkeys" id="newkeys" value="{{ $view->data->keys }}">
                        <input type="hidden" name="newclient_id" id="newclient_id" value="{{ $view->data->client_id }}">
                        <input type="hidden" name="editrowid" id="editrowid" value="">
                        <input type="hidden" name="isnewrowid" id="isnewrowid" value="">
                        <input type="hidden" name="lp_auto_recipients_id" id="lp_auto_recipients_id" value="">
                        <input name="lpkey_recip" id="lpkey_recip" type="hidden" value="">

                        <div class="alert hide model_notification"></div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label class="control-label" for="edit_email">Email Address</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="email"  name="newemail" class="form-control custom-control" id="newemail">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label class="radio-control-label lable-weight">Text Cellphone</label>
                                </div>
                                <div class="col-sm-7">
                                    <span class="radio-inline">
                                        <input type="radio" class="lp-popup-radio" value="y" id="newtextcell_yes" name="newtextcell" />
                                            <label class="radio-control-label" for="newtextcell_yes"><span></span>Yes</label>
                                    </span>
                                    <span class="radio-inline">
                                        <input type="radio" class="lp-popup-radio" value="n" checked id="newtextcell_no" name="newtextcell" />
                                        <label class="radio-control-label" for="newtextcell_no"><span></span>No</label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="textToggleCtrl">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label class="control-label" for="edit_cell_number">Cellphone Number</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" autocomplete="off" rel="" class="form-control custom-control" id="cell_number" name="cell_number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label class="control-label" for="subject">Cell Carrier <a href="https://freecarrierlookup.com/" target="popup" class="carrier-lookup-link">Carrier Lookup</a></label>
                                    </div>
                                    <div class="col-sm-7">
                                        <select class="lp-select2 modal-select2" data-style="form-control select-control" id="carrier" name="carrier" data-width = "296px">
                                           {!! View_Helper::getInstance()->getCarriers() !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-modal-footer footer-border">
                            <a data-dismiss="modal" class="btn lp-btn-cancel" id="modal-close">Close</a>
                            <input type="button" id="edit_rcpt" class="btn lp-btn-add _add_recipient_btn" value ="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.watch_video_popup')
<!-- Model Boxes - Domain Delete - Start -->
<div id="modal_delete_domain" class="modal fade lp-modal-box in">
    <div class="modal-dialog">
        <div class="modal-content modal-action-header">
            <div class="modal-header modal-action-title">
                <h3 class="modal-title">Delete Confirmation</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-sm-12 modal-action-msg-wrap">
                            <div class="modal-msg"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-modal-footer lp-modal-action-footer">
                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                <button type="button" class="btn lp-btn-add _delete_btn">Delete</button>&nbsp;
            </div>
        </div>
    </div>
</div>
@endsection
