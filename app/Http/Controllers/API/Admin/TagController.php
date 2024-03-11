<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Model\Tag;
use App\Traits\GeneralTrait;
use Validator;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class TagController extends Controller
{

    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $tags = Tag::all();
         return $this->returnData('tags',$tags,"Tags read succesfully",200);

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
        $validator = Validator::make($request -> all(),[
            'name' => 'required|string'
           ]);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }



       $tag =  Tag::create([
            'name' => $request->name,
            "slug" => Str::slug($request->name)
        ]);
        return $this->returnData('tags',$tag,"Tag Created succesfully",200);
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


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request -> all(),[
            'name' => 'required|string',
           ]);

           if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

           $tag = Tag::find($id);
            // $tag->name = $request->input('name');
            // $tag->save();

            $tag->update([
                "name" => $request->name,
                "title" => Str::slug($request->name)
            ]);


            return $this->returnSuccessMessage("succesfully updating Tag ",200);
    }


    public function destroy($id)
    {
        $tag= Tag::find($id);
        $tag->delete();

        return $this->returnSuccessMessage("Sucess deleted Tag ",200);
    }
}
