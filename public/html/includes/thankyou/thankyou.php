<div id="fb-thank-you" class="modal fb-modal fade">
    <div class="modal-dialog fb-modal__dialog fb-modal__dialog_cta_message">
        <div class="modal-content fb-modal__content p-0">
            <div class="fb-modal__header">
                <h2 class="fb-modal__title">Thank You</h2>
            </div>
            <div class="fb-modal__body fb-modal__body_plr30">
                <!--tk => 'thank you', clist => 'control-list'-->
                <div class="tk-bar">
                    <div class="tk-bar__title">
                        Thank You Page
                    </div>
                    <div class="tk-bar__control">
                        <ul class="tk-clist">
                            <li class="tk-clist__item">
                                <a href="#" data-toggle="modal" title="Edit Page" class="fb-toggle-button fb-toggle-button_ty-detail-page el-tooltip">Edit Page</a>
                            </li>
                            <li class="tk-clist__item">
                                <div class="button-switch">
                                    <input class="thktogbtn" id="thankyou" name="thankyou"
                                    data-thelink="thankyou_active" data-toggle="toggle" data-onstyle="active"
                                    data-offstyle="inactive" data-width="127" data-height="43"
                                    data-on="INACTIVE" data-off="ACTIVE" checked type="checkbox">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tk-note">
                    <p class="tk-note__description">Upon submission, your Funnel will take potential clients to a customizable "Thank You" page.</p>
                </div>
                <div class="tk-bar">
                    <div class="tk-bar__title">
                        Third Party URL
                    </div>
                    <div class="tk-bar__control">
                        <ul class="tk-clist">
                            <li class="tk-clist__item">
                                <a href="#" id="fb-edit-url" class="fb-toggle-button">
                                    Edit URL
                                </a>
                            </li>
                            <li class="tk-clist__item">
                                <div class="button-switch">
                                    <input  class="thktogbtn" id="thirldparty" name="thirldparty"
                                            data-thelink="thirdparty_active" data-toggle="toggle"
                                            data-onstyle="active" data-offstyle="inactive"
                                            data-width="127" data-height="43" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tk-note">
                    <p class="tk-note__description">This simple option gives your potential clients a quick thank you message, and then forwards them to a third party website of your choice. <br>You can forward your potential clients to your company website, personal website, blog, Facebook page,or other website.</p>
                </div>
                <div class="tk-field-wrap">
                    <div class="tk-field">
                        <div class="tk-field__caption">
                            <div class="select2__parent-url-prefix">
                                <select class="form-control url-prefix">
                                    <option>http://</option>
                                    <option>https://</option>
                                </select>
                            </div>
                        </div>
                        <div class="tk-field__input">
                            <input type="text" class="form-control fb-form-control fb-form-control_font_semibold" placeholder="www.facebook.com/MyBusinessPage">
                        </div>
                    </div>
                </div>
            </div>
            <div class="fb-modal__footer fb-modal__footer_border-none">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <a href="#" data-dismiss="modal" class="button button-cancel">Close</a>
                        </li>
                        <li class="action__item">
                            <a href="#" id="next" class="button button-primary">Save</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>