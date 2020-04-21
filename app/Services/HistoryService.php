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
            print_r($topScorer);
            $contestHistoryModel = new ContestHistoryModel();
            $contestHistoryModel->insert($topScorer);
        }
        else
            print_r("Unexpected error occurred");
    }

    public static function getPreviousContestWinners()
    {
        $contestHistoryModel = new ContestHistoryModel();
        $contestantWinners = $contestHistoryModel->orderBy('date_created', 'desc')->findAll(NUMBER_OF_PREVIOUS_CONTEST_WINNERS);
        print_r(json_encode($contestantWinners));
    }

    public static function getAllTimeWinner()
    {
        $contestHistoryModel = new ContestHistoryModel();
        $result = $contestHistoryModel->getAllTimeWinner();
        if(count($result) > 0)
        {
            $allTimeWinner = $result[0];
        }
        else
            print_r("No Record Found");
    }
}