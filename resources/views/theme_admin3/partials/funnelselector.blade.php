<div class="modal fade global-setting-pop global-setting-pop-funnel"  data-backdrop="static"  id="funnel-selector">
    <div class="modal-dialog modal-extra__dailog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Zapier Funnel Selector</h5>
            </div>
            <div class="modal-body quick-scroll">
                <div class="funnel-search">
                    <div class="funnel-search__category" id="funnel-search-by-zapier-parent">
                        <select name="funnel-search-by-zapier" id="funnel-search-by-zapier">
                            <option value="n">Search by Funnel Name</option>
                            <option value="t">Search by Funnel Tags</option>
                        </select>
                    </div>
                    <div class="funnel-search__input">
                        <div class="funnel-search__input-name" id="search-funnel-by-name">
                            <div class="input__wrapper modal__funnel-search m-0">
                                <input class="form-control search-bar zapier-funnel-name-search" id="searchInput" placeholder="Type in the Funnel Name ..." type="text">
                                <span class="search"  onclick="zapierFunnelFilter();"><i class="ico ico-search"></i></span>
                            </div>
                        </div>
                        <div class="funnel-search__input-tag"id="search-funnel-by-tag">
                            <div class="input__holder lp-tag modal__funnel-search m-0">
                                <div class="select2 select2js__nice-scroll w-100 tag-result-common zapier-funnel-tag-parent" id="_zapier-funnel-tag-parent">
                                    <select class="form-control tag-drop-down-pop zapier-funnel-tag" multiple id="tag_list-pop-zapier">
                                        @php(
                                         $tags_list = tag_list()
                                        )
                                        @if($tags_list)
                                            @foreach($tags_list as $t)

                                                <option value="{!! $t->tag_name !!}">{!! $t->tag_name !!}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <span class="search" onclick="zapierFunnelFilter();"><i class="ico ico-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="funnel__wrapper">
                    <div class="selection-setting">
                        <div class="checkbox">
                            <input type="checkbox" id="integration-all-funnel-checkbox" name="all" value="">
                            <label class="funnel-label" for="integration-all-funnel-checkbox"></label>
                            <span class="text">Select all funnels</span>
                        </div>
                        <a href="#" id="reset-filter" class="reset"><i class="ico ico-undo"></i>Reset</a>
                        <span class="funnel-no-text">Total Funnels Selected: <span class="no" id="zapier_all_selected"></span></span>
                    </div>
                    <div class="accordion integration-funnels" id="zapier_funnelsExample">
                        {{--integration funnel--}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                        </li>
                        <li class="action__item">
                            <input type="hidden" class="tag-type" value="1">
                             <input type="hidden" name="current_hash"  value="{{ LP_Helper::getInstance()->getFunnelData()["funnel"]['hash'] }}">
                            <button type="submit" class="button button-bold button-primary" id="zapier_save_integrations">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Select Funnel message modal-->
<div class="modal fade add_recipient home_popup"  data-backdrop="static"  id="funnle_selector-lp-alert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Alert!</h3>
            </div>
            <div class="modal-body model-action-body">
                <form action="" method="post" id="add-code-popup" class="form-inline lp-popup-form">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="popup-wrapper modal-action-msg-wrap">
                                    <div class="funnel-message modal-msg">You Must Select a Funnel <br>Please select at least one Funnel.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-modal-footer footer-border">
                                <a data-dismiss="modal" class="btn lp-btn-cancel funnel_selector_alert_close">Close</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Preconfigured ZAP Templates -->
<div class="modal fade add_recipient home_popup"  data-backdrop="static"  id="lp_zap_templates">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">leadPops Zap Templates</h3>
            </div>
            <div class="modal-body model-action-body  quick-scroll">
                <form action="" method="post" id="add-code-popup" class="form-inline lp-popup-form">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-md-12">
                                <script type="text/javascript" src="https://zapier.com/apps/embed/widget.js?services=leadpops&limit=15"></script>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
