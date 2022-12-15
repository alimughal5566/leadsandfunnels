
<!--****************WATCH VIDEO POPUP HTML*****************-->
<div class="modal fade add_recipient video-modal" id="lp-video-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><span>How To Video:</span><?php echo $view->data->videotitle; ?></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="ifram-wrapper">
                        <div class="video">
                            @php
                            $thumbnail=LP_ASSETS_PATH."/adminimages/videoph.png";
                            if(isset($view->data->videothumbnail) && $view->data->videothumbnail!=""){
                                $thumbnail=$view->data->videothumbnail;
                            }
                            if(isset($view->data->wistia_id) && $view->data->wistia_id){
                            @endphp

                            <div class="video__youtube" data-wistia="wistia-video" >
                                <img src="{{ $thumbnail }}" class="video__placeholder" />
                                <button class="video__button" data-video-title="@php if(isset($view->data->videotitle) && $view->data->videotitle) echo $view->data->videotitle; @endphp" data-wistia-button="@php if(isset($view->data->wistia_id) && $view->data->wistia_id) echo $view->data->wistia_id; @endphp" ></button>
                            </div>

                            @php
                            }
                            elseif( isset($view->data->videolink) && $view->data->videolink ){
                            @endphp

                            <div class="video__youtube" data-youtube="youtube-video">
                                <img src="{{ $thumbnail }}" class="video__placeholder" />
                                <button class="video__button" data-video-title="@php if(isset($view->data->videotitle) && $view->data->videotitle) echo $view->data->videotitle; @endphp" data-youtube-button="@php if(isset($view->data->videolink) && $view->data->videolink) echo $view->data->videolink; @endphp"></button>
                            </div>

                            @php } @endphp
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

<!-- ************ Support Ticket Request Popup ************ -->
<div class="modal fade support" id="model_cloneFunnelSupportTicket">
    <div class="modal-dialog">
        <div class="contact-section lp-comment">
            <div><h3 class="contact-title">Submit a Support Request</h3></div>
            <div class="modal-body">
                <div class="add-ip">
                    <div class="row">
                        <form name="lp-support-form" id="global-lp-support-form" method="post" action="{{ LP_PATH }}/support/feed" class="form-horizontal">
                            <div class="row">
                                <div class="form-group subject-wrap">
                                    <div class="col-md-2">
                                        <label class="control-label label-subject" for="subject">Category</label>
                                    </div>
                                    <div class="col-md-4 form-group no-padding">
                                        <select name="maintopic" id="global_maintopic" class="lp-select2" data-style="comment-btn" data-width="310px">
                                            <option value="">Select Category</option>
                                            @php
                                            $first_key="";
                                            foreach ($view->data->global_maintopic as $key => $title) {
                                            if($first_key=="") $first_key=$key;
                                            if(isset($view->data->request) && $key == $view->data->request['type']) $sel_attr = " selected";
                                            else $sel_attr = "";
                                            @endphp
                                            <option value="{{ $key }}"{{ $sel_attr }}>{{ $title }}</option>
                                            @php } @endphp
                                        </select>
                                        <div id="global_errmaintopic"></div>
                                    </div>
                                    <input type="hidden" name="issuedatainfo" id="global_issuedatainfo" value='{{ json_encode($view->data->global_subissuedata) }}'>
                                    <div class="col-md-2 align-right">
                                        <label class="control-label label-subject" for="subject">Topic</label>
                                    </div>
                                    <div class="col-md-4 form-group no-padding">
                                        <select name="mainissue" id="global_mainissue" class="lp-select2" data-style="comment-btn" data-width="310px">
                                            <option value="">Select Topic</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group subject-wrap">
                                    <div class="col-md-2">
                                        <label class="control-label label-subject" for="subject">Subject</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input class="form-control sub-control" value="" name="subject" id="global_subject" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <textarea name="message" id="global_message" class="form-control lp-comment-text valid" aria-required="true" aria-invalid="false"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="lp-modal-footer block-footer global_ticket_notif"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="lp-modal-footer block-footer">
                                        <input id="global_btn-spt-form" type="button" name="btn-spt-form" value="SUBMIT" class="btn comment-submit-btn"> &nbsp;
                                        <a data-dismiss="modal" class="btn lp-btn-cancel ip-btn">Close</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
