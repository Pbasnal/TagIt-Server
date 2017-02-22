<?php
namespace App\Http\ApiModels;

use Log;

/**
 * UserModel short summary.
 *
 * UserModel description.
 *
 * @version 1.0
 * @author Basnal
 */
class UserModel
{
    //public $deviceId;
    public $number;
    public $username;

    public function BuildModel($reqData)
	{
		// TODO: validation of data

		Log::info("building user model\n");
        Log::info($reqData);

		if(is_null($reqData))
			return;

		//$this->deviceId  = $reqData['deviceid'];
		$this->number = $reqData['number'];
		$this->username = $reqData['username'];
	}
}