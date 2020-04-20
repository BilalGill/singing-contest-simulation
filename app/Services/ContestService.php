<?php namespace App\Services;

use App\Entities\ContestEntity;
use App\Models\ContestModel;

class ContestService
{
    public function getActiveContest()
    {
        $activeContests = array();
        $contestModel = new ContestModel();
        $activeContests = $contestModel->where('completion_status', '0')->find();
        return $activeContests;
    }

    public function createContest()
    {
        $contest = new ContestEntity();
        $contest->completion_status = 0;
        $contestModel = new ContestModel();
        $contest->id = $contestModel->insert($contest);

        //TODO create static services methods
        $judgeService = new JudgeService();
        $judgeService->createContestJudges($contest);

        $contestantService = new ContestantService();
        $contestantService->createContestants($contest);

        $roundService = new RoundService();
        $roundService->createContestRounds($contest);

        return $contest;
    }
}