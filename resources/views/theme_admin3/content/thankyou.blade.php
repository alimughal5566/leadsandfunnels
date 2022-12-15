@extends("layouts.leadpops-inner-sidebar")

@section('content')

    @php
        if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
            $firstkey = @$view->data->clickedkey;
        }else {
            $firstkey = "";
        }

        if(isset($view->data->submission_id) && $view->data->submission_id != "") {
            $view->route = route('thankyou.listing', ['hash' => $view->data->currenthash]);
            $view->title = 'BACK TO THANK YOU PAGE LIST';
            $view->editRoute = route('thankyou.pages.edit', ['hash' => @$view->data->currenthash, 'id' => $view->data->submission_id ]);
            $view->hideBackRoute = false;
        } else {
            $view->route = route('thankyou.listing', ['hash' => $view->data->currenthash]);
            $view->title = 'BACK TO THANK YOU PAGE OPTIONS';
            $view->editRoute = route('thankyoumessage', ['hash' => @$view->data->currenthash ]);
            $view->hideBackRoute = true;
        }

         //   print_r($view->data->submission);
       //  debug(@$view->data->globalOptions);
       //  print_r(@$view->data->globalOptions);

    // LP_Helper::getInstance()->getFunnelHeader(@$view);
            $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id, $firstkey);
    @endphp

    <main class="main">

        <!-- content of the page -->
        <section class="main-content">
            <form id="thankyou-page-from" method="post"
                  class="global-content-form"
                  data-global_action="{{route('GlobalSaveThankyouOptionsAdminThree')}}"
                  data-action="@php echo LP_BASE_URL.LP_PATH."/popadmin/thanksettingsave"; @endphp"
                  action="">


                @php LP_Helper::getInstance()->getFunnelHeaderAdminThreeThankYouPage($view, $view->data->currenthash) @endphp

                @include("partials.flashmsgs")


                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id" value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="theoption" id="theoption" value="thirdparty">
                <input type="hidden" name="changebtn" id="changebtn" value="0">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash"
                       value="@php echo @$view->data->currenthash @endphp">


                <input type="hidden" name="thankyou_active" id="thankyou_active"
                       value="{{@$view->data->globalOptions['thankyou_active']}}">
                <input type="hidden" name="thirdparty_active" id="thirdparty_active"
                       value="{{@$view->data->globalOptions['thankyou_thirdparty_active']}}">
                <input type="hidden" name="lpkey_thankyou" id="lpkey_thankyou" value="">
                {{--                <input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">--}}
                <input type="hidden" id="clientfname"
                       value="@php echo @$view->session->clientInfo->first_name; @endphp">
                @if(request()->has('id'))
                    <input type="hidden" name="submission_id" value="{!! request()->get('id') !!}">
                @endif
                <!-- content of the page -->
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Thank You Page
                            </h2>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item action__item_separator">
                                                <span class="action__span">
                                                    <a href="{{ $view->editRoute }}"
                                                       class="action__link">
                                                        <span class="ico ico-edit"></span>edit page
                                                    </a>
                                                </span>
                                    </li>
                                    <li class="action__item">
                                        @php $checked="";

                                        if(@$view->data->submission['thankyou_active']=='y'){
                                            $checked="checked";
                                        } elseif(@$view->data->submission['thirdparty_active'] !='y' ){
                                        $checked="checked";
                                    }
                                        @endphp
                                        <input @php echo $checked; @endphp  class="thktogbtn global-switch"
                                               id="thankyou"
                                               name="thankyou"
                                               data-global_val="{{@$view->data->globalOptions['thankyou_active']}}"
                                               data-val="{{@$view->data->submission['thankyou_active']}}"
                                               data-otherlink="thirdparty_active"
                                               data-thelink="thankyou_active" data-toggle="toggle" data-onstyle="active"
                                               data-offstyle="inactive" data-width="127" data-height="43"
                                               data-on="INACTIVE" data-off="ACTIVE" type="checkbox" data-form-field>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <p class="lp-custom-para">
                            @if(isset($view->data->submission_id) && $view->data->submission_id != "")
                                This is the most basic submission option. Upon submission, your LeadPops will simply forward clients to a customizable "Thank You Message." After a few seconds it then redirects the client to the first step of your LeadPops.
                            @else
                                Upon submission, your Funnel will take potential clients to a customizable "Thank You" page.
                            @endif
                        </p>
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
                                                    <a href="javascript:void(0)"
                                                       class="action__link action__link_cancel">
                                                        <span class="ico ico-cross"></span>cancel
                                                    </a>
                                                </span>
                                    </li>
                                    <li class="action__item">
                                        <div class="button-switch">
                                            @php $checked="";
                                        if(@$view->data->submission['thirdparty_active']=='y'){
                                            $checked="checked";
                                        }
                                            @endphp
                                            <input @php echo $checked; @endphp class="thktogbtn global-switch"
                                                   id="thirldparty"
                                                   name="thirldparty"
                                                   data-global_val="{{@$view->data->globalOptions['thankyou_thirdparty_active']}}"
                                                   data-val="{{@$view->data->submission['thirdparty_active']}}"
                                                   data-otherlink="thankyou_active"
                                                   data-thelink="thirdparty_active" data-toggle="toggle"
                                                   data-onstyle="active" data-offstyle="inactive"
                                                   data-width="127" data-height="43" data-on="INACTIVE"
                                                   data-off="ACTIVE" type="checkbox" data-form-field>
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
                                @php $checked="";
                                    if(@$view->data->submission['https_flag']=='y'){
                                        $checked="selected";
                                    }
                                @endphp
                                <select class="form-control flex-grow-0 url-prefix global-select"
                                        data-global_val="{{@$view->data->globalOptions['thankyou_https_flag']}}"
                                        data-val="{{@$view->data->submission['https_flag']}}"
                                        name="https_flag"
                                        id="https_flag" data-form-field>
                                    <option value="https://">https://</option>
                                    <option value="http://">http://</option>
                                </select>
                            </div>
                            <div class="input-holder flex-grow-1">
                                <input id="thirldpurl" name="footereditor" class="form-control global-input-text"
                                       type="text" placeholder="Enter 3rd Party URL"
                                       data-global_val="@php echo str_replace(array("http://","https://"),"",@$view->data->globalOptions['thankyou_thirdparty_url']);@endphp"
                                       data-val="@php echo str_replace(array("http://","https://"),"",@$view->data->submission['thirdparty']);@endphp"
                                       value="@php echo str_replace(array("http://","https://"),"",@$view->data->submission['thirdparty']);@endphp"
                                       data-form-field>
                            </div>
                        </div>
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
@push('body_classes') funnel-thank-you-page @endpush
