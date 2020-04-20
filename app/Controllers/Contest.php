<?php namespace App\Controllers;

use App\Services\ContestService;

class Contest extends BaseController
{
	public function index()
	{
        $contestService = new ContestService();
        $activeContest = $contestService->getActiveContest();
        if(empty($activeContest))
            $result = $contestService->createContest();
        else
            print_r("Contest Already in progress");
	}
}
