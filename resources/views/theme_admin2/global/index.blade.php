@extends("layouts.leadpops")

@section('content')
@php

    use Illuminate\Support\Facades\Session;
    use App\Constants\LP_Constants;
    /** TOTAL EXPERT SESSION **/
    $hasTotalExpert = LP_Helper::getInstance()->getTotalExpertInfo();
    $teHasActivated = "no"; // default not authorized
    $teCurrentStatus = "inactive"; // status in DB
    $active_inactive_checked = ""; // UI default no
    if (!empty($hasTotalExpert)) { // has authorized
        if ($hasTotalExpert[0]["active"] == 1) {
            $teHasActivated = "yes";
            $teCurrentStatus = "active";
            $active_inactive_checked = "checked='checked'";
        }
    }
    // save hash in session to compare with redirect_uri from total expert @ popadminController.totalexpertAction
    //$_SESSION["totalExpertHash"] = "global-settings";
    Session::put('totalExpertHash', "global-settings");
    // $_SESSION returns are:  session mismatch, no token, ok
    /** END - TOTAL EXPERT SESSION **/

    $total_keys=0;
      //$clientdomainslist = $this->getClientDomainsList($this->data->client_id);
    /* Background image */
    $imagecss = @$view->data->backgroungOptions[0]["bgimage_properties"];
     //debug($this->data->globalOptions);
    //debug($imagecss);
    list($background_size,$background_position,$background_repeat,$overlay_opacity) = array_pad(explode("~",$imagecss),4,"");
    list($pos_horizontal_value,$pos_vertical_value) = array_pad(explode(" ",$background_position),2,"");
    $background_size_horizontal=$background_size_vertical=$background_size_horizontal_unit=$background_size_horizontal_value=$background_size_vertical_unit=$background_size_vertical_value="";


    if (strpos($background_size," ") != false) {
        list($background_size_horizontal,$background_size_vertical) = explode(" ",$background_size);
          if (strpos($background_size_horizontal,"%") != false) {
            $background_size_horizontal_unit = "%";
            $background_size_horizontal_value = substr($background_size_horizontal, 0, -1);
          }else {
            $background_size_horizontal_unit = "px";
            $background_size_horizontal_value = substr($background_size_horizontal_value, 0, -2);
          }

          if (strpos($background_size_vertical,"%") != false) {
            $background_size_vertical_unit = "%";
            $background_size_vertical_value = substr($background_size_vertical, 0, -1);
          }else {
            $background_size_vertical_unit = "px";
            $background_size_vertical_value = substr($background_size_vertical_value, 0, -2);
          }
      }



      if (strpos($pos_horizontal_value,"%") != false) {
        $pos_horizontal_unit = "%";
        $pos_horizontal_value = substr($pos_horizontal_value, 0, -1);
      }else {
        $pos_horizontal_unit = "px";
        $pos_horizontal_value = substr($pos_horizontal_value, 0, -2);
      }

      if (strpos($pos_vertical_value,"%") != false) {
        $pos_vertical_unit = "%";
        $pos_vertical_value = substr($pos_vertical_value, 0, -1);
      }else {
        $pos_vertical_unit = "px";
        $pos_vertical_value = substr($pos_vertical_value, 0, -2);
      }
    $active_inac_flag=@$view->data->globalOptions['bk_image_active'];
    $client_products = LP_Helper::getInstance()->getClientProducts();
    //debug($client_products[LP_Constants::PRODUCT_FUNNEL]);

@endphp
{{-- For froala editor --}}
{{-- Saif --}}
<style>
    #textwrapper .fr-box.fr-basic .fr-element,#advance-footer .fr-element{
        padding: 40px 10px 11px 10px;
        min-height: 250px;
        overflow-x: inherit;
        min-height: 250px;
    }
    .bombbombwrapper {
        display: inline-block;
        width: 80px;
        vertical-align: top;
        margin-top: 8px;
        margin-left: 10px;
        cursor: pointer;
    }
    .bombomb_desc {
        display: none;
        position: absolute;
        white-space: normal;
        line-height: 1.2;
        font-size: 10px;
        width: 200px;
        box-shadow: 1px 1px 1px #ccc;
        padding: 5px 10px;
        border: 1px solid #ccc;
        right: 0;
        top: 33px;
        background-color: #fff;
        z-index: 100;
    }
    .lp-contact-review .lp-contact-review__img .fr-fic.fr-dii {
        float: left;
        width: 85px;
        border: 3px solid @php echo @$view->data->globalOptions["logo_color"]; @endphp;
        border-radius: 100px;
        margin-top: -8px;
        min-height: 85px;
        margin-right: 24px;
        height: auto;
        object-fit: cover;
        line-height: 0;
        display: block;
    }
    .lp-contact-review .info {
        float: left;
        text-align: left;
    }
    #hide-other input[type="checkbox"] + label span {
        display: inline-block;
        width: 26px;
        height: 27px;
        margin: 0 0 0 15px;
        vertical-align: middle;
        background: url(/lp_assets/adminimages/checkbox.png) left top no-repeat;
        cursor: pointer;
    }

    .lp-contact-review .info p {
        font-family: "Open Sans";
        font-size: 13px;
        color: #6f6e6e;
        line-height: 15px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .fr-wrapper .rating-wrapper {
        position: relative;
        float: left;
        display: inline-block;
        width: 17px;
        height: 14px
    }
    .fr-wrapper .rating-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        height: 14px;
        /*background: url(../../../../../../../../lp_assets/adminimages/stars1.1.png) no-repeat;*/
        margin: 0 auto;
    }
    .fr-view .secure-template-title strong {
        display: inline-block;
    }

    .co_branded .lp-contact-review {
        margin-top: 10px;
        padding: 0 40px;
        display: inline-block;
    }

    .co_branded {
        padding: 10px 0;
    }
    .box__counter {
        border: 2px solid @php echo @$view->data->globalOptions["logo_color"]; @endphp;
    }
    .animate-container .fifth.desktop::after {
        border-bottom: 16px solid @php echo @$view->data->globalOptions["logo_color"]; @endphp;
    }
    .animate-container .fifth.desktop {
        background-color: @php echo @$view->data->globalOptions["logo_color"]; @endphp;
    }
</style>
<input type="hidden" name="templatetype" id="templatetype" value="">
<input type="hidden" name="logocolor" id="logocolor"  value="@php echo @$view->data->globalOptions['logo_color']; @endphp">
<section id="leadpopovery">
    <div id="overlay">
        <i class="fa fa-spinner fa-spin spin-big"></i>
    </div>
