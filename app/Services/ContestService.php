<?php namespace App\Services;

use App\Entities\ContestEntity;
use App\Entities\JudgeEntity;
use App\Entities\ContestJudgeEntity;
use App\Models\ContestModel;
use App\Models\JudgeModel;
use App\Models\ContestJudgeModel;

class ContestService
{
    public function createContest()
    {
        $contest = new ContestEntity();
        $contest->completion_status = 0;
        $contestModel = new ContestModel();
        $contest->id = $contestModel->insert($contest);

        $judgeService = new JudgeService();
        $judgeService->createContestJudges($contest);

        $contestantService = new ContestantService();
        $contestantService->createContestants($contest);

        $roundService = new RoundService();
        $roundService->createContestRounds($contest);

        return $contest;
    }
}