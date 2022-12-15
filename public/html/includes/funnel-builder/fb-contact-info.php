<!-- contact info page -->
<div class="funnel-content funnel-content_contact-overlay">
	<div class="panel-aside">
		<div class="panel-aside__head">
			<div class="col-left">
				<h4 class="panel-aside__title has-icon slider-icon">
                <span>
                    <i class="ico ico-mail head-icon"></i>
                    Contact Info
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
							<a href="#step1" data-toggle="tab" role="tab" aria-controls="numeric" aria-selected="true" class="fb-tab__link fb-tab__link_active">
								1 step
							</a>
						</li>
						<li class="nav-item fb-tab__item">
							<a href="#step2" data-toggle="tab" role="tab" aria-controls="non-numeric" aria-selected="false" class="fb-tab__link">
								2 steps
							</a>
						</li>
						<li class="nav-item fb-tab__item">
							<a href="#step3" data-toggle="tab" role="tab" aria-controls="non-numeric" aria-selected="false" class="fb-tab__link">
								3 steps
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<!-- Step 1 tabs content-->
						<div id="step1" role="tabpanel"  class="tab-pane fade show active">

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
                            <!-- Options -->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown fb-modal_form-setup open">
                                <div class="fb-modal__row">
                                    <div class="fb-modal__option">
                                        Contact Form Setup
                                    </div>
                                    <div class="fb-modal__control">
                                        <div class="fb-modal__handler">
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-options fb-options_drop-down fb-modal__border-row_menu" style="display: block">
                                    <div class="fb-options__group-clone" style="display: block">
                                        <div class="grouping-label">input 1</div>
                                        <div class="fb-form__group">
                                            <div class="input-type-parent select2-parent">
                                                <select name="input-type" id="input-type"></select>
                                            </div>
                                        </div>
                                        <div class="fb-form__group">
                                            <div class="contact-variation-parent select2-parent">
                                                <select name="contact-variation" id="contact-variation"></select>
                                            </div>
                                        </div>
                                        <div id="first-name" class="fb-form__group">
                                            <input type="text" class="form-control" placeholder="First Name">
                                        </div>
                                        <div id="last-name" class="fb-form__group">
                                            <input type="text" class="form-control" placeholder="Last Name">
                                        </div>
                                        <div id="full-name" class="fb-form__group" >
                                            <input type="text" class="form-control" placeholder="Full Name">
                                        </div>
                                    </div>
                                    <div class="fb-options__group-clone" id="input2"  style="display: none">
                                        <div id="inputlabel2" class="grouping-label">input 2</div>
                                        <ul class="fb-form__list">
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <div class="input-type1-parent select2-parent">
                                                        <select name="input-type" id="input-type1"></select>
                                                    </div>
                                                </div>
                                                <div id="hideinputbutton2" class="fb-form__control">
                                                <span class="tag-box tag-box_lg">
                                                    <i class="ico ico-cross"></i>
                                                </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item">
                                                <input type="text" class="form-control" placeholder="Email Address">
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fb-options__group-clone" id="input3" style="display: none">
                                        <div id="inputlabel3" class="grouping-label">input 3</div>
                                        <ul class="fb-form__list">
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <div class="input-type2-parent select2-parent">
                                                        <select name="input-type" id="input-type2"></select>
                                                    </div>
                                                </div>
                                                <div id="hideinputbutton3" class="fb-form__control">
                                                <span class="tag-box tag-box_lg">
                                                    <i class="ico ico-cross"></i>
                                                </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item setting-wrap">
                                                <input type="text" class="form-control" placeholder="Phone Number">
                                                <div class="fb-form__control">
                                                <a href="#advance-setting" data-toggle="modal" class="tag-box tag-box_lg el-tooltip" title="ADVANCE SETTINGS">
                                                    <i class="ico ico-settings"></i>
                                                </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fb-modal__row_creat-group">
                                        <div class="fb-modal__row">
                                            <a id="addinputbutton" href="javascript:void();" class="lp-btn lp-btn_new-input button-primary">
                                                <span class="lp-btn__icon">
                                                    <i class="ico ico-plus"></i>
                                                </span>
                                                    Add New Input
                                            </a>
                                            <a id="organizebutton" data-toggle="modal" href="#group-organize-pop" class="lp-btn lp-btn_new-input lp-btn_organize button-primary" style="display: none">
                                                <span class="lp-btn__icon">
                                                    <i class="ico ico-dragging"></i>
                                                </span>
                                                Organize
                                            </a>
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
                                            <input type="text" class="form-control fb-form-control" value="NEXT STEP">
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
                                                    <input id="contact-buttonFontSizeSlider" class="form-control" type="text"/>
                                                    <input type="hidden" class="contact-buttonFontSizeSlider" value="47">
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
                                                            <div id="contact-clr-icon" class="last-selected">
                                                                <div class="last-selected__box" style="background: #ffffff"></div>
                                                                <div class="last-selected__code">#ffffff</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fb-modal__row position-row">
                                                        <div class="fb-form__group">
                                                            <div class="contact-input-icon-parent select2-parent icon-parent">
                                                                <select name="contact-icon-type" id="contact-icon-type"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fb-modal__row">
                                                        <div class="fb-modal__option fb-modal__option_light">
                                                            <span class="fb-modal__middle">Icon Size</span>
                                                        </div>
                                                        <div class="fb-modal__control">
                                                            <input id="contact-icon-buttonFontSizeSlider" class="form-control" type="text"/>
                                                            <input type="hidden" class="contact-icon-buttonFontSizeSlider" value="47">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fb-checkbox mt-3">
                                            <input class="fb-checkbox__input" type="checkbox" id="contact-showonly-option">
                                            <label for="contact-showonly-option" class="fb-checkbox__label">
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
                                        <div class="contact-input-message-parent select2-parent message-parent">
                                            <select name="contact-icon-type" id="contact-message-type"></select>
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
							<!-- Field Details -->
							<div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
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
								<div class="fb-modal__border-row fb-modal__border-row_menu">
									<div class="fb-form">
										<div class="fb-form__caption">
											<span class="fb-form__middle">Unique Variable Name</span>
											<span class="fb-tooltip">
			                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
			                                </span>
										</div>
										<ul class="fb-form__list">
											<li class="fb-form__item">
												<div class="fb-form__input">
													<input type="text" value="First_name" class="form-control fb-form-control">
													<span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
												</div>
												<div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
												</div>
											</li>
											<li class="fb-form__item">
												<div class="fb-form__input">
													<input type="text" value="Last_name" class="form-control fb-form-control">
													<span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
												</div>
												<div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
												</div>
											</li>
											<li class="fb-form__item">
												<div class="fb-form__input">
													<input type="text" value="Email_address" class="form-control fb-form-control">
													<span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
												</div>
												<div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
												</div>
											</li>
											<li class="fb-form__item">
												<div class="fb-form__input">
													<input type="text" value="Phone_number" class="form-control fb-form-control">
													<span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
												</div>
												<div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
												</div>
											</li>
										</ul>
										<p class="fb-form__dsc">
											if you're not sure what you're doing, leave this is!
										</p>
									</div>
								</div>
							</div>
							<!-- Settings -->
							<div class="form-group fb-modal__border-box_dropdown">
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
                                <div class="fb-modal__border-row fb-modal__border-row_ptb0 fb-modal__border-row_menu">
                                    <div class="field">
                                        <ul class="field__list">
                                            <li class="field__item">
                                                <div class="fb-checkbox">
                                                    <input class="fb-checkbox__input" type="checkbox" id="first_name">
                                                    <label for="first_name" class="fb-checkbox__label">
                                                        <div class="fb-checkbox__box">
                                                            <div class="fb-checkbox__inner-box"></div>
                                                        </div>
                                                        <div class="fb-checkbox__caption">
                                                            First Name
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="field__item">
                                                <div class="fb-checkbox">
                                                    <input class="fb-checkbox__input" type="checkbox" id="last_name">
                                                    <label for="last_name" class="fb-checkbox__label">
                                                        <div class="fb-checkbox__box">
                                                            <div class="fb-checkbox__inner-box"></div>
                                                        </div>
                                                        <div class="fb-checkbox__caption">
                                                            Last Name
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="field__item">
                                                <div class="fb-checkbox">
                                                    <input class="fb-checkbox__input" type="checkbox" id="email_name">
                                                    <label for="email_name" class="fb-checkbox__label">
                                                        <div class="fb-checkbox__box">
                                                            <div class="fb-checkbox__inner-box"></div>
                                                        </div>
                                                        <div class="fb-checkbox__caption">
                                                            Email Name
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="field__item">
                                                <div class="fb-checkbox">
                                                    <input class="fb-checkbox__input" type="checkbox" id="phone_name">
                                                    <label for="phone_name" class="fb-checkbox__label">
                                                        <div class="fb-checkbox__box">
                                                            <div class="fb-checkbox__inner-box"></div>
                                                        </div>
                                                        <div class="fb-checkbox__caption">
                                                            Phone Name
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
								<div class="fb-modal__row fb-modal__row_tb">
									<div class="fb-modal__option fb-modal__option_light">
										<span class="fb-modal__middle">Auto-Cursor Focus</span>
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
                        <!-- Step 2 tabs content-->
                        <div id="step2" role="tabpanel"  class="tab-pane fade">
                            <!--top dropdown step 2-->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
                                <div class="fb-modal__row fb-modal__row_top-dropdown">
                                    <div class="edit-content-step2-parent select2-parent">
                                        <select name="edit-content-step2" id="edit-content-step2"></select>
                                    </div>
                                </div>
                            </div>
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
                            <!-- Options -->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown fb-modal_form-setup open">
                                <div class="fb-modal__row">
                                    <div class="fb-modal__option">
                                        Contact Form Setup
                                    </div>
                                    <div class="fb-modal__control">
                                        <div class="fb-modal__handler">
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-options fb-options_drop-down fb-modal__border-row_menu" style="display: block">
                                    <div class="fb-options__group-clone">
                                        <div class="grouping-label">input 1</div>
                                        <div class="fb-form__group">
                                            <div class="input-type-step2-parent select2-parent">
                                                <select name="input-type-step2" id="input-type-step2"></select>
                                            </div>
                                        </div>
                                        <div class="fb-form__group">
                                            <div class="contact-variation-step2-parent select2-parent">
                                                <select name="contact-variation-step2" id="contact-variation-step2"></select>
                                            </div>
                                        </div>
                                        <div class="fb-form__group">
                                            <input type="text" class="form-control" placeholder="First Name">
                                        </div>
                                        <div class="fb-form__group">
                                            <input type="text" class="form-control" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="fb-options__group-clone">
                                        <div class="grouping-label">input 2</div>
                                        <ul class="fb-form__list">
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <div class="input-type1-step2-parent select2-parent">
                                                        <select name="input-type-step2" id="input-type1-step2"></select>
                                                    </div>
                                                </div>
                                                <div class="fb-form__control">
                                                <span class="tag-box tag-box_lg">
                                                    <i class="ico ico-cross"></i>
                                                </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item">
                                                <input type="text" class="form-control" placeholder="Email Address">
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fb-options__group-clone">
                                        <div class="grouping-label">input 3</div>
                                        <ul class="fb-form__list">
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <div class="input-type2-step2-parent select2-parent">
                                                        <select name="input-type2-step2" id="input-type2-step2"></select>
                                                    </div>
                                                </div>
                                                <div class="fb-form__control">
                                                <span class="tag-box tag-box_lg">
                                                    <i class="ico ico-cross"></i>
                                                </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item setting-wrap">
                                                <input type="text" class="form-control" placeholder="Phone Number">
                                                <div class="fb-form__control">
                                                    <a href="#advance-setting" data-toggle="modal" class="tag-box tag-box_lg el-tooltip" title="ADVANCE SETTINGS">
                                                        <i class="ico ico-settings"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fb-modal__row_creat-group">
                                        <div class="fb-modal__row">
                                            <a href="javascript:void();" class="lp-btn lp-btn_new-input button-primary">
                                                <span class="lp-btn__icon">
                                                    <i class="ico ico-plus"></i>
                                                </span>
                                                Add New Input
                                            </a>
                                            <a data-toggle="modal" href="#group-organize-pop" class="lp-btn lp-btn_new-input lp-btn_organize button-primary">
                                                <span class="lp-btn__icon">
                                                    <i class="ico ico-dragging"></i>
                                                </span>
                                                Organize
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CTA Button -->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
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
                                <div class="fb-modal__border-row fb-modal__border-row_menu">
                                    <div class="fb-form">
                                        <div class="fb-form__caption">
                                            <span class="fb-form__middle">Button Text</span>
                                            <span class="fb-tooltip">
			                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
			                                </span>
                                        </div>
                                        <div class="fb-form__group">
                                            <input type="text" class="form-control fb-form-control">
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
                                                    <input id="buttonFontSizeSlider2" class="form-control" type="text"/>
                                                    <input type="hidden" class="defaultfontsize2" value="47">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fb-modal__border-box fb-modal__border-box_plr0">
                                            <div class="fb-modal__row">
                                                <div class="fb-modal__option fb-modal__option_light">
                                                    <span class="fb-modal__middle">Button Icon</span>
                                                    <span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip tooltipstered">?</span>
                                                </span>
                                                </div>
                                                <div class="fb-modal__control">
                                                    <div class="fb-toggle">
                                                        <input class="fb-button-icon" name="fb-button-icon"
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
                                        <div class="fb-checkbox mt-3">
                                            <input class="fb-checkbox__input" type="checkbox" id="fb-contactinfo-showonly-option">
                                            <label for="fb-contactinfo-showonly-option" class="fb-checkbox__label">
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
                                    <div class="fb-form">
                                        <div class="fb-froala classic-editor__wrapper">
                                            <div class="fb-froala__init"></div>
                                        </div>
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
                            <!-- Field Details -->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
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
                                <div class="fb-modal__border-row fb-modal__border-row_menu">
                                    <div class="fb-form">
                                        <div class="fb-form__caption">
                                            <span class="fb-form__middle">Unique Variable Name</span>
                                            <span class="fb-tooltip">
			                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
			                                </span>
                                        </div>
                                        <ul class="fb-form__list">
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <input type="text" value="First_name" class="form-control fb-form-control">
                                                    <span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
                                                </div>
                                                <div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <input type="text" value="Last_name" class="form-control fb-form-control">
                                                    <span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
                                                </div>
                                                <div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <input type="text" value="Email_address" class="form-control fb-form-control">
                                                    <span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
                                                </div>
                                                <div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <input type="text" value="Phone_number" class="form-control fb-form-control">
                                                    <span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
                                                </div>
                                                <div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
                                                </div>
                                            </li>
                                        </ul>
                                        <p class="fb-form__dsc">
                                            if you're not sure what you're doing, leave this is!
                                        </p>
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
                                                   data-offstyle="on">
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-modal__row fb-modal__row_tb">
                                    <div class="fb-modal__option fb-modal__option_light">
                                        <span class="fb-modal__middle">Auto-Cursor Focus</span>
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
                        <!-- Step 3 tabs content-->
                        <div id="step3" role="tabpanel"  class="tab-pane fade">
                            <!--top dropdown step 3-->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
                                <div class="fb-modal__row fb-modal__row_top-dropdown">
                                    <div class="edit-content-step3-parent select2-parent">
                                        <select name="edit-content-step3" id="edit-content-step3"></select>
                                    </div>
                                </div>
                            </div>
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
                            <!-- Options -->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown fb-modal_form-setup open">
                                <div class="fb-modal__row">
                                    <div class="fb-modal__option">
                                        Contact Form Setup
                                    </div>
                                    <div class="fb-modal__control">
                                        <div class="fb-modal__handler">
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-options fb-options_drop-down fb-modal__border-row_menu" style="display: block">
                                    <div class="fb-options__group-clone">
                                        <div class="grouping-label">input 1</div>
                                        <div class="fb-form__group">
                                            <div class="input-type-step3-parent select2-parent">
                                                <select name="input-type-step3" id="input-type-step3"></select>
                                            </div>
                                        </div>
                                        <div class="fb-form__group">
                                            <div class="contact-variation-step3-parent select2-parent">
                                                <select name="contact-variation-step3" id="contact-variation-step3"></select>
                                            </div>
                                        </div>
                                        <div class="fb-form__group">
                                            <input type="text" class="form-control" placeholder="First Name">
                                        </div>
                                        <div class="fb-form__group">
                                            <input type="text" class="form-control" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="fb-options__group-clone">
                                        <div class="grouping-label">input 2</div>
                                        <ul class="fb-form__list">
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <div class="input-type1-step3-parent select2-parent">
                                                        <select name="input-type-step3" id="input-type1-step3"></select>
                                                    </div>
                                                </div>
                                                <div class="fb-form__control">
                                                <span class="tag-box tag-box_lg">
                                                    <i class="ico ico-cross"></i>
                                                </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item">
                                                <input type="text" class="form-control" placeholder="Email Address">
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fb-options__group-clone">
                                        <div class="grouping-label">input 3</div>
                                        <ul class="fb-form__list">
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <div class="input-type2-step3-parent select2-parent">
                                                        <select name="input-type-step3" id="input-type2-step3"></select>
                                                    </div>
                                                </div>
                                                <div class="fb-form__control">
                                                <span class="tag-box tag-box_lg">
                                                    <i class="ico ico-cross"></i>
                                                </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item setting-wrap">
                                                <input type="text" class="form-control" placeholder="Phone Number">
                                                <div class="fb-form__control">
                                                    <a href="#advance-setting" data-toggle="modal" class="tag-box tag-box_lg el-tooltip" title="ADVANCE SETTINGS">
                                                        <i class="ico ico-settings"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fb-modal__row_creat-group">
                                        <div class="fb-modal__row">
                                            <a href="javascript:void();" class="lp-btn lp-btn_new-input button-primary">
                                                <span class="lp-btn__icon">
                                                    <i class="ico ico-plus"></i>
                                                </span>
                                                Add New Input
                                            </a>
                                            <a data-toggle="modal" href="#group-organize-pop" class="lp-btn lp-btn_new-input lp-btn_organize button-primary">
                                                <span class="lp-btn__icon">
                                                    <i class="ico ico-dragging"></i>
                                                </span>
                                                Organize
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CTA Button -->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
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
                                <div class="fb-modal__border-row fb-modal__border-row_menu">
                                    <div class="fb-form">
                                        <div class="fb-form__caption">
                                            <span class="fb-form__middle">Button Text</span>
                                            <span class="fb-tooltip">
			                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
			                                </span>
                                        </div>
                                        <div class="fb-form__group">
                                            <input type="text" class="form-control fb-form-control">
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
                                                    <input id="buttonFontSizeSlider3" class="form-control" type="text"/>
                                                    <input type="hidden" class="defaultfontsize3" value="47">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fb-modal__border-box fb-modal__border-box_plr0">
                                            <div class="fb-modal__row">
                                                <div class="fb-modal__option fb-modal__option_light">
                                                    <span class="fb-modal__middle">Button Icon</span>
                                                    <span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip tooltipstered">?</span>
                                                </span>
                                                </div>
                                                <div class="fb-modal__control">
                                                    <div class="fb-toggle">
                                                        <input class="fb-button-icon" name="fb-button-icon"
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
                                        <div class="fb-checkbox mt-3">
                                            <input class="fb-checkbox__input" type="checkbox" id="fb-contactinfo-showonly-option">
                                            <label for="fb-contactinfo-showonly-option" class="fb-checkbox__label">
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
                                    <div class="fb-form">
                                        <div class="fb-froala classic-editor__wrapper">
                                            <div class="fb-froala__init"></div>
                                        </div>
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
                            <!-- Field Details -->
                            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
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
                                <div class="fb-modal__border-row fb-modal__border-row_menu">
                                    <div class="fb-form">
                                        <div class="fb-form__caption">
                                            <span class="fb-form__middle">Unique Variable Name</span>
                                            <span class="fb-tooltip">
			                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
			                                </span>
                                        </div>
                                        <ul class="fb-form__list">
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <input type="text" value="First_name" class="form-control fb-form-control">
                                                    <span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
                                                </div>
                                                <div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <input type="text" value="Last_name" class="form-control fb-form-control">
                                                    <span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
                                                </div>
                                                <div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <input type="text" value="Email_address" class="form-control fb-form-control">
                                                    <span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
                                                </div>
                                                <div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
                                                </div>
                                            </li>
                                            <li class="fb-form__item">
                                                <div class="fb-form__input">
                                                    <input type="text" value="Phone_number" class="form-control fb-form-control">
                                                    <span class="tag-box">
					                                    <i class="ico-close-bracket"></i>
					                                </span>
                                                </div>
                                                <div class="fb-form__control">
													<span class="tag-box tag-box_lg">
		                                                <i class="ico ico-undo"></i>
		                                            </span>
                                                </div>
                                            </li>
                                        </ul>
                                        <p class="fb-form__dsc">
                                            if you're not sure what you're doing, leave this is!
                                        </p>
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
                                                   data-offstyle="on">
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-modal__row fb-modal__row_tb">
                                    <div class="fb-modal__option fb-modal__option_light">
                                        <span class="fb-modal__middle">Auto-Cursor Focus</span>
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
    <div class="color-box__panel-wrapper contact-icon-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="contact-icon-clr">
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
                <input type="hidden" id="contact-icon-clr-trigger" value="1">
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
				<!-- content of the page -->
                <img src="assets/images/fb-contactInfo-content.png" width="100%" alt="content placeholder image">
				<!-- content of the page -->
			</section>
		</main>
	</div>
