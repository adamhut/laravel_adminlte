<?php
namespace App\Presenters;

use App\Profile;
use Laracasts\Presenter\Presenter;
use Illuminate\Support\Facades\Auth;

class UserPresenter extends Presenter
{
    public function profilePic()
    {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        if ($profile->profile_pic != null && $profile->profile_pic != '') {
            return $profile->profile_pic;
        } else {
            return url('adminlte/avatar.png');
        }
    }
}