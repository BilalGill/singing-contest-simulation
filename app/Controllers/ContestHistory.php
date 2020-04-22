<?php namespace App\Controllers;


use App\Models\ContestHistoryModel;

class ContestHistory extends BaseController
{
    public function index()
    {
    }

    public function getPreviousContestWinners()
    {
        $contestHistoryModel = new ContestHistoryModel();
        $previousContestWinners = $contestHistoryModel->getPreviousContestWinners();
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
