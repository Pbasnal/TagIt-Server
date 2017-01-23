<?php
namespace App\Models;

use App\Http\ApiModels\TagModel;
use Moloquent;
/**
 * TagDb Model
 *
 * @author Pankaj Basnal 
 */

class Tag extends Moloquent
{
	protected $connection = 'mongodb';
	
	public static function InsertTag(TagModel $inTag)
	{
		$tag = new Tag;
		$tag->name  = $inTag->name;
		$tag->tags = $inTag->tags;
		$tag->comments = $inTag->comments;
		$tag->images = $inTag->images;
		$tag->location = $inTag->location;

		$tag->save();
	}
}