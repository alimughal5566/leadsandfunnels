@extends("layouts.leadpops-inner-sidebar")

@section('content')

    @php

        $firstkey = isset($view->data->clickedkey)?@$view->data->clickedkey:'';

        $imagesrc = \View_Helper::getInstance()->getCurrentFrontImageSource( @$view->data->client_id, @$view->data->funnelData, true );
        if($imagesrc["imgsrc"]){
            list($imagestatus,$theimage, $noimage) = explode("~",$imagesrc["imgsrc"]);
            $currentImage = "";
            if(!empty($theimage)) {
                $arr = explode('/', $theimage);
                if(is_array($arr)) {
                    $currentImage = end($arr);
                }
            }

            if($imagestatus == 'default') {
               $imagedescr =  "homedefault";
           } else if($imagestatus == 'mine') {
               $imagedescr =  "myhome";
           }

            $active_inactive_checked="checked";

            if($noimage=="noimage") {
                $active_inactive_checked="";
                $imagedescr =  "nohome";

                $imagestatus = 'inactive';
            } else {
                $imagestatus = 'active';
            }
        } else {
           $theimage = '';
           $active_inactive_checked="";
           $imagedescr =  "nohome";
           $imagestatus = 'inactive';
        }

        // dd($currentImage, $theimage, $imagesrc);
        $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);

        if (config('rackspace.rs_featured_image_dir') == 'stockimages/classicimages/' )
            $class = " classicimages";
        else
            $class = "";
    @endphp

    <main class="main">
        <section class="main-content">


            <form id="fuploadload" name="fuploadload"
                  enctype="multipart/form-data"
                  action=""
                  class="global-content-form"
                  data-action="{{ LP_BASE_URL.LP_PATH."/popadmin/uploadimage" }}"
                  data-global_action="{{ route('uploadGlobalImageAdminThree')}}"
                  method="POST">
            @csrf
                <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
                @php
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
                <input type="hidden" name="delete_image" id="delete_image" value="n" data-form-field>
                <input type="hidden" name="scaling_defaultWidthPercentage" id="scaling_defaultWidthPercentage" value="{{ $imagesrc["scaling_defaultWidthPercentage"]}}">
                <input type="hidden" name="scaling_maxWidthPx" id="scaling_maxWidthPx" value="{{ $imagesrc["scaling_maxWidthPx"]}}">
                @php
                    if($view->data->funnelData['leadpop_version_id'] == config('funnelbuilder.funnel_builder_version_id')){
                        echo '<input type="hidden" id="leadpop_version_id_featured_image_off" value="1">';
                    }
                @endphp
                <!-- Title wrap of the page -->
                @php
                    LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view);
                @endphp
                <!-- content of the page -->
                @include("partials.flashmsgs")
                <div class="lp-panel featured-image-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Featured Image
                                <span class="question-mark el-tooltip" title="Maximum image width shown in 470px. If you upload <br />a larger image, we will auto-size it proportionally to fit.">
                                    <span class="ico ico-question"></span>
                                </span>
                            </h2>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <!-- Resize slider for Featured Image -->
                                <div class="main__control bg__control_slider feature-image-resize-slider-wrap">
                                    <input id="feature-image-resize-slider" data-form-field class="form-control" data-slider-id='ex1Slider' type="text"/>
                                    <input type="hidden" id="feature-image-height" value="93">
                                </div>
                                <div class="reset-size-btn-wrap">
                                    <a href="javascript:void(0)" id="reset_featuredimage_size" class="action__link">
                                        <span class="ico ico-undo"></span>
                                    </a>
                                </div>

                                <ul class="action__list">
                                    <li class="action__item action__item_separator"  >
                                        <span class="action__span">
                                            <a href="javascript:void(0)" id="reset_default_image" class="action__link">
                                                <span class="ico ico-undo"></span>reset default image
                                            </a>
                                        </span>
                                    </li>
                                    <li class="action__item">
                                        <input class="thktogbtn" id="activedeactivebtn" name="thankyou" {{$active_inactive_checked}}
                                               data-thelink="thankyou_active" data-toggle="toggle" data-onstyle="active"
                                               data-offstyle="inactive" data-width="127" data-height="43"
                                               data-on="INACTIVE" data-off="ACTIVE" type="checkbox" data-form-field>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="browse__content browse__content_upload-social1">
                            <div id="upload_og_image" class="browse__step1"
                                 @if(!empty($currentImage)) style="display: none;" @endif>
                                <div class="browse__desc">
                                    <p>
                                        You haven't added any Featured Image yet.
                                    </p>
                                    <div class="lp-image__browse">
                                        Click
                                        <label class="lp-image__button" for="logo">
                                            Browse
                                        </label>
                                        to start uploading.
                                    </div>
                                </div>
                            </div>
                            <div id="update_og_image" class="browse__step2"
                                 @if(!empty($currentImage)) style="display: flex;" @endif>
                                <div class="img-frame__wrapper">
                                    <div class="img-frame__content resized">
                                        <div class="preview__wrapper">
                                            <img id="currentdropimagelogo" class="img-frame__preview{{ $class }}" src="{{ $theimage }}" alt="">
                                        </div>
                                    </div>
                                    <div class="img-frame__controls">
                                        <div class="action">
                                            <ul class="action__list">
                                                <li class="action__item btn-image__del" {!! empty($currentImage) ? "style='display:none;'" : "style='display:block;'" !!}>
                                                    <button type="button" class="button button-cancel">
                                                        delete
                                                    </button>
                                                </li>
                                                <li class="action__item">
                                                    <div class="lp-image__browse">
                                                        <label class="button button-primary" for="logo">
                                                            <input id="logo" onchange="onSelect(event)" onclick="fileClicked(event)"
                                                                   class="lp-image__input" type="file" name="logo"
                                                                   accept="image/*" required data-form-field/>
                                                            Browse
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
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
                    <div class="row">
                        <img src="{{ config('view.rackspace_default_images').'/footer-logo.png'}}" alt="footer logo">
                    </div>
                </div>
            </form>
        </section>
    </main>

    <div class="modal fade add_recipient video-modal" id="resetfeaturedimg" data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="lp-video-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Featured Image</h5>
                </div>
                <div class="modal-body">
                    <div class="modal-msg mb-0">Are you sure you want to reset featured image?</div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel lp-btn-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary" id="resetFeature">Reset</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footerScripts')
    <script type="application/javascript">
        let imageURL = '{!! $theimage !!}';
            var ImageConfigSliderMin = '{{config('leadpops.design.featureImage.sliderMin')}}';
            var ImageConfigSliderMax = '{{config('leadpops.design.featureImage.sliderMax')}}';

            var ImageConfigSliderDefault = '{{config('leadpops.design.featureImage.sliderDefault')}}';
            var logoConfigInitWidth = '{{config('leadpops.design.featureImage.sliderDefaultPx')}}';
            var ImageConfigMaxAllowedWidthPx = '{{config('leadpops.design.featureImage.maxAllowedWidthPx')}}';
    </script>

    <script src="{{ config('view.theme_assets') }}/pages/featured-image.js?v={{ LP_VERSION }}"></script>
@endpush
