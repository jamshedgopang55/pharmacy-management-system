<?php

namespace App\Http\Controllers\Admin;

use App\Models\medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MedicineContrller extends Controller
{
    /**
     * @OA\Get(
     *      path="/admin/medicines/",
     *      operationId="listMedicines",
     *      tags={"Medicines"},
     *      summary="Get list of medicines",
     *      description="Returns a list of medicines",
     *      security={{"bearer":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",    
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(type="integer") 
     *          )     
     *      ),
     * )
     */

    public function index()
    {
        $medicines = medicine::get();
        return response()->json(
            [
                'status' => true,
                'medicine' => $medicines
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
     *      path="/admin/medicines/",
     *      operationId="medicines/store",
     *      tags={"Medicines"},
     *      summary="medicines  create",
     *      description="medicines  Customer",
     * security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         description="medicines create",
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
     *                     property="generic_name",
     *                     description=" generic_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="buying_price",
     *                     description=" buying_price",
     *                     type="interger"
     *                 ),
     *                 @OA\Property(
     *                     property="selling_price",
     *                     description=" selling_price",
     *                     type="interger"
     *                 ),
     *                 @OA\Property(
     *                     property="stock_type",
     *                     description=" stock_type",
     *                      type="integer",
     *                     enum={0, 1}
     *                 ),
     *                 @OA\Property(
     *                     property="stock",
     *                     description=" stock",
     *                     type="interger"
     *                 ),
     *                 @OA\Property(
     *                     property="category_id",
     *                     description=" category_id",
     *                     type="interger"
     *                 ),
     *                     required={"name", "generic_name","buying_price","stock_type","stock"}
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
            'generic_name' => 'required|string',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_type' => 'required|in:0,1',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        medicine::create([
            'name' => $request->name,
            'generic_name' => $request->generic_name,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'stock_type' => $request->stock_type,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);
        return   response()->json(['status' => true, 'message' => 'Medicine created Successfully']);
    }

    /**
     * Display the specified resource.
     */

      /**
     * @OA\Get(
     *      path="/admin/medicines/{id}",
     *      operationId="medicines/get{id}",
     *      tags={"Medicines"},
     *      summary=" medicines",
     *      description="medicines",
      * security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id of medicines",
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
    public function show(medicine $medicine )
    {
        return response()->json(
            [
                'status' => true,
                'categories' => $medicine
            ]
        );
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
     *      path="/admin/medicines/{id}",
     *      operationId="medicines/update",
     *      tags={"Medicines"},
     *      summary="medicines  update",
     *      description="medicines  update",
     * security={{"bearer":{}}},
     * @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id for category",
     *         required=true,
     *      ),
     *     @OA\RequestBody(
     *         description="medicines create",
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
     *                     property="generic_name",
     *                     description=" generic_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="buying_price",
     *                     description=" buying_price",
     *                     type="interger"
     *                 ),
     *                 @OA\Property(
     *                     property="selling_price",
     *                     description=" selling_price",
     *                     type="interger"
     *                 ),
     *                 @OA\Property(
     *                     property="stock_type",
     *                     description=" stock_type",
     *                      type="integer",
     *                     enum={0, 1}
     *                 ),
     *                 @OA\Property(
     *                     property="stock",
     *                     description=" stock",
     *                     type="interger"
     *                 ),
     *                 @OA\Property(
     *                     property="category_id",
     *                     description=" category_id",
     *                     type="interger"
     *                 ),
     *                     required={"name", "generic_name","buying_price","stock_type","stock"}
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
    public function update(Request $request, string $id)
    {
        $medicine = medicine::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'generic_name' => 'required|string',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_type' => 'required|in:0,1',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }
        $medicine->name = $request->name;
        $medicine->generic_name = $request->generic_name;
        $medicine->buying_price = $request->buying_price;
        $medicine->generic_name = $request->generic_name;
        $medicine->selling_price = $request->selling_price;
        $medicine->stock_type = $request->stock_type;
        $medicine->stock = $request->stock;
        $medicine->category_id = $request->category_id;
        $medicine->save();
        return   response()->json(['status' => true, 'message' => 'Medicine updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
     /**
     * @OA\Delete(
     *      path="/admin/medicines/{id}",
     *      operationId="medicines/delete",
     *      tags={"Medicines"},
     *      summary="medicines detete",
     *      description="delete  medicines",
     *       security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id for medicines",
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

    public function destroy(medicine $medicine)
    {
        $medicine->delete();
        return   response()->json(['status' => true, 'message' => 'Medicine deleted Successfully']);
    }
}