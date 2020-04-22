<?php namespace App\Controllers;


use App\Models\ContestHistoryModel;
use App\Services\HistoryService;

class ContestHistory extends BaseController
{
	public function index()
	{
	}

	public function getPreviousContestWinners()
    {
        $previousContestWinners =  HistoryService::getPreviousContestWinners();
        echo json_encode($previousContestWinners);
    }

    public function getAllTimeWinner()
    {
        $response = array();
        $response[RESPONSE_CODE] = SUCCESS;
        $contestHistoryModel = new ContestHistoryModel();
        $response[RESPONSE_DATA] = $contestHistoryModel->getAllTimeWinner();

        echo json_encode($response);
    }
}
