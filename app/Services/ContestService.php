<?php namespace App\Services;

use App\Entities\ContestEntity;
use App\Models\ContestModel;

class ContestService
{
    public static function getActiveContest()
    {
        $activeContests = array();
        $contestModel = new ContestModel();
        $activeContests = $contestModel->where('completion_status', '0')->find();
        return $activeContests;
    }

    public static function createContest()
    {
        $contest = new ContestEntity();
        $contest->completion_status = 0;
        $contestModel = new ContestModel();
        $contest->id = $contestModel->insert($contest);

        //TODO create static services methods
        JudgeService::createContestJudges($contest);

        ContestantService::createContestants($contest);

        RoundService::createContestRounds($contest);

        return $contest;
    }
}