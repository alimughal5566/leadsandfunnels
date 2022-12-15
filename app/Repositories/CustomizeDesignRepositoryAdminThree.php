<?php
/**
 * Created by PhpStorm.
 * User: Jazib
 * Date: 13/11/2019
 * Time: 4:35 AM
 */

/**
 * Code Migrated from Zend to Laravel  ==>  CustomizeRepository --> Source: Default_Model_Customize (Customize.php)
 */

namespace App\Repositories;


use App\Constants\FunnelVariables;
use App\Helpers\GlobalHelper;
use App\Helpers\Query;
use App\Services\DataRegistry;
use App\Services\DbService;
use App\Services\gm_process\MyLeadsEvents;
use Exception;
use Illuminate\Http\Request;
use LP_Helper;
use Session;

class CustomizeDesignRepositoryAdminThree
{
    use Response;
    private $db, $customizeRepositoryAdminThree, $customizeRepository;
    protected static $leadpopDomainTypeId = 0;

    private $MAX_W = 190;
    private $MAX_H = 90;
    private $PAD = 10;
    private $image_wrapper = null;


    private $leadpop_vertical_id;
    private $leadpop_vertical_sub_id;
    private $leadpop_id;
    private $leadpop_type_id;
    private $leadpop_template_id;
    private $leadpop_version_id;
    private $leadpop_version_seq;
    private $clientId;


    public function __construct(DbService $service,
                                CustomizeRepositoryAdminThree $customizeRepositoryAdminThree,
                                CustomizeRepository $customizeRepository)
    {
        self::$leadpopDomainTypeId = config('leadpops.leadpopDomainTypeId');
        $this->db = $service;
        $this->customizeRepositoryAdminThree = $customizeRepositoryAdminThree;
        $this->customizeRepository = $customizeRepository;
    }


