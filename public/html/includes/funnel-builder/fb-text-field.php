<!--text field-->
<div class="funnel-content funnel-content_txtfield-overlay">
	<div class="panel-aside">
		<div class="panel-aside__head">
			<div class="col-left">
				<h4 class="panel-aside__title has-icon txtfield-icon">
                <span>
                    <i class="ico ico-select-text head-icon"></i>
                    Text Field
                </span>
				</h4>
			</div>
			<div class="col-right">
				<span class="ico-arrow-right back-ico"></span>
			</div>
		</div>
		<div class="panel-aside-wrap">
			<div class="panel-aside-holder">
				<div class="panel-aside__body m-0 p-0">
					<!-- Tabs -->

					<ul class="nav nav-tabs fb-tab" role="tablist">
						<li class="nav-item fb-tab__item">
							<a href="#short-text" data-toggle="tab" role="tab" aria-selected="true" class="fb-tab__link fb-tab__link_active">
								Short Text Input
							</a>
						</li>
						<li class="nav-item fb-tab__item">
							<a href="#long-text" data-toggle="tab" role="tab" aria-selected="false" class="fb-tab__link">
								Long Text Input
							</a>
						</li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" id="short-text" class="tab-pane fade show fb-tab__tab-pane active">
							<!--Add Question Detail-->
							<div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Question</div>
									<div class="fb-modal__control fb-modal__control_middle">
                            <span class="fb-tooltip fb-tooltip_pb2">
                                <span class="question-mark question-mark_mr10 question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
										<div class="fb-toggle">
											<input class="fb-field-label" name="sticky_bar_active"
											       type="checkbox"
											       id="toggle-status"
											       data-toggle="toggle"
											       data-on="off"
											       data-off="on"
											       data-onstyle="off"
											       data-offstyle="on" checked>
										</div>
									</div>
								</div>
								<div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block">
									<div class="fb-form">
										<div class="fb-froala classic-editor__wrapper">
											<div class="fb-froala__init"></div>
										</div>
									</div>
								</div>
							</div>
							<!-- Description -->
							<div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Description</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input class="fb-field-label" name="sticky_bar_active"
											       type="checkbox"
											       id="toggle-status"
											       data-toggle="toggle"
											       data-on="off"
											       data-off="on"
											       data-onstyle="off"
											       data-offstyle="on">
										</div>
									</div>
								</div>
								<div class="fb-modal__border-row fb-modal__border-row_menu">
									<div class="fb-form">
										<div class="fb-froala classic-editor__wrapper">
											<div class="fb-froala__init"></div>
										</div>
									</div>
								</div>
							</div>
							<!-- Field Label -->
							<div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Field label</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input class="fb-field-label" name="field_label"
											       type="checkbox"
											       id="toggle-status"
											       data-toggle="toggle"
											       data-on="off"
											       data-off="on"
											       data-onstyle="off"
											       data-offstyle="on">
										</div>
									</div>
								</div>
								<div class="fb-modal__border-row fb-modal__border-row_menu">
									<div class="fb-form">
										<div class="fb-form__caption">
											<span class="fb-form__middle">Blank Text Field Label</span>
											<span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
										</div>
										<div class="fb-form__group">
											<input type="text" class="form-control fb-form-control" value="Favorite Movie Name">
											<span class="tag-box">
                                    <i class="fa fa-tag"></i>
                                </span>
										</div>
									</div>
								</div>
							</div>
                            <!-- CTA Button -->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown open">
                                <div class="fb-modal__row">
                                    <div class="fb-modal__option">
                                        CTA Button
                                    </div>
                                    <div class="fb-modal__control">
                                        <div class="fb-modal__handler">
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block;">
                                    <div class="fb-form">
                                        <div class="fb-form__group">
                                            <input type="text" class="form-control fb-form-control" value="Continue">
                                            <span class="tag-box">
                                        <i class="fa fa-tag"></i>
                                    </span>
                                        </div>
                                        <div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_pb-15">
                                            <div class="fb-modal__row">
                                                <div class="fb-modal__option fb-modal__option_light">
                                                    <span class="fb-modal__middle">Font Size</span>
                                                </div>
                                                <div class="fb-modal__control">
                                                    <input id="textfield-buttonFontSizeSlider" class="form-control" type="text"/>
                                                    <input type="hidden" class="textfield-buttonFontSizeSlider" value="47">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fb-modal__border-box fb-modal__border-box_dropdown fb-modal__border-box_plr0 fb-modal__border-box_plr0-top">
                                            <div class="fb-modal__row">
                                                <div class="fb-modal__option fb-modal__option_light">
                                                    <span class="fb-modal__middle">Button Icon</span>
                                                </div>
                                                <div class="fb-modal__control">
                                                    <div class="fb-toggle">
                                                        <input class="fb-button-icon fb-field-label" name="fb-button-icon"
                                                               type="checkbox"
                                                               id="toggle-status"
                                                               data-toggle="toggle"
                                                               data-on="off"
                                                               data-off="on"
                                                               data-onstyle="off"
                                                               data-offstyle="on">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fb-modal__border-row fb-modal__border-row_menu pb-0">
                                                <div class="button-icon-slide">
                                                    <div class="fb-modal__row icon-select-row">
                                                        <div class="icon-select">
                                                            <a href="#select-icon-modal" data-toggle="modal" class="select-icon-opener icon-select__wrapper">
                                                        <span class="icon-wrap">
                                                            <i class="ico-start-rate"></i>
                                                        </span>
                                                                <span class="text-icon-wrap">
                                                            <span class="icon-title">Icon:</span>
                                                            <span class="text-icon">Star</span>
                                                        </span>
                                                            </a>
                                                        </div>
                                                        <div class="icon-color">
                                                            <div id="textfield-clr-icon" class="last-selected">
                                                                <div class="last-selected__box" style="background: #ffffff"></div>
                                                                <div class="last-selected__code">#ffffff</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fb-modal__row position-row">
                                                        <div class="fb-form__group">
                                                            <div class="textfield-input-icon-parent select2-parent icon-parent">
                                                                <select name="textfield-icon-type" id="textfield-icon-type"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fb-modal__row">
                                                        <div class="fb-modal__option fb-modal__option_light">
                                                            <span class="fb-modal__middle">Icon Size</span>
                                                        </div>
                                                        <div class="fb-modal__control">
                                                            <input id="textfield-icon-buttonFontSizeSlider" class="form-control" type="text"/>
                                                            <input type="hidden" class="textfield-icon-buttonFontSizeSlider" value="47">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fb-checkbox mt-3">
                                            <input class="fb-checkbox__input" type="checkbox" id="textfield-showonly-option">
                                            <label for="textfield-showonly-option" class="fb-checkbox__label">
                                                <div class="fb-checkbox__box">
                                                    <div class="fb-checkbox__inner-box"></div>
                                                </div>
                                                <div class="fb-checkbox__caption">
                                                    Hide CTA button until the question is&nbsp;answered
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- security message Content -->
                            <div class="form-group fb-modal__border-box_dropdown">
                                <div class="fb-modal__row">
                                    <div class="fb-modal__option">Security Message</div>
                                    <div class="fb-modal__control">
                                        <div class="fb-toggle">
                                    <span class="fb-tooltip fb-tooltip_pb2">
                                        <span class="question-mark question-mark_mr10 question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                    </span>
                                            <input class="fb-field-label" name="field_label"
                                                   type="checkbox"
                                                   id="toggle-status"
                                                   data-toggle="toggle"
                                                   data-on="off"
                                                   data-off="on"
                                                   data-onstyle="off"
                                                   data-offstyle="on" >
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-modal__border-row fb-modal__border-row_menu">
                                    <div class="fb-form__group-holder">
                                        <div class="textfield-input-message-parent select2-parent message-parent">
                                            <select name="icon-type" id="textfield-message-type"></select>
                                        </div>
                                        <a href="#" class="edit-btn el-tooltip" title="EDIT SECURITY MESSAGES"><i class="ico-edit"></i></a>
                                    </div>
                                </div>
                            </div>
							<!-- Additional Content -->
							<div class="form-group fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Additional Content</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input class="fb-field-label" name="field_label"
											       type="checkbox"
											       id="toggle-status"
											       data-toggle="toggle"
											       data-on="off"
											       data-off="on"
											       data-onstyle="off"
											       data-offstyle="on">
										</div>
									</div>
								</div>
								<div class="fb-modal__border-row fb-modal__border-row_menu">
									<div class="fb-form">
										<div class="fb-froala classic-editor__wrapper">
											<div class="fb-froala__init"></div>
										</div>
									</div>
								</div>
							</div>
                            <!-- Fields detail -->
                            <div class="form-group fb-modal__border-box_dropdown">
                                <div class="fb-modal__row">
                                    <div class="fb-modal__option">
                                        Field Details
                                    </div>
                                    <div class="fb-modal__control">
                                        <div class="fb-modal__handler">
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: none">
                                    <div class="fb-form">
                                        <div class="fb-form__caption">
                                            <span class="fb-form__middle">Unique Variable Name</span>
                                            <span class="fb-tooltip">
                                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                            </span>
                                        </div>
                                        <div class="fb-form__group-holder">
                                            <div class="fb-form__group">
                                                <input type="text" value="Text_field" class="form-control fb-form-control">
                                                <span class="tag-box">
                                                 <i class="ico-close-bracket"></i>
                                                </span>
                                            </div>
                                            <a href="#" class="undo-btn el-tooltip" title="RESET TO DEFAULT"><i class="ico-undo"></i></a>
                                        </div>
                                        <span class="zip-text">If you're not sure what you're doing, leave this as is!</span>
                                    </div>
                                </div>
                            </div>
							<!-- Settings -->
							<div class="form-group fb-modal__border-box fb-modal__border-box_bm_none">
								<div class="tag-row">
									<div class="tag-row__title">Settings</div>
								</div>
								<div class="fb-modal__row">
									<div class="fb-modal__option fb-modal__option_light">
										<span class="fb-modal__middle">Required</span>
										<span class="fb-tooltip">
                                            <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                        </span>
									</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input name="sticky_bar_active"
											       type="checkbox"
											       id="toggle-status"
											       data-toggle="toggle"
											       data-on="off"
											       data-off="on"
											       data-onstyle="off"
											       data-offstyle="on" checked>
										</div>
									</div>
								</div>
                                <div class="fb-modal__row fb-modal__row_tb">
                                    <div class="fb-modal__option fb-modal__option_light">
                                        <span class="fb-modal__middle">Automatic Progress</span>
                                        <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                                    </div>
                                    <div class="fb-modal__control">
                                        <div class="fb-toggle">
                                            <input name="sticky_bar_active"
                                                   type="checkbox"
                                                   id="toggle-status"
                                                   data-toggle="toggle"
                                                   data-on="off"
                                                   data-off="on"
                                                   data-onstyle="off"
                                                   data-offstyle="on">
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
						<div role="tabpanel" id="long-text" class="tab-pane fb-tab__tab-pane fade">
							<!--Add Question Detail-->
							<div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Question</div>
									<div class="fb-modal__control fb-modal__control_middle">
                            <span class="fb-tooltip fb-tooltip_pb2">
                                <span class="question-mark question-mark_mr10 question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
										<div class="fb-toggle">
											<input class="fb-field-label" name="sticky_bar_active"
											       type="checkbox"
											       id="toggle-status"
											       data-toggle="toggle"
											       data-on="off"
											       data-off="on"
											       data-onstyle="off"
											       data-offstyle="on" checked>
										</div>
									</div>
								</div>
								<div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block">
									<div class="fb-form">
										<div class="fb-froala classic-editor__wrapper">
											<div class="fb-froala__init"></div>
										</div>
									</div>
								</div>
							</div>
							<!-- Description -->
							<div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Description</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input class="fb-field-label" name="sticky_bar_active"
											       type="checkbox"
											       id="toggle-status"
											       data-toggle="toggle"
											       data-on="off"
											       data-off="on"
											       data-onstyle="off"
											       data-offstyle="on">
										</div>
									</div>
								</div>
								<div class="fb-modal__border-row fb-modal__border-row_menu">
									<div class="fb-form">
										<div class="fb-froala classic-editor__wrapper">
											<div class="fb-froala__init"></div>
										</div>
									</div>
								</div>
							</div>
							<!-- Field Label -->
							<div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Field label</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input class="fb-field-label" name="field_label"
											       type="checkbox"
											       id="toggle-status"
											       data-toggle="toggle"
											       data-on="off"
											       data-off="on"
											       data-onstyle="off"
											       data-offstyle="on">
										</div>
									</div>
								</div>
								<div class="fb-modal__border-row fb-modal__border-row_menu">
									<div class="fb-form">
										<div class="fb-form__caption">
											<span class="fb-form__middle">Blank Text Field Label</span>
											<span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
										</div>
										<div class="fb-form__group">
											<input type="text" class="form-control fb-form-control" value="Favorite Movie Name">
											<span class="tag-box">
                                    <i class="fa fa-tag"></i>
                                </span>
										</div>
									</div>
								</div>
							</div>
                            <!-- CTA Button -->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown open">
                                <div class="fb-modal__row">
                                    <div class="fb-modal__option">
                                        CTA Button
                                    </div>
                                    <div class="fb-modal__control">
                                        <div class="fb-modal__handler">
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block;">
                                    <div class="fb-form">
                                        <div class="fb-form__group">
                                            <input type="text" class="form-control fb-form-control" value="Continue">
                                            <span class="tag-box">
                                        <i class="fa fa-tag"></i>
                                    </span>
                                        </div>
                                        <div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_pb-15">
                                            <div class="fb-modal__row">
                                                <div class="fb-modal__option fb-modal__option_light">
                                                    <span class="fb-modal__middle">Font Size</span>
                                                </div>
                                                <div class="fb-modal__control">
                                                    <input id="textfield-large-buttonFontSizeSlider" class="form-control" type="text"/>
                                                    <input type="hidden" class="textfield-large-buttonFontSizeSlider" value="47">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fb-modal__border-box fb-modal__border-box_dropdown fb-modal__border-box_plr0 fb-modal__border-box_plr0-top">
                                            <div class="fb-modal__row">
                                                <div class="fb-modal__option fb-modal__option_light">
                                                    <span class="fb-modal__middle">Button Icon</span>
                                                </div>
                                                <div class="fb-modal__control">
                                                    <div class="fb-toggle">
                                                        <input class="fb-button-icon fb-field-label" name="fb-button-icon"
                                                               type="checkbox"
                                                               id="toggle-status"
                                                               data-toggle="toggle"
                                                               data-on="off"
                                                               data-off="on"
                                                               data-onstyle="off"
                                                               data-offstyle="on">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fb-modal__border-row fb-modal__border-row_menu pb-0">
                                                <div class="button-icon-slide">
                                                    <div class="fb-modal__row icon-select-row">
                                                        <div class="icon-select">
                                                            <a href="#select-icon-modal" data-toggle="modal" class="select-icon-opener icon-select__wrapper">
                                                        <span class="icon-wrap">
                                                            <i class="ico-start-rate"></i>
                                                        </span>
                                                                <span class="text-icon-wrap">
                                                            <span class="icon-title">Icon:</span>
                                                            <span class="text-icon">Star</span>
                                                        </span>
                                                            </a>
                                                        </div>
                                                        <div class="icon-color">
                                                            <div id="textfield-large-clr-icon" class="last-selected">
                                                                <div class="last-selected__box" style="background: #ffffff"></div>
                                                                <div class="last-selected__code">#ffffff</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fb-modal__row position-row">
                                                        <div class="fb-form__group">
                                                            <div class="textfield-large-input-icon-parent select2-parent icon-parent">
                                                                <select name="textfield-large-icon-type" id="textfield-large-icon-type"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fb-modal__row">
                                                        <div class="fb-modal__option fb-modal__option_light">
                                                            <span class="fb-modal__middle">Icon Size</span>
                                                        </div>
                                                        <div class="fb-modal__control">
                                                            <input id="textfield-large-icon-buttonFontSizeSlider" class="form-control" type="text"/>
                                                            <input type="hidden" class="textfield-large-icon-buttonFontSizeSlider" value="47">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fb-checkbox mt-3">
                                            <input class="fb-checkbox__input" type="checkbox" id="textfield-large-showonly-option">
                                            <label for="textfield-large-showonly-option" class="fb-checkbox__label">
                                                <div class="fb-checkbox__box">
                                                    <div class="fb-checkbox__inner-box"></div>
                                                </div>
                                                <div class="fb-checkbox__caption">
                                                    Hide CTA button until the question is&nbsp;answered
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- security message Content -->
                            <div class="form-group fb-modal__border-box_dropdown">
                                <div class="fb-modal__row">
                                    <div class="fb-modal__option">Security Message</div>
                                    <div class="fb-modal__control">
                                        <div class="fb-toggle">
                                    <span class="fb-tooltip fb-tooltip_pb2">
                                        <span class="question-mark question-mark_mr10 question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                    </span>
                                            <input class="fb-field-label" name="field_label"
                                                   type="checkbox"
                                                   id="toggle-status"
                                                   data-toggle="toggle"
                                                   data-on="off"
                                                   data-off="on"
                                                   data-onstyle="off"
                                                   data-offstyle="on" >
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-modal__border-row fb-modal__border-row_menu">
                                    <div class="fb-form__group-holder">
                                        <div class="textfield-large-input-message-parent select2-parent message-parent">
                                            <select name="icon-type" id="textfield-large-message-type"></select>
                                        </div>
                                        <a href="#" class="edit-btn el-tooltip" title="EDIT SECURITY MESSAGES"><i class="ico-edit"></i></a>
                                    </div>
                                </div>
                            </div>
							<!-- Additional Content -->
							<div class="form-group fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Additional Content</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input class="fb-field-label" name="field_label"
											       type="checkbox"
											       id="toggle-status"
											       data-toggle="toggle"
											       data-on="off"
											       data-off="on"
											       data-onstyle="off"
											       data-offstyle="on">
										</div>
									</div>
								</div>
								<div class="fb-modal__border-row fb-modal__border-row_menu">
									<div class="fb-form">
										<div class="fb-froala classic-editor__wrapper">
											<div class="fb-froala__init"></div>
										</div>
									</div>
								</div>
							</div>
							<!-- Settings -->
							<div class="form-group fb-modal__border-box fb-modal__border-box_bm_none">
								<div class="tag-row">
									<div class="tag-row__title">Settings</div>
								</div>
								<div class="fb-modal__row">
									<div class="fb-modal__option fb-modal__option_light">
										<span class="fb-modal__middle">Required</span>
										<span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
									</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input name="sticky_bar_active"
											       type="checkbox"
											       id="toggle-status"
											       data-toggle="toggle"
											       data-on="off"
											       data-off="on"
											       data-onstyle="off"
											       data-offstyle="on" checked>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-aside__footer">
			<div class="action">
				<ul class="action__list justify-content-end">
					<li class="action__item">
						<button class="button button-cancel">Close</button>
					</li>
					<li class="action__item">
						<button class="button button-secondary">Save</button>
					</li>
				</ul>
			</div>
		</div>
	</div>

    <div class="color-box__panel-wrapper textfield-icon-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="textfield-icon-clr">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="12"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="205"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="186"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#707d84" />
                <input type="hidden" id="textfield-icon-clr-trigger" value="1">
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>

    <div class="color-box__panel-wrapper textfield-large-icon-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="textfield-large-icon-clr">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="12"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="205"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="186"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#707d84" />
                <input type="hidden" id="textfield-large-icon-clr-trigger" value="1">
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>
	<!-- contain the main content of the page -->
	<div id="content">
		<!-- header of the page -->
		<?php
		include ("includes/funnel-header.php");
		?>
		<!-- contain main informative part of the site -->
		<!-- content of the page -->
		<main class="main">
			<section class="main-content">
				content of the page
				<!-- content of the page -->

				<!-- content of the page -->
			</section>
		</main>
	</div>
</div>
