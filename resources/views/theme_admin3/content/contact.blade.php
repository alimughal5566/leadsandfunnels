@extends("layouts.leadpops-inner-sidebar")

@section('content')
    @php
        if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
            $firstkey = @$view->data->clickedkey;
        }else {
            $firstkey = "";
        }
    @endphp
    <main class="main">
        <section class="main-content">

            @php $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id, $firstkey); @endphp

            <form id="contact-info" method="POST"
                  class="global-content-form"
                  data-global_action="{{route('saveGlobalContactOptionAdminThree')}}"
                  data-action="@php echo LP_BASE_URL.LP_PATH."/popadmin/contactinfosave"; @endphp"
                  action="">
                {{ csrf_field() }}
                <input type="hidden" name="theselectiontype" id="theselectiontype" value="contacteditoptions">
                <input type="hidden" name="client_id" id="client_id" value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash"
                       value="@php echo @$view->data->currenthash @endphp">


                <input type="hidden" name="companyname_active" id="companyname_active" value="{{@$view->data->contact['companyname_active']}}">
                <input type="hidden" name="phonenumber_active" id="phonenumber_active" value="{{@$view->data->contact['phonenumber_active']}}">
                <input type="hidden" name="email_active" id="email_active" value="{{@$view->data->contact['email_active']}}">


                <input type="hidden" name="lpkey" id="lpkey" value="">
                <input type="hidden" name="is_include" id="is_include" value="y">
            {{--<input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">--}}

            @php LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view); @endphp
            @include("partials.flashmsgs")
            <!-- content of the page -->
                {{-- $view->data->globalOptions --}}

                <div class="lp-contact__content">
                    <label class="lp-contact__label" for="company_name">Company Name</label>
                    <div class="input__wrapper">
                        {{--<input name="company_name" class="form-control" type="text">--}}
                        <input type="text" class=" form-control lp-cont-textbox companyname  global-input-text" name="companyname"
                               id="companyname"
                               data-global_val="{{@$view->data->globalOptions['companyname']}}"
                               data-val="@php if(isset($view->data->contact['companyname'])) echo @$view->data->contact['companyname']; @endphp"
                               value="@php if(isset($view->data->contact['companyname'])) echo @$view->data->contact['companyname']; @endphp"
                               data-form-field>

                    </div>
                    <div class="lp-contact__control">
                        @php
                             $checked="";
                            if(@$view->data->contact['companyname_active']=='y'){
                                $checked="checked";
                            }
                        @endphp

                        <input
                               data-lpkeys="@php echo @$view->data->lpkeys; @endphp~companyname_active"
                               class="conttogbtn companyname_tbt global-switch gfooter-toggle" name="companyname_tbt"
                               data-toggle="toggle" data-onstyle="active" data-offstyle="inactive"
                               {{$checked}}

                               data-field="companyname_active"

                               data-global_val="{{@$view->data->globalOptions['companyname_active']}}"
                               data-val="{{@$view->data->contact['companyname_active']}}"

                               data-width="127" data-height="43" data-on="INACTIVE"
                               data-off="ACTIVE" type="checkbox" data-form-field>

                    </div>
                </div>
                <div class="lp-contact__content">
                    <label class="lp-contact__label" for="phone_number">Phone Number</label>
                    <div class="input__wrapper">
                        <input type="text" class=" form-control lp-cont-textbox global-input-text" name="phonenumber" id="phonenumber"
                               data-global_val="{{@$view->data->globalOptions['phonenumber']}}"
                               data-val="@php if(isset($view->data->contact['phonenumber'])) echo @$view->data->contact['phonenumber']; @endphp"
                               value="@php if(isset($view->data->contact['phonenumber'])) echo @$view->data->contact['phonenumber']; @endphp"
                               data-form-field>

                    </div>
                    <div class="lp-contact__control">
                        @php $checked="";
                            if(@$view->data->contact['phonenumber_active']=='y'){
                                $checked="checked";
                            }
                        @endphp

                        <input  class="conttogbtn phonenumber_tbt global-switch gfooter-toggle" name="phonenumber_tbt"
                               data-lpkeys="@php echo @$view->data->lpkeys; @endphp~phonenumber_active"
                               data-toggle="toggle" data-onstyle="active" data-offstyle="inactive"
                                {{$checked}}

                                data-field="phonenumber_active"

                               data-global_val="{{@$view->data->globalOptions['phonenumber_active']}}"
                               data-val="{{@$view->data->contact['phonenumber_active']}}"

                               data-width="127" data-height="43" data-on="INACTIVE"
                               data-off="ACTIVE" type="checkbox" data-form-field>
                    </div>
                </div>
                <div class="lp-contact__content">
                    <label class="lp-contact__label" for="email">Email Address</label>
                    <div class="input__wrapper">
                        {{--<input name="email" class="form-control" type="text">--}}
                        <input type="text" class="form-control lp-cont-textbox global-input-text" name="email" id="email"
                               data-global_val="{{@$view->data->globalOptions['email']}}"
                               data-val="@php if(isset($view->data->contact['email'])) echo @$view->data->contact['email']; @endphp"
                               value="@php if(isset($view->data->contact['email'])) echo @$view->data->contact['email']; @endphp"
                               data-form-field>

                    </div>
                    <div class="lp-contact__control">
                        @php $checked="";
                            if(@$view->data->contact['email_active']=='y'){
                                $checked="checked";
                            }
                        @endphp

                        <input  class="conttogbtn email_tbt global-switch gfooter-toggle" name="email_tbt"
                               data-lpkeys="@php echo @$view->data->lpkeys; @endphp~email_active"
                                {{$checked}}

                               data-global_val="{{@$view->data->globalOptions['email_active']}}"
                               data-val="{{@$view->data->contact['email_active']}}"

                                data-field="email_active"

                               data-toggle="toggle" data-onstyle="active" data-offstyle="inactive"
                               data-width="127" data-height="43" data-on="INACTIVE"
                               data-off="ACTIVE" type="checkbox" data-form-field>
                    </div>
                </div>


                <!-- content of the page -->
                <!-- footer of the page -->
                <div class="footer">
                   {{-- <div class="row">
                        <button type="submit" class="button button-secondary">Save</button>
                    </div>--}}
                    <div class="row">
                        <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </form>
        </section>
    </main>

@endsection
