<?php

namespace App;

use App\Model\Post;
use App\Model\Profile;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
use Impersonate;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','image','about' ,'facebook' ,'twitter' ,'ins' ,'type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


 /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // public function profile() {
    //     return $this->hasOne(Profile::class);
    //   }

    // public function getGravatar() {
    //     $hash = md5(strtolower(trim($this->attributes['email'])));
    //     return "http://gravatar.com/avatar/$hash";
    //   }


    public function posts() {
        return $this->hasMany(Post::class);
      }




      public function isAdmin() {
        return $this->type === 'admin';
      }

      public function AdminOrWriter() {
        return $this->type === 'admin'|| $this->type === 'writer';
      }


      public function isWriter() {
        return $this->type === 'writer';
      }

}
