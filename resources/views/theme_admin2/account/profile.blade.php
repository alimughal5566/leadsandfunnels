@extends("layouts.leadpops")

@section('content')
    @php
        if($view->data->clientInfo['contact_email'] == $view->data->clientInfo['notify_email']) {
            $usedefault = 'y';
        }
        else {
            $usedefault = 'n';
        }
        //die($usedefault);
        if($view->data->clientInfo['send_text'] == 'y') {
            $sendtext = 'y';
        }
        else {
            $sendtext = 'n';
        }



        if(isset($view->session->clickedkey) && $view->session->clickedkey != "") {
            $firstkey = $view->sessions->clickedkey;
        }
        else {
            $firstkey = "";
        }

        $leadpops_branding = $view->data->clientInfo['leadpops_branding'];
    @endphp
    <section class="form">
        <div class="container">

            <div class="title-wrapper">
                <div class="row ">
                    <div class="col-sm-12 lp-main-title">
                        <span class="account-title">Account # {{ $view->session->clientInfo->client_id}} Details</span>
                        <a href="{{ $view->data->payment_url}}" target="_parent" class="btn btn-default payment-btn">Account Payment Information</a>
                    </div>
                    <div class="col-sm-6 text-right">
                        <div class="watch-video">
                            @if((isset($view->data->videolink) && $view->data->videolink != "#") || (isset($view->data->wistia_id) && $view->data->wistia_id))
                                @if(isset($view->data->videotitle) && $view->data->videotitle)
                                    $wistitle=$view->data->videotitle;
                                @endif
                                $wisid=$view->data->wistia_id;

                                <a data-lp-wistia-title="{{ $wistitle }}" data-lp-wistia-key="{{ $wisid }}" class="btn-video lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal"><i class="lp-icon-strip camera-icon"></i> &nbsp;<span class="action-title">Watch how to video</span></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="account-section">
                <form id="fcontactinfo" name="fcontactinfo" method="post" action="/lp/account/savecontactinfo" class="form-horizontal account-form">
                    {{csrf_field()}}
                    <div class="account-wrapper">
                        <div class="row">
                            <div class="col-sm-6 left-row-size">
                                <input type="hidden" name="client_id" id="client_id" value="{{ $view->session->client_id }}">
                                <input type="hidden" name="oemail" id="oemail" value="{{  $view->session->clientInfo->contact_email }}">
                                <input type="hidden" name="phone_number" id="phone_number" value="{{ $view->data->clientInfo['phone_number'] }}">
                                <input type="hidden" name="join_date" id="join_date" value="{{  $view->data->clientInfo['join_date'] }}">
                                <input type="hidden" name="leadpops_branding" id="leadpops_branding" value="{{  $leadpops_branding }}">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="control-label required" for="email">Email Address *</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="email" class="form-control custom-control" name="contact_email" id="email" value="{{ $view->data->clientInfo['contact_email'] }}" />
                                            <div class="form-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="control-label required" for="pwd">Current Password @if($view->data->skeletonLogin != 1) * @endif</label>
                                        </div>
                                        <div class="col-sm-7">

                                            @if($view->data->skeletonLogin == 1)
                                                <input type="password" class="form-control custom-control" id="pwd" name="current_password" value="skeleton-login" style="background-color: #ccc" readonly  />
                                            @else
                                                <input type="password" class="form-control custom-control" id="pwd" name="current_password" value="" />
                                            @endif
                                            <div class="form-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="control-label required" for="pwd">New Password *</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="password" class="form-control custom-control" id="pwd" name="password" value="" />
                                            <div class="form-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="control-label required" for="cpwd">Confirm Password *</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="password" class="form-control custom-control" id="cpwd" name="confirmpassword" value="" />
                                            <div class="form-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="control-label required" for="first_name">First Name *</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control custom-control" id="first_name" name="first_name" value="{{  $view->data->clientInfo['first_name'] }}" />
                                            <div class="form-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="control-label required" for="last_name">Last Name *</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control custom-control" id="last_name" name="last_name" value="{{  $view->data->clientInfo['last_name'] }}" />
                                            <div class="form-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="control-label required" for="company_name">Company Name *</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control custom-control" id="company_name" name="company_name" value="{{  $view->data->clientInfo['company_name'] }}" />
                                            <div class="form-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hidden">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="control-label" for="office_name">Office Name</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control custom-control" name="office_name" id="office_name" value="{{ $view->data->clientInfo['office_name'] }}">
                                            <div class="form-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--</form>-->
                            </div>
                            <div class="col-sm-6 form-left-margin">
                                <!--<form method="post" action="#"  class="form-horizontal account-form">-->
                                <div  class="account-form">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label class="control-label required" for="cell_phone">Cell Phone *</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control custom-control" maxlength="14" placeholder="(___) ___-____" id="cell_phone" name="cell_number" value="{{  $view->data->clientInfo['cell_number'] }}" >
                                                <div class="form-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group radio-group-height">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label class="control-label not-required">Text Cell Phone</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="lp-radio-wrapper lp-radio2-margin">
                                            <span class="radio-inline radio-padding">
                                                <input type="radio"   id="r3" name="textcell" value="y" {{  ($sendtext=='y'?'checked="checked"':'') }}checked/>
                                            <label for="r3"><span></span>Yes</label>
                                            </span>
                                                    <span class="radio-inline">
                                                <input type="radio" id="r4" name="textcell" value="n" {{  ($sendtext=='n'?'checked="checked"':'') }}/>
                                                <label for="r4"><span></span>No</label>
                                            </span>
                                                    <div class="form-error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text_cell_carrier" {{  ($sendtext=='y'?'':'  style="display:none"') }}>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label class="control-label not-required" for="cell_carrier">Cell Carrier</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <select  class="lp-select2" data-style="form-control" data-width = "288px" name="carrier">
                                                    {!! View_Helper::getInstance()->getCarriers($view->data->clientInfo['carrier']) !!}
                                                </select>
                                                <div class="form-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group hidden">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label class="control-label not-required" for="fax_number">Fax Number</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control custom-control" name="fax_number" id="fax_number" value="{{  $view->data->clientInfo['fax_number'] }}" />
                                                <div class="form-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label class="control-label required" for="address1">Address 1 *</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control custom-control" id="address1" name="address1" value="{{  $view->data->clientInfo['address1'] }}" />
                                                <div class="form-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label class="control-label not-required" for="address2">Address 2</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control custom-control" id="address2" name="address2" value="{{  $view->data->clientInfo['address2'] }}" />
                                                <div class="form-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label class="control-label required" for="city">City *</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control custom-control"  name="city" id="city" value="{{ $view->data->clientInfo['city'] }}" required>
                                                <div class="form-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label class="control-label required" for="state" required>State *</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <select id="state" name="state" class="lp-select2" data-style="form-control" required>
                                                    <option {{  ($view->data->clientInfo['state']=='AL'?'selected="selected"':"") }} value="AL" label="AL">AL</option>
                                                    <option {{  ($view->data->clientInfo['state']=='AR'?'selected="selected"':"") }} value="AR" label="AR">AR</option>
                                                    <option {{  ($view->data->clientInfo['state']=='AK'?'selected="selected"':"") }} value="AK" label="AK">AK</option>
                                                    <option {{  ($view->data->clientInfo['state']=='AZ'?'selected="selected"':"") }} value="AZ" label="AZ">AZ</option>
                                                    <option {{  ($view->data->clientInfo['state']=='CA'?'selected="selected"':"") }} value="CA" label="CA">CA</option>
                                                    <option {{  ($view->data->clientInfo['state']=='CO'?'selected="selected"':"") }} value="CO" label="CO">CO</option>
                                                    <option {{  ($view->data->clientInfo['state']=='CT'?'selected="selected"':"") }} value="CT" label="CT">CT</option>
                                                    <option {{  ($view->data->clientInfo['state']=='DC'?'selected="selected"':"") }} value="DC" label="DC">DC</option>
                                                    <option {{  ($view->data->clientInfo['state']=='DE'?'selected="selected"':"") }} value="DE" label="DE">DE</option>
                                                    <option {{  ($view->data->clientInfo['state']=='FL'?'selected="selected"':"") }} value="FL" label="FL">FL</option>
                                                    <option {{  ($view->data->clientInfo['state']=='GA'?'selected="selected"':"") }} value="GA" label="GA">GA</option>
                                                    <option {{  ($view->data->clientInfo['state']=='HI'?'selected="selected"':"") }} value="HI" label="HI">HI</option>
                                                    <option {{  ($view->data->clientInfo['state']=='IA'?'selected="selected"':"") }} value="IA" label="IA">IA</option>
                                                    <option {{  ($view->data->clientInfo['state']=='ID'?'selected="selected"':"") }} value="ID" label="ID">ID</option>
                                                    <option {{  ($view->data->clientInfo['state']=='IL'?'selected="selected"':"") }} value="IL" label="IL">IL</option>
                                                    <option {{  ($view->data->clientInfo['state']=='IN'?'selected="selected"':"") }} value="IN" label="IN">IN</option>
                                                    <option {{  ($view->data->clientInfo['state']=='KS'?'selected="selected"':"") }} value="KS" label="KS">KS</option>
                                                    <option {{  ($view->data->clientInfo['state']=='KY'?'selected="selected"':"") }} value="KY" label="KY">KY</option>
                                                    <option {{  ($view->data->clientInfo['state']=='LA'?'selected="selected"':"") }} value="LA" label="LA">LA</option>
                                                    <option {{  ($view->data->clientInfo['state']=='MA'?'selected="selected"':"") }} value="MA" label="MA">MA</option>
                                                    <option {{  ($view->data->clientInfo['state']=='MD'?'selected="selected"':"") }} value="MD" label="MD">MD</option>
                                                    <option {{  ($view->data->clientInfo['state']=='ME'?'selected="selected"':"") }} value="ME" label="ME">ME</option>
                                                    <option {{  ($view->data->clientInfo['state']=='MI'?'selected="selected"':"") }} value="MI" label="MI">MI</option>
                                                    <option {{  ($view->data->clientInfo['state']=='MN'?'selected="selected"':"") }} value="MN" label="MN">MN</option>
                                                    <option {{  ($view->data->clientInfo['state']=='MO'?'selected="selected"':"") }} value="MO" label="MO">MO</option>
                                                    <option {{  ($view->data->clientInfo['state']=='MS'?'selected="selected"':"") }} value="MS" label="MS">MS</option>
                                                    <option {{  ($view->data->clientInfo['state']=='MT'?'selected="selected"':"") }} value="MT" label="MT">MT</option>
                                                    <option {{  ($view->data->clientInfo['state']=='NC'?'selected="selected"':"") }} value="NC" label="NC">NC</option>
                                                    <option {{  ($view->data->clientInfo['state']=='ND'?'selected="selected"':"") }} value="ND" label="ND">ND</option>
                                                    <option {{  ($view->data->clientInfo['state']=='NE'?'selected="selected"':"") }} value="NE" label="NE">NE</option>
                                                    <option {{  ($view->data->clientInfo['state']=='NH'?'selected="selected"':"") }} value="NH" label="NH">NH</option>
                                                    <option {{  ($view->data->clientInfo['state']=='NJ'?'selected="selected"':"") }} value="NJ" label="NJ">NJ</option>
                                                    <option {{  ($view->data->clientInfo['state']=='NM'?'selected="selected"':"") }} value="NM" label="NM">NM</option>
                                                    <option {{  ($view->data->clientInfo['state']=='NV'?'selected="selected"':"") }} value="NV" label="NV">NV</option>
                                                    <option {{  ($view->data->clientInfo['state']=='NY'?'selected="selected"':"") }} value="NY" label="NY">NY</option>
                                                    <option {{  ($view->data->clientInfo['state']=='OH'?'selected="selected"':"") }} value="OH" label="OH">OH</option>
                                                    <option {{  ($view->data->clientInfo['state']=='OK'?'selected="selected"':"") }} value="OK" label="OK">OK</option>
                                                    <option {{  ($view->data->clientInfo['state']=='OR'?'selected="selected"':"") }} value="OR" label="OR">OR</option>
                                                    <option {{  ($view->data->clientInfo['state']=='PA'?'selected="selected"':"") }} value="PA" label="PA">PA</option>
                                                    <option {{  ($view->data->clientInfo['state']=='RI'?'selected="selected"':"") }} value="RI" label="RI">RI</option>
                                                    <option {{  ($view->data->clientInfo['state']=='SC'?'selected="selected"':"") }} value="SC" label="SC">SC</option>
                                                    <option {{  ($view->data->clientInfo['state']=='SD'?'selected="selected"':"") }} value="SD" label="SD">SD</option>
                                                    <option {{  ($view->data->clientInfo['state']=='TN'?'selected="selected"':"") }} value="TN" label="TN">TN</option>
                                                    <option {{  ($view->data->clientInfo['state']=='TX'?'selected="selected"':"") }} value="TX" label="TX">TX</option>
                                                    <option {{  ($view->data->clientInfo['state']=='UT'?'selected="selected"':"") }} value="UT" label="UT">UT</option>
                                                    <option {{  ($view->data->clientInfo['state']=='VI'?'selected="selected"':"") }} value="VI" label="VI">VI</option>
                                                    <option {{  ($view->data->clientInfo['state']=='VT'?'selected="selected"':"") }} value="VT" label="VT">VT</option>
                                                    <option {{  ($view->data->clientInfo['state']=='VA'?'selected="selected"':"") }} value="VA" label="VA">VA</option>
                                                    <option {{  ($view->data->clientInfo['state']=='WA'?'selected="selected"':"") }} value="WA" label="WA">WA</option>
                                                    <option {{  ($view->data->clientInfo['state']=='WI'?'selected="selected"':"") }} value="WI" label="WI">WI</option>
                                                    <option {{  ($view->data->clientInfo['state']=='WV'?'selected="selected"':"") }} value="WV" label="WV">WV</option>
                                                    <option {{  ($view->data->clientInfo['state']=='WY'?'selected="selected"':"") }} value="WY" label="WY">WY</option>
                                                    <option {{  ($view->data->clientInfo['state']=='GU'?'selected="selected"':"") }} value="GU" label="GU">GU</option>
                                                    <option {{  ($view->data->clientInfo['state']=='PR'?'selected="selected"':"") }} value="PR" label="PR">PR</option>
                                                </select>
                                                <div class="form-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label class="control-label required" for="postal_code">Postal Code *</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control custom-control" id="postal_code" name="zip" value="{{  $view->data->clientInfo['zip']}}" />
                                                <div class="form-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="text-center account-margin"><button type="submit" class="btn btn-success acc-submit-btn">SAVE</button></div>
                </form>
            </div>
        </div>
    </section>
    @include('partials.watch_video_popup')
@endsection
