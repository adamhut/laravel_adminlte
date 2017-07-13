<?php
namespace App\Services\User;

use App\User;
use App\TempTable;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Collection;


class UserImport 
{	
	protected $users = [];
	protected $valid = true;
	protected $errorRows = [];
	protected $validRows = [];
	protected $headers =[];
	protected $errorRowsId = '';
	protected $validRowsId = '';

	//protected $rows = [];

	public function checkImportData($rows, $headers)
	{
		//$this->headers = $headers;
		$emails = [];
		
		foreach($rows as $key => $row)
		{
			$row = array_combine($headers,$row);
			$this->rows = $row;
			if(!$this->isValidEmail($row['email']))
			{
				
				$row['message']='Invalid Email';
				$this->errorRows[$key] = $row;
				$this->valid = false;
				continue;
			}
			if($this->isEmailExist($row['email']))
			{
				$row['message']='Email Exists';
				$this->errorRows[$key] = $row;
				$this->valid = false;
				continue;
			}
			if(in_array($row['email'], array_column($this->validRows, 'email')))
			{
				$row['message']='Duplicate Email in Upload File';
				$this->errorRows[$key] = $row;
				$this->valid = false;
				continue;
			}
			$this->validRows[]= $row;
		}
		$this->storeDataIntoTempTable();
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
		//$this->errorRows =collect($this->errorRows)->values()->toArray();
		ksort($this->errorRows);
		return $this->errorRows;
	}

	public function getValidRows()
	{
		//$this->errorRows =collect($this->errorRows)->values()->toArray();
		//ksort($this->errorRows);
		return $this->validRows;
	}

	protected function isValidEmail($email)
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //"Invalid email format";
            return false;
        }
		return true;
		//return !! filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	protected function isEmailExist($email)
	{
		return User::where('email',$email)->exists();
	}

	protected function storeDataIntoTempTable()
	{
		ksort($this->errorRows);

		$row = TempTable::create([
			'uuid' => Uuid::generate(),
			'user_id' => auth()->user()->id,
			'data' => serialize($this->errorRows),
		]);
		$this->errorRowsId = $row->uuid->string;

		$row = TempTable::create([
			'uuid' => Uuid::generate(),
			'user_id' => auth()->user()->id,
			'data' => serialize($this->validRows),
		]);
		$this->validRowsId = $row->uuid->string;		
		return $this;
	
	}

	public function getErrorRowsId()
	{
		return $this->errorRowsId;
	}
	
	public function getValidRowsId()
	{
		return $this->validRowsId;
	}

}