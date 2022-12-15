<?php
    include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
        <?php
            include ("includes/sidebar-menu.php");
        ?>
    <!-- contain the main content of the page -->
        <div id="content" class="w-100">
            <!-- header of the page -->
                <?php
                    include ("includes/header.php");
                ?>
            <!-- contain main informative part of the site -->
            <main class="main">
                <div class="main-content">

                    <!-- page messages-->
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">Account Settings - Client ID #7921</h1>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item action__item_separator">
                                        <a href="#" class="button button-payment">
                                            account payment information
                                        </a>
                                    </li>
                                    <li class="action__item">
                                        <a data-lp-wistia-title="Account Settings" data-lp-wistia-key="uneyp2xgwm"
                                           class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                            <span class="icon ico-video"></span>
                                            <span class="action-title">Watch how to video</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <form id="fcontactinfo"  class="account" method="get" action="">
                        <div class="lp-panel">
                            <div class="lp-panel__body lp-panel__body_account">
                                <div class="account__info">
                                    <div class="account__profile">
                                        <div class="lp-image__uploader">
                                            <div class="lp-image__preview">AP</div>
                                            <div class="lp-image__uploader-controls text-center">
                                                <label for="profile_img">
                                                    <input id="profile_img" name="profile_img" class="btn-image__upload" type="file" accept="image/*" value="" />
                                                    upload profile image
                                                </label>
                                                <span class="btn-image__del">Delete</span>
                                            </div>
                                            <div class="file__control">
                                                <p class="file__extension">Invalid image format! image format must be JPG, JPEG, PNG.</p>
                                                <p class="file__size">Maximum file size limit is 4MB.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="account__fields col p-0">
                                        <div class="account__fields-row">
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="first_name">First Name *</label>
                                                    <div class="input__wrapper">
                                                        <input type="text" id="first_name" name="first_name" value="Andrew" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="last_name">Last Name *</label>
                                                    <div class="input__wrapper">
                                                        <input type="text" id="last_name" name="last_name" value="Pawlak" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="email">Email Address *</label>
                                                    <div class="input__wrapper">
                                                        <input type="text" id="email" name="email" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="password">Password *</label>
                                                    <div class="input__wrapper">
                                                        <input type="password" id="password" name="password" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="confirm_password">Confirm Password *</label>
                                                    <div class="input__wrapper">
                                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="company_name">Company Name *</label>
                                                    <div class="input__wrapper">
                                                        <input type="text" id="company_name" name="company_name" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="account__fields-row">
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="cell_phone">Cell Phone *</label>
                                                    <div class="input__wrapper">
                                                        <input type="text" id="cell_phone" name="cell_phone" class="form-control" value="6198866985" maxlength="14" placeholder="(___) ___-____" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input__holder input__holder_text-cell-phone">
                                                    <label>Text Cell Phone</label>
                                                    <div class="radio">
                                                        <ul class="radio__list">
                                                            <li class="radio__item">
                                                                <input type="radio" id="yes" value="y" name="textcell" checked>
                                                                <label class="radio__lbl" for="yes">Yes</label>
                                                            </li>
                                                            <li class="radio__item">
                                                                <input type="radio" id="no" value="n" name="textcell">
                                                                <label class="radio__lbl" for="no">No</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text_cell_carrier">
                                                <div class="form-group">
                                                    <div class="input__holder">
                                                        <label for="cell_carrier">Cell Carrier</label>
                                                        <div class="input__wrapper">
                                                            <div class="select2 select2__parent-cell-carrier select2js__nice-scroll">
                                                                <select id="cell_carrier" name="cell_carrier" class="lp-select2__cell-carrier">
                                                                    <option value="">Select</option>
                                                                    <option value="message.alltel.com">Alltel</option>
                                                                    <option value="txt.att.net">AT&amp;T</option>
                                                                    <option value="myboostmobile.com">Boost Mobile</option>
                                                                    <option value="myblue.com">Centennial Wireless</option>
                                                                    <option value="mms.mycricket.com">Cricket</option>
                                                                    <option value="einsteinmms.com">Einstein PCS</option>
                                                                    <option value="mymetropcs.com">Metro PCS</option>
                                                                    <option value="messaging.nextel.com">Nextel</option>
                                                                    <option value="omnipointpcs.com">Omnipoint</option>
                                                                    <option value="teleflip.com">Other</option>
                                                                    <option value="qwestmp.com">Qwest</option>
                                                                    <option value="messaging.sdiepcs.com">Sdie</option>
                                                                    <option value="messaging.sprintpcs.com">Sprint</option>
                                                                    <option value="tmomail.net">T-Mobile</option>
                                                                    <option value="utext.com">Unicell</option>
                                                                    <option value="email.uscc.net">US Celluar</option>
                                                                    <option value="vtext.com">Verizon</option>
                                                                    <option value="vmobl.com">Virgin Mobile</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="address1">Address 1 *</label>
                                                    <div class="input__wrapper">
                                                        <input type="text" id="address1" name="address1" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="address2">Address 2</label>
                                                    <div class="input__wrapper">
                                                        <input type="text" id="address2" name="address1" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="city">City *</label>
                                                    <div class="input__wrapper">
                                                        <input type="text" id="city" name="city" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input__holder">
                                                    <label for="state">State *</label>
                                                    <div class="input__wrapper">
                                                        <div class="select2 select2__parent-state select2js__nice-scroll">

                                                            <select class="lp-select2__state" id="state" name="state" required>
                                                                <option selected="selected" value="AL" label="AL">AL</option>
                                                                <option value="AR" label="AR">AR</option>
                                                                <option value="AK" label="AK">AK</option>
                                                                <option value="AZ" label="AZ">AZ</option>
                                                                <option value="CA" label="CA">CA</option>
                                                                <option value="CO" label="CO">CO</option>
                                                                <option value="CT" label="CT">CT</option>
                                                                <option value="DC" label="DC">DC</option>
                                                                <option value="DE" label="DE">DE</option>
                                                                <option value="FL" label="FL">FL</option>
                                                                <option value="GA" label="GA">GA</option>
                                                                <option value="HI" label="HI">HI</option>
                                                                <option value="IA" label="IA">IA</option>
                                                                <option value="ID" label="ID">ID</option>
                                                                <option value="IL" label="IL">IL</option>
                                                                <option value="IN" label="IN">IN</option>
                                                                <option value="KS" label="KS">KS</option>
                                                                <option value="KY" label="KY">KY</option>
                                                                <option value="LA" label="LA">LA</option>
                                                                <option value="MA" label="MA">MA</option>
                                                                <option value="MD" label="MD">MD</option>
                                                                <option value="ME" label="ME">ME</option>
                                                                <option value="MI" label="MI">MI</option>
                                                                <option value="MN" label="MN">MN</option>
                                                                <option value="MO" label="MO">MO</option>
                                                                <option value="MS" label="MS">MS</option>
                                                                <option value="MT" label="MT">MT</option>
                                                                <option value="NC" label="NC">NC</option>
                                                                <option value="ND" label="ND">ND</option>
                                                                <option value="NE" label="NE">NE</option>
                                                                <option value="NH" label="NH">NH</option>
                                                                <option value="NJ" label="NJ">NJ</option>
                                                                <option value="NM" label="NM">NM</option>
                                                                <option value="NV" label="NV">NV</option>
                                                                <option value="NY" label="NY">NY</option>
                                                                <option value="OH" label="OH">OH</option>
                                                                <option value="OK" label="OK">OK</option>
                                                                <option value="OR" label="OR">OR</option>
                                                                <option value="PA" label="PA">PA</option>
                                                                <option value="RI" label="RI">RI</option>
                                                                <option value="SC" label="SC">SC</option>
                                                                <option value="SD" label="SD">SD</option>
                                                                <option value="TN" label="TN">TN</option>
                                                                <option value="TX" label="TX">TX</option>
                                                                <option value="UT" label="UT">UT</option>
                                                                <option value="VI" label="VI">VI</option>
                                                                <option value="VT" label="VT">VT</option>
                                                                <option value="VA" label="VA">VA</option>
                                                                <option value="WA" label="WA">WA</option>
                                                                <option value="WI" label="WI">WI</option>
                                                                <option value="WV" label="WV">WV</option>
                                                                <option value="WY" label="WY">WY</option>
                                                                <option value="GU" label="GU">GU</option>
                                                                <option value="PR" label="PR">PR</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-0">
                                                <div class="input__holder">
                                                    <label for="postal_code">Zip Code *</label>
                                                    <div class="input__wrapper">
                                                        <input type="text" id="postal_code" name="postal_code" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<!--                            <div class="lp-panel__footer">-->
<!--                                <div class="lp-panel-footer__controls text-center">-->
<!--                                    <button type="button" class="button button-secondary acc-submit-btn">save</button>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                    </form>
                    <!-- footer of the page -->
                    <div class="footer">
                        <div class="row">
                            <img src="assets/images/footer-logo.png" alt="footer logo">
                        </div>
                    </div>
                </div>
            </main>
        </div>

<?php
    include ("includes/video-modal.php");
    include ("includes/footer.php");
?>

