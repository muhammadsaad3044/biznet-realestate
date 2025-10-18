<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatsNew;
use App\Models\WhatsNewImages;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class WhatsNewImagesController extends Controller
{
    public function index(Request $request){
        try {
            
            $whatsnewimage = WhatsNewImages::get();   

            if($whatsnewimage){
                return response()->json([
                    'status'=>200,
                    'whatsnewimages'=> $whatsnewimage,
                    'imagePath'=>url('/uploads/whatsnew/') . '/',
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
                'whats_new_id' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $whatsnewimage = new WhatsNewImages();
            $whatsnewimage->whats_new_id = $request->whats_new_id;
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/whatsnew/', $filename);
                $whatsnewimage->image = $filename;
            }
            $whatsnewimage->save();
            
            
            if($whatsnewimage){

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
                'whats_new_id' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $whatsnewimage =  WhatsNewImages::find($id);

            if(!$whatsnewimage){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $whatsnewimage->whats_new_id = $request->whats_new_id;
                if ($request->hasfile('image')) {

                    // Delete the previous image if it exists
                    if ($whatsnewimage->image && file_exists(public_path('uploads/whatsnew/' . $whatsnewimage->image))) {
                        unlink(public_path('uploads/whatsnew/' . $whatsnewimage->image));
                    }

                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/whatsnew/', $filename);
                    $whatsnewimage->image = $filename;
                }
                $whatsnewimage->save();

                return response()->json([
                    'status' => 200,
                    'message'=>'Update Successfully!',
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

            $whatsnewimage =  WhatsNewImages::find($id);
    
            if($whatsnewimage){

            // Delete the previous image if it exists

            if ($whatsnewimage->image && file_exists(public_path('uploads/whatsnew/' . $whatsnewimage->image))) {
            unlink(public_path('uploads/whatsnew/' . $whatsnewimage->image));
            }    

            $whatsnewimage->delete();

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
