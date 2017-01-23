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
    public $username;
    public $email;
    public $password;

    public function BuildModel($reqData)
	{
		// TODO: validation of data

        Log::info($reqData);

		if(is_null($reqData))
			return;
		$this->username  = $reqData['username'];
		$this->email = $reqData['email'];
		$this->password = $reqData['password'];
	}
}