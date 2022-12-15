<?php

namespace App\Http\Controllers;

use App\Constants\LP_Constants;
use App\Helpers\CustomErrorMessage;
use App\Http\Requests\Promotion\DeleteSocialShareImageRequest;
use App\Models\LynxlyLinks;
use App\Repositories\GlobalRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LP_Helper;
use Session;
use App\Models\ClientLeadpopsSocial;
use Illuminate\Support\Facades\Storage;

class PromotionController extends BaseController
{

    private $Default_Model_Global;
    protected static $leadpopDomainTypeId = 0;
    protected static $leadpopSubDomainTypeId = 0;

    public function __construct(LpAdminRepository $lpAdmin, GlobalRepository $globalRepo)
    {
        $this->middleware(function ($request, $next) use ($lpAdmin, $globalRepo) {
            self::$leadpopDomainTypeId = config('leadpops.leadpopDomainTypeId');
            self::$leadpopSubDomainTypeId = config('leadpops.leadpopSubDomainTypeId');

            $this->Default_Model_Global = $globalRepo;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });
    }


    public function shareFunnel(Request $request)
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $this->data->funnelData = $funnel_data;
            $client_leadpops_social = ClientLeadpopsSocial::select('*')
                ->where('client_id', $funnel_data['client_id'])
                ->where('leadpop_id', $funnel_data['leadpop_id'])
                ->where('leadpop_version_id', $funnel_data['leadpop_version_id'])
                ->where('leadpop_version_seq', $funnel_data['leadpop_version_seq'])
                ->first();
            $this->data->og_image = $client_leadpops_social ? $client_leadpops_social->social_image : '';
            $this->data->og_image_id = $client_leadpops_social ? $client_leadpops_social->id : '';

            $shareEmailTemplate = config("social.share_funnel_template")["email"];
            $this->data->email_subject = $shareEmailTemplate['subject'];
            $this->data->email_text = $shareEmailTemplate['text'];
//            dd($funnel_data);
            $this->data->lynxly_data = LynxlyLinks::where('clients_leadpops_id', $funnel_data['client_leadpop_id'])->first();

          //  dd($funnel_data['client_leadpop_id'], $this->data->lynxly_data);

            $this->active_menu = LP_Constants::SHARE_FUNNEL;


            return $this->response();
        }
    }

    private function saveImage(Request $request)
    {

        $image_name = time() . '_social_share_image.' . $request->image->getClientOriginalExtension();
        $imagename = strtolower($this->registry->leadpops->client_id . "_" . $request->leadpop_id . "_" . $request->leadpop_version_id . "_" . $request->leadpop_version_seq . "_" . $image_name);

        $section = substr($this->registry->leadpops->client_id, 0, 1);
        $destinationPath = $section . '/' . $this->registry->leadpops->client_id . '/pics/social_sharing/' . $imagename;

//        $destinationPath = '/social_sharing/'.$this->registry->leadpops->client_id.'/'.$request->get('leadpop_id').'/'.$request->get('leadpop_version_id').'/'.$request->get('leadpop_version_seq')."/".$imagename;
        return move_uploaded_file_to_rackspace($_FILES['image']['tmp_name'], $destinationPath);
    }


    public function deleteSocialShareImage(DeleteSocialShareImageRequest $request)
    {
        $clientLeadpopsSocial = ClientLeadpopsSocial::find($request->get('id'));
        $container = $this->registry->leadpops->clientInfo['rackspace_container'];
        $rackspace = \App::make('App\Services\RackspaceUploader');
        $file_path = str_replace("https://images.lp-images1.com/", "", $clientLeadpopsSocial->social_image);
        if ($rackspace->exist($file_path, $container)) {
            $rackspace->deleteTo($container, $file_path);
        }

        if($clientLeadpopsSocial->delete()) {
            return $this->successResponse(config("alerts.socialMediaSharing.image_delete_success." . config('view.theme')));
        } else {
            return $this->errorResponse();
        }
//        $response = [
//            'message' => config("alerts.socialMediaSharing.image_delete_success." . config('view.theme')),
//        ];
//        return response()->json($response);
    }


    public function uploadSocialShareImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_hash' => ['required'],
            'leadpop_id' => ['required'],
            'leadpop_version_id' => ['required'],
            'leadpop_version_seq' => ['required'],
            'image' => 'mimes:gif,jpeg,jpg,png|required|file|max:2048'
        ]);

        if ($validator->fails()) {
            $message = CustomErrorMessage::getInstance()->setFirstError($validator, "image");
            return $this->errorResponse($message);
        }

        $cur_hash = $request->input["current_hash"];
        LP_Helper::getInstance()->getCurrentHashData($cur_hash);
        $funneldata = LP_Helper::getInstance()->getFunnelData();

        $client_leadpops_social = ClientLeadpopsSocial::firstOrNew([
            'client_id' => $this->registry->leadpops->client_id,
            'leadpop_id' => $request->get('leadpop_id'),
            'leadpop_version_id' => $request->get('leadpop_version_id'),
            'leadpop_version_seq' => $request->get('leadpop_version_seq'),
        ]);

        $client_leadpops_social->image_type = $request->file('image')->getMimeType();
        $cdn = $this->saveImage($request);
        $client_leadpops_social->social_image = $cdn['image_url'];
        $imageSize = @getimagesize($cdn['image_url']);
        if ($imageSize) {
            $client_leadpops_social->image_width = $imageSize[0];
            $client_leadpops_social->image_height = $imageSize[1];
        }

        if ($client_leadpops_social->save()) {
            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt($funneldata['client_leadpop_id']);
            $message = config("alerts.socialMediaSharing.image_update_success." . config('view.theme'));
            return $this->successResponse($message, [
                "id" => $client_leadpops_social->id
            ]);
//            Session::flash('success', $message);
        } else {
            $message = config("alerts.socialMediaSharing.image_update_error." . config('view.theme'));
            return $this->errorResponse($message);
//            Session::flash('error', $message);
        }

        return $this->lp_redirect('/promote/share/' . $request->input("current_hash"));
    }

}
