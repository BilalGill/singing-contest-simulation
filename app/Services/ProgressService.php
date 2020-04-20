<?php namespace App\Services;

use App\Entities\ContestEntity;
use App\Entities\PerformanceEntity;
use App\Entities\RoundEntity;
use App\Models\ContestantGenreInfoModel;
use App\Models\ContestantModel;
use App\Models\ContestContestantModel;
use App\Models\PerformanceModel;
use App\Models\RoundModel;

class ProgressService
{
    public function progressContest()
    {
        $contestService = new ContestService();
        $activeContest = $contestService->getActiveContest();
        if(empty($activeContest))
        {
            print_r("No Active Contest Found");
            return;
        }
        $activeContest = $activeContest[0];

        $roundModel = new RoundModel();
        $round = $roundModel->where('contest_id', $activeContest->id)->where('completion_status',0)->orderBy('id','asc')->limit(1)->find();
        if(empty($round))
        {
            print_r("All Rounds Completed");
            return;
        }

        $round = $round[0];

        $contestContestantModel = new ContestContestantModel();
        $contestContestants = $contestContestantModel->where('contest_id', $activeContest->id)->findAll($activeContest->id);

        $contestantIds = array_column($contestContestants, 'contestant_id');
        $contestantsModel = new ContestantModel();
        $contestants = $contestantsModel->find($contestantIds);

        $contestantGenreInfoModel = new ContestantGenreInfoModel();
        $contestantGenreInfo = $contestantGenreInfoModel->whereIn('contestant_id', $contestantIds)->where('genre_id', $round->genre_id)->findAll();

        $this->executeContestantPerformance($activeContest, $round, $contestants, $contestantGenreInfo);
    }

    public function executeContestantPerformance(ContestEntity $contest, RoundEntity $round, array $contestants, array $contestantGenreInfo)
    {
        foreach ($contestantGenreInfo as $item)
        {
            $roundScore = $this->generateRoundPerformanceRandomScore();
            $genreTotalScore = $roundScore * $item->strength;

            $performanceModel = new PerformanceModel();
            $performance = new PerformanceEntity();
            $performance->contestant_id = $item->contestant_id;
            $performance->round_id = $round->id;
            $performance->score = $genreTotalScore;

            $performanceModel->insert($performance);
        }
    }

    public function generateRoundPerformanceRandomScore()
    {
        $min = 0;
        $max = 10;

        $randomStat = rand($min*10, $max*10)/10;
        $randomStat = round($randomStat, 2);
        return $randomStat;
    }
}