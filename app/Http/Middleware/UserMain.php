<?php
namespace App\Http\Middleware;

use App\Http\ApiModels\UserModel;
use App\Models\User;
use Log;
/**
 * UserMain short summary.
 *
 * UserMain description.
 *
 * @version 1.0
 * @author Basnal
 */
class UserMain
{
    public function CreateUser($logId, UserModel $userModel)
    {
        //todo: response object to contain error and messages

        Log::info($logId." in create");
        User::all();
        Log::info($userModel->username);

        //$existingusername =  User::where("username", "=",  $userModel->username)->get();
        //$existingDevice =  User::where("deviceId", "=",  $userModel->deviceId)->get();
        $existingNumber =  User::where("number", "=",  $userModel->number)->get();

        //Log::info("user: ".$existingusername);
        //Log::info("device: ".$existingDevice);
        Log::info("number: ".$existingNumber);

        /*if(count($existingusername) !== 0)
        {
            return "User Already registered";
        }
        if(count($existingDevice) !== 0)
        {
            return "Device already registered";
        }*/
        if(count($existingNumber) !== 0)
        {
            return "Number already registered";
        }

        User::InsertUser($logId, $userModel);

        return User::all();
    }
}