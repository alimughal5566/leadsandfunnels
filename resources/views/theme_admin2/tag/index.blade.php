@extends("layouts.leadpops")
@section('content')
        <div class="container">
                        @php
                            LP_Helper::getInstance()->getFunnelHeader($view);
                        @endphp
                        <form action="" method="post" name="set-tag-folder" class="set-tag-folder">

                            <div class="funnel-notifcations">

                            </div>
                        <div class="lp-tag-main">
                            <div class="lp-tag">
                            <div class="lp-tag-main-head">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>Name & Tags</h2>
                                    </div>
                                </div>
                            </div>
                                <div class="row tag-section funnel_validate">
                                    <div class="label-block">
                                        <h2 class="tag-funnel-title">Funnel Name</h2>
                                    </div>
                                    <div class="tag-block">
                                        <input type="text" name="funnel_name" value="{!! @$view->data->funnelData['funnel_name'] !!}" class="funnel_name" id="funnel_name" data-funnel-name="{!! @$view->data->funnelData['funnel_name'] !!}">
                                        <label class="error" for="funnel_name"></label>
                                    </div>
                                    <div class="folder-label">
                                        <h2 class="tag-funnel-title">Folder</h2>
                                    </div>
                                    <div class="folder-result">
                                        <select class="form-control folder-dropdown" name="folder_list" id="folder_list"  data-folder="{{@$view->data->funnelData['leadpop_folder_id'] }}">
                                        </select>
                                    </div>
                                    <div class="edit-folder-icon tag-tooltip edit-folder-popup" data-toggle="tooltip" data-placement="top" data-html="true"  title="EDIT FOLDERS">
                                        <div class="edit-folder-modal">
                                            <a href="#">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row tag-section">
                                    <div class="label-block">
                                        <h2 class="tag-funnel-title">Funnel Tags</h2>
                                    </div>
                                    <div class="tag-block-select">
                                        <div class="tag-result"  data-tags="{{@$view->data->funnelTag }}">
                                        <select class="form-control tag-drop-down" name="tag_list" id="tag_list" multiple>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="edit-folder-icon tag-tooltip edit-tag-popup"  data-toggle="tooltip" data-placement="top" data-html="true"  title="MANAGE GLOBAL TAGS">
                                        <div class="edit-folder-modal">
                                            <a href="#">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </div>
                            <div class="row">
                                <div class="col-sm-12" align="center">
                                    <input type="submit" class="btn saved-btn" value="Save">
                                </div>
                            </div>
                        </form>
                </div>
    @include('partials.watch_video_popup')
@endsection
