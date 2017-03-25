<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Http\ApiModels\UserModel;
use App\Http\ApiModels\UserRequestModel;
use App\Http\Middleware\UserMain;
use Response;
use Authorizer;
use Log;

class UserController extends Controller
{
    private $userMain;

    public function __construct()
    {
         $this->userMain = new UserMain;
    }

    public function getAccessToken()
    {
        return Response::json(Authorizer::issueAccessToken());
    }

    public function store(Request $request)
    {
        $logId = 1234567890;
        Log::info(''.$logId.' : '.$request);

        
        if (function_exists('com_create_guid'))
            $logId = com_create_guid();

        $reqModel = new UserModel;
        $reqModel->BuildModel($request);

        return $this->userMain->CreateUser($logId, $reqModel);
    }

    public function show($number)
    {
        Log::info('in show user request '.$number);
        $userRequests = new UserRequestModel();
        return $userRequests->GetAllRequestOfTheUser($number);
    }
}
