<?php

namespace App\Http\Controllers;

use App\Constants\LP_Constants;
use App\Http\Requests\Promotion\DeleteSocialShareImageRequest;
use App\Repositories\GlobalRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use LP_Helper;
use Session;
use App\Models\ClientLeadpopsSocial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ResponseHelpers;
use App\Models\LynxlyLinkVisits;
use App\Models\LynxlyLinks;

use App\Http\Requests\UrlShortener\SaveHashRequest;


class ShortenUrlController extends BaseController
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


    public function createShortenUrl(Request $request)
    {
        try {
            LP_Helper::getInstance()->getCurrentHashData($request->input('current_hash'));
            $funnelData = LP_Helper::getInstance()->getFunnelData();
            $hash = $this->getUniqueHash();
            $lynxlyLink = LynxlyLinks::create([
                'clients_leadpops_id' => $funnelData['client_leadpop_id'],
                'client_id' => $funnelData['client_id'],
                'leadpop_id' => $funnelData['leadpop_id'],
                'slug_name' => $hash,
                'target_url' => "https://" . $funnelData['funnel']['domain_name'],
            ]);



//            $lynxlyLink = \DB::table('clients_leadpops')->where('id', $funnelData['client_leadpop_id'])->update(['lynxly_hash' => $hash]);
            return response()->json([
                'result' => ['id' =>$funnelData['client_leadpop_id'], 'slug_name' =>$hash],
                'short_url' => config('urlshortener.app_base_url') . '/' . $hash
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function removeShortenUrl(Request $request)
    {
        try {
            LP_Helper::getInstance()->getCurrentHashData($request->input('current_hash'));
            $funnelData = LP_Helper::getInstance()->getFunnelData();
//            $lynxlyLink = \DB::table('clients_leadpops')->where('id', $funnelData['client_leadpop_id'])->update(['lynxly_hash' => '']);
            $lynxlyLink = LynxlyLinks::where('clients_leadpops_id', $funnelData['client_leadpop_id'])->delete();
            LynxlyLinkVisits::where('clients_leadpops_id', $funnelData['client_leadpop_id'])->delete();

            return ResponseHelpers::successResponse('Hash deleted',  $lynxlyLink);

            return response()->json([
                'result' => $result->result->data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function editShortenUrl(Request $request)
    {

        try {
            LP_Helper::getInstance()->getCurrentHashData($request->input('current_hash'));
            $funnelData = LP_Helper::getInstance()->getFunnelData();

           /* $shortUrlData = \DB::table('clients_leadpops')
                ->select("id","lynxly_hash")
                ->where('id', $funnelData['client_leadpop_id'])
                ->orderBy('id', 'asc')
                ->first();*/

            $shortUrlData = \DB::table('lynxly_links')
                ->select("id","slug_name")
                ->where('clients_leadpops_id', $funnelData['client_leadpop_id'])
                ->orderBy('id', 'asc')
                ->first();

            $old_slug = $shortUrlData->slug_name;

            $new_slug = strtolower($request->input('slug'));

            if ($old_slug === $new_slug) {
                return response()->json([
                    'message' => 'same slug',
                ]);
            }

//           $count = $this->checkHashUniquness($new_slug);
           $count = LynxlyLinks::checkUniqunessOfHash($new_slug);

           if($count == 0) {

               $lynxlyLink = LynxlyLinks::where('clients_leadpops_id', $funnelData['client_leadpop_id'])
                   ->update(['slug_name' => $new_slug]);

               return ResponseHelpers::successResponse('slug updated',  [
                   'Old Slug' => $old_slug,
                   'New Slug' => $new_slug
               ]);


           }

            return response()->json([
                'message' => 'Short URL is already exist, please try again.'
            ], Response::HTTP_NOT_ACCEPTABLE);


        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    private function getUniqueHash()
    {
        // Generate a unique Hash
        return self::generateUniqueHash();
    }


  /*  private function checkHashUniquness($hash)
    {
        try {
            return \DB::table('clients_leadpops')->where('lynxly_hash', strtolower($hash))->count();

        } catch (\Exception $e) {
            return false;
        }
    }*/

    private static function generateUniqueHash()
    {

        $hash = strtolower(substr(md5(uniqid(rand(), true)), 0, config('urlshortener.hash_length')));
        $count = LynxlyLinks::where('slug_name', strtolower($hash))->count();
        if ($count) {
            self::generateUniqueHash();
        }
        return $hash;
    }

}
