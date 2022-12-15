@extends("layouts.leadpops-inner-sidebar")

@section('content')

    <main class="main">
            <!-- content of the page -->
            <section class="main-content">
                <!-- Title wrap of the page -->
                @php
                    LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view);
                    $shareURL = "https://" . @$view->data->funnelData['funnel']['domain_name'];//urlencode("https://fha-refi-9979.dev-funnels.com");//
                    if(@$view->data->funnelData['funnel']['slug_name']){
                    $shareURL = "https://" . config('urlshortener.app_base_url').@$view->data->funnelData['funnel']['slug_name'];
                    }
                    $id =  @$view->data->funnelData['client_leadpop_id'];
                @endphp
                @include("partials.flashmsgs")

                <!-- content of the page -->
                <form id="subdomain" method="post" action="">
                    {{ csrf_field() }}
                    <!-- Hidden Fields -->
                    <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->current_hash }}">
                    <input type="hidden" name="changesubok" id="changesubok" value="">
                    <input type="hidden" name="changedomainok" id="changedomainok" value="">
                    <input type="hidden" name="thedomain_id" id="thedomain_id" value="{{ @$view->data->domain_id }}">
                    <input type="hidden" name="leadpop_id" id="leadpop_id" value="{{ @$view->data->customLeadpopid }}">
                    <input type="hidden" name="version_seq" id="version_seq" value="{{ @$view->data->customLeadpopVersionseq }}">
                    <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
                    <input type="hidden" name="hdomain_name" id="hdomain_name" value="{{ @$view->data->domainname }}">
                    <input type="hidden" name="htop_level" id="htop_level" value="{{ @$view->data->toplevel }}">
                    <input type="hidden" name="domaintype" id="domaintype" value="{{ @$view->data->dtype }}">
                    <input type="hidden" name="hasunlimited" id="hasunlimited" value="{{ @$view->data->unlimitedDomains }}">
                    <input type="hidden" name="beforedomainname" id="beforedomainname" value="{{ !empty(@$view->data->domains) ? @$view->data->domains[0]['domain_name'] : "" }}">

                    <input type="hidden" name="firstkey" id="firstkey" value="{{ $view->data->clickedkey }}">
                    <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $view->data->clickedkey }}">
                    <input type="hidden" name="treecookie" id="treecookie" value="{{ \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$view->data->clickedkey) }}">
                    <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">

                    <div class="sub-domain">
                        <div id="msg"></div>
                        <div class="card domain-card  {{ @$view->data->dtype=='1' ? "active" : "" }}">
                            <div class="card-header">
                                <div class="card-link-wrap">
                                    <label class="card-link">
                                        <input type="radio" name="domain-radio" value="1" {{ (@$view->data->dtype=='1' ? 'checked' : '') }}>
                                        <span class="card-circle"></span>
                                        <span class="h2 card-title"><span>Domain type:</span> sub-domain</span>
                                    </label>
                                </div>
                            </div>
                            <div class="domain-slide"  {{@$view->data->dtype=='1'?'style=display:block':''}}>
                                <div class="card-body">
                                    <div class="card-body__row">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="left-col">
                                                    <div class="checkbox">
                                                        <input type="checkbox" onclick="changesubdomainname()" id="checkboxsubdomainname" {{ (@$view->data->dtype=='1' ? 'checked' : '') }} name="checkboxsubdomainname" value="csn">
                                                        <label class="domain-label" for="checkboxsubdomainname">
                                                            Change sub-domain name
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="subdomainname">Sub-domain Name</label>
                                                        <div class="input__wrapper">
                                                            <input id="subdomainname" name="subdomainname" value="{{ (@$view->data->dtype=='1' ? $view->data->domainname : '') }}" {{ @$view->data->dtype=='1' ? '' : 'disabled' }} class="form-control" type="text" data-form-field>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="right-col">
                                                    <div class="checkbox">
                                                        <input type="checkbox" onclick="changetopleveldomain()" id="checkboxsubdomainnametop" {{ (@$view->data->dtype=='1' ? 'checked' : '') }} name="checkboxsubdomainnametop"  value="csnt" />
                                                        <label class="domain-label" for="checkboxsubdomainnametop">
                                                            Change top level domain
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="subdomaintoplist">Top Level Domain</label>
                                                        <div class="input__wrapper">
                                                            <div class="select2top-lvl-domain-parent select2js__nice-scroll">
                                                                <select class="form-control select2top-lvl-domain" name="subdomaintoplist" id="subdomaintoplist" {{ (@$view->data->dtype=='1' ? '' : 'disabled') }} data-form-field>
                                                                    @php
                                                                        echo \View_Helper::getInstance()->GetClientSubDomainTops(@$view->data->toplevel,@$view->data->client_id);
                                                                        if (@$view->data->client_id == 1344) {
                                                                            echo '<option value="popmortgage.com">popmortgage.com</option>';
                                                                        }else if (@$view->data->client_id == 1233) {
                                                                            echo '<option value="grate-connect.com">grate-connect.com</option>';
                                                                            echo '<option value="bab-connect.com">bab-connect.com</option>';
                                                                            echo '<option value="churchill-connect.com">churchill-connect.com</option>';
                                                                            echo '<option value="fairway-connect.com">fairway-connect.com</option>';
                                                                            echo '<option value="mvnt-connect.com">mvnt-connect.com</option>';
                                                                            echo '<option value="thrive-reach.com">thrive-reach.com</option>';
                                                                        }else if (@$view->data->client_id == 15049) {
                                                                            echo '<option value="tennessee-connect.com">tennessee-connect.com</option>';
                                                                        }
                                                                    @endphp
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="funnel-share">
                                        <div class="lp-panel__body">
                                            <div class="form-group m-0 funnel_url copy-btn-area">
                                                <label for="funnel_url">Funnel URL:</label>
                                                <div class="input__wrapper">
                                                    <div class="input-holder input-holder_icon position-relative">
                                                        <span class="ico ico-lock"></span>
                                                        <div id="funnelUrl" name="funnel_url" class="form-control pl-6 d-flex">
                                                            <div id="url__text" class="url__text">{{(@$view->data->dtype=='1' ? "https://".@$view->data->currenturl : '')}} </div>
                                                            <div class="url__text copy-text copy-text-domain">{{(@$view->data->dtype=='1' ? "https://".@$view->data->currenturl : '')}} </div>
                                                            <div class="short-icon {{($view->data->dtype == 2)?'d-none':''}}">
                                                            <a href="#" class="hover-hide">
                                                                <i class="fbi fbi_dots">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </i>
                                                            </a>
                                                            <ul class="lp-controls">
                                                                <li class="lp-controls__item funnel-url-copy {{(@$view->data->funnelData['funnel']['slug_name'])?"":"d-none"}}">
                                                                    <a href="javascript:void(0)"
                                                                       class="lp-controls__link el-tooltip"  onclick="copyToClipboardDiv('#funnelUrl #url__text', this)"
                                                                       title="Copy Full Funnel URL">
                                                                        <i class="ico-copy"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="lp-controls__item">
                                                                    <a href="{{ "https://" . @$view->data->currenturl }}"
                                                                       target="_blank" class="lp-controls__link el-tooltip"
                                                                       title="Open Funnel Link in New Tab">
                                                                        <i class="fas fa-external-link-alt"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="#" class="form-control link-swatcher el-tooltip {{($view->data->dtype == 2)?'d-none':''}}" id="make_shorten_url" ata-container="body" title="SHORTEN URL">
                                                    <i class="fas fa-exchange-alt"></i>
                                                </a>
                                                <div class="copy-url">
                                                    <button class="button button-bold button-primary copy-btn"
                                                            {{($view->data->dtype == 2)?'disabled':''}} onclick="copyToClipboardDiv('#funnelUrl #url__text', this)">copy url
                                                </button>
                                                </div>
                                            </div>
                                            <div class="url-expand copy-btn-area">
                                                <div class="form-group m-0">
                                                    <label for="shortUrl">Short URL: </label>
                                                    <div class="input__wrapper">
                                                        <div class="input-holder input-holder_icon position-relative">
                                                            <span class="ico ico-link"></span>
                                                            <div id="shortUrl" class="shortUrl ">
                                                                <div class="input-holder">
                                                                    <div class="url-text">{{config('urlshortener.app_base_url')}}/<strong
                                                                            class="inner-text font-weight-normal"></strong></div>
                                                                    <input type="text" name="funnel_url" class="form-control form-url-text"
                                                                           id="url_slug_val" data-id="{{$id}}"
                                                                           value="{{@$view->data->funnelData['funnel']['slug_name']}}" spellcheck="false" readonly>
                                                                </div>
                                                                <a href="#" class="hover-hide">
                                                                    <i class="fbi fbi_dots">
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    </i>
                                                                </a>
                                                                <ul class="lp-controls">
                                                                    <li class="lp-controls__item">
                                                                        <a href="#" class="lp-controls__link lp-controls__edit el-tooltip" title="Edit">
                                                                            <i class="ico ico-edit"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="lp-controls__item">
                                                                        <a href="{{config('urlshortener.app_base_url')."/".@$view->data->funnelData['funnel']['slug_name']}}"
                                                                           class="lp-controls__link el-tooltip" id="short_url_link"
                                                                           target="_blank" title="Open Funnel Link in New Tab"><i
                                                                                class="fas fa-external-link-alt"></i></a>
                                                                    </li>
                                                                </ul>
                                                                <ul class="option_list">
                                                                    <li><a href="#" id="doEditPopUpBtn">Save</a></li>
                                                                    <li><a href="#" id="doCanelEdit" class="cancel-option">Cancel</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="copy-text"
                                                                 id="shortLinkValDiv">{{config('urlshortener.app_base_url')."/".@$view->data->funnelData['funnel']['slug_name']}}</div>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="form-control link-swatcher el-tooltip" id="remove_short_url"
                                                       data-id="{{$id}}" data-container="body"
                                                       title="Remove & Delete This Short URL" ><i class="fas fa-times"></i></a>

                                                    <input type="hidden" class="copy-text"
                                                           value="{{config('urlshortener.app_base_url')."/".@$view->data->funnelData['funnel']['slug_name']}}"
                                                           id="shortLinkVal">


                                                    <button class="button button-bold button-primary copy-btn"
                                                            onclick="copyToClipboardDiv('#shortLinkValDiv', this)">copy url
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card domain-card {{ @$view->data->dtype=='2' ? "active" : "" }}">
                            <div class="card-header">
                                <div class="card-link-wrap">
                                    <label class="card-link">
                                        <input type="radio" name="domain-radio" value="2" {{ (@$view->data->dtype=='2' ? 'checked' : '') }}>
                                        <span class="card-circle"></span>
                                        <span class="h2 card-title"><span>Domain type:</span> domain</span>
                                    </label>
                                </div>
                            </div>
                            <div id="domain" class="domain-slide"  {{@$view->data->dtype=='2'?'style=display:block':''}}>
                                <div class="card-body">
                                    <div class="card-body__row">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="left-col">
                                                    <p class="ip-address">leadPops IP Address 184.106.100.178</p>
                                                    <div class="checkbox">
                                                        <input type="checkbox" onclick="changedomainname()" id="checkboxdomainname" name="checkboxdomainname" value="cdn">
                                                        <label class="domain-label" for="checkboxdomainname">
                                                            Add your own domain name
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="domainname">Domain Name</label>
                                                        <div class="input__wrapper">
                                                            @if(@$view->data->unlimitedDomains)
                                                                <input disabled="disabled" type="text" id="domainname"  name="domainname"  class="domain-textbox textbox-size" value="{{ (@$view->data->dtype=='2' ? @$view->data->domains[0]['domain_name'] : '') }}" data-form-field-custom-cb/>
                                                            @else
                                                                <input disabled="disabled" type="text" id="domainname"  name="domainname"  class="domain-textbox textbox-size" value="{{ (@$view->data->dtype=='2' ? @$view->data->domainname:'') }}" data-form-field-custom-cb/>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="domain-grid">
                                                    @if(isset($view->data->domains) && $view->data->domains !== false)
                                                        @for($i=0; $i<count(@$view->data->domains); $i++)
                                                            <div class="domain-grid__list domain_{{ @$view->data->domains[$i]['clients_domain_id'] }}_{{ @$view->data->client_id }} fd_{{ str_replace(".","",@$view->data->domains[$i]['domain_name']) }}">
                                                                <span class="domain-name">
                                                                    {{ @$view->data->domains[$i]['domain_name'] }}
                                                                </span>
                                                                <div class="action action_options">
                                                                    <ul class="action__list">
                                                                        <li class="action__item">
                                                                            <a data-domain_id="{{ @$view->data->domains[$i]['clients_domain_id'] }}" href="#" class="action__link btn-edit-domain">
                                                                                <span class="ico ico-edit"></span>edit
                                                                            </a>
                                                                        </li>
                                                                        <li class="action__item">
                                                                            <a data-domain_id="{{ @$view->data->domains[$i]['clients_domain_id'] }}" href="#" class="action__link btn-delete-domain">
                                                                                <span class="ico ico-cross"></span>delete
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
                                                            </div>
                                                        @endfor
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- footer of the page -->
                <div class="footer">
                    <div class="row">
                        <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </section>
        </main>

    <!-- Model Boxes - Sub-Domain Available - Start -->
    <div id="modal_subdomain_available"  data-backdrop="static"  class="modal fade lp-modal-box">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sub-domain Available</h5>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light"></p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button id="_save_open_subdomain" class="button button-bold button-primary"  type="button">Save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Model Boxes - Sub-Domain Available - End -->

    <!-- Model Boxes - Domain Available - Start -->
    <div id="modal_domain_available"  data-backdrop="static"  class="modal fade lp-modal-box">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ">Domain Available</h5>
                </div>
                <div class="modal-body ">
                    <p class="modal-msg modal-msg_light"></p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button id="_save_open_domain" class="button button-bold button-primary"  type="button">Save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Model Boxes - Domain Available - End -->

    <!-- Model Boxes - Domain Delete - Start -->
    <div id="modal_delete_domain"  data-backdrop="static"  class="modal fade lp-modal-box">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Delete Domain</h3>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light"></p>
                    <input type="hidden" id="_delete_domain_id" />
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No, Never Mind</button>
                            </li>
                            <li class="action__item">
                                <button id="_delete_domain_btn" class="button button-bold button-primary"  type="button">Yes, Delete</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Model Boxes - Domain Delete - End -->
    @push('footerScripts')
        <script src="{{ config('view.theme_assets') }}/pages/short-url.js?v={{ LP_VERSION }}"></script>
    @endpush
@endsection

