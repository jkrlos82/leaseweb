<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterPostRequest;
use App\Models\Server;

class ServerController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/servers",
     *      tags={"servers"},
     *      operationId="listServers",
     *      @OA\Response(
     *          response="200",
     *          description="Return Servers List details",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Error: seems to be a problem with the server."
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Error: Bad request."
     *      )
     * )
     *
     */
    public function index(){
        return response()->json(Server::all(), 200);
    }


    /**
     * @OA\Post(
     *     path="/api/servers/filters",
     *     tags={"servers"},
     *     summary="Filter the servers list",
     *     operationId="filter the servers list",
     *     @OA\Response(
     *          response="200",
     *          description="Return filter Servers List details",
     *          @OA\JsonContent()
     *     ),
     *      @OA\Response(
     *          response="400",
     *          description="Error: Bad request."
     *      ),
     *      @OA\RequestBody(
     *         description="Filters to be used",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                  property="filters",
     *                  type="object",
     *                  @OA\Property(
     *                      property="Storage",
     *                      type="object",
     *                      @OA\Property(
     *                          property="start",
     *                          type="string",
     *                          example="1TB"
     *                      ),
     *                      @OA\Property(
     *                          property="end",
     *                          type="string",
     *                          example="72TB"
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="RAM",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          enum={"2GB", "4GB", "8GB", "12GB", "16GB", "24GB", "32GB", "48GB", "64GB", "96GB"},
     *                          default="64GB"
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="HardDisk_Type",
     *                      type="string",
     *                      example="SATA"
     *                  ),
     *                  @OA\Property(
     *                      property="Location",
     *                      type="string",
     *                      example="AmsterdamAMS-01"
     *                  )
     *             )
     *         )
     *      )
     * )
     */
    public function filters(FilterPostRequest $request){

        try{
            $data = $request->all();
            $response = Server::filters($data['filters']);
            return response()->json($response, 200);
        }catch (\Exception $e){
            return response()->json(["Error"=>$e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/servers/filters/location",
     *      tags={"servers"},
     *      operationId="listLocations",
     *      @OA\Response(
     *          response="200",
     *          description="Return Location List details",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Error: seems to be a problem with the server."
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Error: Bad request."
     *      )
     * )
     *
     */
    public function getLocation(){
        $locations = Server::getLocations();

        return response()->json($locations, 200);
    }
}
