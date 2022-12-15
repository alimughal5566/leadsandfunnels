@php
    //   var_dump($data['swatches']);

    $clientType_MTG = 3;
    $clientType_RE = 5;
    $clientType_INS = 1;
@endphp

@extends("layouts.launcher")

@section('content')
    <!-- main container of all the page elements -->
    <div id="wrapper">
        <!-- contain main informative part of the site -->
        <main class="main">
            <!-- three columns part of the page -->
            <div class="three-cols">
                <!-- sidebar of the page -->
                <aside class="sidebar">
                    <strong class="logo"><a href="#"><img src="{{ LP_ASSETS_PATH }}/adminimages/logo-launcher.png"
                                                          alt="Mortgage Leads by leadPops Logo"
                                                          title="leadPops Mortgage Lead Generation Logo"></a></strong>
                    <div class="text-box">
                        <h1>You are just moments away from growing your business with&nbsp;leadPops!</h1>
                        <div class="text-box__text">
                            <p>Finish launching your Funnels Account by completing a few simple steps&nbsp;now.</p>
                        </div>
                    </div>
                    <div class="progress-area" id="scroll-point">
                        <div class="progress">
                            <div class="progress__progress-bar" style="width: 16%;"></div>
                        </div>
                        <div class="progress-area__progress-detail">
                            <span class="progress-area__num">16</span>% Completed
                        </div>
                    </div>
                    <a href="#" class="btn btn-secondary disabled sidebar__btn" id="launchBtn">launch my funnels account&nbsp;now!</a>
                </aside>

                <!-- setup block of th page -->
                <div class="block-setup">
                    <strong class="block-setup__title">funnel setup</strong>
                    <form id="fuploadlogoimage" name="fuploadlogoimage"
                          enctype="multipart/form-data" method="post"
                          action="{{LP_BASE_URL. '/lp/launcher/launchClientFunnel'}}">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <ul class="list-steps">
                            <li class="list-steps__li list-steps__li--logo">
                                <a href="#" class="list-steps__opener active">
                                    <span class="list-steps__step-no">Step #1</span>
                                    <span class="list-steps__step-title">Upload Logo&nbsp;&nbsp;<span
                                                class="tooltip-area"><span class="tooltip-opener"><i
                                                        class="icon icon-help"></i></span><span
                                                    class="tooltip-content bottom"><span class="tooltip-content__p">Upload a logo that's at least 200px wide, and not larger than 1MB in&nbsp;size. </span><span
                                                        class="tooltip-content__p">You can always change your logo after you&nbsp;launch.</span></span></span></span>
                                    <span class="list-steps__tick"><i class="icon icon-check"></i></span>
                                </a>
                                <div class="list-steps__slide" style="display: block;">
                                    <div class="block-logo">
                                        <span class="info-text">Select a logo. A matching color palette will be&nbsp;created.</span>
                                    </div>
                                    <div class="progress-area progress-area__logo">
                                        <div class="progress">
                                            <div class="progress__progress-bar" id="myBar"></div>
                                        </div>
                                        <div class="progress-area__progress-detail">
                                            Uploading - <span class="progress-area__num" id="num-counter">0</span>
                                        </div>
                                        <br/>
                                    </div>
                                    <div class="preview-area">
                                        <span class="info-text">You can upload your own corporate approved logo if you&nbsp;prefer.</span>
                                        <div class="logo-preview">
                                            <div class="logo-preview__img-holder">
                                                <div id="img-preview"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label class="custom-file">
                                            <input type="file" class="input-file" name="imageInput" id="imageInput">
                                            <span class="btn btn-primary file-text">choose file</span>
                                        </label>
                                        <a href="#" class="link-logo">I don't have a logo</a>
                                    </div>
                                    <div class="logo-validate"></div>
                                </div>
                            </li>
                            <li class="list-steps__li list-steps__li--color">
                                <span class="tooltip-content"><span class="tooltip-content__p">Upload your logo first so that we can pull color options that&nbsp;match!</span></span>
                                <a href="#" class="list-steps__opener">
                                    <span class="list-steps__step-no">Step #2</span>
                                    <span class="list-steps__step-title">Select Background&nbsp;Color</span>
                                    <span class="list-steps__tick"><i class="icon icon-check"></i></span>
                                </a>
                                <div class="list-steps__slide">
                                    <div class="block-swatches">
                                        <span class="info-text">Colors are automatically pulled from&nbsp;logo.</span>
                                        <ul class="list-swatches">
                                            @if($data['swatches'] && count($data['swatches']))
                                                @foreach($data['swatches'] as $key=>$swatch)
                                                    <li class="list-swatches__li">
                                                        <label class="custom-radio">
                                                            <input type="radio" data-color="{{$swatch}}"
                                                                   name="swatcher">
                                                            <span class="fake-radio"><span class="fake-radio__bg"
                                                                                           style="background: {{$swatch}}"></span></span>
                                                        </label>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="list-steps__li list-steps__li--company">
                                <a href="#" class="list-steps__opener">
                                    <span class="list-steps__step-no">Step #3</span>
                                    <span class="list-steps__step-title">Company Name</span>
                                    <span class="list-steps__tick"><i class="icon icon-check"></i></span>
                                </a>
                                <div class="list-steps__slide">
                                    <div class="field-holder">
                                        <label for="company"><i class="icon icon-buildings"></i></label>
                                        <input type="text"
                                               {{ @$data['funnelData']->is_mm==1 || @$data['funnelData']->is_thrive==1 || @$data['funnelData']->is_fairway==1 ? " readonly " : "" }}
                                               placeholder="ABC Mortgage Co."
                                               class="company-name"
                                               name="company"
                                               id="company" value="{{@$data['funnelData']->company_name}}">
                                    </div>
                                </div>
                            </li>
                            <li class="list-steps__li">
                                <a href="#" class="list-steps__opener">
                                    <span class="list-steps__step-no">Step #4</span>
                                    <span class="list-steps__step-title">Phone Number</span>
                                    <span class="list-steps__tick"><i class="icon icon-check"></i></span>
                                </a>
                                <div class="list-steps__slide">
                                    <span class="info-text">You can always change this in the&nbsp;future.</span>
                                    <div class="field-holder">
                                        <label for="phone"><i class="icon icon-phone"></i></label>
                                        <input type="tel" placeholder="(___) ___-____" class="company-phone"
                                               id="phone"
                                               name="phone"
                                               maxlength="14"
                                               value="{{@$data['funnelData']->phone_number}}">
                                    </div>
                                </div>
                            </li>

                            @if(in_array($data['funnelData']->client_type, array($clientType_RE, $clientType_INS)))
                                <li class="list-steps__li">
                                    <a href="#" class="list-steps__opener">
                                        <span class="list-steps__step-no">Step #5</span>
                                        <span class="list-steps__step-title">License Info</span>
                                        <span class="list-steps__tick"><i class="icon icon-check"></i></span>
                                    </a>
                                    <div class="list-steps__slide">
                                        <div class="field-holder">
                                            <label for="nmls"><i class="icon icon-hash"></i></label>
                                            <input type="text"
                                                   placeholder="{{@$data['funnelData']->client_type == $clientType_RE ? "CA DRE #0123456" : "CA-0F99182" }}"
                                                   id="nmls"
                                                   name="nmls"
                                                   value="{{@$data['funnelData']->license_number_text}}">
                                        </div>
                                    </div>
                                </li>
                            @else
                                <li class="list-steps__li">
                                    <a href="#" class="list-steps__opener">
                                        <span class="list-steps__step-no">Step #5</span>
                                        <span class="list-steps__step-title">NMLS Number</span>
                                        <span class="list-steps__tick"><i class="icon icon-check"></i></span>
                                    </a>
                                    <div class="list-steps__slide">
                                        <div class="field-holder">
                                            <label for="nmls"><i class="icon icon-hash"></i></label>
                                            <input type="text"
                                                   placeholder="123456"
                                                   id="nmls"
                                                   name="nmls"
                                                   minlength="4"
                                                   maxlength="10"
                                                   value="{{@$data['funnelData']->license_number_text}}">
                                        </div>
                                    </div>
                                </li>
                            @endif

                            <li class="list-steps__li">
                                <a href="#" class="list-steps__opener">
                                    <span class="list-steps__step-no">Step #6</span>
                                    <span class="list-steps__step-title">Email(s) to Send Leads to&nbsp;&nbsp;<span
                                                class="tooltip-area"><span class="tooltip-opener"><i
                                                        class="icon icon-help"></i></span><span
                                                    class="tooltip-content right-align"><span
                                                        class="tooltip-content__p">You can add up to 5 email addresses separated by&nbsp;commas.</span><span
                                                        class="tooltip-content__p">You'll also be able to set up CRM integrations once you launch your&nbsp;account.</span></span></span></span>
                                    <span class="list-steps__tick"><i class="icon icon-check"></i></span>
                                </a>
                                <div class="list-steps__slide">
                                    <div class="field-holder has-margin">
                                        <label for="email"><i class="icon icon-mail"></i></label>
                                        <input type="email"
                                               id="email"
                                               name="email"
                                               placeholder="Enter email address ..."
                                               value="{{@$data['funnelData']->contact_email}}">
                                    </div>
                                    <div class="btn-finished">
                                        <a href="#" class="btn btn-secondary disabled">I'm finished</a>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <input type="hidden" name="swatches" id="swatches" value="">
                        <input type="hidden" name="base_color" id="base_color" value="">
                        <input type="hidden" name="hash" value="{{@$data['hash']}}">
                    </form>
                </div>
                <!-- preview block of th page -->
                <div class="block-preview">
                    <div class="preview-box">
                        <div class="preview-content">
                            <header class="preview-head">
                                <div class="preview-head__wrap">
                                    <strong class="preview-head__logo"></strong>
                                    <div class="contact-detail">
                                        <strong class="contact-detail__name"></strong>
                                        <span class="contact-detail__num"></span>
                                    </div>
                                </div>
                            </header>
                            <div class="body-area">
                                <div class="body-area__wrap">
                                    <div class="body-area__frame">
                                        <div class="body-area__text-wrap">
                                            <div class="text-bar text-bar__medium"></div>
                                            <div class="text-bar"></div>
                                            <div class="text-bar text-bar__small"></div>
                                        </div>
                                        <div class="body-area__btn-holder"></div>
                                    </div>
                                </div>
                            </div>
                            <footer class="preview-footer">
                                <div class="preview-footer__wrap">
                                    <div class="preview-footer__copyright"></div>
                                    <div class="preview-footer__right-text"></div>
                                </div>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@php
    //dd($data['logo'])
