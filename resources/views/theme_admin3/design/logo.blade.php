@extends("layouts.leadpops-inner-sidebar")

@section('content')
    @php
        $firstkey = (isset($view->data->clickedkey))?@$view->data->clickedkey:'';
        $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
        $logocnt = (isset($view->data->logos['src']))?count(@$view->data->logos['src']):0;
        $logo_image_size = (config('validation.logo_image_size') / 1024);
        $selected_logo_src = \View_Helper::getInstance()->getFunnelCurrentLogo(@$view->data->funnelData, @$view->data->stocklogosource);
    @endphp
    <main class="main">
        <section class="main-content">
            @php
                LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view);
            @endphp
            @include("partials.flashmsgs")
            <form id="fuploadload" enctype="multipart/form-data"
                  action=""
                  class="global-content-form"
                  data-action="{{ LP_BASE_URL.LP_PATH."/popadmin/uploadlogo/".@$view->data->currenthash }}"
                  data-global_action="{{ route('uploadGlobalLogoAdminThree')}}"
                  method="POST">
                @csrf
                <input type="hidden" name="swatches" id="swatches" value="">
                <input type="hidden" name="key" id="key" value="{{ @$view->data->key }}">
                <input type="hidden" name="scope" id="scope" value="">
                <input type="hidden" name="logocnt" id="logocnt" value="{{ $logocnt }}">
                <input type="hidden" name="theselectiontype" id="theselectiontype" value="logo">
                <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
                <input type="hidden" name="logo_source" id="logo_source" value="{{ @$selected_logo_src['use'] }}">
                <input type="hidden" name="stocklogopath" id="stocklogopath" value="{{ @$view->data->stocklogopath }}">
                <input type="hidden" name="logo_id" id="logo_id" value="{{ @$selected_logo_src['id'] }}">
                <input type="hidden" name="currentLogoSource" id="currentLogoSource" value="{{$selected_logo_src["logosrc"]}}" data-form-field>
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
                <input type="hidden" name="uploadlogotype" id="uploadlogotype" value="" data-val="" data-global_val="uploadlogo" class="global-input-text">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                <input type="hidden" name="scaling_defaultHeightPercentage" id="scaling_defaultHeightPercentage" value="{{ $selected_logo_src["scaling_defaultHeightPercentage"]}}">
                <input type="hidden" name="scaling_maxHeightPx" id="scaling_maxHeightPx" value="{{ $selected_logo_src["scaling_maxHeightPx"]}}">
                <input type="hidden" name="current_logo_height" id="current_logo_height" value="{{ $selected_logo_src["current_logo_height"]}}">

                <!-- content of the page -->
                <div class="row logo-row">
                    <div class="col mb-1">
                        <div class="lp-panel mb-4">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Default Logo
                                    </h2>
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <div class="logo__wrapper">
                                    <div class="logo__body">
                                        <div class="img-content-logo" data-id="{{ @$view->data->stocklogoid }}" data-logo>
                                            <img rel="stock" class="logo-img" id="{{ @$view->data->stocklogoid }}"
                                                 src="{{ @$view->data->stocklogosource }}"
                                                 data-swatches="{{ @$view->data->stocklogoswatches }}"
                                                 data-height="{{ config('leadpops.design.logo.defaultHeightPx') }}"
                                                 data-maxHeight="{{ config('leadpops.design.logo.maxAllowedHeightPx') }}"
                                                 alt="Default logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-1">
                        <div class="lp-panel mb-4">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Current Logo
                                        @if(config('app.beta_feature') && in_array($view->data->client_id, config('app.beta_clients')))
                                        <span class="question-mark el-tooltip" title="Maximum logo height is 120px (100%).<br />Minimum logo height is 30px (25%).">
                                            <span class="ico ico-question"></span>
                                        </span>
                                        @endif
                                    </h2>
                                </div>

                                <div class="col-right">
                                    <div class="logo-size-btn-wrap">
                                        <a href="javascript:void(0)" id="reset_logo_size" class="action__link">
                                            <span class="ico ico-undo"></span>
                                        </a>
                                    </div>
                                    <div class="main__control bg__control_slider logo-height-slider-wrap">
                                        <input id="logo-height-slider" data-form-field class="form-control"
                                               data-slider-id='ex1Slider' type="text"/>
                                        <input type="hidden" id="logo-height" value="70">
                                    </div>
                                </div>

                            </div>
                            <div class="lp-panel__body lp-default-logo" id="droppable-photos-container-logo">
                                <div class="logo__wrapper logo-default-img" id="lp-logo-default-img">
                                    <span class="helper"></span>
                                    <img id="currentdropimagelogo" name="logo" style="max-height: {{ $selected_logo_src["current_logo_height"]}}px;" class="logo-img logo-image-wrap" src="{{ $selected_logo_src["logosrc"] }}">
                                </div>
                            </div>
                            <div class="lp-panel__footer drag__info">
                                <p>
                                    Click and drag the logo of your choice from below into this&nbsp;box
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-1">
                        <div class="lp-panel mb-4">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Upload Logos
                                    </h2>
                                </div>
                                <div class="col-right logo__col">
                                    <div class="file__control mr-4">
                                        <p class="file__extension">Invalid image format! image format must be PNG, JPG,
                                            JPEG.</p>
                                        <p class="file__size">The file is too large. Maximum allowed file size
                                            is {{$logo_image_size}}MB.</p>
                                    </div>
                                    {{--<input type="hidden" name="globallogocnt" id="globallogocnt" value="{{ $logocnt }}">--}}
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item">
                                                <div class="lp-image__browse d-flex align-items-center">
                                                    <p class="file-name"></p>
                                                    <label class="button button-primary" for="logo">
                                                        <input id="logo" class="lp-image__input" type="file" name="logo"
                                                               accept="image/*" required="" value="">
                                                        Browse
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <div class="upload-logo__wrapper">
                                    {{--not Global case--}}
                                    <div class="row justify-content-center">
                                        @php
                                            for($i=0; $i<$logocnt; $i++) {
                                                list($logowidth, $logoheight) = @getimagesize(@$view->data->logos['src'][$i]);
                                                $logomarginleft = round((351-$logowidth) / 2);
                                        @endphp

                                        <div class="col-4 p-0" data-id="{{ @$view->data->logos['id'][$i] }}" data-logo>
                                            <div class="upload-logo">
                                                <div class="upload-logo__img">
                                                    <div class="img-content-logo">
                                                        <img class="logo-img" rel="client"
                                                             src="{{ @$view->data->logos['src'][$i] }}"
                                                             id="{{ @$view->data->logos['id'][$i] }}"
                                                             data-swatches="{{ @$view->data->logos['swatches'][$i] }}"
                                                             data-height="{{ config('leadpops.design.logo.defaultHeightPx') }}"
                                                             data-maxHeight="{{ config('leadpops.design.logo.maxAllowedHeightPx') }}"
                                                             style="max-height: {{ config('leadpops.design.logo.maxAllowedHeightPx') }}px"
                                                             alt="Default logo">
                                                    </div>
                                                </div>
                                                <div class="upload-logo__button">
                                                    <button class="button button-cancel del-logo"
                                                            onclick='deletelogo("{{ @$view->data->logos['id'][$i] }}", this)'>
                                                        delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @php } @endphp
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="lp-panel__head border-0 p-0">
                                    <div class="col-left">
                                        <h2 class="card-title">
                                            <span>
                                                Co-Marketing Logo Combinator
                                                <!--<span class="new">(new feature!)</span>-->
                                            </span>
                                        </h2>
                                    </div>
                                    <div class="col-right">
                                        <div class="card-link expandable" data-toggle="collapse"
                                             href="#combinator"></div>
                                    </div>
                                </div>

                            </div>
                            <div id="combinator" class="collapse show">
                                <div class="card-body">
                                    <div class="card-body__row border-0">
                                        <div class="comb__wrapper">
                                            <div class="comb__col">
                                                <div class="file__control mw-100">
                                                    <p class="file__extension">Invalid image format! image format must
                                                        be PNG, JPG, JPEG.</p>
                                                    <p class="file__size">The file is too large. Maximum allowed file
                                                        size is {{$logo_image_size}}MB.</p>
                                                </div>
                                                <div class="upload-drag__wrapper">
                                                    <div class="upload-drag__step1">
                                                        <div class="upload-drag-browse__wrapper">
                                                            <div class="upload-drag-browse__img">
                                                                <img
                                                                    src="{{ config('view.rackspace_default_images') }}/browse-placehlder.png"
                                                                    alt="browse placeholder">
                                                            </div>
                                                            <div class="upload-drag-browse__desc">
                                                                <p>
                                                                    Drag and drop files here to upload. <br>
                                                                    Or <span>browse files</span> from your computer.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="upload-drag__step2">
                                                        <img class="pre-image" src="" alt="">
                                                    </div>
                                                    <input id="comb1" class="upload-drag__file" accept="image/*"
                                                           name="pre-image" type="file">
                                                    <input type="hidden" name="pre-image-style" id="pre-image-style"
                                                           value="">
                                                    <div class="logo-btns-action" style="display: none">
                                                        <ul class="action__list">
                                                            <li class="action__item del-item">
                                                                <button type="button"
                                                                        class="button button-cancel logo-delete">
                                                                    delete
                                                                </button>
                                                            </li>
                                                            <li class="action__item">
                                                                <div class="lp-image__browse">
                                                                    <label class="button button-primary"
                                                                           for="logo_img2">
                                                                        <input id="logo_img2" name="logo_name"
                                                                               class="logo_upload upload-drag__file"
                                                                               type="file" accept="image/*">
                                                                        Browse
                                                                    </label>
                                                                </div>
                                                                <div class="file__control">
                                                                    <p class="file__extension">Invalid image format.
                                                                        Image format must be PNG, JPG, or JPEG.</p>
                                                                    <p class="file__size">The file is too large. Maximum
                                                                        allowed file size
                                                                        is {{(config('validation.background_image_size')/1024)}}
                                                                        MB.</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="comb__col">
                                                <div class="file__control mw-100">
                                                    <p class="file__extension">Invalid image format! image format must
                                                        be PNG, JPG, JPEG.</p>
                                                    <p class="file__size">The file is too large. Maximum allowed file
                                                        size is {{$logo_image_size}}MB.</p>
                                                </div>
                                                <div class="upload-drag__wrapper">
                                                    <div class="upload-drag__step1">
                                                        <div class="upload-drag-browse__wrapper">
                                                            <div class="upload-drag-browse__img">
                                                                <img
                                                                    src="{{ config('view.rackspace_default_images') }}/browse-placehlder.png"
                                                                    alt="browse placeholder">
                                                            </div>
                                                            <div class="upload-drag-browse__desc">
                                                                <p>
                                                                    Drag and drop files here to upload. <br>
                                                                    Or <span>browse files</span> from your computer.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="upload-drag__step2">
                                                        <img class="post-image" src="" alt="">
                                                    </div>
                                                    <input id="comb2" class="upload-drag__file" accept="image/*"
                                                           name="post-image" type="file">
                                                    <input type="hidden" name="post-image-style" id="post-image-style"
                                                           value=""/>
                                                    <div class="logo-btns-action" style="display: none">
                                                        <ul class="action__list">
                                                            <li class="action__item del-item">
                                                                <button type="button"
                                                                        class="button button-cancel logo-delete">
                                                                    delete
                                                                </button>
                                                            </li>
                                                            <li class="action__item">
                                                                <div class="lp-image__browse">
                                                                    <label class="button button-primary"
                                                                           for="logo_img3">
                                                                        <input id="logo_img3" name="logo_name"
                                                                               class="logo_upload upload-drag__file"
                                                                               type="file" accept="image/*">
                                                                        Browse
                                                                    </label>
                                                                </div>
                                                                <div class="file__control">
                                                                    <p class="file__extension">Invalid image format.
                                                                        Image format must be PNG, JPG, or JPEG.</p>
                                                                    <p class="file__size">The file is too large. Maximum
                                                                        allowed file size
                                                                        is {{(config('validation.background_image_size')/1024)}}
                                                                        MB.</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sliders__wrapper">
                                        <div class="comb__wrapper">
                                            <div class="comb__col">
                                                <div class="slider__wrapper">
                                                    <input id="ext1" data-slider-id='ex1Slider' data-slider-min=''
                                                           data-slider-max='' type="text"/>
                                                </div>
                                            </div>
                                            <div class="comb__col">
                                                <div class="slider__wrapper">
                                                    <input id="ex2" data-slider-id='ex1Slider' type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body__row">
                                        <div class="button-control mt-4">
                                            <button type="button" id="combinelogo" class="button button-primary"
                                                    onclick="combinelogos()">combine
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
                <!-- footer of the page -->
                <div class="footer">
                    @include("partials.footerlogo")
                </div>
            </form>
        </section>
    </main>
@endsection
@push('footerScripts')
    <script type="application/javascript">
        var logoConfigMinHeight = '{{config('leadpops.design.logo.minHeight')}}';
        var logoConfigMaxHeight = '{{config('leadpops.design.logo.maxHeight')}}';

        var logoConfigDefaultHeight = '{{config('leadpops.design.logo.defaultHeight')}}';
        var logoConfigInitHeight = '{{config('leadpops.design.logo.defaultHeightPx')}}';
        var logoConfigMaxAllowedHeightPx = '{{config('leadpops.design.logo.maxAllowedHeightPx')}}';
    </script>

    <script src="{{ config('view.theme_assets') }}/pages/new-transition.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/pages/logo.js?v={{ LP_VERSION }}"></script>
@endpush

