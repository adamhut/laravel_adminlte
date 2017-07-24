<?php

namespace App\Http\Controllers;

use App\User;
use App\TempTable;
use Illuminate\Http\Request;
use App\Services\User\UserImport;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
    		return redirect()->back()->withErrors($validator);
    	}

    	$file  = $request->file('file');
    	
    	$csvData = file_get_contents($file);

    	$rows = array_map('str_getcsv',explode("\n", $csvData));
    	$headers = array_shift($rows);
    	
    	if(!$userImport->checkImportData($rows,$headers))
    	{
    		$request->session()->flash('error_rows',$userImport->getErrorRows());
    		$request->session()->flash('valid_rows',$userImport->getValidRows());

    		$request->session()->flash('error_rows_id',$userImport->getErrorRowsId());
    		$request->session()->flash('valid_rows_id',$userImport->getValidRowsId());
            

    		flash()->error('Error in data,Please correct it');
    		return redirect()->back();
    	}

    	
    	
    	flash('User are Imported');
    	return redirect()->back();
    }


    public function getImportData($uuid)
    {
        //$data = TempTable::where('uuid',$uuid)->firstOrFail();
        $filePath=public_path('download');
        //
        $data = TempTable::where('uuid',$uuid)
            ->where('user_id',auth()->id())
            ->first();

        if(!$data)
        {
            abort(400,'Can not find or Access Denied');
        }

        $data = collect(unserialize($data->data))->values(0)->toArray();

        $header = [];
        foreach($data[0] as $key=>$val)
        {
            $header[] = $key;
        }

        if(!file_exists($filePath)) 
        {
            mkdir($filePath ,755 , true);
        }

        $filename = time().'.csv';
        $handle= fopen($filePath.'/'.$filename,'w+');

        fputcsv($handle,$header);
        foreach($data as $row)
        {
             fputcsv($handle,$row);
        }

        $headers = [
            'Content-Type' =>'text/csv'
        ];

        return Response::download($filePath.'/'.$filename,$filename,$headers);

    }

    public function PersistIncompleteData($uuid,UserImport $userImport)
    {
        $data = TempTable::where('uuid',$uuid)
            ->where('user_id',auth()->id())
            ->firstOrFail();

        if(!$data)
        {
            abort(400,'Can not find or Access Denied');
        }

        $rows = collect(unserialize($data->data))->values(0)->toArray();
        //$data = collect(unserialize($data->data))->values(0);
        
        $headers = [];
        
        foreach($rows[0] as $key=>$val)
        {
            $headers[] = $key;
        }

        $userImport->createUsers($rows,$headers);
        $data->delete();
        flash('Users imported');
        return redirect()->back();
    }


    /***Manager Role Part***/
    /**
     * Get the page to see the list of roles and also the form to add a new role.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getManageRoles()
    {
        $roles = Role::orderBy('id', 'asc')->paginate(10);
        return view('adminlte.pages.admin.manage-roles', compact('roles'));
    }

}
