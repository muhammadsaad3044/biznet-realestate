<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ProductOverviewSalesSection, products };
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ProductOverviewSalesSectionController extends Controller
{
    public function index(Request $request){
        try {
            
            $overview_sales = ProductOverviewSalesSection::get();   

            if($overview_sales){
                return response()->json([
                    'status'=>200,
                    'product_overview_sales_section'=>$overview_sales,
                ], 200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function store(Request $request){
        try {
            
            $validator = Validator::make($request->all(), [
                'p_id' => 'required|exists:products,id',
                'title' => 'required',
                'desc' => 'required',
                'price' => 'required',
                'est_price' => 'required',
                'price_tag' => 'required',
                'beds' => 'required',
                'bath' => 'required',
                'sq_ft' => 'required',
                'about_section_title' => 'required',
                'description' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $overview_sales = new ProductOverviewSalesSection();
            $overview_sales->p_id = $request->p_id;
            $overview_sales->title = $request->title;
            $overview_sales->desc = $request->desc;
            $overview_sales->price = $request->price;
            $overview_sales->est_price = $request->est_price;
            $overview_sales->price_tag = $request->price_tag;
            $overview_sales->beds = $request->beds;
            $overview_sales->bath = $request->bath;
            $overview_sales->sq_ft = $request->sq_ft;
            $overview_sales->about_section_title = $request->about_section_title;
            $overview_sales->description = $request->description;
            $overview_sales->save();
            
            
            if($overview_sales){
            return response()->json([
                'status' => 200,
                'message'=>' Added Successfully!',
            ], 200);  
            }else{
            return response()->json([
                'status' => 400,
                'message'=>'Something Went Wrong!',
            ], 200);  
            }


        } catch (\Throwable $th) {

            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function update(Request $request, $id){
        try {

            $validator = Validator::make($request->all(), [
                'p_id' => 'required|exists:products,id',
                'title' => 'required',
                'desc' => 'required',
                'price' => 'required',
                'est_price' => 'required',
                'price_tag' => 'required',
                'beds' => 'required',
                'bath' => 'required',
                'sq_ft' => 'required',
                'about_section_title' => 'required',
                'description' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $overview_sales =  ProductOverviewSalesSection::find($id);

            if(!$overview_sales){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $overview_sales->p_id = $request->p_id;
                $overview_sales->title = $request->title;
                $overview_sales->desc = $request->desc;
                $overview_sales->price = $request->price;
                $overview_sales->est_price = $request->est_price;
                $overview_sales->price_tag = $request->price_tag;
                $overview_sales->beds = $request->beds;
                $overview_sales->bath = $request->bath;
                $overview_sales->sq_ft = $request->sq_ft;
                $overview_sales->about_section_title = $request->about_section_title;
                $overview_sales->description = $request->description;
                $overview_sales->save();

                return response()->json([
                    'status' => 200,
                    'message'=>'Upodate Successfully!',
                ], 200);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function destory(Request $request, $id){
        
        try {
            $overview_sales =  ProductOverviewSalesSection::find($id);
            
            if($overview_sales){
          
            $overview_sales->delete();

            return response()->json([
                'status' => 200,
            ], 200);
            
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
}
