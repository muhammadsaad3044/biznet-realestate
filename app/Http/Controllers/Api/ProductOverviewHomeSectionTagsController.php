<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ProductOverviewAbouthomeSectiontags};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ProductOverviewHomeSectionTagsController extends Controller
{
    public function index(Request $request){
        try {
            
            $overview_tags = ProductOverviewAbouthomeSectiontags::get();   

            if($overview_tags){
                return response()->json([
                    'status'=>200,
                    'overview_home_section_tags'=>$overview_tags,
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
                'tag_name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $overview_tags = new ProductOverviewAbouthomeSectiontags();
            $overview_tags->pd_id = $request->p_id;
            $overview_tags->tag_name = $request->tag_name;
            $overview_tags->save();
            
            
            if($overview_tags){
            return response()->json([
                'status' => 200,
                'message'=>'Added Successfully!',
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
                'tag_name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $overview_tags =  ProductOverviewAbouthomeSectiontags::find($id);

            if(!$overview_tags){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $overview_tags->pd_id = $request->p_id;
                $overview_tags->tag_name = $request->tag_name;
                $overview_tags->save();

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
            $overview_tags =  ProductOverviewAbouthomeSectiontags::find($id);
       
        
            if($overview_tags){
                         
            $overview_tags->delete();

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
