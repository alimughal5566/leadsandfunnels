@extends("layouts.leadpops")

@section('content')
    @php
    if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
        $firstkey = @$view->data->clickedkey;
    }else {
        $firstkey = "";
    }
    @endphp
    <section id="page-seo">
        <div class="container">
            @php
                LP_Helper::getInstance()->getFunnelHeader($view);
                $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
            @endphp
            <form class="form-inline" id="add-seo" method="POST" action="{{ LP_BASE_URL.LP_PATH."/popadmin/seosave" }}">
                {{ csrf_field() }}
                <input type="hidden" name="theselectiontype" id="theselectiontype"  value="edittags">
                <input type="hidden" name="client_id" id="client_id"  value="{{ $view->data->client_id }}">
                <input type="hidden" name="firstkey" id="firstkey" value="{{ $firstkey }}">
                <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $firstkey }}">
                <input type="hidden" name="treecookie" id="treecookie" value="{{ $treecookie }}">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ $view->data->currenthash }}">
                <div class="lp-seo">
                    <div class="lp-seo-head">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="col-left">
                                    <h2 class="lp-heading-2">Title Tag</h2>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-btn-toggle">
                                    @php
                                    $checked="";
                                    if(@$view->data->seo['titletag_active']=='y'){
                                        $checked="checked";
                                    }
                                    @endphp
                                    <input {{ $checked }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox" class="seotogbtn" data-lpkeys="{{ $view->data->lpkeys }}~titletag_active" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-seo-box">
                                <input type="text" class="lp-tg-textbox" name="titletag"  id="titletag" value="{{($view->data->seo)?$view->data->seo['titletag']:'' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-seo">
                    <div class="lp-seo-head">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="col-left">
                                    <h2 class="lp-heading-2">Description</h2>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-btn-toggle">
                                    @php
                                    $checked="";
                                    if(@$view->data->seo['description_active']=='y'){
                                        $checked="checked";
                                    }
                                    @endphp
                                    <input {{ $checked }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox" class="seotogbtn" data-lpkeys="{{ $view->data->lpkeys }}~description_active">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-seo-box">
                                <textarea class="lp-seo-textbox" name="description" id="description">{{($view->data->seo)?$view->data->seo['description']:'' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-seo">
                    <div class="lp-seo-head">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="col-left">
                                    <h2 class="lp-heading-2">Keywords</h2>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-btn-toggle">
                                    @php
                                    $checked="";
                                    if(@$view->data->seo['metatags_active']=='y'){
                                        $checked="checked";
                                    }
                                    @endphp
                                    <input {{ $checked }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox" class="seotogbtn" data-lpkeys="{{ $view->data->lpkeys }}~metatags_active">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-seo-box">
                                <textarea class="lp-seo-textbox" name="metatags"  id="metatags"> {{($view->data->seo)?$view->data->seo['metatags']:'' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-save">
                            <div class="custom-btn-success">
                                <button type="submit" class="btn btn-success"><strong>SAVE</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('partials.watch_video_popup')
@endsection
