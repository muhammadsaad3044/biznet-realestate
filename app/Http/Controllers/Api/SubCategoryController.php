<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sub_Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; 
use Carbon\Carbon;

class SubCategoryController extends Controller
{
    public function index($id){
        try {

            $categories = Sub_Category::leftjoin('categories', 'categories.id', '=', 'sub_categories.cat_id')
            ->select('categories.id as category_id', 'categories.cat_title', 'sub_categories.*')
            ->where('categories.id', $id)
            ->get()
            ->groupBy('category_id'); 
            

            $formattedData = [];
            
            foreach ($categories as $category_id => $subCategories) {
                $categoryTitle = $subCategories->first()->cat_title; // Get the category title
                $subCategoriesArray = $subCategories->map(function ($subCategory) {
                    
                    return [
                        'id' => $subCategory->id,
                        'sub_title' => $subCategory->sub_title,
                        'slug' => '/api/subcategory/' . Str::slug($subCategory->sub_title) .'/'. $subCategory->id,
                    ];
                });
            
                $formattedData[] = [
                    'cat_id' => $category_id,
                    'cat_title' => $categoryTitle,
                    'sub_categories' => $subCategoriesArray,
                ];
            }
            
            if (!empty($formattedData)) {
                return response()->json([
                    'status' => 200,
                    'categories' => $formattedData,
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Record Not Found!',
                ], 404);
            }


        } catch (\Throwable $th) {
            // Log the exception message
            Log::error('Error uploading images and videos: ' . $th->getMessage());
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }  
    }





    public function store(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'cat_id' => 'required|exists:categories,id',
                'sub_title' => 'required',
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $dataArray = [
                'cat_id' => $request->cat_id,
                'sub_title'=> $request->sub_title,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            Sub_Category::insert($dataArray);
            
    
            return response()->json([
                'status' => 200,
            ], 200);
    
        } catch (\Throwable $th) {
            // Log the exception message
            Log::error('Error uploading images and videos: ' . $th->getMessage());
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function update(Request $request, $id)
    {
        try {
           
            // Validate the request
            $validator = Validator::make($request->all(), [
                'cat_id' => 'required|exists:categories,id',
                'sub_title' => 'required',
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // CHeck If the Record exists of not 

            $subCategory = Sub_Category::find($id);

            if($subCategory){


            $subCategory->update([
                'cat_id' => $request->cat_id,
                'sub_title' => $request->sub_title,
                'updated_at' => Carbon::now(),
            ]);
                
        
                return response()->json([
                    'status' => 200,
                ], 200);

            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Record Not Found',
                ], 200);
            }
    

    
        } catch (\Throwable $th) {
            // Log the exception message
            Log::error('Error uploading images and videos: ' . $th->getMessage());
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }




    
    
        
        
    public function destory(Request $request, $id){
        try {
            
            $sub_category = Sub_Category::find($id);
            
            if($sub_category){
                
                $sub_category->delete();
                    
                return response()->json([
                    'status'=>200,
                    'message'=>'Sub Category Deleted Successfully!',
                ], 200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }

        } catch (\Throwable $th) {

            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);

        } 
    }
}
