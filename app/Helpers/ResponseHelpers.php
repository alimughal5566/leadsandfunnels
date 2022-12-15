<?php
/**
 * Created by PhpStorm.
 * User: haroon
 * Date: 28/04/2020
 * Time: 16:52
 */

namespace App\Helpers;


use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelpers
{
    # =================================
    # =           Responses           =
    # =================================

    public static function successResponse($message, $data = [], $pagination = false, $responseCode = null)
    {
        if ($pagination) {

            return response()->json(['status' => true, 'message' => $message, 'result' => $data], Response::HTTP_OK);
        } else {
            return response()->json(['status' => true, 'message' => $message, 'result' => array('data' => $data)], $responseCode ? $responseCode: Response::HTTP_OK);
        }
    }

    public static function validationResponse($errors, $request = null)
    {
        $request = json_encode($request);
        $response = json_encode($errors);

      //  ResponseHelpers::routeRequestResponseLogs('', $request, $response, '5xx');
        return response(['status' => false, 'message' => $errors], Response::HTTP_NOT_ACCEPTABLE);
    }
    public static function unAuthResponse($errors)
    {
        return response(['status' => false, 'message' => $errors], Response::HTTP_UNAUTHORIZED);
    }

    public static function notFoundResponse($errors)
    {
        return response(['status' => false, 'message' => $errors], Response::HTTP_NOT_FOUND);
    }

    public static function serverErrorResponse($errors, $path = null)
    {
        return response()->json(['status' => false, 'message' => $errors],  Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    # ======  End of Responses  =======

}