@extends('layouts.leadpops-inner-sidebar')
@section('content')
    @php
        if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
            $firstkey = @$view->data->clickedkey;
        }else {
            $firstkey = "";
        }
        $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
        $isChecked = function(array $arr, string $prop) {
         return isset($arr[$prop]) && $arr[$prop] == 'y' ? 'checked' : '';
         };
         $isActive = function(array $arr, string $prop) {
         return isset($arr[$prop]) && $arr[$prop] == 'y' ? 'y' : 'n';
         };
    @endphp

    <!-- contain main informative part of the site -->
    <!-- content of the page -->
    <main class="main">
        <section class="main-content">

            <form id="add-seo" method="POST"
                  class="global-content-form"
                  data-global_action="{{route('saveSeoGlobalAdminThree')}}"
                  data-action="{{ LP_BASE_URL . LP_PATH . "/popadmin/seosave" }}"
                  action="">
                <!-- Title wrap of the page -->
                {{ LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view) }}
                @include("partials.flashmsgs")
                {{ csrf_field() }}
                <input type="hidden" name="theselectiontype" id="theselectiontype"  value="edittags">
                <input type="hidden" name="client_id" id="client_id"  value="{{ $view->data->client_id }}">
                <input type="hidden" name="firstkey" id="firstkey" value="{{ $firstkey }}">
                <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $firstkey }}">
                <input type="hidden" name="treecookie" id="treecookie" value="{{ $treecookie }}">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ $view->data->currenthash }}">
                <input type="hidden" name="seo_title_active" id="seo_title_active" value="{{$isActive($view->data->seo , 'titletag_active')}}">
                <input type="hidden" name="seo_description_active" id="seo_description_active" value="{{$isActive($view->data->seo , 'description_active')}}">
                <input type="hidden" name="seo_keyword_active" id="seo_keyword_active" value="{{$isActive($view->data->seo , 'metatags_active')}}">
                <!-- content of the page -->
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Title Tag
                            </h2>
                        </div>
                        <div class="col-right">
                            <input {{ $isChecked($view->data->seo , 'titletag_active') }}
                                    id="titletag" class="seotogbtn"
                                   data-field="seo_title_active"
                                    data-thelink="titletag_active" data-toggle="toggle"
                                    data-onstyle="active" data-offstyle="inactive"
                                    data-width="127" data-height="43" data-on="INACTIVE"
                                    data-off="ACTIVE" type="checkbox"
                                    data-lpkeys="{{ $view->data->lpkeys }}~titletag_active" data-form-field>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="form-group m-0">
                            <div class="input__holder">
                                <input id="title__tag" name="titletag" class="form-control" type="text" value="{{ $view->data->seo['titletag'] ?? '' }}" data-form-field>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Description
                            </h2>
                        </div>
                        <div class="col-right">
                            <input {{ $isChecked($view->data->seo , 'description_active') }}
                                    id="description" class="seotogbtn"
                                    data-field="seo_description_active"
                                    data-thelink="description_active" data-toggle="toggle"
                                    data-onstyle="active" data-offstyle="inactive"
                                    data-width="127" data-height="43" data-on="INACTIVE"
                                    data-off="ACTIVE" type="checkbox"
                                    data-lpkeys="{{ $view->data->lpkeys }}~description_active" data-form-field>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="form-group m-0">
                            <div class="input__holder">
                                <textarea id="seo__desc" name="description" class="form-control text-area" data-form-field>{{ $view->data->seo['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Keyword
                            </h2>
                        </div>
                        <div class="col-right">
                            <input  {{ $isChecked($view->data->seo , 'metatags_active') }}
                                    id="keyword" class="seotogbtn"
                                    data-field="seo_keyword_active"
                                    data-thelink="keyword_active" data-toggle="toggle"
                                    data-onstyle="active" data-offstyle="inactive"
                                    data-width="127" data-height="43" data-on="INACTIVE"
                                    data-off="ACTIVE" type="checkbox"
                                    data-lpkeys="{{ $view->data->lpkeys }}~metatags_active" data-form-field>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="form-group m-0">
                            <div class="input__holder">
                            <textarea id="seo__keyword" name="metatags" class="form-control text-area" data-form-field>{{ $view->data->seo['metatags'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
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

@push('footerScripts')
    <script src="{{ config('view.theme_assets') . "/js/popadmin/seo.js?v=" . LP_VERSION }}"></script>
@endpush
