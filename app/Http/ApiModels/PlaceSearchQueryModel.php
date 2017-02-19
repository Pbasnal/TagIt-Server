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
		$this->query  = $reqData->get('query');
		$this->center = $reqData->get('center');
		$this->bounds = $reqData->get('bounds');
	}
}