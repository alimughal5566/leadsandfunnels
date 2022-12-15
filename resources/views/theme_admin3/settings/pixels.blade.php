@extends("layouts.leadpops-inner-sidebar")

@section('content')
    @php
        use App\Constants\LP_Constants;
        $questions = LP_Helper::getInstance()->FunnelQuestionJson();
        $staticPixelName = ["10" => "Facebook Domain Verification", "11" => "Facebook Conversion API"];
    @endphp
        <main class="main">
            <!-- content of the page -->
            <section class="main-content">
                <!-- Title wrap of the page -->
                {{LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view)}}
                @include("partials.flashmsgs")
                <!-- content of the page -->
                <div class="lp-panel lp-panel__pb-0">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Tracking Pixels and Codes
                            </h2>
                        </div>
                        <div class="col-right">
                            <button class="button button-primary lp-btn-addCode">add code</button>
                        </div>
                    </div>
                    <div class="lp-panel__body p-0 pixel-panel">
                        <div class="lp-table">
                            <div class="lp-table__head">
                                <ul class="lp-table__list">
                                    <li class="lp-table__item">Code Name</li>
                                    <li class="lp-table__item">Options </li>
                                </ul>
                            </div>
                            <div class="lp-table__body">
                                <div class="message-block" style="">(You haven't added any Tracking Pixels or Codes yet)</div>
                                @if(@$view->data->pixels)
                                    @foreach(@$view->data->pixels as $pixel)
                                        @php
                                            $dataAttr = array();
                                            foreach($pixel as $c=>$v) {
                                                if(in_array($c, ['client_id','leadpops_id','client_leadpops_id','domain_id']))
                                                    continue;
                                                $dataAttr[] = 'data-'.$c."='$v'";
                                            }

                                            $dataAttr[] = 'data-pixel_type_label="'.LP_Constants::getPixelType($pixel['pixel_type']).'"';
                                            $dataAttr[] = 'data-pixel_placement_label="'.LP_Constants::getPixelPlace($pixel['pixel_placement']).'"';
                                            $dataAttr[] = 'data-pixel_position_label="'.LP_Constants::getPixelPosition($pixel['pixel_placement']).'"';
                                            $dataAttr[] = 'data-pixel_action_label="'.LP_Constants::getPixelAction($pixel['pixel_action']).'"';
                                            $pixel['pixel_name'] =  isset($staticPixelName[$pixel['pixel_type']]) ? $staticPixelName[$pixel['pixel_type']] : $pixel['pixel_name'];

                                        @endphp
                                        <div class="lp-table-item">
                                            <ul class="lp-table__list" id="pixel_{{$pixel['id']}}">

                                                <li class="lp-table__item" data-list-pixel-name>{{($pixel['pixel_name'])}}</li>
                                                <li class="lp-table__item">
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link btn-editCode" {!! implode(" ",$dataAttr); !!} >
                                                                    <span class="ico ico-edit"></span>edit
                                                                </a>
                                                            </li>
                                                            <li class="action__item">
                                                                <a href="#" class="action__link btn-deleteCode" {!! implode("
                                                        ",$dataAttr) !!} >
                                                                    <span class="ico ico-cross"></span>delete
                                                                </a>
                                                            </li>
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
                                                    <p>Are you sure you want to remove this pixel?</p>
                                                    <ul class="control">
                                                        <li class="control__item">
                                                            <a href="javascript:void(0);" class="lp-table_yes btnAction_confirmPixelDelete">Yes</a>
                                                        </li>
                                                        <li class="control__item">
                                                            <a href="javascript:void(0);" class="lp-table_no">No</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
                <!-- footer of the page -->
                <div class="footer">
                    @include("partials.footerlogo")
                </div>
            </section>
        </main>

    <!-- start Modal -->
    <div class="modal fade pixel-code__pop" id="model_pixel_code"  data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="model_pixel_code" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content select2js__codetype-parent">
                <form
                    data-global_action="{{ LP_PATH }}/global/pixelActionGlobalAdminThree"
                    data-action="{{ LP_PATH }}/popadmin/savepixelinfo"
                    action=""
                    method="post"
                    id="dd-code-popup"
                    class="form-pop global-content-form" >

                    @csrf
                    <input name="action" id="action" type="hidden" />
                    <input name="id" id="id" type="hidden" />
                    <input name="current_hash" id="current_hash" type="hidden" value="{{ @$view->data->current_hash }}" />
                    <input name="client_id" id="client_id" type="hidden" value="{{ @$view->data->client_id }}" />
                    <input name="saved_pixel_code" id="saved_pixel_code" value="" type="hidden">
                    <input name="saved_pixel_type" id="saved_pixel_type" value="" type="hidden">
                    <input name="saved_pixel_placement" id="saved_pixel_placement" value="" type="hidden">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Pixels and Tracking Codes</h5>
                    </div>
                    <div class="modal-body pixel-quick-scroll">

                        <div class="form-group">
                            <label class="modal-lbl">Code Type</label>
                            <div class="input__holder">
                                <div class="select2 select2js__pixel_codetype-parent select2js__nice-scroll">
                                    <select class="form-control select2js__codetype" name="pixel_type" data-name="pixel_type" data-default-val="{{LP_Constants::BING_PIXELS}}" data-default-label="{{LP_Constants::getPixelType(LP_Constants::BING_PIXELS)}}" id="pixel_type" data-form-field>
                                        @foreach(LP_Constants::pixelTypeList() as $id=>$pixel)
                                            <option value="{{ $id }}">{{ $pixel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group facebook-domain-verification">
                            <label class="modal-lbl">Pixel Placement</label>
                            <div class="input__holder">
                                <div class="select2 select2js__pixelplacement-parent">
                                    <select class="form-control select2js__pixelplacement" id="pixel_placement" name="pixel_placement" data-name="pixel_placement" data-default-val="{{LP_Constants::PIXEL_PLACEMENT_BODY}}" data-default-label="{{LP_Constants::getPixelPlace(LP_Constants::PIXEL_PLACEMENT_BODY)}}" data-form-field>
                                        @foreach(LP_Constants::pixelPlacementsList() as $id=>$pixel)
                                            <option value="{{ $id }}">{{ $pixel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group  facebook-domain-verification">
                            <label class="modal-lbl">Code Name</label>
                            <div class="input__holder">
                                <input class="form-control" id="pixel_name" name="pixel_name" type="text" required data-form-field>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="modal-lbl tracking_to_lender">Tag ID</label>
                            <div class="input__holder">
                                <input class="form-control" type="text" id="pixel_code" name="pixel_code" required data-form-field>
                            </div>
                        </div>
                        <div class="pixel_extra pixel_other" style="display: none;">
                            <div class="form-group">
                                <label class="modal-lbl pixel_other_label"></label>
                                <div class="input__holder">
                                    <input class="form-control" type="text" name="pixel_other" id="pixel_other" data-form-field>
                                </div>
                            </div>
                        </div>
                        <div class="tracking_options" style="display: none;">
                            <div class="form-group">
                                <label class="modal-lbl">Tracking Options</label>
                                <div class="input__holder">
                                    <div class="select2 select2js__trackoption-parent" >

                                        <select class="form-control select2js__trackoption" name="tracking_options" id="tracking_options" data-name="tracking_options" data-default-val="@php echo LP_Constants::PIXEL_PAGE_VIEW; @endphp" data-default-label="@php echo LP_Constants::pixelTrackingList(LP_Constants::PIXEL_PAGE_VIEW); @endphp" value="{{LP_Constants::PIXEL_PAGE_VIEW==$id}}" data-form-field>
                                            @foreach(LP_Constants::pixelTrackingList() as $id=>$pixel)
                                                <option   value="{{ $id }}" {{LP_Constants::PIXEL_PAGE_VIEW==$id?'selected':''}}>{{ $pixel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="question_options" style="display: none;">
                            <div class="form-group align-items-start">
                                <label class="modal-lbl my-2 py-1">
                                Question Options <span class="question-mark question-mark_tooltip question-mark_modal el-tooltip ml-1"
                                title="We'll fire a Facebook Pixel (Contact Event) to build your custom <br /> audience based on how people answer questions in your leadPops<br />  Funnel. <br /><br /> This allows leadPops to dynamically 'tell' Facebook what types of <br /> characteristics you prefer in an ideal client, i.e. -- they answer Excellent <br /> or Good credit, they make at least $80K per year, they have a minimum <br />  of 10% for a down payment, etc.<br /> <br />Simply check the box next to answer(s) that you'd like your ideal client <br />  to provide, and our technology will take care of the rest!"><span class="ico-question "></span></span>
                            </label>
                                <div class="ka-dd">

                                    <div id="ka-dd-toggle" class="ka-dd__button">
                                        <span class="displayText">Select Question(s)</span>
                                        <span class="caret"></span>
                                    </div>
                                    <div class="ka-dd__menu">
                                        <div class="ka-dd__scroll">
                                            @php
                                                $i = 1;
                                                foreach($questions as $k => $v){
                                                $q =  preg_replace("/[^A-Za-z_]/", "",   strtolower($k));
                                            @endphp
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed"  href="#gfunnel@php echo $q;@endphp" data-toggle="collapse">
                                                    <div class="ka-dd__ellipsis" title="@php echo $v->text; @endphp" >
                                                        <span class="question">@php echo substr($v->text,0,45); @endphp</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnel@php echo $q;@endphp" data-type="pixels-page">
                                                    @php if($v->type == 4){@endphp
                                                    <div class="item za-zip-code">
                                                        <label for="@php echo $k;@endphp"><span></span>
                                                            <strong>Enter 1 Zip Code Per Line Below</strong>
                                                            <br />
                                                            <textarea type="text" class="form-control ka-dd__form-control zip_code txt" name="zip_code" cols="6" rows="10" data-form-field-custom-cb></textarea>
                                                        </label>
                                                    </div>
                                                    @php }else if($v->type == 1){
                                                        foreach($v->values as $i => $a){
                                                        $q =  preg_replace("/[^A-Za-z0-9_]/", "",   str_replace('.','_',strtolower($k.$a)));
                                                        $ans_length = strlen($a);
                                                    @endphp
                                                    <div class="item @php echo ($ans_length >= 40)?'za-long-answer':''; @endphp">
                                                        <input type="checkbox" id="@php echo $q;@endphp" class="answer" name="answer[]" value="@php echo $k.'|'.$a; @endphp" data-form-field-custom-cb/>
                                                        <label for="@php echo $q;@endphp"><span></span>
                                                            <strong>@php echo strip_tags($a); @endphp</strong>
                                                        </label>
                                                    </div>
                                                    @php } }else if($v->type == 3){
                                                        $zero = LP_Helper::getInstance()->CurrencyFormat($v->min);
                                                        $first = LP_Helper::getInstance()->CurrencyFormat(reset($v->values));
                                                        $last = LP_Helper::getInstance()->CurrencyFormat(end($v->values));
                                                        $val = ($zero != 0)?$first:$zero;
                                                    @endphp
                                                    <div class="item za-slider" data-question="@php echo $q; @endphp">
                                                        <input type="checkbox" data-value="@php echo $q; @endphp"  id="@php echo $q;@endphp" class="answer" name="answer[]" value="@php echo $q.'|'.$val.'~'.$last; @endphp" data-form-field-custom-cb/>
                                                        <label for="@php echo $q;@endphp"><span></span>
                                                            <strong>@php echo $v->min.' - '.$v->max; @endphp</strong>
                                                            <input type="text" class="form-control ka-dd__form-control slider_question min txt" placeholder="@php echo $val; @endphp" value="" data-min="@php echo $val; @endphp" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false"> -
                                                            <input type="text" class="form-control ka-dd__form-control slider_question max txt" placeholder="@php echo $last; @endphp" value="" data-max="@php echo $last; @endphp" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false">
                                                        </label>
                                                    </div>
                                                    @php } @endphp
                                                </div>
                                            </div>
                                            @php $i++; } @endphp
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pixel_position">
                            <div class="form-group">
                                <label class="modal-lbl" for="pixel_position">Code Location</label>
                                <div class="input__holder">
                                    <div class="select2 select2__loc-parent">
                                        <select class="form-control select2__loc"  name="pixel_position" data-name="pixel_position" data-default-val="{{LP_Constants::PIXEL_PLACEMENT_HEAD}}" data-default-label="{{LP_Constants::getPixelPosition(LP_Constants::PIXEL_PLACEMENT_HEAD)}}"  id="pixel_position" data-form-field>
                                            @foreach(LP_Constants::pixelPositionList() as $id=>$pixel)
                                                <option value="{{$id}}">{{$pixel}}</option>
                                            @endforeach
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
                                    <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                                </li>
                                <li class="action__item">
                                    <input id="add_code_submit" title="Page View + Questions are not available<br> in Global Setting mode. Turn off Global<br> Setting at the top to add." class="button button-primary lp-btn-add pixel-model el-tooltip" value="add code" type="button">
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- PIXEL DELETE POPUP - Start -->
    <div id="model_confirmPixelDelete"  data-backdrop="static"  class="modal fade lp-modal-box in">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title">Confirmation</h3>
                </div>
                <div class="modal-body model-action-body">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-sm-12 modal-action-msg-wrap">
                                <div id="notification_confirmPixelDelete" class="modal-msg"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer lp-modal-action-footer">
                    <form id="form_confirmpixelDelete" method="post" action="">
                        <input type="hidden" id="id_confirmPixelDelete" value="" />
                        <input id="current_hash_confirmPixelDelete" type="hidden" value="@php echo @$view->data->current_hash; @endphp" />
                        <input id="client_id_confirmPixelDelete" type="hidden" value="@php echo @$view->data->client_id; @endphp" />
                    </form>
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" id="deleteDismiss" class="button button-cancel btnCancel_confirmPixelDelete" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" id="deleteConfirm" class="button button-primary btnAction_confirmPixelDelete">Delete</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PIXEL DELETE POPUP - End -->

@endsection
@push('footerScripts')
    <script>
        @php
            $trackingOption = array();
            foreach(LP_Constants::pixelTrackingList() as $id=>$pixel){
                array_push($trackingOption, array('value'=>$id, 'title'=>$pixel, 'visible'=>true));
            }

        @endphp
        let trackingOption={!! json_encode($trackingOption) !!};
        let staticPixelName = {!! json_encode($staticPixelName) !!};
    </script>
    <script src="{{ config('view.theme_assets') }}/pages/pixels.js?v={{ LP_VERSION }}"></script>
@endpush
