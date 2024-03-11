<?php

namespace App\Http\Controllers\API\Admin;

use App\Filters\PostsFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;

use Illuminate\Support\Facades\Session;
use App\Http\Resources\PostResource;
use App\Model\Post;
// use Intervention\Image\ImageManager;
// use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Facades\Image;

use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\File;
use Validator;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class PostController extends Controller
{
    use GeneralTrait;



    public function __construct(PostsFilter $filter)
    {
        $this->filter = $filter;
    }



    public function index()
    {
        $filteredPosts  = $this->filter->apply(
            request()->all(),
            // Post::latest()
            Post::inRandomOrder()

        );

        $posts = $filteredPosts->paginate(8);

        return new PostCollection($posts);
    }

    public function all()
    {
        // return new PostCollection(Post::latest()->get());

        // $filteredPosts =Post::all();
        // $posts= $filteredPosts->paginate(3);
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return $this->returnData('posts',$posts,"Posts read succesfully",200);




    }

    public function create()
    {
        //
    }


    public function store(Request $request,Post $post1)
    {

        $validator = Validator::make($request -> all(),[
            'title'=>'required|unique:posts',
            // 'des'=>'required',
            'content'=>'required',
            'image'=>'required|image',
            'category_id'=>'required',

           ]);

           if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        // $picName = time().'.'.$request->image->getClientOriginalExtension();
        // $request->image->move(public_path('images/posts'),$picName );


        // $picName = time().'.'.$request->image->getClientOriginalExtension();
        // Image::make($request->image)->save(public_path('images/posts/').$picName);


        $photo = $request->image;
        $filename = time() .'.'. $photo->getClientOriginalExtension();
        $location = public_path('images/posts/'.$filename);

        Image::make($photo)->resize(800, 451)->save($location);




        $post = Post::create([
            'title'=>$request->title,
            'meta_description'=>$request->meta_description,
            'content'=>$request->content,
            'image'=>$filename,
            'category_id'=>$request->category_id,
            'featured'=>$request->featured,
            // 'slug'=> str_slug($request->title),
            // "slug" => Str::slug($request->name)

            'user_id'=>$request->user_id
         ]);

         return $this->returnData('Post',$post,"Pots Created succesfully",200);
    }




    public function show($id) : PostResource
    {
              $post= Post::FindOrFail($id);

        return new PostResource($post);
    }





    public function edit($id)
    {
    }







    public function update(Request $request, Post $post)

    {
        $validator = Validator::make($request -> all(),[
            'title'=>'required',
            'content'=>'required',

           ]);

           if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }


        if ($request->hasFile('image')) {

            $photo = $request->image;
            $picName = time() .'.'. $photo->getClientOriginalExtension();
            $location = public_path('images/posts/'.$picName);

            Image::make($photo)->resize(800, 451)->save($location);
                // Delet
                $file = $post->image;
                $file_name =public_path('images/posts/'.$file);
                File::delete($file_name);
                $post->update([
                    'image' =>$picName
                ]);
           }
           $post->slug = null;
        //    $post->update(['title' => 'My New Title']);

           $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'featured' =>$request->featured,
            'meta_description' =>$request->meta_description,

           ]);

           return $this->returnSuccessMessage("succesfully updating Post ",200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $post =Post::find($id);
        $post= Post::withTrashed()->where('id',$id)->first();
        // $post= Post::withTrashed()->where('id',$id)->first();





        if ($post->trashed()) {
            $file = $post->image;
        $file_name =public_path('images/posts/'.$file);

        File::delete($file_name);
        $post->forceDelete();

        //     Storage::disk('public')->delete($post->image);
        //   $post->forceDelete();


        }else {
            $post->delete();
        }
               return $this->returnSuccessMessage("Sucess deleted Post ",200);


    }


    public function trashed(){

        $trashed= Post::onlyTrashed()->get();
        return $this->returnData('posts',$trashed,"Pots Restore succesfully",200);

    }
    public function restore($id){
      $post=  Post::withTrashed()->where('id',$id)->restore();
        return $this->returnData('posts',$post,"Pots Restore succesfully",200);

    }
}
