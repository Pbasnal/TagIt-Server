<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\HotspotMain;
use App\Http\Requests;
use App\Http\ApiModels\PlaceSearchQueryModel;
use App\Http\ApiModels\UserRequestModel;
use App\Models\Hotspot;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Log;

class HotspotController extends Controller
{
    private $hotspotMain;

    public function __construct()
    {
        $this->hotspotMain = new HotspotMain();
    }

    public function store(Request $request)
    {
        //TODO: Validations and verifications

        if (function_exists('com_create_guid'))
            $logId = com_create_guid();
        $logId = 1234567890;

        Log::info($logId.": in tag controller: store");
        Log::info($logId.":".print_r($request->input('name'), true));
        $reqModel = new UserRequestModel();
        $reqModel->BuildModel($logId, $request);
        $response = $this->hotspotMain->StoreHotspot($logId, $reqModel);
        
        Log::info("response".json_encode($response));

        if($response === null)
            return "Stored Successfully";
        return "Problem in creating hotspot";
    }

    public function search(Request $request)
    {
        if (function_exists('com_create_guid'))
            $logId = com_create_guid();
        $logId = 1234567890;

        Log::info($logId.' : tag controller');
        

        $reqModel = new PlaceSearchQueryModel();
        $reqModel->BuildModel($request->request);
        $response = $this->hotspotMain->SearchPlace($logId, $reqModel);

        return $response;
    }
    
}
