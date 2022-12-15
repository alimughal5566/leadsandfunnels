<!-- slider page-->
<div class="funnel-content funnel-content_slider-overlay">
	<div class="panel-aside">
		<div class="panel-aside__head">
			<div class="col-left">
				<h4 class="panel-aside__title has-icon slider-icon">
                <span>
                    <i class="ico ico-expand head-icon"></i>
                    Slider
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
							<a href="#numeric" data-toggle="tab" role="tab" aria-controls="numeric" aria-selected="true" class="fb-tab__link fb-tab__link_active">
								numeric
							</a>
						</li>
						<li class="nav-item fb-tab__item">
							<a href="#non-numeric" data-toggle="tab" role="tab" aria-controls="non-numeric" aria-selected="false" class="fb-tab__link">
								non-numeric
							</a>
						</li>
					</ul>
					<div class="tab-content">

						<!-- Numeric tabs content-->

						<div id="numeric" role="tabpanel"  class="tab-pane fade show active">

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

							<!-- Slider Setup -->

							<div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">
										Slider Setup
									</div>
									<div class="fb-modal__control">
										<div class="fb-modal__handler">
											<!-- <i class="fbi fbi_arrow"></i>-->
											<i class="fa fa-chevron-down"></i>
										</div>
									</div>
								</div>
								<div class="fb-modal__border-row fb-modal__border-row_ptb0 fb-modal__border-row_menu">
									<ul class="nav nav-tabs fb-tab fb-tab_plr0" role="tablist">
										<li class="fb-tab__item">
											<a href="#puck1" data-toggle="tab" class="fb-tab__link fb-tab__link_inner fb-tab__link_active">
												1-Puck Slider
											</a>
										</li>
										<li class="fb-tab__item">
											<a href="#puck2" data-toggle="tab" class="fb-tab__link fb-tab__link_inner">
												2-Puck Slider
											</a>
										</li>
									</ul>
									<div class="tab-content">

										<!--Puck 1 Content-->

										<div role="tabpanel" id="puck1" class="tab-pane fb-tab__tab-pane active">
											<div class="fb-form" >
												<div class="slider-range-clone slider-range-clone_puck1">
													<div class="slider-range-clone__item">
                                                    <span class="slider-range-clone__del">
                                                        <i class="ico ico-cross"></i>
                                                    </span>
														<div class="fb-form__caption">
															<span class="fb-form__middle">Slider Range</span>
														</div>
														<div class="segment-grid">
															<div class="segment-grid__item segment-grid__item_17">
																<div class="fb-select-wrap fb-select_unit-wrap">
																	<select class="fb-select fb-select_unit fb-select_slider" name="state">
																		<option value="$">$</option>
																		<option value="%">%</option>
																		<option value="#">#</option>
																	</select>
																</div>
															</div>
															<div class="segment-grid__item segment-grid__item_41">
																<input type="text" class="form-control fb-form-control">
															</div>
															<div class="segment-grid__item segment-grid__item_41">
																<input type="text" class="form-control fb-form-control">
															</div>
														</div>
														<div class="segment-grid">
															<div class="segment-grid__item segment-grid__item_43">
																<div class="fb-select-wrap fb-select_by-wrap fb-select2-group">
																	<select class="fb-select fb-select_by fb-select_slider" name="state">
																		<option value="subranges">By: Subranges</option>
																		<option value="increment">By: Increment</option>
																	</select>
																</div>
															</div>
															<div class="segment-grid__item segment-grid__item_56">
																<input type="text" class="form-control fb-form-control">
															</div>
														</div>
														<div class="segment-grid">
															<div class="segment-grid__item segment-grid__item_94">
																<div class="fb-select-wrap fb-select_start-wrap fb-select2-group fb-select2-group_space">
																	<select class="fb-select fb-select_start fb-select_slider" name="state">
																		<option value="0">Starting Number Ends with: 0</option>
																		<option value="1">Starting Number Ends with: 1</option>
																	</select>
																</div>
															</div>
															<div class="segment-grid__item segment-grid__item_6">

                                                        <span class="fb-tooltip">
                                                            <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                        </span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="fb-options__add-more fb-options__add-more_h84">
												<a href="#" id="add-slider-range" class="lp-btn lp-btn_add-option add-slider-range button-primary border-0">
                                                <span class="lp-btn__icon">
                                                    <i class="ico ico-plus"></i>
                                                </span>
													Add New Segment
												</a>
											</div>

											<!-- Customize Slider Labels -->

											<div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
												<div class="fb-modal__row">
													<div class="fb-modal__option fb-modal__option_light">
														<span class="fb-modal__middle">Customize Slider Labels</span>
														<span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
													</div>
													<div class="fb-modal__control">
														<div class="fb-toggle">
															<input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
												<div class="fb-modal__border-row fb-modal__border-row_sub-menu">
													<div class="slider-label">
														<div class="slider-label__col-6">
															<input type="text" class="form-control fb-form-control" placeholder="Left Label">
														</div>
														<div class="slider-label__col-6">
															<input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
														</div>
													</div>
													<div class="slider-label">
														<div class="slider-label__col-6">
															<input type="text" class="form-control fb-form-control" placeholder="Right Label">
														</div>
														<div class="slider-label__col-6">
															<input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
														</div>
													</div>
												</div>
											</div>

											<!-- Slider Starting Point -->

											<div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
												<div class="fb-modal__row">
													<div class="fb-modal__option fb-modal__option_light">
														<span class="fb-modal__middle">Slider Starting Point</span>
														<span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
													</div>
													<div class="fb-modal__control">
														<div class="fb-toggle">
															<input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
												<div class="fb-modal__border-row fb-modal__border-row_sub-menu">
													<div class="bs-slider">
														<input type="text" class="fb-slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-tooltip="hide">
														<div class="bs-slider__label-wrapper">
															<span class="bs-slider__label">Left Label</span>
															<span class="bs-slider__label">$100000</span>
															<span class="bs-slider__label">Right Label</span>
														</div>
													</div>
												</div>
											</div>
										</div>

										<!--Puck 2 Content-->

										<div role="tabpanel" id="puck2" class="tab-pane fb-tab__tab-pane fade">
                                            <div class="fb-form" >
                                                <div class="slider-range-clone slider-range-clone_puck1">
                                                    <div class="slider-range-clone__item">
                                                    <span class="slider-range-clone__del">
                                                        <i class="ico ico-cross"></i>
                                                    </span>
                                                        <div class="fb-form__caption">
                                                            <span class="fb-form__middle">Slider Range</span>
                                                        </div>
                                                        <div class="segment-grid">
                                                            <div class="segment-grid__item segment-grid__item_17">
                                                                <div class="fb-select-wrap fb-select_unit-wrap-1">
                                                                    <select class="fb-select fb-select_unit-1 fb-select_slider" name="state">
                                                                        <option value="$">$</option>
                                                                        <option value="%">%</option>
                                                                        <option value="#">#</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="segment-grid__item segment-grid__item_41">
                                                                <input type="text" class="form-control fb-form-control">
                                                            </div>
                                                            <div class="segment-grid__item segment-grid__item_41">
                                                                <input type="text" class="form-control fb-form-control">
                                                            </div>
                                                        </div>
                                                        <div class="segment-grid">
                                                            <div class="segment-grid__item segment-grid__item_43">
                                                                <div class="fb-select-wrap fb-select_by-wrap-1 fb-select2-group">
                                                                    <select class="fb-select fb-select_by-1 fb-select_slider" name="state">
                                                                        <option value="subranges">By: Subranges</option>
                                                                        <option value="increment">By: Increment</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="segment-grid__item segment-grid__item_56">
                                                                <input type="text" class="form-control fb-form-control">
                                                            </div>
                                                        </div>
                                                        <div class="segment-grid">
                                                            <div class="segment-grid__item segment-grid__item_94">
                                                                <div class="fb-select-wrap fb-select_start-wrap-1 fb-select2-group fb-select2-group_space">
                                                                    <select class="fb-select fb-select_start-1 fb-select_slider" name="state">
                                                                        <option value="0">Starting Number Ends with: 0</option>
                                                                        <option value="1">Starting Number Ends with: 1</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="segment-grid__item segment-grid__item_6">

                                                        <span class="fb-tooltip">
                                                            <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                        </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fb-options__add-more fb-options__add-more_h84">
                                                <a href="#" id="add-slider-range" class="lp-btn lp-btn_add-option add-slider-range button-primary border-0">
                                                <span class="lp-btn__icon">
                                                    <i class="ico ico-plus"></i>
                                                </span>
                                                    Add New Segment
                                                </a>
                                            </div>
											<!-- Puck2 Customize Slider Labels -->

											<div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
												<div class="fb-modal__row">
													<div class="fb-modal__option fb-modal__option_light">
														<span class="fb-modal__middle">Customize Slider Labels</span>
														<span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
													</div>
													<div class="fb-modal__control">
														<div class="fb-toggle">
															<input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
												<div class="fb-modal__border-row fb-modal__border-row_sub-menu">
													<div class="slider-label">
														<div class="slider-label__col-6">
															<input type="text" class="form-control fb-form-control" placeholder="Left Label">
														</div>
														<div class="slider-label__col-6">
															<input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
														</div>
													</div>
													<div class="slider-label">
														<div class="slider-label__col-6">
															<input type="text" class="form-control fb-form-control" placeholder="Right Label">
														</div>
														<div class="slider-label__col-6">
															<input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
														</div>
													</div>
												</div>
											</div>

											<!-- Puck2 Slider Starting Point -->

											<div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
												<div class="fb-modal__row">
													<div class="fb-modal__option fb-modal__option_light">
														<span class="fb-modal__middle">Slider Starting Point</span>
														<span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
													</div>
													<div class="fb-modal__control">
														<div class="fb-toggle">
															<input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
												<div class="fb-modal__border-row fb-modal__border-row_sub-menu">
													<div class="bs-slider">
														<input type="text" class="fb-slider" data-slider-min="10" data-slider-max="200000" data-slider-step="1"  data-slider-value="[60000,150000]" data-slider-tooltip="hide">
														<div class="bs-slider__label-wrapper">
															<span class="bs-slider__label">Left Label</span>
															<span class="bs-slider__label">$100000 to $200000</span>
															<span class="bs-slider__label">Right Label</span>
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
                            <!-- CTA Button -->
                            <div class="form-group fb-modal__border-box_dropdown">
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
                                <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: none">
                                    <div class="fb-form">
                                        <div class="fb-form__caption">
                                            <span class="fb-form__middle">Button Text</span>
                                            <span class="fb-tooltip">
                                        <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                    </span>
                                        </div>
                                        <div class="fb-form__group">
                                            <input type="text" value="Go!" class="form-control fb-form-control">
                                            <span class="tag-box">
                                                <i class="fa fa-tag"></i>
                                            </span>
                                        </div>
                                        <div class="fb-modal__row range-slider-row">
                                            <div class="fb-modal__option fb-modal__option_light">
                                                <span class="fb-modal__middle">Font Size</span>
                                            </div>
                                            <div class="fb-modal__control">
                                                <input id="font-buttonFontSizeSlider02" class="form-control" type="text"/>
                                                <input type="hidden" class="font-buttonFontSizeSlider02" value="47">
                                            </div>
                                        </div>
                                        <!-- button icon slide -->
                                        <div class="fb-modal__border-box fb-modal__border-box_dropdown fb-modal__border-box_plr0 fb-modal__border-box_plr0-top">
                                            <div class="fb-modal__row">
                                                <div class="fb-modal__option fb-modal__option_light">
                                                    <span class="fb-modal__middle">Button Icon</span>
                                                </div>
                                                <div class="fb-modal__control">
                                                    <div class="fb-toggle">
                                                        <input class="fb-button-icon fb-field-label-inner" name="fb-button-icon"
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
                                            <div class="fb-modal__border-row fb-modal__border-row_menu-inner pb-0" style="display: none">
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
                                                            <div id="num-clr-icon" class="last-selected">
                                                                <div class="last-selected__box" style="background: #ffffff"></div>
                                                                <div class="last-selected__code">#ffffff</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fb-modal__row position-row">
                                                        <div class="fb-form__group">
                                                            <div class="num-input-icon-parent select2-parent icon-parent">
                                                                <select name="icon-type" id="num-icon-type"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fb-modal__row">
                                                        <div class="fb-modal__option fb-modal__option_light">
                                                            <span class="fb-modal__middle">Icon Size</span>
                                                        </div>
                                                        <div class="fb-modal__control">
                                                            <input id="icon-buttonFontSizeSlider02" class="form-control" type="text"/>
                                                            <input type="hidden" class="icon-buttonFontSizeSlider02" value="47">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fb-checkbox mt-3">
                                            <input class="fb-checkbox__input" type="checkbox" id="showonly-option09">
                                            <label for="showonly-option09" class="fb-checkbox__label">
                                                <div class="fb-checkbox__box">
                                                    <div class="fb-checkbox__inner-box"></div>
                                                </div>
                                                <div class="fb-checkbox__caption">
                                                    Hide CTA button until the question is&nbsp;answered
                                                    <!--Only show CTA button when question is answered-->
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
                                        <div class="slider-parent-menu select2-parent message-parent">
                                            <select name="icon-type" id="slider-type-menu"></select>
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
											       data-offstyle="on" >
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
                                                <input type="text" value="Zip_code" class="form-control fb-form-control">
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
							</div>

							<!-- slider range shorts -->

							<div class="form-group fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Show Thousands as K</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input class="fb-field-label" name="field_label"
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
							<div class="form-group fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Show Millions as M</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input class="fb-field-label" name="field_label"
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
							<div class="form-group fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">Show Billions as B</div>
									<div class="fb-modal__control">
										<div class="fb-toggle">
											<input class="fb-field-label" name="field_label"
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

						<!-- Non-Numeric tabs content-->

						<div id="non-numeric" role="tabpanel" class="tab-pane fade">

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
											       data-offstyle="on" >
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

							<!-- Slider Setup -->

							<div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
								<div class="fb-modal__row">
									<div class="fb-modal__option">
										Slider Setup
									</div>
									<div class="fb-modal__control">
										<div class="fb-modal__handler">
											<!-- <i class="fbi fbi_arrow"></i>-->
											<i class="fa fa-chevron-down"></i>
										</div>
									</div>
								</div>
								<div class="fb-modal__border-row fb-modal__border-row_pb0 fb-modal__border-row_menu">
									<div class="tab-content">
										<div class="fb-form">
											<div class="fb-form__caption">
												<span class="fb-form__middle">Custom Values</span>
											</div>
										</div>
										<div class="fb-options">
											<div class="fb-options__clone">
												<div class="fb-options__list">
													<div class="fb-options__col fb-options__col_field">
														<input type="text" class="form-control fb-form-control">
													</div>
													<div class="fb-options__col fb-options__col_handler">
                                                    <span class="tag-box tag-box_move tag-box_lg">
