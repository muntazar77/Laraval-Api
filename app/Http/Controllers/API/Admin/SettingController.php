<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Model\Setting;
use App\Traits\GeneralTrait;
use Validator;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use GeneralTrait;
    public function index(){


        $settings = Setting::first();
        return $this->returnData('settings',$settings,"settings read succesfully",200);

    }

    public function update(Request $request){


$validator = Validator::make($request -> all(),[
    'log_name'=>'required',
    // 'log_image'=>'required',

    'phone'=>'required',
    'email'=>'required',
    'about'=>'required',
    'instegrm'=>'required',
    'facebook'=>'required',
    'twitter'=>'required',
    'addres'=>'required',
    // 'description'=>'required',

   ]);

   if ($validator->fails()) {
    $code = $this->returnCodeAccordingToInput($validator);
    return $this->returnValidationError($code, $validator);
}


// if ($request->log_image) {
//     $picName = time().'.'.$request->log_image->getClientOriginalExtension();
//     $request->log_image->move(public_path('images'),$picName );

//     $category = Setting::find();
//         // image
//         $file = $category->image;
//         $file_name =public_path('images/category/'.$file);
//         File::delete($file_name);
//         $category->update([
//             'image' =>$picName
//         ]);
//    }

        $setting = Setting::first();
        $setting->update([
           'log_name' => $request->log_name ,
           'phone' =>$request->phone,
            'email' => $request->email ,
            'about' => $request->about,
            'instegrm' => $request->instegrm ,
            'facebook' => $request->facebook ,
            'twitter' => $request->twitter ,
            'addres' => $request->addres ,
            // 'description' => $request->addres ,

           ]);


        return $this->returnSuccessMessage("succesfully updating Setting ",200);
    }
}