    public function updateGlobalBackgroundColorAdminThree($client_id, $post)
    {

        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($post['current_hash']);

        try {
            $lplist = explode(",", $_POST['selected_funnels']);
            if ($post['background_type'] != "") {
                $background_type = $post['background_type'];
            } else {
                $background_type = config('lp.leadpop_background_types.LOGO_COLOR');
            }
            $registry = DataRegistry::getInstance();
            $container = $registry->leadpops->clientInfo['rackspace_container'];

            $background = urldecode($post["background"]); // background=/*###>*/background-color: #8795a9;/*@@@*/ background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIHZpZXdCb3g9IjAgMCAxIDEiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjxsaW5lYXJHcmFkaWVudCBpZD0idnNnZyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSIwJSIgeTE9IjAlIiB4Mj0iMCUiIHkyPSIxMDAlIj48c3RvcCBzdG9wLWNvbG9yPSIjODc5NWE5IiBzdG9wLW9wYWNpdHk9IjEiIG9mZnNldD0iMCIvPjxzdG9wIHN0b3AtY29sb3I9IiM4Nzk1YTkiIHN0b3Atb3BhY2l0eT0iMSIgb2Zmc2V0PSIxIi8+PC9saW5lYXJHcmFkaWVudD48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI3ZzZ2cpIiAvPjwvc3ZnPg==); /* IE9, iOS 3.2+ */ background-image: -webkit-gradient(linear, 0% 0%, 0% 100%,color-stop(0, rgb(135, 149, 169)),color-stop(1, rgb(135, 149, 169))); /*Old Webkit*/ background-image: -webkit-linear-gradient(top,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* Android 2.3 */ background-image: -ms-linear-gradient(top,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* IE10+ */ background-image: linear-gradient(to bottom,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* W3C */ /* IE8- CSS hack */ @media \0screen\,screen\9 { .gradient { filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ff8795a9",endColorstr="#ff8795a9",GradientType=0); } }
            $fontcolor = $post["fontcolor"];

            $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
            $clientLogosCollection = GlobalHelper::getClientLogos($lpListCollection, $client_id);


            $leadpop_ids = implode(',', $lpListCollection->pluck('leadpop_id')->unique()->all());
            // $leadpop_version_seq_ids = implode(',', $lpListCollection->pluck('leadpop_version_seq')->unique()->all());

            // dd($post, $leadpop_ids, $lpListCollection );

            $allSixnines = GlobalHelper::getLeadLineCollection($leadpop_ids, FunnelVariables::LEAD_LINE, $client_id);


            //    dd($lpListCollection, $clientLogosCollection, $lplist);

            //  dd($allSixnines);
            $rackspace_stock_assets = rackspace_stock_assets();


            $getCdnLink = getCdnLink();
            $getHttpServer = $this->customizeRepository->getHttpServer();
            $allSwatches = GlobalHelper::getLeadpopBackgroundSwatches($lpListCollection, $client_id);


            $funnelVariables = GlobalHelper::getFunnelVariablesCollection($lpListCollection, $client_id);

            foreach ($lplist as $index => $lp) {
                $lpconstt = explode("~", $lp);
                $leadpop_vertical_id = $lpconstt[0];
                $leadpop_vertical_sub_id = $lpconstt[1];
                $leadpop_id = $lpconstt[2];
                $leadpop_version_seq = $lpconstt[3];

//                $s = "select * from leadpops where id = " . $leadpop_id;
////                $lpres = $this->db->fetchRow($s);
///
                $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

                $leadpop_type_id = $lpres['leadpop_type_id'];
                $leadpop_template_id = $lpres['leadpop_template_id'];
                $leadpop_version_id = $lpres['leadpop_version_id'];


                // $sixnine = $this->customizeRepositoryAdminThree->getLeadLine($client_id, $leadpop_id, $leadpop_version_seq, FunnelVariables::LEAD_LINE);

                $sixnine = $allSixnines
                    ->where('client_id', $client_id)
                    ->where('leadpop_id', $this->leadpop_id)
                    ->where('leadpop_version_seq', $this->leadpop_version_seq)
                    ->first();

                if ($sixnine && $sixnine[FunnelVariables::LEAD_LINE] != "") {
                    $sixnine = $sixnine[FunnelVariables::LEAD_LINE];
                    $sixnine = str_replace(';;', ';', $sixnine);
                    $sixnine = str_replace(': #', ':#', $sixnine);
                    $first = strpos($sixnine, 'color:#');
                    $first += 6;
                    $sec = strpos($sixnine, '>', $first);
                    $sec -= 1;
                    $toreplace = substr($sixnine, $first, ($sec - $first));
                    $sixnine = str_replace($toreplace, $fontcolor, $sixnine);

                    $this->customizeRepository->updateLeadLine(FunnelVariables::LEAD_LINE, $sixnine, $client_id, $leadpop_id, $leadpop_version_seq);
                }


                //icons name list
                $favicon = 'favicon-circle.png';
                $dot = 'dot-img.png';
                $ring = 'ring.png';
                $mvp = 'mvp-check.png';


                $data["client_id"] = $client_id;
                $data["leadpop_vertical_id"] = $leadpop_vertical_id;
                $data["leadpop_vertical_sub_id"] = $leadpop_vertical_sub_id;
                $data["leadpop_type_id"] = $leadpop_type_id;
                $data["leadpop_template_id"] = $leadpop_template_id;
                $data["leadpop_id"] = $leadpop_id;
                $data["leadpop_version_id"] = $leadpop_version_id;
                $data["leadpop_version_seq"] = $leadpop_version_seq;


//                $swatchData = array_merge($data, ['swatch' => $background]);
                array_merge($data, ['swatch' => $background]);

                //  $swatch = LeadpopBackgroundSwatches::where($swatchData)->first();

               /* $leadpopBackgroundWhere = array_map(function ($value, $key) {
                    return $key . '="' . $value . '"';
                }, array_values($data), array_keys($data));

                $leadpopBackgroundWhere = implode(' and ', $leadpopBackgroundWhere);*/


                $leadpopBackgroundWhere = GlobalHelper::whereColumnsArrayToQuery($data);

                $swatch = $allSwatches
                    ->where("client_id", $client_id)
                    ->where("leadpop_id", $leadpop_id)
                    ->where("leadpop_type_id", $leadpop_type_id)
                    ->where("leadpop_vertical_id", $leadpop_vertical_id)
                    ->where("leadpop_vertical_sub_id", $leadpop_template_id)
                    ->where("leadpop_template_id", $leadpop_template_id)
                    ->where("leadpop_version_id", $leadpop_version_id)
                    ->where("leadpop_version_seq", $leadpop_version_seq)
                    ->where("swatch", $background)
                    ->first();


                 $updateColumns = [
                      'background_color' => $background,
                      'background_type' => $background_type
                  ];

                $leadpopBackgroundColums = " background_color = '$background' , "
                    . "  background_type = '$background_type' ";

             //   $leadpopBackgroundColums = GlobalHelper::updateColumnsArrayToQuery($updateColumns);


                if ($swatch && $swatch != "") {
                    $colorRegex = '/^.+?rgba\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([\d\.]+)/';
                    if (preg_match($colorRegex, $background, $matches)) {
                        $customColor = "{$matches[1]},{$matches[2]},{$matches[3]}";
                        $opacity = (int)(((float)$matches[4]) * 100);
                          $updateColumns = [
                              'background_custom_color' => $customColor,
                              'background_overlay_opacity' => $opacity,
                              'color_mode' => 'rgb',
                              'background_type' => '2'
                          ];

                      /*  $leadpopBackgroundColums.= ' , ';
                        $leadpopBackgroundColums.= GlobalHelper::updateColumnsArrayToQuery($updateColumns);*/


                        $leadpopBackgroundColums .= ", background_custom_color = '$customColor' , "
                            . "  background_overlay_opacity = '$opacity' , "
                            . "  color_mode = 'rgb' ,"
                            . "  background_type = '2' ";

                    }
                }

                // LeadpopBackgroundColor::where($data)->update($updateColumns);

                $query = "UPDATE leadpop_background_color set " . $leadpopBackgroundColums . " WHERE " . $leadpopBackgroundWhere;
//                dd($post, $query);
                 /*     echo "<br>";
                      echo 'swatch => '. $swatch;
                      echo $query;
                      echo "<br>";
                      echo "<br>";*/


                Query::execute($query, $currentFunnelKey);

                /* $where = array_map(function ($value, $key) {
                     return $key . '="' . $value . '"';
                 }, array_values($data), array_keys($data));

                 $where = implode(' and ', $where);*/

                $logo_color = $fontcolor;

                /*$s = "select count(*) as cnt from leadpop_logos where  client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $s .= " and use_default = 'y' ";
                $usingDefaultLogo = $this->db->fetchOne($s); // one == using default logo, zero equals uploaded a  logo*/


                $usingDefaultLogo = $clientLogosCollection
                    ->where("client_id", $client_id)
                    ->where("leadpop_id", $leadpop_id)
                    ->where("leadpop_type_id", $leadpop_type_id)
                    ->where("leadpop_vertical_id", $leadpop_vertical_id)
                    ->where("leadpop_vertical_sub_id", $leadpop_template_id)
                    ->where("leadpop_template_id", $leadpop_template_id)
                    ->where("leadpop_version_id", $leadpop_version_id)
                    ->where("leadpop_version_seq", $leadpop_version_seq)
                    ->where("use_default", 'y')
                    ->count();


                if ($usingDefaultLogo) {
                    $filename1 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-";
                    $filename2 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-";
                    $filename3 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-";
                    $filename4 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-";

                    // For Production
                    $favicon_location = $rackspace_stock_assets . "images/" . $filename1 . $favicon;
                    $image_location = $rackspace_stock_assets . "images/" . $filename2 . $dot;
                    $mvp_dot_location = $rackspace_stock_assets . "images/" . $filename3 . $ring;
                    $mvp_check_location = $rackspace_stock_assets . "images/" . $filename4 . $mvp;

                    //make the new icons
                    $favicon_dst_src = $rackspace_stock_assets . "images/default/" . $filename1 . $leadpop_version_seq . "-" . $favicon;
                    $colored_dot_src = $rackspace_stock_assets . "images/default/" . $filename2 . $leadpop_version_seq . "-" . $dot;
                    $mvp_dot_src = $rackspace_stock_assets . "images/default/" . $filename3 . $leadpop_version_seq . "-" . $ring;
                    $mvp_check_src = $rackspace_stock_assets . "images/default/" . $filename4 . $leadpop_version_seq . "-" . $mvp;

                    //make new file url
                    $favicon_dst = $getHttpServer . '/images/' . $filename1;
                    $colored_dot = $getHttpServer . 'images/' . $filename2;
                    $mvp_dot = $getHttpServer . 'images/' . $filename3;
                    $mvp_check = $getHttpServer . 'images/' . $filename4;

                    //update leadpop_logos column values
                    $leadpop_logos_columns = array('default_colored' => 'y', 'logo_color' => $logo_color);
                    $leadpopBackgroundWhere .= " and use_default = 'y'";


                }
                else {
                    $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $leadpop_vertical_id . "_" . $leadpop_vertical_sub_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq);

                    // For Production
                    $favicon_location = $rackspace_stock_assets . "images/" . $favicon;
                    $image_location = $rackspace_stock_assets . "images/" . $dot;
                    $mvp_dot_location = $rackspace_stock_assets . "images/" . $ring;
                    $mvp_check_location = $rackspace_stock_assets . "images/" . $mvp;

                    //icons new name
                    $new_favicon = '_' . $favicon;
                    $new_dot = '_' . $dot;
                    $new_ring = '_' . $ring;
                    $new_mvp = '_' . $mvp;

                    //make the new icons
                    $favicon_dst_src = 'images1/' . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . $new_favicon;
                    $colored_dot_src = 'images1/' . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . $new_dot;
                    $mvp_dot_src = 'images1/' . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . $new_ring;
                    $mvp_check_src = 'images1/' . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . $new_mvp;

                    //make new file url
                    $colored_dot = $getCdnLink . '/logos/' . $filename . $new_dot;
                    $favicon_dst = $getCdnLink . '/logos/' . $filename . $new_favicon;
                    $mvp_dot = $getCdnLink . '/logos/' . $filename . $new_ring;
                    $mvp_check = $getCdnLink . '/logos/' . $filename . $new_mvp;

                    //update leadpop_logos column values
                    $leadpop_logos_columns = array('default_colored' => 'n', 'logo_color' => $logo_color);
                    $leadpopBackgroundWhere .= " and use_me = 'y'";

                }

                $new_clr = [];
                if (isset($logo_color) && $logo_color != "") {
                    $new_clr = $this->customizeRepository->hex2rgb($logo_color);
                }

               /* $myRed = $new_clr[0];
                $myGreen = $new_clr[1];
                $myBlue = $new_clr[2];*/


                $myRed = $new_clr[0] ?? '#3c489e';
                $myGreen = $new_clr[1] ?? '#3c489e';
                $myBlue = $new_clr[2] ?? '#3c489e';


                //icons upload from gearman process
                if (getenv('APP_ENV') != "local") {
                    MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $image_location, $myRed, $myGreen, $myBlue, $colored_dot_src, $client_id, "icons--" . $lp);
                    MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src, $client_id, "icons--" . $lp);
                    MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src, $client_id, "icons--" . $lp);
                    MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src, $client_id, "icons--" . $lp);
                }

                // update the funnel variables in client_leadpops table
                $design_variables = array();
                $design_variables[FunnelVariables::LOGO_COLOR] = $logo_color;
                $design_variables[FunnelVariables::COLORED_DOT] = $colored_dot;
                $design_variables[FunnelVariables::MVP_DOT] = $mvp_dot;
                $design_variables[FunnelVariables::MVP_CHECK] = $mvp_check;
                $design_variables[FunnelVariables::FAVICON_DST] = $favicon_dst;


                $funnel_variables = $funnelVariables
                    ->where('client_id', $client_id)
                    ->where('leadpop_id', $leadpop_id)
                    ->where('leadpop_version_seq', $leadpop_version_seq)
                    ->first();

                if ($funnel_variables) {

                    $funnel_variables = json_decode($funnel_variables['funnel_variables'], 1);
                    //   dd($funnelVariables, $funnel_variables, $design_variables);
                    //   $this->customizeRepository->updateFunnelVariables($design_variables, $client_id, $leadpop_id, $leadpop_version_seq);

                    if ($design_variables) {
                        foreach ($design_variables as $key => $value) {
                            $funnel_variables[$key] = $value;
                        }
                        $s = "UPDATE clients_leadpops SET funnel_variables = '" . addslashes(json_encode($funnel_variables)) . "' ";
                        $s .= " WHERE client_id = " . $client_id;
                        $s .= " AND leadpop_id = " . $leadpop_id;
                        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;

                        Query::execute($s, $currentFunnelKey);
//                          $this->db->query($s);
                        /*  echo $s;
                          echo "<br>";
                          echo "<br>";
                          echo "<br>";*/
                    }

                }
                //update the leadpop_logos table with new values

                $updateString = GlobalHelper::updateColumnsArrayToQuery($leadpop_logos_columns);

                $query = "UPDATE leadpop_logos set $updateString where $leadpopBackgroundWhere";

                /*   echo $query;
                          echo "<br>";
                          echo "<br>";
                          echo "<br>";*/


                // $this->db->update('leadpop_logos', $leadpop_logos_columns, $leadpopBackgroundWhere);
                Query::execute($query, $currentFunnelKey);
            }
            return 'ok';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function updateglobalbackgroundimageAdminThree($client_id, $post, $afiles)
    {

        if (env('GEARMAN_ENABLE') == "1") $gearmanQuery = true;
        else $gearmanQuery = false;

        $lplist = explode(",", $_POST['selected_funnels']);
        $lplist = collect($lplist);
        // To ADD Source Funnel in Global QUE

        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($post['current_hash']);

        $lplist->prepend($currentFunnelKey);
        $lplist = $lplist->unique()->values()->all();

        $registry = DataRegistry::getInstance();

        extract($post->all(), EXTR_OVERWRITE, "form_");
        $tarr = [];
        //  $lplist = explode(",", $lpkey_backgroundimage);


        if ($post['background_type'] != "") {
            $background_type = $post['background_type'];
        } else {
            $background_type = config('lp.leadpop_background_types.LOGO_COLOR');
        }
        $uploaded = false;
        $isfile = false;
        $global_bg_image = array();
        $container = $registry->leadpops->clientInfo['rackspace_container'];
        if ($container) {
            $res = \DB::select("SELECT * FROM current_container_image_path WHERE current_container = '" . $container . "'");
            $containerInfo = objectToArray($res[0]);
            $image_path = $containerInfo['image_path'];
            $parsedUrl = parse_url($containerInfo['image_path']);
            if (substr($parsedUrl['path'], 1) != "") {
                $rackspace_path = substr($parsedUrl['path'], 1);
            }
        }

        $alreadyUploadToCdn = false;
        $first_processed_info = [];

        // LpListCollection
        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);

        $getCdnLink = getCdnLink();
        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);

            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            // $s = "select * from leadpops where id = " . $leadpop_id;
            // $lpres = $this->db->fetchRow($s);

            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

            /*  echo "<pre>";
             print_r($lpres);
             echo "</pre>";
             continue;*/


            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            $section = substr($client_id, 0, 1);
            if ($afiles['background_name']['name'] == '') {
                $img_exp = explode("/", $post['image-url']);
                $img_name = end($img_exp);
                $imagename = rtrim($img_name, '/');
                //$imagename = substr(end(explode("/",$post['image-url'])),0,-1);
            } else {
                $isfile = true;
                $file_name = $afiles['background_name']['name'];
                $newfile_name = preg_replace('/[^A-Za-z0-9-.]/', "", $file_name);
                $imagename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "_" . $newfile_name);
            }

            $imagepath = $section . '/' . $client_id . '/pics/' . $imagename;
            $imageurl = $getCdnLink . '/pics/' . $imagename;

            //  $post['gradient'] = "url(" . getCdnLink() . '/pics/' . $imagename . ")";
            $post['gradient'] = "url(" . $imageurl . ")";
            $background_overlay = $post['background-overlay'];
            $active_overlay = empty($_POST['bgoverly']) ? 'n' : 'y';
            if ($active_overlay == "n") {
                //$post['overlay_color_opacity']=0;
            }

            //to save in db to slip for admin
            $bgimageprop = $post['background_size'] . "~" . $post['background-position'] . "~" . $post['background-repeat'] . "~" . $post['overlay_color_opacity'];


            $bgimage_style = "style='background-image: " . $post['gradient'] . ";";
            $bgimage_style .= " background-size: " . $post['background_size'] . ";";
            $bgimage_style .= " background-position: " . $post['background-position'] . ";";
            $bgimage_style .= " background-repeat: " . $post['background-repeat'] . ";'";
            //$bgimage_style .=" opacity: ".$post['overlay_color_opacity'].";'";
            $background_overlay_opacity = $post['overlay_color_opacity'];

            $s = "update leadpop_background_color set active_backgroundimage = 'y', bgimage_url = '" . $imageurl
                . "', active_overlay = '" . $active_overlay
                . "', background_overlay = '" . $background_overlay
                . "', bgimage_style = '" . addslashes($bgimage_style)
                . "', bgimage_properties = '" . addslashes($bgimageprop)
                . "',background_overlay_opacity='$background_overlay_opacity',background_type = '"
                . $background_type . "'";

            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;

            Query::execute($s, $currentFunnelKey);

            /* if ($gearmanQuery) {
                 MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
             } else {
                 $this->db->query($s);
             }*/

            /*   if ($uploaded) {
                   if ($isfile)
                       $global_bg_image[] = array('server_file' => $image_path . $uploaded,
                           'container' => $container,
                           'rackspace_path' => $rackspace_path . $imagepath
                       );
               } else {
                   if ($isfile) {
                       if (move_uploaded_file_to_rackspace($afiles["background_name"]["tmp_name"], $imagepath)) {
                           $uploaded = $imagepath;
                       }
                   }
               }*/

            if ($afiles['background_name']['tmp_name'] != '') {
                try {
//                    if(!$alreadyUploadToCdn ) {
                    if ($index == 0) {
                        $cdn = move_uploaded_file_to_rackspace($afiles['background_name']['tmp_name'], $imagepath);
                        $imagepath = $cdn['rs_cdn'];
                        // dd($imagepath);
                        $first_processed_info['imagepath'] = $imagepath;
                        $first_processed_info['logo_type'] = $afiles['background_name']['type'];
                    } else {
                        if (env('APP_ENV') === config('app.env_local')) {
                            //  dd($first_processed_info['imagepath'], $imagepath, $container);
                            $cdn = rackspace_copy_file_as($first_processed_info['imagepath'], $imagepath, $container);
                        } else {
                            $cdn = rackspace_copy_file_as_with_gearman($first_processed_info['imagepath'], $imagepath, $container, $client_id, $lp);
                        }

                    }

                    $cdn_link = $cdn['rs_cdn'];
//                            $global_bg_image[] = $cdn_link;
                    //  array_push($global_bg_image, $cdn_link);
                    //   dd($cdn, $image_path, $imagepath, $imageurl);
                    //  return "ok";
                } catch (Exception $e) {
                    if (env('APP_ENV') === config('app.env_local')) {
                       // dd($e);
                    } elseif (env('APP_ENV') !== config('app.env_production'))
                        \Log::channel('myleads')->info('[' . $index . ' ==> ' . $lp . '] = Background Image copy error  => ' . json_encode($e->getMessage()));

                    // return $e->getMessage();
                }
            }
        }


        //  dd($global_bg_image);
        //debug($tarr);
        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);

        if (!$client) {
            $s = "insert into global_settings (id,client_id,bk_image_active,active_backgroundimage,bgimage_url,active_overlay,background_overlay,bgimage_style,bgimage_properties,background_overlay_opacity";
            $s .= ") values (null,";
            $s .= $client_id . ",'y','y','" . $imageurl . "','" . $active_overlay . "','" . $background_overlay . "','" . addslashes($bgimage_style) . "','" . addslashes($bgimageprop) . "','" . $post['overlay_color_opacity'] . "')";


            if ($gearmanQuery) {
                MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
            } else {
                $this->db->query($s);
            }
        } else {
            $s = "update global_settings set bk_image_active = 'y', active_backgroundimage = 'y', bgimage_url = '" . $imageurl . "', active_overlay = '" . $active_overlay . "', background_overlay = '" . $background_overlay . "', bgimage_style = '" . addslashes($bgimage_style) . "', bgimage_properties = '" . addslashes($bgimageprop) . "', background_overlay_opacity = '" . $post['overlay_color_opacity'] . "'";
            $s .= " where client_id = " . $client_id;

            //   Query::execute($s);
            if ($gearmanQuery) {
                MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
            } else {
                $this->db->query($s);
            }
        }

        if (env('GEARMAN_ENABLE') == "1") {
            if (isset($_COOKIE['debug_bg_image']) and $_COOKIE['debug_bg_image'] == 1) {
                print_r($global_bg_image);
                die;
            }
            if ($global_bg_image) {
                //  MyLeadsEvents::getInstance()->executeRackspaceCDNClient($global_bg_image);
            }
        }
        return 'ok';
    }


    public function uploadgloballogo($afiles, $client_id)
    {
        //  die("client_id =>". $client_id);
        $getCdnLink = getCdnLink();

        $afiles['logo']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['logo']['name']);
        $logoname = strtolower($client_id . "_global_" . $afiles['logo']['name']);

        $section = substr($client_id, 0, 1);
        $logopath = $section . '/' . $client_id . '/logos/' . $logoname;
        //**// $logourl = $this->getHttpAdminServer() . '/images/clients/' . $section . '/' . $client_id . '/logos/' . $logoname;
        $logourl = $getCdnLink . '/logos/' . $logoname;

        list($src_w, $src_h, $type) = getimagesize($afiles['logo']["tmp_name"]);

        //**// move_uploaded_file($afiles['globallogo']['tmp_name'], $logopath);
        $cdn = move_uploaded_file_to_rackspace($afiles['logo']['tmp_name'], $logopath);
        $logopath = $cdn['rs_cdn'];

        $logo_color = $this->customizeRepositoryAdminThree->getLogoProminentColor($logopath);
        if (is_array($logo_color)) {
            $logo_color = $logo_color[0];
        }

        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);

        if (@$_POST['uploadlogotype'] == 'uploadlogo') {
            $clien_logo = "logo1";
            $check = true;
            if ($client) {
                if ($client["logo1"] == "") {
                    $clien_logo = "logo1";
                    $check = false;
                }

                if ($client["logo2"] == "" && $check == true) {
                    $clien_logo = "logo2";
                    $check = false;
                }

                if ($client["logo3"] == "" && $check == true) {
                    $clien_logo = "logo3";
                }
            }

            if ($clien_logo != "") {
                if (!$client) {
                    $s = "insert into global_settings (id,client_id,$clien_logo";
                    $s .= ") values (null,";
                    $s .= $client_id . ",'" . $logourl . "') ";
                    $this->db->query($s);
                } else {
                    $s = "update global_settings set $clien_logo = '" . $logourl . "'";
                    $s .= " where client_id = " . $client_id;
                    $this->db->query($s);
                }
            }
        }

        return 'ok';
    }


    /**
     * Save/Upload New Logo Globally
     *
     * @param $afiles $_FILE Global variable
     * @param $request $_POST Global variable
     * @param $client_id
     * @param string $swatches
     *
     * @return string
     * @throws Exception
     */
    function savegloballogonew($afiles, $request, $client_id, $swatches = '')
    {
        $registry = DataRegistry::getInstance();
        $container = $registry->leadpops->clientInfo['rackspace_container'];

        // To ADD Source Funnel in Global QUE
        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);

        if (env('GEARMAN_ENABLE') == "1") $gearmanQuery = true;
        else $gearmanQuery = false;

        $lplist = explode(",", $_POST['selected_funnels']);
        $lplist = collect($lplist);

        $lplist->prepend($currentFunnelKey);
        $lplist = $lplist->unique()->values()->all();

        $first_processed_info = array();
        $globalRandStr = "global__" . $this->customizeRepositoryAdminThree->generateRandomString(5);
        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
        $leadpopLogos = GlobalHelper::getClientLogos($lpListCollection, $client_id);
        $response = [];

        foreach ($lplist as $index => $lp) {
            if (env('APP_ENV') !== config('app.env_production')) {
                \Log::channel('myleads')->info('----------------- [Global Logo @ index-' . $index . '] -----------------');
            }
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            /*  $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);*/

            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];
            $defaultlogoname = $this->getDefaultLogoName($subvertical_id, $leadpop_version_id);


