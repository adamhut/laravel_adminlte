<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class UserApiController extends Controller
{
    
    public function postSidebarToggle(Request $request)
    {

        $userId = $request->user()->id;
        $user = User::where('id', $userId)->with('profile')->first();
        $options = $user->profile->options;

        if (isset($options['sidebar'])) {
            $options['sidebar'] = !$options['sidebar'];
        }

        $user->profile->options = $options;
        $user->profile->save();

        $redis = Redis::connection();
        $redis->publish('message',$user);

        return response(['data' => $user], 200);
    }

    public function postUploadProfilePic(Request $request)
    {
        $data = $request->input('img');
        list($type,$data) = explode(';', $data);
        list(,$data) = explode(',', $data);

        $data = base64_decode($data);

        $imageName = str_random(32).'.png';
        $path = public_path('profile_pics/');
        if(!file_exists($path))
        {
            mkdir($path,0755,true);
        }
        file_put_contents($path.$imageName, $data);
       
        $imageUrl = url('profile_pics/'.$imageName);

        $user = User::with('profile')->find($request->user()->id);
        $user->profile->removeCurrentProfilePic($user);

        $user->profile->profile_pic = $imageUrl;
        $user->profile->save();

        $redis = Redis::connection();
        $redis->publish('user_image_uploaded',$imageUrl);
        if($request->wantsJson())
        {
            return response(['data'=>$imageUrl],201);
        }
        return back();

    }

}