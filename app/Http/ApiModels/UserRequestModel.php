<?php

namespace App\Http\ApiModels;

use App\Http\ApiModels\HotspotModel;
use App\Models\UserRequest;

class UserRequestModel
{
	public $number;
	public $request;

	public function BuildModel($logId, $reqData)
	{
		// TODO: validation of data
		if(is_null($reqData))
			return;
		$this->number  = $reqData->input('number');
		$this->request = new HotspotModel();

		$this->request->BuildModel($logId, $reqData);
	}

	public function BuildFromDbModel(UserRequest $userRequestDbModel)
	{
		$this->number = $userRequestDbModel->number;
		$this->request->BuildFromDbModel($logId, $userRequestDbModel->request);
	}

	public function GetAllRequestOfTheUser($number)
	{
		return UserRequest::where("number", "=",  $number)->get();
	}
}