//            \DB::enableQueryLog();
            /*$logos = \DB::table("leadpop_logos")
                ->where("client_id", $client_id)
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_type_id", $leadpop_type_id)
                ->where("leadpop_vertical_id", $vertical_id)
                ->where("leadpop_vertical_sub_id", $subvertical_id)
                ->where("leadpop_template_id", $leadpop_template_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where("leadpop_version_seq", $version_seq)
                ->where('logo_src', '!=', $defaultlogoname)
                ->where("logo_src", "NOT LIKE", "%default/images/%")
                ->where("logo_src", "NOT LIKE", "%itclix.com/images/%")
                ->orderBy('id', 'ASC')
                ->get();*/


            $logos = $leadpopLogos
                ->where("client_id", $client_id)
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_type_id", $leadpop_type_id)
                ->where("leadpop_vertical_id", $vertical_id)
                ->where("leadpop_vertical_sub_id", $subvertical_id)
                ->where("leadpop_template_id", $leadpop_template_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where("leadpop_version_seq", $version_seq)
                ->where('logo_src', '!=', $defaultlogoname)
                ->where("logo_src", "NOT LIKE", "%default/images/%")
                ->where("logo_src", "NOT LIKE", "%itclix.com/images/%")
                ->sortBy('id')
                ->all();

//            dd(\DB::getQueryLog());
//            dd($logos, $logos->getBindings());

            $current_logo_count = count($logos);
            if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('[' . $lp . '] Existing Logo(s): ' . $current_logo_count);

            # if user reaches update limit of 3 then delete the oldest inactive logo
            $num_of_logos_to_remove = $current_logo_count - 2;
            if ($num_of_logos_to_remove > 0) {
                foreach ($logos as $oneLogo) {
                    if ($oneLogo->use_me == 'n') {
                        \DB::table("leadpop_logos")->where("id", $oneLogo->id)->delete();

                        @unlink($_SERVER['DOCUMENT_ROOT'] . '/images/clients/' . $client_id . '/logos/' . $oneLogo->logo_src);

                        $s = "insert into cron_delete_client_logos (id,client_id,logo_name,hasrun,daterun) values (null,";
                        $s .= $client_id . ",'" . $oneLogo->logo_src . "','n','')";

                        Query::execute($s, $currentFunnelKey);
                        /* if ($gearmanQuery) {
                             MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                         } else {
                             $this->db->query($s);
                         }*/

                        $num_of_logos_to_remove--;
                        if ($num_of_logos_to_remove == 0) break;
                    }
                }
            }

            /*  $s = "select numpics,use_default from leadpop_logos ";
              $s .= " where client_id = " . $client_id;
              $s .= " and leadpop_id = " . $leadpop_id;
              $s .= " and leadpop_type_id = " . $leadpop_type_id;
              $s .= " and leadpop_vertical_id = " . $vertical_id;
              $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
              $s .= " and leadpop_template_id = " . $leadpop_template_id;
              $s .= " and leadpop_version_id = " . $leadpop_version_id;
              $s .= " and leadpop_version_seq = " . $version_seq;
              $respics = $this->db->fetchRow($s);*/

            $respics = $leadpopLogos
                ->where("client_id", $client_id)
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_type_id", $leadpop_type_id)
                ->where("leadpop_vertical_id", $vertical_id)
                ->where("leadpop_vertical_sub_id", $subvertical_id)
                ->where("leadpop_template_id", $leadpop_template_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where("leadpop_version_seq", $version_seq)
                ->first();

            if ($respics) {
                $numpics = $respics['numpics'] + 1;
                $usedefault = $respics['use_default'];
            } else {
                $numpics = 1;
                $usedefault = "y";
            }

            $afiles['logo']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['logo']['name']);
            $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "__" . $globalRandStr . $afiles['logo']['name']);
            $section = substr($client_id, 0, 1);
            $logopath = $section . '/' . $client_id . '/logos/' . $logoname;

            if (env('APP_ENV') !== config('app.env_production')) {
                \Log::channel('myleads')->info("logo->temp_name: " . $afiles['logo']['tmp_name'] . " >> Exist?: " . file_exists($afiles['logo']['tmp_name']));
                \Log::channel('myleads')->info("Upload Path >> " . $logopath);
            }

            // Upload first image direct to rackspace and rest of the image via gearman
            if ($index == 0) {
                $cdn = move_uploaded_file_to_rackspace($afiles['logo']['tmp_name'], $logopath);
                $logopath = $cdn['rs_cdn'];

                $logo_color = $this->customizeRepositoryAdminThree->getLogoProminentColor($logopath);
                if (is_array($logo_color)) {
                    $logo_color = $logo_color[0];
                }

                if ($logo_color == "#272827") {
                    $logo_color = "#A8000D";
                }

                $first_processed_info['logopath'] = $logopath;
                $first_processed_info['logo_color'] = $logo_color;
                $first_processed_info['logo_type'] = $afiles['logo']['type'];
            } else {
                if (env('APP_ENV') === config('app.env_local')) {
                    $cdn = rackspace_copy_file_as($first_processed_info['logopath'], $logopath, $container);
                } else {
                    $cdn = rackspace_copy_file_as_with_gearman($first_processed_info['logopath'], $logopath, $container, $client_id, $lp);
                }

                $logopath = $cdn['rs_cdn'];
                $logo_color = $first_processed_info['logo_color'];
            }

            if (env('APP_ENV') !== config('app.env_production')) {
                \Log::channel('myleads')->info($cdn);
                \Log::channel('myleads')->info("Logo Path: " . $logopath);
                \Log::channel('myleads')->info("Logo Color: " . $logo_color);
            }

            //$imagetype = $afiles['logo']['type'];
            $imagetype = $first_processed_info['logo_type'];

            if ($imagetype != 'image/jpeg' && $imagetype != 'image/png' && $imagetype != 'image/gif') {
                return $this->errorResponse();
            }

            $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
            $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
            $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color, swatches, last_update) values (null,";
            $s .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $vertical_id . "," . $subvertical_id . ",";
            $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $version_seq . ",";
            $s .= "'" . $usedefault . "','" . $logoname . "','n'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "', '" . $swatches . "', " . time() . ") ";
            if($lp == $currentFunnelKey) {
                $this->db->query($s);
                $response = [
                    "id" => $this->db->lastInsertId(),
                    "image_src" => $cdn["client_cdn"]
                ];
            } else {
                Query::execute($s, $currentFunnelKey);
            }
            /*if ($gearmanQuery) {
                MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
            } else {
                $this->db->query($s);
            }*/


            $s = "update leadpop_logos  set numpics = " . $numpics;
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            Query::execute($s, $currentFunnelKey);
            /* if ($gearmanQuery) {
                 MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
             } else {
                 $this->db->query($s);
             }*/


            $s = "UPDATE clients_leadpops SET  last_edit = '" . date("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND leadpop_version_id  = " . $leadpop_version_id;
            $s .= " AND leadpop_version_seq  = " . $version_seq;
            Query::execute($s, $currentFunnelKey);
            /*  if ($gearmanQuery) {
                  MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
              } else {
                  $this->db->query($s);
              }*/

        }

        return $this->successResponse($response);
    }


    /**
     * Save/Upload New Combinator Logo Globally
     *
     * @param $afiles $_FILE Global variable
     * @param $post $_POST Global variable
     * @param $client_id
     * @param string $swatches
     * @return string
     * @throws Exception
     */
    function uploadGlobalCombineLogo($afiles, $post, $client_id, $swatches = '')
    {
        if (env('GEARMAN_ENABLE') == "1") $gearmanQuery = true;
        else $gearmanQuery = false;

        $lplist = explode(",", $post['selected_funnels']);
        $lplist = collect($lplist);

        // To ADD Source Funnel in Global QUE
        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);

        $lplist->prepend($currentFunnelKey);
        $lplist = $lplist->unique()->values()->all();

