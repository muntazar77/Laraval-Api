<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Model\Profile;
use App\User;
use Illuminate\Support\Facades\File;

use App\Traits\GeneralTrait;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $users= User::paginate(10);

         return $this->returnData('users',$users,"Users read succesfully",200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , User $user)
    {
            $validator = Validator::make($request -> all(),[
                'email' => 'required|email|unique:users',
                'name' => 'required',
                'password'=> 'required|string|min:6'
               ]);


            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $users =  User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' =>Hash::make(request('password')),
                'type' => request('type'),
                // 'image'=> $user->getGravatar()
            ]);
            return $this->returnData('users',$users,"Users Created succesfully",200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request -> all(),[
            'email' => 'string|email',
            'name' => 'required',
            // 'password'=> 'required|string|min:6'
            'password' => 'sometimes|min:6'


           ]);

           if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);

        }

        $user = User::find($id);

        // if($request->password){
        //     $user->update([
        //         'password' => Hash::make(request('password')),

        //        ]);
        // }

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }


            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                // 'password' => Hash::make(request('password')),
                'type' => $request->type

               ]);

            return $this->returnSuccessMessage("succesfully updating User ",200);
    }

   
    public function destroy($id)
    {
        $user= User::find($id);



        // $file = $user->image;
        // $file_name =public_path('images/profile/'.$file);
        // File::delete($file_name);
        $user->delete();

        return $this->returnSuccessMessage("Sucess deleted User ",200);
    }



}
