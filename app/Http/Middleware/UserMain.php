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
        Log::info($logId." in create");
        User::all();
        Log::info($userModel->username);

        $existingNumber =  User::where("number", "=",  $userModel->number)->get();

        Log::info("number: ".$existingNumber);

        if(count($existingNumber) !== 0)
        {
            return "Number already registered";
        }

        User::InsertUser($logId, $userModel);

        return "User created";
    }
}