<?php namespace App\Services;


use App\Models\ContestContestantModel;
use App\Models\ContestHistoryModel;

class HistoryService
{
    public static function saveCompletedContest($contest)
    {
        $contestantModel = new ContestContestantModel();
        $result = $contestantModel->getTopScorer($contest->id);
        if(count($result) > 0)
        {
            $topScorer = $result[0];

            $contestHistoryModel = new ContestHistoryModel();
            $contestHistoryModel->insert($topScorer);
        }
    }

    public static function getPreviousContestWinners()
    {
        $response = array();
        $response[RESPONSE_CODE] = SUCCESS;

        $contestHistoryModel = new ContestHistoryModel();
        $response[RESPONSE_DATA] = $contestHistoryModel->orderBy('date_created', 'desc')->findAll(NUMBER_OF_PREVIOUS_CONTEST_WINNERS);

        return $response;
    }

    public static function getAllTimeWinner()
    {
        $response = array();
        $response[RESPONSE_CODE] = SUCCESS;

        $contestHistoryModel = new ContestHistoryModel();
        $result = $contestHistoryModel->getAllTimeWinner();
        if(count($result) > 0)
        {
            $response[RESPONSE_DATA] = $result[0];
        }
        else
        {
            $response[RESPONSE_MESSAGE] = "No Record Found";
        }

        return $response;
    }
}