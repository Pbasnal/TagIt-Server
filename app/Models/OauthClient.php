<?php
namespace App\Models;

use App\Http\ApiModels\OauthClientModel;
use Moloquent;
/**
 * Oauth_Client short summary.
 *
 * Oauth_Client description.
 *
 * @version 1.0
 * @author Basnal
 */
class OauthClient extends Moloquent
{
    protected $connection = 'mongodb';

    //public $id;
    //public $secret;
    //public $name;
    //public $created_at;
    //public $updated_at;

    public static function AddClient(OauthClientModel $inClient)
	{
        $clientResults = OauthClient::where("name", "=",  $inClient->name)->get();
        if(count($clientResults) != 0)
            return;

		$client = new OauthClient;
		$client->id  = $inClient->id;
		$client->secret = $inClient->secret;
		$client->name = $inClient->name;
        $client->created_at = $client->updated_at = date("Y-m-d H:i:s");

		$client->save();
	}
}