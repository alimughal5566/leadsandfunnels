@extends("layouts.leadpops-inner-sidebar")
@section('content')

    @php
        if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
            $firstkey = @$view->data->clickedkey;
        }else {
            $firstkey = "";
        }

    $defaultTcpaMessage = config('lp.tcpa_message.defaults.tcpa_text')??'';
    $tcpa_checkbox = config('lp.tcpa_message.defaults.tcpa_checkbox') == 1 ? 'checked':'';
    $tcpa_title = config('lp.tcpa_message.defaults.tcpa_title')??'';
    $is_required_ckb = config('lp.tcpa_message.defaults.is_required_ckb') == 1 ? 'checked':'';

    @endphp

    <main class="main">
        <section class="main-content tcpa-message-content">
            <!-- Title wrap of the page -->
            <input type="hidden" id="theme_color" value="{{ $view->data->advancedfooteroptions["logocolor"] ?? '#00ccff'}}">
        @php LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view, false, false, false,
        [
        'link' =>route('tcpaIndex', [@$view->data->currenthash]),
        'text' => 'BACK TO MESSAGE LIST'
        ])
        @endphp


        @include("partials.flashmsgs")

        @php
            $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
        @endphp

        <!-- content of the page -->
            <div class="lp-panel tcpa-message-pannel">
                <!-- content page head -->

                <form id="create-tcpa-form" action="{{route('createTcpaFromMessage')}}" data-edit="false"
                      data-global_action="{{route('createTcpaFromMessage')}}" method="post">


                    {{ csrf_field() }}
                    <input type="hidden" name="client_id" id="client_id"
                           value="@php echo @$view->data->client_id @endphp">
                    <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                    <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                    <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                    <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                    <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                    <input type="hidden" name="messageContent" id="messageContent" data-form-field>

                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Add New Message
                            </h2>
                            <ul class="action-view-list">
                                <li class="action-view-item desktop active">
                                    <i class="ico ico-devices"></i>
                                </li>
                                <li class="action-view-item mobile">
                                    <i class="ico ico-Mobile"></i>
                                </li>
                            </ul>
                        </div>
                        <div class="col-right">
                            <div class="tcpa-checkbox-btn">
                                <label class="checkbox-label">
                                    <input class="field-label" name="is_active" type="checkbox" {{$tcpa_checkbox}} data-form-field>
                                    <span class="checkbox-area">
                                        <span class="handle"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- content page body -->

                    <div class="lp-panel__body">
                        <div class="tcpa-message-detail">
                            <div class="background-detail__area">
                                <div class="theme__header">
                                    <div class="dots"></div>
                                    <div class="dots"></div>
                                    <div class="dots"></div>
                                </div>
                                {{--<div class="tcpa-iframe-holder">
                                    <div class="tcpa-iframe-area" id="preview_iframe">

                                    </div>
                                </div>--}}
                                <div class="theme__body" id="preview_iframe">

                                    {{--<iframe class="tcpa-iframe"  id="iframe" src="{{LP_BASE_URL.'/previewbars/zipcode-preview.php?ls_key='.$view->data->currenthash}}"></iframe>--}}

                                </div>
                            </div>
                            <div class="bg-controls-block">
                                <div class="right-sidebar">
                                    <div class="right-block-holder">
                                    <div class="form-group">
                                        <div class="title-holder">
                                            <strong class="title">Message Name</strong>
                                        </div>
                                        <div class="field-holder">
                                            <input type="text" name="tcpa_title" id="tcpa_title" class="form-control"
                                                   value="{{$tcpa_title}}" data-form-field>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="title-holder">
                                            <strong class="title">Content</strong>
                                        </div>
                                        <div class="field-holder">
                                            <div class="classic-editor__wrapper update-version">
                                                <div class="tcpa-message-froala">
                                                    {{$defaultTcpaMessage}}
                                                </div>
                                            </div>
                                            <span class="editor-error-message d-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="field-holder">
                                            <div class="checkbox-area">
                                                <label class="label-text">Add “required” checkbox</label>
                                                <div class="tcpa-checkbox-btn-small">
                                                    <label class="checkbox-label">
                                                        <input class="field-label" name="is_required"
                                                               id="is_required_ckb" type="checkbox" {{$is_required_ckb}}
                                                               data-form-field>
                                                        <span class="checkbox-area">
                                                            <span class="handle"></span>
                                                        </span>
                                                    </label>
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
            <div id="contentHtml" style="display: none">{{$defaultTcpaMessage}}</div>
            <div class="footer">
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                </div>
            </div>
        </section>
    </main>
@endsection

@php


    if (!isset($tcpaMessage['tcpa_text'])){
       // set default tcpa_text
       $tcpaMessage['tcpa_text'] =  $defaultTcpaMessage;
       }


       $iframeProps  = [
       "localStoragePrefix" => "tcpa_module_",
       "currenthash" => @$view->data->currenthash,
       "iframeHolder"=> "#preview_iframe",
       "iframeSrc" => $view->data->questionPreview->iframeSrc,
       "showCtaMessages" => 0,
       "showFeatureImage" => 0,
       ];
@endphp

@include("partials.messages-preview-setup", [
'data' => [$view, @$tcpaMessage, $iframeProps]
]);
@push('footerScripts')
<script src="{{ config('view.theme_assets') . "/js/tcpa/tcpa.js?v=" . LP_VERSION }}"></script>
<script>


    $(document).ready(function () {
        $('#messageContent').val($('#contentHtml').html());
    })
</script>
@endpush
