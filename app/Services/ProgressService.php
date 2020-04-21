<?php namespace App\Services;

use App\Entities\ContestEntity;
use App\Entities\PerformanceEntity;
use App\Entities\RoundEntity;
use App\Models\ContestantGenreInfoModel;
use App\Models\ContestantModel;
use App\Models\ContestContestantModel;
use App\Models\ContestJudgeModel;
use App\Models\ContestModel;
use App\Models\GenreModel;
use App\Models\JudgeModel;
use App\Models\PerformanceModel;
use App\Models\RoundModel;

class ProgressService
{
    public function progressContest()
    {
        $contestModel = new ContestModel();
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
            $activeContest->completion_status = 1;
            $contestModel->save($activeContest);

            $historyService = new HistoryService();
            $historyService->saveCompletedContest($activeContest);

            print_r("All Rounds Completed");
            return;
        }

        $round = $round[0];
        $contestContestantModel = new ContestContestantModel();
        $contestContestants = $contestContestantModel->where('contest_id', $activeContest->id)->findAll($activeContest->id);
        $contestContestantsArray = array();
        foreach ($contestContestants as $contestant)
            $contestContestantsArray[$contestant->contestant_id] = $contestant;

        $contestantIds = array_column($contestContestants, 'contestant_id');
        $contestantsModel = new ContestantModel();
        $contestants = $contestantsModel->find($contestantIds);

        $contestantGenreInfoModel = new ContestantGenreInfoModel();
        $contestantGenreInfo = $contestantGenreInfoModel->whereIn('contestant_id', $contestantIds)->where('genre_id', $round->genre_id)->findAll();

        $this->executeContestantPerformance($activeContest, $round, $contestants, $contestantGenreInfo, $contestContestantsArray);

        $round->completion_status = 1;
        $roundModel->save($round);
    }

    public function executeContestantPerformance(ContestEntity $contest, RoundEntity $round, array $contestants, array $contestantGenreInfo, array &$contestContestantsArray)
    {
        $contestContestantModel = new ContestContestantModel();
        $genreModel = new GenreModel();
        $genre = $genreModel->find($round->genre_id);

        foreach ($contestantGenreInfo as $item)
        {
            $roundScore = $this->generateRoundPerformanceRandomScore();
            $genreTotalScore = $roundScore * $item->strength;

            $sicknessChance = 5;
            $isContestantSick = false;
            if(rand(1,100)<=$sicknessChance)
            {
                $genreTotalScore = $genreTotalScore/2;
                $isContestantSick = true;
            }

            $performanceModel = new PerformanceModel();
            $performance = new PerformanceEntity();
            $performance->contestant_id = $item->contestant_id;
            $performance->round_id = $round->id;
            $performance->score = $genreTotalScore;

            $performanceModel->insert($performance);

            $judgesService = new JudgeService();
            $judgeScore = $judgesService->judgesRoundScoring($contest, $genreTotalScore, $genre, $isContestantSick);

            $contestContestantsArray[$item->contestant_id]->contest_score += $judgeScore;
            $contestContestantModel->save($contestContestantsArray[$item->contestant_id]);
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