<!--                                                        <i class="fbi fbi_drag-dark"></i>-->
                                                        <i class="ico ico-dragging"></i>
                                                    </span>
													</div>
													<div class="fb-options__col">
														<a href="#" class="fb-options__delete">
                                                        <span class="tag-box tag-box_lg">
<!--                                                            <i class="fbi fbi_cross-dark"></i>-->
                                                            <i class="ico ico-cross"></i>
                                                        </span>
														</a>
													</div>
												</div>
											</div>
											<div class="fb-options__add-more">
												<a href="#" class="lp-btn lp-btn_add-option">
                                                <span class="lp-btn__icon">
<!--                                                    <i class="fbi fbi_plus-sm"></i>-->
                                                    <i class="ico ico-plus"></i>
                                                </span>
													Add New Value
												</a>
											</div>
										</div>

										<!-- Customize Slider Labels -->

										<div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
											<div class="fb-modal__row">
												<div class="fb-modal__option fb-modal__option_light">
													<span class="fb-modal__middle">Customize Slider Labels</span>
													<span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
												</div>
												<div class="fb-modal__control">
													<div class="fb-toggle">
														<input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
											<div class="fb-modal__border-row fb-modal__border-row_sub-menu">
												<div class="slider-label">
													<div class="slider-label__col-6">
														<input type="text" class="form-control fb-form-control" placeholder="Left Label">
													</div>
													<div class="slider-label__col-6">
														<input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
													</div>
												</div>
												<div class="slider-label">
													<div class="slider-label__col-6">
														<input type="text" class="form-control fb-form-control" placeholder="Right Label">
													</div>
													<div class="slider-label__col-6">
														<input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
													</div>
												</div>
											</div>
										</div>

										<!-- Slider Starting Point -->

										<div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
											<div class="fb-modal__row">
												<div class="fb-modal__option fb-modal__option_light">
													<span class="fb-modal__middle">Slider Starting Point</span>
													<span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
												</div>
												<div class="fb-modal__control">
													<div class="fb-toggle">
														<input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
											<div class="fb-modal__border-row fb-modal__border-row_sub-menu">
												<div class="bs-slider">
													<input type="text" class="fb-slider" data-slider-min="10" data-slider-max="200000" data-slider-step="1"  data-slider-value="[60000,150000]" data-slider-tooltip="hide">
													<div class="bs-slider__label-wrapper">
														<span class="bs-slider__label">Left Label</span>
														<span class="bs-slider__label">$100000 to $200000</span>
														<span class="bs-slider__label">Right Label</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

                            <!-- CTA Button -->
                            <div class="form-group fb-modal__border-box_dropdown">
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
                                <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: none">
                                    <div class="fb-form">
                                        <div class="fb-form__caption">
                                            <span class="fb-form__middle">Button Text</span>
                                            <span class="fb-tooltip">
                                        <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                    </span>
                                        </div>
                                        <div class="fb-form__group">
                                            <input type="text" value="Go!" class="form-control fb-form-control">
                                            <span class="tag-box">
                                                <i class="fa fa-tag"></i>
                                            </span>
                                        </div>
                                        <div class="fb-modal__row range-slider-row">
                                            <div class="fb-modal__option fb-modal__option_light">
                                                <span class="fb-modal__middle">Font Size</span>
                                            </div>
                                            <div class="fb-modal__control">
                                                <input id="font-buttonFontSizeSlider03" class="form-control" type="text"/>
                                                <input type="hidden" class="font-buttonFontSizeSlider03" value="47">
                                            </div>
                                        </div>
                                        <!-- button icon slide -->
                                        <div class="fb-modal__border-box fb-modal__border-box_dropdown fb-modal__border-box_plr0 fb-modal__border-box_plr0-top">
                                            <div class="fb-modal__row">
                                                <div class="fb-modal__option fb-modal__option_light">
                                                    <span class="fb-modal__middle">Button Icon</span>
                                                </div>
                                                <div class="fb-modal__control">
                                                    <div class="fb-toggle">
                                                        <input class="fb-button-icon fb-field-label-inner" name="fb-button-icon"
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
                                            <div class="fb-modal__border-row fb-modal__border-row_menu-inner pb-0" style="display: none">
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
                                                            <div id="non-num-clr-icon" class="last-selected">
                                                                <div class="last-selected__box" style="background: #ffffff"></div>
                                                                <div class="last-selected__code">#ffffff</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fb-modal__row position-row">
                                                        <div class="fb-form__group">
                                                            <div class="non-num-input-icon-parent select2-parent icon-parent">
                                                                <select name="icon-type" id="non-num-icon-type"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fb-modal__row">
                                                        <div class="fb-modal__option fb-modal__option_light">
                                                            <span class="fb-modal__middle">Icon Size</span>
                                                        </div>
                                                        <div class="fb-modal__control">
                                                            <input id="icon-buttonFontSizeSlider03" class="form-control" type="text"/>
                                                            <input type="hidden" class="icon-buttonFontSizeSlider03" value="47">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fb-checkbox mt-3">
                                            <input class="fb-checkbox__input" type="checkbox" id="showonly-option10">
                                            <label for="showonly-option10" class="fb-checkbox__label">
                                                <div class="fb-checkbox__box">
                                                    <div class="fb-checkbox__inner-box"></div>
                                                </div>
                                                <div class="fb-checkbox__caption">
                                                    Hide CTA button until the question is&nbsp;answered
                                                    <!--Only show CTA button when question is answered-->
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
                                        <div class="non-slider-parent-menu select2-parent message-parent">
                                            <select name="icon-type" id="non-slider-type-menu"></select>
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
                                                   data-offstyle="on" >
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
                                                <input type="text" value="Zip_code" class="form-control fb-form-control">
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
    <!-- Icon color picker -->
    <div class="color-box__panel-wrapper num-icon-clr">

        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="num-icon-clr">
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
                <input type="hidden" id="num-icon-clr-trigger" value="1">
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
    <!-- Icon color picker -->
    <div class="color-box__panel-wrapper non-num-icon-clr">

        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="non-num-icon-clr">
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
                <input type="hidden" id="non-num-icon-clr-trigger" value="1">
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