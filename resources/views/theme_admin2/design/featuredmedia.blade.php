@extends("layouts.leadpops")

@section('content')
    @php
       if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
           $firstkey = @$view->data->clickedkey;
       }else {
           $firstkey = "";
       }
       $imagesrc = \View_Helper::getInstance()->getCurrentFrontImageSource(@$view->data->client_id,@$view->data->funnelData);
       if($imagesrc){
           list($imagestatus,$theimage, $noimage) = explode("~",$imagesrc);

           if($imagestatus == 'default') {
               $imagedescr =  "homedefault";
           }
           else if($imagestatus == 'mine') {
               $imagedescr =  "myhome";
           }

           $active_inactive_checked="checked";

           if($noimage=="noimage") {
               $active_inactive_checked="";
               $imagedescr =  "nohome";
           }
       }else{
           $theimage = '';
           $active_inactive_checked="";
           $imagedescr =  "nohome";
           $imagestatus = '';
       }
       //debug($noimage);
       $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
    @endphp

    <section id="page-featured-image">
        <div class="container">
        @php  LP_Helper::getInstance()->getFunnelHeader($view);@endphp
        <!--Feature IMAGE-->
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="alert alert-danger" id="alert-danger" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Error:</strong>
                        <span></span>
                    </div>
                    <div id="delresmess"></div>
                </div>
            </div>
            <div class="lp-featured-image">
                <div class="featured-image-head">
                    <div class="row">
                        <div class="lp-custom-width">
                            <div class="col-md-7">
                                <div class="col-left"><h2 class="lp-heading-2">Featured Image</h2></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-center">
                                    <span class="fa fa-rotate-left"></span><span style="cursor: pointer;" onclick="activetodefaultimage()">RESET DEFAULT IMAGE</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-btn-toggle">
                                    <input id="activedeactivebtn" @php  echo $active_inactive_checked; @endphp data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="browse-image">
                            @php
                            $del_btn=true;
                            if($theimage == 'noimage') {
                                $del_btn=false;
                                echo "<br />No image uploaded.";
                            }else{
                            @endphp
                            <img id="currentdropimagelogo" src="{{ $theimage }}" onerror="disabledelbtn();" alt="Image not found" >
                            @php } @endphp
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-custom-btns">
                            <form id="fuploadload" name="fuploadload" enctype="multipart/form-data" action="{{ LP_BASE_URL.LP_PATH."/popadmin/uploadimage" }}" method="POST">
                                {{csrf_field()}}
                                @php
                                if($del_btn==true){
                                @endphp
                                <button type="button" class="btn btn-danger" id="delfeamed" name=""><strong>DELETE</strong></button>
                                @php } @endphp
                                <label class="btn btn-file">
                                    Browse <input type="file" name="logo" id="logo" style="display: none;" onclick="fileClicked(event)" onchange="fileChanged(event)">
                                </label>
                                <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
                                @php
                                //$_funnel_data=str_replace("'", "\'", json_encode(@$view->data->funnelData));
                                $_funnel_data=json_encode(@$view->data->funnelData,JSON_HEX_APOS);
                                @endphp
                                <input type="hidden" name="funneldata" id="funneldata" value='{{ $_funnel_data }}'>
                                <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                                <input name="theselectiontype" id="theselectiontype" value="imageedit" type="hidden">
                                <input name="imagestatus" id="imagestatus" value="{{ $imagestatus }}" type="hidden">
                                <input type="hidden" name="logo_source" id="logo_source" value="">
                                <input type="hidden" name="badimage" id="badlogo" value="{{ @$view->data->badupload }}">
                                <input type="hidden" name="firstkey" id="firstkey" value="{{ $firstkey }}">
                                <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $firstkey }}">
                                <input type="hidden" name="treecookie" id="treecookie" value="{{ $treecookie }}">
                                <input type="hidden" name="imageuploaded" id="imageuploaded" value="{{ @$view->data->imageuploaded }}">
                                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                                <input type="hidden" name="reset_defaultimg" id="reset_defaultimg" value="no">

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row save_row">
                <div class="col-md-12">
                    <div class="lp-save">
                        <div class="custom-btn-success">
                            <button type="button" onclick="uploadimage();"  class="btn btn-success"><strong>SAVE</strong></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <div class="modal fade add_recipient home_popup" id="resetfeaturedimg" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title">Reset Featured Image</h3>
                </div>
                <div class="modal-body model-action-body">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="popup-wrapper modal-action-msg-wrap">
                                    <div class="funnel-message modal-msg">Are you sure you want to reset featured image?</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-modal-footer footer-border">
                        <a data-dismiss="modal" class="btn lp-btn-cancel nmv">Close</a>
                        <input type="button" class="btn lp-btn-add" id="cancelfimgbtn" value ="Reset">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.watch_video_popup')
@endsection
