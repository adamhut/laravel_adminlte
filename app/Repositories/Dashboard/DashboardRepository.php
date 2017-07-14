<?php
namespace App\Repositories\Dashboard;


interface DashboardRepository{

	public function userLastWeekActivities($userId);
}