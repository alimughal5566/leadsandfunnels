@extends("layouts.leadpops-inner")

@section('content')
    @php
        $backgroundPreview = "";
        $imageUploaderCls = "";
        $rackspaceImageBase = $view->data->clientInfo['rackspace_image_base'] . "/pics/";
        if(!empty($view->data->clientInfo['avatar']) && @getimagesize($rackspaceImageBase . rawurlencode($view->data->clientInfo['avatar']))) {
            $backgroundPreview = "style=\"background-image:url('" . ($rackspaceImageBase . $view->data->clientInfo['avatar']) . "');\"";
            $imageUploaderCls = "has__background";
        }

        $noProfileImageText = "";
        if(isset($view->session->clientInfo->first_name) || isset($view->session->clientInfo->last_name)) {
            if(isset($view->session->clientInfo->first_name) && !empty($view->session->clientInfo->first_name)) {
                $noProfileImageText .= $view->session->clientInfo->first_name[0];
            }
            if(isset($view->session->clientInfo->last_name) && !empty($view->session->clientInfo->last_name)) {
                $noProfileImageText .= $view->session->clientInfo->last_name[0];
            }
            $noProfileImageText = strtoupper($noProfileImageText);
        }
    @endphp

    <main class="main">
        <div class="main-content">

            <!-- page messages-->
            <!-- Title wrap of the page -->
            <div class="main-content__head">
                <div class="col-left">
                    <h1 class="title">Account Settings - Client ID #{{ $view->session->client_id }}</h1>
                </div>
                <div class="col-right">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item action__item_separator">
                                <script src="https://js.chargebee.com/v2/chargebee.js" data-cb-site="leadpops" ></script>
                                <a class="button button-payment" href="javascript:void(0)" data-cb-type="portal" >account payment information</a>
                            </li>
                            @if((isset($view->data->videolink) && $view->data->videolink) || (isset($view->data->wistia_id) && $view->data->wistia_id))
                                <li class="action__item">
                                    <a data-lp-wistia-title="{{ $view->data->videotitle }}" data-lp-wistia-key="{{ $view->data->wistia_id }}"
                                       class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                        <span class="icon ico-video"></span>
                                        <span class="action-title">
                                            WATCH HOW-TO VIDEO
                                        </span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            @include("partials.flashmsgs")
            <!-- content of the page -->
            <form id="fcontactinfo" name="fcontactinfo" method="post" action="/lp/account/savecontactinfo" enctype="multipart/form-data" class="account">
                {{csrf_field()}}
                <input type="hidden" name="client_id" id="client_id" value="{{ $view->session->client_id }}">
                <input type="hidden" name="oemail" id="oemail" value="{{  $view->session->clientInfo->contact_email }}">
                <input type="hidden" name="phone_number" id="phone_number" value="{{ $view->data->clientInfo['phone_number'] }}">
                <input type="hidden" name="join_date" id="join_date" value="{{  $view->data->clientInfo['join_date'] }}">
                <input type="hidden" name="leadpops_branding" id="leadpops_branding" value="{{  $view->data->clientInfo['leadpops_branding'] }}">
                <input type="hidden" name="delete_image" id="delete_image" value="n">

                <div class="lp-panel">
                    <div class="lp-panel__body lp-panel__body_account">
                        <div class="account__info">
                            <div class="account__profile">
                                <div class="lp-image__uploader {{$imageUploaderCls}}">
                                    <div class="lp-image__preview" {!! $backgroundPreview !!} noProfileImageText="{{$noProfileImageText}}">{{$imageUploaderCls == "" ? $noProfileImageText : ""}}</div>
                                    <div class="lp-image__uploader-controls text-center">
                                        <label for="profile_img">
                                            <input id="profile_img" name="profile_img" class="btn-image__upload" type="file" accept="image/*" value="" data-form-field/>
                                            upload profile image
                                        </label>
                                        <span class="btn-image__del">Delete</span>
                                    </div>
                                    <div class="file__control">
                                        <p class="file__extension">Invalid image format! image format must be JPG, JPEG, PNG.</p>
                                        <p class="file__size">Maximum file size limit is 2MB.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="account__fields col p-0">
                                <div class="account__fields-row">
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="first_name">First Name *</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="first_name" name="first_name" class="form-control" value="{{  $view->data->clientInfo['first_name'] }}" required data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="last_name">Last Name *</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="last_name" name="last_name" class="form-control" value="{{  $view->data->clientInfo['last_name'] }}" required data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="email">Login Email *</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="email" name="contact_email" value="{{ $view->data->clientInfo['contact_email'] }}" class="form-control" required data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="current_password">Current Password @if($view->data->skeletonLogin != 1) * @endif</label>
                                            <div class="input__wrapper">
                                                @if($view->data->skeletonLogin == 1)
                                                    <input type="password" id="current_password" name="current_password"  class="form-control" value="skeleton-login" style="background-color: #ccc" readonly>
                                                @else
                                                    <input type="password" id="current_password" name="current_password"  class="form-control" value="" data-form-field>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="password">New Password *</label>
                                            <div class="input__wrapper">
                                                <input type="password" id="password" name="password" value="" class="form-control" data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="confirm_password">Confirm Password *</label>
                                            <div class="input__wrapper">
                                                <input type="password" id="confirm_password" name="confirmpassword" value="" class="form-control" data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="company_name">Company Name *</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="company_name" name="company_name" class="form-control" value="{{  $view->data->clientInfo['company_name'] }}" required data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display:none">
                                        <div class="input__holder">
                                            <label for="office_name">Office Name</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="office_name" name="office_name" class="form-control" value="{{  $view->data->clientInfo['office_name'] }}" data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="account__fields-row">
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="cell_phone">Cell Phone *</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="cell_phone" name="cell_number" class="form-control" maxlength="14" placeholder="(___) ___-____" value="{{  $view->data->clientInfo['cell_number'] }}" required data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder input__holder_text-cell-phone">
                                            <label>
                                                Text Lead Alerts
                                                <span class="question-mark el-tooltip" data-container="body" data-toggle="tooltip" title="This feature will send you a text message <br/>notification when you get new leads." data-html="true" data-placement="top">
                                                    <i class="ico ico-question"></i>
                                                </span>
                                            </label>
                                            <div class="radio">
                                                <ul class="radio__list">
                                                    <li class="radio__item">
                                                        <input type="radio" id="yes" value="y" name="textcell" {{ ($view->data->clientInfo['send_text']=='y'?'checked="checked"':'') }}checked data-form-field>
                                                        <label class="radio__lbl" for="yes">Yes</label>
                                                    </li>
                                                    <li class="radio__item">
                                                        <input type="radio" id="no" value="n" name="textcell" {{ ($view->data->clientInfo['send_text']=='n'?'checked="checked"':'') }} data-form-field>
                                                        <label class="radio__lbl" for="no">No</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text_cell_carrier" {{  ($view->data->clientInfo['send_text']=='y'?'':'  style="display:none"') }}>
                                        <div class="form-group">
                                            <div class="input__holder">
                                                <label for="cell_carrier">Cell Carrier</label>
                                                <div class="input__wrapper">
                                                    <div class="select2 select2__parent-cell-carrier select2js__nice-scroll">
                                                        <select id="cell_carrier" name="carrier" class="lp-select2__cell-carrier" data-form-field>
                                                            {!! View_Helper::getInstance()->getCarriers($view->data->clientInfo['carrier']) !!}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display:none">
                                        <div class="input__holder">
                                            <label for="fax_number">Fax Number</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="fax_number" name="fax_number" class="form-control" value="{{  $view->data->clientInfo['fax_number'] }}" data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="address1">Address 1 *</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="address1" name="address1" class="form-control" value="{{  $view->data->clientInfo['address1'] }}" required data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="address2">Address 2</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="address2" name="address2" value="{{  $view->data->clientInfo['address2'] }}" class="form-control" data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="city">City *</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="city" name="city" value="{{ $view->data->clientInfo['city'] }}" class="form-control" required data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input__holder">
                                            <label for="state">State *</label>
                                            <div class="input__wrapper">
                                                <div class="select2 select2__parent-state select2js__nice-scroll">
                                                    <select class="lp-select2__state" id="state" name="state" required data-form-field>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-0">
                                        <div class="input__holder">
                                            <label for="postal_code">Zip Code *</label>
                                            <div class="input__wrapper">
                                                <input type="text" id="postal_code" name="zip" value="{{  $view->data->clientInfo['zip']}}" class="form-control" required data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                    <div class="lp-panel__footer">--}}
{{--                        <div class="lp-panel-footer__controls text-center">--}}
{{--                            <button type="button" class="button button-secondary acc-submit-btn">save</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </form>
            <!-- footer of the page -->
            <div class="footer">
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                </div>
            </div>
        </div>
    </main>
@endsection

@push('footerScripts')
    <script src="{{ config('view.theme_assets') . "/js/account/profile.js?v=" . LP_VERSION}}"></script>
@endpush

