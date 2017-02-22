<?php

namespace App\Models;

use App\Http\ApiModels\UserModel;
use Moloquent;
use Log;

/**
 * HotspotDb Model
 *
 * @author Pankaj Basnal
 */

class User extends Moloquent
{
	protected $connection = 'mongodb';

	public static function InsertUser($logId, UserModel $inUser)
	{
		Log::info($logId.": inserting user");
		
        $user = new User;
		//$user->deviceId  = $inUser->deviceId;
		$user->number = $inUser->number;
		$user->username = $inUser->username;

		$user->save();
	}
}