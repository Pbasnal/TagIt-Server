<?php

namespace App\Http\ApiModels;

use App\Http\Types\HotspotInformation;
use Log;

class HotspotModel
{
	public $name;
	public $info;
	public $location;
	public $portal;

	public function BuildModel($logID, $reqData)
	{

		// TODO: validation of data
		if(is_null($reqData))
		{
			Log::info($logID.": request data is null");
			return;
		}

		$this->name  = $reqData->input('name');
		$this->location = $reqData->input('location');
		$this->portal = $reqData->input('portal');

		$this->info = new HotspotInformation;
		$this->info->tags = explode ( ' ' , $reqData->input('tags'));
		$this->info->comments = $reqData->input('comments');
		$this->info->images = $reqData->input('images');

		for($i = 0; $i <  count($this->info->tags); $i++)
		{
			$this->info->tags[$i] = str_replace('#', '', $this->info->tags[$i]);
		}

		Log::info($logID.": request data\n".print_r($this, true));
	}

	public function BuildFromDbModel($tagDbModel)
	{
		$this->name = $tagDbModel->name;
		$this->location = $tagDbModel->location;
		$this->portal = $tagDbModel->portal;

		$this->info = new HotspotInformation;
		$this->info->tags = $tagDbModel->tags;
		$this->info->comments = $tagDbModel->comments;
		$this->info->comments = $tagDbModel->commends;
		$this->info->reports = $tagDbModel->reports;
		$this->info->images = $tagDbModel->images;
	}

	public function BuildFromGoogleResponse($googleResults, $hashTag = null)
	{
		$this->name = $googleResults["name"];
		$this->location = $googleResults["geometry"]["location"];
		
		if($hashTag != null)
		{
			$this->info = new HotspotInformation;
			$this->info->tags = array($hashTag);
		}
	}
}