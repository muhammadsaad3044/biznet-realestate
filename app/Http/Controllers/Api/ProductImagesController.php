<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\productImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;


class ProductImagesController extends Controller
{
    public function index(Request $request){
        try {
            
            $product = productImage::with('products')->get();   

            if($product){
                return response()->json([
                    'status'=>200,
                    'products'=>$product,
                    'imagePath'=>url('/uploads/products/'),
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
                'pd_id' => 'required|exists:products,id',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // $images = $request->file('image', []);
            $images = $request->image;
         
            
            foreach ($images as $index => $file) {
                    
                $image = "";
                
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $extension = $file->getClientOriginalExtension(); 
                    $filename = time() . $index . '.' . $extension;
                    $file->move('uploads/products/', $filename);
                    $image = $filename; // Save the filename
                }
    

    
                // Store the image and corresponding video (or null if no video)

                $dataArray = [
                    'pd_id' => $request->pd_id,
                    'image' => $image,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                
               
    
                productImage::insert($dataArray);



            }
            
                return response()->json([
                    'status' => 200,
                    'message' => 'Store Images Successfully!',
                ], 200);
                
                
       



        } catch (\Throwable $th) {

            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    public function storefloorimage(Request $request){
        try {
        
            $validator = Validator::make($request->all(), [
                'pd_id' => 'required|exists:products,id',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $floorimage = new productImage();
            $floorimage->pd_id = $request->pd_id;

            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/products/', $filename);
                $floorimage->floor_image = $filename;
            }
            
            $floorimage->save();
            
            
            if($floorimage){
            return response()->json([
                'status' => 200,
            ], 200);  
            }else{
            return response()->json([
                'status' => 400,
            ], 200);  
            }


        } catch (\Throwable $th) {

            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }

    public function update(Request $request, $id){
        try {

            $validator = Validator::make($request->all(), [
                'pd_id' => 'required|exists:products,id',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $product =  productImage::find($id);

            if(!$product){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $product->pd_id = $request->pd_id;
    
                if ($request->hasfile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/products/', $filename);
                    $product->image = $filename;
                }
                
                // For Floor Image
                if ($request->hasfile('floor_image')) {
                    $file = $request->file('floor_image');
                    $extension = $file->getClientOriginalExtension();
                    $filename1 = time() . '.' . $extension;
                    $file->move('uploads/products/', $filename1);
                    $product->floor_image = $filename1;
                }
    
    
                $product->save();

                return response()->json([
                    'status' => 200,
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
            
            $product =  productImage::find($id);
       
            if($product){

            $filePath = 'uploads/products/' . $product->image;
    
            // Check if the file exists in the storage
            if (Storage::exists($filePath)) {
                // Delete the file from the storage
                Storage::delete($filePath);
            }
                                
            $product->delete();
            
            
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
