@extends("layouts.leadpops")

@section('content')
    @php
    if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
        $firstkey = @$view->data->clickedkey;
    }else {
        $firstkey = "";
    }

    $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
    $logocnt = (isset($view->data->logos['src']))?count(@$view->data->logos['src']):0;
    @endphp
    <div class="container">
        @php  LP_Helper::getInstance()->getFunnelHeader($view); @endphp
        <img src="" id="temporary_image" name="temporary_image" style="display:none">

        <form class="form-inline" id="fuploadload"
              enctype="multipart/form-data"
              action=""
              class="global-content-form"
              data-action="{{ LP_BASE_URL.LP_PATH."/popadmin/uploadlogo/".@$view->data->currenthash }}"
              data-global_action="{{ route('uploadGlobalLogoAdminThree')}}"
              method="POST">
            {{csrf_field()}}
            // uploadGlobalLogoAdminThree
            <input type="hidden" name="swatches" id="swatches" value="">
            <input type="hidden" name="key" id="key" value="{{ @$view->data->key }}">
            <input type="hidden" name="scope" id="scope" value="">
            <input type="hidden" name="logocnt" id="logocnt" value="{{ $logocnt }}">
            @php
            $_funnel_data=json_encode(@$view->data->funnelData,JSON_HEX_APOS);
            @endphp
            <input type="hidden" name="funneldata" id="funneldata" value='{{ $_funnel_data }}'>
            <input type="hidden" name="theselectiontype" id="theselectiontype" value="logo">
            <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
            <input type="hidden" name="logo_source" id="logo_source" value="{{ @$view->data->logoids['use'] }}">
            <input type="hidden" name="stocklogopath" id="stocklogopath" value="{{ @$view->data->stocklogopath }}">
            <input type="hidden" name="logo_id" id="logo_id" value="{{ @$view->data->logoids['id'] }}">
            @if (@$view->data->client_id == 1348)
            <input type="hidden" name="bgimage_active" id="bgimage_active" value="{{ @$view->data->bgimage_active }}">
            <input type="hidden" name="keepbgimage" id="keepbgimage" value="">
            @endif
            <input type="hidden" name="badlogo" id="badlogo" value="{{ @$view->data->badupload }}">
            <input type="hidden" name="firstkey" id="firstkey" value="{{ $firstkey }}">
            <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $firstkey }}">
            <input type="hidden" name="treecookie" id="treecookie" value="{{ $treecookie }}">
            <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
            <input type="hidden" name="logouploaded" id="logouploaded" value="{{ @$view->data->logouploaded }}">
            <input type="hidden" name="uploadlogotype" id="uploadlogotype" value="">
            <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">


            <div class="inner-page-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="lp-default-logo" id="lp-default-logo">
                            <div class="col-left-logo">
                                <h2 class="lp-heading-logo">Default Logo</h2>
                            </div>
                            <div class="logo-default-img img-content-logo" >
                                <span class="helper"></span>
                                <img  rel="stock" class="logo-img" id="{{ @$view->data->stocklogoid }}" data-swatches="{{ @$view->data->stocklogoswatches }}" src="{{ @$view->data->stocklogosource }}">
                            </div>
                            <div class="note no-border">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="lp-default-logo" id="droppable-photos-container-logo">
                            <div class="col-left-logo">
                                <h2 class="lp-heading-logo">Current Logo</h2>
                            </div>
                            <div id="lp-logo-default-img" class="logo-default-img" >
                                <span class="helper"></span>
                                @php
                                $selected_logo_src = \View_Helper::getInstance()->getCurrentLogoImageSource(@$view->data->client_id,0,@$view->data->funnelData);

                                if($selected_logo_src!=""){
                                $style = "";
                               }else{
                                    $selected_logo_src = @$view->data->stocklogosource;
                                }
                                @endphp
                                <img id="currentdropimagelogo" class="abc" src="{{ $selected_logo_src }}" >
                            </div>
                            <div class="note">Click and drag the logo of your choice from below into this box</div>
                        </div>
                    </div>
                </div>
                <div class="lp-logo">
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
                                        Browse <input type="file" accept="image/*"  name="logo" id="logo" style="display: none;">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="logo-main-wrapper">
                        <div class="row">
                            @php if($logocnt == 0 ) { @endphp
                            <div class="col-xs-12" >
                                <div class="bluetextheadleft">
                                    <br />
                                    To upload a logo:<br /><br />
                                    1. Click "Browse" to select your logo, then click "Upload."<br /><br />
                                    2. Next, simply drag and drop your logo into the box that <br />
                                    says "Current Logo", then click "Save New Logo."<br />
                                </div>
                            </div>
                            @php
                            }
                            else
                            {
                                for($i=0; $i<$logocnt; $i++) {
                                    list($logowidth, $logoheight) = @getimagesize(@$view->data->logos['src'][$i]);
                                    $logomarginleft = round((351-$logowidth) / 2);
                            @endphp
                            <div class="col-md-4" >
                                <div class="sub-logo-wrapper">
                                    <div id="droppablePhotosLogo" style=" zoom:1;">
                                        <div class="upload-logo-left droppable-gallery-logo">
                                            <div class="left img-content-logo" id="lp-cur-logo-{{ $i }}" >
                                                <div class="logo-wrapper logo-wrapper-margin">
                                                    <span class="helper"></span>
                                                    <img rel="client" class="lp-fun-logo-img1 logodes" id="{{ @$view->data->logos['id'][$i] }}" src="{{ @$view->data->logos['src'][$i] }}" data-swatches="{{ @$view->data->logos['swatches'][$i] }}" alt="Image File not found">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center" id="glogowrap">
                                        <button type="button" id="logodesdel" class="btn btn-danger" onclick='deletelogo("{{ @$view->data->logos['id'][$i] }}")' ><strong>DELETE</strong></button>
                                    </div>
                                </div>
                            </div>
                            @php
                                }
                            }
                            @endphp
                        </div>
                    </div>
                </div>
                <div class="lp-thankyou">
                    <div class="lp-thankyou-head">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="col-collapse"><h2  class="footer-head-color">Co-Marketing Logo Combinator</h2></div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-right">
                                    <a href="#primary-footer" data-toggle="collapse" id="lp-footer-collapse" class="lp-footer-collapse footer-expand"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="primary-footer" class="collapse">
                        <div class="logo-main-wrapper">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner-wraper" >
                                        <div id="droppablePhotosLogo" style=" zoom:1;">
                                            <div class="upload-logo-left droppable-gallery-logo">
                                                <div class="left img-content-logo" id="" >
                                                    <div id= "comb-logo-wrapper" class="logo-wrapper logo-wrapper-margin">
                                                        <div class="comb-logo-inner-wrapper">
                                                            <div class="image-upload">
                                                                <label for="pre-image">

                                                                    @if(env('APP_ENV') === config('app.env_local'))
                                                                        <img class = "pre-image" src="{{ asset('/lp_assets/upload-image.png') }}"/>
                                                                    @else
                                                                        <img class = "pre-image" src="{{ secure_asset('/lp_assets/upload-image.png') }}"/>
                                                                    @endif

                                                                </label>
                                                                <input type="file" accept="image/*" name="pre-image" id="pre-image" data-image = 'pre-image' onclick="fileClicked(event)" onchange="fileChanged(event)"/>
                                                                <input type="hidden" name="pre-image-style" id="pre-image-style" value=""/>
                                                            </div>
                                                            <div class="image-divider"></div>
                                                            <div class="image-upload">
                                                                <label for="post-image">

                                                                    @if(env('APP_ENV') === config('app.env_local'))
                                                                        <img class = "post-image" src="{{ asset('/lp_assets/upload-image.png') }}"/>
                                                                    @else
                                                                        <img class = "post-image" src="{{ secure_asset('/lp_assets/upload-image.png') }}"/>
                                                                    @endif

                                                                </label>
                                                                <input type="file" accept="image/*"  name="post-image" id="post-image" data-image = 'post-image' onclick="fileClicked(event)" onchange="fileChanged(event)"/>
                                                                <input type="hidden" name="post-image-style" id="post-image-style" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-md-offset-3 slider-wrapper">
                                            <div class="col-md-6">
                                                <input id="ex1" data-slider-id='ex1Slider' data-slider-min='' data-slider-max='' type="text"/>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="ex2" data-slider-id='ex1Slider' type="text"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center combinelogo-wrapper" id="glogowrap">
                                            <button type="button" id="combinelogo" class="btn btn-info" onclick='combinelogos()' ><strong>Combine</strong></button>
                                            <!-- <button type="button" id="swaplogos" class="btn btn-info" onclick='swaplogos()' ><strong>Swap Logos</strong></button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-save">
                    <div class="custom-btn-success">
                        <button type="button" onclick="changelogo();" class="btn btn-success"><strong>SAVE</strong></button>
                    </div>
                </div>
            </div>


        </form>


    </div>
    @include('partials.watch_video_popup')
@endsection
