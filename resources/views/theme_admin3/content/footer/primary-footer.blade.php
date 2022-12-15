@php
/*print('privacy_active => '.@$view->data->bottomlinks['privacy_active']);
echo "<br>";
print('terms_active => '.@$view->data->bottomlinks['terms_active']);
echo "<br>";
print('disclosures_active => '.@$view->data->bottomlinks['disclosures_active']);
echo "<br>";
print('licensing_active => '.@$view->data->bottomlinks['licensing_active']);
echo "<br>";
print('about_active => '.@$view->data->bottomlinks['about_active']);
echo "<br>";
print('contact_active => '.@$view->data->bottomlinks['contact_active']);
echo "<br>";*/

 //print_r(@$view->data->globalOptions);
 //print_r(@$view->data->globalOptions['advanced_footer_active']);


/*print('privacy_policy_active => '.@$view->data->globalOptions['privacy_policy_active']);
echo "<br>";
print('terms_of_use_active => '.@$view->data->globalOptions['terms_of_use_active']);
echo "<br>";
print('disclosures_active => '.@$view->data->globalOptions['disclosures_active']);
echo "<br>";
print('licensing_information_active => '.@$view->data->globalOptions['licensing_information_active']);
echo "<br>";
print('about_active => '.@$view->data->globalOptions['about_us_active']);
echo "<br>";
print('contact_us_active => '.@$view->data->globalOptions['contact_us_active']);
echo "<br>";*/
@endphp
<div class="lp-panel py-0">
    <div class="card-header">
        <div class="lp-panel__head border-0 p-0">
            <div class="col-left">
                <h2 class="card-title">
                    <span>
                       Primary Footer Options
                   </span>
                </h2>
            </div>
            <div class="col-right">
                <div class="card-link expandable" data-toggle="collapse" aria-expanded="false"
                     href="#primaryfooter"></div>
            </div>
        </div>

    </div>
    <div id="primaryfooter" class="collapse show">
        <div class="card-body">
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h3 class="lp-panel__title">
                            @php echo ($view->data->bottomlinks['privacy_text'] == "" ? "Privacy Policy" : $view->data->bottomlinks['privacy_text']);  @endphp
                        </h3>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/privacypolicy/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>

                                                                {{-- <a href="{{route('privacypolicy', [@$view->data->currenthash, 'app_theme' => 'theme_admin3'])}}" class="action__link">
                                                                     <span class="ico ico-edit"></span>edit page
                                                                 </a>--}}
                                                            </span>
                                </li>
                                <li class="action__item global_switch_holder">

                                    @php $checked="";
                                            if($view->data->bottomlinks["privacy_active"]=="y"){
                                                $checked="checked";
                                            }

                                    @endphp

                                    <input @php echo $checked;@endphp class="pfobtn global-switch"
                                           data-lpkeys="@php echo $view->data->lpkeys; @endphp~privacy_active"
                                           data-toggle="toggle"

                                           data-global_val="{{@$view->data->globalOptions['privacy_policy_active']}}"
                                           data-val="{{@$view->data->bottomlinks["privacy_active"]}}"
                                           data-thelink="privacy_active"
                                           name="privacy_active"

                                           data-onstyle="active" data-offstyle="inactive"
                                           data-width="127" data-height="43"
                                           data-on="INACTIVE" data-off="ACTIVE"
                                           type="checkbox" data-form-field>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h3 class="lp-panel__title">
                            @php echo ($view->data->bottomlinks['terms_text'] == "" ? "Terms of Use" : $view->data->bottomlinks['terms_text']);  @endphp
                        </h3>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/termsofuse/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                </li>
                                <li class="action__item global_switch_holder">
                                    @php $checked="";
                                            if($view->data->bottomlinks["terms_active"]=="y"){
                                                $checked="checked";

                                            }
                                    @endphp
                                    <input @php echo $checked; @endphp class="pfobtn global-switch"
                                           data-lpkeys="@php echo $view->data->lpkeys; @endphp~terms_active"
                                           data-toggle="toggle"

                                           data-global_val="{{@$view->data->globalOptions['terms_of_use_active']}}"
                                           data-val="{{@$view->data->bottomlinks["terms_active"]}}"
                                           data-thelink="terms_active"
                                           name="terms_active"

                                           data-onstyle="active" data-offstyle="inactive"
                                           data-width="127" data-height="43" data-on="INACTIVE"
                                           data-off="ACTIVE" type="checkbox" data-form-field>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h3 class="lp-panel__title">
                            @php echo ($view->data->bottomlinks['disclosures_text'] == "" ? "Disclosures" : $view->data->bottomlinks['disclosures_text']);  @endphp
                        </h3>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/disclosures/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                </li>
                                <li class="action__item global_switch_holder">
                                    @php $checked="";
                                            if($view->data->bottomlinks["disclosures_active"]=="y"){
                                                $checked="checked";

                                            }
                                    @endphp
                                    <input @php echo $checked; @endphp class="pfobtn global-switch"
                                           data-lpkeys="@php echo $view->data->lpkeys; @endphp~disclosures_active"
                                           data-toggle="toggle"

                                           data-global_val="{{@$view->data->globalOptions['disclosures_active']}}"
                                           data-val="{{@$view->data->bottomlinks["disclosures_active"]}}"
                                           data-thelink="disclosures_active"
                                           name="disclosures_active"

                                           data-onstyle="active" data-offstyle="inactive"
                                           data-width="127" data-height="43" data-on="INACTIVE"
                                           data-off="ACTIVE" type="checkbox" data-form-field>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h3 class="lp-panel__title">
                            @php echo ($view->data->bottomlinks['licensing_text'] == "" ? "Licensing Information" : $view->data->bottomlinks['licensing_text']);  @endphp
                        </h3>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/licensinginformation/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                </li>
                                <li class="action__item global_switch_holder">
                                    @php $checked="";
                                            if($view->data->bottomlinks["licensing_active"]=="y"){
                                                $checked="checked";

                                            }
                                    @endphp
                                    <input @php echo $checked; @endphp class="pfobtn global-switch"
                                           data-lpkeys="@php echo $view->data->lpkeys; @endphp~licensing_active"
                                           data-toggle="toggle"

                                           data-global_val="{{@$view->data->globalOptions['licensing_information_active']}}"
                                           data-val="{{@$view->data->bottomlinks["licensing_active"]}}"
                                           data-thelink="licensing_active"
                                           name="licensing_active"

                                           data-onstyle="active" data-offstyle="inactive"
                                           data-width="127" data-height="43" data-on="INACTIVE"
                                           data-off="ACTIVE" type="checkbox" data-form-field>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h3 class="lp-panel__title">
                            @php echo ($view->data->bottomlinks['about_text'] == "" ? "About Us" : $view->data->bottomlinks['about_text']);  @endphp
                        </h3>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/aboutus/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                </li>
                                <li class="action__item global_switch_holder">
                                    @php $checked="";
                                            if($view->data->bottomlinks["about_active"]=="y"){
                                                $checked="checked";

                                            }
                                    @endphp
                                    <input @php echo $checked; @endphp class="pfobtn global-switch"
                                           data-lpkeys="@php echo $view->data->lpkeys; @endphp~about_active"
                                           data-toggle="toggle"

                                           data-global_val="{{@$view->data->globalOptions['about_us_active']}}"
                                           data-val="{{@$view->data->bottomlinks["about_active"]}}"
                                           data-thelink="about_active"
                                           name="about_active"

                                           data-onstyle="active" data-offstyle="inactive"
                                           data-width="127" data-height="43" data-on="INACTIVE"
                                           data-off="ACTIVE" type="checkbox" data-form-field>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-panel">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h3 class="lp-panel__title">
                            @php echo ($view->data->bottomlinks['contact_text'] == "" ? "Contact Us" : $view->data->bottomlinks['contact_text']);  @endphp
                        </h3>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/contactus/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                </li>
                                <li class="action__item global_switch_holder">
                                    @php $checked="";
                                            if($view->data->bottomlinks["contact_active"]=="y"){
                                                $checked="checked";
                                            }
                                    @endphp
                                    <input @php echo $checked; @endphp class="pfobtn global-switch"
                                           data-lpkeys="@php echo $view->data->lpkeys; @endphp~contact_active"

                                           data-global_val="{{@$view->data->globalOptions['contact_us_active']}}"
                                           data-val="{{@$view->data->bottomlinks["contact_active"]}}"
                                           data-thelink="contact_active"
                                           name="contact_active"


                                           data-toggle="toggle"
                                           data-onstyle="active" data-offstyle="inactive"
                                           data-width="127" data-height="43" data-on="INACTIVE"
                                           data-off="ACTIVE" type="checkbox" data-form-field>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

