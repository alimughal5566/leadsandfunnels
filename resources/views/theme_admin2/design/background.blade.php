@extends("layouts.leadpops")

@section('content')
    @php
        if(isset($view->data->clickedkey) && $view->data->clickedkey != "") {
            $firstkey = $view->data->clickedkey;
        }else {
            $firstkey = "";
        }

        /* logo color */
        list($displaylogosrc, $logo_color) = explode('~~~',\View_Helper::getInstance()->getCurrentLogoImageSource(@$view->data->client_id,1,@$view->data->funnelData));

        if(@$logo_color!=''){
            list($r,$g,$b) = array_pad(explode('-',$logo_color),3,"");
        }

        if($displaylogosrc != "" and UR_exists($displaylogosrc)) {
            list($dlogowidth, $dlogoheight) = getimagesize($displaylogosrc);

            if($dlogowidth >= 350) {
                $dlogowidth = 350;
            }

            if($dlogoheight >= 130) {
                $dlogoheight = 130;
            }

            $dlogomargintop = round((131-$dlogoheight) / 2);
            $dlogomarginleft = round((351-$dlogowidth) / 2);

            if(!stristr($displaylogosrc,'/clients/')) {
                $dimensions = " width='350' height='130' ";
            }else {
                $dimensions = "";
                $dimensions = " width='350' height='130' ";
            }
        }

        /* Background image */
        $imagecss = @$view->data->backgroungOptions[0]["bgimage_properties"];

        list($background_size,$background_position,$background_repeat,$overlay_opacity) = array_pad(explode("~",$imagecss),4,"");
        list($pos_horizontal_value,$pos_vertical_value) = array_pad(explode(" ",$background_position),2,"");
        $background_size_horizontal=$background_size_vertical=$background_size_horizontal_unit=$background_size_horizontal_value=$background_size_vertical_unit=$background_size_vertical_value="";

        if (strpos($background_size," ") != false) {
            list($background_size_horizontal,$background_size_vertical) = explode(" ",$background_size);
            if (strpos($background_size_horizontal,"%") != false) {
                $background_size_horizontal_unit = "%";
                $background_size_horizontal_value = substr($background_size_horizontal, 0, -1);
            } else {
                $background_size_horizontal_unit = "px";
                $background_size_horizontal_value = substr($background_size_horizontal_value, 0, -2);
            }

            if (strpos($background_size_vertical,"%") != false) {
                $background_size_vertical_unit = "%";
                $background_size_vertical_value = substr($background_size_vertical, 0, -1);
            } else {
                $background_size_vertical_unit = "px";
                $background_size_vertical_value = substr($background_size_vertical_value, 0, -2);
            }
        }

        if (strpos($pos_horizontal_value,"%") != false) {
            $pos_horizontal_unit = "%";
            $pos_horizontal_value = substr($pos_horizontal_value, 0, -1);
        } else {
            $pos_horizontal_unit = "px";
            $pos_horizontal_value = substr($pos_horizontal_value, 0, -2);
        }

        if (strpos($pos_vertical_value,"%") != false) {
            $pos_vertical_unit = "%";
            $pos_vertical_value = substr($pos_vertical_value, 0, -1);
        } else {
            $pos_vertical_unit = "px";
            $pos_vertical_value = substr($pos_vertical_value, 0, -2);
        }

        $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
        $active_inac_flag=@$view->data->backgroungOptions[0]['active_backgroundimage'];
        $background_type_vale=@$view->data->backgroungOptions[0]['background_type'];
    @endphp

    <section id="leadpopovery">
        <div id="overlay">
            <i class="fa fa-spinner fa-spin spin-big"></i>
        </div>
    </section>
    <section id="page-background">
        <input type="hidden" name="background_type_vale" id="background_type_vale"
               value="@php echo $background_type_vale;@endphp">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="alert alert-success" id="success-alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Success:</strong>
                        <span>Background Color has been saved.</span>
                    </div>
                    <div class="alert alert-danger" id="alert-danger" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Error:</strong>
                        <span></span>
                    </div>

                </div>
            </div>

            @php
                LP_Helper::getInstance()->getFunnelHeader($view);
            @endphp
            <form role="form" class="form-horizontal" method="post" action="#">
                {{csrf_field()}}
                <input type="hidden" name="swatchnumber" id="swatchnumber" value="">
                <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
                <input type="hidden" name="client_logo" id="client_logo" value="{{ @$view->data->clientLogo }}">
                <input type="hidden" name="generate_logo" id="generate_logo" value="{{ @$view->data->generateLogo }}">
                <input type="hidden" name="r" id="r" value="{{ $r }}">
                <input type="hidden" name="g" id="g" value="{{ $g }}">
                <input type="hidden" name="b" id="b" value="{{ $b }}">
                <input type="hidden" name="firstkey" id="firstkey" value="{{ $firstkey }}">
                <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $firstkey }}">
                <input type="hidden" name="treecookie" id="treecookie" value="{{ $treecookie }}">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="background_type" id="background_type" value="1">
            </form>
            <div class="row" id="active-inactive_info" data-activeinacflag='{{ $active_inac_flag }}'></div>
            <div class="row" id="bg-image-data-info" data-background-size='{{ $background_size }}'
                 data-background-position='{{ $background_position }}'
                 data-background-repeat='{{ $background_repeat }}'
                 data-pos-horizontal-unit='{{ $pos_horizontal_unit }}'
                 data-pos-horizontal-value='{{ $pos_horizontal_value }}'
                 data-pos-vertical-unit='{{ $pos_vertical_unit }}'
                 data-pos-vertical-value='{{ $pos_vertical_value }}'
                 data-background-size-horizontal-unit='{{ $background_size_horizontal_unit }}'
                 data-background-size-horizontal-value='{{ $background_size_horizontal_value }}'
                 data-background-size-vertical-unit='{{ $background_size_vertical_unit }}'
                 data-background-size-vertical-value='{{ $background_size_vertical_value }}'></div>
            <div style="display: none;  z-index: 5000; width: 200px; height: 130px; position: absolute; left: -331px; top: 109px">
                <textarea rows="5" id="the-gradient" class="gradient-result"></textarea>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger hide" id="error-alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Error:</strong> <span></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default custom-accordion first">
                            <div class="panel-heading">
                                <div class="lp-domain-wrapper">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h4 class="panel-title">
                                                <a id="bkinactive"
                                                   class="collapse-bg-img"
                                                   data-lpkeys="{{ @$view->data->lpkeys.'~active_backgroundimage' }}"
                                                   data-bkactive="n" data-targetele="pulllogocolor"
                                                   data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                    <i class="lp_radio_icon_lg"></i> Automatically Pull <b> Logo Colors</b>
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse ">
                                <div class="panel-body lp-padding">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="ics-gradient-editor-1-div">
                                                <div class="gradient" id="ics-gradient-editor-1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default custom-accordion">
                            <div class="panel-heading">
                                <div class="lp-domain-wrapper">
                                    <h4 class="panel-title">
                                        <a id="bkactive"
                                           class="collapse-bg-img"
                                           data-lpkeys="{{ @$view->data->lpkeys.'~active_backgroundimage' }}"
                                           data-bkactive="y" data-targetele="backgroundimage" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapse3">
                                            <i class="lp_radio_icon_lg"></i> Upload a <b>Background Image</b>
                                        </a>
                                        <div class="lp-tooltip">
                                            <img src="{{ LP_ASSETS_PATH }}/adminimages/ttip.png" alt="">
                                            <span class="lp-tooltiptext">Suggested background "Cover" image dimensions:<br> 1920 width x 1080 height.<br> Recommended size: smaller than 2 MB.<br> Use this free service: <a
                                                        class="lp-tp-btn" href="http://www.TinyPNG.com" target="_blank"> www.TinyPNG.com </a> to compress<br> images prior to upload to reduce load time.</span>
                                        </div>

                                        <div class="col-right">
                                            <div class="custom-btn-toggle"></div>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse">
                                <div class="panel-body lp-padding">
                                    <div class="row">
                                        <hr class="lp-divider">
                                        <form id="updatebackgroundimage" class="form-horizontal" role="form"
                                              style="margin-top:10px;" enctype="multipart/form-data"
                                              action="{{ LP_BASE_URL.LP_PATH."/popadmin/updatebackgroundimage/".@$view->data->currenthash }}"
                                              method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" name="background_type" id="background_type" value="3">

                                            <div class="col-md-6">

                                                <div class="lp-background-img" id="previewbox">
                                                    <div id="preview-overlay" class="bg-image img-responsive">
                                                    </div>
                                                    <div id="bg-img-action-btn" class="logo-remove-btn">
                                                        <div>
                                                            <button class="btn-success lp-success-color" id="bg-img-change">Change</button>
                                                            <button class="btn-danger lp-danger-color" id="bg-img-remove">Remove</button>
                                                        </div>
                                                    </div>
                                                    <div class="logo-upload-wrap" id="logouploadwrap">
                                                        <label class="btn btn-file" id="bd-img-browse">
                                                            Choose Image <input type="file" class="" accept="image/*" onclick="fileClicked(event)" onchange="fileChanged(event)"
                                                                                name="background_name"
                                                                                id="background_name"
                                                                                placeholder="Image File"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="bg-option-image-url" name="bg-option-image-url" value="{{ @$view->data->backgroungOptions[0]["bgimage_url"] }}">
                                            <input type="hidden" id="image-url" name="image-url" class="image-url" value="{{ @$view->data->backgroungOptions[0]["bgimage_url"] }}">
                                            <input type="hidden" id="background-overlay" name="background-overlay" value="{{ @$view->data->backgroungOptions[0]["background_overlay"] }}">
                                            <input type="hidden" id="client_id" name="client_id" value="{{ @$view->data->client_id }}">
                                            @php
                                                $_funnel_data = json_encode($view->data->funnelData, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS);
                                            @endphp
                                            <input type="hidden" name="funneldata" id="funneldata" value='{{ $_funnel_data }}'>
                                            <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                                            <div class="col-md-6">
                                                <div class="lp-background-customize">
                                                    <div class="form-group lp-custom-div">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <label class="control-label custom-label ">Background Overlay Color</label>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <div id="colorSelector" class="colorSelector col-sm-7"
                                                                     style="{{ (@$view->data->backgroungOptions[0]['background_overlay']!="") ? "background-color:".@$view->data->backgroungOptions[0]['background_overlay'] : "\"background-color:\"#FFFFFF" }}"></div>
                                                                <div class="custom-btn-toggle">
                                                                    @php
                                                                    $checked="";
                                                                    if(@$view->data->backgroungOptions[0]['active_overlay']=='y'){
                                                                        $checked="checked";
                                                                    }
                                                                    @endphp
                                                                    <input id="overlay_active_btn"
                                                                           class="bgimg-overlay-btn"
                                                                           data-lpkeys="{{ @$view->data->lpkeys.'~active_overlay' }}"
                                                                           {{ $checked }} data-toggle="toggle"
                                                                           data-onstyle="success" data-offstyle="danger"
                                                                           data-width="100" data-on="INACTIVE"
                                                                           data-off="ACTIVE" type="checkbox">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group lp-custom-div lp-opacity">
                                                        <div class="row ">
                                                            <div class="col-sm-5">
                                                                <label class="control-label tooltip-label">Overlay Color Opacity</label>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <input id="ex1" data-slider-id='ex1Slider' type="text"/>
                                                                <input type="hidden" id="overlay_color_opacity"
                                                                       name="overlay_color_opacity"
                                                                       value="{{ (@$view->data->backgroungOptions[0]['background_overlay_opacity']!="") ? @$view->data->backgroungOptions[0]['background_overlay_opacity'] : 20 }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group lp-custom-div">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <label class="control-label custom-label ">Background
                                                                    Repeat</label>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <select class="lp-select2 select-width" id="background-repeat" name="background-repeat">
                                                                    <option value="no-repeat" selected>No Repeat</option>
                                                                    <option value="repeat">Repeat</option>
                                                                    <option value="repeat-x">Repeat-X</option>
                                                                    <option value="repeat-y">Repeat-Y</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group lp-custom-div">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <label class="control-label custom-label">Background Position</label>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <select class="lp-select2 select-width" id="background-position" name="background-position">
                                                                    <option value="center center" selected>Center Center</option>
                                                                    <option value="center left">Center Left</option>
                                                                    <option value="center right">Center Right</option>
                                                                    <option value="top center">Top Center</option>
                                                                    <option value="top left">Top Left</option>
                                                                    <option value="top right">Top Right</option>
                                                                    <option value="bottom center">Bottom Center</option>
                                                                    <option value="bottom left">Bottom Left</option>
                                                                    <option value="bottom right">Bottom Right</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group lp-custom-div">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <label class="control-label custom-label">Background Size</label>
                                                            </div>

                                                            <div class="col-sm-7">
                                                                <input type="hidden" id="backgroundsize" name="backgroundsize" value="{{ ($background_size) ? $background_size : '' }}">
                                                                <select class="lp-select2 select-width" id="background_size" name="background_size">
                                                                    <option value="cover" selected>Cover</option>
                                                                    <option value="contain">Contain</option>
                                                                    <option value="auto">Default</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="lp-save">
                        <div class="custom-btn-success">
                            <button type="button" class="btn btn-success" id="bgimgapply"><strong>SAVE</strong></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    @include('partials.watch_video_popup')
@endsection
