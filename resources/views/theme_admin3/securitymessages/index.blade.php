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
   // dd($view->data->messages);
    @endphp

    <main class="main">

        <!-- content of the page -->
        <section class="main-content security-message">
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
                            Security Messages
                            <span class="question-mark el-tooltip" title="Tooltip Content">
                                    <span class="ico ico-question"></span>
                                </span>
                        </h2>
                    </div>
                    <div class="col-right">
                        {{-- <a href="{{route('createTcpaFromPage', [@$view->data->currenthash])}}"
                            class="button button-primary">add new message</a>--}}
                        <a class="button button-primary" href="#create-message" data-toggle="modal">create new
                            message</a>
                    </div>
                </div>
                <!-- content page body -->
                <div class="lp-panel__body">
                    <div class="lp-table">
                        <div class="lp-table__head">
                            {{--<ul class="lp-table__list">
                                <li class="lp-table__item">
                                        <span class="text-wrap">
                                            Message Name
                                            <span class="sorting-opener-wrap">
                                                <a href="#" class="sort-up"></a>
                                                <a href="#" class="sort-down"></a>
                                            </span>
                                        </span>
                                </li>
                                <li class="lp-table__item">
                                        <span class="text-wrap">
                                            Date Created
                                             <span class="sorting-opener-wrap">
                                                <a href="#" class="sort-up"></a>
                                                <a href="#" class="sort-down"></a>
                                            </span>
                                        </span>
                                </li>
                                <li class="lp-table__item">
                                    <span class="text-wrap">Status</span>
                                </li>
                            </ul>--}}


                            <ul class="lp-table__list">
                                <li class="lp-table__item">
                                    <span>Message Name</span>
                                </li>
                                <li class="lp-table__item">
                                    <span>Applied to</span>
                                </li>
                                <li class="lp-table__item">Options</li>
                            </ul>

                        </div>
                        <div class="lp-table__body">

                            @if(@$view->data->messages)
                                @foreach($view->data->messages as $oneMessage)
                                    <div class="lp-table-item tcp-message-data">
                                        <ul class="lp-table__list " id="rcp_{{ $oneMessage['security_message_id'] }}">
                                            <li class="lp-table__item">
                                        <span>
                                            {{$oneMessage['security_message_title']}}
                                            <span class="question-mark el-tooltip" title="Tooltip Content">
                                                <span class="ico ico-question"></span>
                                            </span>
                                        </span>
                                            </li>
                                            <li class="lp-table__item">
                                            <span>{{isset($oneMessage['used_in_questions'])? $oneMessage['used_in_questions']: 0 }}
                                                questions</span>
                                            </li>
                                            <li class="lp-table__item">
                                                <div class="action action_options">
                                                    <ul class="action__list action_options-btns-list">
                                                        <li class="action__item">
                                                            <a href="{{route('EditSecurityMessagesFromPage', [@$view->data->currenthash, $oneMessage['security_message_id']])}}"
                                                               class="action__link edit-recipient el-tooltip"
                                                               data-id="158673" data-name="John Douglas"
                                                               data-email="muhammad.akram@leadpops.com"
                                                               data-cell="(618) 886-6984"
                                                               data-carrier="messaging.sprintpcs.com" data-text="Edit" title='<div class="security-info-tooltip">Edit</div>'>
                                                                <span class="ico ico-edit"></span>edit
                                                            </a>
                                                        </li>
                                                        <li class="action__item">
                                                            <a href="#" data-toggle="modal" data-delete-security data-id="{{$oneMessage['security_message_id']}}" data-target="#security-message-confirmation" class="action__link el-tooltip" data-text="Delete" title='<div class="security-info-tooltip">delete</div>'><i  class="ico-cross"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <ul class="action__list">
                                                        <li class="action__item">
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                @endforeach

                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                </div>
            </div>


            <!--create new message-->

            <div class="modal fade" id="create-message" tabindex="-1" role="dialog" aria-labelledby="create-message"
                 aria-hidden="true">


                <form id="createMessageForm" name="createMessageForm" method="post"
                      data-global_action="{{route('CreateSecurityMessage')}}"
                      data-action="{{route('CreateSecurityMessage')}}"
                      action=""
                      class="form-pop global-content-form">
                    {{csrf_field()}}


                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Create New Message</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-group m-0">
                                    <label for="message-name" class="modal-lbl">New Message Name</label>
                                    <input name="security_message_title" id="security_message_title"
                                           value="" class="form-control" type="text">
                                </div>
                            </div>

                            <input name="client_id" type="hidden" value="{{$view->data->client_id}}">
                            <input type="hidden" name="current_hash" id="current_hash"
                                   value="@php echo @$view->data->currenthash @endphp">
                            <input type="hidden" name="clickedkey" id="clickedkey" value="{{ @$view->data->lpkeys }}">


                            <div class="modal-footer">
                                <div class="action">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <button type="button" class="button button-cancel" data-dismiss="modal">
                                                Cancel
                                            </button>
                                        </li>
                                        <li class="action__item">
                                            {{--<a href="create-security-messages.php" id="createSecurityMsgBtn" class="button button-primary">Next</a>--}}
                                            <button type="button" id="createSecurityMsgBtn"
                                                    class="button button-primary">Next
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </section>


    </main>


    <form id="deleteMessageForm" name="deleteMessageForm" method="post"

          data-global_action="{{route('deleteSecurityMessage')}}"
          data-action="{{route('deleteSecurityMessage')}}"
          action=""
          class="form-pop global-content-form">
        {{csrf_field()}}
        <input name="message_id" id="message_id" type="hidden">
        <input name="client_id" id="del_client_id" type="hidden" value="{{$view->data->client_id}}">
        <input type="hidden" name="current_hash" id=""
               value="@php echo @$view->data->currenthash @endphp">
        <input type="hidden" name="clickedkey" id="clickedkey" value="{{ @$view->data->lpkeys }}">

    </form>

    {{--   <form id="createMessageForm" name="createMessageForm" method="post"

             data-global_action="{{route('toggleTcpaMessage')}}"
             data-action="{{route('toggleTcpaMessage')}}"
             action=""
             class="form-pop global-content-form">
           {{csrf_field()}}
           <input name="security_message_title" id="security_message_title" type="hidden">
           <input name="client_id" id="toggle_client_id" type="hidden" value="{{$view->data->client_id}}">
           <input type="hidden" name="current_hash" id="current_hash"
                  value="@php echo @$view->data->currenthash @endphp">
           <input type="hidden" name="clickedkey" id="clickedkey" value="{{ @$view->data->lpkeys }}">

       </form>--}}
    <!-- Security Message Confirmation Modal -->
    <div class="modal fade global-confirmation-modal" id="security-message-confirmation">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Your Security Message</h5>
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


@endsection

@push('footerScripts')
    <script src="{{ config('view.theme_assets') . "/js/security_messages/security_message_index.js?v=" . LP_VERSION }}"></script>
@endpush
