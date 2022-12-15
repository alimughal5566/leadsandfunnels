<!-- address page -->
<div class="funnel-content funnel-content_address-overlay">
	<div class="panel-aside">
		<div class="panel-aside__head">
			<div class="col-left">
				<h4 class="panel-aside__title has-icon zip-icon">
                <span>
                    <i class="ico ico-building head-icon"></i>
                    <span class="head-text">Address</span>
                </span>
				</h4>
			</div>
			<div class="col-right">
                <img src="assets/images/powered-by-google.png" alt="powered-by-google">
            </div>
		</div>
		<div class="panel-aside-wrap">
			<div class="panel-aside-holder">
				<div class="panel-aside__body m-0 p-0">
					<!--drop down steps-->
					<div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
						<div class="fb-modal__row fb-modal__row_top-dropdown">
							<div class="edit-content-address-parent select2-parent el-tooltip select2-parent_disabled"
                                 title='<div class="address-tooltip-content-wrap"><p>In the "Settings" section below, there is a toggle
                                 <br>switch that says "Google Map Verification Step."</p> Flip that "ON" first, then
                                 you can edit the content<br>
                                    of the Google Map Verification step.</div>'>
								<select name="edit-content-address" id="edit-content-address"></select>
							</div>
						</div>
					</div>
                    <div class="fb-address-first-step">
                        <!--Add Question Detail-->
                        <div class="form-group fb-modal__border-box_dropdown">
                            <div class="fb-modal__row">
                                <div class="fb-modal__option">Question</div>
                                <div class="fb-modal__control fb-modal__control_middle">
                            <span class="fb-tooltip fb-tooltip_pb2">
                                <span class="question-mark question-mark_mr10 question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                                    <div class="fb-toggle">
                                        <input checked class="fb-field-label" name="sticky_bar_active"
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
                            <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block">
                                <div class="fb-form">
                                    <div class="fb-froala classic-editor__wrapper">
                                        <div class="fb-froala__init">Where do you live?</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="form-group fb-modal__border-box_dropdown">
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
                        <div class="form-group fb-modal__border-box_dropdown">
                            <div class="fb-modal__row">
                                <div class="fb-modal__option">Field Label</div>
                                <div class="fb-modal__control">
                                    <div class="fb-toggle">
                                        <input checked class="fb-field-label" name="field_label"
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
                            <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block;">
                                <div class="fb-form">
                                    <!--                        <div class="fb-form__caption">-->
                                    <!--                            <span class="fb-form__middle">Blank Text Field Label</span>-->
                                    <!--                            <span class="fb-tooltip">-->
                                    <!--                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>-->
                                    <!--                                </span>-->
                                    <!--                        </div>-->
                                    <div class="fb-form__group">
                                        <input type="text" class="form-control fb-form-control" value="Type in your address">
                                        <span class="tag-box">
                                    <i class="fa fa-tag"></i>
                                </span>
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
                                        <input type="text" class="form-control fb-form-control" value="CONTINUE">
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
                                                <input id="address-buttonFontSizeSlider" class="form-control" type="text"/>
                                                <input type="hidden" class="address-buttonFontSizeSlider" value="47">
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
                                        <input class="fb-checkbox__input" type="checkbox" id="fb-address-showonly-option">
                                        <label for="fb-address-showonly-option" class="fb-checkbox__label">
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
                                    <div class="fb-froala classic-editor__wrapper">
                                        <div class="fb-froala__init"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fb-address-second-step">
                        <!--Add Question Detail-->
                        <div class="form-group fb-modal__border-box_dropdown">
                            <div class="fb-modal__row">
                                <div class="fb-modal__option">Question</div>
                                <div class="fb-modal__control fb-modal__control_middle">
                            <span class="fb-tooltip fb-tooltip_pb2">
                                <span class="question-mark question-mark_mr10 question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                                    <div class="fb-toggle">
                                        <input checked class="fb-field-label" name="sticky_bar_active"
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
                            <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block">
                                <div class="fb-form">
                                    <div class="fb-froala classic-editor__wrapper">
                                        <div class="fb-froala__init">Does this general map listing look correct?</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CTA Button -->
                        <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown open">
                            <div class="fb-modal__row">
                                <div class="fb-modal__option">
                                    Button Labels
                                    <span class="fb-tooltip fb-tooltip_pb2">
                                        <span class="question-mark question-mark_mr10 question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                    </span>
                                </div>
                                <div class="fb-modal__control">
                                    <div class="fb-modal__handler">
                                        <i class="fa fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block">
                                <div class="fb-options border-0 normal-option">
                                    <div class="fb-options__clone ui-sortable">
                                        <div class="fb-options__list">
                                            <div class="fb-options__col fb-options__col_field">
                                                <div class="fb-form__group">
                                                    <input type="text" class="form-control fb-form-control" placeholder="Text to confirm address">
                                                    <span class="tag-box">
                                                        <i class="fa fa-tag"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="fb-options__col fb-options__col_handler ui-sortable-handle">
                                                <span class="tag-box tag-box_move tag-box_lg">
                                                    <i class="ico ico-dragging"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="fb-options__list">
                                            <div class="fb-options__col fb-options__col_field">
                                                <div class="fb-form__group">
                                                    <input type="text" class="form-control fb-form-control" value="No, enter another address">
                                                    <span class="tag-box">
                                                        <i class="fa fa-tag"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="fb-options__col fb-options__col_handler ui-sortable-handle">
                                                <span class="tag-box tag-box_move tag-box_lg">
                                                    <i class="ico ico-dragging"></i>
                                                </span>
                                            </div>
                                        </div>
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
                                    <div class="fb-froala classic-editor__wrapper">
                                        <div class="fb-froala__init"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Settings-->
                    <div class="form-group fb-modal__border-box_dropdown fb-modal__border-box_dropdown_setting">
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
                                        <input checked name="address_required"
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
                            <div class="fb-modal__row fb-modal__row_tb">
                                <div class="fb-modal__option fb-modal__option_light">
                                    <span class="fb-modal__middle">Google Map Verification&nbsp;Step</span>
                                    <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                                </div>
                                <div class="fb-modal__control">
                                    <div class="fb-toggle">
                                        <input name="address_required"
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
                            <div class="fb-modal__row fb-modal__row_tb">
                                <div class="fb-modal__option fb-modal__option_light">
                                    <span class="fb-modal__middle">Show Unit#</span>
                                    <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                                </div>
                                <div class="fb-modal__control">
                                    <div class="fb-toggle">
                                        <input name="show_unit"
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
                            <div class="fb-modal__row fb-modal__row_tb">
                                <div class="fb-modal__option fb-modal__option_light">
                                    <span class="fb-modal__middle">U.S Only</span>
                                    <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                                </div>
                                <div class="fb-modal__control">
                                    <div class="fb-toggle">
                                        <input name="us_only"
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
                            <div class="fb-modal__row fb-modal__row_tb">
                                <div class="fb-modal__option fb-modal__option_light">
                                    <span class="fb-modal__middle">Specify U.S state(s)</span>
                                    <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                                </div>
                                <div class="fb-modal__control">
                                    <div class="fb-toggle">
                                        <input name="specify_us_state"
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
                            <div class="fb-modal__row fb-modal__row_tb">
                                <div class="fb-modal__option fb-modal__option_light">
                                    <span class="fb-modal__middle">Auto-Cursor Focus</span>
                                    <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                                </div>
                                <div class="fb-modal__control">
                                    <div class="fb-toggle">
                                        <input name="auto_cursor"
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
                        </div>


				</div>
			</div>
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
