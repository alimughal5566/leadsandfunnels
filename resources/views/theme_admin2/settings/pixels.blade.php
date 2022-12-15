@extends("layouts.leadpops")

@section('content')
    <div class="container">
        @php
            use App\Constants\LP_Constants;
            LP_Helper::getInstance()->getFunnelHeader($view);
        @endphp

        <form class="form-inline" method="post">
            <div class="lp-pixels">
                <div class="lp-pixels-head">
                    <div class="row">
                        <div class="col-md-10">
                            <h2>Tracking Pixels and Codes</h2>
                        </div>
                        <div class="col-md-2">
                            <a href="#" class="btn btn-default lp-btn-addCode">ADD CODE</a>
                        </div>
                    </div>
                </div>
                <div class="lp-pixels-col">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="domain-edit">
                                <h3>Code Name</h3><h3>Options</h3>
                            </div>

                            @php
                            //debug(@$view->data->pixels);
                            if(@$view->data->pixels){
                                foreach(@$view->data->pixels as $pixel){
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
                                    @endphp
                                    <div class="domain-edit pixel_@php echo $pixel['id']; @endphp">
                                        @php echo $pixel['pixel_name']; @endphp <a href="#" class="btn-deleteCode" @php echo implode(" ",$dataAttr); @endphp ><i class="fa fa-remove"></i>DELETE</a><a href="#" class="btn-editCode" @php echo implode(" ",$dataAttr); @endphp><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                    </div>
                                    @php
                                }
                            }
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- -- -- -- -- PIXEL POPUP HTML - START -- -- -- -- -->
    <div class="modal fade add_recipient lp-add-code" id="model_pixel_code">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Pixels and Tracking Codes</h3>
                </div>
                <div class="modal-body">
                    <form action="{{ LP_PATH }}/popadmin/savepixelinfo" method="post" id="add-code-popup" class="form-inline lp-popup-form">
                        {{ csrf_field() }}
                        <input name="action" id="action" type="hidden" />
                        <input name="id" id="id" type="hidden" />
                        <input name="current_hash" id="current_hash" type="hidden" value="{{ @$view->data->current_hash }}" />
                        <input name="client_id" id="client_id" type="hidden" value="{{ @$view->data->client_id }}" />

                        <div class="row">
                            <div class="col-md-12 pixel-drop">
                                <div class="form-group">
                                    <label class="control-label lp-popup-label" for="subject">Code Type</label>
                                    <span class="leadpop-select-menu form-control fields">
                                    <div class="dropdown dropdown-toggle leadpop-dropdown" data-name="pixel_type" data-default-val="@php echo LP_Constants::BING_PIXELS; @endphp" data-default-label="@php echo LP_Constants::getPixelType(LP_Constants::BING_PIXELS); @endphp" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="firstLabel lpLabel"><span class="displayText"><span></span></span> <span class="caret"></span></span>
                                        <input type="hidden" value="" id="pixel_type" name="pixel_type">
                                        <ul class="leadpop-list dropdown-list">
                                            @foreach(LP_Constants::pixelTypeList() as $id=>$pixel)
                                            <li data-value="{{ $id }}"><span>{{ $pixel }}</span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                 </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 pixel-drop">
                                <div class="form-group">
                                    <label class="control-label lp-popup-label" for="subject">Code Placement</label>

                                    <!-- Funnel / Thank you -->
                                    <span class="leadpop-select-menu form-control fields">
                                    <div class="dropdown dropdown-toggle leadpop-dropdown" data-name="pixel_placement" data-default-val="@php echo LP_Constants::PIXEL_PLACEMENT_BODY; @endphp" data-default-label="@php echo LP_Constants::getPixelPlace(LP_Constants::PIXEL_PLACEMENT_BODY); @endphp" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="firstLabel lpLabel"><span class="displayText"><span></span></span> <span class="caret"></span></span>
                                        <input type="hidden" value="" id="pixel_placement" name="pixel_placement">
                                        <ul class="leadpop-list dropdown-list">
                                            @php
                                                foreach(LP_Constants::pixelPlacementsList() as $id=>$pixel){
                                            @endphp
                                            <li data-value="@php echo $id; @endphp"><span>@php echo $pixel; @endphp</span></li>
                                            @php
                                                }
                                            @endphp
                                        </ul>
                                    </div>
                                </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 pixel-drop">
                                <div class="form-group">
                                    <label class="control-label lp-popup-label" for="code_name">Code Name</label>
                                    <input class="form-control form-width fields z-pixel" name="pixel_name" id="pixel_name" type="text" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 pixel-drop">
                                <div class="form-group">
                                    <label class="control-label lp-popup-label tracking_to_lender" for="tracking_id">Tag ID</label>
                                    <input type="text" class="form-control fields z-pixel" name="pixel_code" id="pixel_code" required>
                                </div>
                            </div>
                        </div>

                        <div class="row pixel_extra pixel_other" style="display: none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label lp-popup-label pixel_other_label"></label>
                                    <input class="form-control form-width fields z-pixel" name="pixel_other" id="pixel_other" type="text">
                                </div>
                            </div>
                        </div>

                        <!-- Code Postion  Head - Body - Footer -->
                        <div class="row">
                            <div class="col-md-12 pixel-drop pixel_position">
                                <div class="form-group">
                                    <label class="control-label lp-popup-label" for="subject">Code Location</label>

                                    <span class="leadpop-select-menu form-control fields">
                                    <div class="dropdown dropdown-toggle leadpop-dropdown" data-name="pixel_position" data-default-val="@php echo LP_Constants::PIXEL_PLACEMENT_HEAD; @endphp" data-default-label="@php echo LP_Constants::getPixelPosition(LP_Constants::PIXEL_PLACEMENT_HEAD); @endphp" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="firstLabel lpLabel"><span class="displayText"><span></span></span> <span class="caret"></span></span>
                                        <input type="hidden" value="" id="pixel_position" name="pixel_position">
                                        <ul class="leadpop-list dropdown-list">
                                            @foreach(LP_Constants::pixelPositionList() as $id=>$pixel)
                                            <li data-value="{{ $id }}"><span>{{ $pixel }}</span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </span>
                                </div>
                            </div>
                        </div>

                        <!--Muhamad Zulfiqar-->
                        <div class="row tracking_options" style="display: block;">
                            <div class="col-md-12 pixel-drop">
                                <div class="form-group">
                                    <label class="control-label lp-popup-label" for="subject">Tracking Options</label>

                                    <span class="leadpop-select-menu form-control fields">
                                    <div class="dropdown dropdown-toggle leadpop-dropdown" data-name="tracking_options" data-default-val="@php echo LP_Constants::PIXEL_PAGE_VIEW; @endphp" data-default-label="@php echo LP_Constants::pixelTrackingList(LP_Constants::PIXEL_PAGE_VIEW); @endphp" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="firstLabel lpLabel"><span class="displayText"><span></span></span> <span class="caret"></span></span>
                                        <input type="hidden" value="" id="tracking_options" name="tracking_options">
                                        <ul class="leadpop-list dropdown-list">
                                            @foreach(LP_Constants::pixelTrackingList() as $id=>$v)
                                            <li data-value="{{ $id }}"><span>{{ $v }}</span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </span>
                                </div>
                            </div >
                        </div>

                        <div class="row question_options" style="display: block;">
                            @php $re = LP_Helper::getInstance()->FunnelQuestionJson(); @endphp
                            <div class="col-md-12 pixel-drop ">
                                <div class="form-group tooltip-container za-question-tooltip">
                                    <label class="control-label lp-popup-label ka-label" for="subject">Questions <i class="fa fa-question-circle label-tooltip" data-toggle="tooltip" data-placement="top" data-html="true"  title="We'll fire a Facebook Pixel (Contact Event) to build your custom <br /> audience based on how people answer questions in your leadPops<br />  Funnel. <br /><br /> This allows leadPops to dynamically 'tell' Facebook what types of <br /> characteristics you prefer in an ideal client, i.e. -- they answer Excellent <br /> or Good credit, they make at least $80K per year, they have a minimum <br />  of 10% for a down payment, etc.<br /> <br />Simply check the box next to answer(s) that you'd like your ideal client <br />  to provide, and our technology will take care of the rest!"></i></label>
                                    <div class="ka-dd">
                                        <div id="ka-dd-toggle" class="ka-dd__button">
                                            <span class="displayText">Select Question(s)</span>
                                            <span class="caret"></span>
                                        </div>
                                        <div class="ka-dd__menu">
                                            <div class="ka-dd__scroll">
                                                @php
                                                    $i = 1;
                                                    foreach($re as $k => $v){
                                                    $q =  preg_replace("/[^A-Za-z_]/", "",   strtolower($k));
                                                @endphp
                                                <div class="ka-dd__list">
                                                    <a class="ka-dd__link collapsed"  href="#gfunnel@php echo $q;@endphp" data-toggle="collapse">
                                                        <div class="ka-dd__ellipsis" data-toggle="tooltip" data-placement="top" data-html="true" title="@php echo $v->text; @endphp" >
                                                            <span class="question">@php echo substr($v->text,0,45); @endphp</span>
                                                        </div>
                                                    </a>
                                                    <div class="panel-collapse collapse" id="gfunnel@php echo $q;@endphp">
                                                        @php if($v->type == 4){@endphp
                                                        <div class="item za-zip-code">
                                                            <label for="@php echo $k;@endphp"><span></span>
                                                                <strong>Enter 1 Zip Code Per Line Below</strong>
                                                                <br />
                                                                <textarea type="text" class="form-control ka-dd__form-control zip_code txt" name="zip_code" cols="6" rows="10"></textarea>
                                                            </label>
                                                        </div>
                                                        @php }else if($v->type == 1){
                                                        foreach($v->values as $i => $a){
                                                        $q =  preg_replace("/[^A-Za-z0-9_]/", "",   str_replace('.','_',strtolower($k.$a)));
                                                        $ans_length = strlen($a);
                                                        @endphp
                                                        <div class="item @php echo ($ans_length >= 40)?'za-long-answer':''; @endphp">
                                                            <input type="checkbox" id="@php echo $q;@endphp" class="answer" name="answer[]" value="@php echo $k.'|'.$a; @endphp" />
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
                                                            <input type="checkbox" data-value="@php echo $q; @endphp"  id="@php echo $q;@endphp" class="answer" name="answer[]" value="@php echo $q.'|'.$val.'~'.$last; @endphp" />
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
                        </div>


                        <div class="row">
                            <div class="col-md-12 pixel-drop">
                                <div class="lp-modal-footer footer-border">
                                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                                    <input type="submit" class="btn lp-btn-add pixel-model" value ="ADD CODE">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- -- -- -- -- PIXEL POPUP HTML - ENDS -- -- -- -- -->

    <!-- PIXEL DELETE POPUP - Start -->
    <div id="model_confirmPixelDelete" class="modal fade lp-modal-box in">
        <div class="modal-dialog">
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
                <div class="lp-modal-footer lp-modal-action-footer">
                    <form id="form_confirmpixelDelete" method="post" action="">
                        <input type="hidden" id="id_confirmPixelDelete" value="" />
                        <input id="current_hash_confirmPixelDelete" type="hidden" value="@php echo @$view->data->current_hash; @endphp" />
                        <input id="client_id_confirmPixelDelete" type="hidden" value="@php echo @$view->data->client_id; @endphp" />
                    </form>
                    <a data-dismiss="modal" class="btn btnCancel_confirmPixelDelete lp-btn-cancel">Close</a>
                    <a class="btn lp-btn-add btnAction_confirmPixelDelete">Delete</a>&nbsp;
                </div>
            </div>
        </div>
    </div>
    <!-- PIXEL DELETE POPUP - End -->
    @include('partials.watch_video_popup')
@endsection
