<?php 

namespace App\Repositories\Dashboard;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EloquentDashboard implements DashboardRepository
{

	public function userLastWeekActivities($userId)
	{
		$query = $this->baseQuery();
		$query->where('user_id',$userId);
		
		return $query->get();
		
	}

	public function systemLastWeekActivities($userId)
	{
		$query = $this->baseQuery();
		return $query->get();
	}

	private function baseQuery()
	{
		/*
		$select =[
			DB::raw("count(id) as count, DATE_FORMAT(created_at,'%M %d') as reportDate")
		];
		$query = DB::table('watchdogs');
		$query->select($select);
		$query->where('created_at','>',"'".Carbon::today()->subDays(7)."'")
			->where('created_at','<=',"'".Carbon::today()."'")

			->groupBy('reportDate');
		return $query;
		*/
	
		$select = [
            DB::raw("count(id) AS count, DATE_FORMAT(created_at, '%M %d') AS reportDate")
        ];
        $query = DB::table('watchdogs');
        $query->select($select);
        $query->where('created_at', '>', Carbon::today()->subDays(7));
        $query->where('created_at', '<', Carbon::today());
        $query->orderBy('reportDate', 'desc');
        $query->groupBy('reportDate');

        return $query;
	}
}