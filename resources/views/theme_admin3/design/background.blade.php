@extends("layouts.leadpops-inner-sidebar")
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

        $overlay_opacity = (int)(isset($overlay_opacity) ? $overlay_opacity : 50);

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
        // Was showing null into selected color, to fix the issue added condition, default color #ffffff
        $background_custom_color = in_array(@$view->data->backgroungOptions[0]['background_custom_color'], ["", "null", null]) ? '#FFFFFF' : @$view->data->backgroungOptions[0]['background_custom_color'];
        $color_mode = @$view->data->backgroungOptions[0]['color_mode'];
        $background_overlay_opacity = (int)(@$view->data->backgroungOptions[0]['background_overlay_opacity'] ? @$view->data->backgroungOptions[0]['background_overlay_opacity'] : 50 );
        $selected_logo_color = @$view->data->backgroungOptions[0]['background_color'];
        if(strpos($selected_logo_color,'background-image:') != false){
         list($a,$b) =  explode('background-image:',$selected_logo_color);
         $b = str_replace('; /* W3C */','',$b);
         $selected_logo_color = trim(str_replace('right ','',$b));
        }
        $previously_used_colors = json_decode(@$view->data->backgroungOptions[0]['previously_used_colors']);
        $previously_used_colors = $previously_used_colors?array_reverse($previously_used_colors):[];
        $rgbacolor = 'rgba(255,255,255,0.5)';
        if(@$view->data->backgroungOptions[0]['background_overlay']){
            $rgbacolor = \View_Helper::getInstance()->hex2rgb(@$view->data->backgroungOptions[0]['background_overlay']);
            $rgbacolor = 'rgba('.$rgbacolor[0].','.$rgbacolor[1].','.$rgbacolor[2].','.($overlay_opacity/100).')';
        }

        switch ($background_type_vale){
            case config('background.color_option.pull_logo_color'):
                $current_active = 'auto-pull';
                break;
            case config('background.color_option.upload_background_image'):
                $current_active = 'background';
                break;
            case config('background.color_option.customize_own_color'):
                $current_active = 'customize';
                break;
            default:
                $current_active = 'background';
        }
        $background_image_url = $view->data->backgroungOptions[0]["bgimage_url"];
        $checked=$view->data->backgroungOptions[0]['active_overlay']=='y'?'checked':"";
        $_funnel_data = json_encode($view->data->funnelData, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS);
    /*    echo "<pre>";
    print_r($view->data->backgroungOptions);
       echo "</pre>";*/
    @endphp
    <form role="form" class="form-horizontal" method="post" action="#">
        @csrf
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
        <input type="hidden" name="background_custom_color" id="background_custom_color" value="{{$background_custom_color}}">
        <input type="hidden" name="saved_color_mode" id="saved_color_mode" value="{{$color_mode}}">
        <input type="hidden" name="background_type" id="background_type" value="1">
    </form>
    <main class="main">
        <section class="main-content" id="page-background">
            <!-- Title wrap of the page -->
            @php
                LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view, null, config('background.background_tabs'));
            @endphp
            @include("partials.flashmsgs")
                <div class="tab-content">
                    <div id="main" class="tab-pane active">
                        <div class="card background-card {{$current_active=='background'?'active':''}}">
                            <div class="card-header">
                                <div class="card-link-wrap">
                                    <label class="card-link">
                                        <input type="radio" name="background-radio" value="background" @if($current_active=='background') checked @endif />
                                        <span class="card-circle"></span>
                                        <span class="h2 card-title">
                                            <span>Upload a</span> Background Image
                                            <span class="bg__el-tooltip" data-tooltip-content="#tooltip_content" title="Suggested background &#34;Cover&#34; image dimensions:<br> 1920 width x 1080 height.<br> Recommended size: smaller than {{(config('validation.background_image_size')/1024)}} MB.<br> Use this free service: <a class='lp-tp-btn' href='http://www.TinyPNG.com' target='_blank'> www.TinyPNG.com </a> to compress<br> images prior to upload to reduce load time.">
                                                <img src="{{ config('view.rackspace_default_images') }}/ttip.png" alt="ttip">
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div id="bgImagePage" class="background-slide" data-parent="#main" {{$current_active=='background'?'style=display:block':''}}>
                                <div class="card-body">
                                    <div class="browse__content">
                                        <input type="hidden" name="background_type_vale" id="background_type_vale"
                                               value="@php echo $background_type_vale;@endphp">
                                        <form id="background_form"  role="form" style="width: 100%"
                                              enctype="multipart/form-data"
                                              action=""
                                              class="global-content-form"
                                              data-action="{{ LP_BASE_URL.LP_PATH."/popadmin/updatebackgroundimage/".@$view->data->currenthash }}"
                                              data-global_action="{{ route('updateGlobalBackgroundImageAdminThree')}}"
                                              method="POST">
                                            {{--@csrf--}}
                                            {{ csrf_field() }}
                                            <input type="hidden" name="background_type" id="background_type" value="3">
                                            <input type="hidden" id="bg-option-image-url" name="bg-option-image-url" value="{{ @$view->data->backgroungOptions[0]["bgimage_url"] }}">
                                            <input type="hidden" id="image-url" name="image-url" class="image-url" value="{{ @$view->data->backgroungOptions[0]["bgimage_url"] }}">
                                            <!-- Background color opacity -->
                                            <input type="hidden" id="bgPageOverlay_color_opacity" name="overlay_color_opacity" value="{{$overlay_opacity}}">
                                            <!-- Background color overlay -->
                                            <input type="hidden" id="bgPageImg-overlay" name="background-overlay" value="{{ @$view->data->backgroungOptions[0]["background_overlay"] }}" data-form-field data-ignore-case>
                                            <!-- Own color hidden inputs -->
                                            <input type="hidden" id="bgPage-modeowncolor-hex" name="" value="#34409E">
                                            <input type="hidden" id="bgPage-modeowncolor-rgb" name="" value="52, 64, 158">
                                            <input type="hidden" id="client_id" name="client_id" value="{{ @$view->data->client_id }}">
                                            <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">

                                            <div class="browse__step1" style="{{$background_image_url?'display: none;':'display: block;'}}">
                                                <div class="browse__desc">
                                                    <p>
                                                        You haven't added any background image yet.
                                                    </p>
                                                    <div class="lp-image__browse">
                                                        Click
                                                        <label class="lp-image__button" for="Pagebrowse_img2">

                                                            {{--<input id="Pagebrowse_img1" name="background_name" class="lp-image__input" type="file" accept="image/*">--}}
                                                            Browse
                                                        </label>
                                                        to start uploading.
                                                    </div>
                                                    <div class="file__control">
                                                        <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                        <p class="file__size">Maximum file size limit is 4MB.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="browse__step2" style="{{$background_image_url?'display: block;':'display: none;'}}">
                                            <div class="bg__wrapper">
                                                <div class="bg__image">
                                                        <div class="browse__bg-image" id="previewbox" style="{{$background_image_url?"background-image:url('".$background_image_url."');":''}}">
                                                        <div id="bgPagePreview-overlay" class="bg-image"></div>
                                                        <div class="action">
                                                            <ul class="action__list">
                                                                <li class="action__item del__img" id="background_image_delete" style="display: none;">
                                                                    <button type="button" class="btn-image__del button button-cancel">
                                                                        delete
                                                                    </button>
                                                                </li>
                                                                <li class="action__item">
                                                                    <div class="lp-image__browse">
                                                                        <label class="button button-primary" for="Pagebrowse_img2">
                                                                            <input id="Pagebrowse_img2" name="background_name" class="lp-image__input" type="file" accept="image/*" data-form-field>
                                                                            Browse
                                                                        </label>
                                                                    </div>
                                                                    <div class="file__control">
                                                                        <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                                        <p class="file__size">The file is too large. Maximum allowed file size is {{(config('validation.background_image_size')/1024)}}MB.</p>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg__controls">
                                                    <div class="form-group">
                                                        <label for="_bgPage__active-overlay">Background Overlay Color</label>
                                                        <div class="main__control bg__control_overlay-wrapper" id="bgoverly_container">
                                                            <div class="text-color-parent">
                                                                <div class="color-picker bgPageColor-picker__overlay" style="   background-color:{{ $rgbacolor }};">
                                                                    <div hidden id="last_selected_code" class="last-selected__code">{{ (@$view->data->backgroungOptions[0]['background_overlay']!="") ? @$view->data->backgroungOptions[0]['background_overlay'] : "#FFFFFF" }}</div>
                                                                </div>
                                                            </div>
                                                            <input id="bgPage__active-overlay" {{$checked}} class="bgoverly global-switch" id="bgoverly" name="bgoverly"
                                                                   data-lpkeys="{{ @$view->data->lpkeys.'~active_overlay' }}"
                                                                   data-toggle="toggle" data-onstyle="active"
                                                                   data-offstyle="inactive" data-width="127" data-height="43"
                                                                   data-on="INACTIVE" data-off="ACTIVE" type="checkbox" data-form-field>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ex2-wrap-bg">
                                                        <label>Overlay Color Opacity
                                                            <span class="question-mark el-tooltip" title="Opacity setting is controlled<br> within the color picker above.">
                                                                <span class="ico ico-question"></span>
                                                            </span>
                                                        </label>
                                                        <div class="main__control">
                                                            <div class="range-slider">
                                                                <div class="input__wrapper ex2-wrap">
                                                                    <input id="bg_image_overlay_opacity" name="overlay_color_opacity" class="form-control bg-image-opacity-slider" data-slider-id="bgImageOpacitySlider" value="{{$overlay_opacity}}" data-value="{{$overlay_opacity}}"  type="text" data-form-field/>
                                                                    <span id="bg-image-opacity" class="opacity-slider-val">{{$overlay_opacity}}%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Background Repeat</label>
                                                        <div class="main__control">
                                                            <div class="select2__bgPage-repeat-parent">
                                                                <select class="select2__bgPage-repeat" background-repeat  name="background-repeat" data-form-field>
                                                                    @foreach (config('background.background_position.background_repeat_select_list') as $select)
                                                                        <option value="{{$select['value']}}" {{($background_repeat==$select['value'])?'selected':''}}>{{$select['title']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Background Position</label>
                                                        <div class="main__control">
                                                            <div class="select2__bgPage-postion-parent select2js__nice-scroll">
                                                                <select class="select2__bgPage-postion" name="background-position" data-form-field>
                                                                    @foreach (config('background.background_position.background_position_select_list') as $select)
                                                                        <option value="{{$select['value']}}" {{($background_position==$select['value'])?'selected':''}}>{{$select['title']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Background Size</label>
                                                        <div class="main__control">
                                                            <div class="select2__bgPage-cover-parent">
                                                                <input type="hidden" id="backgroundsize" name="backgroundsize" value="{{ ($background_size) ? $background_size : '' }}">
                                                                <select class="select2__bgPage-cover" name="background_size" data-form-field>
                                                                    @foreach (config('background.background_position.background_size_select_list') as $select)
                                                                        <option value="{{$select['value']}}" {{($background_size==$select['value'])?'selected':''}}>{{$select['title']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="form-group">
                                                <button type="submit" hidden id="backgroundImageSubmit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card  background-card {{$current_active=='customize'?'active':''}}">
                            <div class="card-header">
                                <div class="card-link-wrap">
                                    <label class="card-link">
                                        <input type="radio" name="background-radio" value="customize" @if($current_active=='customize') checked @endif />
                                        <span class="card-circle"></span>
                                        <span class="h2 card-title"><span>Customize Your</span> Own Colors</span>
                                    </label>
                                </div>
                            </div>
                            <div id="bgOwnColorPage" class="background-slide" data-parent="#main" {{$current_active=='customize'?'style=display:block':''}}>
                                <div class="card-body">
                                    <form role="form"
                                        id="ownColorsForm"
                                        class="form-horizontal global-content-form"
                                        method="post"
                                        data-action="{{ route('update-background-customized-color') }}"
                                        data-global_action="{{ route('updateGlobalCustomizedColorAdminThree') }}"
                                        action="#">
                                        @csrf
                                        <input type="hidden" name="client_id" value="{{ @$view->data->client_id }}">
                                        <input type="hidden" name="current_hash" value="{{ @$view->data->currenthash }}">
                                        <input type="hidden" name="background_type" value="2">
                                        <input  name="hexcolor" type="hidden">

                                        <div class="owncolor">
                                            <div class="owncolor__wrapper">
                                                <div class="bgPageowncolor__box owncolor__box"></div>
                                                <div class="owncolor__info">
                                                    <label for="selectedcolor">Selected Color</label>
                                                    <div class="last-selected">
                                                        <div class="last-selected__box"></div>
                                                        <input type="text" class="last-selected__code" id="customize_last_selected" value="{{ $background_custom_color }}" maxlength="7" style="border: none;" data-form-field data-ignore-case>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="owncolor__controls">
                                                <div class="head">
                                                    <h2>Add custom color code</h2>
                                                </div>
                                                <div class="owncolor__inner">
                                                    <div class="form-group">
                                                        <label>Color Mode</label>
                                                        <div class="main__control">
                                                            <div class="select2__bgPage-colormode-parent">
                                                                <select class="select2__bgPage-colormode" name="colorMode" id="colorMode" data-form-field>
                                                                    <option value="{{config('background.color_option.mode_hex')}}" {{($color_mode == config('background.color_option.mode_hex')?'selected':'')}}>HEX</option>
                                                                    <option value="{{config('background.color_option.mode_rgb')}}" {{($color_mode == config('background.color_option.mode_rgb')?'selected':'')}}>RGB</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bgPage-colorval">Color Value</label>
                                                        <div class="main__control">
                                                            <input id="bgPage-colorval" class="form-control" name="colorValue" type="text" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="background_overlay_opacity">Background Color Opacity</label>
                                                        <div class="main__control">
                                                            <div class="range-slider">
                                                                <div class="input__wrapper ex2-wrap">
                                                                    <input id="background_overlay_opacity" name="background_overlay_opacity" class="form-control own-color-opacity-slider" data-slider-id="ownColorOpacitySlider" value="{{$background_overlay_opacity}}" data-value="{{$background_overlay_opacity}}"  type="text" data-form-field/>
                                                                    <span id="own-color-opacity" class="opacity-slider-val">{{$background_overlay_opacity}}%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card  background-card {{$current_active=='auto-pull'?'active':''}}">
                            <div class="card-header">
                                <div class="card-link-wrap">
                                    <label class="card-link">
                                        <input type="radio" name="background-radio" value="auto-pull" @if($current_active=='auto-pull') checked @endif />
                                        <span class="card-circle"></span>
                                        <span class="h2 card-title"><span>Automatically Pull</span> Logo Colors</span>
                                    </label>
                                </div>
                            </div>
                            <div id="bgLogoColorPage" class="background-slide" data-parent="#main" {{$current_active=='auto-pull'?'style=display:block':''}}>
                                <input type="hidden" name="swatches" value="{{ @$view->data->backgroungSwatches}}">
                                <form role="form"
                                    id="bgLogoColorPageForm"
                                    class="form-horizontal global-content-form"
                                    method="post"
                                    data-action="{{ route('updatebackgroundcolors') }}"
                                    data-global_action="{{ route('setAutoPulledLogoColorAdminThree') }}"
                                    action="">
                                    @csrf
                                    <input type="hidden" name="client_id" value="{{ @$view->data->client_id }}">
                                    <input type="hidden" name="current_hash" value="{{ @$view->data->currenthash }}">
                                    <input type="hidden" name="background_type" value="1">
                                    <input type="hidden" name="background" value="">
                                    <input type="hidden" name="fontcolor" value="">
                                    <input type="hidden" name="swatchnumber" id="swatchnumber" value="" data-form-field>
                                    <input type="hidden" name="range" value="thedomain">
                                    <div class="card-body">
                                        <div class="card-body__row">
                                            <div id="logo-colors" >
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer of the page -->
                <div class="footer">
                    @include("partials.footerlogo")
                </div>
        </section>
    </main>

    <!-- main tab color picker -->
    <div class="color-box__panel-wrapper main-bg-clr">
        <div class="picker-block" id="mian-bg-colorpicker">
        </div>
        <label class="color-box__label">Add custom color code</label>
        <div class="color-box__panel-rgb-wrapper">
            <div class="color-box__r">
                R: <input class="color-box__rgb" value="106"/>
            </div>
            <div class="color-box__g">
                G: <input class="color-box__rgb" value="153"/>
            </div>
            <div class="color-box__b">
                B: <input class="color-box__rgb" value="148"/>
            </div>
        </div>
        <div class="color-box__panel-hex-wrapper">
            <label class="color-box__hex-label">Hex code:</label>
            <input class="color-box__hex-block" value="#6a9994" maxlength="7"/>
        </div>
    </div>
@endsection
@push('footerScripts')
    <script>


        var validExtensions = ['.png', '.jpg', '.jpeg'];

        function isValidExtension(path){
            path= path.toLowerCase();
            let found = false;
            validExtensions.forEach(function(extension){
                if(path.indexOf(extension)>-1){
                    found = true;
                }
            })
            return found;
        }

        let hasImage = {{$background_image_url?'true':"false"}};
        let imagePath = "{{$background_image_url}}";

        // hasImage = isValidExtension(imagePath);

        let background_overlay_opacity = {{$background_overlay_opacity}};
        let overlay = {{$checked?'true':'false'}};
        let funnel_data = @php echo $_funnel_data; @endphp;
        let swatches = [];
        let selectedSwatch = `{{$selected_logo_color}}`;
        let backgroundOverlayColor = '{{ (@$view->data->backgroungOptions[0]['background_overlay']!="") ? @$view->data->backgroungOptions[0]['background_overlay'] : "#FFFFFF" }}';
        let defaultBackgroundImageURL = "{{$background_image_url?$background_image_url:''}}";
    </script>
    <script src="{{ config('view.theme_assets') }}/pages/background.js?v={{ LP_VERSION }}"></script>


@endpush
