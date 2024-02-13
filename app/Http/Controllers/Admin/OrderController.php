<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\medicine;
use App\Models\OrderIteam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *      path="/admin/order/",
     *      operationId="order/list",
     *      tags={"Orders"},
     *      summary="Get record of order",
     *      description="Returns a list of order",
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
        $Order = Order::get();
        return response()->json(
            [
                'status' => true,
                'order' => $Order
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
     *      path="/admin/order",
     *      operationId="order/storesy",
     *      tags={"Orders"},
     *      summary="Store order",
     *      description="Store new order.",
     *      security={{"bearer":{}}},
     *      @OA\RequestBody(
     *          description="Array of categories to store",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="customer_info", type="object",
     *                  @OA\Property(property="customer_id", type="number" ,example="2"),
     *              ),
     *              @OA\Property(property="order_details", type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="order_id", type="number", example="1"),
     *                      @OA\Property(property="medicine_id", type="number", example="1"),
     *                      @OA\Property(property="item_price", type="number", example="139"),
     *                      @OA\Property(property="qty", type="number", example="4"),
     *                  ),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="order successfully stored"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Failed operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example="false"),
     *              @OA\Property(property="message", type="string", example="Invalid input data"),
     *          ),
     *      ),
     * )
     */



    public function store(Request $request)
    {


        $order = new Order;
        $order->customer_id = $request->customer_info['customer_id'];
        $order->save();
        $totalPrice = 0;
        $orderPrice = 0;

        $orderDetails = $request->order_details;
        $currentQty = 0;
        for ($i = 0; $i < count($orderDetails); $i++) {

            $medicine = Medicine::where('id', $orderDetails[$i]['medicine_id'])->first();
            $stock = $medicine->stock;
            $name = $medicine->name;

            if ($stock + 1 < $orderDetails[$i]['qty']) {
                $order->delete();
                return response()->json([
                    'status' => false,
                    'error' => "Stock unavailable for $name"
                ]);
            } else {

                $currentQty = $medicine->stock;
                $medicine->stock = $currentQty - $orderDetails[$i]['qty'];
                $medicine->save();
            }
            $medicineId = $orderDetails[$i]['medicine_id'];
            $itemPrice = $orderDetails[$i]['item_price'];
            $quantity = $orderDetails[$i]['qty'];
            $totalPrice += $itemPrice * $quantity;

            OrderIteam::create([
                'order_id' => $order->id,
                'medicine_id' => $medicineId,
                'iteam_price' => $itemPrice,
                'qty' => $quantity,
                'total_price' => $totalPrice
            ]);
            $orderPrice += $totalPrice;
            $totalPrice = 0;
            $currentQty = 0;
        }
        $order->total_price = $orderPrice;
        $order->save();

        return response()->json(
            [
                'status' => true,
                'message' => "Order Placed Successfully",
                'orderPrice' => $orderPrice
            ]
        );
    }




    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *      path="/admin/order/{id}",
     *      operationId="order/get{id}",
     *      tags={"Orders"},
     *      summary=" order single record",
     *      description="order single record",
     * security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id of record",
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
    public function show(string $id)
    {
        $order = order::with('order_items')->find($id);
        if (!$order) {
            return response()->json([
                'status' => false,
                'error' => 'Record Not Found!'
            ]);
        }
        return response()->json(
            [
                'status' => true,
                'order' => $order
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *      path="/admin/order/{id}",
     *      operationId="order/delete",
     *      tags={"Orders"},
     *      summary="order detete",
     *      description="delete  order",
     *       security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id for order",
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

     public function destroy(string $id)
    {   $order = order::find($id);
        if (!$order) {
            return response()->json([
                'status' => false,
                'error' => 'Record Not Found!'
            ]);
        }
        $order->delete();
        return   response()->json(['status' => true, 'message' => 'order deleted Successfully']);
    }
}
