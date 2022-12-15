<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/',  [
//  'uses' => 'IndexController@testpage',
//  'as' => 'testpage'
//]);

Route::get('/', function () {
    return redirect("/lp");
});

//Redirect login to lp
Route::get('/login', function () {
    return redirect("/lp");
});

Route::get('/ajax', 'TestAjaxController@ajax');
Route::any('/ajax-data', 'TestAjaxController@getAjaxData');
Route::get('test1', 'TestController@test1');
Route::get('allsession', 'TestController@all_session');


Route::get('/login/freetrial', 'LoginController@freeTrialLogin')->name('login_freetrial');

Route::group(['prefix' => "/lp"], function () {
    Route::any('/test', 'TestController@test')->name('dev_test');
    Route::any('/console/funnels', 'DebugController@funnels')->name('deubg_funnels');
    Route::any('/console/funnelinfo/{hash}', 'DebugController@funnelsInfo')->name('deubg_funnels_info');

    /**
     * New Account Launch Screen Password Set Route(s)
     */
    Route::get('/activate/{hash}', 'GuestController@activateClient')->name('guest.activateClient');
    Route::post('/activate/{hash}', 'GuestController@activateClient')->name('guest.activateClient');

    /**
     * New Account Launch Screen Route(s)
     */
    Route::group(['prefix' => 'launcher'], function () {
        Route::get('/', 'LauncherController@index')->name('launcher');
        Route::get('/launchFunnelScreen', 'LauncherController@launchFunnelShow')->name('launchFunnelShow');
        Route::post('/launchClientFunnel', 'LauncherController@launchFunnel')->name('launchFunnel');
        Route::post('/getlogoprimarycolor', 'LauncherController@getLogoPrimaryColor')->name('getLogoPrimaryColor');
        // http://branch5-myleads.leadpops.com/lp/launcher/launchClientFunnel
        Route::get('/getInitialSwatches', 'LauncherController@getInitialSwatches')->name('getLauncherInitialSwatches');
        Route::get('/getLaunchStatus', 'LauncherController@getLaunchStatus')->name('getLaunchStatus');
    });

    /**
     * Login Route(s)
     */
    Route::group(['prefix' => 'login'], function () {
        Route::get('/', 'LoginController@indexAction')->name('login');
        Route::get('/is_andrew', 'LoginController@isandrewAction')->name('login_andrew');
        Route::get('/ismovement', 'LoginController@ismovementAction')->name('login_movement');
        Route::get('/isfairwaymc', 'LoginController@isfairwaymcAction')->name('login_fairwaymc');
        Route::get('/reporting', 'LoginController@reportingAction')->name('login_reporting_portal');

        Route::post('/go', 'LoginController@goAction')->name('login_action');
    });

    /**
     * Password Reset Route(s)
     */
    Route::group(['prefix' => 'password'], function () {
//        Route::get('/reset-link', 'PasswordController@sendResetLinkEmail')->name('password_email');
//        Route::get('/reset/{token}', 'PasswordController@newPasswordAction')->name('password_reset');
//        Route::post('/reset', 'PasswordController@resetPassword')->name('password_update');
//        Route::post('/forgotpassword', 'PasswordController@forgotpassword')->name('forgot_password');

        Route::post('/reset_link', 'PasswordController@newSendResetPasswordLink')->name('reset_link');
        Route::get('/reset/{token}', 'PasswordController@newPasswordResetAction')->name('new_password_reset');
        Route::post('/reset', 'PasswordController@newResetPassword')->name('new_password_update');
    });

    /**
     * Routes which can be accessed after authentication
     */
    Route::group(['middleware' => ['auth']], function () {
        /**
         * Dashboard
         */
        Route::get('/', 'IndexController@indexAction')->name('dashboard');

        Route::group(['prefix' => 'index'], function () {
            Route::get('/', 'IndexController@indexAction')->name('dashboard');
            Route::any('/modifydomainstatus', 'IndexController@modifydomainstatusAction');
            Route::any('/setoverlaysessionflag', 'IndexController@setoverlaysessionflagAction');
            Route::any('/overlaycancel', 'IndexController@overlaycancelAction');
            Route::any('/syncportalpassword', 'IndexController@syncportalpasswordAction');
            Route::any('/clonefunnel/{hash}', 'IndexController@clonefunnel')->name('clone_funnel_route');
            Route::post('/deletefunnel/{hash}', 'IndexController@deletefunnel');
            Route::post('/upgradetoproplan', 'IndexController@upgradeClientToProPlan');
        });

        /**
         * Ajax Route(s)
         */

        Route::group(['prefix' => 'ajax'], function () {
            Route::post('/updatebottomlinks', 'AjaxController@updatebottomlinks')->name('ajax_updatebottomlinks');
            Route::post('/updatecompliance', 'AjaxController@updatecompliance')->name('ajax_updatecompliance');
            Route::post('/updateadvancefooter', 'AjaxController@updateadvancefooter')->name('ajax_updateadvancefooter');
            //Route::post('/updateseotags', 'AjaxController@updateseotags')->name('ajax_updateseotags');     // @deprecated route v3.0
            Route::post('/updatecontact', 'AjaxController@updatecontact')->name('ajax_updatecontact');
            Route::post('/checksubdomainavailable', 'AjaxController@checksubdomainavailable')->name('ajax_checksubdomainavailable');
            Route::post('/checkdomainavailable', 'AjaxController@checkdomainavailable')->name('ajax_checkdomainavailable');
            Route::post('/download_rs_image', 'AjaxController@downloadRackspaceImage')->name('ajax_downloadRackspaceImage');
            Route::post('/getdomainfromid', 'AjaxController@getdomainfromid')->name('getdomainfromid');
            Route::post('/updatetemplatecta', 'AjaxController@updatetemplatecta');
            Route::post('/current_logo', 'AjaxController@getCurrentLogo');
            Route::post('/savefunnelquestions/{hash}', 'FunnelController@saveFunnelQuestions');
            Route::post('/togglelpimage/{hash}', 'FunnelController@toggleLpImage');
            Route::post('/savesecuritymessage/{hash}', 'FunnelController@saveSecurityMessage');
        });

        Route::group(['prefix' => 'content'], function () {
            Route::get('/extra-content/{hash}', 'ContentController@advanceFooter')->name('advance_footer');
            Route::post('/extra-content/{hash}', 'ContentController@advanceFooter')->name('advance_footer');
        });

        Route::group(['prefix' => 'popadmin'], function () {
            Route::get('/stats/{hash}', 'StatsController@statistics')->name('statistics');


            /* Call to Action */
            Route::get('/calltoaction/{hash}', 'ContentController@calltoactionAction')->name('calltoaction');
            Route::post('/calltoactionsave', 'ContentController@calltoactionsaveAction')->name('calltoaction_save');
            Route::post('/resetctamessage/{hash}', 'ContentController@resetctamessageAction')->name('calltoaction_reset_cta');
            Route::post('/resetctadescription/{hash}', 'ContentController@resetctadescriptionAction')->name('calltoaction_reset_desc');

            /* Footer */
            Route::get('/footeroption/{hash}', 'ContentController@footeroptionAction')->name('footeroption');
            Route::post('/footeroption/{hash}', 'ContentController@footerOptionPageSaveAction')->name('footeroption_page_save');
            Route::post('/savefooteroptions', 'ContentController@savefooteroptionsAction')->name('footeroption_save');
            Route::get('/privacypolicy/{hash}', 'ContentController@privacypolicyAction')->name('privacypolicy');
            Route::get('/termsofuse/{hash}', 'ContentController@termsofuseAction')->name('termsofuse');
            Route::get('/disclosures/{hash}', 'ContentController@disclosuresAction')->name('disclosures');
            Route::get('/licensinginformation/{hash}', 'ContentController@licensinginformationAction')->name('licensinginformation');
            Route::get('/aboutus/{hash}', 'ContentController@aboutusAction')->name('aboutus');
            Route::get('/contactus/{hash}', 'ContentController@contactusAction')->name('contactus');

            /* Autoresponder */
            Route::get('/autoresponder/{hash}', 'ContentController@autoresponderAction')->name('autoresponder');
            Route::post('/updateautoresponder', 'ContentController@updateautoresponderAction')->name('updateautoresponder');
            Route::post('/autorespondsave', 'ContentController@autorespondsaveAction')->name('autorespondsave');

            /* SEO */
            Route::get('/seo/{hash}', 'ContentController@seoAction')->name('seo');
            Route::post('/seosave', 'ContentController@seosaveAction')->name('seo_save');

            /* Contact Info */
            Route::get('/contact/{hash}', 'ContentController@contactAction')->name('contact');
            Route::post('/contactinfosave', 'ContentController@contactinfosaveAction')->name('contact_save');

            /* Thank you */
            Route::group(['prefix' => 'thank-you-pages'], function () {
                Route::get('/{hash}', 'ContentController@thankyoupagesAction')->name('thankyou.listing');

                Route::post('/re-ordering', 'ContentController@thankyouPagesReOrdering')->name('thankyou.pages.orders');
                Route::post('/funnel-builder-thankyou-setting', 'ContentController@funnelBuilderThankSetting')->name('funnel-builder-thankyou');
                Route::post('/duplicate', 'ContentController@thankyouPagesDuplicateAction')->name('thankyou.pages.duplicate');
                Route::post('/save/{hash}', 'ContentController@thankyouPagesSaveAction')->name('thankyou.pages.save');

                Route::get('/add/{hash}', 'ContentController@thankyouPagesAddAction')->name('thankyou.pages.edit');
                Route::get('/edit/{id}/{hash}', 'ContentController@thankyoupageseditAction')->name('thankyou.pages.edit');

                Route::delete('/delete', 'ContentController@thankyoupagesDeleteAction')->name('thankyou.pages.delete');
            });

            Route::get('/thankyou/{hash}', 'ContentController@thankyouAction')->name('thankyou');
            Route::post('/thank-you-pages', 'ContentController@updateThankyouPage')->name('thankyou.pages.update');
            Route::get('/thankyoumessage/{hash}', 'ContentController@thankyoumessageAction')->name('thankyoumessage');
            Route::post('/thankmessagesave', 'ContentController@thankmessagesaveAction')->name('thankyoumessage_save');
            Route::post('/thanksettingsave', 'ContentController@thanksettingsaveAction');

            /* Desgin Route(s) */
            Route::get('/logo/{hash}', 'DesignController@logoAction')->name('logo');
            Route::get('/background/{hash}', 'DesignController@backgroundAction')->name('background');
            Route::post('/logo-colors', 'DesignController@getLogoColors');
            Route::post('/update-customized-color', 'DesignController@setCustomizedBackgroundColor')->name('update-background-customized-color');
            Route::get('/featuredmedia/{hash}', 'DesignController@featuredmediaAction')->name('featuredmedia');
            Route::post('/uploadlogo/{hash}', 'DesignController@uploadlogo')->name('uploadlogo');
            Route::post('/changelplogo/{hash}', 'DesignController@changelplogo')->name('changelplogo');
            Route::post('/update-logo-size/{hash}', 'DesignController@updateLogoScale')->name('updatelogoscale');
            Route::post('/update-featured-image-size/{hash}', 'DesignController@changelpIimageScalingProperties')->name('updatefeaturedimagescale');
            Route::post('/getinitialswatches', 'DesignController@getinitialswatches')->name('getinitialswatches');
            Route::post('/updatebackgroundcolors', 'DesignController@updatebackgroundcolors')->name('updatebackgroundcolors');
            Route::post('/updatebackgroundimage/{hash}', 'DesignController@updatebackgroundimageAction')->name('updatebackgroundimage');
            Route::post('/uploadimage', 'DesignController@uploadimage')->name('uploadimage');
            Route::post('/deletelogo', 'DesignController@deletelogo')->name('deletelogo');
            Route::post('/backgroundoptionstoggle', 'DesignController@backgroundoptionstoggle')->name('backgroundoptionstoggle');
            Route::post('/changeimage', 'DesignController@changeimageAction')->name('changeimage');
            Route::post('/changetodefaultimage', 'DesignController@changetodefaultimageAction')->name('changetodefaultimage');
            Route::post('/activetodefaultimage', 'DesignController@activetodefaultimageAction')->name('activetodefaultimage');

            /* Domain Settings */
            Route::get('/domain/{hash}', 'SettingsController@domainAction')->name('domain');
            Route::post('/savechecksubdomainavailable', 'SettingsController@savechecksubdomainavailableAction')->name('subdomain_save');
            Route::post('/savecheckdomainavailable', 'SettingsController@savecheckdomainavailableAction')->name('domain_save');
            Route::post('/deletethisdomain', 'SettingsController@deletethisdomainAction')->name('domain_delete');

            /* Pixel Settings */
            Route::get('/pixels/{hash}', 'SettingsController@pixelsAction')->name('pixels');
            Route::post('/savepixelinfo', 'SettingsController@savepixelinfoAction')->name('pixels_save');
            Route::post('/deletepixelinfo', 'SettingsController@deletepixelinfoAction')->name('pixels_delete');

            /* Integration Settings */
            Route::get('/integration/{hash}', 'SettingsController@integrationAction')->name('integration');
            Route::get('/integrate/{key}/{hash}', 'SettingsController@integrate')->name('integrate');
            Route::post('/createauthkey', 'SettingsController@createauthkeyAction')->name('create_auth_key');
            Route::post('/savezapierfunnels', 'SettingsController@savezapierfunnelsAction')->name('save_zapier');
            Route::any('/totalexpert', 'SettingsController@totalexpertAction');
            Route::any('/totalexpertoauth', 'SettingsController@totalexpertoauthAction');
            Route::post('/totalexpertdelete', 'SettingsController@totalexpertdeleteAction');
            Route::any('/homebotdelete', 'SettingsController@homebotdeleteAction');
            Route::post('/{key}/update', 'IntegrationController@update')->name('updateIntegration');

            /* ADA Accessability*/
            Route::get('/adaaccessibility/{hash}', 'SettingsController@adaAccessibility')->name('ada_accessibility');
            Route::post('/adaaccessibility/{hash}', 'SettingsController@adaAccessibility')->name('ada_accessibility');


            Route::get('/hub', 'SettingsController@hub')->name('hub');
            Route::get('/hubdetail', 'SettingsController@hubdetailAction')->name('hubdetail');
            Route::post('/checkfunneldomain', 'SettingsController@checkStickyDomainAvailable');
            Route::post('/savestickybar', 'SettingsController@savestickybar');
            Route::post('/captureScreenshot', 'SettingsController@captureScreenshot');
            Route::post('/updatestickycodetype', 'SettingsController@updatestickycodetype');
            /* Saif */
            /* Sticky Bar verison 2 */

            Route::post('/updatestickybarstatusv2', 'SettingsController@updatestickybarstatusv2');
            Route::post('/checkfunneldomainv2', 'SettingsController@checkfunneldomainv2');
            Route::post('/updatestickycodetypev2', 'SettingsController@updatestickycodetypev2');
            Route::post('/savethirdpartyslug', 'SettingsController@savethirdpartyslug');
            Route::post('/is_iframe_support', 'SettingsController@is_iframe_support');
            Route::post('/savestickybarv2', 'SettingsController@savestickybarv2');
            Route::post('/diactivethirdpartywebsite', 'SettingsController@diactivethirdpartywebsite');

            /* footer froala images */

            Route::post('/footerimageupload', 'GlobalController@footerimageupload');
            Route::post('/footerimageremove', 'GlobalController@footerimageremove');

            /* footer froala images global */

            Route::post('/globalimageupload', 'GlobalController@globalimageupload');
            Route::post('/globalimageremove', 'GlobalController@globalimageremove');

            /* funnel builder route */
            Route::get('/funnel/questions/{hash}', 'FunnelController@index')->name('funnel-builder');

            /* TCPA */
            Route::get('/tcpa/{hash}', 'TcpaController@index')->name('tcpaIndex');
            Route::get('/tcpa-create/{hash}', 'TcpaController@create')->name('createTcpaFromPage');
            Route::post('/tcpa-create-message', 'TcpaController@createTcpaMessage')->name('createTcpaFromMessage');
            Route::get('/tcpa-edit/{hash}/{id}', 'TcpaController@edit')->name('EditTcpaFromPage');
            Route::post('/tcpa-edit-message/{id}', 'TcpaController@editTcpaMessage')->name('editTcpaFromMessage');
            Route::post('/tcpa-delete-message', 'TcpaController@deleteTcpaMessage')->name('deleteTcpaMessage');
            Route::post('/toggle-tcpa-message', 'TcpaController@toggleTcpaMessage')->name('toggleTcpaMessage');


            /* Security Messages */
            Route::get('/security-messages/{hash}', 'SecurityMessagesController@index')->name('SecurityMessagesIndex');
            Route::get('/security-messages-edit/{hash}/{id}', 'SecurityMessagesController@edit')->name('EditSecurityMessagesFromPage');

            Route::post('/security-message-create', 'SecurityMessagesController@createSecurityMessage')->name('CreateSecurityMessage');
            Route::post('/security-message-edit/{id}', 'SecurityMessagesController@editMessage')->name('editSecurityMessage');
            Route::post('/delete-security-message', 'SecurityMessagesController@deleteSecurityMessage')->name('deleteSecurityMessage');


        });


        Route::group(['prefix' => 'myleads'], function () {
            Route::get('/index/{hash}', 'AccountController@myleads')->name('myleads');
            Route::post('/getleads/{hash}', 'AccountController@getleads')->name('getleads');
            Route::post('/getallfunnelkey/{hash}', 'AccountController@getallfunnelkey')->name('getallfunnelkey');
            Route::post('/deleteselectedleads/{hash}', 'AccountController@deleteMultipleLeads')->name('deleteselectedleads');
            Route::post('/deletepoplead', 'AccountController@deleteLead')->name('deletepoplead');
            Route::post('/getleaddetail/{hash}', 'AccountController@getleaddetail')->name('getleaddetail');
        });


        Route::group(['prefix' => 'recipients'], function () {
            Route::get('contacts/{hash}', 'FunnelController@allcontacts')->name('get.all.recipients');
            Route::post('save', 'FunnelController@saveNewRecipient')->name('save.recipients');

        });
        Route::group(['prefix' => 'vehicle'], function () {
            Route::post('/make', 'MakeController@getVehicleMakes')->name('getvehiclemakes');
            Route::post('/model', 'ModelController@getVehicleModels')->name('getvehiclemodels');
        });

        Route::get('/account', 'AccountController@index')->name('account');
        Route::get('/account/contacts/{hash}', 'AccountController@contacts')->name('contacts');
        Route::get('/account/profile', 'AccountController@profile')->name('my_profile');
        Route::post('/account/savecontactinfo', 'AccountController@savecontactinfo');
        Route::post('/account/savenewrecipient', 'AccountController@savenewrecipient');
        Route::post('/account/saveNewRecipientAdminThree', 'AccountController@saveNewRecipientAdminThree');
        Route::post('/account/editRecipientAdminThree', 'AccountController@editRecipientAdminThree');
        Route::post('/account/deleteleadrecipient', 'AccountController@deleteleadrecipient');

        Route::get('/support', 'AccountController@support')->name('support');
        Route::get('/support/index/sup/videos', 'AccountController@support')->name('videos');
        Route::get('/support/index/sup/ticket', 'AccountController@support')->name('ticket');
        Route::post('/cancelrequest', 'AccountController@cancelrequest')->name('cancelrequest');
        Route::post('/support/feed', 'AccountController@feed')->name('feed');

        #Route::post('/clonefunnel', 'IndexController@clonefunnel');
        Route::get('/tagmapping', 'IndexController@tagmapping');
        Route::post('/tagfiltersession', 'IndexController@tagfiltersession');
        Route::post('/clienttraningsetting', 'IndexController@clienttraningsetting');

        Route::group(['prefix' => 'global'], function () {
            Route::get('/', 'GlobalController@index')->name('global_settings');
            Route::post('/uploadgloballogo', 'GlobalController@uploadgloballogo')->name('upload_global_logo');
            Route::post('/updateglobalbackgroundimage', 'GlobalController@updateglobalbackgroundimage')->name('update_background_image');
            Route::post('/updateglobalbackgroundcolor', 'GlobalController@updateglobalbackgroundcolor')->name('update_background_color');
            Route::post('/uploadglobalimage', 'GlobalController@uploadglobalimage')->name('upload_global_image');
            Route::post('/saveglobalmaincontent', 'GlobalController@saveglobalmaincontent')->name('save_global_main_content');
            Route::post('/saveglobalautoresponder', 'GlobalController@saveglobalautoresponder')->name('save_global_autoresponder');
            Route::post('/globalsaveseo', 'GlobalController@globalsaveseo')->name('save_seo_global');
            Route::post('/globalsavecontactoptions', 'GlobalController@globalsavecontactoptions')->name('save_global_contact_options');
            Route::post('/globalsavethankyouoptions', 'GlobalController@globalsavethankyouoptions')->name('save_global_thankyou_options');
            Route::get('/privacypolicy', 'GlobalController@privacypolicy')->name('privacypolicy');
            Route::get('/termsofuse', 'GlobalController@termsofuse')->name('termsofuse');
            Route::get('/disclosures', 'GlobalController@disclosures')->name('disclosures');
            Route::get('/licensinginformation', 'GlobalController@licensinginformation')->name('licensinginformation');
            Route::get('/aboutus', 'GlobalController@aboutus')->name('aboutus-global');
            Route::get('/contactus', 'GlobalController@contactus')->name('contactus-global');
            Route::post('/savefooteroptions', 'GlobalController@savefooteroptions')->name('savefooteroptions-global');
            Route::post('/updatecompliance', 'GlobalController@updatecompliance')->name('update_compliance');
            Route::post('/deletelogoglobal', 'GlobalController@deletelogoglobal');
            Route::post('/activetodefaultimageglobal', 'GlobalController@activetodefaultimageglobal');
            Route::post('/updatestatusglobaladvancefooter', 'GlobalController@updatestatusglobaladvancefooter');
            Route::post('/updateglobaladvancefooter', 'GlobalController@updateglobaladvancefooter');
            Route::post('/updateAdaAccessibility', 'GlobalController@updateAdaAccessibility');

            //********************************************************//
            //**************** AdminThree GLOBAL Routes **************//
            //********************************************************//

            // Global Routes
            Route::post('/updateComplianceAdminThree', 'GlobalControllerAdminThree@updateComplianceAdminThree')
                ->name('updateGlobalComplianceAdminThree');

            Route::post('/saveFooterOptionsAdminThree', 'GlobalControllerAdminThree@saveFooterOptionsAdminThree')
                ->name('saveFooterOptionsAdminThree');


            Route::post('/saveGlobalContactOptionAdminThree', 'GlobalControllerAdminThree@saveGlobalContactOption')
                ->name('saveGlobalContactOptionAdminThree');



           /* Route::post('/updateStatusGlobalAdvanceFooterAdminThree', 'GlobalControllerAdminThree@updatestatusglobaladvancefooter')
                ->name('updateStatusGlobalAdvanceFooterAdminThree');*/




         /*   Route::post('/updateglobaladvancefooterAdminThree', 'GlobalControllerAdminThree@updateglobaladvancefooter')
                ->name('updateglobaladvancefooterAdminThree');*/


            Route::post('/GlobalSaveThankyouOptionsAdminThree', 'GlobalControllerAdminThree@globalsavethankyouoptions')
                ->name('GlobalSaveThankyouOptionsAdminThree');


            Route::post('/GlobalSaveThankyouMessageAdminThree', 'GlobalControllerAdminThree@globalsavethankyouMessage')
                ->name('GlobalSaveThankyouMessageAdminThree');


            Route::post('/updatePrimaryFooterTogglesAdminThree', 'GlobalControllerAdminThree@updatePrimaryFooterTogglesAdminThree')
                ->name('updatePrimaryFooterTogglesAdminThree');


            Route::post('/saveSeoGlobalAdminThree', 'GlobalControllerAdminThree@globalsaveseo')
                ->name('saveSeoGlobalAdminThree');




            Route::post('/advanceFooterSaveActionGlobalAdminThree', 'GlobalControllerAdminThree@advanceFooterSaveActionGlobalAdminThree')
                ->name('advanceFooterSaveActionGlobalAdminThree');

            Route::post('/footerOptionPageSaveActionGlobalAdminThree', 'GlobalControllerAdminThree@footerOptionPageSaveActionGlobalAdminThree')
                ->name('footerOptionPageSaveActionGlobalAdminThree');


            Route::post('/pixelActionGlobalAdminThree', 'GlobalControllerAdminThree@pixelActionGlobalAdminThree')
                ->name('pixelActionGlobalAdminThree');


            Route::post('/resetCtaMessageActionGlobalAdminThree', 'GlobalControllerAdminThree@resetCtaMessageActionGlobalAdminThree')
                ->name('resetCtaMessageActionGlobalAdminThree');

            Route::post('/resetCtaDescriptionActionGlobalAdminThree', 'GlobalControllerAdminThree@resetCtaDescriptionActionGlobalAdminThree')
                ->name('resetCtaDescriptionActionGlobalAdminThree');


            //**************** START AdminThree DESIGN GLOBAL Routes **************//

            Route::post('/updateGlobalCustomizedColorAdminThree', 'GlobalDesignControllerAdminThree@setCustomizedBackgroundColor')
                ->name('updateGlobalCustomizedColorAdminThree');

            Route::post('/updateGlobalBackgroundColorAdminThree', 'GlobalDesignControllerAdminThree@updateglobalbackgroundcolor')
                ->name('updateGlobalBackgroundColorAdminThree');

            Route::post('/setAutoPulledLogoColorAdminThree', 'GlobalDesignControllerAdminThree@setAutoPulledLogoColorAdminThree')
                ->name('setAutoPulledLogoColorAdminThree');

            Route::post('/updateGlobalBackgroundImageAdminThree', 'GlobalDesignControllerAdminThree@updateglobalbackgroundimage')
                ->name('updateGlobalBackgroundImageAdminThree');


            // Logo Routes
            Route::post('/uploadGlobalLogoAdminThree', 'GlobalDesignControllerAdminThree@uploadgloballogo')
                ->name('uploadGlobalLogoAdminThree');


            /*Route::post('/backgroundGlobalOptionsToggleAdminThree', 'GlobalDesignControllerAdminThree@backgroundoptionstoggle')
                ->name('backgroundGlobalOptionsToggleAdminThree');*/

            Route::post('/deleteGlobalLogoAdminThree', 'GlobalDesignControllerAdminThree@deletelogoglobal')
                ->name('deleteGlobalLogoAdminThree');

            Route::post('/changeLpLogoGlobalAdminThree', 'GlobalDesignControllerAdminThree@changelplogo')
                ->name('changeLpLogoGlobalAdminThree');


            // Feature Image Routes
            Route::post('/uploadGlobalImageAdminThree', 'GlobalDesignControllerAdminThree@uploadglobalimage')->name('uploadGlobalImageAdminThree');
            Route::post('/reset-featured-image', 'GlobalDesignControllerAdminThree@activetodefaultimageglobal')->name('activeToDefaultImageGlobalAdminThree');


            /*Route::post('/deactivateFeatureImageGlobalAdminThree', 'GlobalDesignControllerAdminThree@changetodefaultimageAction')
                ->name('deactivateFeatureImageGlobalAdminThree');*/

            //**************** END AdminThree DESIGN GLOBAL Routes **************//


            Route::post('/updateAdaAccessibilityGlobalAdminThree', 'GlobalControllerAdminThree@updateAdaAccessibility')
                ->name('updateAdaAccessibilityGlobalAdminThree');

            //**************** AdminThree LeadAlerts GLOBAL Routes **************//

            Route::post('/saveNewRecipientGlobalAdminThree', 'AccountController@saveNewRecipientGlobalAdminThree')
                ->name('saveNewRecipientGlobalAdminThree');

            Route::post('/deleteRecipientGlobalAdminThree', 'AccountController@deleteRecipientGlobalAdminThree')
                ->name('deleteRecipientGlobalAdminThree');



            //**************** AdminThree Tag GLOBAL Routes **************//

            Route::post('/saveFunnelTagGlobal', 'GlobalControllerAdminThree@saveFunnelTagGlobal')->name('saveFunnelTagGlobal');


        });

        /**
         * Stats Route
         */

        Route::group(['prefix' => 'stats'], function () {
            Route::post('/index', 'StatsController@index')->name('Stats');
            Route::post('/blockipaddresslist', 'StatsController@blockipaddresslist')->name('blockipaddresslist');
            Route::post('/blockipaddresslist/v3', 'StatsController@blockipaddresslist_v3')->name('blockipaddresslist');
            Route::post('/blockipaddress', 'StatsController@blockipaddress')->name('blockipaddress');
            Route::post('/deleteblockipaddress', 'StatsController@deleteblockipaddress')->name('deleteblockipaddress');
            Route::post('/savegoogleanalytics', 'StatsController@savegoogleanalytics')->name('savegoogleanalytics');
            Route::post('/deletegoogleanalytics', 'StatsController@deletegoogleanalytics')->name('deletegoogleanalytics');
            Route::get('/updatestatsprocess/{id}', 'StatsController@updatestatsprocess')->name('updatestatsprocess');
        });

        Route::group(['prefix' => 'export'], function () {
            Route::any('/exportsworddata', 'ExportController@exportsworddata')->name('exportsworddata');
            Route::any('/exportsexcelddata', 'ExportController@exportsexcelddata')->name('exportsexcelddata');
            Route::any('/exportspdfdata', 'ExportController@exportspdfdata')->name('exportspdfdata');
            Route::post('/myleadsemail', 'ExportController@myleadsemail')->name('myleadsemail');
            Route::post('/myleadpopemail', 'ExportController@myleadsemail')->name('myleadsemail');
            Route::post('/exportleadsemaildata/{hash}', 'ExportController@exportleadsemaildata')->name('exportleadsemaildata');
            Route::post('/myleadsprint', 'ExportController@myleadsprint')->name('myleadsprint');
            Route::post('/myleadpopprint', 'ExportController@myleadpopprint')->name('myleadpopprint');
        });

        Route::group(['prefix' => 'survey'], function () {
            Route::post('/setsurveysession', 'SurveyController@setsurveysession')->name('setsurveysession');
            Route::post('/index', 'SurveyController@index')->name('submitsurvey');
        });

        Route::group(['prefix' => 'tag'], function () {
            Route::get('/{hash}', 'TagController@index')->name('tag');
            Route::post('/addfolder', 'TagController@addfolder')->name('addfolder');
            Route::post('/savesorting', 'TagController@savesorting')->name('savesorting');
            Route::post('/addtag', 'TagController@addtag')->name('addtag');
            Route::post('/savefunneltag', 'TagController@savefunneltag')->name('savefunneltag');
            Route::post('/delete', 'TagController@delete')->name('delete');
        });

        Route::group(['prefix' => 'promote'], function () {
            Route::get('/share/{hash}', 'PromotionController@shareFunnel')->name('shareFunnel');
            Route::post('/upload/{hash}', 'PromotionController@uploadSocialShareImage')->name('uploadSocialImage');
            Route::delete('/image', 'PromotionController@deleteSocialShareImage');
        });

        Route::group(['prefix' => 'url-shortener'], function () {
            Route::post('/createShortenUrl', 'ShortenUrlController@createShortenUrl')->name('createShortenUrl');
            Route::post('/removeShortenUrl', 'ShortenUrlController@removeShortenUrl')->name('removeShortenUrl');
            Route::post('/editShortenUrl', 'ShortenUrlController@editShortenUrl')->name('editShortenUrl');
        });

        //Conditional Logic routes

        Route::group(['prefix' => 'cl'],function(){
            Route::post('/save-conditional-logic', 'FunnelController@saveConditionalLogic')->name('saveconditionlogic');
            Route::post('/save-after-delete', 'FunnelController@saveAfterDelete')->name('save.after.delete');

        });

        //funnel builder routes
        Route::group(['prefix' => 'funnel-builder'],function (){
            Route::get('/', 'FunnelController@index')->name('funnel-builder');
            Route::post('/create-funnel', 'FunnelController@createFunnel')->name('create-funnel');
            Route::post('/update-funnel-name', 'FunnelController@updateFunnelName')->name('update-funnel-name');
            Route::post('/reset-default-provided-questions', 'FunnelController@resetToDefaultProvidedQuestions')->name('reset-default-provided-questions');
        });

        //leadpops branding routes
        Route::group(['prefix' => 'branding'], function () {
            Route::get('/{hash}', 'LeadpopBrandingController@index')->name('branding');
            Route::post('upload-image/{hash}', 'LeadpopBrandingController@uploadImage')->name('upload-image');
            Route::post('store', 'LeadpopBrandingController@store')->name('store');
            Route::post('branding-global-setting', 'LeadpopBrandingController@brandingGlobalSetting')->name('branding-global-setting');
            Route::post('/update-plan', 'LeadpopBrandingController@update')->name('update-plan');
        });
    });


    Route::get('/accountpause', 'IndexController@accountpause');
    Route::get('/logout', 'LoginController@logout')->name('logout');
    Route::get('/load-top-header-funnel', 'IndexController@loadFunnel');
});

