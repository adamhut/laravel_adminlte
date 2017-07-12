<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Services\User\UserImport;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    
    /**
     * reutrn impor user page
     * @return [type] [description]
     */
    public function importUser()
    {
    	
    	return view('adminlte.pages.admin.import-user');
    }


    /**
     * handle upload file
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function handleImportUser(Request $request, UserImport $userImport)
    {
    	$validator = Validator::make($request->all(),[
    		'file' =>'required'
    	]);

    	if($validator->fails())
    	{
    		return rediret()->back()->withErrors($validator);
    	}
    	
    	$file  = $request->file('file');
    	
    	$csvData = file_get_contents($file);

    	$rows = array_map('str_getcsv',explode("\n", $csvData));
    	$headers = array_shift($rows);
    	
    	if(!$userImport->checkImportData($rows,$headers))
    	{
    		$request->session()->flash('error_rows',$userImport->getErrorRows());
    		flash()->error('Error in data,Please correct it');
    		return redirect()->back();
    	}
    	$userImport->createUsers();
    	/*
    	$collection = collect($rows);
    	$headers = collect($collection->shift());
    	
    	$collection->each(function($item ,$key) use($headers){
    		$record  = $headers->combine($item);
    		$record->put('password',bcrypt('test0000'));
    		$record->put('active',0);
    		User::create($record->toArray());
    	});
		*/
    	flash('User are Imported');
    	return redirect()->back();
    	/*
    	$this->validate($request,[
    		'file' =>'required|file'
    	]);
    	*/
    }
}
