<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Filters\PostsFilter;
use App\Model\Category;
use App\Model\Post;
use App\Traits\GeneralTrait;
use App\User;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    use GeneralTrait;

    public function __construct(PostsFilter $filter)
    {
        $this->filter = $filter;
    }

//   ####### منشورات ذات صلة########
    public function relatedPost($slug){

        $post =Post::where('slug','=', $slug)->first();
        $related= Post::where('category_id', '=', $post->category->id)->where('id', '!=', $post->id)->take(3)->get();


        // $filteredPosts  = $this->filter->apply(
        //     request()->all(),
        //     // Post::latest()
        //     $related

        // );

        return new PostCollection($related);
    }


    // منشورات اكثر مشاهدة
    public function mostViwe(){

        // $post =Post::where('slug','=', $slug)->first();

        $view_post = Post::orderBy('visits', 'desc')->take(4)->get();
        return new PostCollection($view_post);


    }


    // منشورات المميزة

    public function featuredPost(){



            $one = Post::where('featured','1')->orderBy('created_at','desc')->first();
            $to = Post::where('featured','1')->orderBy('created_at','desc')->skip(1)->take(1)->get()->first();
            $thre = Post::where('featured','1')->orderBy('created_at','desc')->skip(2)->take(1)->get()->first();
            $for = Post::where('featured','1')->orderBy('created_at','desc')->skip(2)->take(1)->get()->first();


        return response()->json([
            'f1' => $one,
            'f2' => $to,
            'f3' => $thre,
            'f4' => $for,
        ]);
    }



    // احدث منشورات

    public function newsPost(){

        $new_post = Post::orderBy('created_at','desc')->take(3)->get();

        return new PostCollection($new_post);


    }

    public function singPost($slug)
    {
       $post =Post::where('slug','=', $slug)->first();

         // //view_count or view_post
         $blogKey = 'blog_' . $post->id;
         if (!Session::has($blogKey)) {
             $post->increment('visits');
             Session::put($blogKey,1);
         }

        return new PostResource($post);
    }






    public function categoryAll(){

        $categories =Category::all();
        // $categoryHed = Category::orderBy('created_at','desc')->take(8)->get();
        $categoryHed = Category::take(8)->get();


        return response()->json([
            'status' => true,
            'categories' => $categories,
            'categoryHed' => $categoryHed,


        ]);
    }



    public function categoryPosts($id){

        // posts category
        $category = Category::find($id);
        // $nameCategory = $category->name;
        $posts = $category->posts()->paginate(6);


        // return $this->returnData('categories',$categories,"Categories read succesfully",200);

        // return response()->json([
        //     'nameCategory' =>$nameCategory
        // ]);


        return new PostCollection($posts);


    }

    public function categoryName($id){

        // posts category
        $category = Category::find($id);
        // $nameCategory = $category->name;
        // $aboutCategory =$category->about;



        return response()->json([
            // 'aboutCategory' =>$aboutCategory,
            // 'nameCategory' =>$nameCategory
            'category' =>$category
        ]);

    }



    // عدد المقالات الكلية
    // عدد المقالات لكل قسم
    // عدد مقالات لكل مستخدم
    // عدد الاقسام
    // عدد المستخدمين




    public function count(){
        // $categories = Category::withCount('posts')->count();
        $user= auth('api')->user()->id;
        // $user->po
        $featured = Post::where('user_id',$user)->count();

    //    ->with('trashed_count' , Post::onlyTrashed()->get()->count())  ;



        return response()->json([
            'posts_count'=> Post::all()->count(),
            'users_count'=>User::all()->count() ,
            'categories_count'=>Category::all()->count() ,
            'users_posts' => $featured,

        ]);



    }

    public function searchposts($query){
        $posts = Post::where('title','like','%'.$query.'%')->with('user');
        //get all rows //count
        // $nbposts = count($posts->get());


        // $posts = $posts->paginate(intval($nbposts));
        return response()->json($posts);
    }


    public function search(Request $request)
    {
        $posts=Post::where('title','like','%'.$request->keywords.'%')->take(3)->get();

        return response()->json($posts);

    }


}

