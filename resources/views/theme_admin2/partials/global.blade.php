<div class="global-title-wrapper">
		<div class="container">
        <div class="row">
            <div class="col-sm-6 lp-main-title">
                <span class="lp-url-color"> Global Settings @if((@$view->data->globalpagetitle)) {{ @$view->data->globalpagetitle }} @endif</span>
            </div>
                <div class="col-sm-6 text-right">
                    <div class="watch-video">
                        @php
                             if(((@$view->data->videolink) && @$view->data->videolink) || ((@$view->data->wistia_id) && @$view->data->wistia_id)){
                                if((@$view->data->videotitle) && @$view->data->videotitle) {
                                  $wistitle=@$view->data->videotitle;
                                }
                                $wisid=@$view->data->wistia_id;
                        @endphp
                                <a data-lp-wistia-title="{{   $wistitle }}" data-lp-wistia-key="{{ $wisid }}" class="btn-video lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal"><i class="lp-icon-strip camera-icon"></i> &nbsp;<span class="action-title">Watch how to video</span></a>
                        @php
                        }
                        @endphp
                    </div>
                </div>
        </div>
    </div>
</div>
