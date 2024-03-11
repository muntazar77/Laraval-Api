<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\File;

use Validator;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class CategoryController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $categories =Category::paginate(10);


    //     return $this->returnData('categories',$categories,"Categories read succesfully",200);

    // }




       public function index()
        {
            $categories =Category::paginate(10);
            $user= auth('api')->user()->id ;
            return response()->json([
                'status' => true,
                'errNum' => 200,
               'categories' => $categories,
               'user_id' => $user
            ]);

            // return $this->returnData('categories',$categories,"Categories read succesfully",200);

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
    public function store(Request $request)
    {

        $rules = [
            "name" => "required",
            "about" => "required",
            // "image"=>"required|image"

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }


        // $picName = time().'.'.$request->image->getClientOriginalExtension();
        // $request->image->move(public_path('images/category'),$picName );


       $category =  Category::create([
            'name' => request('name'),
            'about' => request('about'),
            // 'image'=>$picName
        ]);
        return $this->returnData('categories',$category,"Sucess Create Category",200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return Category::FindOrFail($id);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $rules = [
            "name" => "required",
            "about" => "required",
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }



        // if ($request->hasFile('image')) {
        //     $picName = time().'.'.$request->image->getClientOriginalExtension();
        //     $request->image->move(public_path('images/category'),$picName );

        //     $category = Category::find($id);
        //         // image
        //         $file = $category->image;
        //         $file_name =public_path('images/category/'.$file);
        //         File::delete($file_name);
        //         $category->update([
        //             'image' =>$picName
        //         ]);
        //    }

           $category1 = Category::find($id);

        //    $category2->update([$request->all()]);

            $category1->update([
                'name' => $request->name,
                'about' => $request->about,
               ]);


            return $this->returnSuccessMessage("Sucess updating category ",200);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

            $category = Category::find($id);


            // $file = $category->image;
            // $file_name =public_path('images/category/'.$file);
            // File::delete($file_name);
            $category->delete();

            return $this->returnSuccessMessage("Sucess deleted category ",200);


    }
}
