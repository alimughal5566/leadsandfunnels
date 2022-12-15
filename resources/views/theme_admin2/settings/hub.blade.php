@extends("layouts.leadpops")

@section('content')
<div class="menu-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="marketing-title">
                    <h2>Marketing Hub</h2>
                </div>
            </div>
                <div class="col-sm-6 text-right">
                    <div class="watch-video how-to-title">
                        @php
                            if((isset($view->data->videolink) && $this->data->videolink) || (isset($view->data->wistia_id) && $view->data->wistia_id)){
                                    if(isset($this->data->videotitle) && $this->data->videotitle){
                                        $wistitle = $view->data->videotitle;
                                     }
                                    $wisid = $this->data->wistia_id;
                                    @endphp
                                    <a data-lp-wistia-title="<?php echo $wistitle; ?>" data-lp-wistia-key="<?php echo $wisid;  ?>" class="btn-video lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal"><i class="lp-icon-strip camera-icon"></i> &nbsp;<span class="action-title">Watch how to video</span></a>
                          @php
                           }
                        @endphp
                   </div>
               </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="lp-marketing-hub">
        <div class="row gutter-15">
            @php
                $col_per_row=4;
                $i=0;
            foreach ($view->data->result as $d){
                    $i++;
                @endphp
                <div class="col-sm-3 ">
                    <div class="marketing-wrapper">
                        <div class="marketing-heading">
                            {{ $d['title'] }}
                        </div>
                        <div class="marketing-body">
                            @php
                                if($d["action"] != "" && $d["action"] != NULL){
                                    $link=LP_BASE_URL.LP_PATH."/".$d["action"];
                                }else if($d['filename']){
                                    $link=LP_BASE_URL.'/images/marketinghub/'.$d['filename'];
                                  }
                            @endphp
                            <a href="{{ $link }}" target="_blank" >
                                @php
                                    $logo=LP_ASSETS_PATH."/adminimages/placeholder.png";
                                    if($d["logo"]){
                                        $logo=LP_BASE_URL."/images/marketinghub/".$d["logo"];
                                    }
                                @endphp

                                <img src="{{ $logo }}" alt="pdf placeholder"></a>
                        </div>
                        <div class="marketing-footer">
                            <div class="footer-wrapper">
                                <a href="{{ $link }}" target="_blank">
                                    <i class="hub-icon" aria-hidden="true"></i>
                                    <span class="pdf-title">{{ $d['summary'] }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
             @php
                 if($i%4==0){
                   echo '</div><div class="row gutter-15">';
                   $i=0;
                   }
                 }
             @endphp
        </div>
    </div>
</div>
@include('partials.watch_video_popup')
@endsection
