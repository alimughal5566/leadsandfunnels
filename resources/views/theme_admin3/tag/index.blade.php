@extends('layouts.leadpops-inner-sidebar')

@section('content')
        <!-- contain main informative part of the site -->
        <!-- content of the page -->
        @include("partials.flashmsgs")
        <main class="main">
            <section class="main-content">
                <form class="name-tag-form global-content-form" name="set-tag-folder" action=""
                      data-global_action="{{ LP_BASE_URL.LP_PATH}}/global/saveFunnelTagGlobal"
                      data-action="{{ LP_BASE_URL.LP_PATH."/tag/savefunneltag"}}" method="post">
                     {{csrf_field()}}
                    <input type="hidden" name="hash" id="hash" value="{{ $view->data->funnelData['hash'] }}">
                    <input type="hidden" name="clickedkey" id="clickedkey" value="{{@$view->data->lpkeys}}">
                    <input type="hidden" name="old_funnel_name" id="old_funnel_name"  value="{!! $view->data->funnelData['funnel_name'] ?? '' !!}">

                    <!-- Title wrap of the page -->
                    {{ LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view) }}

                    <div class="funnel-notifcations"></div>
                    <!-- content of the page -->
                    <div class="lp-panel lp-tag pb-2">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Name / Folder / Tags
                                </h2>
                            </div>
                        </div>

                        <div class="lp-panel__body lp-panel__body_fb-info">
                            <div class="funnel__name">
                                <div class="funnel__col">
                                    <div class="form-group">
                                        <label for="funnel_name" class="nt-lbl">Funnel Name</label>
                                        <div class="input__wrapper global-disabled">
                                            <input type="text" name="funnel_name" value="{!! $view->data->funnelData['funnel_name'] ?? '' !!}"
                                                   class="funnel_name global-disabled" id="funnel_name" data-form-field>
                                        </div>
                                    </div>
                                </div>
                                <div class="funnel__col">
                                    <div class="form-group">
                                        <label class="nt-lbl text-center">Folder</label>
                                        <div class="input__wrapper">
                                            <div class="select2__folder-parent select2js__nice-scroll">
                                                <select class="select2__folder form-control folder-dropdown" name="folder_list" id="folder_list" data-folder="{{ $view->data->funnelData['leadpop_folder_id'] ?? '' }}" data-form-field>
                                                </select>
                                            </div>
                                        </div>
                                        <span class="edit__field el-tooltip edit-folder-popup" title="<b class='pop-tooltip'>Manage Folders</b>">
                                            <span class="ico ico-edit"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tag_list"  class="nt-lbl">Funnel Tag(s)</label>
                                        <div class="input__wrapper lp-tag">
                                            <div class="select2js__tags-parent tag-result-common tag-result tags-render" data-tags="{{ $view->data->funnelData['funnelTag'] ?? '' }}">
                                                <select class="form-control tag-drop-down" name="tag_list[]" id="tag_list" multiple data-form-field-custom-cb>
                                                </select>
                                            </div>
                                        </div>
                                        <span class="edit__field el-tooltip edit-tag-popup" title="<b class='pop-tooltip'>manage tags</b>">
                                                <span class="ico ico-edit"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer of the page -->
                    <div class="footer">
                        {{--<div class="row">--}}
                            {{--<button type="submit" hidden class="button button-secondary">Save</button>--}}
                        {{--</div>--}}
                        @include("partials.footerlogo")
                    </div>
                </form>
            </section>
        </main>

        <div class="modal fade add-folder"id="add-folder" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Folders</h5>
                        </div>
                        <div class="folder-notifcations">
                        </div>
                        <div class="modal-body pb-0">
                            <form action="" method="post" name="add-folder" class="add-folder-form form-pop" novalidate="novalidate">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="lp-group">
                                            <label class="control-label" for="add-folder">Add New Folder</label>
                                            <div class="row">
                                                <div class="col-9">
                                                    <div class="form-group m-0">
                                                        <div class="input__holder">
                                                            <input type="text" name="folder_name" class="form-control" id="folder_name" placeholder="New Folder" required aria-required="true">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3 pl-0">
                                                    <input type="submit" class="button folder-btn" value="Add Folder">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                            <div class="folder-list">
                                <div class="folder-col">
                                    <div class="col">
                                        <h3>Folder Name</h3>
                                    </div>
                                    <div class="col">
                                        <h3>Options</h3>
                                    </div>
                                </div>
                                <div class="folder-listing">
                                    <div class="sorting ui-sortable">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item">
                                        <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                                    </li>
                                    <li class="action__item">
                                        <a href="#" class="button button-primary lp-btn-add btnAction_sort">Save</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="modal fade add-folder" data-backdrop="static"  id="add-tag">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Global Tag Management</h5>
                    </div>
                    <div class="tag-notifcations">
                    </div>
                    <div class="modal-body pb-0">
                        <form action="" method="post" name="add-folder" class="add-tag-form form-pop" novalidate="novalidate">
                            <div class="row">
                                <div class="col-12">
                                    <div class="lp-group">
                                        <label class="control-label" for="tag_name">Add New Tag</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group m-0">
                                                    <div class="input__holder">
                                                        <input type="text" name="tag_name" class="form-control" id="tag_name" placeholder="New Tag" required="" aria-required="true">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 pl-0">
                                                <input type="submit" class="button tag-btn" value="Add Tag">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                        <div class="folder-list">
                            <div class="folder-col">
                                <div class="col">
                                    <div class="tag-name-col">
                                        <h3>Tag Name</h3>
                                        <div class="sorting-btns-wrap">
                                            <span class="sort-up active tag-sort" data-sort="asc"></span>
                                            <span class="sort-down tag-sort" data-sort="desc"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h3>Options</h3>
                                </div>
                            </div>
                            <div class="folder-listing tag-listing">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade add_recipient home_popup in" data-backdrop="static"  id="delete_folder">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-action-header">
                        <h3 class="modal-title modal-action-title">Delete Tag</h3>
                    </div>
                    <div class="modal-body model-action-body">
                        <div class="lp-lead-modal-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="modal-action-msg-wrap">
                                        <div class="funnel-message modal-msg">Are you sure to delete this tag?</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer lp-modal-footer footer-border">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                                </li>
                                <li class="action__item">
                                    <input class="button button-primary lp-btn-add" id="delete" value="delete" type="button">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
