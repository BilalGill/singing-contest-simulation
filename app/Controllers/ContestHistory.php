<?php namespace App\Controllers;


use App\Services\HistoryService;

class ContestHistory extends BaseController
{
	public function index()
	{
	}

	public function getPreviousContestWinners()
    {
        HistoryService::getPreviousContestWinners();
    }
}