//        \DB::enableQueryLog();

        $first_processed_info = array();
        $globalRandStr = "global__" . $this->customizeRepositoryAdminThree->generateRandomString(5);
        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
        $leadpopLogos = GlobalHelper::getClientLogos($lpListCollection, $client_id);
        $response = [];

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            /*  $s = "select * from leadpops where id = " . $leadpop_id;
$lpres = $this->db->fetchRow($s);*/

            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();


            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            // Combine and resize
            $pre_image_style = explode("~", $post['pre-image-style']);
            $post_image_style = explode("~", $post['post-image-style']);

            if ($this->image_wrapper === null) {
                $wrapper_img = $this->_createCombineImages($pre_image_style[0], $pre_image_style[1], $post_image_style[0], $post_image_style[1], $afiles);
            } else {
                $wrapper_img = $this->image_wrapper;
            }

            /*  $logos = \DB::table("leadpop_logos")
                  ->where("client_id", $client_id)
                  ->where("leadpop_id", $leadpop_id)
                  ->where("leadpop_type_id", $leadpop_type_id)
                  ->where("leadpop_vertical_id", $vertical_id)
                  ->where("leadpop_vertical_sub_id", $subvertical_id)
                  ->where("leadpop_template_id", $leadpop_template_id)
                  ->where("leadpop_version_id", $leadpop_version_id)
                  ->where("leadpop_version_seq", $version_seq)
                  ->where("logo_src", "NOT LIKE", "%default/images/%")
                  ->where("logo_src", "NOT LIKE", "%itclix.com/images/%")
                  ->orderBy('id', 'ASC')
                  ->get();*/

            $logos = $leadpopLogos
                ->where("client_id", $client_id)
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_type_id", $leadpop_type_id)
                ->where("leadpop_vertical_id", $vertical_id)
                ->where("leadpop_vertical_sub_id", $subvertical_id)
                ->where("leadpop_template_id", $leadpop_template_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where("leadpop_version_seq", $version_seq)
                ->where("logo_src", "NOT LIKE", "%default/images/%")
                ->where("logo_src", "NOT LIKE", "%itclix.com/images/%")
                ->sortBy('id')
                ->all();

            $current_logo_count = count($logos);

            if (env('APP_ENV') !== config('app.env_production')) {
                \Log::channel('myleads')->info('[' . $lp . '] Existing Logo(s): ' . $current_logo_count);
                if ($logos) {
                    foreach ($logos as $r => $oneLogo) {
                        \Log::channel('myleads')->info('[' . $lp . ']: ..' . $r . '.. ' . $oneLogo->id . ' => ' . $oneLogo->logo_src . ' => ' . $oneLogo->use_me);
                    }
                }
            }

            # if user reaches update limit of 3 then delete the oldest inactive logo
            $num_of_logos_to_remove = $current_logo_count - 2;
            if ($num_of_logos_to_remove > 0) {
                foreach ($logos as $r => $oneLogo) {
                    if ($oneLogo->use_me == 'n') {
                        \Log::channel('myleads')->info('[' . $lp . ']: ..REMOVED.. ' . $oneLogo->id . ' => ' . $oneLogo->logo_src . ' => ' . $oneLogo->use_me);
                        // \DB::table("leadpop_logos")->where("id", $oneLogo->id)->delete();
                        $query = "DELETE from leadpop_logos where id = '$oneLogo->id'";
                        Query::execute($query, $currentFunnelKey);

                        @unlink($_SERVER['DOCUMENT_ROOT'] . '/images/clients/' . $client_id . '/logos/' . $oneLogo->logo_src);

                        $s = "insert into cron_delete_client_logos (id,client_id,logo_name,hasrun,daterun) values (null,";
                        $s .= $client_id . ",'" . $oneLogo->logo_src . "','n','')";
                        Query::execute($s, $currentFunnelKey);
                        /* if ($gearmanQuery) {
                             MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                         } else {
                             $this->db->query($s);
                         }*/

                        $num_of_logos_to_remove--;

                        if ($num_of_logos_to_remove == 0) break;
                    }
                }
            }

            /* $s = "select numpics,use_default from leadpop_logos ";
             $s .= " where client_id = " . $client_id;
             $s .= " and leadpop_id = " . $leadpop_id;
             $s .= " and leadpop_type_id = " . $leadpop_type_id;
             $s .= " and leadpop_vertical_id = " . $vertical_id;
             $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
             $s .= " and leadpop_template_id = " . $leadpop_template_id;
             $s .= " and leadpop_version_id = " . $leadpop_version_id;
             $s .= " and leadpop_version_seq = " . $version_seq;
             $respics = $this->db->fetchRow($s);
            */


            $respics = $leadpopLogos
                ->where("client_id", $client_id)
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_type_id", $leadpop_type_id)
                ->where("leadpop_vertical_id", $vertical_id)
                ->where("leadpop_vertical_sub_id", $subvertical_id)
                ->where("leadpop_template_id", $leadpop_template_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where("leadpop_version_seq", $version_seq)
                ->first();


            $numpics = $respics['numpics'] + 1;
            $usedefault = $respics['use_default'];
            $afiles['pre-image']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['pre-image']['name']);
            $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "__" . $globalRandStr . $afiles['pre-image']['name']);
            $section = substr($client_id, 0, 1);

            $logopath = $section . '/' . $client_id . '/logos/' . $logoname;
            $logopath = dir_to_str($logopath, true);

            if ($index == 0) {
                imagepng($wrapper_img, $logopath);
                $cdn = move_file_to_rackspace($logopath);       //Save file to tmp directory on local and on selection create swatches and then update leadpop_logos
                $logopath = $cdn['rs_cdn'];
                $logo_color = $this->customizeRepositoryAdminThree->getLogoProminentColor($logopath);

                if (is_array($logo_color)) {
                    $logo_color = $logo_color[0];
                }

                if ($logo_color == "#272827") {
                    $logo_color = "#A8000D";
                }

                //$rackspace_path = str_replace("rs_tmp/","", str_replace("~","/", $logopath));
                $first_processed_info['logopath'] = $logopath;
                $first_processed_info['logo_color'] = $logo_color;
            } else {
                $registry = DataRegistry::getInstance();
                $container = $registry->leadpops->clientInfo['rackspace_container'];

                $rackspace_path = str_replace("rs_tmp/", "", str_replace("~", "/", $logopath));
                rackspace_copy_file_as_with_gearman($first_processed_info['logopath'], $rackspace_path, $container, $client_id, "combinator--" . $lp);

                $logo_color = $first_processed_info['logo_color'];
            }

            $imagetype = 'image/png';
            if ($imagetype != 'image/jpeg' && $imagetype != 'image/png' && $imagetype != 'image/gif') {
                return $this->errorResponse();
            }

            $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
            $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
            $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color,last_update) values (null,";
            $s .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $vertical_id . "," . $subvertical_id . ",";
            $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $version_seq . ",";
            $s .= "'" . $usedefault . "','" . $logoname . "','n'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "', " . time() . ") ";

            if($lp == $currentFunnelKey) {
                $this->db->query($s);
                $response = [
                    "id" => $this->db->lastInsertId(),
                    "image_src" => $cdn["client_cdn"]
                ];
            } else {
                Query::execute($s, $currentFunnelKey);
            }

            $s = "update leadpop_logos  set numpics = " . $numpics;
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
//            $this->db->query($s);
            Query::execute($s, $currentFunnelKey);

        }
        return $this->successResponse($response);
    }

    private function _createCombineImages($preWidth, $preHeight, $postWidth, $postHeight, $afiles)
    {
        $src1_img_w = round(str_replace('px', '', $preWidth));
        $src1_img_h = round(str_replace('px', '', $preHeight));
        $src2_img_w = round(str_replace('px', '', $postWidth));
        $src2_img_h = round(str_replace('px', '', $postHeight));

        $src1_image = $this->customizeRepositoryAdminThree->_createImage($afiles['pre-image']);
        $src1_image = $this->customizeRepositoryAdminThree->resize_image($src1_image, $src1_img_w, $src1_img_h);
        $src1_img_w = imagesx($src1_image);
        $src1_img_h = imagesy($src1_image);

        $src2_image = $this->customizeRepositoryAdminThree->_createImage($afiles['post-image']);
        $src2_image = $this->customizeRepositoryAdminThree->resize_image($src2_image, $src2_img_w, $src2_img_h);
        $src2_img_w = imagesx($src2_image);
        $src2_img_h = imagesy($src2_image);

        $HIGHT = $src1_img_h;
        $Y1 = $Y2 = 0;
        if ($src2_img_h > $src1_img_h) {
            $HIGHT = $src2_img_h;
            $Y1 = ($src2_img_h - $src1_img_h) / 2;
        } else {
            $Y2 = ($src1_img_h - $src2_img_h) / 2;
        }


        $divider = imagecreatetruecolor(2, $HIGHT);
        $color = imagecolorallocate($divider, 211, 211, 211);
        imagefill($divider, 0, 0, $color);

        $IMG_W = $src1_img_w + $src2_img_w + $this->PAD * 2 + 2;
        $IMG_H = $HIGHT;

        $wrapper_img = imagecreatetruecolor($IMG_W, $IMG_H);
        $color = imagecolorallocatealpha($wrapper_img, 0, 0, 0, 127); //fill transparent back
        imagefill($wrapper_img, 0, 0, $color);

        imagecopymerge($wrapper_img, $src1_image, 0, $Y1, 0, 0, $src1_img_w, $src1_img_h, 100);
        imagecopymerge($wrapper_img, $divider, $this->PAD + $src1_img_w, $this->PAD, 0, $this->PAD, 2, $HIGHT, 100);
        imagecopymerge($wrapper_img, $src2_image, $this->PAD * 2 + $src1_img_w + 2, $Y2, 0, 0, $src2_img_w, $src2_img_h, 100);

        imagesavealpha($wrapper_img, true);

        return $wrapper_img;
    }

    private function getDefaultLogoName($leadpop_vertical_sub_id, $leadpop_version_id)
    {
        $registry = DataRegistry::getInstance();

        if ($registry->leadpops->clientInfo['is_fairway'] == 1)
            $trial_launch_defaults = "trial_launch_defaults_fairway";
        else if ($registry->leadpops->clientInfo['is_mm'] == 1)
            $trial_launch_defaults = "trial_launch_defaults_mm";
        else
            $trial_launch_defaults = "trial_launch_defaults";

        // get trial info from version_seq = 1 because if funnel is cloned manny times the higher version_seq not exist in trial tables
        $default = \DB::table($trial_launch_defaults)
            ->where("leadpop_vertical_sub_id", $leadpop_vertical_sub_id)
            ->where("leadpop_version_id", $leadpop_version_id)
            ->orderBy('leadpop_version_seq', 'asc')
            ->first();

        $defaultlogoname = '';
        if ($default) {
            $defaultlogoname = $default->logo_name;
        }
        return $defaultlogoname;
    }


    public function savegloballogo($data, $client_id)
    {
        // $this->savegloballogonew($data, $client_id);
        // return "ok";
    }


    public function activateDefaultlpimageGlobal($client_id, $adata)
    {
        $lplist = explode(",", $_POST['selected_funnels']);
        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        $lplist = json_decode(json_encode($lplist), 1);

        $scaling_properties = json_encode([
            'maxWidth' => config('leadpops.design.featureImage.maxAllowedWidthPx'),
            'scalePercentage' => config('leadpops.design.featureImage.sliderDefault')
        ]);

        array_unshift($lplist, $currentFunnelKey);
        $lplist = array_unique($lplist);

        $src_funnel_image = "";
        $rackspace_stock_assets = rackspace_stock_assets();
        extract($_POST, EXTR_OVERWRITE, "form_");
        $registry = DataRegistry::getInstance();
        if ($registry->leadpops->clientInfo['is_fairway'] == 1) $trial_launch_defaults = "trial_launch_defaults_fairway";
        else if ($registry->leadpops->clientInfo['is_mm'] == 1) $trial_launch_defaults = "trial_launch_defaults_mm";
        else $trial_launch_defaults = "trial_launch_defaults";

        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
        $trialLaunchCollection = GlobalHelper::getTrialLaunchCollection($trial_launch_defaults, $lpListCollection);
        $funnelVariables = GlobalHelper::getFunnelVariablesCollection($lpListCollection, $client_id);

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            $trialDefaults = $trialLaunchCollection
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_type_id", $leadpop_type_id)
                ->where("leadpop_vertical_id", $vertical_id)
                ->where("leadpop_vertical_sub_id", $subvertical_id)
                ->where("leadpop_template_id", $leadpop_template_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where("leadpop_version_seq", 1)
                ->first();

            if ($trialDefaults) {
                $imagename = $trialDefaults['image_name'];
                $imagesrc = $rackspace_stock_assets . config('rackspace.rs_featured_image_dir') . $imagename;

                if ($lp === $currentFunnelKey) $src_funnel_image = $imagesrc;

                $s = "update leadpop_images  set use_default = 'y',use_me = 'n' , image_src = '" . $imagename . "' , scaling_properties = '" . $scaling_properties . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                Query::execute($s, $currentFunnelKey);

                $design_variables =  [];
                $design_variables[FunnelVariables::FRONT_IMAGE] =  $imagesrc;
                $funnel_variables = $funnelVariables
                    ->where('client_id', $client_id)
                    ->where('leadpop_id', $leadpop_id)
                    ->where('leadpop_version_seq', $version_seq)
                    ->first();

                if ($funnel_variables) {
                    $funnel_variables = json_decode($funnel_variables['funnel_variables'], 1);

                    if ($design_variables) {
                        foreach ($design_variables as $key => $value) {
                            $funnel_variables[$key] = $value;
                        }
                        $s = "UPDATE clients_leadpops SET funnel_variables = '" . addslashes(json_encode($funnel_variables)) . "' ";
                        $s .= " WHERE client_id = " . $client_id;
                        $s .= " AND leadpop_id = " . $leadpop_id;
                        $s .= " AND leadpop_version_seq = " . $version_seq;

                        Query::execute($s, $currentFunnelKey);
//                          $this->db->query($s);
                        /*  echo $s;
                          echo "<br>";
                          echo "<br>";
                          echo "<br>";*/
                    }
                }
            }
        }

        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);
        if (!$client) {
            $s = "insert into global_settings (id,client_id,image,";
            $s .= "image_url,image_path) values (null,";
            $s .= $client_id . ",'','','') ";
            Query::execute($s, $currentFunnelKey);
        } else {
            $s = "update global_settings set image = '',image_url = '',image_path = '' ";
            $s .= " where client_id = " . $client_id;
            Query::execute($s, $currentFunnelKey);
        }
        $return_arr = array('imgsrc' => $src_funnel_image, 'imgpath' => "", 'imagename' => "");

        return $return_arr;
    }

    /**
     * @param $client_id
     * @param $adata $_POST variable
     * @return false|string|string[]
     * @throws Exception
     *
     * This function activate featured image globally for selected funnels in two ways
     *      - If reference funnel has default feature image then it will select default image from respective launcher table and will update in custom_vars
     *      - If image is user uploaded then it sync same image across all selected funnels.
     */
    public function activateFeaturedImageGlobally($client_id, $adata)
    {
        if (env('GEARMAN_ENABLE') == "1") $gearmanQuery = true;
        else $gearmanQuery = false;


        $lplist = explode(",", $_POST['selected_funnels']);

        $getCdnLink = getCdnLink();

        // Logic to add REFERENCE/SOURCE to list if not added.
        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        $lplist = json_decode(json_encode($lplist), 1);
        array_unshift($lplist, $currentFunnelKey);
        $lplist = array_unique($lplist);

        extract($_POST, EXTR_OVERWRITE, "form_");
        $registry = DataRegistry::getInstance();
        if ($registry->leadpops->clientInfo['is_fairway'] == 1) $trial_launch_defaults = "trial_launch_defaults_fairway";
        else if ($registry->leadpops->clientInfo['is_mm'] == 1) $trial_launch_defaults = "trial_launch_defaults_mm";
        else $trial_launch_defaults = "trial_launch_defaults";

        $trail_img = false;


        $s = "SELECT * FROM current_container_image_path WHERE cdn_type = 'default-assets'";
        $defaultCdn = $this->db->fetchRow($s);

        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
        $leadPopImages = GlobalHelper::getLeadpopImages($lpListCollection, $client_id);
        $trialLaunchCollection = GlobalHelper::getTrialLaunchCollection($trial_launch_defaults, $lpListCollection);



        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            /*  $s = "select * from leadpops where id = " . $leadpop_id;
              $lpres = $this->db->fetchRow($s);*/


            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            /*$s = "select * from $trial_launch_defaults where leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id  = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = 1";
            $trialDefaults = $this->db->fetchRow($s);*/


            $trialDefaults = $trialLaunchCollection
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_type_id", $leadpop_type_id)
                ->where("leadpop_vertical_id", $vertical_id)
                ->where("leadpop_vertical_sub_id", $subvertical_id)
                ->where("leadpop_template_id", $leadpop_template_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where("leadpop_version_seq", 1)
                ->first();


            if ($trialDefaults) {
                $defaultimagename = $trialDefaults['image_name'];

                // Pick setting of current/Reference funnel and based on that decide decide its default or user selected image
                $s = "select * from leadpop_images where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq . " LIMIT 1";
                $current_image = $this->db->fetchRow($s);


               /* $current_image = $leadPopImages
                    ->where("client_id", $client_id)
                    ->where("leadpop_id", $leadpop_id)
                    ->where("leadpop_type_id", $leadpop_type_id)
                    ->where("leadpop_vertical_id", $vertical_id)
                    ->where("leadpop_vertical_sub_id", $subvertical_id)
                    ->where("leadpop_template_id", $leadpop_template_id)
                    ->where("leadpop_version_id", $leadpop_version_id)
                    ->where("leadpop_version_seq", 1)
                    ->first();*/

                // Default Image
                if ($current_image && !empty($current_image)) {

                    if ($current_image['image_src'] == $defaultimagename || strpos($current_image['image_src'], $defaultimagename) !== false) {


                        $imagesrc = $defaultCdn['image_path'] . config('rackspace.rs_featured_image_dir') . $defaultimagename;

                        $s = "update leadpop_images  set use_default = 'y',use_me = 'n' ";
                    } // User selected image
                    else {
                        $imagesrc = $getCdnLink . '/pics/' . $current_image['image_src'];

                        $s = "update leadpop_images  set use_default = 'n',use_me = 'y' ";
                    }

                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
                    $s .= " and leadpop_vertical_id = " . $vertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
                    $s .= " and leadpop_version_id = " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    Query::execute($s, $currentFunnelKey);
                   /* echo "$s";
                    echo "<br>";
                    echo "<br>";
                    echo "<br>";
                    echo "<br>";*/


                    /*  if ($gearmanQuery) {
                          MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                      } else {
                          $this->db->query($s);
                      }*/

                    $customize = new CustomizeRepository($this->db);
                    $customize->updateFunnelVar(FunnelVariables::FRONT_IMAGE, $imagesrc, $client_id, $leadpop_id, $version_seq);
                }

            }
        }

        /*    $s = "select * from global_settings where client_id = " . $client_id;
            $client = $this->db->fetchRow($s);
            if (!$client) {
                $s = "insert into global_settings (id,client_id,image,";
                $s .= "image_url,image_path) values (null,";
                //$s .= $client_id.",'".addslashes($imagename)."','".addslashes($imagesrc)."','".addslashes($imagepath)."') ";
                $s .= $client_id . ",'','','') ";
                $this->db->query($s);
            } else {
                $s = "update global_settings set image = '',image_url = '',image_path = '' ";
                $s .= " where client_id = " . $client_id;
                $this->db->query($s);
            }*/


        $return_arr = array('imgsrc' => "", 'imgpath' => "", 'imagename' => "");
        if ($trail_img == true) {
            $return_arr['imgsrc'] = $imagesrc;
            $return_arr['imgpath'] = $imagepath;
            $return_arr['imagename'] = $imagename;
        }

        return $return_arr;
    }

    public function deactivateFeaturedImageGlobally($client_id, $adata)
    {
        if (env('GEARMAN_ENABLE') == "1") $gearmanQuery = true;
        else $gearmanQuery = false;


        $lplist = explode(",", $_POST['selected_funnels']);


        // Logic to add REFERENCE/SOURCE to list if not added.
        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        $lplist = json_decode(json_encode($lplist), 1);
        array_unshift($lplist, $currentFunnelKey);
        $lplist = array_unique($lplist);


        extract($_POST, EXTR_OVERWRITE, "form_");
        $gf_image_active_val = (isset($adata["gf_image_active"]) && $adata["gf_image_active"]) ? "y" : "n";
        $registry = DataRegistry::getInstance();

        $trail_img = false;


        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            /*  $s = "select * from leadpops where id = " . $leadpop_id;
$lpres = $this->db->fetchRow($s);*/

            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];


            $s = "update leadpop_images  set use_default = 'n',use_me = 'n'";

            // setting empty image_src column value when image is deleted and didn't browse any image after delete
            if (isset($_POST['delete_image']) && $_POST['delete_image'] == 1 && (!isset($_FILES["logo"]) || $_FILES["logo"]["name"] == "")) {
                $s .= ", image_src = '' ";
            }

            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;

            /*  if ($gearmanQuery) {
                  MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
              } else {
                  $this->db->query($s);
              }*/
            Query::execute($s, $currentFunnelKey);

            $customize = new CustomizeRepository($this->db);
            $customize->updateFunnelVar(FunnelVariables::FRONT_IMAGE, "", $client_id, $leadpop_id, $version_seq);


        }
        return 'ok';
    }

    public function changelplogo($client_id, $adata, $funnel_data = array())
    {
        if (env('GEARMAN_ENABLE') == "1") $gearmanQuery = true;
        else $gearmanQuery = false;

        $registry = DataRegistry::getInstance();
        $container = $registry->leadpops->clientInfo['rackspace_container'];

        if (!empty($funnel_data)) {
            $referred_vertical_id = $funnel_data["leadpop_vertical_id"];
            $referred_subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $referred_leadpop_id = $funnel_data["leadpop_id"];
            $referred_version_seq = $funnel_data["leadpop_version_seq"];
        } else {

            $referred_vertical_id = $registry->leadpops->customVertical_id;
            $referred_subvertical_id = $registry->leadpops->customSubvertical_id;
            $referred_leadpop_id = $registry->leadpops->customLeadpopid;
            $referred_version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $lplist = explode(",", $_POST['selected_funnels']);
        $lplist = collect($lplist);

        // To ADD Source Funnel in Global QUE
        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        if (isset($_POST['current_hash'])) {
            $lplist->prepend($currentFunnelKey);
            $lplist = $lplist->unique()->values()->all();
        }


        // one Time Queries
        $rackspace_stock_assets = rackspace_stock_assets();
        $getCdnLink = getCdnLink();

        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);


        $clientlogo = GlobalHelper::getClientLogoByLogoSource($adata['logo_id'], $adata['logo_source']);

        $leadpopBackgroundColor = GlobalHelper::getLeadpopBackgroudColor($lpListCollection, $client_id);


        $submissionOptions = GlobalHelper::getSubmissionOptions($lpListCollection, $client_id);


        $leadpopLogos = GlobalHelper::getClientLogos($lpListCollection, $client_id);


        $s = "select is_mm from clients where client_id = " . $client_id . "";
        $is_mm = $this->db->fetchOne($s);


        //for FW specific Logo
        $s = "select is_fairway from clients where client_id = " . $client_id . "";
        $is_fairway = $this->db->fetchOne($s);

        if ($adata['logo_source'] == 'client' ||
            $adata['logo_source'] == 'default') {
            $leadPopVerticals = GlobalHelper::getLeadpopsVerticals($lpListCollection, $client_id);
            $defaultLogoColors =  GlobalHelper::getDefaultLogoColor($lpListCollection);
            $leadpop_ids = implode(',', $lpListCollection->pluck('leadpop_id')->unique()->all());
            $allSixnines = GlobalHelper::getLeadLineCollection($leadpop_ids, FunnelVariables::LEAD_LINE, $client_id);
        }


        $scaling_properties = $adata["scaling_properties"] ?? "";
        foreach ($lplist as $index => $lp) {
            if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('====== [ changelplogo # ' . $index . ' ==> ' . $lp . ' ] ======');
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            /*  $s = "select * from leadpops where id = " . $leadpop_id;
    $lpres = $this->db->fetchRow($s);*/

            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            if ($adata['logo_source'] == 'client') {

                /* $s = "select logo_src from leadpop_logos where id = " . $adata['logo_id'];
                 $clientlogo = $this->db->fetchOne($s);*/

                $logosrc = strval($getCdnLink) . "/logos/" . strval($clientlogo['logo_src']);
                //   $logosrc = "https://images.lp-imagesdev.com/images1/8/8514//logos/8514_181_2_3_84_90_90_1_default.png";
              //  var_dump($logosrc);


                $s = "update leadpop_logos  set use_default = 'n',use_me = 'n' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                Query::execute($s, $currentFunnelKey);
                /* if ($gearmanQuery) {
                     MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                 } else {
                     $this->db->query($s);
                 }*/


                // Check if looped funnel is not referred funnel
                if ($vertical_id == $referred_vertical_id &&
                    $subvertical_id == $referred_subvertical_id &&
                    $leadpop_id == $referred_leadpop_id &&
                    $version_seq == $referred_version_seq
                ) {
                    $s = "update leadpop_logos  set use_me = 'y', swatches = '" . $adata['swatches']  . "', scaling_properties = '" . $scaling_properties . "' ";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and id = " . $adata['logo_id'];
                    Query::execute($s, $currentFunnelKey);
                    /*if ($gearmanQuery) {
                        MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                    } else {
                        $this->db->query($s);
                    }*/


                    if (env('APP_ENV') !== config('app.env_production'))
                        \Log::channel('myleads')->info('[' . $index . ' ==> ' . json_encode($lp) . '] = its Source Logo -- Just Update DB Row => ' . $adata['logo_id']);
                } else {


                    /**
                     * Use Case:
                     *      From Global Screen User dragged an image to enable it. But currently coded code is not optimized
                     *      we are uploading images everytime on logo change
                     *
                     *      Instead if should do this...
                     *          1) Find if we already have logo uploaded on rackspace then just enable it
                     *          2) If logo is not there then upload and enable it
                     *
                     */

                    ## IF logo has __global__ in name then lookup in DB we have same name image for current funnel
                    $upload_logo_cdn = true;
                    $logoname = "";
                    if (strpos($clientlogo['logo_src'], "__global__") !== false) {
                        $arr = explode("__global__", $clientlogo['logo_src']);
                        $name2s = end($arr);
                        $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "__global__" . $name2s);


                        // DB Lookup
                        // \DB::enableQueryLog();
                        /*  $existingLogo = \DB::table("leadpop_logos")
                              ->where("client_id", $client_id)
                              ->where("leadpop_id", $leadpop_id)
                              ->where("leadpop_type_id", $leadpop_type_id)
                              ->where("leadpop_vertical_id", $vertical_id)
                              ->where("leadpop_vertical_sub_id", $subvertical_id)
                              ->where("leadpop_template_id", $leadpop_template_id)
                              ->where("leadpop_version_id", $leadpop_version_id)
                              ->where("leadpop_version_seq", $version_seq)
                              ->where('logo_src', '=', $logoname)
                              ->orderBy('id', 'asc')
                              ->get();
                          $upload_logo_cdn = count($existingLogo) > 0 ? false : true;*/


                        $existingLogo = $leadpopLogos
                            ->where("client_id", $client_id)
                            ->where("leadpop_id", $leadpop_id)
                            ->where("leadpop_type_id", $leadpop_type_id)
                            ->where("leadpop_vertical_id", $vertical_id)
                            ->where("leadpop_vertical_sub_id", $subvertical_id)
                            ->where("leadpop_template_id", $leadpop_template_id)
                            ->where("leadpop_version_id", $leadpop_version_id)
                            ->where("leadpop_version_seq", $version_seq)
                            ->where('logo_src', '=', $logoname)
                            ->sortBy('id')
                            ->all();

                        $upload_logo_cdn = count($existingLogo) > 0 ? false : true;

                    }


                    # Use Case # 1 - Find Logo if its already uploaded
                    if (!$upload_logo_cdn) {
                        if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('[' . $index . ' ==> ' . $lp . '] = Global Que -- Logo found in DB uploaded via Global mode - Update DB Row => ' . $logoname);

                        $s = "update leadpop_logos  set use_me = 'y', swatches = '" . $adata['swatches'] . "', scaling_properties = '" . $scaling_properties . "' ";
                        $s .= " where client_id = " . $client_id;
                        $s .= " and leadpop_id = " . $leadpop_id;
                        $s .= " and leadpop_type_id = " . $leadpop_type_id;
                        $s .= " and leadpop_vertical_id = " . $vertical_id;
                        $s .= " and leadpop_vertical_id = " . $vertical_id;
                        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                        $s .= " and leadpop_template_id = " . $leadpop_template_id;
                        $s .= " and leadpop_version_id = " . $leadpop_version_id;
                        $s .= " and leadpop_version_seq = " . $version_seq;
                        $s .= " and logo_src = '" . $logoname . "'";

                        Query::execute($s, $currentFunnelKey);
                        /* if ($gearmanQuery) {
                             MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                         } else {
                             $this->db->query($s);
                         }*/


                        if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('[' . $index . ' ==> ' . $lp . '] = ' . $s);

                    } # Use Case # 2 - Logo is missing so Upload & enable logo
                    else {
                        if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('[' . $index . ' ==> ' . $lp . '] = Global Que -- This logo is not present in current funnel. Lets Upload and Enable it');
                        $arr = explode("_", $clientlogo['logo_src']);
                        $name2s = end($arr);

                        $afileslogoname = preg_replace('/[^\.a-zA-Z0-9]/', '', $name2s);
                        $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "_" . $afileslogoname);
                        $section = substr($client_id, 0, 1);
                        $logopath = $section . '/' . $client_id . '/logos/' . $logoname;

                        ### $cdn = rackspace_copy_file_as($logosrc, $logopath);
                        $cdn = rackspace_copy_file_as_with_gearman($logosrc, $logopath, $container, $client_id, "activate--" . $lp);
                        $logopath = $cdn['rs_cdn'];

                        $defaultlogoname = $this->getDefaultLogoName($subvertical_id, $leadpop_version_id);

                        /* $logos = \DB::table("leadpop_logos")
                             ->where("client_id", $client_id)
                             ->where("leadpop_id", $leadpop_id)
                             ->where("leadpop_type_id", $leadpop_type_id)
                             ->where("leadpop_vertical_id", $vertical_id)
                             ->where("leadpop_vertical_sub_id", $subvertical_id)
                             ->where("leadpop_template_id", $leadpop_template_id)
                             ->where("leadpop_version_id", $leadpop_version_id)
                             ->where("leadpop_version_seq", $version_seq)
                             ->where('logo_src', '!=', $defaultlogoname)
                             ->where("logo_src", "NOT LIKE", "%default/images/%")
                             ->where("logo_src", "NOT LIKE", "%itclix.com/images/%")
                             ->orderBy('id', 'asc')
                             ->get();*/

                        $logos = $leadpopLogos
                            ->where("client_id", $client_id)
                            ->where("leadpop_id", $leadpop_id)
                            ->where("leadpop_type_id", $leadpop_type_id)
                            ->where("leadpop_vertical_id", $vertical_id)
                            ->where("leadpop_vertical_sub_id", $subvertical_id)
                            ->where("leadpop_template_id", $leadpop_template_id)
                            ->where("leadpop_version_id", $leadpop_version_id)
                            ->where("leadpop_version_seq", $version_seq)
                            ->where('logo_src', '!=', $defaultlogoname)
                            ->where("logo_src", "NOT LIKE", "%default/images/%")
                            ->where("logo_src", "NOT LIKE", "%itclix.com/images/%")
                            ->sortBy('id')
                            ->all();


                        $current_logo_count = count($logos);
                        if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('#4.4 - ImageCount: ' . $current_logo_count);

                        $num_of_logos_to_remove = $current_logo_count - 2;
                        if ($num_of_logos_to_remove > 0) {

                            foreach ($logos as $r => $oneLogo) {
                                if ($oneLogo->use_me == 'n') {

                                    // \DB::table("leadpop_logos")->where("id", $oneLogo->id)->delete();
                                    $query = "DELETE from leadpop_logos where id = '$oneLogo->id'";
                                    Query::execute($query, $currentFunnelKey);

                                    if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('#4.4.2 - ' . $_SERVER['DOCUMENT_ROOT'] . '/images/clients/' . $client_id . '/logos/' . $oneLogo->logo_src);
                                    // @unlink($_SERVER['DOCUMENT_ROOT'] . '/images/clients/' . $client_id . '/logos/' . $oneLogo->logo_src);

                                    $s = "insert into cron_delete_client_logos (id,client_id,logo_name,hasrun,daterun) values (null,";
                                    $s .= $client_id . ",'" . $oneLogo->logo_src . "','n','')";
                                    if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('#4.4.3 - ' . $s);
                                    Query::execute($s, $currentFunnelKey);
                                    /*if ($gearmanQuery) {
                                        MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                                    } else {
                                        $this->db->query($s);
                                    }*/

                                    $num_of_logos_to_remove--;

                                    if ($num_of_logos_to_remove == 0) break;
                                }
                            }
                        }

                        /* $s = "select numpics,use_default from leadpop_logos ";
                         $s .= " where client_id = " . $client_id;
                         $s .= " and leadpop_id = " . $leadpop_id;
                         $s .= " and leadpop_type_id = " . $leadpop_type_id;
                         $s .= " and leadpop_vertical_id = " . $vertical_id;
                         $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                         $s .= " and leadpop_template_id = " . $leadpop_template_id;
                         $s .= " and leadpop_version_id = " . $leadpop_version_id;
                         $s .= " and leadpop_version_seq = " . $version_seq;
                         $respics = $this->db->fetchRow($s);*/


                        $respics = $leadpopLogos
                            ->where("client_id", $client_id)
                            ->where("leadpop_id", $leadpop_id)
                            ->where("leadpop_type_id", $leadpop_type_id)
                            ->where("leadpop_vertical_id", $vertical_id)
                            ->where("leadpop_vertical_sub_id", $subvertical_id)
                            ->where("leadpop_template_id", $leadpop_template_id)
                            ->where("leadpop_version_id", $leadpop_version_id)
                            ->where("leadpop_version_seq", $version_seq)
                            ->first();


                        if ($respics) {
                            $numpics = $respics['numpics'] + 1;
                        } else {
                            $numpics = 1;
                        }


                        $usedefault = 'n';

                        /*$s = "select logo_src, ini_logo_color from leadpop_logos where id = " . $adata['logo_id'];
                        $clientlogo = $this->db->fetchRow($s);*/


                        $logo_color = $clientlogo['ini_logo_color'];

                        $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
                        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
                        $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color, swatches, last_update, scaling_properties) values (null,";
                        $s .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $vertical_id . "," . $subvertical_id . ",";
                        $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $version_seq . ",";
                        $s .= "'" . $usedefault . "','" . $logoname . "','y'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "', '" . $adata['swatches'] . "', '" . time() . "', '" . addslashes($scaling_properties) . "'" .  ") ";
                        Query::execute($s, $currentFunnelKey);
                        /* if ($gearmanQuery) {
                            MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                        } else {
                            $this->db->query($s);
                        }*/
                    }
                }


                $s1 = "update current_logo set logo_src = '" . $logosrc . "' ";
                $s1 .= " where client_id = " . $client_id;
                $s1 .= " and leadpop_id = " . $leadpop_id;
                $s1 .= " and leadpop_vertical_id = " . $vertical_id;
                $s1 .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s1 .= " and leadpop_type_id = " . $leadpop_type_id;
                $s1 .= " and leadpop_template_id = " . $leadpop_template_id;
                $s1 .= " and leadpop_version_id  	= " . $leadpop_version_id;
                $s1 .= " and leadpop_version_seq = " . $version_seq;
                Query::execute($s1, $currentFunnelKey);
                /*  if ($gearmanQuery) {
                      MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                  } else {
                      $this->db->query($s);
                  }*/


            } else if ($adata['logo_source'] == 'default') {


                $s = "update leadpop_logos set use_default = 'y', use_me = 'n' , default_colored = 'n', swatches = '" . $adata['swatches'] . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                Query::execute($s, $currentFunnelKey);
                /* if ($gearmanQuery) {
                     MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                 } else {
                     $this->db->query($s);
                 }*/
            }


            $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq);

            if ($adata['logo_source'] == 'client' || $adata['logo_source'] == 'default') {

                /*$s = "select lead_pop_vertical from leadpops_verticals where  id = $vertical_id";
                $vertical = $this->db->fetchRow($s);*/

                $vertical = $leadPopVerticals->where('id', $vertical_id)->first();

                $verticalName = strtolower(str_replace(' ', '', $vertical['lead_pop_vertical']));
                $subverticalName = ""; //strtolower(str_replace(' ', '', $subverticalName));

             /*   $s = "select default_logo_color from stock_leadpop_logos  where  leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $logo_color = $this->db->fetchOne($s);*/


                $logo_color = $defaultLogoColors->where('leadpop_vertical_id', $vertical_id)
                    ->where('leadpop_vertical_sub_id', $subvertical_id)
                    ->where('leadpop_version_id', $leadpop_version_id)
                    ->first();

                $logo_color = $logo_color['logo_color']  ?? '';

                if ($adata['logo_source'] == 'default') {
                    $defaultlogoname = $this->getDefaultLogoName($subvertical_id, $leadpop_version_id);


                    if ($subverticalName == "") {
//                        $logosrc = $getCdnLink . '/images/' . @$verticalName . '/' . $this->getDefaultLogoName($subvertical_id, $leadpop_version_id);
                        $logosrc = $getCdnLink . '/images/' . @$verticalName . '/' . $defaultlogoname;
                    } else {
                        $subverticalName = str_replace(' ', '', $subverticalName);
//                        $logosrc = $getCdnLink . '/images/' . @$verticalName . '/' . $subverticalName . '_logos/' . $this->getDefaultLogoName($subvertical_id, $leadpop_version_id);
                        $logosrc = $getCdnLink . '/images/' . @$verticalName . '/' . $subverticalName . '_logos/' . $defaultlogoname;
                    }

                    $s = "update current_logo set logo_src = '" . $defaultlogoname . "'";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_vertical_id = " . $vertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
                    $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    Query::execute($s, $currentFunnelKey);
                    /* if ($gearmanQuery) {
                         MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                     } else {
                         $this->db->query($s);
                     }*/

                } else if ($adata['logo_source'] == 'client') { // new change ini_logo_color
                    /* $s = "select logo_src, ini_logo_color from leadpop_logos where id = " . $adata['logo_id'];
                     $clientlogo = $this->db->fetchRow($s);*/


                    if ($is_mm == 1 && $clientlogo['ini_logo_color'] == "#272827") {
                        $clientlogo['ini_logo_color'] = "#A8000D";
                    }


                    if ($is_fairway == 1 && $logo_color == "#94D60A") {
                        $logo_color = "#18563E";
                    }

                    $s = "update leadpop_logos set logo_color = '" . $clientlogo['ini_logo_color'] . "'";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and id = " . $adata['logo_id'];
                    Query::execute($s, $currentFunnelKey);
                    /*  if ($gearmanQuery) {
                          MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                      } else {
                          $this->db->query($s);
                      }*/

                    // changed from $this->getHttpServer() to $this->getHttpAdminServer 3/25/2016 robert
                    //$logosrc = $this->getHttpServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$clientlogo['logo_src'];
                    $logosrc = $getCdnLink . '/logos/' . $clientlogo['logo_src'];
                    $logo_color = $clientlogo['ini_logo_color'];

                }

              //  $sixnine = $this->customizeRepositoryAdminThree->getLeadLine($client_id, $leadpop_id, $version_seq, FunnelVariables::LEAD_LINE);

                $sixnine = $allSixnines
                    ->where('client_id', $client_id)
                    ->where('leadpop_id', $leadpop_id)
                    ->where('leadpop_version_seq', $version_seq)
                    ->first();


//                if ($sixnine != "") {
                if ($sixnine && $sixnine[FunnelVariables::LEAD_LINE] != "") {
                    $sixnine = $sixnine[FunnelVariables::LEAD_LINE];
                    $sixnine = str_replace(';;', ';', $sixnine);
                    $sixnine = str_replace(': #', ':#', $sixnine);
                    $first = strpos($sixnine, 'color:#');
                    $first += 6;
                    $sec = strpos($sixnine, '>', $first);
                    $sec -= 1;
                    $toreplace = substr($sixnine, $first, ($sec - $first));
                    $sixnine = str_replace($toreplace, $logo_color, $sixnine);

                    $this->customizeRepositoryAdminThree->updateLeadLine(FunnelVariables::LEAD_LINE, $sixnine, $client_id, $leadpop_id, $version_seq);
                }

                $image_location = $rackspace_stock_assets . "images/dot-img.png";
                $favicon_location = $rackspace_stock_assets . "images/favicon-circle.png";
                $mvp_dot_location = $rackspace_stock_assets . "images/ring.png";
                $mvp_check_location = $rackspace_stock_assets . "images/mvp-check.png";

                $colored_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_dot_img.png';
                $favicon_dst_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_favicon-circle.png';
                $mvp_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_ring.png';
                $mvp_check_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_mvp-check.png';

                if (isset($logo_color) && $logo_color != "") {
                    $new_clr = $this->customizeRepositoryAdminThree->hex2rgb($logo_color);
                }

                # this was not being used anywhere in code
                // $im = imagecreatefrompng($image_location);
               /* $myRed = $new_clr[0];
                $myGreen = $new_clr[1];
                $myBlue = $new_clr[2];*/


                $myRed = $new_clr[0] ?? '#3c489e';
                $myGreen = $new_clr[1] ?? '#3c489e';
                $myBlue = $new_clr[2] ?? '#3c489e';

                ## This code is taking too much time in loop so moving this code to Rackspace so it process in background
                /*
                $this->customizeRepositoryAdminThree->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
                $this->customizeRepositoryAdminThree->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
                $this->customizeRepositoryAdminThree->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
                $this->customizeRepositoryAdminThree->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);
                */

                // In replacement of above
                if (getenv('APP_ENV') != "local") {
                    MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $image_location, $myRed, $myGreen, $myBlue, $colored_dot_src, $client_id, "icons--" . $lp);
                    MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src, $client_id, "icons--" . $lp);
                    MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src, $client_id, "icons--" . $lp);
                    MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src, $client_id, "icons--" . $lp);
                }
            }

            $colored_dot = $getCdnLink . '/logos/' . $filename . '_dot_img.png';
            $favicon_dst = $getCdnLink . '/logos/' . $filename . '_favicon-circle.png';
            $mvp_dot = $getCdnLink . '/logos/' . $filename . '_ring.png';
            $mvp_check = $getCdnLink . '/logos/' . $filename . '_mvp-check.png';


            $design_variables = array();
            $design_variables[FunnelVariables::LOGO_SRC] = $logosrc;
            $design_variables[FunnelVariables::LOGO_COLOR] = $logo_color;
            $design_variables[FunnelVariables::COLORED_DOT] = $colored_dot;
            $design_variables[FunnelVariables::MVP_DOT] = $mvp_dot;
            $design_variables[FunnelVariables::MVP_CHECK] = $mvp_check;
            $design_variables[FunnelVariables::FAVICON_DST] = $favicon_dst;

            $this->customizeRepositoryAdminThree->updateFunnelVariables($design_variables, $client_id, $leadpop_id, $version_seq);


            if (env('APP_ENV') === config('app.env_local')) {
                $leadpop_background_swatches = 'leadpop_background_swatches';
            } else {
                $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
            }

            $s = "delete from " . $leadpop_background_swatches;
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            Query::execute($s, $currentFunnelKey);

            if ($adata['logo_source'] == 'client') {

                $swatches = $adata["swatches"];

                if ($swatches) {

                    $result = explode("#", $swatches);
                    $new_color = $this->customizeRepositoryAdminThree->hex2rgb($logo_color);
                    $index = 0;
                    array_unshift($result, implode('-', $new_color));

                    // SET BACKGROUND COLOR
                    $background_from_logo = '/*###>*/background-color: rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1);/*@@@*/
			background-image: linear-gradient(to right bottom,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 0%,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 100%); /* W3C */';

                    /* $s = " select * from leadpop_background_color where client_id = " . $client_id;
                     $s .= " and leadpop_vertical_id = " . $vertical_id;
                     $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                     $s .= " and leadpop_type_id = " . $leadpop_type_id;
                     $s .= " and leadpop_template_id = " . $leadpop_template_id;
                     $s .= " and leadpop_id = " . $leadpop_id;
                     $s .= " and leadpop_version_id = " . $leadpop_version_id;
                     $s .= " and leadpop_version_seq = " . $version_seq;
                     $s .= " and active_backgroundimage = 'y'";
                     $_count = $this->db->fetchAll($s);*/

                    $_count = $leadpopBackgroundColor->where('client_id', $client_id)
                        ->where('leadpop_vertical_id', $vertical_id)
                        ->where('leadpop_vertical_sub_id', $subvertical_id)
                        ->where('leadpop_type_id', $leadpop_type_id)
                        ->where('leadpop_template_id', $leadpop_template_id)
                        ->where('leadpop_id', $leadpop_id)
                        ->where('leadpop_version_id', $leadpop_version_id)
                        ->where('leadpop_version_seq', $version_seq)
                        ->where('active_backgroundimage', 'y')->count();

                    /*   echo "<pre>";
                      print_r($_count);
                       print_r($_count1);
                       echo '=========================================================';
                      echo "</pre>";*/


                    if ($_count) {
                        $active_backgroundimage = 'y';
                        $background_type = config('lp.leadpop_background_types.BACKGROUND_IMAGE');
                    } else {
                        $active_backgroundimage = 'n';
                        $background_type = config('lp.leadpop_background_types.LOGO_COLOR');
                    }
                    $s = "update leadpop_background_color set background_color = '" . addslashes($background_from_logo) . "' ,
                        active_backgroundimage = '" . $active_backgroundimage . "',
                        background_type = $background_type, active = 'y' , default_changed = 'y'
                        WHERE client_id = $client_id
                        and leadpop_version_id  = $leadpop_version_id
                        and leadpop_version_seq = $version_seq";
                    Query::execute($s, $currentFunnelKey);
                    /* if ($gearmanQuery) {
                         MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                     } else {
                         $this->db->query($s);
                     }*/


                    foreach ($result as $key => $value) {

                        list($red, $green, $blue) = explode("-", $value);

                        if ($key < 1) {
                            $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";
                        } else {
                            $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                        }

                        $str1 = "linear-gradient(to top, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                        $str2 = "linear-gradient(to bottom right, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";

                        /**
                         * It appears that swatches order matter and first swatch was intentionally made solid above with opacity=1 in $str0,
                         * that resulted in a duplicate swatch and a total of 27 swatches were being generated instead of 28
                         * to fix that without changing swatch generation order, I had to add this $key < 1 here too
                         */
                        if ($key < 1) {
                            $str3 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                        } else {
                            $str3 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";
                        }

                        $swatches = array($str0, $str1, $str2, $str3);
                        //debug($swatches);
                        for ($i = 0; $i < 4; $i++) {
                            $index++;
                            $is_primary = 'n';
                            $backgroundSwatch = addslashes($swatches[$i]);

                            if ($index == 1) {
                                $is_primary = 'y';
                                /*  LeadpopBackgroundColor::where([
                                      'client_id' => $client_id,
                                      'leadpop_vertical_id' => $vertical_id,
                                      'leadpop_vertical_sub_id' => $subvertical_id,
                                      'leadpop_type_id' => $leadpop_type_id,
                                      'leadpop_template_id' => $leadpop_template_id,
                                      'leadpop_id' => $leadpop_id,
                                      'leadpop_version_id' => $leadpop_version_id,
                                      'leadpop_version_seq' => $version_seq
                                  ])->update([
                                      'background_color' => $backgroundSwatch,
                                      'background_type' => '1'
                                  ]);*/

                                $query = "UPDATE leadpop_background_color set background_color = '" . addslashes($backgroundSwatch) . "',
                                  background_type = '1'
                                  WHERE client_id = '$client_id'
                                  and leadpop_version_id = '$leadpop_version_id'
                                  and leadpop_version_seq = '$version_seq'
";
                                Query::execute($query, $currentFunnelKey);
                            }
                            $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                            $s .= "swatch,is_primary,active) values (null,";
                            $s .= $client_id . "," . $vertical_id . ",";
                            $s .= $subvertical_id . ",";
                            $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
                            $s .= $leadpop_id . ",";
                            $s .= $leadpop_version_id . ",";
                            $s .= $version_seq . ",";
                            $s .= "'" . $backgroundSwatch . "',";
                            $s .= "'" . $is_primary . "','y')";
                            Query::execute($s, $currentFunnelKey);
                            /* if ($gearmanQuery) {
                                 MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                             } else {
                                 $this->db->query($s);
                             }*/
                        }

                    }
                }

                // UPdate Thankyou page

                /*$s = "select * from submission_options ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $submissionOptions = $this->db->fetchRow($s);*/

                $submissionOption = $submissionOptions->where('client_id', $client_id)
                    ->where('leadpop_vertical_id', $vertical_id)
                    ->where('leadpop_vertical_sub_id', $subvertical_id)
                    ->where('leadpop_type_id', $leadpop_type_id)
                    ->where('leadpop_template_id', $leadpop_template_id)
                    ->where('leadpop_id', $leadpop_id)
                    ->where('leadpop_version_id', $leadpop_version_id)
                    ->where('leadpop_version_seq', $version_seq)->first();


                if ($submissionOption) {
                    $thankyou = $submissionOption['thankyou'];
                    if ($submissionOption['thankyou_logo'] == 1) {
                        $thankyou = preg_replace('/<p(?=[^>]*id="defaultLogoContainer")(.*?)>(.*?)<\/p>/', '', $thankyou);
                        $thankyou = preg_replace('/<img(?=[^>]*id="defaultLogo")(.*?)>/', '', $thankyou);

                        $logo = '<p id="defaultLogoContainer" style="text-align: center;"><img alt="" id="defaultLogo" style="max-width: 350px; max-height: 120px;" src="' . $logosrc . '"></p>';
                        $thankyou = $logo . $thankyou;
                        $s = "UPDATE submission_options SET thankyou = '" . addslashes($thankyou) . "' WHERE id = " . $submissionOption['id'];
                        Query::execute($s, $currentFunnelKey);
                        /* if ($gearmanQuery) {
                             MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                         } else {
                             $this->db->query($s);
                         }*/
                    }
                }


            }
        }

        return true;
    }

    public function updateThankYouPageLogo($new_logo_url, $funnel_data)
    {
        $s = "select * from submission_options ";
        $s .= " where client_id = " . $funnel_data['client_id'];
        $s .= " and leadpop_version_id = " . $funnel_data['leadpop_version_id'];
        $s .= " and leadpop_version_seq = " . $funnel_data['leadpop_version_seq'];
        $submissionOptions = $this->db->fetchRow($s);

        if ($submissionOptions) {
            $thankyou = $submissionOptions['thankyou'];
            if ($submissionOptions['thankyou_logo'] == 1) {
                $thankyou = preg_replace('/<p(?=[^>]*id="defaultLogoContainer")(.*?)>(.*?)<\/p>/', '', $thankyou);
                $thankyou = preg_replace('/<img(?=[^>]*id="defaultLogo")(.*?)>/', '', $thankyou);

                $logo = '<p id="defaultLogoContainer" style="text-align: center;"><img alt="" id="defaultLogo" style="max-width: 350px; max-height: 120px;" src="' . $new_logo_url . '"></p>';
                $thankyou = $logo . $thankyou;
                $s = "UPDATE submission_options SET thankyou = '" . addslashes($thankyou) . "' WHERE id = " . $submissionOptions['id'];
                $this->db->query($s);
            }
        }


    }


    /**
     * @param $client_id
     * @param $lplist
     * @param $column
     */
    public function getLeadLineCollection($client_id, $lplist, $column = 'lead_line')
    {
        $collectedData = $this->createLpCollection($lplist);

        // setup comma seperated data convert multiple queries into one query
        $leadpop_ids = implode(',', $collectedData->pluck('leadpop_id')->unique()->all());
        $leadpop_version_seq_ids = implode(',', $collectedData->pluck('leadpop_version_seq')->unique()->all());

        $s = "SELECT id, " . $column . " FROM clients_leadpops ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id in ( " . $leadpop_ids . " )";
        $s .= " AND leadpop_version_seq in ( = " . $leadpop_version_seq_ids . " )";

        $res = $this->db->fetchAll($s);

        return collect($res);

        /* $variable = $res[$column];
         return $variable;*/
    }


    function backgroundOptionsToggle()
    {
        $lplist = explode(",", $_POST['selected_funnels']);
        $lplist = collect($lplist);

        // To ADD Source Funnel in Global QUE
        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        if (isset($_POST['current_hash'])) {
            $lplist->prepend($currentFunnelKey);
            $lplist = $lplist->unique()->values()->all();
        }

        $client_id = $_POST['client_id'];
        $thelink = $_POST['thelink'];

        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
        $leadpopBackgroundColor = GlobalHelper::getLeadpopBackgroundColor($lpListCollection, $client_id);

        foreach ($lplist as $index => $lp) {

            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            /* $s = "select * from leadpops where id = " . $leadpop_id;
             $lpres = $this->db->fetchRow($s);*/

            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            /* $s = "select * from leadpop_background_color ";
             $s .= " where client_id = " . $client_id;
             $s .= " and leadpop_id = " . $leadpop_id;
             $s .= " and leadpop_type_id = " . $leadpop_type_id;
             $s .= " and leadpop_vertical_id = " . $vertical_id;
             $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
             $s .= " and leadpop_template_id = " . $leadpop_template_id;
             $s .= " and leadpop_version_id = " . $leadpop_version_id;
             $s .= " and leadpop_version_seq = " . $version_seq;
             $result = $this->db->fetchRow($s);*/


            $result = $leadpopBackgroundColor
                ->where("client_id", $client_id)
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_type_id", $leadpop_type_id)
                ->where("leadpop_vertical_id", $vertical_id)
                ->where("leadpop_vertical_sub_id", $subvertical_id)
                ->where("leadpop_template_id", $leadpop_template_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where("leadpop_version_seq", $version_seq)
                ->first();


            if ($thelink == 'active_overlay') {
                if ($result['active_overlay'] == 'y') {
                    $active = 'n';
                } else {
                    $active = 'y';
                }
            }

            if ($thelink == 'active_backgroundimage') {
                if ($result['active_backgroundimage'] == 'y') {
                    $active = 'n';
                } else {
                    $active = 'y';
                }
            }
            if (isset($_POST['bkactive']) && "" != $_POST['bkactive']) $active = $_POST['bkactive'];

            $s = "update leadpop_background_color  set " . $thelink . " = '" . $active . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            //   $this->db->query($s);
            Query::execute($s, $currentFunnelKey);

            // echo $s;
            // echo '=====';

            $s = "UPDATE clients_leadpops SET  last_edit = '" . date("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND leadpop_version_id  = " . $leadpop_version_id;
            $s .= " AND leadpop_version_seq  = " . $version_seq;
            // $this->db->query($s);
            Query::execute($s, $currentFunnelKey);


        }
        return $thelink . "~" . $active;
    }




    public function changelplogoScalingProperties($client_id, $adata, $funnel_data = array())
    {
        if (env('GEARMAN_ENABLE') == "1") $gearmanQuery = true;
        else $gearmanQuery = false;

        $registry = DataRegistry::getInstance();

        if (!empty($funnel_data)) {
            $referred_vertical_id = $funnel_data["leadpop_vertical_id"];
            $referred_subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $referred_leadpop_id = $funnel_data["leadpop_id"];
            $referred_version_seq = $funnel_data["leadpop_version_seq"];
        } else {

            $referred_vertical_id = $registry->leadpops->customVertical_id;
            $referred_subvertical_id = $registry->leadpops->customSubvertical_id;
            $referred_leadpop_id = $registry->leadpops->customLeadpopid;
            $referred_version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $lplist = explode(",", $_POST['selected_funnels']);
        $lplist = collect($lplist);

        // To ADD Source Funnel in Global QUE
        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        if (isset($_POST['current_hash'])) {
            $lplist->prepend($currentFunnelKey);
            $lplist = $lplist->unique()->values()->all();
        }

        // one Time Queries
        $getCdnLink = getCdnLink();
        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
        $clientlogo = GlobalHelper::getClientLogoByLogoSource($adata['logo_id'], $adata['logo_source']);
        $leadpopLogos = GlobalHelper::getClientLogos($lpListCollection, $client_id);

        $scaling_defaultHeightPercentage = $adata["scaling_defaultHeightPercentage"] ;
        $scaling_maxHeightPx = $adata["scaling_maxHeightPx"] ;
        $scaling_properties = json_encode(['maxHeight' => $scaling_maxHeightPx, 'scalePercentage' => $scaling_defaultHeightPercentage]);
        foreach ($lplist as $index => $lp) {
            if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('====== [ changelplogoScalingProperties # ' . $index . ' ==> ' . $lp . ' ] ======');
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];


            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            if ($adata['logo_source'] == 'client') {

                $logosrc = strval($getCdnLink) . "/logos/" . strval($clientlogo['logo_src']);

                // Check if looped funnel is not referred funnel
                if ($vertical_id == $referred_vertical_id &&
                    $subvertical_id == $referred_subvertical_id &&
                    $leadpop_id == $referred_leadpop_id &&
                    $version_seq == $referred_version_seq
                ) {
                    $s = "update leadpop_logos  set scaling_properties = '" . $scaling_properties . "' ";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and id = " . $adata['logo_id'];
                    Query::execute($s, $currentFunnelKey);

                    if (env('APP_ENV') !== config('app.env_production'))
                        \Log::channel('myleads')->info('[' . $index . ' ==> ' . json_encode($lp) . '] = its Source Logo -- Just Update DB Row => ' . $adata['logo_id']);
                } else {
                    /**
                     * Use Case:
                     *      From Global Screen User dragged an image to enable it. But currently coded code is not optimized
                     *      we are uploading images everytime on logo change
                     *
                     *      Instead if should do this...
                     *          1) Find if we already have logo uploaded on rackspace then just enable it an update scaling properties
                     *
                     */

                    ## IF logo has __global__ in name then lookup in DB we have same name image for current funnel
                    $upload_logo_cdn = true;
                    $logoname = "";
                    if (strpos($clientlogo['logo_src'], "__global__") !== false) {
                        $arr = explode("__global__", $clientlogo['logo_src']);
                        $name2s = end($arr);
                        $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "__global__" . $name2s);

                        $existingLogo = $leadpopLogos
                            ->where("client_id", $client_id)
                            ->where("leadpop_id", $leadpop_id)
                            ->where("leadpop_type_id", $leadpop_type_id)
                            ->where("leadpop_vertical_id", $vertical_id)
                            ->where("leadpop_vertical_sub_id", $subvertical_id)
                            ->where("leadpop_template_id", $leadpop_template_id)
                            ->where("leadpop_version_id", $leadpop_version_id)
                            ->where("leadpop_version_seq", $version_seq)
                            ->where('logo_src', '=', $logoname)
                            ->sortBy('id')
                            ->all();

                        $upload_logo_cdn = count($existingLogo) > 0 ? false : true;

                    }
                    # Use Case # 1 - Find Logo if its already uploaded
                    if (!$upload_logo_cdn) {
                        if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('[' . $index . ' ==> ' . $lp . '] = Global Que -- Logo found in DB uploaded via Global mode - Update DB Row => ' . $logoname);

                        $s = "update leadpop_logos  set scaling_properties = '" . $scaling_properties . "' ";
                        $s .= " where client_id = " . $client_id;
                        $s .= " and leadpop_id = " . $leadpop_id;
                        $s .= " and leadpop_type_id = " . $leadpop_type_id;
                        $s .= " and leadpop_vertical_id = " . $vertical_id;
                        $s .= " and leadpop_vertical_id = " . $vertical_id;
                        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                        $s .= " and leadpop_template_id = " . $leadpop_template_id;
                        $s .= " and leadpop_version_id = " . $leadpop_version_id;
                        $s .= " and leadpop_version_seq = " . $version_seq;
                        $s .= " and logo_src = '" . $logoname . "'";

                        Query::execute($s, $currentFunnelKey);

                        if (env('APP_ENV') !== config('app.env_production')) \Log::channel('myleads')->info('[' . $index . ' ==> ' . $lp . '] = ' . $s);

                    }
                }

            }
        }
        return true;
    }


    public function changelpImageScalingProperties($client_id, $adata, $funnel_data = array(), $lplist)
    {
        extract($_POST, EXTR_OVERWRITE, "form_");
        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);

        $scaling_defaultWidthPercentage = $_POST['scaling_defaultWidthPercentage'];
        $scaling_maxWidthPx = $_POST['scaling_maxWidthPx'];
        $scaling_properties = json_encode(['maxWidth'=>$scaling_maxWidthPx, 'scalePercentage'=>$scaling_defaultWidthPercentage]);

        $registry = DataRegistry::getInstance();

        if (!empty($funnel_data)) {
            $referred_vertical_id = $funnel_data["leadpop_vertical_id"];
            $referred_subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $referred_leadpop_id = $funnel_data["leadpop_id"];
            $referred_version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $referred_vertical_id = $registry->leadpops->customVertical_id;
            $referred_subvertical_id = $registry->leadpops->customSubvertical_id;
            $referred_leadpop_id = $registry->leadpops->customLeadpopid;
            $referred_version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $referred_lpres = $lpListCollection->where('leadpop_id', $referred_leadpop_id)->first();

        $referred_leadpop_type_id = $referred_lpres['leadpop_type_id'];
        $referred_leadpop_template_id = $referred_lpres['leadpop_template_id'];
        $referred_leadpop_version_id = $referred_lpres['leadpop_version_id'];

        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        $currentFunnelsImageQuery = "SELECT * FROM leadpop_images ";
        $currentFunnelsImageQuery .= " where client_id = " . $client_id;
        $currentFunnelsImageQuery .= " and leadpop_id = " . $referred_leadpop_id;
        $currentFunnelsImageQuery .= " and leadpop_type_id = " . $referred_leadpop_type_id;
        $currentFunnelsImageQuery .= " and leadpop_vertical_id = " . $referred_vertical_id;
        $currentFunnelsImageQuery .= " and leadpop_vertical_sub_id = " . $referred_subvertical_id;
        $currentFunnelsImageQuery .= " and leadpop_template_id = " . $referred_leadpop_template_id;
        $currentFunnelsImageQuery .= " and leadpop_version_id = " . $referred_leadpop_version_id;
        $currentFunnelsImageQuery .= " and leadpop_version_seq = " . $referred_version_seq;
        $currentFunnelsImage = $this->db->fetchRow($currentFunnelsImageQuery);

//        dd('$currentFunnelKey', $currentFunnelKey);

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];

            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            // Featured Image Status
            $registry = DataRegistry::getInstance();
            if ($registry->leadpops->clientInfo['is_fairway'] == 1) $trial_launch_defaults = "trial_launch_defaults_fairway";
            else if ($registry->leadpops->clientInfo['is_mm'] == 1) $trial_launch_defaults = "trial_launch_defaults_mm";
            else $trial_launch_defaults = "trial_launch_defaults";
            // get trial info from version_seq = 1 because if funnel is cloned manny times the higher version_seq not exist in trial tables
            $s = "select * from " . $trial_launch_defaults;
            $s .= " where leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id  = " . $leadpop_version_id;
            $s .= " ORDER BY leadpop_version_seq ASC";
            $trialDefaults = $this->db->fetchRow($s);
            $defaultimagename = $trialDefaults['image_name'];

            $s = "update leadpop_images  set scaling_properties = '" . $scaling_properties . "' ";
            if ($adata['imagestatus'] == "inactive") {
                $s .= ", use_me = 'n'";
                //Check if user wants to disable default featured image as well...
                if(trim($currentFunnelsImage["image_src"]) == $defaultimagename){
                    $s .= ", use_default = 'n'";
                }
                $imagesrc='';
            } else {
                //Check if use wants to enable default featured image...
                if(trim($currentFunnelsImage["image_src"]) == $defaultimagename){
                    $s .= ", use_default = 'y'";
                    $imagesrc = $defaultimagename;
                }else{
                    $s .= ", use_me = 'y'";
                    $imagesrc = $currentFunnelsImage['image_src'];
                }
            }

            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            Query::execute($s, $currentFunnelKey);
            $customize = new CustomizeRepository($this->db);
            $customize->updateFunnelVar(FunnelVariables::FRONT_IMAGE, $imagesrc, $client_id, $leadpop_id, $leadpop_version_seq);
        }
        return true;

    }



    //=======================================================================================================================================================
    //=========================================================deprecated in admin3.0-----===================================================================
    //=======================================================================================================================================================


    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */


}


