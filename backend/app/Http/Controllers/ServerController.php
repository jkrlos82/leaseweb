<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterPostRequest;
use App\Models\Server;

class ServerController extends Controller
{
    //
    public function index(){
        return response()->json(Server::all(), 200);
    }

    public function filters(FilterPostRequest $request){

        $data = $request->all();
        //dd($data['filters']);
        $response = Server::filters($data['filters']);
        return response()->json($response, 200);
    }

    public function getLocation(){
        $locations = Server::getLocations();

        return response()->json($locations, 200);
    }
}
