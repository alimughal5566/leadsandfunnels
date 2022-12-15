@php
    $protocol = "http://";
    if(@$view->is_secured){
        $protocol = "https://";
    }
    $view->route = route('thankyou', ['hash' => $view->data->currenthash, 'app_theme' => 'theme_admin3']);
    $view->title = 'BACK TO THANK YOU PAGE OPTIONS';
@endphp

@extends("layouts.leadpops-inner-sidebar")

@section('content')

    <main class="main">
        <!-- content of the page -->
        <section class="main-content">
            <form id="thankyou-page-edit-form" method="post" class="global-content-form" action="{{route('thankyou.pages.save', ['hash' => @$view->data->currenthash ])}}" method="POST">
                {{-- Title Header & Watch How To Video --}}
                @php LP_Helper::getInstance()->getFunnelHeaderAdminThreeThankYouPage($view, $view->data->currenthash) @endphp
                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id" value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="current_hash" id="current_hash" value="@php echo @$view->data->currenthash @endphp">
                <input type="hidden" name="funneldata" id="funneldata" value='{{ json_encode(@$view->data->funnelData,JSON_HEX_APOS)  }}'>
                <img class="hide d-none" name="default_logo" id="default_logo" src="@php echo $view->data->logo; @endphp"/>

                <!-- content of the page -->
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h2 class="lp-panel__title">
                            Thank You Page Details
                        </h2>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item action__item_en-logo">
                                    <input class="responder-toggle typ_logo" for="typ_logo" id="typ_logo" name="thankyou_logo"
                                           data-thelink="en-logo_active" data-field="typ_logo" data-toggle="toggle"
                                           data-onstyle="active" data-offstyle="inactive"
                                           value="1"
                                           data-width="182" data-height="50" data-on="logo disabled"
                                           onchange="logo_trigger()"
                                           data-off="logo enabled" type="checkbox" checked>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="lp-panel__body">
                    <div class="form-thank-you">
                        <div class="form-group">
                            <label>Thank You Page Title</label>
                            <input class="form-control" id="thankyou-title" type="text" name="thankyou_title" placeholder="Thank You! Sebonix Funnel Version1" value="{{ $view->data->page->thankyou_title ?? 'Default Success Message' }}" required>
                        </div>
                        @error('thankyou_title')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                        <div class="form-group m-0">
                            <label>{{ $protocol . @$view->data->workingLeadpop }}/</label>
                            <input id="url__text" onkeypress="return AvoidSpace(event)" class="form-control" type="text" name="thankyou_slug" placeholder="thank-you" value="{{ $view->data->page->thankyou_slug ?? 'thank-you' }}" required>
                        </div>
                        @error('thankyou_slug')
                            <span class="help-block mt-3">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="lp-panel">
                <div class="lp-panel__head lp-panel__head_thankyou-edit">
                    <div class="col-left">
                        <h2 class="lp-panel__title">
                            Thank You Message
                        </h2>
                    </div>
                    <div class="col-right">
{{--                        <div class="dynamic-anwser-parent">--}}
{{--                            <select class="form-control dynamic-anwser">--}}
{{--                                <option>Dynamic Answer Insert</option>--}}
{{--                                <option>1. What is your first name?</option>--}}
{{--                                <option>2. What type of property are you purchasing?</option>--}}
{{--                                <option>3. What is the purchase price of new property?</option>--}}
{{--                                <option>4. Anything else we should consider?</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="lp-panel__body">
                    <div class="default__panel classic-editor__wrapper">
                        <div id="textwrapper">
                                <textarea name="thankyou" class="lp-froala-textbox classic-editor">
                                        {{ $view->data->thankyou }}
                                </textarea>
                        </div>
                        <!--<div class="thank-you-editor classic-editor"></div>-->
                    </div>
                </div>
            </div>
            <!-- footer of the page -->
            <div class="footer">
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                </div>
            </div>
            </form>
        </section>
    </main>

@endsection
@push('body_classes') funnel-thank-you-page @endpush
@push('footerScripts')
    <script src="{{ config('view.theme_assets') }}/js/content/thankyoupagesedit.js?v={{ LP_VERSION }}"></script>
    <script>
        $("#thankyou-page-edit-form").submit(function(e) {
            e.preventDefault();
            const form = $('#thankyou-page-edit-form');
            const hash = $('[data-id="main-submit"]').data("lpkeys");
            const thankyou_logo = ($("#typ_logo").is(":checked"))?1:0;
            const thankyou_title = $("#thankyou-title").val();
            const thankyou = $('.lp-froala-textbox').froalaEditor('html.get');
            $.ajax({
                method: 'post',
                url: form.attr("action"),
                data: {
                    noOfPages: 1,
                    'thankyou_logo': thankyou_logo,
                    'thankyou_title': thankyou_title,
                    'thankyou':thankyou,
                    'current_hash': hash
                },
                success: function (response) {
                    if (response.status) {
                        lptoast.cogoToast.success(response.message, {position: 'top-center', heading: 'Success'});
                    }
                }
            });
         });
    </script>
@endpush
