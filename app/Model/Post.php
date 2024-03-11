<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use sluggable,SoftDeletes;
    protected $fillable =['title','content','image','category_id','slug','user_id','featured','meta_description'];
    protected $dates = ['deleted_at'];


    public function sluggable(){
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    public function category(){
        return $this->belongsTo(Category::class);
    }

//users
    public function user(){
        return $this->belongsTo(User::class);
    }




      public function hasTag($tagId) {
        return in_array($tagId, $this->tags->pluck('id')->toArray());
      }



    //   public function scopeOnline($query, $condition = true)
    //   {
    //       return $query->where(["online" => $condition]);
    //   }


}
