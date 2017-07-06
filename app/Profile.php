<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'profile_pic', 
        'country', 
        'twitter', 
        'facebook', 
        'skype', 
        'linkedin', 
        'options'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getOptionsAttribute($value)
    {
        return unserialize($value);
    }
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = serialize($value);
    }


    public function removeCurrentProfilePic($user=null)
    {
        $user = $user?:auth()->user();
        if(($url = $user->profile->profile_pic) !='')     
        {
            $fileName = explode('/', $url);
            $fileName = $fileName[count($fileName)-1];
            // /dd($fileName);
            unlink(public_path('profile_pics/').$fileName);
        }
    }
}
