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
        $contest->completion_status = 2;

        $contestModel = new ContestModel();
        $contestModel->save($contest);

        $contest = $contestModel->find(2);

        $judgeModel = new JudgeModel();

        $randomJudge = $judgeModel->orderBy("RAND()")->findAll(3);

        $contestJudgesList = array();

        foreach ($randomJudge as $item=>$value)
        {
            $contestJudges = new ContestJudgeEntity();
            $contestJudges->judge_id = $randomJudge[$item]->id;
            $contestJudges->contest_id = 2;

            $contestJudgesList[] = $contestJudges;
        }

        $contestJudgeModel = new ContestJudgeModel();
        $contestJudgeModel->insertBatch($contestJudgesList);


        return $contest;
    }
}