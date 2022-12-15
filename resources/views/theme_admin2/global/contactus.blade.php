@extends("layouts.leadpops")

@section('content')
<section id="page-footer-edit-1">
    <div class="container">
        <div class="alert alert-danger" id="alert-danger" style="display: none;">
            <button type="button" class="close" >x</button>
            <strong>Error:</strong>
            <p> </p>
        </div>
        <div class="global-links">
            <div class="row">
                <div class="col-md-12">
                    <div id="gie-btn" class="custom-btn-toggle inc-toggle">
                        <input checked data-toggle="toggle" class="responder-toggle is_include" data-onstyle="success" data-offstyle="danger" for="is_include" data-field = 'is_include' data-width="100" data-on="EXCLUDE" data-off="INCLUDE" type="checkbox">
                    </div>
                    <div class="pop-up-funnel">
                        <a href="#" data-toggle="modal" data-target="#funnel-selector" ><i class="fa fa-cog"> Select Funnels </i> </a>
                    </div>
                </div>
            </div>
        </div>
        <form class="form-inline" enctype="multipart/form-data" name="gffooter" id="gffooter" method="POST" action="{{  LP_BASE_URL.LP_PATH }}/global/savefooteroptions">
            {{csrf_field()}}
            <input type="hidden" name="client_id" id="client_id"  value="{{  @$view->data->client_id  }}">
            <input type="hidden" name="is_include" id="is_include" value="y">
            <input type="hidden" name="lpkey_contactus" id="lpkey_contactus" value="">
            <input type="hidden" name="theselectiontype" id="theselectiontype" value="contactus">
            <input type="hidden" name="contact_us_active" id="contact_us_active" value="{{  @$view->data->globalOptions['contact_us_active']  }}">
            <input type="hidden" name="gfot_ai_val" id="gfot_ai_val" value="{{  @$view->data->globalOptions['contact_us_active']  }}">
            <input type="hidden" name="theselection" id="theselection"  value="{{  @$view->data->globalOptions['contact_type']  }}">
            <input type="hidden" name="thelink" id="thelink"  value="contact_active">
            <input type="hidden" name="gfot-ai-flg" id="gfot-ai-flg"  value="0">

            <div class="lp-auto-responder">
                <div class="lp-auto-responder-head">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="col-left">
                                <h2 class="lp-heading-2">Contact Us</h2>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="custom-btn-toggle">
                                @php
                                    $checked="";
                                    if(@$view->data->globalOptions['contact_us_active']=='y'){
                                        $checked="checked";
                                    }
                                 @endphp
                                 <input {{  $checked  }} class="gfooter-toggle" data-field = 'contact_us_active' data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-pp-box">
                            <label for="textMsg" class="control-label lp-auto-responder-label lp-pp-lable">Link Contact Us to</label>
                            <select class="lp-select2 selectpicker" name="linktype" id="linktype" onchange="mytoggledestination()">
                                <option value="-1">Select One</option>
                                <option value="u" @if(@$view->data->globalOptions['contact_type']=='u') {{ 'selected="selected"' }} @endif>Another Website</option>
                                <option value="m" @if(@$view->data->globalOptions['contact_type']=='m') {{ 'selected="selected"' }} @endif>Your Funnel</option>
                            </select>
                            <label for="textMsg" class="control-label lp-auto-responder-label lp-pp-link-lable">Link text</label>
                            <input type="text" class="lp-auto-responder-inbox" name="theurltext"  id="theurltext"  value="{{ @$view->data->globalOptions['contact_text'] }}">
                        </div>
                    </div>
                </div>
                <div id="webaddress" class="row">
                    <div class="col-md-12">
                        <div class="lp-footer-msg-box">
                            <label for="textMsg" class="control-label lp-auto-responder-label lp-pp-lable">URL(with http://)</label>
                            <input type="text" class="lp-auto-responder-inbox" name="theurl"  id="theurl" value="{{ @$view->data->globalOptions['contact_url'] }}">
                        </div>
                    </div>
                </div>
                <div id="webmodal" class="row" style=" @if(@$view->data->globalOptions['contact_type']=='m') {{  'display:block' }} @else {{ 'display:none' }} @endif">
                    <div class="col-md-12">
                        <div class="lp-msg-box">
                            <textarea name="footereditor" class="lp-pp-section lp-froala-textbox">{{ @$view->data->globalOptions['contact'] }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="lp-save">
                        <div class="custom-btn-success">
                            <button type="button" onclick="saveglobalcontactus();" class="btn btn-success"><strong>SAVE</strong></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@include('partials.watch_video_popup')
@include('partials.funnelselector')
@endsection
