<?php
namespace App\Models;

use App\Http\ApiModels\UserRequestModel;
use App\Models\Hotspot;
use App\Models\User;
use Moloquent;
use Log;

/**
 * HotspotDb Model
 *
 * @author Pankaj Basnal
 */

class UserRequest extends Moloquent
{
	protected $connection = 'mongodb';

	public static function InsertUserRequest($logId, UserRequestModel $inUserRequest)
	{
		Log::info($logId.": inserting User Request");
		
		if(!UserRequest::ValidateIfUserExists($inUserRequest->number))
			return false;

        $userRequest = new UserRequest();
		$userRequest->number  = $inUserRequest->number;

		$userRequest->request  = new Hotspot();
		$userRequest->request  = $inUserRequest->request;

		$userRequest->save();

		return true;
	}

	private static function ValidateIfUserExists($number)
	{
		$existingNumber =  User::where("number", "=",  $number)->get();

		if(count($existingNumber) !== 0)
        {
            return true;
        }

        return false;
	}
}