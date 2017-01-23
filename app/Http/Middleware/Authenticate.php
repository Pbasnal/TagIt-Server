<?php namespace App\Http\Middleware;

use Closure;
use Chrisbjr\ApiGuard\Http\Middleware\ApiGuard;
use Log;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(ApiGuard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		Log::info('in authenticate handle');

		$response = $this->auth->handle($request, $next);
		$response->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With')
                ->header('Access-Control-Allow-Origin', '*');
		return $response;

	}

}
