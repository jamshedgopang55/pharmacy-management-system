<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *      path="/admin/category/",
     *      operationId="category/list",
     *      tags={"category"},
     *      summary="Get list of category",
     *      description="Returns a list of category",
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
        $categories = Category::all();
        return response()->json(
            [
                'status' => true,
                'categories' => $categories
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
     *      path="/admin/category",
     *      operationId="category/store",
     *      tags={"category"},
     *      summary="Store multiple categories",
     *      description="Store new categories.",
     *      security={{"bearer":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Array of categories to store",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="name", type="string", example="Category 1"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Categories successfully stored"),
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


        $categories = $request->json()->all();

        foreach ($categories as $categoryData) {
            $validator = Validator::make($categoryData, [
                'name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            Category::create([
                'name' => $categoryData['name']
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Categories created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json(
            [
                'status' => true,
                'categories' => $category
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */



    public function edit(Category $category)
    {
        return response()->json(
            [
                'status' => true,
                'categories' => $category
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *      path="/admin/category/{id}",
     *      operationId="category/update",
     *      tags={"category"},
     *      summary="category update",
     *      description="update new category", 
     *       security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id for category",
     *         required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="category update",
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


    public function update(Request $request, Category $category)
    {
        $category = Category::findOrFail($category->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $category->id, 'id'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }
        $category->name = $request->name;
        $category->save();
        return   response()->json(['status' => true, 'message' => 'Category updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/admin/category/{id}",
     *      operationId="category/delete",
     *      tags={"category"},
     *      summary="category delete",
     *      description="delete  category",
     *       security={{"bearer":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pass id for category",
     *         required=true,
     *      ),
     * security={{"bearer":{}}},
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

    public function destroy(Category $category)
    {
        $category->delete();
        return   response()->json(['status' => true, 'message' => 'Category deleted Successfully']);
    }
}
