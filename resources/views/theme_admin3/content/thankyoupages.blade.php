@extends("layouts.leadpops-inner-sidebar")

@section('content')
    <main class="main">
        <section class="main-content">
            <form id="thankyou-pages-form" method="post"
                  class="global-content-form"
                  action="{{route('thankyou.pages.duplicate')}}"
                  method="POST">
                {{-- Title Header & Watch How To Video --}}
                @php LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view) @endphp

                @include("partials.flashmsgs")

                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id" value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="current_hash" id="current_hash" value="@php echo @$view->data->currenthash @endphp">


                <!-- content of the page -->

                <div class="funnel-wrap">
                    <!-- Thank you page Listing -->

                    <div class="funnel-panel funnel-panel_thankyou">
                        <div class="funnel-panel__body">
                            <div class="funnel-panel__ty_sortable">
                                <div class="fb-question-items-wrap" data-hbs="thankyouList">
                                    @foreach($view->data->pages as $page)
                                        <div class="fb-question-item @if($page->thirdparty_active == 'y') outside-link @endif" id="{{ $page->id }}">
                                            <div class="fb-question-item__serial"></div>
                                            <div class="fb-question-item__detail">
                                                <div class="fb-question-item__col">
                                                    <div class="icon-text icon-text_link">
                                                        {{ $page->thirdparty_active == 'y' ? '3rd Party URL' : 'Thank You' }}
                                                    </div>
                                                </div>
                                                <div class="fb-question-item__col">
                                                    <div class="tu-url">
                                                        <div class="tu-url__url"> {{ $page->thirdparty_active == 'y' ? $page->thirdparty : $page->thankyou_title }}</div>
                                                    </div>
                                                </div>
                                                <div class="fb-question-item__col fb-question-item__col_control">
                                            <span class="tooltip-info-wrap">
                                                <span class="question-mark el-tooltip" title="TOOLTIP CONTENT">
                                                    <span class="ico ico-question"></span>
                                                </span>
                                            </span>
                                                    <a href="#" class="hover-hide">
                                                        <i class="fbi fbi_dots">
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                        </i>
                                                    </a>
                                                    <ul class="lp-control">
                                                        <li class="lp-control__item">
                                                            <a title="<div class='thankyou-tooltip'> Conditional Logic is a feature that is in<br> development and will be coming soon.</div>"
                                                               class="lp-control__link el-tooltip conditional-logic-link" href="#">
                                                                <i class="lp-icon-conditional-logic ico-back"></i>
                                                            </a>
                                                        </li>
                                                        <li class="lp-control__item lp-control__item_edit">
                                                            <a title="Edit" class="lp-control__link el-tooltip"
                                                               href="{{ route('thankyou', ['id' => $page->id, 'hash' => $view->data->currenthash]) }}">
                                                                <i class="ico-edit"></i>
                                                            </a>
                                                        </li>
                                                        <li class="lp-control__item">
                                                            <a title="<div class='thankyou-tooltip'> Duplicate Thank You page a feature that is<br> in development and coming soon.</div>"                                                              class="lp-control__link el-tooltip lp-control__link__copy"
                                                               href="javascript:;" data-submission-id="{{ $page->id }}" data-hash="{{ $view->data->currenthash }}">
                                                                <i class="ico-copy"></i>
                                                            </a>
                                                        </li>
                                                        @if(count($view->data->pages) > 1)
                                                        <li class="lp-control__item" data-hide>
                                                            <a title="Move"
                                                               class="lp-control__link lp-control__link_cursor_move el-tooltip"
                                                               href="#">
                                                                <i class="ico-dragging"></i>
                                                            </a>
                                                        </li>
                                                        <li class="lp-control__item" data-hide>
                                                            <a title="Delete"
                                                               class="lp-control__link el-tooltip delete-page"
                                                                href="javascript:;" data-toggle="modal"
                                                               data-existing="1" data-submission-id="{{ $page->id }}">
                                                                <i class="ico-cross"></i>
                                                            </a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
{{--                                    {{ $view->data->pages->links('vendor.pagination.custom') }}--}}
                                </div>
                                @if(@$view->data->submission['leadpop_version_id'] == config('funnelbuilder.funnel_builder_version_id') && 1==2)
                                    <div class="funnel-panel__add">
                                        <div class="add-btn-wrap">
                                            <div class="add-box add-box_page add-thankyou_page" data-backdrop="static" data-keyboard="false">
                                                <i class="lp-icon-plus lp-icon-plus_large ico-plus"></i>
                                                <span class="add-box__text">Add New Page</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="funnel-panel__add disbale-page-option" >
                                        <div class="add-btn-wrap el-tooltip" title='<div class="thankyou-page-tooltip">Add New Thank You Page <br> (coming soon!) </div>'>
                                            <div class="add-box add-box_page" data-backdrop="static" data-keyboard="false">
                                                <i class="lp-icon-plus lp-icon-plus_large ico-plus"></i>
                                                <span class="add-box__text">Add New Page</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- footer of the page -->
                    <div class="footer">
                        <div class="row">
                            <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <!-- delete modal -->
    <div class="modal fade confirmation-delete" id="confirmation-delete-funnel">
        <form action="{{route('thankyou.pages.delete')}}" method="post">
            @csrf
            @method('delete')
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Thank You Page</h5>
                    </div>
                    <div class="modal-body">
                        <p class="modal-msg modal-msg_light">
                            Are you sure, you want to delete the thank you page?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-bold button-cancel" data-dismiss="modal">
                                        No, Never Mind
                                    </button>
                                </li>
                                <li class="action__item">
                                    <button class="button button-bold button-primary" type="button" id="deleteSubmit">Yes, Delete</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@push('body_classes') funnel-thank-you-page @endpush
@push('footerScripts')
    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.runtime.js"></script>
    <script src="{{ config('view.theme_assets') }}/js/funnel/handlebar/templates.js"></script>
    <script src="{{ config('view.theme_assets') }}/js/funnel/thankyou/thankyou-util.js?v={{ LP_VERSION }}"></script>
    <script>
        thankyou_hbar.templtate = 'thankyou-pages.hbs';
    </script>
    <script src="{{ config('view.theme_assets') }}/js/content/thankyou-pages.js?v={{ LP_VERSION }}"></script>
@endpush
