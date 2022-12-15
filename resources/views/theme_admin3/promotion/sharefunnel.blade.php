@extends("layouts.leadpops-inner-sidebar")

@section('content')
    <!-- contain main informative part of the site -->
    <main class="main">
        <!-- content of the page -->
        <section class="main-content funnel-share">
            <!-- Title wrap of the page -->
        @php

            LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view);
            //$shareURL = urlencode("https://fha-refi-9979.dev-funnels.com/");
            $shareURL = "https://" . @$view->data->funnelData['funnel']['domain_name'];//urlencode("https://fha-refi-9979.dev-funnels.com");//
            if(@$lynxly_data->slug_name){
            $shareURL = "https://" . config('urlshortener.app_base_url').@$lynxly_data->slug_name;
            }

            $shareURLDec = "https://" . @$view->data->funnelData['funnel']['domain_name'];
            $containerWidth = '500';
            $containerHeight = '500';
            $id =  @$view->data->funnelData['client_leadpop_id'];

//dd($view->data->funnelData['client_leadpop_id']);
        $lynxly_data = $view->data->lynxly_data ?? false;

     //   dd($lynxly_data->slug_name);

        @endphp

        @include("partials.flashmsgs")


        <!-- content of the page -->
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h2 class="lp-panel__title">
                            Your Funnel Lives in This Link & URL Shortener
                        </h2>
                    </div>
                </div>
                <div class="lp-panel__body">
                    <div class="form-group m-0 funnel_url copy-btn-area">
                        <label for="funnel_url">Funnel URL:</label>
                        <div class="input__wrapper">
                            <div class="input-holder input-holder_icon position-relative">
                                <span class="ico ico-lock"></span>
                                <div id="funnelUrl" name="funnel_url" class="form-control pl-6 d-flex">
                                    <div class="url-text">{{ "https://" . @$view->data->funnelData['funnel']['domain_name']}}
                                    </div>
                                    <div class="url-text copy-text">{{ "https://" . @$view->data->funnelData['funnel']['domain_name']}}
                                    </div>
                                    <a href="#" class="hover-hide">
                                        <i class="fbi fbi_dots">
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                        </i>
                                    </a>
                                    <ul class="lp-controls">
                                        <li class="lp-controls__item funnel-url-copy {{$lynxly_data?"":"d-none"}}">
                                            <a href="javascript:void(0)"
                                               class="lp-controls__link el-tooltip"
                                               title="Copy Full Funnel URL" onclick="copyToClipboardDiv('#funnelUrl .copy-text', this)">
                                                <i class="ico-copy"></i>
                                            </a></li>
                                        <li class="lp-controls__item">
                                            <a href="{{ "https://" . @$view->data->funnelData['funnel']['domain_name'] }}"
                                               target="_blank" class="lp-controls__link el-tooltip"
                                               title="Open Funnel Link in New Tab">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <a href="#" class="form-control link-swatcher el-tooltip" id="make_shorten_url"
                           data-container="body" title="SHORTEN URL">
                            <i class="fas fa-exchange-alt"></i>
                        </a>

                        <button class="button button-bold button-primary copy-btn"
                                onclick="copyToClipboardDiv('#funnelUrl .copy-text', this)">copy url
                        </button>
                    </div>
                    <div class="url-expand copy-btn-area">
                        <div class="form-group m-0">
                            <label for="shortUrl">Short URL: </label>
                            <div class="input__wrapper">
                                <div class="input-holder input-holder_icon position-relative">
                                    <span class="ico ico-link"></span>
                                    <div id="shortUrl" class="shortUrl ">
                                        <div class="input-holder">
                                            <div class="url-text">{{config('urlshortener.app_base_url')}}/<strong
                                                        class="inner-text font-weight-normal"></strong></div>
                                            <input type="text" name="funnel_url" class="form-control form-url-text"
                                                   id="url_slug_val" data-id="{{$id}}"
                                                   value="{{@$lynxly_data->slug_name}}" spellcheck="false" readonly>
                                        </div>
                                        <a href="#" class="hover-hide">
                                            <i class="fbi fbi_dots">
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                            </i>
                                        </a>
                                        <ul class="lp-controls">
                                            <li class="lp-controls__item"><a href="#"
                                                                             class="lp-controls__link lp-controls__edit el-tooltip"
                                                                             title="Edit"><i
                                                            class="ico ico-edit"></i></a></li>
                                            <li class="lp-controls__item">
                                                <a href="{{config('urlshortener.app_base_url')."/".@$lynxly_data->slug_name}}"
                                                   class="lp-controls__link el-tooltip" id="short_url_link"
                                                   target="_blank" title="Open Funnel Link in New Tab"><i
                                                            class="fas fa-external-link-alt"></i></a>
                                            </li>
                                        </ul>
                                        <ul class="option_list">
                                            <li><a href="#" id="doEditPopUpBtn">Save</a></li>
                                            <li><a href="#" id="doCanelEdit" class="cancel-option">Cancel</a></li>
                                        </ul>
                                    </div>
                                    <div class="copy-text"
                                         id="shortLinkValDiv">{{config('urlshortener.app_base_url')."/".@$lynxly_data->slug_name}}</div>
                                </div>
                            </div>
                            <a href="#" class="form-control link-swatcher el-tooltip" id="remove_short_url"
                               data-id="{{$id}}" data-container="body"
                               title="Remove & Delete This Short URL"><i class="fas fa-times"></i></a>

                            <input type="hidden" class="copy-text"
                                   value="{{config('urlshortener.app_base_url')."/".@$lynxly_data->slug_name}}"
                                   id="shortLinkVal">


                            <button class="button button-bold button-primary copy-btn"
                                    onclick="copyToClipboardDiv('#shortLinkValDiv', this)">copy url
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h2 class="lp-panel__title">
                            Social Media and Email
                        </h2>
                    </div>
                </div>
                <div class="lp-panel__body">
                    <div class="action social-media">
                        <ul class="action__list">
                            <li class="action__item">
                                <a id="fbshare" href="#" class="action__link share-fb">
                                        <span class="social-share facebook">
                                            <i class="fa fa-facebook"></i>
                                            facebook
                                        </span>
                                </a>

                            </li>
                            <li class="action__item">
                                <a href="javascript:void(0)" id="twitter-share"
                                   class="twitter-action__link" data-size="large">
                                        <span class="social-share twitter">
                                            <i class="fa fa-twitter"></i>
                                            twitter
                                        </span>
                                </a>
                            </li>

                            <li class="action__item">
                                <a href="javascript:void(0)"
                                   {{--'http://www.linkedin.com/shareArticle?mini=true&url=https://stackoverflow.com/questions/10713542/how-to-make-custom-linkedin-share-button/10737122&title=How%20to%20make%20custom%20linkedin%20share%20button&summary=some%20summary%20if%20you%20want&source=stackoverflow.com'--}}
                                   id="linkedin-share">
                                    <span class="social-share linkedin">
                                        <i class="fa fa-linkedin"></i>
                                        linkedin
                                    </span>
                                </a>


                                {{--<a  href="javascript:void(0)" class="action__link"--}}
                                {{--onclick="window.open(--}}
                                {{--'https://www.linkedin.com/shareArticle?mini=true&url={{ $shareURL }}'--}}
                                {{--,'', '_blank, width={{$containerWidth}}, height={{$containerHeight}}, resizable=yes, scrollbars=yes'); return false;"--}}
                                {{-->--}}
                                {{--<span class="social-share linkedin">--}}
                                {{--<i class="fa fa-linkedin"></i>--}}
                                {{--linkedin--}}
                                {{--</span>--}}
                                {{--</a>--}}
                            </li>


                            <!--                                <li class="action__item">-->
                            <!--                                    <a href="#" class="action__link">-->
                            <!--                                        <span class="social-share buffer">-->
                            <!--                                            <i class="fab fa-buffer"></i>-->
                            <!--                                            bufferapp-->
                            <!--                                        </span>-->
                            <!--                                    </a>-->
                            <!--                                </li>-->
                            <li class="action__item">

                                <a href="javascript:void(0)" id="email-share" class="action__link">
                                        <span class="social-share email">
                                            <i class="fas fa-envelope-open-text"></i>
                                            email
                                        </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="lp-panel pb-0">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h2 class="lp-panel__title">
                            Social Share Image
                            <span class="question-mark el-tooltip" title="<p>Your Social Share Image is what shows when you share your <br> Funnel link on social media.</p><p>Ideal dimensions for a custom social share image that works<br> well on Facebook, Twitter, and LinkedIn are 1,200 x 630 pixels.</p><p>If you don't upload a social share image, we'll automatically <br>
pull your Funnel's Featured Image.</p><p>If you don't have a Featured Image, we'll pull your Funnel's <br>Logo.</p><p class='m-0'>If you don't have a Logo or a Featured Image, and you don't<br>  upload a Social share Image below, no image will be shown<br> when you share your Funnel link.</p>">
                                    <span class="ico ico-question"></span>
                                </span>
                        </h2>
                    </div>
                    <div class="col-right reset_share_image_list">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <a href="javascript:void(0)" class="action__link reset_share_image">
                                        <span class="ico ico-undo"></span>reset default image
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form id="social_share_form" method="post" enctype="multipart/form-data"
                      action="{{ LP_BASE_URL.LP_PATH."/promote/upload/".@$view->data->funnelData['current_hash'] }}">
                    @csrf
                    <input type="hidden" name="og_image_id" id="og_image_id" value="{{ @$view->data->og_image_id }}">
                    <input type="hidden" name="current_hash" id="current_hash"
                           value="{{ @$view->data->funnelData['current_hash'] }}">
                    <input type="hidden" name="leadpop_id" id="leadpop_id"
                           value="{{ @$view->data->funnelData['leadpop_id'] }}">
                    <input type="hidden" name="leadpop_version_id" id="leadpop_version_id"
                           value="{{ @$view->data->funnelData['leadpop_version_id'] }}">
                    <input type="hidden" name="leadpop_version_seq" id="leadpop_version_seq"
                           value="{{ @$view->data->funnelData['leadpop_version_seq'] }}">
                    <div class="lp-panel__body p-0">
                        <div class="browse__content browse__content_upload-social">
                            <div id="upload_og_image" class="browse__step1">
                                <div class="browse__desc">
                                    <p>
                                        You haven't added any Social Share image yet.
                                    </p>
                                    <div class="lp-image__browse">
                                        Click
                                        <label class="lp-image__button" for="browse_img">
                                            Browse
                                        </label>
                                        to start uploading.
                                    </div>
                                    <div class="file__control">
                                        <p class="file__extension">Invalid image format. Image format must be PNG, JPG,
                                            or JPEG.</p>
                                        <p class="file__size">Maximum file size limit is 4MB.</p>
                                    </div>
                                </div>
                            </div>
                            <div id="update_og_image" class="browse__step2">
                                <div class="img-frame__wrapper">
                                    <div class="img-frame__content">
                                        <div class="preview__wrapper">
                                            <img id="og_image_preview" class="img-frame__preview"
                                                 src="{{@$view->data->og_image}}" alt="">
                                        </div>
                                    </div>
                                    <div class="img-frame__controls">
                                        <div class="action">
                                            <ul class="action__list">
                                                <li class="action__item del__img">
                                                    <button type="button" class="btn-image__del button button-cancel">
                                                        delete
                                                    </button>
                                                </li>
                                                <li class="action__item del__img"
                                                    id="delete_og_image" {!!@$view->data->og_image?"style='display:block;'":"style='display:none;'" !!}>
                                                    <button type="button" class="button button-cancel"
                                                            id="delete_social_image">
                                                        delete
                                                    </button>
                                                </li>
                                                <li class="action__item"
                                                    id="browse_og_image" {!! @$view->data->og_image?"style='display:none;'":"style='display:block;'" !!}>
                                                    <div class="lp-image__browse">
                                                        <label class="button button-primary" for="browse_img">
                                                            <input id="browse_img" onchange="onSelect(event)" onclick="fileClicked(event)"
                                                                   class="lp-image__input" type="file" name="image"
                                                                   accept="image/*" required data-form-field/>
                                                            Browse
                                                        </label>
                                                    </div>
                                                    <div class="file__control">
                                                        <p class="file__extension">Invalid image format. Image format
                                                            must be PNG, JPG, or JPEG.</p>
                                                        <p class="file__size">Maximum file size limit is 4MB.</p>
                                                        <p class="file__imgsize">Image you choose should be at least
                                                            32x32&nbsp;pixels</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- content of the page -->
            <!-- footer of the page -->
            <div class="footer">
                {{--                <div class="row">--}}
                {{--                    <button class="button button-secondary">Save</button>--}}
                {{--                </div>--}}
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">

                </div>
            </div>
        </section>
    </main>

    <!-- Model Boxes - Domain Delete - Start -->
    <div class="modal fade lp-modal-box" data-backdrop="static"  id="delete_social_media_image">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Delete Social Share Image</h3>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_mb-0 modal-msg_light">
                        Are you sure you want to delete Social Share Image?
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No
                                </button>
                            </li>
                            <li class="action__item">
                                <button id="_delete_social_media_image" class="button button-bold button-primary"
                                        type="button">Yes
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Model Boxes - Domain RESET - Start -->
    <div class="modal fade lp-modal-box" data-backdrop="static"  id="reset_social_media_image">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Reset Social Share Image</h3>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_mb-0 modal-msg_light">
                        Are you sure you want to Reset Social Share Image?
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No
                                </button>
                            </li>
                            <li class="action__item">
                                <button id="_reset_social_media_image" class="button button-bold button-primary"
                                        type="button">Yes
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade add_recipient home_popup" id="deleteSlugName" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title">Delete Short URL</h3>
                </div>
                <div class="modal-body model-action-body">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="popup-wrapper modal-action-msg-wrap">
                                    <div class="funnel-message modal-msg modal-msg_mb-0">
                                        Are you sure you want to delete your Short Link?
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">
                                    Never Mind
                                </button>

                            </li>
                            <li class="action__item">
                                <button id="doDeletePopUpBtn" class="button button-bold button-primary" type="button">
                                    Delete
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>





    @push('footerScripts')
        <script>
            var validExtensions = ['.png', '.jpg', '.jpeg'];
            let imagePath = "{{@$view->data->og_image}}".toLowerCase();
            let hasImage = imagePath ? true : false;
            validExtensions.forEach(function (extension) {
                if (imagePath.indexOf(extension) > -1) {
                    hasImage = true;
                }
            })

                    @if ($errors->any())
            var errors = {!! json_encode($errors->all()) !!};
            errors.forEach(error => {
                displayAlert('danger', error);
            })
            @endif
            var  facebookTemplate =  twitterTemplate = linkedinTemplate = emailTemplate =  shareURL  = '';
            var emailSubject = '{{$view->data->email_subject}}';
            var containerWidth = '{{$containerWidth}}';
            var containerHeight = '{{$containerHeight}}';
            shareURL = '{!! $shareURL !!}';
            socialLinkRender();

            /**
             * it will work on created, update and remove short url
             */
            function socialLinkRender()
            {
                facebookTemplate = `{!! config("social.share_funnel_template")["facebook"] !!}`;
                twitterTemplate = `{!! config("social.share_funnel_template")["twitter"] !!}`;
                linkedinTemplate = `{!! config("social.share_funnel_template")["linkedin"] !!}`;
                emailTemplate = `{!! @$view->data->email_text !!}`;
                facebookTemplate = encodeURIComponent(facebookTemplate.replaceAll("FUNNEL_LINK", shareURL));
                twitterTemplate =  encodeURIComponent(twitterTemplate.replaceAll("FUNNEL_LINK", shareURL));
                linkedinTemplate = encodeURIComponent(linkedinTemplate.replaceAll("FUNNEL_LINK", shareURL));
                emailTemplate = encodeURIComponent(emailTemplate.replaceAll('[:FUNNEL_LINK]', shareURL));
            }

        </script>
        <script src="{{ config('view.theme_assets') }}/pages/short-url.js?v={{ LP_VERSION }}"></script>
    @endpush

@endsection
