@extends("layouts.leadpops-inner-sidebar")
@section('content')
    @php
        if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
            $firstkey = @$view->data->clickedkey;
        }else {
            $firstkey = "";
        }

        $tcpaMessage = @$view->data->message;
        $backgroundSwatches = @$view->data->backgroundSwatches;
        $defaultSecurityMessage = config('lp.security_message.defaults');
    @endphp

    <main class="main">
        <section class="main-content security-message">
            <!-- Title wrap of the page -->

            <input type="hidden" id="theme_color" value="{{ $view->data->advancedfooteroptions["logocolor"] ?? '#abb3b6'}}">
        @php LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view, false, false, false, [
        'link' =>route('SecurityMessagesIndex', [@$view->data->currenthash]),
        'text' => "BACK TO INITIAL PAGE"
        ]) @endphp

        @include("partials.flashmsgs")

        @php
            $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
        @endphp

        <!-- content of the page -->

            <div class="lp-panel lp-panel_tabs">

                <form id="messages-form" action="{{route('editSecurityMessage', [$tcpaMessage['id']])}}"
                      data-edit="true"
                      data-global_action="{{route('editSecurityMessage', [$tcpaMessage['id']])}}" method="post">


                    {{ csrf_field() }}
                    <input type="hidden" name="client_id" id="client_id"
                           value="@php echo @$view->data->client_id @endphp">
                    <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                    <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                    <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                    <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                    <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                    <input type="hidden" name="id" id="id" value="{{$tcpaMessage['id']}}">
                    <input type="hidden" name="tcpa_title" id="tcpa_title" value="{{$tcpaMessage['tcpa_title']}}">
                    <input type="hidden" name="icon" id="icon_style" value="{{@$tcpaMessage['icon']}}" data-form-field-custom-cb/>
                    <input type="hidden" name="tcpa_text_style" id="message_text_style"
                           value="{{@$tcpaMessage['tcpa_text_style']}}" data-form-field-custom-cb/>

                    <input type="hidden" name="swatches" value="{{ @$backgroundSwatches}}">


                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title lp-panel__title_regent-gray">{{$tcpaMessage['tcpa_title']}}</h2>
                        </div>
                        <div class="col-right">
                            <ul class="nav nav__tab security-nav-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active security-message-desktop-view preview-link" data-toggle="pill" href="#Custom">
                                        <span class="el-tooltip" title="Computer & Tablet">
                                            <span class="ico ico-devices"></span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link security-message-mobile-view preview-link" data-toggle="pill" href="#FullPage">
                                        <span class="ico ico-Mobile el-tooltip" title="Mobile"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="available-preview">
                            <div class="lp-panel__embed">
                                <div class="lp-panel__embed-preview">
                                    <div class="theme__wrapper">
                                        <div class="theme__header">
                                            <div class="dots"></div>
                                            <div class="dots"></div>
                                            <div class="dots"></div>
                                        </div>
                                        <div class="theme__body" id="preview_iframe">

                                            {{--<iframe class="tcpa-iframe"  id="iframe" src="{{LP_BASE_URL.'/previewbars/zipcode-preview.php?ls_key='.$view->data->currenthash}}"></iframe>--}}

                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel__embed-setting-panel security-setting-pannel">
                                    <div class="preview-panel">
                                        <div class="preview-panel__head">
                                            <div class="form-group">
                                                <h3 class="preview-panel__title">
                                                    Security Message Icon
                                                </h3>
                                                <div class="switcher-min">
                                                    <input id="message-icon" name="message-icon"
                                                           data-toggle="toggle min"
                                                           data-onstyle="active" data-offstyle="inactive"
                                                           data-width="72" data-height="26" data-on="OFF"
                                                           data-off="ON" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-panel__body">
                                            <div class="icon-setting">
                                                <div class="form-group">
                                                    <label for="preview-button-pop">Select an Icon</label>
                                                    <div class="btn-icon-wrapper">
                                                        <div class="icon-block">
                                                            {{--<i class="ico ico-shield-2"></i>--}}
                                                            <i id="selectedIcon" class=""></i>
                                                        </div>
                                                        <span class="arrow"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="preview-button-pop">Icon Color</label>
                                                    <div class="text-color-parent color-picker-parent-wrap">
                                                        <div id="ico-colorpicker"></div>
                                                        <div id="clr-icon" class="last-selected custom-color-picker">
                                                            <div class="last-selected__box custom-color-bg" id="iconSelectedColor"
                                                                 style="background: #24b928"></div>
                                                            <div class="last-selected__code custom-color-code" id="iconSelectedCode">
                                                                #24b928
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="preview-button-pop">Icon Position</label>
                                                    <div class="select2js__icon-position-parent select2-parent">
                                                        <select name="select2js__icon-position"
                                                                id="select2js__icon-position">
                                                            <option value="Left Align">Left Align</option>
                                                            <option value="Right Align">Right Align</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group icon-size-area">
                                                    <label for="preview-button-pop">Icon Size</label>
                                                    <div class="range-slider-area">
                                                        <div class="range-slider">
                                                            <div class="input__wrapper">
                                                                <input id="ex1" class="form-control"
                                                                       data-slider-id='ex1Slider' type="text"/>
                                                                <input type="hidden" id="iconsize" value="12" />
                                                            </div>
                                                        </div>
                                                        <span class="icon-size-reset"><i class="ico-undo"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="default-setting">
                                                <div class="form-group form-group_security-message">
                                                    <label for="buttontext">
                                                        Security Message Text
                                                        <span class="question-mark el-tooltip" title="Tooltip Content">
                                                        <span class="ico ico-question"></span>
                                                    </span>
                                                    </label>
                                                    <div class="font-opitons-area security-font-option">
                                                        <div class="input__wrapper">
                                                            <input type="text" id="security_message_text"
                                                                   name="tcpa_text"
                                                                   value="{{@$tcpaMessage['tcpa_text'] ?? $defaultSecurityMessage["tcpa_text"] }}"
                                                                   class="form-control"
                                                                   placeholder="Enter Security Message Text"
                                                                   data-form-field />
                                                        </div>
                                                        <div class="font-bold">
                                                            <button type="button" class="form-control txt-cta-bold"><i
                                                                        class="ico ico-alphabet-b"></i></button>
                                                        </div>
                                                        <div class="font-italic">
                                                            <button type="button" class="form-control txt-cta-italic"><i
                                                                        class="ico ico-alphabet-i"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="preview-button-pop">Text Color</label>
                                                    <div class="text-color-parent color-picker-parent-wrap">
                                                        <div id="clr-text" class="last-selected custom-color-picker">
                                                            <div class="last-selected__box custom-color-bg" id="textSelectedColor"
                                                                 style="background: #b4bbbc"></div>
                                                            <div class="last-selected__code custom-color-code" id="textSelectedCode">
                                                                #b4bbbc
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- footer of the page -->
            <div class="modal fade" id="icon-picker">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Select Icon</h5>
                        </div>
                        <div class="modal-body pb-0">
                            <ul class="icon-wrapper"></ul>
                        </div>
                        <div class="modal-footer">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item">
                                        <button type="button" class="button button-bold button-cancel"
                                                data-dismiss="modal">Close
                                        </button>
                                    </li>
                                    <li class="action__item">
                                        <button class="button button-bold button-primary btn-add-icon">Select</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                </div>
            </div>
        </section>
    </main>