@endphp
@push('FooterScripts')
    <script>
        var ajax_token = '{{ csrf_token() }}';
        var site = {
            baseUrl: "{{ LP_BASE_URL }}",
            lpPath: "{{ LP_PATH }}",
            lpAssetsPath: "{{ LP_ASSETS_PATH }}",
            version: "{{LP_VERSION}}"
        };
    </script>
    <script type="text/javascript" src="{{ config('view.theme_assets') }}/js/color-thief.js?v={{LP_VERSION}}"></script>
    <script type="text/javascript" src="{{ config('view.theme_assets') }}/js/launcher/index.js?v={{LP_VERSION}}"></script>

    <script type="text/javascript">

        var defaultSwatches = [];
        @if($data['swatches'] && count($data['swatches']))
            defaultSwatches = jQuery.parseJSON("{{json_encode($data['swatches'])}}".replace(/&quot;/ig, '"'));
        @endif

        $(document).ready(function () {

            setTimeout(function () {
                getLaunchStatus();
            }, 200)


            //debugger;
            var logo = "{{@$data['logo']}}";
            window.client_type = {!! json_encode($data['funnelData']) !!};
            if (logo && logo != 'undefined') {
                jQuery(".link-logo").hide();
                jQuery(".file-text").text('upload new logo');
                jQuery('.list-steps__li--logo').addClass('visited check-active');
                jQuery('.list-steps__li--color').addClass('pointer-active');
                $('.input-file').each(function () {
                    //debugger;
                    $(this).attr('src', logo);
                });

                var image_holder = $("#img-preview");
                image_holder.empty();

                var img = document.createElement('img');
                img.setAttribute('src', logo);
                img.setAttribute('class', "logo-preview__img");
                $(img).appendTo(image_holder);
                image_holder.show();

                // img.crossOrigin = "Anonymous";
                img.addEventListener("load", function () {
                    setSwatches(img, true);
                });
                jQuery(window).on('load', function () {
                    setTimeout(function () {
                        jQuery('.block-logo').addClass('hidden');
                        jQuery('.progress-area__logo').removeClass('bar-active');
                        jQuery('.preview-area').addClass('preview-active');
                        var currentImage = jQuery('#img-preview .logo-preview__img').clone();
                        jQuery('.preview-head__logo').html(currentImage);
                        $("li.list-swatches__li input[type=radio]").eq(0).trigger('click');
                    }, 1000);
                });
            }


            $('#launchBtn').on('click', function (e) {
                e.preventDefault();
                $('#fuploadlogoimage').submit();
            });
            $('#company').trigger('keyup');
            $('#phone').trigger('keyup');
            $('#email').trigger('keyup');
            $('#nmls').trigger('keyup');
        });

        function getFileExtension(file) {
            return file.substr((file.lastIndexOf('.') + 1));
        }


        function getLaunchStatus() {
            jQuery.ajax({
                type: "GET",
                data: '',
                datatype: "json",
                processData: false,
                contentType: false,
                url: site.baseUrl + "/lp/launcher/getLaunchStatus",
                success: function (data) {
                    var status = JSON.parse(data).status;
                  //  debugger;
                    console.log(status);
                    if (!status || status == null || status == 2) {
                        window.location.href = "{{LP_PATH}}" + "/index";
                    }
                },
                error: function (e) {
                }
            });
        }
    </script>
@endpush
