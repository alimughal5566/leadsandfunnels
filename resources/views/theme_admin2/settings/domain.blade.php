@extends("layouts.leadpops")

@section('content')
    @php
    if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
        $firstkey = @$view->data->clickedkey;
    }else {
        $firstkey = "";
    }

    $treecookie = $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
    @endphp
    <div class="container">
        <div class="lp-subdomain-notifcations"></div>
        @php LP_Helper::getInstance()->getFunnelHeader($view); @endphp
    </div>
    <!--DOMAIN-->
    <form class="form-inline" method="post">
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

        <input type="hidden" name="firstkey" id="firstkey" value="{{ $firstkey }}">
        <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $firstkey }}">
        <input type="hidden" name="treecookie" id="treecookie" value="{{ $treecookie }}">
        <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">

        <div class="container">
            <div class="custom-panel" id="accordion">
                <!-- Sub-domain panel -->
                <div class="panel custom-accordion">
                    <div class="panel-heading">
                        <div class="lp-domain-wrapper">
                            <h4 class="panel-title">
                                <a {!! (@$view->data->dtype=='1' ? '' : 'class="collapsed" aria-expanded="false"') !!} data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <i class="lp_radio_icon_lg"></i> Domain type: <span class="domain">provided sub-domain</span>
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse {{ (@$view->data->dtype=='1' ? 'in' : '') }}">
                        <div class="panel-body lp-padding">
                            <div class="lp-domain-body">
                                <div class="lp-sub-domain">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="left-col">
                                                <input type="checkbox" onclick="changesubdomainname()" id="checkboxsubdomainname" name="checkboxsubdomainname" {{ (@$view->data->dtype=='1' ? 'checked' : '') }} value="csn" />
                                                <label class="sub-domain-label" for="checkboxsubdomainname"><span class="lp-checkbox-icon"></span>Change sub-domain name</label>
                                                <div class="sub-domain-div"><label for="sub-domain-textbox" class="sub-domain-labl">Sub-domain Name</label>
                                                    <input type="text" id="subdomainname" name="subdomainname" value="{{ (@$view->data->dtype=='1' ? $view->data->domainname : '') }}" {{ @$view->data->dtype=='1' ? '' : 'disabled' }} class="sub-domain-textbox"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="right-col">
                                                <input type="checkbox" onclick="changetopleveldomain()" id="checkboxsubdomainnametop" name="checkboxsubdomainnametop" {{ (@$view->data->dtype=='1' ? 'checked' : '') }} value="csnt" />
                                                <label class="sub-domain-label" for="checkboxsubdomainnametop"><span class="lp-checkbox-icon"></span>Change top level domain</label>

                                                <div class="sub-domain-div">
                                                    <div class="col-sm-4"><label for="sub-domain-textbox" class="sub-domain-labl">Top Level Domain</label></div>
                                                    <div class="col-sm-8 sub-domain-margin">
                                                        <select class="lp-select2 selectpicker" name="subdomaintoplist" id="subdomaintoplist" data-width="365" {{ (@$view->data->dtype=='1' ? '' : 'disabled') }}>
                                                            @php
                                                            echo \View_Helper::getInstance()->GetClientSubDomainTops(@$view->data->toplevel,@$view->data->client_id);
                                                            if (@$view->data->client_id == 1344) {
                                                                echo '<option value="popmortgage.com">popmortgage.com</option>';
                                                            }
                                                            @endphp
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lp-save">
                                        <div class="custom-btn-success">
                                            <button onclick="verifyopensubdomain()" type="button" class="btn btn-success"><strong>SAVE</strong></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- domain panel -->
                <div class="panel custom-accordion lp-top-space">
                    <div class="panel-heading">
                        <div class="lp-domain-wrapper">
                            <h4 class="panel-title">
                                <a {!! (@$view->data->dtype=='2' ? '' : 'class="collapsed" aria-expanded="false"') !!} data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    <i class="lp_radio_icon_lg"></i> Domain type:&nbsp;<span class="domain">my domain</span>
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse {{ (@$view->data->dtype=='2' ? 'in' : '') }}">
                        <div class="panel-body lp-padding">
                            <div class="lp-domain-body">
                                <div class="lp-sub-domain">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="left-col">
                                                <p>leadPops IP Address 184.106.100.178</p>
                                                <input type="checkbox" onclick="changedomainname()" id="checkboxdomainname" name="checkboxdomainname" value="cdn" />
                                                <label class="domain-label" for="checkboxdomainname"><span></span>Add your own domain name</label>
                                                <div class="sub-domain-div">
                                                    <label for="" class="sub-domain-labl ">Domain Name</label>
                                                    @if(@$view->data->unlimitedDomains)
                                                    <input disabled="disabled" type="text" id="domainname"  name="domainname" class="domain-textbox textbox-size" value="{{ (@$view->data->dtype=='2' ? @$view->data->domains[0]['domain_name'] : '') }}" />
                                                    @else
                                                    <input disabled="disabled" type="text" id="domainname"  name="domainname"  class="domain-textbox textbox-size" value="{{ (@$view->data->dtype=='2' ? @$view->data->domainname:'') }}"/>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-padding">
                                            <div class="right-col domain-grid">
                                                <div class="domain-edit">
                                                    <span>Domain</span> <a href="#">Actions</a>
                                                </div>
                                                @if(isset($view->data->domains) && $view->data->domains !== false)
                                                    @for($i=0; $i<count(@$view->data->domains); $i++)
                                                    <div class="domain-edit domain_{{ @$view->data->domains[$i]['domain_id'] }}_{{ @$view->data->client_id }} domainlist fd_{{ str_replace(".","",@$view->data->domains[$i]['domain_name']) }}" {{ (@$view->data->domains[$i]['domain_name']=="temporary" ? "style='display:none'" : "") }}>
                                                        <span>{{ @$view->data->domains[$i]['domain_name'] }}</span> <a href="#" onclick="deletedomainname('{{ @$view->data->domains[$i]['domain_id'] }}','{{ @$view->data->client_id }}')"><i class="fa fa-remove"></i>DELETE</a><a href="#" onclick="editdomainname('{{ @$view->data->domains[$i]['domain_id'] }}','{{ @$view->data->client_id }}')"><i class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                                    </div>
                                                    @endfor
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lp-save">
                                        <div class="custom-btn-success">
                                            <button type="submit" id="domain_btn" class="btn btn-success"><strong>SAVE</strong></button>
                                        </div>
                                    </div>
                                    <div class="lp-alert lp-domain-notifcations"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Model Boxes - Sub-Domain Available - Start -->
                <div id="modal_subdomain_available" class="modal fade lp-modal-box in">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header modal-action-header">
                                <h3 class="modal-title modal-action-title">Sub-domain Available</h3>
                            </div>
                            <div class="modal-body model-action-body">
                                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                                    <div class="row">
                                        <div class="col-sm-12 modal-action-msg-wrap">
                                            <div class="modal-msg"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-modal-footer lp-modal-action-footer">
                                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                                <a id="_save_open_subdomain" class="btn lp-btn-add">Save</a>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Model Boxes - Sub-Domain Available - End -->

                <!-- Model Boxes - Domain Available - Start -->
                <div id="modal_domain_available" class="modal fade lp-modal-box in">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header modal-action-header">
                                <h3 class="modal-title modal-action-title">Domain Available</h3>
                            </div>
                            <div class="modal-body model-action-body">
                                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                                    <div class="row">
                                        <div class="col-sm-12 modal-action-msg-wrap">
                                            <div class="modal-msg"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-modal-footer lp-modal-action-footer">
                                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                                <button type="button" id="_save_open_domain" class="btn lp-btn-add">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Model Boxes - Domain Available - End -->

                <!-- Model Boxes - Domain Delete - Start -->
                <div id="modal_delete_domain" class="modal fade lp-modal-box in">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header modal-action-header">
                                <h3 class="modal-title modal-action-title">Delete Domain</h3>
                            </div>
                            <div class="modal-body model-action-body">
                                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                                    <div class="row">
                                        <div class="col-sm-12 modal-action-msg-wrap">
                                            <div class="modal-msg"></div>
                                            <input type="hidden" id="_delete_domain_id" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-modal-footer lp-modal-action-footer">
                                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                                <a id="_delete_domain_btn" class="btn lp-btn-add">Delete</a>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Model Boxes - Domain Delete - End -->

            </div>

        </div>
    @include('partials.watch_video_popup')
@endsection