@endsection

@push('footerScripts')
<script type="text/javascript">
    var defaultSecurityMessage = JSON.parse('{!! json_encode($defaultSecurityMessage) !!}'),
        saved_security_message = {
            icon: '{!! addslashes(@$tcpaMessage['icon']) !!}',
            tcpa_text_style: '{!! addslashes(@$tcpaMessage['tcpa_text_style']) !!}',
        },
        current_security_message ;
    if(saved_security_message) {
        if (saved_security_message.icon && saved_security_message.icon !== "null") {
            saved_security_message.icon = JSON.parse(saved_security_message.icon);
        } else {
            saved_security_message.icon = defaultSecurityMessage.icon;
        }
        if (saved_security_message.tcpa_text_style && saved_security_message.tcpa_text_style !== "null") {
            saved_security_message.tcpa_text_style = JSON.parse(saved_security_message.tcpa_text_style);
        } else {
            saved_security_message.tcpa_text_style = defaultSecurityMessage.tcpa_text_style;
        }
        current_security_message = JSON.parse(JSON.stringify(saved_security_message));
    }

    $(document).ready(function () {
        setTimeout(() => {
            // adjustment related icon Style
            if(current_security_message.icon && current_security_message.icon != null) {
                let IconStyle = current_security_message.icon;
                if (IconStyle.enabled == true) {
                    $('#message-icon').prop("checked", true);
                    $('#message-icon').trigger("change", true);
                }

                if (IconStyle.icon && IconStyle.icon != null) {
                    $('#selectedIcon').addClass(IconStyle.icon);
                }

                if (IconStyle.color && IconStyle.color != null) {
                    $("#clr-icon").ColorPickerSetColor(IconStyle.color);
                }

                if (IconStyle.position && IconStyle.position != null) {
                    $('#select2js__icon-position').val(IconStyle.position).trigger('change');
                }

                if (IconStyle.size && IconStyle.size != null) {
                    $('#iconsize').val(IconStyle.size);
                    $('#ex1').bootstrapSlider('setValue', IconStyle.size);
                }
            }

            // adjustment related to text Style
            const security_message_text = $("#security_message_text");
            if(current_security_message.tcpa_text_style && current_security_message.tcpa_text_style != null) {
                let MessageTextStyle = current_security_message.tcpa_text_style;
                if (MessageTextStyle.is_bold && MessageTextStyle.is_bold != null) {
                    $(security_message_text).css("font-weight", "bold");
                    $('.txt-cta-bold').addClass('active');
                } else {
                    $(security_message_text).css("font-weight", "600");
                }

                if (MessageTextStyle.is_italic && MessageTextStyle.is_italic != null) {
                    $(security_message_text).css("font-style", "italic");
                    $('.txt-cta-italic').addClass('active');
                } else {
                    $(security_message_text).css("font-style", "normal");
                }

                if (MessageTextStyle.color && MessageTextStyle.color != null) {
                    $("#clr-text").ColorPickerSetColor(MessageTextStyle.color);
                }
            }
        }, 700);

        /**
         * reset to default font size
         */
        jQuery(document).on("click", '.icon-size-reset', function(){
            $('#iconsize').val(defaultSecurityMessage.icon.size);
            $('#ex1').bootstrapSlider('setValue', defaultSecurityMessage.icon.size).trigger("change");
        });
    });
</script>
@php
    if (!isset($tcpaMessage['tcpa_text'])){
        // set default tcpa_text
        $tcpaMessage['tcpa_text'] = $defaultSecurityMessage['tcpa_text'];
    }

    $iframeProps  = [
        "localStoragePrefix" => "tcpa_module_",
        "currenthash" => @$view->data->currenthash,
        "iframeHolder"=> "#preview_iframe",
        "iframeSrc" => $view->data->questionPreview->iframeSrc
    ];
@endphp

@include("partials.messages-preview-setup", [
    'data' => [$view, $tcpaMessage, $iframeProps]
]);

<script src="{{ config('view.theme_assets') . "/js/security_messages/security-messages.js?v=" . LP_VERSION }}"></script>
@endpush

