<?php

namespace App\Http\Controllers\Admin;

use App\Models\location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class locationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *      path="/admin/location/",
     *      operationId="location/list",
     *      tags={"location"},
     *      summary="Get list of location",
     *      description="Returns a list of location",
      * security={{"bearer":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",    
     *           @OA\JsonContent(
     *              type="array",
     *              @OA\Items(type="integer") 
     *          )     
     *      ),
     * )
     */
    public function index()
    {
        $location =  location::all();

        return response()->json(
            [
                'status' => true,
                'locations' => $location
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Post(
     *      path="/admin/location",
     *      operationId="location/store",
     *      tags={"location"},
     *      summary="location store",
     *      description="store new location",
      * security={{"bearer":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Location data",
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string"),
     *          ),
     *      ),
     *      
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Failed operation",
     *      ),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:locations,name'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        location::create(
            [
                'name' => $request->name
            ]
        );
        return   response()->json(['status' => true, 'message' => 'location created Successfully']);
    }


    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *      path="/admin/location/{id}",
     *      operationId="location/get{id}",
     *      tags={"location"},
     *      summary="Get list of location",
     *      description="Returns a list of location",
      * security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id of Location",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",    
     *           @OA\JsonContent(
     *              type="array",
     *              @OA\Items(type="integer") 
     *          )     
     *      ),
     * )
     */
    public function show(location $location)
    {

        return response()->json(
            [
                'status' => true,
                'locations' => $location
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */


    public function edit(location $location)
    {
        return response()->json(
            [
                'status' => true,
                'locations' => $location
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */

      /**
     * @OA\Put(
     *      path="/admin/location/{id}",
     *      operationId="location/update",
     *      tags={"location"},
     *      summary="location update",
     *      description="update new location", 
      * security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id for Location",
     *         required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Location update",
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string"),
     *          ),
     *      ),
     *      
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Failed operation",
     *      ),
     * )
     */
    public function update(Request $request, string $id)
    {
        $location = location::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:locations,name,' . $id, 'id'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }
        $location->name = $request->name;
        $location->save();
        return   response()->json(['status' => true, 'message' => 'location updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */


    /**
     * @OA\Delete(
     *      path="/admin/location/{id}",
     *      operationId="location/delete",
     *      tags={"location"},
     *      summary="location store",
     *      description="delete  location",
      * security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id for Location",
     *         required=true,
     *      ),
     *      
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Failed operation",
     *      ),
     * )
     */

    public function destroy(location $location)
    {
        $location->delete();
        return   response()->json(['status' => true, 'message' => 'location deleted Successfully']);
    }
}
