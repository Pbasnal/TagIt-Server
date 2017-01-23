<?php

namespace App\Http\ApiModels;

class PlaceSearchQueryModel
{
	public $query;
	public $center;
	public $bounds;

	public function BuildModel($reqData)
	{
		if(is_null($reqData))
			return;
		$this->query  = $reqData['query'];
		$this->center = $reqData['center'];
		$this->bounds = $reqData['bounds'];
	}
}