<?php

namespace App\Http\Controllers\Api;

use App\TempTable;
use Illuminate\Http\Request;
use App\Services\User\UserImport;
use App\Http\Controllers\Controller;

class AdminApiController extends Controller
{
    //
    //
    public function PersistIncompleteData($uuid,UserImport $userImport)
    {
    	$data = TempTable::where('uuid',$uuid)
            ->where('user_id',auth()->id())
            ->firstOrFail();

        if(!$data)
        {
        	return response('can not find the data or access denied',400);
        }

        $rows = collect(unserialize($data->data))->values(0)->toArray();      
        
        $count = count($rows);

        $headers = [];

        if($count==0)
        {
        	return response('can not find the data',400);
        }
        
        foreach($rows[0] as $key=>$val)
        {
            $headers[] = $key;
        }

        $userImport->createUsers($rows,$headers);
        
        $data->delete();

        return response('Total user imported:'.$count,201);
        
        //flash('Users imported');
        //return redirect()->back();
    }

    public function editWrongUsers ($uuid)
    {
    	$data = TempTable::where('uuid',$uuid)
            ->where('user_id',auth()->id())
            ->firstOrFail();

        if(!$data)
        {
        	return response('can not find the data or access denied',400);
        }
        $data =unserialize($data->data);
        return response($data,200);
        //$rows = collect(unserialize($data->data))->values(0)->toArray();	
    }

}
