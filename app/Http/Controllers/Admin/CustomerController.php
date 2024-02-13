<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *      path="/admin/customer/",
     *      operationId="customer/list",
     *      tags={"Customer"},
     *      summary="Get list of customer",
     *      description="Returns a list of customer",
     *       security={{"bearer":{}}},
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
        $customers = Customer::get();
        return response()->json(
            [
                'status' => true,
                'Customer' => $customers
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
     *      path="/admin/customer/",
     *      operationId="Customer/store",
     *      tags={"Customer"},
     *      summary="Customer  create",
     *      description="Customer  Customer",
     * security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         description="Customer create",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description=" name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     description=" phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     description=" email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="location_id",
     *                     description=" location_id",
     *                     type="string"
     *                 ),
     *                     required={"name", "phone","location_id"}
     *             )
     *           
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",    
     *           @OA\JsonContent(
     *              type="array",
     *              @OA\Items()
     *          )     
     *      ),
     * )
     */


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'email',
            'location_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'gmail' => $request->email,
            'location_id' => $request->location_id,
        ]);
        return   response()->json(['status' => true, 'message' => 'Customer created Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *      path="/admin/customer/{id}",
     *      operationId="Customer/update",
     *      tags={"Customer"},
     *      summary="Customer  create",
     *      description="Customer  Customer",
     * security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id for category",
     *         required=true,
     *      ),
     *     @OA\RequestBody(
     *         description="Customer create",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description=" name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     description=" phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     description=" email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="location_id",
     *                     description=" location_id",
     *                     type="string"
     *                 ),
     *                     required={"name", "phone","location_id"}
     *             )
     *           
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",    
     *           @OA\JsonContent(
     *              type="array",
     *              @OA\Items()
     *          )     
     *      ),
     * )
     */

    public function update(Request $request, Customer $customer)
    {
        $customer = Customer::findOrFail($customer->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:Customers,name,' . $customer->id, 'id'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }
        $customer->name = $request->name;
        $customer->save();
        return   response()->json(['status' => true, 'message' => 'Customer updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/admin/customer/{id}",
     *      operationId="Customer/delete",
     *      tags={"Customer"},
     *      summary="Customer detete",
     *      description="delete  Customer",
     *       security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id for Customer",
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

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return   response()->json(['status' => true, 'message' => 'customer deleted Successfully']);
    }
}
