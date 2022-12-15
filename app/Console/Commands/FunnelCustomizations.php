<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * To fix customization code to new design
 * Class FunnelCustomizations
 * @package App\Console\Commands\Temp
 */
class FunnelCustomizations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'funnel-customization:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "[One Time Command] This command will fix funnel customizations for new design";

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $action = "";
    private $customizations_table = "clients_customized_funnels_v3";
    private $cssStyleStartingPosition = 0;
    private $cssStyleEndingPosition = 0;
    private $jsScriptStartingPosition = 0;
    private $jsScriptEndingPosition = 0;
    private $userInputClientIds = null;
    private $activeClients = [
        // Fixed in add style/script functions
        // 1643,3092,3163,5111,6129,7655,8165,8238,8712,8761,8925,10345,10545,10890,11731,
        // Active Clients
        2403,3528,3632,3672,3673,3682,3744,3777,3785,4049,4113,4281,4479,4787,5068,5085,6327,6458,8377,8469,8551,8646,8961,9135,9338,9404,9687,10107,10314,10378,10461,10676,10679,10691,10737,10738,10761,10866,10868,10916,11085,11115,11156,11172,11256,11257,11269,11274,11282,11374,11418,11480,11500,11647,11751,11773,11782,11908,12177,12196,12210,
        // Newly added entries
        1338,2892,2955,2996,3067,6448,6720,7387,8329,11004,11529,11661,11883,11895,12013,12110,12247,12249,12282,12344,12445,12492,12586,
        //Circle styles
         2955,1627,3110,3528,3531,3534,3555,3576,3594,3598,3600,3613,3632,3640,3649,3653,3672,3673,3682,3740,3744,3777,3782,3785,3787,3789,3831,3862,3892,3913,3926,3927,3939,3954,3970,4037,4049,4077,4113,4175,4187,4210,4281,4479,4491,4528,4534,4744,4777,4787,4839,4850,4897,4923,5068,5085,5409,5676,5761,5898,6022,6140,6702,6969,6990,7017,7055,7078,7104,7200,7260,7753,8039,
        // Remaining EHL/EHO logo replacement
        8035,8250,8673,7980,8258,8192,8378,8393,8391,6229,8402,8401,8351,8399,8398,8022,8406,4112,8412,8413,8418,7582,4949,8419,7751,8440,7415,8474,8471,2566,7778,8482,8453,8502,6726,8511,8512,8227,8517,8525,8526,8550,8554,8530,8584,8621,8632,8640,8658,8650,8663,8669,8513,8708,8753,5628,8767,8768,8736,8738,8791,8804,1598,8661,8858,8769,7648,7855,8879,8845,8549,8906,8921,8944,1889,8157,9052,8735,9124,9059,8229,9342,7570,9454,3493,3967,9457,7533,9580,9519,9568,8473,8429,9612,2059,6489,9823,9895,9586,3776,9907,9898,9945,4401,10105,8821,10149,6507,
        //Logo CSS replacement
        1328,8278,8472,9094,9449,4074,8707,7394,11903,
        // Remaining disclaimers
        6854,7702,7850,8508,9757,10103,10679,11534,9127,10068,9772,
        //phone replacement
        7227,9762,10563,11903
        //ignored
        //8245,8246,8253,6114
        //ignored 3rd party OR js/css include + CSS
        //3705,5123,2128,2140,1488,1422
        //funnel not working
        //,12177,6453
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $action_input = $this->ask("What would you like to do? Type action 1 OR 2 to proceed \n 1. Dry run \n 2. Update Data");
            if($action_input == "" || $action_input == null){
                $this->error("                                           ");
                $this->error("   No action from user.                    ");
                $this->error("                                           ");
                exit;
            }

            $this->userInputClientIds = $this->ask("Would you like to execute command for all clients OR specific one? \n - Type 'all' for all clients \n - Enter Client ID for specific client");
            if($this->userInputClientIds == "" || $this->userInputClientIds == null){
                $this->error("                                           ");
                $this->error("   No client selection from user.          ");
                $this->error("                                           ");
                exit;
            }
            else{
                if(strtolower($this->userInputClientIds) != "all"){
                    $this->userInputClientIds = explode(",",$this->userInputClientIds);
                    $this->activeClients = $this->userInputClientIds;
                }
            }

            if(trim($action_input) == "1"){ // Dry Run
                $this->action = "print";
            }
            else if(trim($action_input) == "2"){ // Fix Data
                $this->action = "fix";
            }
            else {
                $this->error("                                           ");
                $this->error("  Invalid user action.                     ");
                $this->error("                                           ");
                exit;
            }

            $this->comment("[FunnelCustomizations] -> footer code\n");
            $this->updateFooterCode();

        } catch (\Exception $e) {
            $this->error("Error:" . $e->getMessage());
        }
    }

    /**
     * This function will update footer JavaScript code, that will work with funnel new design
     */
    private function updateFooterCode(){
        DB::enableQueryLog();
        $this->comment("[FunnelCustomizations] -> header_code, footer_code -> Company Logo\n");
        $this->updateFooterCompanyLogo();

        $this->comment("\n[FunnelCustomizations] -> footer code -> Google Tag event\n");
        $this->updateFooterGoogleTagEventCode();

        $this->comment("\n[FunnelCustomizations] -> header/footer -> styles\n");
        $this->updateHeaderAndFooterStyles();

//        $styles="<style>abc</style>tererereerer";
//        $style = $this->getCssStyle($styles);
//        echo $this->cssStyleStartingPosition . "---" . $this->cssStyleEndingPosition;
//        $updatedStyle = substr_replace($style, ".xyz{}", $this->cssStyleEndingPosition, 0);
//        $styles = str_replace($style, $updatedStyle, $styles);
//        var_dump($styles, $updatedStyle, $style);

        $this->comment("\n[FunnelCustomizations] -> header code -> adding header styles\n");
        $this->addHeaderStyles();

        $this->comment("\n[FunnelCustomizations] -> header code -> adding company logo scripts\n");
        $this->addCompanyLogoScripts();

        $this->comment("\n[FunnelCustomizations] -> adding disclaimer scripts\n");
        $this->addDisclaimerScripts();

        $this->comment("\n[FunnelCustomizations] -> adding phone number scripts\n");
        $this->addPhoneNumbersScripts();
    }

    /**
     * replace classed in header and footer
     */
    private function updateHeaderAndFooterStyles(){
        $customizedFunnels = DB::table($this->customizations_table)
            ->select("id", "header_code", "footer_code")
            ->whereIn("client_id", $this->activeClients) // only updating for active clients
            ->where(function ($query) {
                $query->where('header_code', "like", "%<style%");
                $query->orWhere('footer_code', "like", "%<style%");
            })
            ->where(function ($query) {
                $query->where('header_code', "like", "%.meta_info ul li%");
                $query->orWhere('header_code', "like", "%#poweredbysomeguysincphonetext%");
                $query->orWhere('header_code', "like", "%.micro-logo%");
                $query->orWhere('footer_code', "like", "%.micro-logo%");
                $query->orWhere('header_code', "like", "%#step-1 #getfreeratequotestext%");
                $query->orWhere('header_code', "like", '%#singleton #getfreeinsurancequotestext%');
                $query->orWhere('footer_code', "like", "%#poweredbysomeguysincphonetext%");
            })
            ->orderBy("id", "asc")
            ->get();
//        var_dump(DB::getQueryLog());

        if(count($customizedFunnels) == 0) {
            $this->error("[FunnelCustomizations] styles already updated.\n");
            return false;
        }

        foreach ($customizedFunnels as $customizedFunnel) {
            $headerCode = $customizedFunnel->header_code;
            $footerCode = $customizedFunnel->footer_code;
            $style = $this->getCssStyle($headerCode);
            $footerStyle = $this->getCssStyle($footerCode);
            if($style !== false || $footerStyle !== false) {
                if($style !== false) {
                    //Replacing header styles
                    $updatedStyle = $this->replaceStyles($style);
                    $headerCode = str_replace($style, $updatedStyle, $headerCode);
                    $style = $this->getCssStyle($headerCode, true);
                    if ($style !== false) {
                        $updatedStyle = $this->replaceStyles($style);
                        $headerCode = str_replace($style, $updatedStyle, $headerCode);
                    }
                }else if($footerStyle !== false) {
                    //Replacing footer styles
                    $updatedStyle = $this->replaceStyles($footerStyle);
                    $footerCode = str_replace($footerStyle, $updatedStyle, $footerCode);
                }

                if($this->action == "fix") {
                    DB::table($this->customizations_table)
                        ->where("id", $customizedFunnel->id)
                        ->update([
                            "header_code" => $headerCode,
                            "footer_code" => $footerCode
                        ]);
                    $this->info("[FunnelCustomizations] ID#" . $customizedFunnel->id . " styles are updated.\n");
                } else {
                    $this->info("[DRY RUN] - [FunnelCustomizations] ID#" . $customizedFunnel->id . " styles will be updated.\n");
                }
            }
        }
    }

    private function replaceStyles($style) {
        $updatedStyle = str_replace(".f-img-wrapper .img-container",".home-image-wrap .home-image", $style);
        $updatedStyle = str_replace(".main-header .logo-wrapper, .main-header .meta_info{",".header__info .name, .header__info .email, .header__info .contact-number, .header__info span{", $updatedStyle);
        $updatedStyle = str_replace(".meta_info ul li",".header__info .name, .header__info .email, .header__info .contact-number, .header__info span", $updatedStyle);

        //Company Email
        $updatedStyle = str_replace("#poweredbysomeguysinctext span", ".header__info .email a", $updatedStyle);
        //Company Phone
        //.meta_info #poweredbysomeguysincphonetex

        //Micro logo
        $updatedStyle = str_replace(".micro-logo", ".funnel-micro-logo", $updatedStyle);

        //CTA message
        $updatedStyle = str_replace("#step-1 #getfreeratequotestext", "#getfreeratequotestext", $updatedStyle);
        $updatedStyle = str_replace("#singleton #getfreeinsurancequotestext", "#getfreeinsurancequotestext", $updatedStyle);

        $replacements = [
            ".hide-tab .meta_info #poweredbysomeguysincphonetext{",
            "#poweredbysomeguysincphonetext{",
            "#poweredbysomeguysincphonetext {",
            "#poweredbysomeguysincphonetext > span {",
            "#phone #poweredbysomeguysincphonetext span,"
        ];

        foreach ($replacements as $replacement) {
            $replaceWith = ".header__info .contact-number, .header__info .contact-number a";
            $replaceWith .= strpos($replacement, "{") !== false? "{" : "";
            $replaceWith .= strpos($replacement, ",") !== false? "," : "";
            $updatedStyle = str_replace($replacement, $replaceWith, $updatedStyle);
        }
        //.meta_info #poweredbysomeguysincphonetext>span::after, .meta_info #poweredbysomeguysincphonetext>a::after, .meta_info #phone>span>span::after, .meta_info #phone>span>a::after
        $updatedStyle = str_replace("#poweredbysomeguysincphonetext > span", ".header__info .contact-number, .header__info .contact-number a", $updatedStyle);

        $replacements = [
            ".meta_info #poweredbysomeguysincphonetext>span::after",
            ".meta_info #poweredbysomeguysincphonetext>a::after",
            ".meta_info #poweredbysomeguysincphonetext>span"
        ];

        foreach ($replacements as $replacement) {
            $replaceWith = ".header__info > .contact-number";
            $replaceWith .= strpos($replacement, "span::after") !== false? "" : "::after";
            $firstPos = strpos($updatedStyle, $replacement);
            if($firstPos !== false) {
                $secPos = strpos($updatedStyle, "{", $firstPos);
                if($secPos !== false) {
                    $replacement = substr($updatedStyle, $firstPos, ($secPos - $firstPos));
                    $updatedStyle = str_replace($replacement, $replaceWith, $updatedStyle);
                }
            }
        }

        return $updatedStyle;
    }

    /**
     * updating company logo
     */
    private function updateFooterCompanyLogo(){
        $customizedFunnels = DB::table($this->customizations_table)
            ->select("id", "header_code", "footer_code")
            ->whereIn("client_id", $this->activeClients) // only updating for active clients
            ->whereNotIn("id", [884,912,918,951,956,962]) // ignoring active client funnels those fixed in any other function
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('header_code', "like", "%.show-cell-pop%");
                    $q->orWhere('header_code', "like", "%.equal-housing #housing img%");
                    $q->orWhere('header_code', "like", '%jQuery(".micro-logo")%');
                    $q->orWhere('header_code', "like", "%.logo-wrapper%");
                    $q->orWhere('header_code', "like", "%#main-wrapper .logo img{%");
                    $q->orWhere('header_code', "like", '%jQuery("li.bab-aime-logo img").each%');
                });
                $query->orWhere(function ($q) {
                    $q->where('footer_code', "like", "%.show-cell-pop%");
                    $q->orWhere('footer_code', "like", "%.logo-wrapper%");
                    $q->orWhere('footer_code', "like", "%jQuery('li.housing-logo img')%");
                });
                $query->orWhere(function ($q) {
                    $q->where('footer_code', "like", "%.bab-aime-logo%");
                    $q->where('footer_code', "not like", "%.bab-aime-logo-desktop%");
                });
            })
            ->get();
