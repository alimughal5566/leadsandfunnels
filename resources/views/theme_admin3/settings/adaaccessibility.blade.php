@php
// dd($view);
    $inactiveChecked="checked";
    $activeChecked="";
    if(@$view->data->ada_accessibility['is_ada_accessibility'] == "1"){
        $inactiveChecked="";
        $activeChecked="checked";
    }
@endphp
@extends("layouts.leadpops-inner-sidebar")

@section('content')
    <!-- content of the page -->
    <main class="main">
        <section class="main-content header-page">
            <!-- Title wrap of the page -->
            @php
                LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view);
            @endphp
            @include("partials.flashmsgs")

            <form id="ada_accessibility_form" method="POST"
                  class="global-content-form"
                  data-global_action="{{ route('updateAdaAccessibilityGlobalAdminThree')}}"
                  data-action="@php echo LP_BASE_URL.LP_PATH."/popadmin/adaaccessibility/".$view->data->currenthash; @endphp"
                  action="">
                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id"  value="{{ $view->data->client_id }}">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ $view->data->currenthash }}">
                <input type="hidden" name="lpkeys" id="lpkeys" value="{{ @$view->data->lpkeys }}">


                <!-- content of the page -->
                <div class="box-ada">
                    <div class="row">
                        <div class="col col-md-6">
                            <label class="label-ada">
                                <input type="radio" name="is_ada_accessibility" value="0" {{$inactiveChecked}} data-form-field>
                                <div class="box-ada__label-box inactive-area">
                                    <span class="box-ada__wrap">
                                        <span class="box-ada__text">inactive</span>
                                    </span>
                                </div>
                                <div class="ada-sign integration__check-box inactive-area">
                                    <i class="ico ico-check"></i>
                                </div>
                            </label>
                        </div>
                        <div class="col col-md-6">
                            <label class="label-ada">
                                <input type="radio" name="is_ada_accessibility" value="1" {{$activeChecked}} data-form-field>
                                <div class="box-ada__label-box">
                                    <span class="box-ada__wrap">
                                        <span class="box-ada__img">
                                            <img src="{{ config('view.rackspace_default_images') }}/ada-complaint.png" alt="ADA COMPLIANT">
                                        </span>
                                        <span class="box-ada__text">active</span>
                                    </span>
                                </div>
                                <div class="ada-sign integration__check-box">
                                    <i class="ico ico-check"></i>
                                </div>
                            </label>
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
