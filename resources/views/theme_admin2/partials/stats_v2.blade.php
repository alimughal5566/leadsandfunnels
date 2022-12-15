<!--************Stats POPUP STICKYBAR v2************-->
<div class="modal fade add_recipient  stickybar-stats sticky-stats__model " id="stats_v2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="lp-sticky-bar__title">
                <ul class="lp-stickybar__list">
                    <li class="lp-stickybar__item">
                        Sticky Bar Stats Report
                    </li>
                    <li class="lp-stickybar__item lp-stickybar_icon lp-stickybar_tooltip ">
                        <span class="lp-stickybar__link sticky-tooltip" data-toggle="tooltip"  data-html="true" data-placement="bottom" data-original-title="Watch How-to Video">
                            <i class="lp__sprite-icon lp__video-icon"></i>
                        </span>
                    </li>
                </ul>
                <ul class="nav nav-tabs stickybar-stats__tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#Overview">Overview</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#urlreport">URL Report</a>
                    </li>
                </ul>
            </div>

            <div class="modal-body">
                <div class="stats_model_notification_v2"></div>
                <div class="reportContent_v2">
                    <input type="hidden" name="startDatev2" id="startDatev2" value="12-12-12">
                    <input type="hidden" name="endDatev2" id="endDatev2" value="11-11-11">
                    <input type="hidden" name="clicked_by_sb" value="sticky-bar"  id="clicked_by_sb">
                    <div class="modal__header-bar">
                        <div class="modal__header-bar__options">
                            <label>
                                <span class="lp-icon-strip execl-icon"></span> export excel file
                            </label>
                            <label>
                                <span class="lp-icon-strip print-icon"></span> print
                            </label>
                        </div>
                        <div class="date-range-selector__wrapper">
                            <span class="date-range-label">Data Range</span>
                            <div class="dropdown date-range-selector" id="reportrange_v2" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="date-range-selector__title__wrapper">
                                        <span class="date-range-selector__title">
                                            <span>All Time</span>
                                        </span>
                                        <span class="caret"></span>
                                    </span>
                                <input type="hidden" name="qa-dropdown">
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="Overview" class="tab-pane fade in active">
                            <div class="lead-group-wrapper">
                                <div class="lead-wrapper stats_total">
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Sticky Bar<span class="nl">age</span></span>
                                            <span class="count">54</span>
                                            <span class="count-day">Days</span>
                                            <span class="status">(active)</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Days<span class="nl">Active</span></span>
                                            <span class="count">54</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Total<span class="nl">Views</span></span>
                                            <span class="count">758</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">CTA Button<span class="nl">Clicks</span></span>
                                            <span class="count">70</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">CTA Button<span class="nl">Click Rate</span></span>
                                            <span class="count">9.23%</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Lead<span class="nl">Conversions</span></span>
                                            <span class="count">21</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Lead Conversion<span class="nl">Rate</span></span>
                                            <span class="count conversion">30%</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Total<span class="nl">Click-to-Calls</span></span>
                                            <span class="count">17</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Click-to-Call<span class="nl">Rate</span></span>
                                            <span class="count">2.24%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="urlreport" class="tab-pane fade">
                            <div class="urlreport__wrapper">
                                URL Report
                            </div>
                            <div class="lead-group-wrapper">
                                <div class="slug_label">1. <span>www.leadpops.com/consult</span></div>
                                <div class="lead-wrapper stats_total">
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Total<span class="nl">Views</span></span>
                                            <span class="count">758</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">CTA Button<span class="nl">Clicks</span></span>
                                            <span class="count">70</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">CTA Button<span class="nl">Click Rate</span></span>
                                            <span class="count">9.23%</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Lead<span class="nl">Conversions</span></span>
                                            <span class="count">21</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Lead Conversion<span class="nl">Rate</span></span>
                                            <span class="count">30%</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Total<span class="nl">Click-to-Calls</span></span>
                                            <span class="count">17</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Click-to-Call<span class="nl">Rate</span></span>
                                            <span class="count">2.24%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lead-group-wrapper">
                                <div class="slug_label">2.<span>www.leadpops.com/reviews</span></div>
                                <div class="lead-wrapper stats_total stats_total--blue">
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title lead-title--blue ">Total<span class="nl">Views</span></span>
                                            <span class="count ">758</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title lead-title--blue ">CTA Button<span class="nl">Clicks</span></span>
                                            <span class="count">70</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title lead-title--blue ">CTA Button<span class="nl">Click Rate</span></span>
                                            <span class="count">9.23%</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title lead-title--blue ">Lead<span class="nl">Conversions</span></span>
                                            <span class="count">21</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title lead-title--blue ">Lead Conversion<span class="nl">Rate</span></span>
                                            <span class="count">30%</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title lead-title--blue ">Total<span class="nl">Click-to-Calls</span></span>
                                            <span class="count">17</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title lead-title--blue  ">Click-to-Call<span class="nl">Rate</span></span>
                                            <span class="count">2.24%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lead-group-wrapper">
                                <div class="slug_label">1.<span>www.leadpops.com/meet-the-team</span></div>
                                <div class="lead-wrapper stats_total">
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Total<span class="nl">Views</span></span>
                                            <span class="count">758</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">CTA Button<span class="nl">Clicks</span></span>
                                            <span class="count">70</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">CTA Button<span class="nl">Click Rate</span></span>
                                            <span class="count current_month_visitor">9.23%</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Lead<span class="nl">Conversions</span></span>
                                            <span class="count">21</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Lead Conversion<span class="nl">Rate</span></span>
                                            <span class="count">30%</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Total<span class="nl">Click-to-Calls</span></span>
                                            <span class="count">17</span>
                                        </div>
                                    </div>
                                    <div class="leadbox__wrapper">
                                        <div class="leadbox">
                                            <span class="lead-title">Click-to-Call<span class="nl">Rate</span></span>
                                            <span class="count">2.24%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal__footer clearfix">
                        <span href="#" data-dismiss="modal" class="btn__go-back">go back</span>
                        <span href="#" data-dismiss="modal" class="btn btn__close-modal btn__close-sb-modal">Close</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="startDatev2" id="startDatev2" value="12-12-12">
<input type="hidden" name="endDatev2" id="endDatev2" value="11-11-11">