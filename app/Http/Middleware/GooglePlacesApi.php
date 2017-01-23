<?php
namespace App\Http\Middleware;

use joshtronic\GooglePlaces;
use App\Http\ApiModels\PlaceSearchQueryModel;

class GooglePlacesApi
{
	private $placesUri = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=';
	public function DummyCall()
	{
		$google_places = new GooglePlaces(config('googleapi.googlekey'));

		$lat = 17.4631839;
		$lng = 78.35364379999999;
		$place_types = 'food';

		$google_places->location = array($lat, $lng);
		$google_places->radius = 8046; //hard-coded radius
		$google_places->types = $place_types;
		$nearby_places = $google_places->nearbySearch();

		return $nearby_places['results'];
	}

	public function SearchPlace(PlaceSearchQueryModel $query)
	{
		$googleKey = config('googleapi.googlekey');
		$google_places = new GooglePlaces($googleKey);

		$radius = $this->GetRadiusFromBoundsAndCenter($query->center, $query->bounds);

		$google_places->location = array($query->center['lat'], $query->center['lng']);
		$google_places->radius = $radius;
		$google_places->type = $query->query;
		$nearby_places = $google_places->nearbySearch();

		return $nearby_places['results'];
	}

	function GetRadiusFromBoundsAndCenter($center, $bounds)
	{
		$height = pow(($bounds['NEPoint']['lng'] - $bounds['SWPoint']['lng']) * 200000, 2);
		$width = pow(($bounds['SWPoint']['lat'] - $bounds['NEPoint']['lat']) * 200000, 2);

		if($height < $width)
			return sqrt($height) / 2;

		return sqrt($width) / 2;
	}
}