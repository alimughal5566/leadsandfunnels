<?php
/**
 * Created by PhpStorm.
 * User: Jazib
 * Date: 23/11/2019
 * Time: 5:17 AM
 */

namespace App\Services;


use Exception;
use OpenCloud\Rackspace;

class RackspaceUploader extends Rackspace
{
    private $region;
    private $urlType;
    private $apiKey;

    function __construct(){
        $this->region = config('rackspace.region');
        $this->urlType = config('rackspace.urlType');
        $this->apiKey = config('rackspace.apiKey');
        $this->username = config('rackspace.username');

        parent::__construct(Rackspace::US_IDENTITY_ENDPOINT, array(
            'username' => 'andrewsells',
            'apiKey'   => 'fa82cd10a5b44e909be6740fb0f10ca2',
        ));
    }

    function containersList(){
        $result = array();
        $objectStoreService = $this->objectStoreService(null, 'ORD');
        foreach ($objectStoreService->listContainers() as $i=>$container){
            /**
             * @var $container \OpenCloud\ObjectStore\Resource\Container
             */
            $result[] = $container->name;
        }

        return $result;
    }

    function uploadTo($containerName, $files, $uploadPath){
        try{
            $objectStoreService = $this->objectStoreService(null, $this->region);
            $container = $objectStoreService->getContainer($containerName);

            // Upload an object to the container.
            $object = $container->uploadObject($uploadPath, $files);

            /** @var $cdnInfo \Guzzle\Http\Url */
            $cdnInfo = $object->getPublicUrl();
            $rackcdn = array();
            if($cdnInfo){
                $rackcdn['rs_cdn'] = $cdnInfo->getScheme()."://".$cdnInfo->getHost().$cdnInfo->getPath();
                $rackcdn['path'] = $cdnInfo->getPath();

                $cinfo = $this->containerInfo($containerName);
                $rackcdn['image_url'] = $cinfo['cdn_domain'] . $cdnInfo->getPath();
            }
            else{
                $rackcdn['rs_cdn'] = "";
                $rackcdn['path'] = "";
                $rackcdn['image_url'] = "";
            }

            return $rackcdn;
        }
        catch (Exception $e){
            dd($e->getMessage());
        }
    }

    function deleteTo($containerName, $filespath){
        try{
            $objectStoreService = $this->objectStoreService(null, $this->region);
            $container = $objectStoreService->getContainer($containerName);

            // delete an object to the container.

            $container->deleteObject($filespath);

            return "";
        }
        catch (Exception $e){
            dd($e->getMessage());
        }
    }

    function exist($file, $containerName){
        $objectStoreService = $this->objectStoreService(null, $this->region);
        $container = $objectStoreService->getContainer($containerName);
        return $container->objectExists($file);
    }

    function getFile($file, $containerName,$global = 0){
        $objectStoreService = $this->objectStoreService(null, $this->region);
        $container = $objectStoreService->getContainer($containerName);

        $local_file = "";
        if($this->exist($file, $containerName)){
            $object = $container->getObject($file);
            $objectContent = $object->getContent();
            $local_file = env('RACKSPACE_TMP_DIR', '')."/".str_replace("/", "~", $object->getName());
            $fp = @fopen($local_file, "wb");
            fwrite($fp, $objectContent);
            if($global == 1){
                $local_file = $local_file;
            }else{
                $local_file = public_path($local_file);
            }
        }

        return $local_file;
    }

    function copyFile($file, $uploadPath, $containerName){
        $cinfo = $this->containerInfo($containerName);
        if(strpos($uploadPath, $cinfo['sep']) === false){
            $uploadPath = $cinfo['sep'] . $uploadPath;
        }

        $info = parse_url($file);
        $file_name = substr($info['path'], 1);

        $objectStoreService = $this->objectStoreService(null, $this->region);
        $container = $objectStoreService->getContainer($containerName);

        $rackcdn = array();
        if($this->exist($file_name, $containerName)){

            $tmp = $this->getFile($file_name, $containerName);
            if($tmp){
                $handle = fopen($tmp, 'r');
                $rackcdn = $this->uploadTo($containerName, $handle, $uploadPath);

                if(is_resource($handle)) {
                    fclose($handle);
                }

                if(file_exists($tmp)){
                    unlink($tmp);
                }
            }
        }
        else{
            $rackcdn['rs_cdn'] = "";
            $rackcdn['path'] = "";
            $rackcdn['image_url'] = "";
        }
        return $rackcdn;
    }

    function containerInfo($containerName){
        $res = \DB::select("SELECT * FROM current_container_image_path WHERE current_container = '$containerName'");
        $containerInfo = objectToArray($res[0]);
        $purl = parse_url($containerInfo['image_path']);
        $containerInfo['cdn_domain'] = str_replace($purl['path'],"", $containerInfo['image_path']);
        $containerInfo['sep'] = substr($purl['path'], 1);
        return $containerInfo;
    }

    function test(){
        return "Hi Jaz!!";
    }
}
