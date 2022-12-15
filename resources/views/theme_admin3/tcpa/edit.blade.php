@extends("layouts.leadpops-inner-sidebar")
@section('content')

    @php
        if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
            $firstkey = @$view->data->clickedkey;
        }else {
            $firstkey = "";
        }

    // dd(@$view->data->tcpaMessage);

    $tcpaMessage = @$view->data->tcpaMessage;

   $first_question = @$view->data->required_question;
 //   print_r($tcpaMessage);
 // dd($tcpaMessage);


      $imagesrc = \View_Helper::getInstance()
        ->getCurrentFrontImageSource( @$view->data->client_id, @$view->data->funnelData );
$theimage = "";
        if($imagesrc){
            list($imagestatus,$theimage, $noimage) = explode("~",$imagesrc);
            $currentImage = "";
            if(!empty($theimage)) {
                $arr = explode('/', $theimage);
                if(is_array($arr)) {
                    $currentImage = end($arr);
                }
            }

      // dd($currentImage, $theimage, $imagesrc);
    }




     $homePageMessageMainMessage = trim(textCleaner($view->data->homePageMessageMainMessage));
    $homePageMessageDescription = trim($view->data->homePageMessageDescription);

    $homePageMessageMainMessageStyle = $view->data->messageStyle;
    $homePageMessageDescriptionStyle = $view->data->dmessageStyle;
    @endphp

    <main class="main">
        <section class="main-content tcpa-message-content">
            <!-- Title wrap of the page -->

        {{--        @php LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view, false, false, false, route('tcpaIndex', [@$view->data->currenthash])) @endphp--}}
            <input type="hidden" id="theme_color" value="{{ $view->data->advancedfooteroptions["logocolor"] ?? '#00ccff'}}">
        @php LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view, false, false, false,
        [
        'link' => route('tcpaIndex', [@$view->data->currenthash]),
        'text' => 'BACK TO MESSAGE LIST'
        ]);
        @endphp

        @include("partials.flashmsgs")

        @php
            $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
        @endphp

        <!-- content of the page -->
            <div class="lp-panel tcpa-message-pannel">
                <!-- content page head -->

                <form id="create-tcpa-form" action="{{route('editTcpaFromMessage', [$tcpaMessage['id']])}}"
                      data-edit="true"
                      data-global_action="{{route('editTcpaFromMessage', [$tcpaMessage['id']])}}" method="post">


                    {{ csrf_field() }}
                    <input type="hidden" name="client_id" id="client_id"
                           value="@php echo @$view->data->client_id @endphp">
                    <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                    <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                    <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                    <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                    <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                    <input type="hidden" name="tcpa_message_id" id="tcpa_message_id" value="{{$tcpaMessage['id']}}">
                    <input type="hidden" name="messageContent" data-form-field id="messageContent" value="{{$tcpaMessage['tcpa_text']?? ""}}">


                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Update Message
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
                                    <input class="field-label" name="is_active" type="checkbox"
                                           {{$tcpaMessage['is_active']? "checked": ""}} data-form-field>
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
                                {{-- <div class="tcpa-iframe-holder">
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
                                            <input type="text" name="tcpa_title" class="form-control"
                                                   value="{{$tcpaMessage['tcpa_title']?? ""}}" data-form-field>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="title-holder">
                                            <strong class="title">Content</strong>
                                        </div>
                                        <div class="field-holder">
                                            <div class="classic-editor__wrapper update-version">
                                                <div class="tcpa-message-froala">
                                                    {!! html_entity_decode($tcpaMessage['tcpa_text']?? "")!!}
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
                                                               id="is_required_ckb" type="checkbox"
                                                               {{$tcpaMessage['is_required']? "checked": ""}} data-form-field>
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

            <div id="contentHtml" style="display: none">{!!  @$tcpaMessage['tcpa_text'] !!}</div>
            <div class="footer">
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                </div>
            </div>
        </section>
    </main>
@endsection

@push('footerScripts')


@php
    $iframeProps  = [ "localStoragePrefix" => "tcpa_module_",
            "currenthash" => @$view->data->currenthash,
            "iframeHolder"=> "#preview_iframe",
            "iframeSrc" => $view->data->questionPreview->iframeSrc,
            "showCtaMessages" => 0,
            "showFeatureImage" => 0,
            ];
@endphp

@include("partials.messages-preview-setup", [
'data' => [$view, $tcpaMessage, $iframeProps]
]);
<script src="{{ config('view.theme_assets') . "/js/tcpa/tcpa.js?v=" . LP_VERSION }}"></script>
@endpush


