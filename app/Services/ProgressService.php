<?php namespace App\Services;

use App\Entities\ContestEntity;
use App\Entities\PerformanceEntity;
use App\Entities\RoundEntity;
use App\Models\ContestantGenreInfoModel;
use App\Models\ContestantModel;
use App\Models\ContestContestantModel;
use App\Models\ContestModel;
use App\Models\GenreModel;
use App\Models\PerformanceModel;
use App\Models\RoundModel;

class ProgressService
{
    public static function progressContest()
    {
        $response = array();
        $response[RESPONSE_CODE] = SUCCESS;

        $contestModel = new ContestModel();
        $activeContest = ContestService::getActiveContest();
        if (empty($activeContest)) {
            $response[RESPONSE_MESSAGE] = "No Active Contest Found";
            return;
        }
        $activeContest = $activeContest[0];

        $roundModel = new RoundModel();
        $round = $roundModel->where('contest_id', $activeContest->id)->where('completion_status', 0)->orderBy('id', 'asc')->limit(1)->find();
        if (empty($round)) {
            HistoryService::saveCompletedContest($activeContest);

            $activeContest->completion_status = 1;
            $contestModel->save($activeContest);

            $response[RESPONSE_MESSAGE] = "All Rounds Completed";
            return;
        }

        $round = $round[0];
        $contestContestantModel = new ContestContestantModel();
        $contestContestants = $contestContestantModel->where('contest_id', $activeContest->id)->findAll();
        $contestContestantsArray = array();
        foreach ($contestContestants as $contestant)
            $contestContestantsArray[$contestant->contestant_id] = $contestant;

        $contestantIds = array_column($contestContestants, 'contestant_id');
        $contestantsModel = new ContestantModel();
        $contestants = $contestantsModel->find($contestantIds);

        $contestantGenreInfoModel = new ContestantGenreInfoModel();
        $contestantGenreInfo = $contestantGenreInfoModel->whereIn('contestant_id', $contestantIds)->where('genre_id', $round->genre_id)->findAll();

        ProgressService::executeContestantPerformance($activeContest, $round, $contestants, $contestantGenreInfo, $contestContestantsArray, $response);

        $round->completion_status = 1;
        $roundModel->save($round);

        $response["roundsComplete"] = $roundModel->getCompleteRoundCount($activeContest->id);
        $response["contestantList"] = $contestContestantsArray;

        return $response;
    }

    public static function executeContestantPerformance(ContestEntity $contest, RoundEntity $round, array $contestants, array $contestantGenreInfo, array &$contestContestantsArray, array &$response)
    {
        $contestContestantModel = new ContestContestantModel();
        $genreModel = new GenreModel();
        $genre = $genreModel->find($round->genre_id);
        $response["roundGenre"] = $genre->genre;

        foreach ($contestantGenreInfo as $item) {
            $roundScore = ProgressService::generateRoundPerformanceRandomScore();
            $genreTotalScore = $roundScore * $item->strength;
            $contestContestantsArray[$item->contestant_id]->is_sick = "NO";

            $isContestantSick = false;
            if (rand(1, 100) <= SICKNESS_CHANCE) {
                $genreTotalScore = $genreTotalScore / 2;
                $isContestantSick = true;
                $contestContestantsArray[$item->contestant_id]->is_sick = "YES";
            }

            $genreTotalScore = ProgressService::ceiling($genreTotalScore, 1);

            $performanceModel = new PerformanceModel();
            $performance = new PerformanceEntity();
            $performance->contestant_id = $item->contestant_id;
            $performance->round_id = $round->id;
            $performance->score = $genreTotalScore;

            $performanceModel->insert($performance);

            $contestContestantsArray[$item->contestant_id]->round_performance = $genreTotalScore;
            $judgeScore = JudgeService::judgesRoundScoring($contest, $genreTotalScore, $genre, $isContestantSick, $response);

            $contestContestantsArray[$item->contestant_id]->contest_score += $judgeScore;
            $contestContestantsArray[$item->contestant_id]->round_judge_score = $judgeScore;
            $contestContestantsArray[$item->contestant_id]->round_performance = $genreTotalScore;

            $contestContestantModel->save($contestContestantsArray[$item->contestant_id]);
        }
    }

    public static function generateRoundPerformanceRandomScore()
    {
        $min = 0;
        $max = 10;
        do {
            $randomScore = rand($min * 10, $max * 10) / 10;
            $randomScore = round($randomScore, 2);
        } while ($randomScore < 0.1);

        return $randomScore;
    }

    // Rounding up to two one point
    public static function ceiling($value, $precision = 0)
    {
        $offset = 0.5;
        if ($precision !== 0)
            $offset /= pow(10, $precision);
        $final = round($value + $offset, $precision, PHP_ROUND_HALF_DOWN);
        return ($final == -0 ? 0 : $final);
    }
}