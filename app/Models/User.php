<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'screen_name',
        'name',
        'email',
        'password',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAllUsers($user_id){
        return $this->where('id', '<>', $user_id)->paginate(6);
    }


    public function userUpdate(Array $params)
    {

        if(isset($params['profile_image'])){
        $this::where('id', $this->id)
          ->update([
            'screen_name' => $params['screen_name'],
            'name' => $params['name'],
            'self_introduction' => $params['self_introduction'],
            'profile_image' => $params['profile_image'],
            'email' => $params['email'],
          ]);
      } else {
        $this::where('id', $this->id)
          ->update([
            'screen_name' => $params['screen_name'],
            'name' => $params['name'],
            'self_introduction' => $params['self_introduction'],
            'email' => $params['email'],
          ]);
      }
      return;
    }
}