</section>
<div id="global-section" class="global-section">
	<div class="container">
        <div class="row">
            <div class="col-md-12">
                <br>
                <div class="alert alert-danger" id="alert-danger" style="display: none;">
                    <button type="button" class="close" >x</button>
                    <strong>Error:</strong>
                    <span> </span>
                </div>
        		<div class="alert alert-success" id="success-alert" style="display: none;">
        			<button type="button" class="close" data-dismiss="alert">x</button>
        			<strong>Success:</strong>
        			<span>Settings has been saved.</span>
        		</div>
            </div>
        </div>
		<div class="row" id="bg-image-data-info"  data-background-size='{{ $background_size }} ' data-background-position='{{ $background_position }}' data-background-repeat='{{ $background_repeat }}' data-pos-horizontal-unit='{{ $pos_horizontal_unit }}' data-pos-horizontal-value='{{ $pos_horizontal_value }}' data-pos-vertical-unit='{{ $pos_vertical_unit }}' data-pos-vertical-value='{{ $pos_vertical_value }}' data-background-size-horizontal-unit='{{ $background_size_horizontal_unit }}' data-background-size-horizontal-value='{{ $background_size_horizontal_value }}' data-background-size-vertical-unit='{{ $background_size_vertical_unit }}' data-background-size-vertical-value='{{ $background_size_vertical_value }}' ></div>
		<input type="hidden" name="data-background-swatches" id="data-background-swatches" value='{{ @$view->data->globalOptions['swatches'] }}'>
		<div class="global-links">
			<div class="row">
				<div class="col-md-5">
					<div class="btn-wrapper">
						<div id="gie-btn" class="custom-btn-toggle inc-toggle">
							<input checked data-toggle="toggle" class="responder-toggle is_include" data-onstyle="success" data-offstyle="danger" for="is_include" data-field = 'is_include' data-width="100" data-on="EXCLUDE" data-off="INCLUDE" type="checkbox">
							<!--<input type="checkbox" checked data-toggle="toggle" class="responder-toggle is_include" for="is_include" data-field = 'is_include' data-on="EXCLUDE" data-off="INCLUDE" data-style = 'is_include' data-width = '100'>-->
						</div>
						<div class="pop-up-funnel">
							<a href="#" data-toggle="modal" data-target="#funnel-selector" ><i class="fa fa-cog"></i>&nbsp;Select Funnels </a>
						</div>
					</div>
				</div>
                <input type="hidden"  name="selectedfunnel" id="selectedfunnel">
				<div class="col-md-7">
					<div class="glo-links">
					 <ul>
                             <li class="@if(@$view->data->maintab=='design') {{ 'gl_active' }} @endif " ><a class="gsmainmenu link " data-id="design" href="#">Design</a></li>

                         <li class="@if(@$view->data->maintab=='content') {{  'gl_active' }} @endif"><a class="gsmainmenu " data-id="content" href="#">Content</a></li>
                         <li class="@if(@$view->data->maintab=='integration-pixels') {{  'gl_active' }} @endif"><a class="gsmainmenu " data-id="integration-pixels" href="#">Settings</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
        <img src="" id="temporary_image" name="temporary_image" style="display:none;">
    <!--  DESIGN-->
    <div id="gl-design" class="global-items  @if(@$view->data->action=='logo' || @$view->data->action=='background' || @$view->data->action=='featured-image' ) {{ 'item-active'  }}@endif">
        <div class="sub-tab-section design">
            <ul class="nav nav-tabs">
                <li class="@if(@$view->data->action=='logo') {{ 'active' }} @endif"><a data-toggle="tab" href="#logo">LOGO</a></li>
                <li class="@if(@$view->data->action=='background')  {{ 'active' }} @endif"><a   data-toggle="tab" href="#background">BACKGROUND</a></li>
                <li class="@if(@$view->data->action=='featured-image') {{ 'active' }} @endif"><a  data-toggle="tab" href="#featured-image">FEATURED IMAGE</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div id="logo" class="tab-pane fade  @if(@$view->data->action=='logo') {{ 'active in' }} @endif">
                <form class="form-inline" id="uploadgloballogo" enctype="multipart/form-data" action="{{ LP_BASE_URL.LP_PATH.'/global/uploadgloballogo' }}" method="post">
                               {{ csrf_field() }}
                    <input type="hidden" name="swatches" id="swatches" value="">
                    <input type="hidden" name="logosavetype" id="logosavetype" value="uploadlogo">

                    <input type="hidden" name="key" id="key" value="">
                    <input type="hidden" name="image_url" id="image_url" value="">
                    <input type="hidden" name="scope" id="scope" value="">
                    <input type="hidden" name="logocnt" id="logocnt" value="">
                    <input type="hidden" name="theselectiontype" id="theselectiontype" value="logo">

                    <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
                    <input type="hidden" name="logo" id="logo" value="{{ @$view->data->globalOptions['logo'] }}">
                    <input type="hidden" name="logo_path" id="logo_path" value="{{ @$view->data->globalOptions['logo_path'] }}">
                    <input type="hidden" name="logo_color" id="logo_color" value="{{ @$view->data->globalOptions['logo_color'] }}">
                    <input type="hidden" name="logo_source" id="logo_source" value="client">
                    <input type="hidden" name="stocklogopath" id="stocklogopath" value="{{ @$view->data->globalOptions['logo_path'] }}">
                    <input type="hidden" name="logo_id" id="logo_id" value="">
                    @if (@$view->data->client_id == 1348)
                        <input type="hidden" name="bgimage_active" id="bgimage_active" value="">
                    <input type="hidden" name="keepbgimage" id="keepbgimage" value="">
                    @endif
                    <input type="hidden" name="badlogo" id="badlogo" value="">
                    <input type="hidden" name="logouploaded" id="logouploaded" value="">
                    <input type="hidden" name="globalswatches" id="globalswatches" value="">
                    <input type="hidden" name="useme_logo" id="useme_logo" value="y">
                    <input type="hidden" name="usedefault_logo" id="usedefault_logo" value="n">
                    <input type="hidden" name="lpkey_logo" id="lpkey_logo" value="">
                    <input type="hidden" name="temp_logo" id="temp_logo" value="">

                    <div id="lp-global-logo" class="inner-page-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="lp-default-logo" id="droppable-photos-container-logo">
                                    <div class="col-left-logo">
                                        <h2 class="lp-heading-logo">Current Logo</h2>
                                    </div>
                                    <div class="logo-default-img">
                                        <span class="helper"></span>
                                        @php
                                            $logo_arr=[];
                                            if(@$view->data->globalOptions['logo1'])
                                                $logo_arr[]=array('src' =>@$view->data->globalOptions['logo1'],"id"=>"logo1");
                                            if(@$view->data->globalOptions['logo2'])
                                                $logo_arr[]=array('src' =>@$view->data->globalOptions['logo2'],"id"=>"logo2");
                                            if(@$view->data->globalOptions['logo3'])
                                                $logo_arr[]=array('src' =>@$view->data->globalOptions['logo3'],"id"=>"logo3");
                                            $logocnt=count($logo_arr);

                                        @endphp
                                            @if(@$view->data->globalOptions['logo_url']!='')
                                                <img id="currentdropimagelogo" alt="" class="abc" src="@if(@$view->data->globalOptions['logo_url']!=""){{  @$view->data->globalOptions['logo_url'] }} @endif" >
                                        @endif
                                    </div>
                                    <div class="note">Click and drag the logo of your choice from below into this box</div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-logo">
                            <div class="logooverlay text-center"></div>
                            <div class="lp-upload-logo">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-left">
                                            <h2>Upload Logos</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-6" >
                                        <div class="col-right" id="logouploadwrap">
                                            <span id="logonamesel"></span>
                                            <label class="btn btn-file">
                                                Browse <input type="file" name="globallogo" accept="image/*" id="globallogo" style="display: none;">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="logo-main-wrapper">

                                <div class="row">

                                     <input type="hidden" name="globallogocnt" id="globallogocnt" value="{{ $logocnt }}">


                                    @if($logocnt == 0 )
                                        <div class="bluetextheadleft">
                                             <br />
                                          To upload a logo:<br /><br />
                                          1. Click "Browse" to select your logo, then click "Upload."<br /><br />
                                          2. Next, simply drag and drop your logo into the box that <br />
                                          says "Current Logo", then click "Save New Logo."<br />
                                        </div>
                                    @else
                                        @for($i=0; $i<$logocnt; $i++)
                                            <div class="col-md-4" >
                                                <div class="sub-logo-wrapper">
                                                <div id="droppablePhotosLogo" style=" zoom:1;">
                                                    <div class="upload-logo-left droppable-gallery-logo">
                                                        <div class="left img-content-logo" id="lp-cur-logo-{{ $i }}" >
                                                            <div class="logo-wrapper logo-wrapper-margin">
                                                                <span class="helper"></span>
                                                                <img rel="client" class="logo-img1 logodes" data-swatches="" id="{{ $logo_arr[$i]['id'] }}" src="{{ $logo_arr[$i]['src'] }}" alt="Image File not found">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center" id="glogowrap" >
                                                    <button onclick="javascript: return false;"  data-toggle="modal" id="lp-cur-logo-del{{ $i }}" type="button" class="btn btn-danger globallogo" data-logoid="{{ $logo_arr[$i]['id'] }}"  ><strong>DELETE</strong></button>
                                                </div>
                                                </div>
                                            </div>
                                       @endfor
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="lp-save">
                            <div class="custom-btn-success">
                                <buton type="button" class="btn btn-success submit" id="savelogo" onclick="savegloballogo(event,this)">Save</buton>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="background" class="tab-pane fade @if(@$view->data->action=='background') {{ 'active in' }} @endif">
                <div style="display: none;  z-index: 5000; width: 200px; height: 130px; position: absolute; left: -331px; top: 109px">
                    <textarea rows="5" id="the-gradient" class="gradient-result"></textarea>
                    <div id="active-inactive_info" data-activeinacflag='{{ $active_inac_flag }}'></div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion">
                        <div class="panel panel-default custom-accordion">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="lp-domain-wrapper">
                                            <h4 class="panel-title">
                                                <a id="bkinactive" class="collapse-bg-img" data-targetele="pulllogocolor" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                    <i class="lp_radio_icon_lg"></i> Automatically Pull <b> Logo Colors</b>
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body lp-padding">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="ics-gradient-editor-1-div" >
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
                                        <a id="bkactive" class="collapse-bg-img " data-targetele="backgroundimage" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                            <i class="lp_radio_icon_lg"></i> Upload a <b>Background Image</b>
                                        </a>
                                        <div class="lp-tooltip">
                                            <img src="{{ LP_ASSETS_PATH }}/adminimages/ttip.png" alt="">
                                            <span class="lp-tooltiptext">Suggested background "Cover" image dimensions:<br> 1920 width x 1080 height.<br> Recommended size: smaller than 2 MB.<br> Use this free service: <a class="lp-tp-btn" href="http://www.TinyPNG.com" target="_blank"> www.TinyPNG.com </a> to compress<br> images prior to upload to reduce load time.</span>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse">
                                <div class="panel-body lp-padding">
                                    <div class="row">
                                        <hr class="lp-divider">
                                        <form id="updateglobalbackgroundimage" class="form-horizontal" role="form" style="margin-top:10px;" enctype="multipart/form-data" action="{{ LP_BASE_URL.LP_PATH."/global/updateglobalbackgroundimage" }}" method="post">
                                           {{ csrf_field() }}
                                            <div class="col-md-6">
                                                <input type="hidden" id="bg-option-image-url" name="bg-option-image-url" value="@if((@$view->data->backgroungOptions[0]['bgimage_url']) && @$view->data->backgroungOptions[0]['bgimage_url']!="") {{ @$view->data->backgroungOptions[0]['bgimage_url'] }} @endif">
                                                <div class="lp-background-img" id="previewbox"  >
                                                    <div id="preview-overlay"></div>
                                                    <div id="bg-img-action-btn" class="logo-remove-btn">
                                                        <div>
                                                            <button class="btn-success lp-success-color"  id="bg-img-change">Change</button>
                                                            <button class="btn-danger lp-danger-color" id="bg-img-remove">Remove</button>
                                                        </div>
                                                    </div>
                                                    <div class="logo-upload-wrap" id="logouploadwrap">
                                                        <label class="btn btn-file" id="bd-img-browse">
                                                            Choose Image <input type="file" onclick="fileClicked(event)" onchange="fileChanged(event)" class="" name="background_name" id="background_name" accept="image/*" placeholder="Image File"/>
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                            <input type="hidden" name="lpkey_backgroundcolor" id="lpkey_backgroundcolor" value="">
                                            <input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">
                                            <div id="colordiv" name="gradient" class="image-wrapp previewDiv"></div>
                                            <input type="hidden" id="background-type" name="background-type" class="background-type" value="bgimage">
                                            <input type="hidden" id="bg-option-image-url" name="bg-option-image-url" value="">
                                            <input type="hidden" id="client_id" name="client_id" value="{{ @$view->data->client_id }}">
                                            <input type="hidden" id="image-url" name="image-url" class="image-url" value="@if((@$view->data->backgroungOptions[0]['bgimage_url']) && @$view->data->backgroungOptions[0]['bgimage_url']!="") {{  @$view->data->backgroungOptions[0]['bgimage_url']  }} @endif">
                                            <input type="hidden" id="active-overlay" name="active-overlay" value="@if((@$view->data->backgroungOptions[0]["active_overlay"]) && @$view->data->backgroungOptions[0]["active_overlay"]) {{ @$view->data->backgroungOptions[0]["active_overlay"]}} @else {{  "n"  }} @endif">
                                            <input type="hidden" id="background-overlay" name="background-overlay" value="@if((@$view->data->backgroungOptions[0]["background_overlay"]) && @$view->data->backgroungOptions[0]["background_overlay"]!="") {{ @$view->data->backgroungOptions[0]["background_overlay"] }} @endif ">
                                            <input type="hidden" id="background-size" name="background-size" value="">
                                            <input type="hidden" name="background_type" id="background_type" value="3">

                                            <input type="hidden" name="lpkey_backgroundimage" id="lpkey_backgroundimage" value="">
                                            <div class="col-md-6">
                                                <div class="lp-background-customize">
                                                    <div class="form-group lp-custom-div">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <label class="control-label custom-label ">Background Overlay color</label>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <div id="colorSelector" class="colorSelector col-sm-7"  style="{{ ((@$view->data->backgroungOptions[0]['background_overlay']) && @$view->data->backgroungOptions[0]['background_overlay']!="") ? "background-color:".@$view->data->backgroungOptions[0]['background_overlay'] : "\"background-color:\"#FFFFFF" }}"></div>
                                                                <div class="custom-btn-toggle">
                                                                    @php
                                                                        $checked="";
                                                                        if((@$view->data->backgroungOptions[0]["active_overlay"]) && @$view->data->backgroungOptions[0]["active_overlay"]=='y'){
                                                                            $checked="checked";
                                                                        }
                                                                     @endphp
                                                                     <input id="overlay_active_btn"  class="bgimg-overlay-btn" data-lpkeys="{{ @$view->data->lpkeys.'~active_overlay' }}"  {{ $checked }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group lp-custom-div lp-opacity" >
                                                        <div class="row ">
                                                            <div class="col-sm-5">
                                                                <label class="control-label tooltip-label">Overlay Color Opacity</label>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <input id="ex1" data-slider-id='ex1Slider' type="text"/>
                                                                @php
                                                                if($overlay_opacity!=""){
                                                                    $overlay_opacity==$overlay_opacity;
                                                                }else
                                                                    {
                                                                        $overlay_opacity=20;
                                                                    }

                                                                    @endphp
                                                                <input type="hidden" id="overlay_color_opacity" name="overlay_color_opacity" value="{{ $overlay_opacity }} ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group lp-custom-div">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <label class="control-label custom-label ">Background Repeat</label>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <select class="lp-select2 select-width" id="background-repeat" name="background-repeat">
                                                                    <option value="no-repeat" selected>No Repeat</option>
                                                                    <option value="repeat" >Repeat</option>
                                                                    <option value="repeat-x" >Repeat-X</option>
                                                                    <option value="repeat-y" >Repeat-Y</option>
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
                                                                    <option value="center left" >Center Left</option>
                                                                    <option value="center right" >Center Right</option>
                                                                    <option value="top center" >Top Center</option>
                                                                    <option value="top left" >Top Left</option>
                                                                    <option value="top right" >Top Right</option>
                                                                    <option value="bottom center" >Bottom Center</option>
                                                                    <option value="bottom left" >Bottom Left</option>
                                                                    <option value="bottom right" >Bottom Right</option>
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
                                                                    <option value="contain" >Contain</option>
                                                                    <option value="auto" >Default</option>
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
            </div>
            <div id="featured-image" class="tab-pane fade @if(@$view->data->action=='featured-image') {{ 'active in' }} @endif">
                <form id="uploadglobalimage" name="uploadglobalimage" enctype="multipart/form-data" action="{{ LP_BASE_URL.LP_PATH."/global/uploadglobalimage" }}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="image" id="image" value="{{ @$view->data->globalOptions['image'] }}">
                    <input type="hidden" name="image_path" id="image_path" value="{{ @$view->data->globalOptions['image_path'] }}">
                    <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
                    <input type="hidden" name="use_me" id="use_me" value="y">
                    <input type="hidden" name="use_default" id="use_default" value="n">
                    <input type="hidden" name="lpkey_image" id="lpkey_image" value="">
                    <input type="hidden" name="reset_defaultimg" id="reset_defaultimg" value="no">
                    <div class="inner-page-body">
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
                                               @php
                                                    $checked="checked";
                                                    if(@$view->data->globalOptions['gf_image_active']=="n") $checked="";
                                               @endphp
                                                <input id="gf_image_active" name="gf_image_active"  {{  $checked }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="browse-image">
                                       @if(@$view->data->globalOptions['image_url'] == '')
                                            <img id="globalfeaturedimage" class="hide">
                                            @else
                                                <img id="globalfeaturedimage" src="{{ @$view->data->globalOptions['image_url'] }}">
                                            @endif
                                     </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="lp-custom-btns">
                                            <button type="button" class="btn btn-danger @if(@$view->data->globalOptions['image_url'] == '') {{ "hide" }} @endif" id="delfeamed" name=""><strong>DELETE</strong></button>
                                            <label class="btn btn-file">
                                                Browse <input type="file" onclick="fileClicked(event)" onchange="fileChanged(event)" name="globalfeaturedlogo" id="globalfeaturedlogo" accept="image/*" style="display: none;">
                                            </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row save_row">
                            <div class="col-md-12">
                                <div class="lp-save">
                                    <div class="custom-btn-success">
                                        <button type="button" onclick="uploadimageglobalfeatured();"  class="btn btn-success"><strong>SAVE</strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <!--CONTENT-->
	<div id="gl-content" class="global-items @if(@$view->data->action=='autoresponder' || @$view->data->action=='contactinfo' || @$view->data->action=='cta' || @$view->data->action=='thankyou' || @$view->data->action=='seo' || @$view->data->action=='footer') {{ 'item-active' }} @endif">
		<div class="sub-tab-section content">
			<ul class="nav nav-tabs">
                <li class="@if(@$view->data->action=='cta') {{ 'active' }} @endif"><a  data-toggle="tab" href="#cta">CTA</a></li>
				<li class="@if(@$view->data->action=='footer') {{  'active' }} @endif"><a  data-toggle="tab" href="#footer-tab">FOOTER</a></li>
                <li class="@if(@$view->data->action=='autoresponder') {{ 'active' }} @endif"><a  data-toggle="tab" href="#auto-responder">AUTO RESPONDER</a></li>
				<li class="@if(@$view->data->action=='seo')  {{ 'active' }} @endif"><a  data-toggle="tab" href="#seo">SEO</a></li>
                <li class="@if(@$view->data->action=='contactinfo') {{ 'active' }} @endif"><a  data-toggle="tab" href="#contact-info">CONTACT INFO</a></li>
				<li class="@if(@$view->data->action=='thankyou') {{ 'active' }} @endif"><a  data-toggle="tab" href="#thankyou">THANK YOU</a></li>
			</ul>
		</div>
		<div class="tab-content">
            <div id="cta" class="tab-pane fade @if(@$view->data->action=='cta') {{ ' in active' }} @endif">
                <form name="maincontent" id="maincontent" class="form-inline" method="POST" action="{{ LP_BASE_URL.LP_PATH.'/global/saveglobalmaincontent' }}">
                    {{csrf_field()}}
                    <input type="hidden" name="savestyle" id="savestyle" value="">
                    <input type="hidden" name="contenttype" id="contenttype" value="">
                    <input type="hidden" name="mlineheight" id="mlineheight" value="">
                    <input type="hidden" name="dlineheight" id="dlineheight" value="">
                    <input type="hidden" name="lpkey_maincontent" id="lpkey_maincontent" value="">
                    <input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">
                    <div class="lp-cta global-space">
                        <div class="lp-cta-head">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="col-left"><h2 class="lp-heading-2">Main Message</h2></div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-input-area">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-left">
                                        <label for="" class="control-label cta-font-label">
                                            Font Type
                                        </label>
                                        <select class="lp-select2-with-custom-optclass cta-font-type" data-width="220px" name="mthefont" id="mthefont" onchange="changefont('mthefont',this.value)">
                                            @foreach (@$view->data->fontfamilies as $font)
                                                @php
                                                $cfont = str_replace(" ", "_", strtolower($font));
                                            @endphp
                                                <option class="{{ $cfont }}" value='{{ $font }}' {{ ((@$view->data->fontfamily) && @$view->data->fontfamily==$font?'selected="selected"':'') }}>{{ $font }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-center">
                                        <label for="" class="control-label cta-font-label">
                                            Font Size
                                        </label>
                                        <select name="mthefontsize" id="mthefontsize" class="lp-select2 cta-font-size" data-width="90px" onchange="changefontsize('mthefontsize',this.value)">
                                                <option value="10px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='10px'?'selected="selected"':"") }}>10 px</option>
                                                <option value="11px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='11px'?'selected="selected"':"") }}>11 px</option>
                                                <option value="12px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='12px'?'selected="selected"':"") }}>12 px</option>
                                                <option value="13px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='13px'?'selected="selected"':"") }}>13 px</option>
                                                <option value="14px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='14px'?'selected="selected"':"") }}>14 px</option>
                                                <option value="15px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='15px'?'selected="selected"':"") }}>15 px</option>
                                                <option value="16px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='16px'?'selected="selected"':"") }}>16 px</option>
                                                <option value="17px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='17px'?'selected="selected"':"") }}>17 px</option>
                                                <option value="18px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='18px'?'selected="selected"':"") }}>18 px</option>
                                                <option value="19px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='19px'?'selected="selected"':"") }}>19 px</option>
                                                <option value="20px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='20px'?'selected="selected"':"") }}>20 px</option>
                                                <option value="21px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='21px'?'selected="selected"':"") }}>21 px</option>
                                                <option value="22px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='22px'?'selected="selected"':"") }}>22 px</option>
                                                <option value="23px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='23px'?'selected="selected"':"") }}>23 px</option>
                                                <option value="24px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='24px'?'selected="selected"':"") }}>24 px</option>
                                                <option value="25px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='25px'?'selected="selected"':"") }}>25 px</option>
                                                <option value="26px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='26px'?'selected="selected"':"") }}>26 px</option>
                                                <option value="27px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='27px'?'selected="selected"':"") }}>27 px</option>
                                                <option value="28px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='28px'?'selected="selected"':"") }}>28 px</option>
                                                <option value="29px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='29px'?'selected="selected"':"") }}>29 px</option>
                                                <option value="30px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='30px'?'selected="selected"':"") }}>30 px</option>
                                                <option value="31px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='31px'?'selected="selected"':"") }}>31 px</option>
                                                <option value="32px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='32px'?'selected="selected"':"") }}>32 px</option>
                                                <option value="33px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='33px'?'selected="selected"':"") }}>33 px</option>
                                                <option value="34px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='34px'?'selected="selected"':"") }}>34 px</option>
                                                <option value="35px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='35px'?'selected="selected"':"") }}>35 px</option>
                                                <option value="36px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='36px'?'selected="selected"':"") }}>36 px</option>
                                                <option value="37px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='37px'?'selected="selected"':"") }}>37 px</option>
                                                <option value="38px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='38px'?'selected="selected"':"") }}>38 px</option>
                                                <option value="39px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='39px'?'selected="selected"':"") }}>39 px</option>
                                                <option value="40px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='40px'?'selected="selected"':"") }}>40 px</option>
                                                <option value="41px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='41px'?'selected="selected"':"") }}>41 px</option>
                                                <option value="42px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='42px'?'selected="selected"':"") }}>42 px</option>
                                                <option value="43px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='43px'?'selected="selected"':"") }}>43 px</option>
                                                <option value="44px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='44px'?'selected="selected"':"") }}>44 px</option>
                                                <option value="45px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='45px'?'selected="selected"':"") }}>45 px</option>
                                                <option value="46px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='46px'?'selected="selected"':"") }}>46 px</option>
                                                <option value="47px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='47px'?'selected="selected"':"") }}>47 px</option>
                                                <option value="48px" {{ ((@$view->data->fontsize) && @$view->data->fontsize=='48px'?'selected="selected"':"") }}>48 px</option>
                                        </select>
                                    </div>
                                    <div class="col-right">
                                        <label for="" class="control-label cta-font-label">
                                            Text Color
                                        </label>
                                        <div id="colorSelector" class="colorSelector-mmessagecp cta-color-selector" data-ctaid="mmessagecpval" data-ctavalue="mmainheadingval" ></div>
                                        <input type="hidden" name="mmessagecpval" id="mmessagecpval" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="lp-cta-textarea">
                                        <input type="text" class="cta-text cta-text_stop_event" name="mmainheadingval" id="mmainheadingval" style="" value="@if((@$view->data->homePageMessageMainMessage)) {{ trim(@$view->data->homePageMessageMainMessage) }} @endif" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-cta">
                        <div class="lp-cta-head">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="col-left"><h2 class="lp-heading-2">Description</h2></div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-input-area">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-left">
                                        <label for="" class="control-label cta-font-label">
                                            Font Type
                                        </label>
                                        <select class="lp-select2-with-custom-optclass cta-font-type" data-width = "220px" name="dthefont" id="dthefont" onchange="changefont('dthefont',this.value)">
                                            @foreach (@$view->data->fontfamilies as $font)
                                              @php
                                                $cfont = str_replace(" ", "_", strtolower($font));
                                              @endphp
                                                <option class="{{ $cfont }}" value='{{ $font }}' {{ ((@$view->data->dfontfamily) && @$view->data->dfontfamily==$font?'selected="selected"':'') }} >{{ $font }}</option>
                                             @endforeach
                                        </select>
                                    </div>
                                    <div class="col-center">
                                        <label for="" class="control-label cta-font-label">
                                            Font Size
                                        </label>
                                        <select name="dthefontsize" id="dthefontsize" class="lp-select2 cta-font-size" data-width="90px" onchange="changefontsize('dthefontsize',this.value)">
                                                <option value="10px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='10px'?'selected="selected"':"") }}>10 px</option>
                                                <option value="11px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='11px'?'selected="selected"':"") }}>11 px</option>
                                                <option value="12px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='12px'?'selected="selected"':"") }}>12 px</option>
                                                <option value="13px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='13px'?'selected="selected"':"") }}>13 px</option>
                                                <option value="14px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='14px'?'selected="selected"':"") }}>14 px</option>
                                                <option value="15px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='15px'?'selected="selected"':"") }}>15 px</option>
                                                <option value="16px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='16px'?'selected="selected"':"") }}>16 px</option>
                                                <option value="17px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='17px'?'selected="selected"':"") }}>17 px</option>
                                                <option value="18px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='18px'?'selected="selected"':"") }}>18 px</option>
                                                <option value="19px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='19px'?'selected="selected"':"") }}>19 px</option>
                                                <option value="20px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='20px'?'selected="selected"':"") }}>20 px</option>
                                                <option value="21px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='21px'?'selected="selected"':"") }}>21 px</option>
                                                <option value="22px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='22px'?'selected="selected"':"") }}>22 px</option>
                                                <option value="23px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='23px'?'selected="selected"':"") }}>23 px</option>
                                                <option value="24px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='24px'?'selected="selected"':"") }}>24 px</option>
                                                <option value="25px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='25px'?'selected="selected"':"") }}>25 px</option>
                                                <option value="26px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='26px'?'selected="selected"':"") }}>26 px</option>
                                                <option value="27px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='27px'?'selected="selected"':"") }}>27 px</option>
                                                <option value="28px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='28px'?'selected="selected"':"") }}>28 px</option>
                                                <option value="29px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='29px'?'selected="selected"':"") }}>29 px</option>
                                                <option value="30px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='30px'?'selected="selected"':"") }}>30 px</option>
                                                <option value="31px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='31px'?'selected="selected"':"") }}>31 px</option>
                                                <option value="32px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='32px'?'selected="selected"':"") }}>32 px</option>
                                                <option value="33px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='33px'?'selected="selected"':"") }}>33 px</option>
                                                <option value="34px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='34px'?'selected="selected"':"") }}>34 px</option>
                                                <option value="35px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='35px'?'selected="selected"':"") }}>35 px</option>
                                                <option value="36px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='36px'?'selected="selected"':"") }}>36 px</option>
                                                <option value="37px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='37px'?'selected="selected"':"") }}>37 px</option>
                                                <option value="38px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='38px'?'selected="selected"':"") }}>38 px</option>
                                                <option value="39px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='39px'?'selected="selected"':"") }}>39 px</option>
                                                <option value="40px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='40px'?'selected="selected"':"") }}>40 px</option>
                                                <option value="41px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='41px'?'selected="selected"':"") }}>41 px</option>
                                                <option value="42px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='42px'?'selected="selected"':"") }}>42 px</option>
                                                <option value="43px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='43px'?'selected="selected"':"") }}>43 px</option>
                                                <option value="44px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='44px'?'selected="selected"':"") }}>44 px</option>
                                                <option value="45px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='45px'?'selected="selected"':"") }}>45 px</option>
                                                <option value="46px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='46px'?'selected="selected"':"") }}>46 px</option>
                                                <option value="47px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='47px'?'selected="selected"':"") }}>47 px</option>
                                                <option value="48px" {{ ((@$view->data->dfontsize) && @$view->data->dfontsize=='48px'?'selected="selected"':"") }}>48 px</option>
                                        </select>
                                    </div>
                                    <div class="col-right">
                                        <label for="" class="control-label cta-font-label">
                                            Text Color
                                        </label>
                                        <div id="colorSelector" class="colorSelector-mdescp cta-color-selector" data-ctaid="dmessagecpval" data-ctavalue="dmainheadingval"></div>
                                        <input type="hidden" name="dmessagecpval" id="dmessagecpval" value="@if((@$view->data->dcolor) && (@$view->data->dcolor)) {{ @$view->data->dcolor }} @endif">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="lp-cta-textarea">
                                        <textarea class="cta-textarea" id="dmainheadingval" name="dmainheadingval" style="{{ @$view->data->dmessageStyle }}">@if((@$view->data->homePageMessageDescription)) {{ trim(@$view->data->homePageMessageDescription) }} @endif</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-save">
                                <div class="custom-btn-success">
                                    <button type="button" class="btn btn-success" onclick="saveglobalmaincontent();" ><strong>SAVE</strong></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
			<div id="auto-responder" class="tab-pane fade @if(@$view->data->action=='autoresponder') {{ ' in active' }} @endif" >
				<form name="globalfhtml" id="globalfhtml" class="form-inline" method="POST" action="{{ LP_BASE_URL.LP_PATH.'/global/saveglobalautoresponder' }}">
				  {{csrf_field()}}
                    <input type="hidden" name="html_active" id="html_active" value="">
                  <input type="hidden" name="text_active" id="text_active" value="">
                  <input type="hidden" name="responder_active" id="responder_active" value="y">
                  <input type="hidden" name="lpkey_responder" id="lpkey_responder" value="">
                  <input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">
					<div class="lp-auto-responder global-space">            <!--class=lp-common-section-->
						<div class="lp-auto-responder-head">    <!--class=lp-common-section-head-->
							<div class="row">
								<div class="col-md-10">
									<div class="col-left"><h2 class="lp-heading-2">Autoresponder message detail</h2></div>
								</div>
								<div class="col-md-2">
									<div class="col-right">
										<div class="custom-btn-toggle">
											<input checked class="responder-toggle" data-field = 'responder_active' data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="lp-msg-box">
									<label for="textMsg" class="control-label lp-auto-responder-label">Message Subject</label>
									<input type="text" class="lp-auto-responder-textbox lp-auto-responder-textbox_stop_event" id="subline" name="subline" value="@if((@$view->data->globalOptions['subline']) && @$view->data->globalOptions['subline']!="") {{ @$view->data->globalOptions['subline'] }} @else {{ "Thank You For Contacting ".@$view->session->clientInfo->company_name }} @endif">
								</div>
							</div>
						</div>
					</div>
					<div class="lp-auto-responder">
						<div class="row">
							<div class="col-md-12">
								<div class="lp-auto-responder-head">
									<div class="col-left"><h2 class="lp-heading-2">Message type</h2></div>

								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="lp-email-box">
									<div class="lp-email-wrapper">
										<div class="radio-inline html-email">
											<input data-id="html-editor" checked type="radio" id="r3" name="cell_phone"/>
											<label for="r3"><span></span><b>Html</b> Email</label>
										</div>
										<div class="radio-inline text-email">
											<input data-id="text-editor" type="radio" id="r4" name="cell_phone"/>
											<label for="r4"><span></span><b>Text</b> Email</label>
										</div>
										<div class="lp-ck-wrapper"></div>
										<div id="textwrapper">
											<textarea name="htmlautoeditor" class="lp-html-editor lp-email-section lp-froala-textbox"></textarea>
										</div>
										<div id="textwrapper-area">
											<textarea name="textautoeditor" id="lp-text-editor" class="lp-email-section textautoeditor"></textarea>
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
									<button type="button" class="btn btn-success" onclick="saveglobalautoresponder()"><strong>SAVE</strong></button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div id="contact-info" class="tab-pane fade @if(@$view->data->action=='contactinfo') {{ ' in active' }} @endif">
				<form name="globalcontactinfo" id="globalcontactinfo" class="form-inline" method="POST" action="{{ LP_BASE_URL.LP_PATH.'/global/globalsavecontactoptions' }}">
					{{csrf_field()}}
                    <input type="hidden" name="companyname_active" id="companyname_active" value="y">
					<input type="hidden" name="phonenumber_active" id="phonenumber_active" value="y">
					<input type="hidden" name="email_active" id="email_active" value="y">
					<input type="hidden" name="lpkey" id="lpkey" value="">
					<input type="hidden" name="is_include" id="is_include" value="y">
					<input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">
					<div class="lp-content-contact-div global-space">
						<div class="row">
							<div class="col-md-2">
								<label for="companyname" class="control-label lp-con-label">Company Name</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="lp-cont-textbox" name="company_name" id="companyname" >
							</div>
							<div class=" col-md-2 custom-btn-toggle">
								<input checked class="company-toggle" data-field = 'companyname_active' data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
							</div>
						</div>
					</div>
					<div class="lp-content-contact-div">
						<div class="row">
							<div class="col-md-2">
								<label for="phonenumber" class="control-label lp-con-label">Phone Number</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="lp-cont-textbox" name="phone_number" id="phonenumber">
							</div>
							<div class=" col-md-2 custom-btn-toggle">
								<input checked class="phonenumber-toggle" data-field = "phonenumber_active" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
							</div>
						</div>
					</div>
					<div class="lp-content-contact-div">
						<div class="row">
							<div class="col-md-2">
								<label for="email" class="control-label lp-con-label">Email Address</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="lp-cont-textbox" name="email_address" id="email" >
							</div>
							<div class=" col-md-2 custom-btn-toggle">
								<input checked class="email-toggle" data-field = "email_active" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="lp-save">
								<div class="custom-btn-success">
									<button type="button" class="btn btn-success" onclick="saveglobalcontactmessage();">SAVE</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

            <?php //if($client_products[LP_Constants::PRODUCT_FUNNEL]!="0"){ ?>
			<div id="footer-tab" class="tab-pane fade @if(@$view->data->action=='footer') {{ ' in active' }} @endif">
					<div class="lp-thankyou global-space">
						<div class="lp-thankyou-head">
							<div class="row">
								<div class="col-md-10">
									<div class="col-collapse"><h2  class="footer-head-color">Primary Footer Options</h2></div>
								</div>
								<div class="col-md-2">
									<div class="col-right">
										<a href="#primary-footer" data-toggle="collapse" id="lp-footer-collapse" class="lp-footer-collapse"></a>
									</div>
								</div>
							</div>
						</div>
						<div id="primary-footer" class="collapse">
							<div class="lp-thankyou-head">
								<div class="row">
									<div class="lp-custom-width">
										<div class="col-md-10">
											<div class="col-left"><h3 class="lp-heading-3">Privacy Policy</h3></div>
										</div>
										<div class="col-md-2">
											<div class="col-center">
												<a href="{{ LP_BASE_URL.LP_PATH.'/global/privacypolicy' }}"><i class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="lp-thankyou-head">
								<div class="row">
									<div class="lp-custom-width">
										<div class="col-md-10">
											<div class="col-left"><h3 class="lp-heading-3">Terms of Use</h3></div>
										</div>
										<div class="col-md-2">
											<div class="col-center">
												<a href="{{ LP_BASE_URL.LP_PATH.'/global/termsofuse' }}"><i class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="lp-thankyou-head">
								<div class="row">
									<div class="lp-custom-width">
										<div class="col-md-10">
											<div class="col-left"><h3 class="lp-heading-3">Disclosures</h3></div>
										</div>
										<div class="col-md-2">
											<div class="col-center">
												<a href="{{ LP_BASE_URL.LP_PATH.'/global/disclosures' }}"><i class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="lp-thankyou-head">
								<div class="row">
									<div class="lp-custom-width">
										<div class="col-md-10">
											<div class="col-left"><h3 class="lp-heading-3">Licensing Information</h3></div>
										</div>
										<div class="col-md-2">
											<div class="col-center">
												<a href="{{ LP_BASE_URL.LP_PATH.'/global/licensinginformation' }}"><i class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="lp-thankyou-head">
								<div class="row">
									<div class="lp-custom-width">
										<div class="col-md-10">
											<div class="col-left"><h3 class="lp-heading-3">About US</h3></div>
										</div>
										<div class="col-md-2">
											<div class="col-center">
												<a href="{{ LP_BASE_URL.LP_PATH.'/global/aboutus' }}"><i class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="lp-thankyou-head">
								<div class="row">
									<div class="lp-custom-width">
										<div class="col-md-10">
											<div class="col-left"><h3 class="lp-heading-3">Contact US</h3></div>
										</div>
										<div class="col-md-2">
											<div class="col-center">
												<a href="{{ LP_BASE_URL.LP_PATH.'/global/contactus' }}"><i class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<form name="gsecfotform" id="gsecfotform" class="form-inline" method="POST" action="{{ LP_BASE_URL.LP_PATH.'/global/saveglobalmaincontent' }}">
                          {{csrf_field()}}
						<div class="lp-thankyou">
							<div class="lp-thankyou-head">
								<div class="row">
									<div class="col-md-10">
										<div class="col-collapse"><h2 class="footer-head-color =">Secondary Footer Options</h2></div>
									</div>
									<div class="col-md-2">
										<div class="col-right">
											<a href="#secondary-footer" data-toggle="collapse" id="lp-footer-collapse" class="lp-footer-collapse"></a>
										</div>
									</div>
								</div>
							</div>
							<div id="secondary-footer" class="collapse">
								<div class="lp-thankyou-head">
									<div class="row">
										<div class="lp-custom-width">
											<div class="col-md-10">
												<div class="col-left">
                                                    <label for="Compliance" class="lp-label" id="compliance">Compliance Text:</label>
													<!--<h3 class="lp-heading-3 bodin">Compliance Text:</h3>-->
                                                    <input type="text" name="compliance_text" value="{{ @$view->data->globalOptions['compliance_text'] }}" id="compliance_text" class="lp-footer-textbox " disabled>
												</div>
											</div>
											<div class="col-md-2">
												<div class="col-center">
													<a href="#" class="lp_footer_toggle_compliance" data-togele="lp-footer-url-edit"><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
												</div>
											</div>
                                            <input type="hidden" name="client_id" id="client_id"  value="{{ @$view->data->client_id }}">
                                            <input type="hidden" name="lpkey_secfot" id="lpkey_secfot" value="">
                                            <input type="hidden" name="sec_fot_url_active" id="sec_fot_url_active" value="{{ @$view->data->globalOptions['sec_fot_url_active'] }}">
                                            <input type="hidden" name="sec_fot_license_number_active" id="sec_fot_license_number_active" value="{{ @$view->data->globalOptions['sec_fot_license_number_active'] }}">
                                            <input type="hidden" name="gfot_ai_val" id="gfot_ai_val" value="{{ @$view->data->globalOptions['sec_fot_url_active'] }}">
                                            <input type="hidden" name="gfot_ai_val1" id="gfot_ai_val1" value="{{ @$view->data->globalOptions['sec_fot_license_number_active'] }}">
                                            <input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">
                                            <input type="hidden" name="thelink" id="thelink"  value="compliance_active~license_number_active">
                                            <input type="hidden" name="gfot-ai-flg" id="gfot-ai-flg"  value="0">
                                            <input type="hidden" name="gfot-ai-flg1" id="gfot-ai-flg1"  value="0">
										</div>
									</div>
								</div>
								<div id="lp-footer-url-edit" class="hide">
									<div class="row">
										<div class="col-md-12">
											<div class="lp-thankyou-head">
												@php
		                                            $checked="";
		                                            $disable="disabled";
		                                            if(@$view->data->globalOptions['compliance_is_linked']=='y') {
		                                                $checked='checked';
		                                                $disable="";
		                                            }
                                                @endphp
		                                         <input {{ $checked }}  type="checkbox" name="compliance_is_linked" id="compliance_is_linked" data-tarele="compliance_link"  value="y" />
		                                         <label class="lp-footer-label" for="compliance_is_linked"><span  class="lp-checkbox-icon"></span>Link to URL</label>
		                                        <label for="" class="control-label lp-footer-label">
		                                            URL
		                                        </label>
		                                        <input type="text" class="lp-footer-textbox-2" name="compliance_link" value="{{ @$view->data->globalOptions['compliance_link'] }}" id="compliance_link" {{ $disable }}>

											</div>
										</div>
									</div>
								</div>
								<div class="lp-thankyou-head">
									<div class="row">
										<div class="lp-custom-width">
											<div class="col-md-10">
												<div class="col-left">


                                                    <label for="License" class="lp-label" id="licence">License #:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                    <input class="lp-footer-textbox " type="text" name="license_number_text" value="{{ @$view->data->globalOptions['license_number_text'] }}" id="license_number_text" disabled>

												</div>
											</div>
											<div class="col-md-2">
												<div class="col-center">
													<a href="#" class="lp_footer_toggle_licence" data-togele="lp-footer1-url-edit"><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="lp-footer1-url-edit" class="hide">
									<div class="row">
										<div class="col-md-12">
											<div class="lp-thankyou-head">

												@php
												$checked="";
												$disable="disabled";

												if(@$view->data->globalOptions['license_number_is_linked']=='y') {
													$checked='checked';
													$disable="";
												}
												@endphp
												<input  {{ $checked }} type="checkbox" name="license_number_is_linked" id="license_number_is_linked" data-tarele="license_number_link" value="y"  />
												<label class="lp-footer-label" for="license_number_is_linked"><span  class="lp-checkbox-icon" ></span>Link to URL</label>
												<label for="" class="control-label lp-footer-label">
													URL
												</label>
												<input type="text" class="lp-footer-textbox-2" name="license_number_link" value="{{ @$view->data->globalOptions['license_number_link'] }}" id="license_number_link" {{ $disable }}>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="lp-footer-save">
											<div class="custom-btn-success">
												<button type="button" class="btn btn-success" onclick="return compliance_update();" ><strong>SAVE</strong></button>
											</div>
										</div>
									</div>
								</div>
							</div>
                        </div>
                    </form>
                <div class="lp-thankyou" id="advance-footer-wrapper">
                    <div class="lp-thankyou-head">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-collapse"><h2 class="footer-head-color =">Super Footer Options</h2></div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-btn-toggle">
                                    <input class="global_super_status_btn" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-right">
                                    <a href="#advance-footer" data-toggle="collapse" id="lp-footer-collapse" class="lp-footer-collapse footer-expand"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="advance-footer" class="collapse">
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                </div>
                            </div>
                        </div>
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                    <div class="col-md-12">
                                        <div class="col-left global_advance_footer">
                                        <textarea class="lp-froala-textbox">
                                        </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="lp-footer-save">
                                <div class="custom-btn-success">
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <span class="fa fa-rotate-left"></span><span style="cursor: pointer;" onclick="activetodefaultadvancedfooter()">RESET DEFAULT</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-push-1">
                                   <button type="button" id="global-advance-footer-save-btn" class="btn btn-success"><strong>SAVE</strong></button>
                                    </div>
                                    <div class="col-md-5" class="col-center">
                                        <div id="hide-other">
                                              <input class="sub-group" id="hideofooter" data-key="hideofooter" name="hideofooter" type="checkbox">
                                            <label for="hideofooter">Hide Primary and Secondary footer content<span></span></label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="default-html" style="display: none;">
                    <div class="container advanced-container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="funnel__title">How this works...</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <div class="box funnel__box">
                                    <div class="box__counter">1</div>
                                    <div class="box__content">
                                        <h3 class="box__heading"><span style="font-size: 20px;">60-Second Digital Pre-Approval</span></h3>
                                        <p class="box__des">Share some basic info; if qualified, we&#39;ll provide you with a free, no-obligation pre-approval letter.</p>
                                    </div>
                                </div>
                                <div class="box funnel__box">
                                    <div class="box__counter">2</div>
                                    <div class="box__content">
                                        <h3 class="box__heading"><span style="font-size: 20px;">Choose the Best Options for You</span></h3>
                                        <p class="box__des">Choose from a variety of loan options, including our conventional 20% down product.
                                            <br>
                                            <br>We also offer popular 5%-15% down home loans... AND we can even go as low as 0% down.</p>
                                    </div>
                                </div>
                                <div class="box funnel__box">
                                    <div class="box__counter">3</div>
                                    <div class="box__content">

                                        <h3 class="box__heading"><span style="font-size: 20px;">Start Shopping for Your Home!</span></h3>

                                        <p class="box__des">It only takes about 60 seconds to get everything under way. Simply enter your zip code right now.</p>
                                    </div>
                                </div>
                                <!-- <a class="funnel__btn" href="#">Find My 203K</a> -->
                                <div style="text-align: center;margin: 20px auto;"><a class="lp-btn__go" href="#GetStartedNow" id="btn-submit" tabindex="-1" title="">Get Started Now!</a></div>
                                <div class="funnel__caption">

                                    <p style="text-align: center; margin-left: 20px;"><em><span style="font-size: 11px;">This hassle-free process only takes about 60 seconds,&nbsp;</span></em>
                                        <br><em><span style="font-size: 11px;">and it won&#39;t affect your credit score!</span></em></p>

                                    <p>
                                        <br>
                                    </p>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="animate-container">
                                    <div class="first animated desktop slideInRight"><img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-1.png" class="fr-fic fr-dii"></div>
                                    <div class="second animated desktop fadeIn">


                                        <h2 class="animate__heading" style="font-size: 18px;"><span style="font-size: 18px;">Share some basic info</span></h2><img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-2.png" class="fr-fic fr-dii"></div>
                                    <div class="third animated desktop zoomIn"><strong><span style="color: rgb(3, 177, 253); font-size: 18px;">10% Down</span></strong></div>
                                    <div class="fourth animated desktop fadeInLeft"><img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-4.png" class="fr-fic fr-dii"></div>
                                    <div class="fifth animated desktop slideInRight">

                                        <p><span class="clientfname">Hi, I&#39;m @php echo $view->session->clientInfo->first_name; @endphp, your loan&nbsp;</span>officer.
                                            <br>It looks like you may qualify for<br>a lot more than you thought!</p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <p></p>
                            </div>
                            <br>
                        </div>
                        <p></p>
                    </div>
                </div>
                <!-- Model Boxes - Property CTA - Start -->
                <div id="modal_proerty_template" class="modal fade lp-modal-box in">
                    <div class="modal-dialog modal-dialog-template">
                        <div class="modal-content">
                            <div class="modal-header modal-action-header">
                                <h3 class="modal-title modal-action-title property-modal-text title-bold title-18" >Would you like to use our default CTA Message that goes with Property Template?&nbsp;<i class="fa fa-question-circle CTA-wraning"><span class="CTA-wraning__tooltiptext">No matter which option you select below, you can always further customize the CTA messaging from the "Edit > Content&nbsp;> <br>Call-to-Action" section of the Funnels Admin Panel.</span></i></h3>
                            </div>
                            <div class="modal-body model-action-body">
                                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                                    <div class="row">
                                        <div class="col-sm-12 modal-action-msg-wrap">
                                            <div class="modal-msg property-msg">
                                                <p><span class="radio" style="display: inline-block;margin:inherit;">
                                                <input type="radio" class="lp-popup-radio" value="y" id="property_cta_yes" name="property_cta">
                                                <label class="radio-control-label" style="padding-left: inherit;" for="property_cta_yes"><span></span></label>
                                            </span>Yes, use the default CTA message that goes with this template &nbsp&nbsp&nbsp</p>
                                                <p><span class="radio" style="display: inline-block;margin:inherit; ">
                                                <input type="radio" class="lp-popup-radio" value="n" checked="" id="property_cta_no" name="property_cta">
                                                <label class="radio-control-label" style="padding-left: inherit;" for="property_cta_no"><span></span></label>
                                            </span>No, I'd like to keep what I have now &nbsp&nbsp&nbsp</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-modal-footer lp-modal-action-footer lp-modal-action-footer-template">
                                <a data-dismiss="modal" class="btn lp-btn-cancel lp-btn-cancel-template" style="color: white">Close</a>
                                <a id="_update_template_cta_btn" class="btn lp-btn-add lp-btn-add-template">Save & Continue</a>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Model Boxes - Property CTA - End -->
            </div>

			<div id="seo" class="tab-pane fade @if(@$view->data->action=='seo') {{ ' in active' }} @endif">
				<form name="globalseo" id="globalseo" class="form-inline" method="POST" action="{{ LP_BASE_URL.LP_PATH.'/global/globalsaveseo' }}">
					{{csrf_field()}}
                    <input type="hidden" name="seo_title_active" id="seo_title_active" value="{{ @$view->data->globalOptions["seo_title_active"] }}">
					<input type="hidden" name="seo_description_active" id="seo_description_active" value="{{ @$view->data->globalOptions["seo_description_active"] }}">
					<input type="hidden" name="seo_keyword_active" id="seo_keyword_active" value="{{ @$view->data->globalOptions["seo_keyword_active"] }}">
					<input type="hidden" name="lpkey_seo" id="lpkey_seo" value="">
					<input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">
					<div class="lp-seo global-space">
						<div class="lp-seo-head">
							<div class="row">
								<div class="col-md-10">
									<div class="col-left">
										<h2 class="lp-heading-2">Title Tag</h2>
									</div>
								</div>
								<div class="col-md-2">
									<div class="custom-btn-toggle">
                                        @php
											$checked="";
											if(@$view->data->globalOptions["seo_title_active"]=="y") $checked="checked";
                                        @endphp
										<input {{ $checked  }} class="seo-toggle" data-field = 'seo_title_active' data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="lp-seo-box">
									<input type="text" class="lp-tg-textbox lp-tg-textbox_stop_event" name="seo_title_tag" value="<?php //echo @$view->data->globalOptions["seo_title"] ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="lp-seo">
						<div class="lp-seo-head">
							<div class="row">
								<div class="col-md-10">
									<div class="col-left">
										<h2 class="lp-heading-2">Description</h2>
									</div>
								</div>
								<div class="col-md-2">
									<div class="custom-btn-toggle">
                                        @php
                                            $checked="";
                                            if(@$view->data->globalOptions["seo_description_active"]=="y") $checked="checked";
                                         @endphp
                                        <input {{ $checked }} class="seo-toggle" data-field = 'seo_description_active' data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="lp-seo-box">
                                    <textarea class="lp-seo-textbox" name="seo_description"><?php //echo @$view->data->globalOptions["seo_description"] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-seo">
                        <div class="lp-seo-head">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="col-left">
                                        <h2 class="lp-heading-2">Keywords</h2>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="custom-btn-toggle">
                                        @php
                                            $checked="";
                                            if(@$view->data->globalOptions["seo_keyword_active"]=="y") $checked="checked";
										 @endphp
										<input {{ $checked }} class="seo-toggle" data-field = 'seo_keyword_active' data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="lp-seo-box">
									<textarea class="lp-seo-textbox" name="seo_keywords"><?php //echo @$view->data->globalOptions["seo_keyword"] ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="lp-save">
								<div class="custom-btn-success">
									<button type="button" class="btn btn-success" onclick="globalsaveseo();"><strong>SAVE</strong></button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div id="thankyou" class="tab-pane fade @if(@$view->data->action=='thankyou') {{  ' in active' }} @endif">
				<form name="globalthankyou" id="globalthankyou" class="form-inline" method="POST" action="{{ LP_BASE_URL.LP_PATH.'/global/globalsavethankyouoptions' }}">
					{{csrf_field()}}
                    <input type="hidden" name="thankyou_active" id="thankyou_active" value="">
					<input type="hidden" name="thirdparty_active" id="thirdparty_active" value="">
					<input type="hidden" name="lpkey_thankyou" id="lpkey_thankyou" value="">
                    <input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">
					<input type="hidden" name="changebtn" id="changebtn" value="">
                    <input type="hidden" id="clientfname" value="@php echo @$view->session->clientInfo->first_name; @endphp">
                    <div class="lp-thankyou global-space">
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-th-custom-width">
                                    <div class="col-md-10">
                                        <div class="col-left"><h2 class="lp-heading-2" >Thank You Page</h2></div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-btn-toggle">
                                            @php
                                                $checked="checked";
                                            @endphp
                                            <input {{ $checked }} class="glvthktogbtn" id="thankyou-toggle" name="thankyou" data-thelink="thankyou_active" data-target="#thirldparty-toggle" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="g-thk-msg-wrp">
                            <div class="col-md-12">
                                <div id="msg"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="lp-email-box">
                                            <div id="textwrapper" class="">
                                                <textarea class="lp-html-editor-global lp-email-section lp-froala-textbox"  name="thankyoumessage"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-thankyou">
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-th-custom-width-2">
                                    <div class="col-md-8">
                                        <div class="col-left"><h2 class="lp-heading-2">Third Party URL</h2></div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <a href="javascript::void();" id="eurllink" class="lp_thankyou_toggle"><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-btn-toggle">
                                            @php
                                                $checked="";
                                            @endphp
                                            <input {{ $checked }} class="glvthktogbtn" id="thirldparty-toggle" data-target="#thankyou-toggle" name="thirldparty" data-thelink="thirdparty_active" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="lp-custom-para">
                                    <p>
                                        This option gives your potential clients a quick thank you message, and then forwards
                                        them to a third party website of your choice. You can send your potential clients to your company
                                        website, personal website, blog, Facebook page, etc.
                                    </p>
                                </div>
                                <div id="lp-thankyou-url-edit" class="col-md-12 hide" >
                                    <div class="row">
                                        <div class="lp-thankyou-input custom-btn-toggle">
                                            @php
                                                $checked="";
                                                @endphp
                                            <input {{ $checked }} id="https_flag" class="" name="https_flag"  data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="HTTP://" data-off="HTTPS://" type="checkbox">
                                            <input type="text" class="lp-thankyou-textbox" id="thirdpartyurl" name="thirdpartyurl" value="">
                                            <label class="error thirdpartyurl_error" style="display: none">Please enter URL.</label>
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
									<button type="button" class="btn btn-success" onclick="globalsavethankyou()" ><strong>SAVE</strong></button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--INTEGRATION-PIXELS-->
	<div id="gl-integration-pixels" class="global-items @if(@$view->data->action=='integration' || @$view->data->action=='pixels'|| @$view->data->action=='leadalerts' || @$view->data->action=='ada') {{ 'item-active' }} @endif">
		<div class="sub-tab-section integration-pixels">
			<ul class="nav nav-tabs">
                <li class="@if(@$view->data->action=='pixels') {{  'active' }} @endif"><a  data-toggle="tab" href="#pixels">PIXELS</a></li>
				<li class="@if(@$view->data->action=='leadalerts') {{  'active' }} @endif"><a  data-toggle="tab" href="#leadalerts">LEAD ALERTS</a></li>
				<li class="@if(@$view->data->action=='integration') {{  'active' }} @endif"><a  data-toggle="tab" href="#integration">INTEGRATIONS</a></li>
                <li class="@if(@$view->data->action=='ada') {{ 'active' }} @endif"><a  data-toggle="tab" href="#ada">ADA ACCESSIBILITY</a></li>
            </ul>
		</div>
		<div class="tab-content">

            <div id="pixels" class="tab-pane fade @if(@$view->data->action=='pixels')  {{ ' in active' }} @endif">

                <form name="maincontent_pixel" id="maincontent_pixel" class="form-inline" method="POST" action="{{ LP_PATH }}/popadmin/savepixelinfo">
                    {{csrf_field()}}
                    <input name="action" id="action" type="hidden" value="global.add" />
                    <input name="lpkey_pixels" id="lpkey_pixels" type="hidden" value="" />
                    <input name="id" id="id" type="hidden" value="" />
                    <input name="current_hash" id="current_hash" type="hidden" value="" />
                    <input name="domains_include" id="domains_include" type="hidden" value="" />
                    <input name="domains_ids" id="domains_ids" type="hidden" value="" />
                    <input name="client_id" id="client_id" type="hidden" value="{{ @$view->data->client_id }}" />
                    <div class="lp-cta global-space">
                        <div class="lp-cta-head">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="col-left"><h2 class="lp-heading-2">Add Pixel Code</h2></div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-input-area pixel-wrap">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="" class="control-label pixel-label">Pixel Placement</label>
                                </div>
                                <div class="col-md-4">
                                    <select class="lp-select2 lp-h50" data-width="92.5%" data-style="lp-select-box" name="pixel_placement" id="pixel_placement">
			                            @foreach(LP_Constants::pixelPlacementsList() as $id=>$pixel)
                                            <option value="{{ $id }}">{{ $pixel }}</option>
				                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="" class="control-label pixel-label">Code Type</label>
                                </div>
                                <div class="col-md-4">
                                    <select class="lp-select2 lp-h50" data-width="92.5%" data-style="lp-select-box" name="pixel_type" id="pixel_type">
			                            @foreach(LP_Constants::pixelTypeList() as $id=>$pixel)
                                            <option value="{{ $id }}">{{ $pixel }}</option>
				                           @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row"><div class="col-md-12">&nbsp;</div></div>

                            <div class="row">

                                <div class="col-md-2">
                                    <label for="pixel_name" class="control-label pixel-label">Code Name</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="lp-cont-textbox" name="pixel_name" id="pixel_name">
                                </div>

                                <div class="col-md-2">
                                    <label for="tracking_id" class="control-label pixel-label tracking_to_lender">Tag ID</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="lp-cont-textbox" name="pixel_code" id="pixel_code">
                                </div>

                            </div>

                            <div class="row"><div class="col-md-12">&nbsp;</div></div>

                            <div class="row">

                                <div class="col-md-2 pixel_position">
                                    <label for="tracking_id" class="control-label pixel-label">Code Placement</label>
                                </div>
                                <div class="col-md-4 pixel_position">
                                    <select class="lp-select2 lp-h50" data-width="92.5%" data-style="lp-select-box" name="pixel_position" id="pixel_position">
			                            @foreach(LP_Constants::pixelPositionList() as $id=>$pixel)
                                            <option value="{{ $id }}">{{ $pixel }}</option>
			                            @endforeach
                                    </select>
                                </div>

                                <span class="pixel_extra facebook_pixel_action" style="display: none;">
                                    <div class="col-md-2">
                                        <label for="" class="control-label pixel-label">Pixel Action</label>
                                    </div>
                                    <div class="col-md-4" style="padding-top: 10px">
                                        <input type="hidden" name="pixel_action[]" id="pixel_action" value="{{ LP_Constants::PIXEL_ACTION_LEAD }}">
			                            <input disabled checked type="checkbox">
                                        <label for="pixel_action" class="lp-gray"><span></span>Lead</label>&nbsp;&nbsp;&nbsp;
                                    </div>
                                </span>


                                <span class="pixel_extra pixel_other" style="display: none;">
                                    <div class="col-md-2">
                                        <label for="pixel_other" class="control-label pixel-label pixel_other_label"></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="lp-cont-textbox" name="pixel_other" id="pixel_other">
                                    </div>
                                </span>

                            </div>





                            <div class="row"><div class="col-md-12">&nbsp;</div></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="lp-save">
                                        <div class="custom-btn-success">
                                            <button type="button" class="pixel_global_add_btn btn btn-success"><strong>ADD CODE</strong></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row"><div class="col-md-12">&nbsp;</div></div>

                    <div class="lp-pixels">
                        <div class="lp-pixels-head">
                            <div class="row">
                                <div class="col-md-10">
                                    <h2>Global Tracking Pixels and Codes</h2>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                        <div class="lp-pixels-col">
                            <div class="row">
                                <div class="col-md-12 global-pixel-list">
                                    <div class="domain-edit">
                                        <h3>Code Name</h3><h3>Options</h3>
                                    </div>

                                    @php
                                    if(@@$view->data->globalPixels) {
                                        foreach(@@$view->data->globalPixels as $pixel){
	                                        $dataAttr = array();
	                                        foreach($pixel as $c=>$v) {
		                                        if(in_array($c, ['client_id','leadpops_id','client_leadpops_id','domain_id']))
			                                        continue;
			                                    $val = ($v)?$v:"''";
		                                        $dataAttr[] = "data-".$c."=".$val;
	                                        }
	                                        $dataAttr[] = 'data-pixel_type_label="'.LP_Constants::getPixelType($pixel['pixel_type']).'"';
	                                        $dataAttr[] = 'data-pixel_placement_label="'.LP_Constants::getPixelPlace($pixel['pixel_placement']).'"';
	                                        $dataAttr[] = 'data-pixel_action_label="'.LP_Constants::getPixelAction($pixel['pixel_action']).'"';
	                                        @endphp
                                            <div class="domain-edit pixel_{{ $pixel['id'] }}">
		                                        {{ $pixel['pixel_name'] }} <a href="#" class="action-btn btn-delete-GlobalPixel" {{  implode(" ",$dataAttr) }} ><i class="fa fa-remove"></i>DELETE</a>
                                                <a href="#" class="action-btn btn-edit-GlobalPixel" {{ implode(" ",$dataAttr) }}><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                            </div>
	                                        @php
                                        }
                                    }
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-pixel-alerts"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="leadalerts" class="tab-pane fade @if(@$view->data->action=='leadalerts') {{ ' in active' }} @endif">
                <div class="lp-cta global-space" id="recipient_modal">
                    <form name="fnewrecipient"  id="fnewrecipient" action="{{ LP_PATH }}/account/savenewrecipient" method="POST" class="lp-popup-form recipient-form">
                        {{csrf_field()}}
                        <div class="lp-cta-head">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="col-left"><h2 class="lp-heading-2">Add Recipient</h2></div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-input-area pixel-wrap">
                                <input name="lpkey_recip" id="lpkey_recip" type="hidden" value="" />
                                <input type="hidden" name="newkeys" id="newkeys" value="{{  @$view->data->keys }}">
                                <input type="hidden" name="newclient_id" id="newclient_id" value="{{  @$view->data->client_id }}">
                                <input type="hidden" name="editrowid" id="editrowid" value="">
                                <input type="hidden" name="isnewrowid" id="isnewrowid" value="">
                                <input type="hidden" name="lp_auto_recipients_id" id="lp_auto_recipients_id" value="">
                                <div class="alert hide model_notification"></div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label pixel-label" for="edit_email">Email Address</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="email"  name="newemail" class="lp-cont-textbox" id="newemail">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label pixel-label">Text Cellphone</label>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="radio-inline">
                                            <input type="radio" class="lp-popup-radio" value="y" id="newtextcell_yes" name="newtextcell" />
                                            <label class="radio-control-label" for="newtextcell_yes"><span></span>Yes</label>
                                        </span>
                                        <span class="radio-inline">
                                            <input type="radio" class="lp-popup-radio" value="n" checked id="newtextcell_no" name="newtextcell" />
                                            <label class="radio-control-label" for="newtextcell_no"><span></span>No</label>
                                        </span>
                                    </div>
                                </div>
                                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                                <div class="gtextToggleCtrl">
                                    <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label pixel-label" for="edit_cell_number">Cellphone Number</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" autocomplete="off" rel="" class="lp-cont-textbox" id="cell_number" name="cell_number">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label pixel-label" for="subject">Cell Carrier</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="lp-select2 lp-h50" data-width="92.5%" data-style="lp-select-box" id="carrier" name="carrier" >
                                            {!! View_Helper::getInstance()->getCarriers() !!}
                                        </select>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="lp-save">
                                            <div class="custom-btn-success">
                                                <input type="button" id="edit_rcpt" class="btn btn-success lp-btn-add _add_recipient_btn" value ="Save">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <form class="form-inline" method="post">
                        <div class="lead-alert-section lead-alert">
                            <div class="lead-alert-heading">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h2 class="lead-alert-title">Global Lead Recipients</h2>
                                    </div>
                                </div>
                            </div>
                            <div id="RecipientRowTemplate" class="hide">
                                <div class="lead-alert-col lead-alert-data" id="#rcp_ROWID#">
                                    <div class="row">
                                        <div class="col-sm-4"><h4 class="lead-alert-email-address">#EMAIL#</h4></div>
                                        <div class="col-sm-4"><h4 class="lead-alert-cell">#CELL#</h4></div>
                                        <div class="col-sm-4">
                                            <h5 class="lead-alert-action">
                                                <a href="#" data-rid="#EDIT-ROWID#" data-id="#EDIT-GIID#" data-frkey="#FUNNEL-LP-RECKEY#" data-email="#EMAIL2#" data-cell="#CELL2#" data-carrier="#CARRIER#" data-text="Edit" class="action-btn edit-form edit-recipient"><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                                <a href="#" data-rid="#EDIT-ROWID1#" data-id="#DELETE-GIID1#" data-frkey="#FUNNEL-LP-RECKEY1#" data-clientid="#DELETE-CLIENTID#" class="action-btn del remove-recipient"><i class="fa fa-remove"></i>DELETE</a>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lead-alert-col">
                                <div class="row">
                                    <div class="col-sm-4"><h3 class="lead-alert-caption lead-alert-email-address">Email Address</h3></div>
                                    <div class="col-sm-4"><h3 class="lead-alert-caption lead-alert-cell" >Cell Number</h3></div>
                                    <div class="col-sm-4"><h3 class="lead-alert-caption lead-alert-option">Options</h3></div>
                                </div>
                            </div>

                            @php
                            if(@$view->data->globalrecipients){
                                foreach (@$view->data->globalrecipients as $i=>$recipient){
                                    @endphp
                                    <div class="lead-alert-col lead-alert-data" id="rcp_{{ $recipient['id'] }}">
                                        <div class="row">
                                            <div class="col-sm-4"><h4 class="lead-alert-email-address">{{ $recipient['email_address'] }}<em>{{ ($recipient['is_primary']=='y' ? " (Primary)" : "") }}</em></h4></div>
                                            <div class="col-sm-4"><h4 class="lead-alert-cell">{{ ($recipient['phone_number'] != "" ? $recipient['phone_number'] : "-") }}</h4></div>
                                            <div class="col-sm-4">
                                                <h5 class="lead-alert-action">
                                                    <a href="#" data-id="{{ $recipient['gid'] }}" data-frkey="{{ $recipient["fkeys"] }}" data-email="{{ $recipient['email_address'] }}" data-cell="{{ $recipient['phone_number'] }}" data-carrier="{{ $recipient['carrier'] }}" data-text="Edit" class="action-btn edit-form edit-recipient"><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                                    @if($recipient['is_primary'] == 'n')
                                                        <a href="#" data-rid="{{ $recipient['id'] }}" data-id="{{ $recipient['gid'] }}" data-frkey="{{ $recipient["fkeys"] }}" data-clientid="{{ $recipient['client_id'] }}" class="action-btn del remove-recipient"><i class="fa fa-remove"></i>DELETE</a>
                                                        @endif
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                }
                            }else{
                                @endphp
                                <div class="lead-alert-col lead-alert-data" id="0" style="border: none;">
                                </div>
                                @php
                            }
                            @endphp
                        </div>
                    </form>
			</div>
			<div id="integration" class="tab-pane fade @if(@$view->data->action=='integration') {{ ' in active' }} @endif">

                <div id="clip-msg"></div>
                <div class="panel-group" id="accordions">

                    <!-- Zapier Accordion -->
                    <div class="panel custom-accordion integration-panel">
                        <div class="panel-heading">
                            <div class="lp-domain-wrapper int-head">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordions" href="#collapse2">
										<i class="lp_radio_icon_lg"></i>
										Zapier Integration
									</a>
                                </h4>
                            </div>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse in">
                            <div class="">
                                <div class="tab-title">
                                    <p>- To integrate Zapier with leadPops Funnels you need an authorization token for your account.</p>
                                    <p>- While creating a Zap, this authorization token will be asked by Zapier to identify your account.</p>
                                </div>
                                <div>
                                    <div class="item-wrapp">
                                        <div class="input-wrapp">
                                            <div class="lp-seo">
                                                <div class="lp-seo-head">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="col-left">
                                                                <h2 class="lp-heading-2">Zapier Authorization Key</h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="lp-seo-box lp-int-box">
                                                                <input disabled class="lp-tg-textbox valid" id="zapier_access_key" value="{{ (@$view->data->clientToken ? @$view->data->clientToken : "") }}" aria-required="true" aria-invalid="false" readonly type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="lp-seo-box__ integration__">
                                                                <a href="#" id="zapierKeyBtn" class="btn lp-btn-success">{{ (@$view->data->clientToken ? "Re-Generate Key" : "Generate Key") }}</a>
                                                                <a href="#" id="zapierKeyBtn_copy" class="btn lp-btn-primary">Copy to Clipboard</a>
                                                                <input type="hidden" name="zapier_integrations" id="zapier_integrations" value="{{ @$view->data->integrations }}" />
                                                                <a href="#" data-toggle="modal" class="btn lp-btn-success zapier-funnel-selector lp-secondary-clr" data-target="#funnel-selector"><i class="fa fa-cog"></i> Select Funnels for Zapier</a>

                                                                <a href="#" data-toggle="modal" class="btn lp-btn-success zapier-funnel-selector lp-secondary-clr" data-target="#lp_zap_templates"><i class="fa fa-cog"></i> Pre-configured Zaps</a>
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
                    <!-- Zapier Accordion - Ends -->

                    <!-- leadPops Auathorization Accordion -->
                    <div class="panel custom-accordion">
                        <div class="panel-heading">
                            <div class="lp-domain-wrapper integration-head">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordions" href="#collapse1">
                                        <i class="lp_radio_icon_lg"></i>
                                        leadPops API Authorization Key
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="item-wrapp">
                                <div class="input-wrapp">
                                    <div class="lp-seo integration">
                                        <div class="lp-seo-head">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="lp-seo-box integration">
                                                        <input disabled class="lp-tg-textbox valid" id="lp_auth_access_key" value="{{ (@$view->data->LeadpopAccessToken ? @$view->data->LeadpopAccessToken : "") }}" aria-required="true" aria-invalid="false" readonly type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="lp-seo-box__ integration__">
                                                        <a href="#" id="lp_auth_access_btn" class="btn lp-btn-success">{{ (@$view->data->LeadpopAccessToken ? "Re-Generate Key" : "Generate Key") }}</a>
                                                        <a href="#" id="lp_auth_access_code_copy" class="btn lp-btn-primary">Copy to Clipboard</a>
                                                        <a class="btn btn-small lp-btn-success lp-secondary-clr" target="_blank" href="https://documenter.getpostman.com/view/140573/leadpops-leads-api-production/6fbSMwY">leadPops API Documentation</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- leadPops Auathorization Accordion - Ends -->

                    <!-- TotalExpert Accordion -->
                    <div class="panel custom-accordion">
                        <input type="hidden" name="te_activated" id="te_activated" value="{{ $teHasActivated }}">
                        <input type="hidden" name="te_status" id="te_status" value="{{ $teCurrentStatus }}">
                        <div class="panel-heading">
                            <div class="lp-domain-wrapper integration-head">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordions" href="#collapseTotalExpert">
                                        <i class="lp_radio_icon_lg"></i>
                                        Total Expert Integration <span style="color: #ff6666">{{  @$_SESSION["totalExpertError"] }}</span>
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <div id="collapseTotalExpert" class="panel-collapse collapse">
                            <div class="item-wrapp">
                                <div class="input-wrapp">
                                    <div class="lp-seo integration">
                                        <div class="lp-seo-head">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="custom-btn-toggle total-expert-container">
                                                        <input id="totalExpertActiveDeactiveBtn" {{ $active_inactive_checked }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                                        @php
                                                        $scope = "postLeads+leadSurveyInteraction";
                                                        $session_id = session()->getId();
                                                        @endphp
                                                        <div style="display: none; float:right; border: 1px solid #ff6666"><a id="teactivate" style="color: #000 !important; transition: none !important;" href="https://public.totalexpert.net/v1/authorize?response_type=code&client_id=leadpops&scope={{  $scope }}&state={{ $session_id }}">For Surveys Click Here</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- TotalExpert Accordion - Ends -->

                </div>
			</div>
            <div id="ada" class="tab-pane fade @if(@$view->data->action=='ada') {{ ' in active' }} @endif">
                <form name="ada-accessibility" id="adaAccessibilityForm" class="form-inline" method="POST" action="{{ LP_BASE_URL.LP_PATH.'/global/updateAdaAccessibility' }}">
                    {{csrf_field()}}
                    <input type="hidden" name="lpkey_ada_accessibility" id="lpkey_ada_accessibility" value="">
                    <input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">
                    <div class="lp-cta global-space ada_accessibility">
                        <div class="ada_accessibility__holder">
                            <div class="row">
                                <div class="col col-md-6">
                                    <div class="form-group">
                                        <div class="input-wrap custom-radio-btn">
                                            <input name="is_ada_accessibility" value="0" type="radio">
                                            <label for="inactive" class="fake-radio inactive">
                                                <strong class="fake-radio__holder">
                                                    <strong class="radio-text">Inactive</strong>
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-md-6">
                                    <div class="form-group">
                                        <div class="input-wrap custom-radio-btn">
                                            <input name="is_ada_accessibility" value="1" type="radio">
                                            <label for="active" class="fake-radio">
                                                <strong class="fake-radio__holder">
                                                    <strong class="logo">
                                                        <img src="<?php LP_BASE_URL;?>/lp_assets/adminimages/ada-complaint.png" alt="ada complaint">
                                                    </strong>
                                                    <strong class="radio-text">Active</strong>
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="lp-save">
                                    <div class="custom-btn-success">
                                        <button type="button" onclick="javascript:updateAdaAccessibility()" class="btn btn-success"><strong>SAVE</strong></button>
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
<!-- Model Boxes - Domain Delete - Start -->
<div id="modal_delete_domain" class="modal fade lp-modal-box in">
    <div class="modal-dialog">
        <div class="modal-content modal-action-header">
            <div class="modal-header modal-action-title">
                <h3 class="modal-title">Delete Confirmation</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-sm-12 modal-action-msg-wrap">
                            <div class="modal-msg"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-modal-footer lp-modal-action-footer">
                <a data-dismiss="modal" class="btn lp-btn-cancel btnCancel_confirmReciDelete">Close</a>
                <a class="btn lp-btn-add _delete_btn">Delete</a>&nbsp;
            </div>
        </div>
    </div>
</div>
<!--****************Global logo DELETE POPUP HTML*****************-->
<div class="modal fade add_recipient home_popup" id="deletegloballogo" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Delete Logo</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-md-12 modal-action-msg-wrap">
                            <div class="popup-wrapper modal-msg">
                                <div class="funnel-message">Are you sure to delete this logo?</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-modal-footer footer-border lp-modal-action-footer">
                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                    <input type="button" class="btn lp-btn-add" id="deletethegloballogo" value ="delete">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade add_recipient home_popup" id="gresetfeaturedimg" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content ">
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
                <div class="lp-modal-footer footer-border lp-modal-action-footer">
                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                    <input type="button" class="btn lp-btn-add" id="gcancelfimgbtn" value ="Reset">
                </div>
            </div>
        </div>
    </div>
</div>
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
                    <input id="client_id_confirmPixelDelete" type="hidden" value="{{ @$view->data->client_id }}" />
                </form>
                <a data-dismiss="modal" class="btn action-btn btnCancel_confirmPixelDelete lp-btn-cancel">Close</a>
                <a class="btn action-btn lp-btn-add btnAction_confirmPixelDelete">Delete</a>&nbsp;
            </div>
        </div>
    </div>
</div>
<!-- PIXEL DELETE POPUP - End -->
    <!-- Model Boxes - Domain Delete - Start -->
    <div id="modal_reset_default" class="modal fade lp-modal-box in">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title">Reset To Defualt Footer Content</h3>
                </div>
                <div class="modal-body model-action-body">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-sm-12 modal-action-msg-wrap">
                                <div class="modal-msg"></div>
                                <input type="hidden" id="_delete_domain_id" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-modal-footer lp-modal-action-footer">
                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                    <a id="_reset_default_btn" class="btn lp-btn-add">Yes</a>&nbsp;
                </div>
            </div>
        </div>
    </div>
    <!-- Model Boxes - Domain Delete - End -->
@include('partials.watch_video_popup')
@include('partials.funnelselector')
@endsection
