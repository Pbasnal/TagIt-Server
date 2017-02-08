<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\TagMain;
use App\Http\Requests;
use App\Http\ApiModels\PlaceSearchQueryModel;
use App\Http\ApiModels\HotspotModel;
use App\Models\Hotspot;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Log;

class TagController extends Controller
{
    private $tagMain;

    public function __construct()
    {
        $this->tagMain = new TagMain;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info("in tag controller");
        $dummyPlaces = $this->tagMain->DummyCall();

        return view('pages.places')->with('APP_KEY', config('googleapi.googlekey'))->with('dummyPlaces', json_encode($dummyPlaces));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO: Validations and verifications
        Log::info("in tag controller: store");
        Log::info(print_r($request->input('name'), true));
        $reqModel = new HotspotModel();
        $reqModel->BuildModel($request);
        $this->tagMain->StoreTag($reqModel);
        
        return Hotspot::all();
    }

    public function search(Request $request)
    {
        Log::info('tag controller');
        $reqModel = new PlaceSearchQueryModel();
        $reqModel->BuildModel($request->input('requestData'));
        $response = $this->tagMain->SearchPlace($reqModel);

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
