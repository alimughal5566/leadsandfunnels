@extends("layouts.leadpops-inner-sidebar")
@section('content')

    @php
        if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
            $firstkey = @$view->data->clickedkey;
        }else {
            $firstkey = "";
        }


    //    dd($view->data->client_id);

    // dd($firstkey);
    @endphp

    <main class="main">

        <!-- content of the page -->
        <section class="main-content tcpa-message-content">
        @php LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view) @endphp
        @include("partials.flashmsgs")
        @php
            $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
        @endphp

        <!-- content of the page -->
            <div class="lp-panel">
                <!-- content page head -->
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h2 class="lp-panel__title">
                            TCPA Messages
                            <span class="question-mark el-tooltip" title="Tooltip Content">
                                    <span class="ico ico-question"></span>
                                </span>
                        </h2>
                    </div>
                    <div class="col-right">
                        <a href="{{route('createTcpaFromPage', [@$view->data->currenthash])}}"
                           class="button button-primary">add new message</a>
                    </div>
                </div>
                <!-- content page body -->
                <div class="lp-panel__body">
                    <div class="lp-table">
                        <div class="lp-table__head">
                            <ul class="lp-table__list">
                                <li class="lp-table__item">
                                        <span class="text-wrap">
                                            Message Name
                                            <span class="sorting-opener-wrap">
                                                <a href="#" class="sort-up active tcpa-name-sort" data-sort="name-asc"></a>
                                                <a href="#" class="sort-down tcpa-name-sort" data-sort="name-desc"></a>
                                            </span>
                                        </span>
                                </li>
                                <li class="lp-table__item">
                                        <span class="text-wrap">
                                            Date Created
                                             <span class="sorting-opener-wrap">
                                                <a href="#" class="sort-up tcpa-date-sort" data-sort="date-asc"></a>
                                                <a href="#" class="sort-down tcpa-date-sort" data-sort="date-desc"></a>
                                            </span>
                                        </span>
                                </li>
                                <li class="lp-table__item">
                                    <span class="text-wrap">Status</span>
                                </li>
                            </ul>
                        </div>
                        <div class="lp-table__body">

                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                </div>
            </div>


        </section>


    </main>


    <form id="deleteMessageForm" name="deleteMessageForm" method="post"

          data-global_action="{{route('deleteTcpaMessage')}}"
          data-action="{{route('deleteTcpaMessage')}}"
          action=""
          class="form-pop global-content-form">
        {{csrf_field()}}
        <input name="tcpa_message_id" id="del_tcpa_message_id" type="hidden">
        <input name="client_id" id="del_client_id" type="hidden" value="{{$view->data->client_id}}">
        <input type="hidden" name="current_hash" id="current_hash"
               value="@php echo @$view->data->currenthash @endphp">
        <input type="hidden" name="clickedkey" id="clickedkey" value="{{ @$view->data->lpkeys }}">

    </form>


    <form id="toggleMessageForm" name="toggleMessageForm" method="post"

          data-global_action="{{route('toggleTcpaMessage')}}"
          data-action="{{route('toggleTcpaMessage')}}"
          action=""
          class="form-pop global-content-form">
        {{csrf_field()}}
        <input name="tcpa_message_id" id="toggle_tcpa_message_id" type="hidden">
        <input name="client_id" id="toggle_client_id" type="hidden" value="{{$view->data->client_id}}">
        <input type="hidden" name="current_hash" id="current_hash"
               value="@php echo @$view->data->currenthash @endphp">
        <input type="hidden" name="clickedkey" id="clickedkey" value="{{ @$view->data->lpkeys }}">

    </form>

    <!-- TCPA Message Confirmation Modal -->
    <div class="modal fade global-confirmation-modal" id="tcpa-message-confirmation">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Your TCPA Message</h5>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light">
                        Are you sure you want to remove this message?
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel lp-table_no" data-dismiss="modal">
                                    No, Never Mind</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary lp-table_yes" data-delete-yes type="submit">Yes, Delete</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
    $tcpa_message = array();
    foreach($view->data->tcpaMessages as $data)
    {
        $data['tcpa_title'] = str_replace('"','\"',$data['tcpa_title']);
        $data['tcpa_text'] = str_replace('"','\"',$data['tcpa_text']);
        $tcpa_message[] = $data;
    }
    @endphp
@endsection

@push('footerScripts')
    <script>
        var tcpa_records = '{!! str_replace("'","\'",json_encode($tcpa_message)) !!}';
    </script>
    <script src="{{ config('view.theme_assets') . "/js/tcpa/tcpa_index.js?v=" . LP_VERSION }}"></script>
@endpush


