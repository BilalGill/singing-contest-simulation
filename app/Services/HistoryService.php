<?php namespace App\Services;


use App\Models\ContestContestantModel;
use App\Models\ContestHistoryModel;

class HistoryService
{
    /**
     * Save completed contest info into the history table
     *
     * @param $contest
     * @throws \ReflectionException
     */
    public static function saveCompletedContest($contest)
    {
        $contestantModel = new ContestContestantModel();
        $topScorer = $contestantModel->getTopScorer($contest->id);
        if (!empty($topScorer)) {
            $contestHistoryModel = new ContestHistoryModel();
            $contestHistoryModel->insert($topScorer);
        }
    }

    /**
     * get contest with maximum score of all time
     * if two or more contestants have same score than both are selected as all time winners
     *
     * @return array
     */
    public static function getAllTimeWinner()
    {
        $response = array();
        $response[RESPONSE_CODE] = SUCCESS;

        $contestHistoryModel = new ContestHistoryModel();
        $result = $contestHistoryModel->getAllTimeWinner();
        if (count($result) > 0) {
            $response[RESPONSE_DATA] = $result[0];
        } else {
            $response[RESPONSE_MESSAGE] = "No Record Found";
        }

        return $response;
    }
}