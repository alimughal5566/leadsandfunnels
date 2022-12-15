@extends("layouts.leadpops")

@section('content')
    @php
    if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
        $firstkey = @$view->data->clickedkey;
    }else {
        $firstkey = "";
    }
    // debug(@$view->data->contact);
    @endphp
    <section id="page-thank-you">
        <div class="container">
            @php
            LP_Helper::getInstance()->getFunnelHeader(@$view);
            $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id, $firstkey);
            @endphp
            <form role="form" id="thankyou-page-from" class="form-inline" method="post" action="@php echo LP_BASE_URL.LP_PATH."/popadmin/thanksettingsave"; @endphp">
                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id"  value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="theoption" id="theoption"  value="thirdparty">
                <input type="hidden" name="changebtn" id="changebtn"  value="0">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash" value="@php echo @$view->data->currenthash @endphp">
                <div class="lp-thankyou">
                    <div class="lp-thankyou-head">
                        <div class="row">
                            <div class="lp-th-custom-width">
                                <div class="col-md-8">
                                    <div class="col-left"><h2 class="lp-heading-2" >Thank You Page</h2></div>
                                </div>
                                <div class="col-md-2">
                                    <div class="col-center">
                                        <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/thankyoumessage/".@$view->data->currenthash; @endphp"><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="custom-btn-toggle">
                                        @php $checked="";

                                        if(@$view->data->submission['thankyou_active']=='y'){
                                            $checked="checked";
                                        }
                                        @endphp
                                        <input @php echo $checked; @endphp class="thktogbtn" id="thankyou" name="thankyou" data-thelink="thankyou_active" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-custom-para">
                                <p>
                                    Upon submission, your Funnel will take potential
                                    clients to a customizable "Thank You Page".
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-thankyou">
                    <div class="lp-thankyou-head">
                        <div class="row">
                            <div class="lp-th-custom-width-2">
                                <div class="col-md-8">
                                    <div class="col-left"><h2 class="lp-heading-2">Third Party URL</h2></div>
                                </div>
                                <div class="col-md-2">
                                    <div class="col-center">
                                        <a href="javascript::void();" id="eurllink" class="lp_thankyou_toggle"><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="custom-btn-toggle">
                                        @php $checked="";
                                        if(@$view->data->submission['thirdparty_active']=='y'){
                                            $checked="checked";
                                        }
                                        @endphp
                                        <input @php echo $checked; @endphp class="thktogbtn" id="thirldparty" name="thirldparty" data-thelink="thirdparty_active" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-custom-para">
                                <p>
                                    This option gives your potential clients a quick thank you message, and then forwards
                                    them to a third party website of your choice. You can send your potential clients to your company
                                    website, personal website, blog, Facebook page, etc.
                                </p>
                            </div>
                            <div id="lp-thankyou-url-edit" class="col-md-12 hide" >
                                <div class="row">
                                    <div class="lp-thankyou-input custom-btn-toggle">
                                    @php $checked="";
                                    if(@$view->data->submission['https_flag']=='y'){
                                        $checked="selected";
                                    }
                                    @endphp
                                    <!-- <input @php echo $checked; @endphp id="https_flag" class="" name="https_flag"  data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="HTTP://" data-off="HTTPS://" type="checkbox"> -->
                                        <select name="https_flag" id="https_flag" class="lp-select2 cta-font-size" data-width="120px">
                                            <option value="http://">http://</option>
                                            <option value="https://" @php echo $checked; @endphp>https://</option>
                                        </select>
                                        <input type="text" class="lp-thankyou-textbox" id="thirldpurl" name="footereditor" value="@php echo str_replace(array("http://","https://"),"",@$view->data->submission['thirdparty']);@endphp">
                                    </div>
                                </div>
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