Route::group(['prefix' => 'api'], function () {
    Route::any('/homebot.php', 'HomebotController@actionCall');
});

Route::post('/addfunnelprocess.php', 'ProcessController@addfunnelprocess')->name('addfunnelprocess');
Route::post('/addfunnelprocess_mvp.php', 'ProcessController@addfunnelprocess')->name('addfunnelprocess2');
Route::post('/addfunnelprocess_fairway.php', 'ProcessController@addfunnelprocess_fairway')->name('addfunnelprocess_fairway');
Route::post('/addfunnelprocess_baller.php', 'ProcessController@addfunnelprocess_baller')->name('addfunnelprocess_baller');

Route::post('/clonefunnelprocess_mvp_fix.php', 'ProcessController@clonefunnelprocess_mvp_fix')->name('clonefunnelprocess_mvp_fix');
Route::post('/clonefunnelprocess_insurance_mvp_fix.php', 'ProcessController@clonefunnelprocess_insurance_mvp_fix')->name('website_clonefunnelprocess_insurance');
Route::post('/clonefunnelprocess_mvp_movement_fix.php', 'ProcessController@clonefunnelprocess_mvp_movement_fix')->name('website_clonefunnelprocess_mvp_movement');
Route::post('/clonefunnelprocess_mvp_fairway_fix.php', 'ProcessController@clonefunnelprocess_mvp_fairway_fix')->name('website_clonefunnelprocess_mvp_fairway');     //for both fairway + stearns
Route::post('/clonefunnelprocess_mvp_baller_fix.php', 'ProcessController@clonefunnelprocess_mvp_baller_fix')->name('website_clonefunnelprocess_mvp_baller');
Route::post('/clonefunnelprocess_realestate_mvp_fix.php', 'ProcessController@clonefunnelprocess_realestate_mvp_fix')->name('website_clonefunnelprocess_realestate_mvp');
Route::post('/clonefunnelprocess_mvp_stearns_websites.php', 'ProcessController@clonefunnelprocess_stearns_mvp_fix')->name('website_clonefunnelprocess_stearns_mvp');


Route::post('/add_missing_website_funnel_script.php', 'ProcessController@add_website_funnel_script')->name('add_website_funnel_script');
/**
 *Account lock and account unlock
 */
Route::any('/vurspeks.php', 'IndexController@account_lock')->name('account_lock');
Route::any('/skepsruv.php', 'IndexController@account_unlock')->name('account_unlock');

/**
 * account pause and cancellation
 */
Route::post('/accountpause', 'CancellationProcessController@accountPause');
Route::post('/accountcancellation', 'CancellationProcessController@accountCancellation');
Route::post('/removeaccountcancellation', 'CancellationProcessController@removeAccountCancellation');

