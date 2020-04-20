<?php namespace App\Services;

use App\Entities\ContestEntity;
use App\Models\ContestModel;

class ContestService
{
    public function createContest()
    {
        $contest = new ContestEntity();
        $contest->completion_status = 2;

        $contestModel = new ContestModel();
        $contestModel->save($contest);

        $contest = $contestModel->find(2);

        return $contest;
    }
}