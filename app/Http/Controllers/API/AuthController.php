<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;

use App\Model\Profile;
use App\Traits\GeneralTrait;
use App\User;
// use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\File;

use Validator;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use GeneralTrait;
 /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        // Auth::user()->impersonate($other_user);

         $credentials = $request->only('email', 'password');
        // $aut=  JWTAuth::attempt($credentials);
        // $credentials = request(['email', 'password']);
        //      $pas =  request(['password' => bcrypt($request->password)]);
        //      $email =  request('email');

          //  'password' => bcrypt($request->password),
         // $validator->validated())

        $aut=  JWTAuth::attempt($credentials);
        if (! $token = $aut) {
            return response()->json(['error' => 'Unauthorized Yue '], 401);
        }


        $user = Auth::user();
        if($user->type === 'admin' || $user->type === 'writer'){

            return $this->respondWithToken($token);
        }



        return response()->json(['error' => 'You are not authorized'], 401);

    }



    public function register(Request $request){



        $validator = Validator::make($request -> all(),[
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password'=> 'required|string|min:6'
           ]);


        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }


      $user =  User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' =>Hash::make(request('password')),
            // 'image'=> $user1->getGravatar()

        ]);

        return $this->login(request());

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        // return response()->json(auth('api')->user());
        // return response()->json(['user' => auth()->user()], 200);
        return response()->json(auth()->user());
    }



    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
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

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }


        // $currentPhoto = $user->image;

        // if ($request->hasFile('image')) {
        //     $picName = time().'.'.$request->image->getClientOriginalExtension();
        //     $request->image->move(public_path('images/profile'),$picName );

        //         // Delet
        //         $file = $user->image;
        //         $file_name =public_path('images/profile/'.$file);
        //         File::delete($file_name);

        //         $user->update([
        //             'image' =>$picName
        //         ]);

        //    }

            // $user->update($request->all());
            $user->update([
                'email' => $request->email,
                'password' => $request->password,
                'name' => $request->name,

                'ins' => $request->ins,
                'twitter' => $request->twitter,
                'facebook' => $request->facebook,
                'about' => $request->about,



               ]);


         return $this->returnData('User',$user,"Profile Update succesfully",200);


        //  auth()->user()->update($request->all());
        // return response()->json([
        //     'status' => 'user profile was updated',
        //     'user' => auth()->user()
        // ], 200);




    }


    public function profile()
    {
        // return auth('api')->user();
        return response()->json(auth('api')->user());
    }




    public function logout()
    {
        auth()->logout();

        // return response()->json(['message' => 'Successfully ']);
        return $this->returnSuccessMessage("Successfully logged out",200);
    }




    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 ,
            'user' => auth()->user(),
            'msg' => ' تم  تسجيل الدخول',
        ]);
    }



// public function adminLogin(Request $request){
//     // validate request

//     $validator = Validator::make($request->all(), [
//         'email' => 'required|email',
//         'password' => 'required|string',
//     ]);

//     if (! $token = auth()->attempt($validator->validated())) {
//         return response()->json(['error' => 'Unauthorized user'], 401);
//     }

//     $user = Auth::user();
//     if($user->type === 'admin' || $user->type === 'writer'){

//         return $this->respondWithToken($token);
// }
// // else{
// //     // return response()->json(['error' => 'You are not authorized'], 401);
// //     // return $this->returnError(401,"You are not authorized");

// // }
//     return response()->json(['error' => 'You are not authorized'], 401);

//     // return $this->returnError(401,"You are not authorized");

// }


}
