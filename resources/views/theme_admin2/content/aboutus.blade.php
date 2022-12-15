@extends("layouts.leadpops")

@section('content')
    @php
    if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
        $firstkey = @$view->data->clickedkey;
    }else {
        $firstkey = "";
    }
    @endphp

    <section id="page-footer-edit-1">
        <div class="container">
            @php
                LP_Helper::getInstance()->getFunnelHeader($view);
                $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
            @endphp
            <form class="form-inline" enctype="multipart/form-data" name="ffooter" id="ffooter" method="POST" action="@php echo LP_BASE_URL.LP_PATH."/popadmin/savefooteroptions"; @endphp">
                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id"  value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="theselection" id="theselection"  value="@php echo @$view->data->bottomlinks['about_type'] @endphp">
                <input type="hidden" name="theselectiontype" id="theselectiontype"  value="aboutus">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash" value="@php echo @$view->data->currenthash @endphp">
                <div class="alert alert-danger" id="alert-danger" style="display: none;">
                    <button type="button" class="close" >x</button>
                    <strong>Error:</strong>
                    <p> </p>
                </div>

                <div class="lp-auto-responder">
                    <div class="lp-auto-responder-head">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="col-left">
                                    <h2 class="lp-heading-2">@php echo (@$view->data->bottomlinks['about_text'] == "" ? "About Us" : @$view->data->bottomlinks['about_text']);  @endphp</h2>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-btn-toggle">
                                    @php
                                    $checked="";
                                    if(@$view->data->bottomlinks['about_active']=='y'){
                                        $checked="checked";
                                    }
                                    @endphp
                                    <input @php echo $checked; @endphp data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox" class="pptogbtn" data-lpkeys="@php echo @$view->data->lpkeys."~about_active"; @endphp">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-pp-box">
                                <label for="textMsg" class="control-label lp-auto-responder-label lp-pp-lable">Link About us to</label>
                                <select class="lp-select2 selectpicker" name="linktype" id="linktype" onchange="mytoggledestination()">
                                    <option value="-1">Select One</option>
                                    <option value="u" @php echo (@$view->data->bottomlinks['about_type']=='u'?'selected="selected"':'') @endphp>Another Website</option>
                                    <option value="m" @php echo (@$view->data->bottomlinks['about_type']=='m'?'selected="selected"':'') @endphp>Your Funnel</option>
                                </select>
                                <label for="textMsg" class="control-label lp-auto-responder-label lp-pp-link-lable">Link text</label>
                                <input type="text" class="lp-auto-responder-inbox" name="theurltext"  id="theurltext"  value="@php echo @$view->data->bottomlinks['about_text'];  @endphp">
                            </div>
                        </div>
                    </div>
                    <div id="webaddress" class="row">
                        <div class="col-md-12">
                            <div class="lp-footer-msg-box">
                                <label for="textMsg" class="control-label lp-auto-responder-label lp-pp-lable">URL(with http://)</label>
                                <input type="text" class="lp-auto-responder-inbox" name="theurl"  id="theurl" value="@php echo @$view->data->bottomlinks['about_url'];@endphp">
                            </div>
                        </div>
                    </div>
                    <div id="webmodal" class="row" style=" @php echo (@$view->data->bottomlinks['about_type']=='m'?'display:block':'display:none') @endphp;">
                        <div class="col-md-12">
                            <div class="lp-msg-box">
                                <textarea name="footereditor" class="lp-froala-textbox lp-pp-section">@php echo @$view->data->bottomlinks['about']; @endphp</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-save">
                            <div class="custom-btn-success">
                                <button type="button" onclick="savebottomlinkmessage();" class="btn btn-success"><strong>SAVE</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('partials.watch_video_popup')
@endsection