//        var_dump(DB::getQueryLog());

//        $this->info("[FunnelCustomizations] already updated, exiting.\n" . count($customizedFunnels));exit;
        if(count($customizedFunnels) == 0) {
            $this->error("[FunnelCustomizations] already updated.\n");
            return;
        }
        foreach ($customizedFunnels as $customizedFunnel) {
            //Replacing desktop logo
            $headerCode = str_replace(".hide-cell-pop #housing", ".copyright-logo .logo", $customizedFunnel->header_code);
            $headerCode = str_replace(".hide-cell-pop .housing-logo", ".copyright-logo .logo", $headerCode);
            $footerCode = str_replace(".hide-cell-pop .housing-logo", ".copyright-logo .logo", $customizedFunnel->footer_code);
            $footerCode = str_replace(".hide-cell-pop #housing", ".copyright-logo .logo", $footerCode);

            //Replacing mobile logo
            $headerCode = str_replace(".show-cell-pop #housing", ".logo-list-mobile .logo", $headerCode);
            $headerCode = str_replace(".show-cell-pop .housing-logo", ".logo-list-mobile .logo", $headerCode);
            $headerCode = str_replace(".show-cell-pop   .housing-logo", ".logo-list-mobile .logo", $headerCode);

            $headerCode = str_replace(".equal-housing #housing img", ".copyright-logo .logo img, .logo-list-mobile .logo img", $headerCode);

            //Replacing micro-logo
            $headerCode = str_replace('jQuery(".micro-logo")', 'jQuery(".funnel-micro-logo")', $headerCode);

            $footerCode = str_replace(".show-cell-pop #housing", ".logo-list-mobile .logo", $footerCode);
            $footerCode = str_replace(".show-cell-pop .housing-logo", ".logo-list-mobile .logo", $footerCode);
            $footerCode = str_replace(".show-cell-pop   .housing-logo", ".logo-list-mobile .logo", $footerCode);

            // Replaceing bab-aime-logo styles
            $headerCode = str_replace('jQuery("li.bab-aime-logo img").each', 'jQuery(".logo-list-mobile li.bab-aime-logo img, .bab-aime-logo-desktop li img").each', $headerCode);
            //footer
            $replaceWith = ".bab-aime-logo-desktop, .logo-list-mobile li.bab-aime-logo";
            $footerCode = str_replace(" .bab-aime-logo{", $replaceWith . "{", $footerCode);
            $footerCode = str_replace(".hide-cell-pop .equal-housing li.bab-aime-logo{", $replaceWith . "{", $footerCode);
            $footerCode = str_replace("jQuery('li.housing-logo img')", 'jQuery(".logo-list-mobile li.bab-aime-logo img, .bab-aime-logo-desktop li img")', $footerCode);
            $footerCode = str_replace("jQuery('li.housing-logo ')", 'jQuery("'.$replaceWith.'")', $footerCode);

            //logo replacements
            $replacements = [
                '#main-wrapper .logo img{',
                '#main-wrapper .logo-wrapper .logo',
                "#main-wrapper  .logo-wrapper .logo",
                ".logo-wrapper .logo"
            ];

            foreach ($replacements as $replacement) {
                $replaceWith = ".header__holder .header__logo";
                $replaceWith .= strpos($replacement, "{") !== false? "{" : "";
                $headerCode = str_replace($replacement, $replaceWith, $headerCode);
                $footerCode = str_replace($replacement, $replaceWith, $footerCode);
            }


            $this->updateCustomizedFunnel($customizedFunnel, [
                "header_code" => $headerCode,
                "footer_code" => $footerCode
            ]);
        }
    }

    /**
     * This will fix issue with google conversion tag
     */
    private function updateFooterGoogleTagEventCode(){
        $footerCode = '<script type="text/javascript">
jQuery(document).ready(function(){
    var $field = $(".question[data-field=purchaseprice],.question[data-field=firstmortgagebalance],.question[data-field=currentmortgagebalance]");
    var re = /([\d]+)/g;
    var $field_length = $field.length;
    var avg = 0;
    if($field_length){
        for(var i = 0; i < $field_length; i++){
            var val = $field.find(".current-val").text();
            if(val){
                val = val.replace(/,/g,"");
                var matches = val.match(re);
                if(matches.length >= 2){
                    avg = (parseInt(matches[0]) + parseInt(matches[1])) / 2000;
                    break;
                }else if(matches.length == 1){
                    avg = parseInt(matches[0])/1000;
                    break;
                }
            }
        }
        gtag("event", "conversion", {"send_to": "AW-861534600/ONYECJfEhp0BEIjz55oD",
        "value": avg,
        "currency": "USD"
        });
    }
});
</script>';

        $ids = [55,56,57,58,199,201,202];
        if($this->action == "fix") {
            $updatedRows = DB::table($this->customizations_table)
                ->whereIn("id", $ids)
                ->whereIn("client_id", [5111, 3588])
                ->update([
                    "footer_code" => $footerCode
                ]);
            $this->info("[FunnelCustomizations] " . $updatedRows . " Rows updated, ID's#" . implode(",", $ids) . ".\n");
        } else {
            $this->info("[DRY RUN] - [FunnelCustomizations] " . count($ids) . " Rows will be updated, ID's#" . implode(",", $ids) . ".\n");
        }
    }

    /**
     * return CSS styles chunk
     * @param $code
     * @return false|string
     */
    private function getCssStyle($code, $checkMoreStyles = false){
        try {
            if ($checkMoreStyles) {
                $this->cssStyleStartingPosition = strpos($code, "<style", $this->cssStyleEndingPosition);
                if ($this->cssStyleStartingPosition === false) {
                    return $this->cssStyleStartingPosition;
                }
            } else {
                $this->cssStyleStartingPosition = strpos($code, "<style");
                if ($this->cssStyleStartingPosition === false) {
                    return $this->cssStyleStartingPosition;
                }
            }

            $this->cssStyleEndingPosition = strpos($code, "</style>", $this->cssStyleStartingPosition);
            if ($this->cssStyleEndingPosition === false) {
                $this->info("Not found");
            }

            return substr($code, $this->cssStyleStartingPosition, ($this->cssStyleEndingPosition));
        } catch (\Exception $e) {
            $this->error("Error -> " . $e->getMessage());
        }
    }

    /**
     * return Javascript chunk
     * @param $code
     * @return false|string
     */
    private function getJsScript($code, $checkMoreStyles = false){
        try {
            if ($checkMoreStyles) {
                $this->jsScriptStartingPosition = strpos($code, "<script", $this->jsScriptEndingPosition);
                if ($this->jsScriptStartingPosition === false) {
                    return $this->jsScriptStartingPosition;
                }
            } else {
                $this->jsScriptStartingPosition = strpos($code, "<script");
                if ($this->jsScriptStartingPosition === false) {
                    return $this->jsScriptStartingPosition;
                }
            }

            $this->jsScriptEndingPosition = strpos($code, "</script>", $this->jsScriptStartingPosition);
            if ($this->jsScriptEndingPosition === false) {
                $this->info("script ending tag isn't found -> " . $this->jsScriptStartingPosition . " - " . $this->jsScriptEndingPosition);
            }

            return substr($code, $this->jsScriptStartingPosition, ($this->jsScriptEndingPosition));
        } catch (\Exception $e) {
            $this->error("Error -> " . $e->getMessage());
        }
    }

    /**
     * New Theme styles, added new styles
     */
    private function addHeaderStyles(){
        $this->comment("\n[FunnelCustomizations] -> header code -> adding color styles\n");
        $this->addStylesWithPrimaryColorReplaced();

        $this->comment("\n[FunnelCustomizations] -> header code -> adding next button color styles\n");
        $this->addNextButtonStyles();

        $this->comment("\n[FunnelCustomizations] -> header code -> adding other styles\n");
        $this->addStyles();

        $this->comment("\n[FunnelCustomizations] -> header code -> adding image circle styles\n");
        $this->addFeaturedImageCirleStyles();
    }

    /**
     * adding next button styles
     */
    private function addNextButtonStyles(){
        $mappings = [
            // Header code
             173 => ["primary_color" => "#3aafb9", "hover_color" => "#349da6"],
             180 => ["primary_color" => "#0d68ae", "hover_color" => "#085d9f"],
             920 => ["primary_color" => "#0d68ae", "hover_color" => "#085d9f"],
             921 => ["primary_color" => "#0d68ae", "hover_color" => "#085d9f"],
             922 => ["primary_color" => "#0d68ae", "hover_color" => "#085d9f"],
             923 => ["primary_color" => "#0d68ae", "hover_color" => "#085d9f",],
             940 => ["primary_color" => "#40b93c", "hover_color" => "#288c24"],

            // Footer code
            592 => ["primary_color" => "#66CBFE", "hover_color" => "#48B1E6"],
            593 => ["primary_color" => "#66CBFE", "hover_color" => "#48B1E6"],
            722 => ["primary_color" => "#0c254a", "hover_color" => "#061831"],
            792 => ["primary_color" => "#81d742", "hover_color" => "#587c3e", "btn_quote" => true],
            796 => ["primary_color" => "#000080", "hover_color" => "#000080"], //TODO: Check active, before
            872 => ["primary_color" => "#40b93c", "hover_color" => "#288c24", "btn_quote" => true],
            887 => ["primary_color" => "red", "hover_color" => "red"],
            954 => ["primary_color" => "#40b93c", "hover_color" => "#288c24", "btn_quote" => true],
            970 => ["primary_color" => "#144F91", "hover_color" => "#004063", "btn_quote" => true],
            984 => ["primary_color" => "#218b21", "hover_color" => "#007A39", "btn_quote" => true],
            987 => ["primary_color" => "#6181c0", "hover_color" => "#465f8f"]
        ];
        $customizedFunnels = $this->getCustomizedFunnelsByMappingIds($mappings);
        foreach ($customizedFunnels as $customizedFunnel) {
            $properties = $mappings[$customizedFunnel->id];
            $headerCode = $customizedFunnel->header_code;
            $footerCode = $customizedFunnel->footer_code;
            $headerStyle = $this->getCssStyle($headerCode);
            $headerCssEndingPosition = $this->cssStyleEndingPosition;
            $footerStyle = $this->getCssStyle($footerCode);
            if ($headerStyle !== false || $footerStyle !== false) {
                $newStyles = $this->getButtonReplacedStyles($properties);
                if ($this->isButtonCssAlreadyReplaced($headerCode) || $this->isButtonCssAlreadyReplaced($footerCode)) {
                    $this->error("[FunnelCustomizations] ID#" . $customizedFunnel->id . " code already updated.\n");
                } else {
                    if(strpos($headerCode, "a.submit:hover") !== false) {
                        $headerCode = substr_replace($headerCode, $newStyles, $headerCssEndingPosition, 0);
                    } else {
                        $footerCode = substr_replace($footerCode, $newStyles, $this->cssStyleEndingPosition, 0);
                    }

                    $this->updateCustomizedFunnel($customizedFunnel, [
                        "header_code" => $headerCode,
                        "footer_code" => $footerCode
                    ]);
                }
            }
        }
    }

    /**
     * @param $properties
     */
    private function isButtonCssAlreadyReplaced($code)
    {
        if (strpos($code, "a.submit:hover") !== false && strpos($code, "a.btn-next:hover{") !== false) {
            return true;
        }
        return false;
    }

    /**
     * adding new CSS with primary color replaced
     */
    private function addStylesWithPrimaryColorReplaced(){
        $mappings = [
            //Header styles
            221 => ["primary_color" =>"#ff7e00"], //old -> question color replaced
            892 => ["primary_color" =>"#00a3b2", "progress_color"=>"#00a3b2"],
            935 => ["primary_color" =>"#0acdff", "progress_color"=>"#0acdff"], //old -> question color replaced
            940 => ["primary_color" =>"#40b93c", "progress_color"=>"#40b93c", "btn_quote" => true],
            944 => ["primary_color" =>"#6DA301", "progress_color"=>"#6DA301"], //old -> question color replaced
            947 => ["primary_color" =>"#0091FF", "progress_color"=>"#0091FF"], //old -> question color replaced
            972 => ["primary_color" =>"#000", "progress_color"=>"#000"], //old -> question color replaced

            //Footer styles
            686 => ["primary_color" =>"#3a96ff", "btn_quote" => true],
            697 => ["primary_color" =>"#4976ae", "progress_color" => "#4976ae"]
        ];

        $customizedFunnels = $this->getCustomizedFunnelsByMappingIds($mappings);
        foreach ($customizedFunnels as $customizedFunnel) {
            $properties = $mappings[$customizedFunnel->id];
            $headerCode = $customizedFunnel->header_code;
            $footerCode = $customizedFunnel->footer_code;
            $headerStyle = $this->getCssStyle($headerCode);
            $headerCssEndingPosition = $this->cssStyleEndingPosition;
            $footerStyle = $this->getCssStyle($footerCode);
            if ($headerStyle !== false || $footerStyle !== false) {
                $newStyles = $this->getColorReplaced($properties);

                if ($this->isColorStylesReplaced($headerCode) || $this->isColorStylesReplaced($footerCode)) {
                    $this->error("[FunnelCustomizations] ID#" . $customizedFunnel->id . " code already updated.");
                } else {
                    if(strpos($headerCode, ".btn-mvp") !== false) {
                        $headerCode = substr_replace($headerCode, $newStyles, $headerCssEndingPosition, 0);
                    } else {
                        $footerCode = substr_replace($footerCode, $newStyles, $this->cssStyleEndingPosition, 0);
                    }

                    $this->updateCustomizedFunnel($customizedFunnel, [
                        "header_code" => $headerCode,
                        "footer_code" => $footerCode
                    ]);
                }
            }
        }
    }

    private function isColorStylesReplaced($code) {
        if(strpos($code, ".btn-mvp") !== false && strpos($code, ".question .radio-button{") !== false) {
            return true;
        }
        return false;
    }

    private function getButtonReplacedStyles($properties)
    {
        $primary_color = $properties["primary_color"];
        $hover_color = $primary_color;

        if(isset($properties["hover_color"])) {
            $hover_color = $properties["hover_color"];
        }

        $wrapper = ".home ";
        if(isset($properties["next-btn"])) {
            $wrapper = "";
        }

        $style = $wrapper . "a.btn-next, " . $wrapper . "a.btn-next:hover{
                    color:#fff;
                }
                " . $wrapper . "a.btn-next:hover {
                    background: $hover_color;
                    border-color: $hover_color;
                }
                " . $wrapper . "a.btn-next {
                    background-color: $primary_color;
                    border: 1px solid $hover_color;
                }";

        if(isset($properties["wrap_border_color"])) {
            $input_wrap_color = $properties["wrap_border_color"];
            $style .= "\n" . "/* Textarea Questions*/
                .question_note .note-wrap {
                    border: 1px solid $input_wrap_color;
                }
                .question_note .input-wrap.focused .note-wrap{
                    border-color :$input_wrap_color;
                }";
        }

        if(isset($properties["progress_color"])) {
            $style .= "\n" . $this->getProgressColorReplaced();
        }

        if(isset($properties["btn_quote"])) {
            $style .= $this->addButtonStyleExceptHomeButton($primary_color);
        }

        return $style;
    }

    /**
     * Progress bar color replaced
     * @param $progress_color
     * @return string
     */
    private function getProgressColorReplaced($progress_color) {
        $style = "/* Progress Bar */
            .progress-bar, .progress .value, .progress-wrapper .success-note{ background-color: $progress_color !important; }
            .progress .value:after { border-bottom-color: $progress_color !important; }";
        return $style;
    }

    /**
     * New Theme :: CSS with customized color replaced in styles
     * @param $properties
     * @return string
     */
    private function getColorReplaced($properties){
        $progress_color = null;
        $primary_color = $properties["primary_color"];
        $border_color = $primary_color;

        if(isset($properties["border_color"])) {
            $border_color = $properties["border_color"];
        }

        $style = "";
        if(isset($properties["progress_color"])) {
            $progress_color = $properties["progress_color"];

            $style .= $this->getProgressColorReplaced($progress_color);
        }

        $style .= "\n/* City Zip code question */
        .question_cityzipcode .states-box{
            background: $primary_color;
        }
        .question_cityzipcode .states-box .states:hover, .question_cityzipcode .states-box .states.hover{
            color: $primary_color;
        }

        /* Zip code question colors */
        .question_zipcode .form-control.filled, .question_zipcode .form-control:focus {
            border-color: $border_color;
        }

        /* Radio question colors */
        .question .radio-button{
                background-color: $primary_color;
                border: 1px solid $border_color;
        }
        .question .radio-button.active{
            color: $primary_color;
        }
        .question .radio-button .icon-valid{
            color: $primary_color;
        }

        /* Slider question colors */
        .question .range-slider .current-val{
            color: $primary_color;
        }
        .question .range-slider .slider-selection{
            background-color: $primary_color;

        }
        .question .range-slider .slider-handle{
            background-color: $primary_color;
        }
        .question .range-slider__value{
            color: $primary_color;
        }

        .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
        .mCSB_outside + .mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar,
        .mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, .mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar{
            background-color: $primary_color;
        }
        .mCSB_outside + .mCSB_scrollTools:after, .mCSB_outside + .mCSB_scrollTools:before{
            color: $primary_color !important;
        }

        /* Input Box Questions */
        input[type='text'].filled, input[type='text']:focus, input[type='tel'].filled, input[type='tel']:focus, input[type='email'].filled, input[type='email']:focus, input[type='search'].filled, input[type='search']:focus, input[type='password'].filled, input[type='password']:focus, input[type='url'].filled, input[type='url']:focus, input[type='date'].filled, input[type='date']:focus, textarea.filled, textarea:focus, .form-control.filled, .form-control:focus{
            border-color: $border_color;
        }

        /* Textarea Questions*/

        .question_note .note-wrap {
            border: 1px solid $border_color;
        }
        .question_note .input-wrap.focused .note-wrap{
            border-color :$border_color;
        }

        /* Dropdown Single Select Question */
        .single-select-opener-wrap{
            background : $primary_color;
        }
        .single-select-dropdown{
            background : $primary_color;
        }
        .single-select-list a.selected{
            color: $primary_color;
        }
        .single-select-list a:hover, .single-select-list a.hover{
            color: $primary_color;
        }
        .question_select-question .mCSB_outside + .mCSB_scrollTools .mCSB_draggerRail{
            background-color: #ebebeb;

        }
        .single-select-list a:before{
            color: $primary_color;
        }

        /* Dropdown Multi Select Question */
        .multi-check-list .check-label.hover .fake-label{
            color: $primary_color;
        }
        .multi-check-list .check-label.hover .fake-label:before{
            border-color : $border_color;
        }
        .multi-select-dropdown{
            background : $primary_color;
        }
        .multi-check-list input[type='checkbox']:checked + .fake-label{
            background: #fff;
            color: $primary_color;
        }
        .multi-check-list .fake-label:hover{
            background-color: #fff;
            color: $primary_color;
        }
        .multi-check-list .fake-label:after{
            color: $primary_color;
        }
        .multi-check-list input[type='checkbox']:checked + .fake-label:before{
            border-color: $border_color;
        }
        .multi-select-dropdown .finish-btn{
            color: $primary_color;
        }
        .multi-select-opener-wrap{
            background : $primary_color;
        }
        .multi-select-area__tag .tag-text{
            color: $primary_color;
        }
        .multi-select-area__tag .tag-text .cancel{
            color: $primary_color;
        }
        .question_birthday .birthday .select2-container--default .select2-selection--single{
            background-color: $primary_color;
        }
        .question_birthday .birthday .select2-container--open .month-dropdown .select2-results{
            background-color: $primary_color;
        }
        .question_birthday .birthday .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{
            background-color: #fff;
            color: $primary_color;
        }
        .question_birthday .birthday .select2-container--default .select2-results__option--selected{
            color: $primary_color;
        }
        .question_birthday .birthday .select2-container--default .select2-results__option--selected:after{
            color:$primary_color;
        }
        .question_birthday .birthday .select2-container--open .month-dropdown .select2-results:before{
            background-color: $primary_color;
            border-bottom: 1px solid #ffffff;
        }
        .question_birthday .birthday .select2-container--open .month-dropdown{
            background-color: $primary_color;
        }


        .question_birthday .birthday .select2-container--open .day-dropdown .select2-results{
            background-color: $primary_color;
        }
        .question_birthday .birthday .select2-container--open .day-dropdown .select2-results{
            background-color: $primary_color;
        }
        .question_birthday .birthday .select2-container--open .day-dropdown .select2-results:before{
            background-color: $primary_color;
            border-bottom: 1px solid #ffffff;
        }
        .question_birthday .birthday .select2-container--open .day-dropdown{
            background-color: $primary_color;
        }


        .question_birthday .birthday .select2-container--open .year-dropdown .select2-results{
            background-color: $primary_color;
        }
        .question_birthday .birthday .select2-container--open .year-dropdown .select2-results{
            background-color: $primary_color;
        }
        .question_birthday .birthday .select2-container--open .year-dropdown .select2-results:before{
            background-color: $primary_color;
        }
        .question_birthday .birthday .select2-container--open .year-dropdown{
            background-color: $primary_color;
        }


        /* Checkbox Question */
        .question .checkbox-button{
            background-color: $primary_color;
            border: 1px solid $border_color;
        }
        .question .checkbox-button.active{
            color: $primary_color;
        }
        .question .checkbox-button.active .fake-input{
            border-color: $border_color;
        }

        /* Menu Quetion*/
        .question .checkbox-button.focus .fake-input{
            border-color: $border_color;
        }
        .question .checkbox-button.focus{
            color: $primary_color;
        }
        .question .radio-button.focus{
            color: $primary_color;
        }

        /* Back Button */

        .btn-back .icon {
            color: $primary_color !important;
        }
        @media (min-width: 768px){
            .btn-back .icon {
                color: $primary_color !important;
            }
        }";

        if(isset($properties["btn_quote"])) {
            $style .= $this->addButtonStyleExceptHomeButton($primary_color);
        }

        return $style;
    }

    /**
     * apply styles on button except home button
     * @param $primary_color
     * @return string
     */
    private function addButtonStyleExceptHomeButton($primary_color){
        return "\n/*Button style except home button */
        .question:not(.home) a.btn-next{
            color:#fff,
            background-color: $primary_color;
            border: 1px solid $primary_color;
        }";
    }

    /**
     * adding company phine script
     */
    private function addCompanyPhoneScript(){
        $mappings = [
            //Header
            868 => [
                "phone_number" => "1-(888) 406-4252"
            ]
        ];

        $customizedFunnels = $this->getCustomizedFunnelsByMappingIds($mappings);
        foreach ($customizedFunnels as $customizedFunnel) {
            $headerCode = $customizedFunnel->header_code;
            $script = $this->getJsScript($headerCode);


            $this->updateCustomizedFunnel($customizedFunnel, [
                "header_code" => $headerCode
            ]);
        }
    }

    private function addPhoneScript($properties) {
        $script = '
        /*Phone number replacement -> desktop view */
        jQuery(".header__info .contact-number a").attr("href", "tel: ' . $properties["phone_number"] . '");
        jQuery(".header__info .contact-number a").html("' . $properties["phone_number"] . '");

        /*Phone number replacement -> Mobile view */
        jQuery(".header__info .cta-btn a").attr("href", "tel: ' . $properties["phone_number"] . '");
        jQuery(".header__info .cta-btn a").html("' . $properties["phone_number"] . '");';
        return $script;
    }


    /**
     * Adding footer company script for customizations
     */
    private function addCompanyLogoScripts(){
        $mappings = [
            //Header
            902 => ["company_logo" => "https://images.lp-images1.com/default/images/EHO.jpg"],
            912 => [
                "company_extra_logos" => [
                    [
                        "company_logo" => '<li class="logo"><img src="https://images.lp-images1.com/images1/1/11172/pics/11172_165_2_3_76_82_82_1_1616577024_memberfdiclogo.png" alt=""></li>',
                        "mobile_logo" => '<li class="logo"><img src="https://images.lp-images1.com/images1/1/11172/pics/11172_165_2_3_76_82_82_1_1616577024_memberfdiclogo.png" alt=""></li>'
                    ]
                ],
            ],
            // BAB logos
            884 => [
                "bab_aime_extra_logos" => [
                    "desktop_logo" => '<li><img alt="CAMP LOGO" src="https://images.lp-images1.com/images1/1/10679/pics/10679_163_2_3_75_81_81_1_1614066676_campimage.png"></li>'.
                        '<li><a href="https://www.bbb.org/us/ca/ladera-ranch/profile/mortgage-broker/the-mortgage-advisory-1126-172016171" target="_blank" ><img alt="BBB LOGO" src="https://images.lp-images1.com/images1/1/10679/pics/10679_163_2_3_75_81_81_1_1614066710_externalcontent.png"></a></li>',
                    "mobile_logo" => '<li class="bab-aime-logo"><img alt="CAMP LOGO" src="https://images.lp-images1.com/images1/1/10679/pics/10679_163_2_3_75_81_81_1_1614066676_campimage.png"></li><li class="bab-aime-logo">' .
                        '<a href="https://www.bbb.org/us/ca/ladera-ranch/profile/mortgage-broker/the-mortgage-advisory-1126-172016171" target="_blank" ><img alt="BBB LOGO" src="https://images.lp-images1.com/images1/1/10679/pics/10679_163_2_3_75_81_81_1_1614066710_externalcontent.png"></a></li>',
                ],
                "remove_style" => true
            ],
            951 => [
                "bab_aime_extra_logos" => [
                    "desktop_logo" => '<li class="bab-aime-logo"> <img alt="BBA Rating logo" src="https://images.lp-images1.com/images1/1/10461/pics/10461_196_1_3_92_98_98_1_1622116879_bbaratingneedstomatchotherlogoscolor.png"></li>' .
                        '<li class="bab-aime-logo"><img alt="FDIC logo" style="margin-right:20px" src="https://images.lp-images1.com/images1/1/10461/pics/10461_196_1_3_92_98_98_1_1622116888_footerfdic.png"></li>',
                    "mobile_logo" => '<li class="bab-aime-logo"> <img alt="BBA Rating logo" src="https://images.lp-images1.com/images1/1/10461/pics/10461_196_1_3_92_98_98_1_1622116879_bbaratingneedstomatchotherlogoscolor.png"></li>' .
                        '<li class="bab-aime-logo"><img alt="FDIC logo" style="margin-right:20px" src="https://images.lp-images1.com/images1/1/10461/pics/10461_196_1_3_92_98_98_1_1622116888_footerfdic.png"></li>',
                    "jquery_mobile_method" => "after",
                    "jquery_mobile_el" => ".logo",
                ]
            ],
            956 => [
                "bab_aime_extra_logos" => [
                    "desktop_logo" => '<li class="vettedva"><img alt="VettedVA" src="https://images.lp-images1.com/images1/1/11782/pics/11782_210_1_5_99_105_105_1_1623654243_webvettedvamainlogo1.png"></li>',
                    "mobile_logo" => '<li class="bab-aime-logo white-vettedva"><img alt="VettedVA" src="https://images.lp-images1.com/images1/1/11782/pics/11782_210_1_5_99_105_105_1_1623654243_webvettedvamainlogo1.png"></li>',
                ]
            ],
            962 => [
                "bab_aime_extra_logos" => [
                    "desktop_logo" => '<li class="bab-aime-logo zillow"><img alt="Zillow Lender" src="https://images.lp-images1.com/images1/1/12177/pics/12177_162_1_3_75_81_81_1_1624613211_image.png"></li>',
                    "mobile_logo" => '<li class="bab-aime-logo zillow"><img alt="Zillow Lender" src="https://images.lp-images1.com/images1/1/12177/pics/12177_162_1_3_75_81_81_1_1624613211_image.png"></li>'
                ]
            ],
            967 => [
                "bab_aime_extra_logos" => [
                    "desktop_logo" => '<li class="bab-aime-logo" style="height: 50px !important;margin-right: 10px;"> <img alt="Vetted VA logo" src="https://images.lp-images1.com/images1/1/11895/pics/11895_182_1_3_85_91_91_1_1625720416_vettedvalogo.png"></li>',
                    "mobile_logo" => '<li class="bab-aime-logo" style="height: 50px !important;margin-right: 10px;"> <img alt="Vetted VA logo" src="https://images.lp-images1.com/images1/1/11895/pics/11895_182_1_3_85_91_91_1_1625720416_vettedvalogo.png"></li>'
                ]
            ]
        ];

        $customizedFunnels = $this->getCustomizedFunnelsByMappingIds($mappings);
        foreach ($customizedFunnels as $customizedFunnel) {
            $headerCode = $customizedFunnel->header_code;
            $footerCode = $customizedFunnel->footer_code;
            $headerScript = $this->getJsScript($headerCode);
            $headerJsEndingPosition = $this->jsScriptEndingPosition;
            $footerScript = $this->getJsScript($footerCode);

            if($headerScript !== false || $footerScript !== false) {
                if($this->isCompanyLogoScriptAdded($headerScript) || $this->isCompanyLogoScriptAdded($footerScript)) {
                    $this->error("[FunnelCustomizations] ID#" . $customizedFunnel->id . " header/footer code already updated.\n");
                } else {
                    $properties = $mappings[$customizedFunnel->id];
                    $newScript = $this->addCompanyLogoScript($properties);
                    if (strpos($headerScript, ".equal-housing") !== false || strpos($headerScript, "bab-aime-logo") !== false) {
                        $headerCode = substr_replace($headerCode, $newScript, $headerJsEndingPosition, 0);
                    } else {
                        $footerCode = substr_replace($footerCode, $newScript, $this->jsScriptEndingPosition, 0);
                    }
                    // removing styles
                    if(isset($properties["remove_style"])) {
                        $headerCode = $this->removeStyles($headerCode, $properties["remove_style"]);
                    }

                    $this->updateCustomizedFunnel($customizedFunnel, [
                        "header_code" => $headerCode,
                        "footer_code" => $footerCode
                    ]);
                }
            }
        }
    }

    /**
     * checking if replaced in header OR footer
     */
    private function isCompanyLogoScriptAdded($code) {
        if(strpos($code, ".equal-housing") !== false && strpos($code, ".copyright-logo .logo") !== false) {
             return true;
        }

        if(strpos($code, "bab-aime-logo") !== false && strpos($code, ".bab-aime-logo-desktop") !== false) {
            return true;
        }

        return false;
    }

    /**
     * adding footer company logo customization code
     */
    private function addCompanyLogoScript($properties){
        $script = "jQuery(document).ready(function (){";

        if(isset($properties["company_logo"])) {
            $script .= '
            /*Company Logo -> desktop view */
        jQuery(".copyright-logo .logo img").attr("src", "' . $properties["company_logo"] . '");

        /*Company Logo -> Mobile view */
        jQuery(".logo-list-mobile .logo img").attr("src", "' . $properties["company_logo"] . '");';
        }

        if(isset($properties["company_extra_logos"])) {
            foreach ($properties["company_extra_logos"] as $extraLogos) {
                $script .= '
                /*Company Logo -> desktop view */
                jQuery(".copyright-logo .logo").after(\'' . $extraLogos["company_logo"] . '\');';

                if(isset($extraLogos["mobile_logo"])) {
                    $script .= '
                    /*Company Logo -> Mobile view */
                    jQuery(".logo-list-mobile .logo").after(\'' . $extraLogos["mobile_logo"] . '\');';
                }
            }
        }

        if(isset($properties["bab_aime_extra_logos"])) {
            $script .= '
            /* Extra BAB Logo -> desktop view */
            jQuery(".bab-aime-logo-desktop").prepend(\'' . $properties["bab_aime_extra_logos"]["desktop_logo"] . '\');';

            if(isset($properties["bab_aime_extra_logos"]["mobile_logo"])) {
                $el = ".logo-list-mobile ";
                $iquery_method = isset($properties["bab_aime_extra_logos"]["jquery_mobile_method"]) ? $properties["bab_aime_extra_logos"]["jquery_mobile_method"] : "before";
                $el .= isset($properties["bab_aime_extra_logos"]["jquery_mobile_el"]) ? $properties["bab_aime_extra_logos"]["jquery_mobile_el"] : ".bab-aime-logo";
                $script .= '
                /* Extra BAB Logo -> Mobile view */
                jQuery("' . $el . '").' . $iquery_method . '(\'' . $properties["bab_aime_extra_logos"]["mobile_logo"] . '\');';
            }
        }

        $script .= "});";
        return $script;
    }


    /**
     * Adding contact disclaimer
     */
    private function addDisclaimerScripts(){
        $mappings = [
            // Header
            908 => [
                "disclaimer_text" => "By clicking the button below, you are providing prior express \"written\" consent for Preferred Rate as well as its real estate agent and broker partners to contact you occasionally by telephone (including by automated dialing systems, text, artificial voice or pre-recorded messages), mobile device (including SMS and MMS), and/or email, even if you are on a corporate, state, or national Do Not Call list. Consent is not required in order to purchase goods and services from Preferred Rate or its real estate agent and broker partners. You also agree to our Terms of Use and Privacy Policy.",
                "email-box" => true ],
            988 => [
                "disclaimer_text" => 'By submitting an inquiry, you agree that a licensed mortgage broker or lender with Choice Home Mortgage may contact you by phone, text message or email. You expressly consent to receive phone calls (including autodialed and/or pre-recorded calls) text messages and email using automated technology at the phone number and email address you provided, even if it is a wireless number, regardless of whether you are on any Federal or state DNC (Do Not Call) and/or DNE (Do Not Email) list or registry. In addition, you understand and acknowledge that data and message rates may apply. Furthermore, you acknowledge that you are over 18 years of age. You may revoke your express consent at any time by contacting us via <a style="font-weight: bold;" href="tel:(888) 256-1135">(888) 256-1135</a> or email at <a style="font-weight: bold;" href="mailto:info@choicehm.com">info@choicehm.com</a>'],
            942 => [
                "footer_disclaimer" => 'By submitting, I am authorizing AnnieMac Home Mortgage to deliver telemarketing calls and text messages to my cell phone using an auto-dialer, text message, or a prerecorded message. I also understand that I am not required to provide this authorization as a condition to doing business with AnnieMac Home Mortgage. Standard text message calling rates will apply.'],
            826 => [
                "footer_disclaimer" => '<p style="font-weight: 700;font-family:Open Sans,sans-serif;">For information purposes only. This is not a commitment to lend or extend credit. Information and/or dates are subject to change without notice. All loans are subject to credit approval. By refinancing your existing loan, your total finance charges may be higher over the life of the loan. By filling out our website forms, calling, or otherwise proceeding, you consent to receive calls and texts (including through automated means: e.g. autodialing, text and pre-recorded messaging and artificial voice) via telephone and mobile device (including SMS/MMS - msg/data rates/charges may apply) at the number you provide, and/or email, from LendV LLC, authorized third parties, and others about your inquiry, but not as a condition of any purchase and/or use of our services. You may choose to use our services by calling (855) 898-2411. This consent applies even if you are on any internal, corporate, state, federal, or national Do Not Call (DNC) list. You also agree to our Privacy Policy regarding the information relating to you. Please note: LendV LLC is licensed in the following states: Washington. If your property is located outside of Washington then we apologize that we are unable to assist with any financing at this time. LendV LLC, 19251 Indian Creek Ave., Lake Oswego, OR 97035 | (855) 898-2411 | Washington MB-2000088 | NMLS #2000088 | Equal Housing Opportunity.</p>'],
            845 => [
                "footer_disclaimer" => 'By submitting your contact information, you consent to be contacted. <br> See <a href="https://www.primeres.com/tcpa-disclaimer" target="_blank">TCPA Disclaimer</a>',
                "jquery_method" => "before"],
            951 => [
                "footer_disclaimer" => '<p class="bottomlinksmodal bottomlinksmodal--color">By sharing your contact information, you express consent to Retirement Equity Solutions or Magnolia Bank to contact you about your inquiry at the phone number and/or email address you provide using a manual or automated system. You are not required to enter into this agreement as a condition for doing any kind of business with Retirement Equity Solutions or Magnolia Bank, and you can revoke this consent any time. To speak with someone at Magnolia Bank, please call&nbsp;<a href="tel:1-877-765-2234">1-877-765-2234</a></p>'],
            963 => [
                "footer_disclaimer" => 'By filling out our website forms, submitting, or otherwise proceeding, you consent to receive calls and texts (including through automated means: e.g. autodialing, text and pre-recorded messaging and artificial voice) via telephone and mobile device (including SMS/MMS - msg/data rates/charges may apply) at the number you provide, and/or email, from Best Rate, and or our authorized third parties about your&nbsp;inquiry.'],
            971 => [
                "footer_disclaimer" => '<p>By clicking "Submit" I agree by electronic signature to: (1) be contacted by CapitalBull, LLC. about obtaining a mortgage loan, or credit repair or credit repair marketing by a live agent, artificial or prerecorded voice, and SMS text at my residential or cellular number, dialed manually or by auto-dialer, and by email (consent to be contacted is not a condition to purchase services); and (2) the <a style="color: #333333; text-decoration: underline;" href="https://capitalbull.com/privacy-policy" target="_blank">Privacy Policy</a>.</p>'],
            980 => [
                "footer_disclaimer" => 'By clicking "Submit" on any forms or funnels, I agree by electronic signature to: (1) be contacted by PRMG inc?s team about obtaining a mortgage loan, or credit repair or credit repair marketing by a live agent, artificial or prerecorded voice, and SMS text at my residential or cellular number, dialed manually or by auto-dialer, and by email (consent to be contacted is not a condition to purchase services); and (2) the Privacy Policy.'],
            983 => [
                "footer_disclaimer" => '<p class="bottomlinksmodal bottomlinksmodal--color">Copyright © 2021. Homestar Financial Corporation 332 Washington St. NW, Gainesville, GA 30501. NMLS #70864. For licensing info: NMLSconsumeraccess.org. This is not a commitment to lend and not all customers will qualify. All terms, information, conditions, rates, and programs are subject to credit and property approval and may change without notice. Not all products are available in all states. Certain other restrictions may apply. Homestar Financial Corporation is an equal housing lender and is not affiliated with any government&nbsp;entity.</p>'],
            992 => [
                "footer_disclaimer" => '<p class="bottomlinksmodal bottomlinksmodal--color">© 2021 HomePlus Corporation dba HomePlus Mortgage, NMLS&nbsp;#78669 <br/> <a href="http://www.nmlsconsumeraccess.org/EntityDetails.aspx/COMPANY/78669" target="_blank" rel="noopener">www.nmlsconsumeraccess.org</a> | <a href="https://homeplusmortgage.com/legal/" target="_blank">Legal: State and Federal Disclosures and Licenses</a> | <a href="https://homeplusmortgage.com/privacy-policy/" target="_blank">Privacy Policy</a></p><p style="text-transform: uppercase; font-weight: 600; margin-bottom: 2px;">HomePlus Corporation is an Equal Housing Lender</p>'],
            993 => [
                "footer_disclaimer" => '<p class="bottomlinksmodal bottomlinksmodal--color">© 2021 HomePlus Corporation dba HomePlus Mortgage, NMLS&nbsp;#78669 <br/> <a href="http://www.nmlsconsumeraccess.org/EntityDetails.aspx/COMPANY/78669" target="_blank" rel="noopener">www.nmlsconsumeraccess.org</a> | <a href="https://homeplusmortgage.com/legal/" target="_blank">Legal: State and Federal Disclosures and Licenses</a> | <a href="https://homeplusmortgage.com/privacy-policy/" target="_blank">Privacy Policy</a></p><p style="text-transform: uppercase; font-weight: 600; margin-bottom: 2px;">HomePlus Corporation is an Equal Housing Lender</p>'],
            995 => [
                "footer_disclaimer" => '<p class="bottomlinksmodal bottomlinksmodal--color">Ladera Lending, Inc. does not currently offer Reverse Mortgages in the state of NC</p>',
                "jquery_method" => "before"
            ],


            // Footer
            651 => [
                "disclaimer_text" => "By clicking \'Submit\' you agree to the <a href=\"http://w-wagoner-7850.leadpops.com/legal/\" target=\"_blank\">Terms of Use</a> and <a target=\"_blank\" href=\"http://w-wagoner-7850.leadpops.com/legal/\">Privacy Policy</a> consent (not required as a condition to purchase a good/service) to Global Equity Finance, Inc. contacting you via telephone, mobile device (including SMS and MMS) and/or email even if you are on a corporate, state or national Do Not Call Registry.  As an alternative, you may contact us at 800-245-3279."],
            745 => [
                "disclaimer_text" => '<p class="bottomlinksmodal bottomlinksmodal--color">NOTICE: This is not a commitment to lend or extend credit. We arrange loans, we do not lend. Information and/or data is subject to change without notice. All loans are subject to credit approval. Homestead Mortgage, LLC | MA &amp; CT Broker License #: MB1534</p>'],
            764 => [
                "disclaimer_text" => "We take your privacy seriously. By clicking the button above, You agree that we can share your personal data with third parties, such as our mortgage partners, service providers and other affiliates, and that we can use this data for marketing and analytics, and to make your experience easier. you are also providing your express written consent to have your information shared and to be contacted through their authorized third party, to call you at the number you have provided including through automated means such as autodialing, text SMS/MMS (charges may apply), and prerecorded messaging, and/or via email, even if your telephone number is a cellular phone number or on a corporate, state, or the National Do Not Call Registry."],
            818 => [
                "disclaimer_text" => "By clicking \"Submit\" you agree to our Terms and Conditions and our Privacy Policy. You also consent to be contacted, including via automated technology, at the phone number entered above for marketing purposes and about your inquiry. You affirm that you are the subscriber of the phone number(s) or that the subscriber has authorized you to provide this consent. Your consent is not a condition of purchase of goods or services from Filo Mortgage, L.L.C."],
            846 => [
                "disclaimer_text" => "By clicking the button above, you provide written consent to First Federal Bank and its affiliates contacting you. You are providing your express “written” consent to be contacted by or on behalf of First Federal Bank at any of the telephone number(s) provided using an automatic telephone dialing system or an artificial/prerecorded voice or via text/SMS message, and even if the telephone number(s) provided is on a federal, state or internal do-not-call registry. First Federal Bank may also contact you via email using any email address you have provided. You are not required to provide this consent as a condition of applying for a mortgage with us. As an alternative, you may contact us directly at 1-800-519-5677 to complete your request. You understand that you may revoke this consent at any time. You can unsubscribe from these communications at any time. For more information on how to unsubscribe, our privacy practices, and how we are committed to protecting and respecting your privacy, please review our Privacy&nbsp;Policy.<br>Also, by submitting your information, you agree to receive other communications from First Federal Bank and/ or its&nbsp;divisions."],
            849 => [
                "footer_disclaimer" => '<p>By clicking "Submit" I agree by electronic signature to: (1) be contacted by Mark 1 Mortgage about obtaining a mortgage loan, or credit repair or credit repair marketing by a live agent, artificial or prerecorded voice, and SMS text at my residential or cellular number, dialed manually or by auto-dialer, and by email (consent to be contacted is not a condition to purchase services); and (2) the Privacy Policy - **you can link the privacy policy on their website for this on the funnels. **</p>'],
            871 => [
                "disclaimer_text" => "By clicking 'Get My Quote', you agree to our Terms and Conditions below.<br><br>I authorize Impac Mortgage Corp. dba CashCall Mortgage, and its corporate parent, affiliates and partners to deliver or cause to be delivered to you (including through agents and authorized third-parties) telemarketing promotions for products or services in addition to those about which you are applying, but that may be of interest to you using an automatic telephone dialing system or an artificial or prerecorded voice and text messages to the phone numbers you provided above. You are not required to sign this agreement as a condition of purchasing any property, goods, or services."],
            877 => [
                "footer_disclaimer" => "By clicking \"Submit\" I agree by electronic signature to: (1) be contacted by  <a href=\"http://gofastlender.com/\" target=\"_blank\">GoFastLender.com</a> about obtaining a mortgage loan by a live agent, or prerecorded voice, and SMS text at my residential or cellular number, dialed manually or by auto-dialer, and by email (consent to be contacted is not a condition to purchase services); and (2) the Privacy Policy and Terms of Use."],
            882 => [
                "footer_disclaimer" => "You agree to receive automated promotional messages.  You also agree to the <a href=\"https://renaissanceloans.com/privacy-policy/\" target=\"_blank\">privacy policy</a> - This agreement isn\'t a condition of any transaction or offering.  Msg & Data rates may apply.  By replying \"stop\", text communications will be stopped immediately.  By agreeing to opt-in to this service, you are agreeing to allow Renaissance Mortgage Capital, LLC dba Renaissance Home Loans, and Sapphire Properties of the Palm Beaches, LLC dba Sapphire Properties to contact you using digital forms of communication including automated text notifications, phone calls and emails.  Renaissance Mortgage Capital, LLC and Sapphire Properties of the Palm Beaches, LLC are affiliated businesses, share data, and seek to assist customers with mortgage and real estate services."],
            883 => [
                "footer_disclaimer" => "You agree to receive automated promotional messages.  You also agree to the privacy policy - <a href=\"https://renaissanceloans.com/privacy-policy/\" target=\"_blank\">NEEDS TO BE SAPPHIRE PRIVACY POLICY</a> - This agreement isn\'t a condition of any transaction or offering.  Msg & Data rates may apply.  By replying \"stop\", text communications will be stopped immediately.  By agreeing to opt-in to this service, you are agreeing to allow Sapphire Properties of the Palm Beaches, LLC dba Sapphire Properties and Renaissance Mortgage Capital, LLC dba Renaissance Home Loans, to contact you using digital forms of communication including automated text notifications, phone calls and emails.  Sapphire Properties of the Palm Beaches, LLC and Renaissance Mortgage Capital, LLC are affiliated businesses, share data, and seek to assist customers with mortgage and real estate services."],
            966 => [
                "disclaimer_text" => "By clicking the \"Continue\" button below, I agree to the InsureOne Insurance <a href=\"https://www.insureone.com/privacy-policy/\" style=\"font-weight: bold;\" target=\"_blank\">Privacy Policy</a> and <a style=\"font-weight: bold;\" href=\"https://www.insureone.com/terms-of-use/\" target=\"_blank\">Terms of Use</a>, and I give consent to share my information with InsureOne Insurance\'s <a style=\"font-weight: bold;\" href=\"https://www.insureone.com/affiliate-disclosure/\" target=\"_blank\">Affiliates</a>, <a style=\"font-weight: bold;\"href=\"https://www.insureone.com/external-marketing-partners/\" target=\"_blank\">External Marketing Partners</a>, and their successors and assigns. For all of these, I also give my express written consent to be contacted at the phone number provided above for marketing purposes by call, text, or automated telephone dialing system, including with an artificial or prerecorded voice. I understand that I am providing this consent even if my telephone number is currently listed on a federal, state, internal, or corporate Do-Not-Call list. I understand that I do not have to agree to receive these types of calls or text messages as a condition of purchasing any goods or&nbsp;services."],
            //Footer
            918 => [
                "footer_disclaimer" => '<p class="bottomlinksmodal bottomlinksmodal--color">Copyright © 2021. Homestar Financial Corporation 332 Washington St. NW, Gainesville, GA 30501. NMLS #70864. For licensing info: NMLSconsumeraccess.org. This is not a commitment to lend and not all customers will qualify. All terms, information, conditions, rates, and programs are subject to credit and property approval and may change without notice. Not all products are available in all states. Certain other restrictions may apply. Homestar Financial Corporation is an equal housing lender and is not affiliated with any government&nbsp;entity.</p>']
        ];
        $customizedFunnels = $this->getCustomizedFunnelsByMappingIds($mappings);
        foreach ($customizedFunnels as $customizedFunnel) {
            $headerCode = $customizedFunnel->header_code;
            $footerCode = $customizedFunnel->footer_code;
            $headerScript = $this->getJsScript($headerCode);
            $headerJsEndingPosition = $this->jsScriptEndingPosition;
            $footerScript = $this->getJsScript($footerCode);

            if($headerScript !== false || $footerScript !== false) {
                if($this->isDisclaimerAdded($headerScript) || $this->isDisclaimerAdded($footerScript)) {
                    $this->error("[FunnelCustomizations] ID#" . $customizedFunnel->id . " header/footer code already updated.\n");
                } else {
                    $newScript = $this->addDisclaimerScript($mappings[$customizedFunnel->id]);
                    if (strpos($headerScript, ".phone-box") !== false || $this->isFooterDisclaimerScript($headerScript)) {
                        $headerCode = substr_replace($headerCode, $newScript, $headerJsEndingPosition, 0);
                    } else {
                        $footerCode = substr_replace($footerCode, $newScript, $this->jsScriptEndingPosition, 0);
                    }

                    $this->updateCustomizedFunnel($customizedFunnel, [
                        "header_code" => $headerCode,
                        "footer_code" => $footerCode
                    ]);
                }
            }
        }
    }

    /**
     * @param $code
     * @return boolto check footer disclaimer in code
     */
    private function isFooterDisclaimerScript($code){
        if(strpos($code, 'jQuery(".main-footer").prepend') !== false ||
            strpos($code, "jQuery('#main-wrapper .main-footer').prepend") !== false ||
            strpos($code, 'jQuery("#rightside").append') !== false ||
            strpos($code, "jQuery('#rightside').append") !== false ||
            strpos($code, "jQuery('#rightside').after") !== false ||
            strpos($code, 'jQuery("#rightside").before') !== false ||
            strpos($code, 'jQuery(".main-footer #rightside").before') !== false ||
            strpos($code, 'jQuery(".main-footer .hide-cell-pop").prepend')){
            return true;
        }
        return false;
    }
    /**
     * checking if replaced in header OR footer
     */
    private function isDisclaimerAdded($code) {
        if(strpos($code, ".phone-box") !== false && strpos($code, "contact-disclaimer") !== false) {
            return true;
        }

        if($this->isFooterDisclaimerScript($code) && strpos($code, ".footer__info") !== false) {
            return true;
        }

        return false;
    }

    /**
     * adding footer company logo customization code
     */
    private function addDisclaimerScript($properties){
        $script = "\njQuery(document).ready(function (){";

        if(isset($properties["disclaimer_text"])) {
            $script .= '
            /* Contact Disclaimer */
            let contact_disclaimer = "' . addslashes($properties["disclaimer_text"]) . '";
            jQuery(".question [data-id=phone]").parents(".question").find(".step-footer").append("<div class=\"contact-disclaimer\">" + contact_disclaimer + "</div>");';
        }

        if(isset($properties["email-box"])) {
            $script .= '
                jQuery(".question [data-id=email]").parents(".question").find(".step-footer").append("<div class=\"contact-disclaimer\">" + contact_disclaimer + "</div>");
                ';
        }

        if(isset($properties["footer_disclaimer"])) {
            $jquery_method = (isset($properties["jquery_method"]) ? $properties["jquery_method"] : "after");
            $script .= '
            /* Footer Disclaimer */
            let disclaimer = "' . addslashes($properties["footer_disclaimer"]) . '";
            jQuery(".footer__info").' . $jquery_method . '("<div class=\"disclaimer\">" + disclaimer + "</div>");';
        }


        $script .= "});";

        return $script;
    }

    private function addPhoneNumbersScripts() {
        $mappings = [
            // Header
            903 => [
                "needle"=>".show-tab #poweredbysomeguysincphonetext span",
                "remove_style" => true,
                "phone_numbers" => [[
                    "label" => "Call:",
                    "number" => "(352) 754-6191",
                ], [
                    "label" => "Text:",
                    "number" => "(813) 946-9706"
                ]]
            ],
            936 => [
                "needle"=>".show-tab #phone #poweredbysomeguysincphonetext",
                "mobile_hide_labels" => true,
                "phone_numbers" => [[
                    "link_text" => "(844) 842-LOAN",
                    "label" => "Call Today!",
                    "number" => "(844) 842-5626",
                ]]
            ],
            799 => [
                "needle"=>".show-tab #phone #poweredbysomeguysincphonetext",
                "mobile_hide_labels" => true,
                "phone_numbers" => [[
                    "link_text" => "1-888-8KARBON",
                    "label" => "Call Today!",
                    "number" => "1-888-8527266",
                ]]
            ],
            961 => [
                "needle"=>".show-tab #phone #poweredbysomeguysincphonetex",
                "mobile_hide_labels" => true,
                "phone_numbers" => [[
                    "label" => "Toll Free:",
                    "number" => "(866) 684-3247"
                ], [
                    "label" => "Local:",
                    "number" => "(714) 548-3291",
                ]]
            ],
            959 => [
                "needle"=>".show-tab.only-number .meta_info",
                "phone_numbers" => [[
                    "label" => "Chris\'s Phone#",
                    "number" => "(239) 206-4872"
                ], [
                    "label" => "Corey\'s Phone#",
                    "number" => "(239) 218-8148",
                ]]
            ],
            965 => [
                "needle"=>".show-tab.only-number .meta_info ul",
                "mobile_hide_labels" => true,
                "jquery_method" => "after",
                "phone_numbers" => [[
                    "label" => "Call or Text!",
                    "number" => "(239) 206-4872"
                ]]
            ]
        ];

        $customizedFunnels = $this->getCustomizedFunnelsByMappingIds($mappings);
        foreach ($customizedFunnels as $customizedFunnel) {
            $headerCode = $customizedFunnel->header_code;
            $footerCode = $customizedFunnel->footer_code;
            $headerScript = $this->getJsScript($headerCode);
            $headerJsEndingPosition = $this->jsScriptEndingPosition;
            $footerScript = $this->getJsScript($footerCode);
            $properties = $mappings[$customizedFunnel->id];

            if($headerScript !== false || $footerScript !== false) {
                if($this->isPhoneNumbersAdded($headerScript, $properties["needle"]) || $this->isPhoneNumbersAdded($footerCode, $properties["needle"])) {
                    $this->error("[FunnelCustomizations] ID#" . $customizedFunnel->id . " header/footer code already updated.\n");
                } else {
                    $newScript = $this->addPhoneNumbersScript($properties);
                    if(strpos($headerScript, $properties["needle"]) !== false){
                        $headerCode = substr_replace($headerCode, $newScript, $headerJsEndingPosition, 0);
                        // removing styles
                        if(isset($properties["remove_style"])) {
                            $headerCode = $this->removeStyles($headerCode, $properties["remove_style"]);
                        }

                    } else {
                        $footerCode = substr_replace($footerCode, $newScript, $this->jsScriptEndingPosition, 0);
                        // removing styles
                        if(isset($properties["remove_style"])) {
                            $footerCode = $this->removeStyles($footerCode, $properties["remove_style"]);
                        }
                    }

                    $this->updateCustomizedFunnel($customizedFunnel, [
                        "header_code" => $headerCode,
                        "footer_code" => $footerCode
                    ]);
                }
            }
        }
    }

    /**
     * checking if replaced in header OR footer
     */
    private function isPhoneNumbersAdded($code, $needle) {
        if(strpos($code, $needle) !== false && strpos($code, "contact-number") !== false) {
            return true;
        }

        return false;
    }

    /**
     * adding phone number script
     */
    private function addPhoneNumbersScript($properties){
        $script = "jQuery(document).ready(function (){";

        if(isset($properties["phone_numbers"])) {
            $phoneHtml = "";
            foreach ($properties["phone_numbers"] as $phoneNumber) {
                $link_text = isset($phoneNumber["link_text"]) ? $phoneNumber["link_text"] : $phoneNumber["number"];
                $phoneHtml .= '<span class="contact-number"><span class="contact-label">' . $phoneNumber["label"] . ' </span><a href="tel:' . $phoneNumber["number"] . '">' . $link_text . '</a></span>';
            }

            $cls = "custom-company-details";
            $cls .= (isset($properties["mobile_hide_labels"]) && $properties["mobile_hide_labels"]) ? " without-label" : "";
            $jquery_method = (isset($properties["jquery_method"]) && $properties["jquery_method"]) ? $properties["jquery_method"] : "replaceWith";
            $script .= '
                /* Phone Number */
                jQuery(".header__info .cta-btn").remove();
                jQuery(".header__info .contact-number span").addClass("contact-label");
                jQuery(".header__info .contact-number").' . $jquery_method . '(\'' . $phoneHtml . ' \');
                jQuery(".header__info").addClass("' . $cls . '");';
        }


        $script .= "});";

        return $script;
    }

    /**
     * get customized funnels
     * @param $mappings
     * @return \Illuminate\Support\Collection
     */
    private function getCustomizedFunnelsByMappingIds($mappings) {
        $this->info("adding/Updating entries -> " . implode(",", array_keys($mappings)));
        return DB::table($this->customizations_table)
            ->select("id", "header_code", "footer_code")
            ->whereIn('id', array_keys($mappings))
            ->whereIn("client_id", $this->activeClients)
            ->orderBy("id", "asc")
            ->get();
    }

    /**
     * update customization after changes
     * @param $customizedFunnel
     * @param $attributes
     */
    private function updateCustomizedFunnel($customizedFunnel, $attributes) {
        if ($this->action == "fix") {
            DB::table($this->customizations_table)
                ->where("id", $customizedFunnel->id)
                ->update($attributes);
            $this->info("[FunnelCustomizations] ID#" . $customizedFunnel->id . " funnel code/style updated.\n");
        } else {
            $this->info("[DRY RUN] - [FunnelCustomizations] ID#" . $customizedFunnel->id . " funnel code/style will be updated.\n");
        }
    }

    /**
     * This will remove complete style attribute OR specific class
     */
    private function removeStyles($code, $style) {
        $style_start = "<style";
        $style_end = "</style>";
        if($style == null) {
            return $code;
        }

        $cssStyleStartingPosition = strpos($code, $style_start);
        $cssStyleEndingPosition = strpos($code, $style_end, $cssStyleStartingPosition);
        if($cssStyleStartingPosition !== false && $cssStyleEndingPosition !== false) {
            if($style == true) {
                $cssStyleEndingPosition += strlen($style_end);
                return substr_replace($code, "", $cssStyleStartingPosition, ($cssStyleEndingPosition - $cssStyleStartingPosition));
            }
        }

        return $code;
    }

    /**
     * Adding CSS for new design
     */
    private function addStyles(){
        $mappings = [
            //Header styles
            937 => ["styles" =>".footer__copyright .copyright-logo li.logo, .footer .logo-list-mobile li.logo{
                width: 55px; max-width: 55px !important;
            }"]
        ];

        $customizedFunnels = $this->getCustomizedFunnelsByMappingIds($mappings);
        foreach ($customizedFunnels as $customizedFunnel) {
            $properties = $mappings[$customizedFunnel->id];
            $headerCode = $customizedFunnel->header_code;
            $headerStyle = $this->getCssStyle($headerCode);
            if ($headerStyle !== false) {
                if (strpos($headerStyle,".logo-list-mobile") !== false) {
                    $this->error("[FunnelCustomizations] ID#" . $customizedFunnel->id . " code already updated.\n");
                } else if(isset($properties["styles"])) {
                    $newStyles = "
                        /* Footer logo CSS styles */
                        " .$properties["styles"];
                    $headerCode = substr_replace($headerCode, $newStyles, $this->cssStyleEndingPosition, 0);
                    $this->updateCustomizedFunnel($customizedFunnel, [
                        "header_code" => $headerCode
                    ]);
                }
            }
        }
    }

    /**
     * adding featured image new cirle styles CSS
     * @return bool
     */
    private function addFeaturedImageCirleStyles()
    {
        $customizedFunnels = DB::table($this->customizations_table)
            ->select("id", "header_code")
            ->where('header_code', "like", "%<style%")
            ->where(function ($query) {
                if (!is_array($this->userInputClientIds) && strtolower($this->userInputClientIds) == "all") {
                    $query->where('header_code', "like", "%.f-img-wrapper .img-container%");
                    $query->where('header_code', "not like", "%.question__image%");
                } else {
                    $query->whereIn('client_id', $this->activeClients);
                    $query->where('header_code', "like", "%.f-img-wrapper .img-container%");
                    $query->where('header_code', "not like", "%.question__image%");
                }
            })
            ->get();

        if(count($customizedFunnels) == 0) {
            $this->error("[FunnelCustomizations] circle styles already added.\n");
            return false;
        }

        $circleStyle = "\n /* Featured image cricle style*/
        .question__image {
            overflow: hidden;
              margin: 0;
              position: relative;
              border-radius: 50%;
              border: 1px solid #eee;
              padding:7px
            }
            .home-image img {
              max-width: 100% !important;
              width: 100%;
              display: block;
              object-fit: cover;
              height: 100%;
              border-radius: 50%;
              }
              ";
        foreach ($customizedFunnels as $customizedFunnel) {
            $headerCode = $customizedFunnel->header_code;
            $style = $this->getCssStyle($headerCode);
            if ($style !== false) {
                $headerCode = substr_replace($headerCode, $circleStyle, $this->cssStyleEndingPosition, 0);
                //updating header style
                $this->updateCustomizedFunnel($customizedFunnel, [
                    "header_code" => $headerCode
                ]);
            }
        }
    }
}
