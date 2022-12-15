<div id="conditional-logic" class="modal fb-modal fade">
    <div class="modal-dialog fb-modal__dialog fb-modal__dialog_conditional-logic">
        <div class="modal-content fb-modal__content fb-modal__content_plr30">
            <div class="fb-modal__header fb-modal__header_conditional-logic">
                <div class="fb-cl-head">
                    <h2 class="fb-modal__title">Conditional Logic</h2>
                    <p class="fb-cl-head__subtitle">Offer intelligent Funnels to your users based on their selections</p>
                </div>
                <div class="fb-toggle fb-toggle_medium">
                    <div class="switcher-min">
                        <input  id="sticky_bar_active" name="sticky_bar_active" data-toggle="toggle min"
                                data-onstyle="active" data-offstyle="inactive"
                                data-width="92" data-height="28" data-on="INACTIVE"
                                data-off="ACTIVE" type="checkbox">
                    </div>
                </div>
            </div>
            <div class="fb-modal__body quick-scroll">
                <div class="cl-grid-clone cl-grid-clone_if">
                    <div class="cl-grid">
                        <div class="cl-grid__left">
                            <div class="cl-field">
                                <div class="cl-field__label">IF</div>
                                <div class="cl-field__select">
                                    <div class="fb-select-wrap fb-select-wrap-1 select2-parent">
                                        <select name="if" class="fb-select fb-select-1 conditional-logic-if">
                                            <option value="">Select Question</option>
                                            <option value="What is your first name?">1. What is your first name?</option>
                                            <option value="What type of property are you purchase?">2. What type of property are you purchase?</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="cl-field cl-field_state cl-field_disabled">
                                <div class="cl-field__label">State</div>
                                <div class="cl-field__select">
                                    <div class="fb-select-wrap fb-select-wrap-2 select2-parent">
                                        <select name="cl_state" class="fb-select fb-select-2 conditional-logic-state">
                                            <option value="">Select State</option>
                                            <option value="1">Is Equal To</option>
                                            <option value="2">Not Equal To</option>
                                            <option value="3">Empty</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="cl-field cl-field_value cl-field_disabled">
                                <div class="cl-field__label">Value</div>
                                <div class="cl-field__select">
                                    <div class="fb-select-wrap fb-select-wrap-3 select2-parent">
                                        <select class="fb-select fb-select-3">
                                            <option value="">Select Value</option>
                                            <option value="1">I have no idea!</option>
                                            <option value="2">I have no idea!</option>
                                            <option value="3">I have no idea!</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cl-grid__right">
                            <a href="#" data-parents="cl-grid-clone_if" class="fb-add-box fb-add-box_clone fb-add-box_clone-if">
                                <!--                                <i class="fbi fbi_plus-green"></i>-->
                                <i class="ico ico-plus"></i>
                            </a>
                            <a href="#" class="fb-add-box fb-add-box_close">
                                <!--                                <i class="fbi fbi_cross-red"></i>-->
                                <i class="ico ico-cross"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="cl-grid-clone cl-grid-clone_do">
                    <div class="cl-grid">
                        <div class="cl-grid__left">
                            <div class="cl-field">
                                <div class="cl-field__label">THEN</div>
                                <div class="cl-field__select">
                                    <div class="fb-select-wrap fb-select-wrap-4 select2-parent">
                                        <select class="fb-select fb-select-4 conditional-logic-do">
                                            <option value="">Select Condition Action</option>
                                            <option value="1">Show Multiple</option>
                                            <option value="2">1</option>
                                            <option value="3">2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="cl-field cl-field_field cl-field_disabled">
                                <div class="cl-field__label">Field</div>
                                <div class="cl-field__select">
                                    <div class="fb-select-wrap fb-select-wrap-5 select2-parent">
                                        <select class="fb-select fb-select-5">
                                            <option value="">Select a Field</option>
                                            <option value="What is your first name?">1. What is your first name?</option>
                                            <option value="What type of property are you purchase?">2. What type of property are you purchase?</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cl-grid__right">
                            <a href="#" data-parents="cl-grid-clone_do" class="fb-add-box fb-add-box_clone fb-add-box_clone-do">
                                <i class="fbi ico-plus"></i>
                            </a>
                            <a href="#" class="fb-add-box fb-add-box_close">
                                <i class="fbi ico-cross"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="cl-grid">
                    <div class="cl-other-cases">
                        <div class="cl-field__label">In <span>ALL</span> other cases</div>
                        <div class="cl-field__select">
                            <div class="fb-select-wrap select2-parent fb-select-wrap-6">
                                <select class="fb-select fb-select-6">
                                    <option value="">Select Action</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="fb-modal__footer fb-modal__footer_conditional-logic">
                <a href="javascript:void();" class="cl-footer-link view-active__conditions">active conditions</a>
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <a href="#" class="button button-bold button-cancel" data-dismiss="modal">Cancel</a>
                        </li>
                        <li class="action__item">
                            <a href="#" class="button button-bold button-primary">Save</a>
                        </li>
                    </ul>
                    <!--                    <a href="#" data-dismiss="modal" class="lp-btn lp-btn_danger lp-btn_mr20">Cancel</a>-->
                    <!--                    <a href="#" class="lp-btn lp-btn_success">Save</a>-->
                </div>
            </div>
        </div>
    </div>
</div>