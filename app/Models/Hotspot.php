<?php
namespace App\Models;

use App\Http\ApiModels\HotspotModel;
use App\Http\Types\HotspotInformation;
use Moloquent;
use Log;

/**
 * HotspotDb Model
 *
 * @author Pankaj Basnal
 */

class Hotspot extends Moloquent
{
	protected $connection = 'mongodb';

	public static function InsertTag($logId, HotspotModel $inHotspot)
	{
		Log::info($logId.": inserting hotspot");
		
        $hotspot = new Hotspot;
		$hotspot->name  = $inHotspot->name;
		$hotspot->location = $inHotspot->location;
		$hotspot->portal = $inHotspot->portal;

		$info = new HotspotInformation;
		$info->tags = $inHotspot->info->tags;
		$info->comments = $inHotspot->info->comments;
		$info->images = $inHotspot->info->images;
		$info->commends = $inHotspot->info->commends;
		$info->reports = $inHotspot->info->reports;

		$hotspot->infos = array($info);
		$hotspot->save();
	}
}