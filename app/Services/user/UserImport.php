<?php
namespace App\Services\User;

use App\User;
use Illuminate\Support\Collection;


class UserImport 
{	
	protected $users = [];
	protected $valid = [];
	protected $errorRows = [];
	protected $validRows = [];
	protected $headers =[];

	public function checkImportData($rows, $headers)
	{
		//$this->headers = $headers;
		$emails = [];
		
		foreach($rows as $key => $row)
		{
			$row = array_combine($headers,$row);
			if(!$this->isValidEmail($row['email']))
			{
				$row['message']='Invalid Email';
				$this->errorRows[$key] = $row;
				$this->valid = false;
				continue;
			}
			if(!$this->isEmailExist($row['email']))
			{
				$row['message']='Email Exists';
				$this->errorRows[$key] = $row;
				$this->valid = false;
				continue;
			}
			$this->validRows[]= $row;
		}
		return $this->valid;
		
		/*
		 $rows->each(function($item ,$key) use($headers){
			if(!$this->checkValidEmail($item['email']))
			{

			}
    		$record  = $headers->combine($item);
    		$record->put('password',bcrypt('test0000'));
    		$record->put('active',0);
    		User::create($record->toArray());
    	});
		*/
	}

	public function createUsers($rows, $headers)
	{
		$collection = collect($rows);
    	$headers = collect($headers);
    	try {
    		\DB::beginTransaction();
    		$collection->each(function($item ,$key) use($headers){
	    		$record  = $headers->combine($item);
	    		$record->put('password',bcrypt('test0000'));
	    		$record->put('active',0);
	    		User::create($record->toArray());
	    	});	
    		\DB::commit();
    		
    	} catch (Exception $e) {
    		
    		\DB::rollback();
    		\Log::info($e->getMessage);
    	
    	}
    	
	}

	public function getErrorRows()
	{
		return $this->errorRows;
	}

	protected function isValidEmail($email)
	{
		if(! filter_var($email, FILTER_VALIDATE_EMAIL));
		{
			return false;
		}
		return true;
		return !! filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	protected function isEmailExist($email)
	{
		return User::where('email',$email)->exist();
	}

}