<?php

namespace App;

use App\Profile;
use App\Presenters\UserPresenter;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable,HasRoles;
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active',
    ];

    protected $presenter = UserPresenter::class;


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function profileUrl()
    {
        $url =   $this->profile->profile_pic!='' ? $this->profile->profile_pic:url('adminlte/avatar.png');
        return $url;
    }

    public function profilePic()
    {
        $profile = Profile::where('user_id', $this->id)->first();
        if ($profile->profile_pic != null && $profile->profile_pic != '') {
            return $profile->profile_pic;
        } else {
            return url('adminlte/avatar.png');
        }
    }

    
    
}
