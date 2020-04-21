<?php namespace App\Controllers;

use App\Services\ContestService;

class Contest extends BaseController
{
	public function index()
	{
        ContestService::getActiveContest();
        if(empty($activeContest))
            $result = ContestService::createContest();
        else
            print_r("Contest Already in progress");
	}
}
