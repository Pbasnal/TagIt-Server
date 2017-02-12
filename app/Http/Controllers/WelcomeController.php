<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;

class WelcomeController extends ApiGuardController {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$sql = DB::connection('mysql')->getDatabaseName();

		$mongo = DB::connection('mongodb')->collection('users')->first();

		$html = "<h3>"."Sql"."</h3>".$sql."<h3>"."Mongo"."</h3>".print_r($mongo);

		return $html;
	}

}
