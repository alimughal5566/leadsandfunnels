@extends("layouts.leadpops-inner")

@section('content')
    <!-- content of the page -->
    <main class="main">
        <section class="main-content header-page">
            <!-- Title wrap of the page -->
            <div class="main-content__head">
                <div class="col-left">
                    <h1 class="title">
                        Marketing Hub
                    </h1>
                </div>
                <div class="col-right">
                    @if((isset($view->data->videolink) && $view->data->videolink) || (isset($view->data->wistia_id) && $view->data->wistia_id))
                        <a data-lp-wistia-title="{{ $view->data->videotitle }}" data-lp-wistia-key="{{ $view->data->wistia_id }}"
                           class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span>
                            <span class="action-title">
                                    WATCH HOW-TO VIDEO
                                </span>
                        </a>
                    @endif
                </div>
            </div>
            <!-- content of the page -->
            <div class="grid-list">
                @foreach($view->data->result as $marketingHubData)
                    <div class="grid-list__item">
                        <div class="grid-panel">
                            <div class="grid-panel__head">
                                <h2 class="grid-panel__title">{{ $marketingHubData['title'] }}</h2>
                            </div>
                            <div class="grid-panel__body">
                                @php
                                    if($marketingHubData["action"] != "" && $marketingHubData["action"] != NULL){
                                        $detailsLink = LP_BASE_URL.LP_PATH."/".$marketingHubData["action"];
                                    }else if($marketingHubData['filename']){
                                        $detailsLink = LP_BASE_URL.'/images/marketinghub/'.$marketingHubData['filename'];
                                      }
                                @endphp
                                <a class="pdf-link" href="{{ $detailsLink }}" target="_blank" >
                                    @if(!empty($marketingHubData["logo"]) && file_exists("images/marketinghub/" . $marketingHubData["logo"]))
                                        <div class="pdf-thumbnial" style="background-image: url('{{ LP_BASE_URL."/images/marketinghub/" . $marketingHubData["logo"] }}')"></div>
                                    @else
                                        PDF thubmnail <br>
                                        placeholder
                                    @endif
                                </a>
                            </div>
                            <div class="grid-panel__footer">
                                <a href="{{ $detailsLink }}" target="_blank">
                                    <img src="{{ config('view.rackspace_default_images') }}/pdf-icon.png" alt="pdf icon">
                                    {{ $marketingHubData['summary'] }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- footer of the page -->
            <div class="footer">
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                </div>
            </div>
        </section>
    </main>
@endsection
