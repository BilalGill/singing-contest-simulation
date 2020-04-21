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

    public function judgesRoundScoring(ContestEntity $contest, $contestantScore, $genre, $isContestantSick)
    {
        $judgesScore = 0;
        $contestJudgeModel = new ContestJudgeModel();
        $contestJudges = $contestJudgeModel->where('contest_id', $contest->id)->find();

        $judgeIds = array_column($contestJudges, 'judge_id');
        $judgeModel = new JudgeModel();
        $roundJudges = $judgeModel->find($judgeIds);
        foreach ($roundJudges as $judge)
        {
            if($judge->judge_type == "honest")
                $judgesScore += $this->honestJudge($contestantScore);
            else if($judge->judge_type == "rock")
                $judgesScore += $this->rockJudge($contestantScore, $genre);
            else if($judge->judge_type == "mean")
                $judgesScore += $this->meanJudge($contestantScore);
            else if($judge->judge_type == "friendly")
                $judgesScore += $this->friendlyJudge($contestantScore, $isContestantSick);
            else if($judge->judge_type == "random")
                $judgesScore += $this->randomJudge($contestantScore);
        }

        return $judgesScore;
    }

    public function randomJudge(){
        return rand(1,10);
    }

    public function honestJudge($contestantScore)
    {
        $score = 0;
        if($contestantScore >= 0.1 && $contestantScore <= 10.0)
            $score = 1;
        else if($contestantScore >= 10.1 && $contestantScore <= 20.0)
            $score = 2;
        else if($contestantScore >= 20.1 && $contestantScore <= 30.0)
            $score = 3;
        else if($contestantScore >= 30.1 && $contestantScore <= 40.0)
            $score = 4;
        else if($contestantScore >= 40.1 && $contestantScore <= 50.0)
            $score = 5;
        else if($contestantScore >= 50.1 && $contestantScore <= 60.0)
            $score = 6;
        else if($contestantScore >= 60.1 && $contestantScore <= 70.0)
            $score = 7;
        else if($contestantScore >= 70.1 && $contestantScore <= 80.0)
            $score = 8;
        else if($contestantScore >= 80.1 && $contestantScore <= 90.0)
            $score = 9;
        else if($contestantScore >= 90.1 && $contestantScore <= 100.0)
            $score = 10;

        return $score;
    }

    public function meanJudge($contestantScore)
    {
        if($contestantScore < 90.0)
            return 2;
        else
            return 10;
    }

    public function rockJudge($contestantScore, $genre)
    {
        $score = 0;

        if($genre != "Rock")
        {
            $score = rand(1,10);
        }
        else
        {
            if($contestantScore < 50.0)
                $score = 5;
            else if($contestantScore >= 50.0 && $contestantScore <= 74.9)
                $score = 8;
            else
                $score = 10;
        }

        return $score;
    }

    public function friendlyJudge($contestantScore, $isContestantSick)
    {
        $score = 8;
        if($contestantScore <= 3.0)
            $score = 7;
        if($isContestantSick)
            $score++;

        return $score;
    }
}