<?php
namespace App\Http\Middleware;

use App\Http\ApiModels\UserModel;
use App\User;
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
    public function CreateUser(UserModel $userModel)
    {
        //todo: response object to contain error and messages
        //Todo: proper validation of usernames and emails and passwords

        Log::info("in create");
        Log::info($userModel->username);

        $existingUsername =  User::where("username", "=",  $userModel->username)->get();
        $existingEmail =  User::where("email", "=",  $userModel->email)->get();

        if(count($existingUsername) !== 0)
        {
            return "User Already Exists";
        }
        if(count($existingEmail) !== 0)
        {
            return "Email already exists";
        }

        $user = new User;
        $user->username = $userModel->username;
        $user->email    = $userModel->email;
        $user->password =  \Illuminate\Support\Facades\Hash::make($userModel->password);

        $user->created_at = $user->updated_at = date("Y-m-d H:i:s");

        $user->save();

        return User::all();
    }
}