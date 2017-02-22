<?php


namespace App\Http\Middleware;

use App\Http\Middleware\GooglePlacesApi;
use App\Http\ApiModels\PlaceSearchQueryModel;
use App\Http\ApiModels\HotspotModel;
use Log;

use App\Models\Hotspot;
use App\Models\UserRequest;

class HotspotMain
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

	public function SearchHotspot($logId, PlaceSearchQueryModel $query)
	{
		Log::info("Searching in TagMain: searching for -> ".$query->query);

		$hotspotResults = Hotspot::whereRaw(['tags' => ['$all' => [$query->query]] ])->get();
		
		$googleResults = $this->googlePlacesApi->SearchPlace($query);
        
		//$this->StoreGoogleResults($logId, $hotspotResults, $googleResults, $query->query);

		return $this->CombineResults($hotspotResults, $googleResults);
	}

	public function StoreHotspot($logId, $userRequest)
	{
		Log::info($logId.": in tagmain: storetag");
		//Log::info($logId."".print_r($hotspot, true));
		if(!UserRequest::InsertUserRequest($logId, $userRequest))
			return "User doesn't exists";

		Hotspot::InsertHotspot($logId, $userRequest->request);
	}

	private function StoreGoogleResults($logId, $hotspotResults, $googleResults, $hashTag)
	{
	    $tags = array();
	    array_push($tags, $hashTag);
	    
		for($i = 0; $i < count($googleResults); $i++)
		{
			$hotspot = new HotspotModel;
			$hotspot->BuildFromGoogleResponse($googleResults[$i], $tags);
			if(!$this->TagExists($hotspot, $hotspotResults))
				$this->StoreTag($logId, $hotspot);
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
        
        if($googleResults == null)
			return $results;
			
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