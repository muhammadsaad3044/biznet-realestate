<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ProductOverviewAbouthomeSectionIcons};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ProductOverviewHomeSectionIconsController extends Controller
{
    public function index(Request $request){
        try {
            
            $overview_icons = ProductOverviewAbouthomeSectionIcons::get();   

            if($overview_icons){
                return response()->json([
                    'status'=>200,
                    'overview_home_section_icons'=>$overview_icons,
                    'imagePath'=>"https://biznetusa.com/uploads/products/",
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
                'image.*' => 'image|mimes:jpeg,png,jpg,gif',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $overview_icons = new ProductOverviewAbouthomeSectionIcons();
            $overview_icons->p_id = $request->p_id;
            $overview_icons->title = $request->title;

            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/products/', $filename);
                $overview_icons->icon = $filename;
            }

            $overview_icons->save();
            
            
            if($overview_icons){
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

            $overview_icons =  ProductOverviewAbouthomeSectionIcons::find($id);

            if(!$overview_icons){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $overview_icons->p_id = $request->p_id;
                $overview_icons->title = $request->title;
    
                if ($request->hasfile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/products/', $filename);
                    $overview_icons->icon = $filename;
                }
                $overview_icons->save();

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
            $overview_icons =  ProductOverviewAbouthomeSectionIcons::find($id);
       
        
            if($overview_icons){
                         
            $overview_icons->delete();

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
