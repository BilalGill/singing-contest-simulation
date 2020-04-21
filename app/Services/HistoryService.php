<?php namespace App\Services;


use App\Models\ContestantModel;
use App\Models\ContestContestantModel;
use App\Models\ContestHistoryModel;

class HistoryService
{
    public function saveCompletedContest($contest)
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

    public function getPreviousContestWinners()
    {
        $contestHistoryModel = new ContestHistoryModel();
        $contestantWinners = $contestHistoryModel->orderBy('date_created', 'desc')->findAll(5);
        print_r(json_encode($contestantWinners));
    }

    public function getAllTimeWinner()
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