@extends("layouts.leadpops")

@section('content')
    <section id="page-ada-accessibility">
        <div class="container">
            @php
                LP_Helper::getInstance()->getFunnelHeader($view);
            @endphp
            <form class="form-inline" id="add-ada-accessibility" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id"  value="{{ $view->data->client_id }}">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ $view->data->currenthash }}">
                <div class="lp-seo">
                    <div class="lp-seo-head ada_accessibility">
                        <div class="ada_accessibility__holder">
                            <div class="row">
                                @php
                                    $inactiveChecked="checked";
                                    $activeChecked="";
                                    if(@$view->data->ada_accessibility['is_ada_accessibility'] == "1"){
                                        $inactiveChecked="";
                                        $activeChecked="checked";
                                    }
                                @endphp
                                <div class="col col-md-6">
                                    <div class="form-group">
                                        <div class="input-wrap custom-radio-btn">
                                            <input {{ $inactiveChecked }} name="is_ada_accessibility" value="0" type="radio">
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
                                            <input {{ $activeChecked }} name="is_ada_accessibility" value="1" type="radio">
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
                                        <button type="submit" class="btn btn-success"><strong>SAVE</strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('partials.watch_video_popup')
@endsection