</div>

<div class="modal fade organize-pop" id="group-organize-pop">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Organize Inputs</h5>
            </div>
            <div class="modal-body pb-0">
                <div class="organize-group">
                    <ul class="organize-group__head">
                        <span>Input Type</span>
                        <span>Options</span>
                    </ul>
                    <ul class="organize-group__list">
                        <li class="organize-group__item">
                            <span class="organize-group__name">Name</span>
                            <span class="organize-group__action">
                                    <i class="ico ico-dragging"></i>
                                </span>
                        </li>
                        <li class="organize-group__item">
                            <span class="organize-group__name">Email</span>
                            <span class="organize-group__action">
                                    <i class="ico ico-dragging"></i>
                                </span>
                        </li>
                        <li class="organize-group__item">
                            <span class="organize-group__name">Phone</span>
                            <span class="organize-group__action">
                                    <i class="ico ico-dragging"></i>
                                </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Cancel</button>
                        </li>
                        <li class="action__item">
                            <button class="button button-bold button-primary" type="submit">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="advance-setting">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Advance Settings</h5>
            </div>
            <div class="modal-body pb-0">
                <div class="form-group">
                    <div class="country-code-parent select2-parent">
                        <select name="country-code" id="country-code"></select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="phone-format-parent select2-parent">
                        <select name="phone-format" id="phone-format"></select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Cancel</button>
                        </li>
                        <li class="action__item">
                            <button class="button button-bold button-primary" type="submit">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
