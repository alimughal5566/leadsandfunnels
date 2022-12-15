<!-- start Modal -->
<div class="modal fade modal-code" id="code-modal" tabindex="-1" aria-labelledby="code-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Email Instructions and Code Snippet to Your Website Admin</h5>
            </div>
            <div class="modal-body quick-scroll py-0">
                <div class="modal-body__wrap">
                    <div class="modal-code-row">
                        <strong class="modal-code-row__title">sender details</strong>
                        <strong class="modal-code-row__title">recipient details</strong>
                    </div>
                    <div class="modal-code-row modal-code-row__email-detail">
                        <div class="modal-code-row__col">
                            <div class="modal-code-row__label">
                                <label for="sender-name">Sender Name</label>
                            </div>
                            <div class="modal-code-row__field">
                                <input type="text" class="form-control" id="sender-name">
                            </div>
                        </div>
                        <div class="modal-code-row__col">
                            <div class="modal-code-row__label">
                                <label for="recieve-name">Recipient Name</label>
                            </div>
                            <div class="modal-code-row__field">
                                <input type="text" class="form-control" id="recieve-name">
                            </div>
                        </div>
                        <div class="modal-code-row__col">
                            <div class="modal-code-row__label">
                                <label>Sender Email</label>
                            </div>
                            <div class="modal-code-row__field">
                                <div class="select2-parent email-select__parent">
                                    <select class="email-select"></select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-code-row__col">
                            <div class="modal-code-row__label">
                                <label for="recieve-email">Recipient Email</label>
                            </div>
                            <div class="modal-code-row__field">
                                <input type="email" class="form-control" id="recieve-email">
                            </div>
                        </div>
                    </div>
                    <div class="modal-code-row">
                        <div class="modal-code-row__label">
                            <label for="subject">Subject Line</label>
                        </div>
                        <div class="modal-code-row__field el-tooltip subject-field-holder" title="This feature is coming soon!">
                            <input type="text" class="form-control subject-field" id="subject">
                        </div>
                    </div>
                    <div class="modal-code-row">
                        <div class="modal-code__email-body">
                            <p class="modal-code__email-body__p">Dear {{name}},</p>
                            <p class="modal-code__email-body__p">Please add this code to every page of our website just before the closing </body> tag to install leadPops. </p>
                            <p class="modal-code__email-body__p">You only need to include the code once per page.</p>
                            <p class="modal-code__email-body__p">Here it is: </p>
                            <p class="modal-code__email-body__p">&lt;!---leadPops Sticky Bar Code Starts Here---&gt;<br >&lt;script type="text/javascript" src="https://embed.clix .ly/d0b67be116d4ae460a060a8e.js"&gt;&lt;/script&lt;</p>
                            <p class="modal-code__email-body__p">Thank you!</p>
                            <p class="modal-code__email-body__p">-Team LP</p>
                            <p class="modal-code__email-body__p">support@leadPops.com</p>
                            <p class="modal-code__email-body__p">Want to learn more about on-site conversion? <a href="#" class="modal-code__email-body__link">Click Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-cancel lp-btn-cancel" data-dismiss="modal">cancel</button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-primary" data-dismiss="modal">Send</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade login-modal" id="login-modal" tabindex="-1" aria-labelledby="login-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login Details of Your Website</h5>
            </div>
            <div class="modal-body quick-scroll py-0">
                <div class="info-text">
                    <p>If it's possible, please create a temporary user account for us to install the necessary JavaScript code.</p>
                </div>
                <div class="form-group">
                    <label for="login-url" class="modal-lbl">Login URL</label>
                    <div class="input__holder">
                        <input id="login-url" name="login-url" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="login-username" class="modal-lbl">Username</label>
                    <div class="input__holder">
                        <input id="login-username" name="login-url" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="login-psw" class="modal-lbl">Password</label>
                    <div class="input__holder">
                        <input id="login-psw" name="login-url" class="form-control" type="password">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-cancel lp-btn-cancel" data-dismiss="modal">cancel</button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-primary" data-dismiss="modal">Send</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- select icon modal -->
<div class="modal fade select-icon-modal" id="select-icon-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Icon</h5>
            </div>
            <div class="modal-body">
                <div class="icons-list-holder">
                    <ul class="icons-list">

                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <ul class="btns-list">
                    <li>
                        <button type="button" class="button button-cancel btn-cancel-icon" data-dismiss="modal">Close</button>
                    </li>
                    <li>
                        <button type="button" class="button button-primary btn-add-icon disabled" disabled>Select</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
