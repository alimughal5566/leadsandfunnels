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
            @php LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view) @endphp
            @include("partials.flashmsgs")
            @php
                $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
            @endphp
            <form id="add_autoresponder"
                  class="global-content-form"
                  data-global_action="@php echo LP_BASE_URL.LP_PATH."/popadmin/autorespondsave"; @endphp"
                  data-action="@php echo LP_BASE_URL.LP_PATH."/popadmin/autorespondsave"; @endphp"
                  method="POST" action="">

                <!-- Title wrap of the page -->


                <!-- content of the page -->
                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id" value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="sline" id="sinle" value="text">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                <input type="hidden" name="active_responderhtml" id="active_responderhtml"
                       value="@php echo @$view->data->autoresponder['active'] @endphp">
                <input type="hidden" name="active_respondertext" id="active_respondertext"
                       value="@php echo @$view->data->autoresponder['active'] @endphp">
                <input type="hidden" name="auto_active" id="auto_active" value="@php
                    if(@$view->data->autoresponder['html_active']=='y'){
                        echo "html";
                    }else{
                        echo "text";
                    }
                @endphp">



                <input type="hidden" name="active" id="active"
                       value="@php echo @$view->data->autoresponder['active'] @endphp">


                {{--<input type="hidden" name="text_active" id="text_active" value="">--}}
                {{--<input type="hidden" name="responder_active" id="responder_active" value="y">--}}
                {{--<input type="hidden" name="lpkey_responder" id="lpkey_responder" value="">--}}
                {{--<input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">--}}


                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Autoresponder message details
                            </h2>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item">
                                        @php
                                            $checked="";
                                            if(@$view->data->autoresponder['active']=='y'){
                                                $checked="checked";
                                            }
                                        @endphp
                                        <input @php echo $checked; @endphp
                                               data-lpkeys="@php echo @$view->data->lpkeys; @endphp"
                                               class="autoreschk global-switch" id="autoreschk" name="thankyou"
                                               data-global_val="y"
                                               data-val="{{@$view->data->autoresponder['active']}}"
                                               data-toggle="toggle" data-onstyle="active"
                                               data-offstyle="inactive" data-width="127" data-height="43"
                                               data-on="INACTIVE" data-off="ACTIVE" type="checkbox" data-form-field>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="lp-panel__body">
                        <div class="auto-responder">
                            <div class="auto-responder__row">
                                <div class="form-group">
                                    <label for="mg_subject" class="auto-responder__msg-lbl">Message Subject</label>
                                    <div class="input__holder">
                                        <input name="subline"
                                               class="form-control lp-auto-responder-textbox font-weight-bold global-input-text"
                                               id="subline"
                                               type="text"
                                               data-global_val="@if((@$view->data->globalOptions['subline']) && @$view->data->globalOptions['subline']!="") {{ @trim($view->data->globalOptions['subline']) }} @else {{ "Thank You For Contacting ".@$view->session->clientInfo->company_name }} @endif"
                                               data-val="@php if(@$view->data->autoresponder['subject_line']!=""){ echo @$view->data->autoresponder['subject_line'];}else { echo "Thank You For Contacting&nbsp;".@$view->session->clientInfo->company_name;} @endphp"
                                               value="@php if(@$view->data->autoresponder['subject_line']!=""){ echo @$view->data->autoresponder['subject_line'];}else { echo "Thank You For Contacting&nbsp;".@$view->session->clientInfo->company_name;} @endphp"
                                               data-form-field>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Message type
                            </h2>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="row">
                            <div class="col">
                                <div class="radio">
                                    <ul class="radio__list radio__list_message-type">
                                        <li class="radio__item">
                                            {{--   <input data-id="html-editor"  type="radio" id="htmlemail" name="theoption" value="html" @php if(@$view->data->autoresponder['html_active']=='y'){echo "checked";} @endphp/>
                                                <label class="radio__htmlemail" for="htmlemail">HTML <span>Email</span></label>--}}


                                            <input type="radio" data-id="html-editor" id="htmlemail" value="html"
                                                   name="theoption"
                                                   class="global-radio"
                                                   data-global_val="{{@$view->data->globalOptions['autoresponder_html_active']}}"
                                                   data-val="{{@$view->data->autoresponder['html_active']}}"
                                                   data-form-field>
                                            <label class="radio__htmlemail" for="htmlemail">HTML
                                                <span>Email</span></label>

                                        </li>
                                        <li class="radio__item">
                                            {{-- <input type="radio" id="r4" value="textemail" name="theoption">
                                             <label for="r4"><span></span><b>Text</b> Email</label>--}}

                                            <input type="radio" data-id="text-editor" id="textemail" value="text"
                                                   name="theoption"
                                                   class="global-radio"
                                                   data-global_val="{{@$view->data->globalOptions['autoresponder_text_active']}}"
                                                   data-val="{{@$view->data->autoresponder['text_active']}}"
                                                   data-form-field>
                                            <label class="radio__textemail" for="textemail">Text
                                                <span>Email</span></label>


                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="html-email__body classic-editor__wrapper funnel-setting-pages-editor">
                                    <div id="textwrapper" class="">
                                        <textarea
                                                class="lp-froala-textbox classic-editor"
                                                name="htmlautoeditor"
                                                data-global_val=""
                                                data-val="" data-form-field>{!!  @$view->data->autoresponder['html'] !!}</textarea>
                                    </div>
                                    <!--<div name="frola_email" class="html-email__froala-editor classic-editor"></div>-->
                                </div>
                                <div class="text-email__body display-none">
                                    <textarea class="text-area text-area_h300"
                                              name="textautoeditor" id="autoresponder_text" cols="30" rows="10"
                                              data-global_val=""
                                              data-val="" data-form-field></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="globalHtml" style="display: none">{!! @$view->data->globalOptions['autoresponder_html']  !!}</div>


                <!-- content of the page -->
                <!-- footer of the page -->
                <div class="footer">
                    {{--  <div class="row">
                          <button type="submit" onclick="saveautooptions()" class="button button-secondary">Save</button>
                      </div>--}}
                    <div class="row">
                        <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
@push('footerScripts')

    <script>
        $(document).ready(function () {
            var text = {!! json_encode(@$view->data->autoresponder['thetext'])!!};
            setTimeout( function () {
                // setTextArea();
                $('#autoresponder_text').html(text);
                ajaxRequestHandler.setAutoEnableDisableButton(true);
                ajaxRequestHandler.loadFormSavedValues();
            }, 100);
            // $('input:radio[name=theoption]').change(function () {
            //     setTextArea();
            // });
            //
            // function setTextArea() {
            //     // $('.lp-froala-textbox').froalaEditor('html.set', $('#contentHtml').html());
            //     lp_html_editor.html.set($('#contentHtml').html());
            //     $('#autoresponder_text').html(text);
            // }
        })
    </script>
@endpush

@push('body_classes') auto-responder-settings-page @endpush
