<?php

namespace App\Http\ApiModels;

class TagModel
{
	public $name;
	public $tags;
	public $comments;
	public $images;
	public $location;

	public function BuildModel($reqData)
	{

		// TODO: validation of data
		if(is_null($reqData))
			return;
		$this->name  = $reqData['name'];
		$this->tags = explode ( ' ' , $reqData['tags']);
		$this->comments = $reqData['comments'];
		$this->images = $reqData['images'];
		$this->location = $reqData['location'];

		for($i = 0; $i <  count($this->tags); $i++)
		{
			$this->tags[$i] = str_replace('#', '', $this->tags[$i]);
		}
	}

	public function BuildFromDbModel(Tag $tagDbModel)
	{
		$this->name = $tagDbModel->name;
		$this->tags = $tagDbModel->tags;
		$this->comments = $tagDbModel->comments;
		$this->images = $tagDbModel->images;
		$this->location = $tagDbModel->location;
	}
}