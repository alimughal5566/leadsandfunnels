@extends("layouts.leadpops")

@section('content')
<section id="leadpopovery">
    <div id="overlay">
        <i class="fa fa-spinner fa-spin spin-big"></i>
    </div>
</section>
<section id="lpsupport" class="support">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="alert-success" class="alert alert-success alert-dismissible hide">
                </div>
                <div id="alert-danger" class="alert alert-danger alert-dismissible hide">
                </div>
            </div>
        </div>

        <div class="title-wrapper">
            <div class="row ">
                <div class="col-sm-6 lp-main-title">
                    <span class="account-title">Support</span>
                </div>
            </div>
        </div>

        <div class="contact-section info">
            <div class="row">
                <div class="wrapper">
                    <div class="contact-title">Contact Information</div>
                    <div class="col-sm-4 contact-info">
                        <h3><img src="{{ LP_ASSETS_PATH }}/adminimages/mail-icon.png" alt="icon">support@leadPops.com</h3>
                        <h3><img src="{{ LP_ASSETS_PATH }}/adminimages/phone-icon.png" alt="icon">855.leadPops (855.532.3767)</h3>
                    </div>
                    <div class="col-sm-8 contact-info">
                        <img src="{{ LP_ASSETS_PATH }}/adminimages/building-icon.png" alt="icon">
                        <h3>leadPops, Inc.<br>
                            2665 Ariane Dr. Suite 202,<br>
                            San Diego, CA 92117
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="contact-section spt-btn">
                    <ul>
                        <li><a id="lp-chat-wu" href="mailto:support@leadpops.zendesk.com"  class="btn btn-primary">CHAT WITH US</a></li>
                        <li><a href="{{ LP_SCHEDULE_APPOINMENT }}" target="_blank" class="btn btn-primary">SCHEDULE AN APPOINTMENT</a></li>
                        <li><a href="{{ LP_BASE_URL.LP_PATH."/popadmin/hub" }}"  class="btn btn-primary marketing-hub">MARKETING HUB</a></li>

                            @if(LP_Helper::getInstance()->getClientType() != "")
                                <li>
                                    <a href="#" class="btn btn-primary sup-train-lib" data-ov-target="lp-ol-{{ str_replace(' ','-',strtolower(LP_Helper::getInstance()->getClientType())) }}"  id="lp-train-module-sup">VIEW TRAINING LIBRARY</a>
                                </li>
                         @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
               <div id="lp-sup-ticket" class="contact-section lp-comment">
                    <div class="contact-title contact-title-margin">Submit a Support Request</div>
                        <form name="lp-support-form" id="lp-support-form" method="post" action="{{ LP_PATH }}/feed" class="form-horizontal">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6 form-group ">
                                    <label class="control-label label-subject" for="subject">Select Category</label>
                                        <select name="maintopic" id="maintopic" class="lp-select2" data-style="comment-btn" data-width="360px">
                                            <option value="">Select Category</option>
                                             @php
                                                 $first_key="";
                                             @endphp
                                               @foreach ($view->data->maintopic as $key => $title)
                                                @php
                                                    if($first_key=="") $first_key=$key;
                                                    @endphp
                                                    @if(isset($this->data->request) && $key == $this->data->request['type'])
                                                    @php
                                                    $sel_attr = " selected";
                                                    @endphp
                                                    @else
                                                    @php
                                                    $sel_attr = "";
                                                    @endphp
                                                     @endif

                                                    <option value="{{ $key }}"{{ $sel_attr }}>{{ $title }}</option>
                                             @endforeach
                                        </select>
                                        <div id="errmaintopic"></div>
                                </div>
                                <input type="hidden" name="issuedatainfo" id="issuedatainfo" value='{{ json_encode($view->data->subissuedata) }}'>
                                <input type="hidden" name="targetele" id="targetele" value='{{ ($view->data->target_ele)?$view->data->target_ele: "" }}'>
                                <div class="col-md-6 form-group lp-issue ">
                                    <label class="control-label label-subject" for="subject">Select Topic</label>
                                    <select name="mainissue" id="mainissue" class="lp-select2" data-style="comment-btn" data-width="380px" data-select="@if(isset($view->data->request)) {{ $view->data->request['topic'] }} @endif ">
                                        <option value="">Select Topic</option>
                                    </select>
                                    <div id="errissue"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 issue-message" id="issumemessage" name="issumemessage"></div>
                                <input type="hidden" name="mailmsg" id="mailmsg" value="">
                                <input type="hidden" name="mailsubject" id="mailsubject" value="">
                            </div>
                            <div class="row">
                                <div class="form-group subject-wrap">
                                    <div class="col-md-2">
                                        <label class="control-label label-subject" for="subject">Subject</label>
                                    </div>
                                    <div class="col-md-10 spt-sub-input">
                                        <input type="text" class="form-control sub-control" value="@if(isset($view->data->request)) {{  $view->data->request['subject'] }} @endif " name="subject" id="subject">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="lp-comment-box">
                                    <textarea name="message" id="message" class="form-control lp-comment-text">@if(isset($view->data->request)) {{ $view->data->request['message'] }} @endif</textarea>
                                </div>
                            </div>
                            <div class="pull-right">
                            	<input id="btn-spt-form" type="button" name="btn-spt-form" value="SUBMIT" class="form-control btn comment-submit-btn">
                            </div>
                        </form>
                </div>
            </div>
        </div>
        <div id="lp-sup-videos" data-lp-wistia="wistia-lp-video" class="contact-section lp-video video-main-title">
            <h3 class="contact-title video-title-margin">How-to Videos</h3>
            @php
            $homepage=['Homepage Mortgage','Homepage Insurance','Homepage Real Estate'];
            $client_type[]="Homepage ".LP_Helper::getInstance()->getClientType();
            $notallow=array_diff($homepage, $client_type);
            /*debug($notallow,'0','');
            debug($this->data->support_video_data);*/

            $i=1;
            @endphp
            @foreach ($view->data->support_video_data as $group=>$videos)
                @if(!in_array($group, $notallow))
                    <div class="lp-video-expand">
                        <h3 class="lp-video-title">{{ str_replace('-',' > ',str_replace('_',' ',$group)) }}</h3>
                        <span id="{{ $i }}" class="pull-right lp-expand-collapse "><i class="lp-icon-strip expand-icon"></i>&nbsp;<span class="action-title">EXPAND VIDEOS</span></span>
                        <span  class="pull-right lp-expand-collapse lp-collapse deactive"><i class="fa fa-times" aria-hidden="true"></i>COLLAPSE</span>
                    </div>
                    <div class="lp-video-collapse tab{{ $i }}">
                        <div class="row video-row" >
                            @php
                            $k=0;
                            @endphp
                        @foreach ($videos as $vdata)
                                @php
                                  $thumbnail=LP_ASSETS_PATH."/adminimages/videoph_thumb.png";
                                    $k++;
                                @endphp
                            <div class="col-xs-3 lp-video-box">
                                @if($vdata["wistia_id"])
                                    <a href="#" data-lp-wistia-title="@if(isset($vdata["title"]) && $vdata["title"]) {{ $vdata["title"] }} @endif" data-lp-wistia-button="@if(isset($vdata["wistia_id"]) && $vdata["wistia_id"]) {{ $vdata["wistia_id"] }} @endif" class="lpsupportwistia" >
                                        <img class="lp-video-img" src="{{ $thumbnail }}" alt="video">
                                    </a>
                                @elseif($vdata["url"])
                                        @php
                                    $url_data=explode("/", $vdata["url"]);
                                    $embed= end($url_data);
                                        @endphp
                                    <a href="{{ $vdata["url"] }}" class="lpsupportvideo" data-youtubed="{{ $embed }}" data-url="{{ $vdata["url"] }}" >
                                        <img class="lp-video-img" src="{{ $thumbnail }}" alt="video">
                                    </a>
                                @endif
                                <h4>{{ $vdata["title"] }}</h4>
                            </div>
                          @endforeach
                            @php
                           $i++;
                            @endphp
                        </div>
                        <hr class="lp-video-hr ">
                    </div>
                 @endif
               @endforeach
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="contact-section social-media">
                <div class="contact-title social-title-margin">Social Media</div>
                    <ul>
                        <li class="social-media-facebook">
                            <a target="_blank" class="btn" href="{{ LP_SM_FB_LINK }}">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                <span>facebook</span></a>
                        </li>
                        <li class="social-media-twitter"><a target="_blank" href="{{ LP_SM_TWITTER_LINK }}" class="btn btn-primary">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                Twitter</a>
                        </li>
                        <li class="social-media-linkedin"><a target="_blank" href="{{ LP_SM_LINKEDIN_LINK }}" class="btn btn-primary">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                                Linkedin</a>
                        </li>
                        <li class="social-media-instagram"><a target="_blank" href="{{ LP_SM_INSTAGRAM_LINK }}" class="btn btn-primary">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                Instagram</a>
                        </li>
                        <li class="social-media-youtube"><a target="_blank" href="{{ LP_SM_YOUTUBE_LINK }}" class="btn btn-primary">
                                <i class="fa fa-youtube" aria-hidden="true"></i>
                                Youtube</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="contact-section lp-deactivate-account">
                    <div class="contact-title social-title-margin">Deactivate Account</div>
                    <div class="description">
                        Not getting the results you're looking for from Funnels? Be sure to <a class="" target="_blank" href="{{ LP_SCHEDULE_APPOINMENT }}">schedule a FREE 1:1 call</a>  with one of our Marketing Coaches. We can help turbocharge your marketing and referral generation efforts. <br/><br/>
                        Otherwise, you can request to cancel your account by clicking the button below.

                    </div>
                    <a onclick="javascript: return false;" data-toggle="modal" id="lpcancelbtn" class="btn  pull-right">Request Cancellation</a>
                </div>
                <div class="alert" id="lp-alert-resp" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!--****************WATCH VIDEO POPUP HTML*****************-->
<div class="modal fade add_recipient video-modal" id="lp-sup-video-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><span>How To Video:</span>Domain Names</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="ifram-wrapper">
                        <div class="video-lp-wistia">
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-modal-footer footer-border">
                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
            </div>

        </div>
    </div>
</div>

<!--****************Global logo DELETE POPUP HTML*****************-->
<div class="modal fade add_recipient home_popup" id="cancelrequest" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Deactivate Account</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="popup-wrapper modal-action-msg-wrap">
                                <div class="funnel-message modal-msg">Are you sure you want to deactivate your Account?</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-modal-footer footer-border">
                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                    <input type="button" class="btn lp-btn-add" id="cancelrequestbtn" value ="Deactivate">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
