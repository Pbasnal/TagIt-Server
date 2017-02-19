<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Hotspot;
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
		$html = "<h3>"."Hotspots"."</h3>".Hotspot::all();

		return 'Welcome';
	}

}
