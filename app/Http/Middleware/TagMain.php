<?php


namespace App\Http\Middleware;

use App\Http\Middleware\GooglePlacesApi;
use App\Http\ApiModels\PlaceSearchQueryModel;
use App\Http\ApiModels\HotspotModel;
use Log;

use App\Models\Hotspot;

class TagMain
{
	private $googlePlacesApi;

	public function __construct()
    {
        $this->googlePlacesApi = new GooglePlacesApi;
    }

	public function DummyCall()
	{
		return $this->googlePlacesApi->DummyCall();
	}

	public function SearchPlace(PlaceSearchQueryModel $query)
	{
		$hotspotResults = Hotspot::where("tags", "=",  $query->query)->get();
		$googleResults = $this->googlePlacesApi->SearchPlace($query);

		$this->StoreGoogleResults($hotspotResults, $googleResults, $query->query);

		return $this->CombineResults($hotspotResults, $googleResults);
	}

	public function StoreTag($logId, $hotspot)
	{
		Log::info($logId.": in tagmain: storetag");
		Log::info($logId."".print_r($hotspot, true));
		Hotspot::InsertTag($logId, $hotspot);
	}

	private function StoreGoogleResults($hotspotResults, $googleResults, $hashTag)
	{
		for($i = 0; $i < count($googleResults); $i++)
		{
			$hotspot = new HotspotModel;
			$hotspot->BuildFromGoogleResponse($googleResults[$i], $hashTag);
			if(!$this->TagExists($hotspot, $hotspotResults))
				$this->StoreTag($hotspot);
		}
	}

	private function CombineResults($hotspotResults, $googleResults)
	{
		$results = array();

		for($i = 0; $i < count($hotspotResults); $i++)
		{
			$hotspot = new HotspotModel;
			$hotspot->BuildFromDbModel($hotspotResults[$i]);
			if(!$this->TagExists($hotspot, $results))
				array_push($results, $hotspot);
		}

		for($i = 0; $i < count($googleResults); $i++)
		{
			$hotspotResults = new HotspotModel;
			$hotspotResults->BuildFromGoogleResponse($googleResults[$i]);
			if(!$this->TagExists($hotspotResults, $results))
				array_push($results, $hotspotResults);
		}

		return $results;
	}

	private function TagExists($hotspotResults, $hotspotList)
	{
		foreach ($hotspotList as $hotspot)
		{
			if(strcasecmp($hotspot->name, $hotspotResults->name) == 0)
				return true;
		}

		return false;
	}

}