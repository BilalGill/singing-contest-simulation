<?php namespace App\Services;

use App\Entities\ContestEntity;
use App\Entities\JudgeEntity;
use App\Entities\ContestJudgeEntity;
use App\Models\ContestModel;
use App\Models\JudgeModel;
use App\Models\ContestJudgeModel;

class JudgeService
{
    public function createContestJudges(ContestEntity $contest)
    {
        $judgeModel = new JudgeModel();

        $randomJudges = $judgeModel->orderBy("RAND()")->findAll(3);
        $contestJudgesList = array();
        foreach ($randomJudges as $judge)
        {
            $contestJudges = new ContestJudgeEntity();
            $contestJudges->judge_id = $judge->id;
            $contestJudges->contest_id = $contest->id;

            $contestJudgesList[] = $contestJudges;
        }
        $contestJudgeModel = new ContestJudgeModel();
        $contestJudgeModel->insertBatch($contestJudgesList);
    }
}