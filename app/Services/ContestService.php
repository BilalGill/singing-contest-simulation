<?php namespace App\Services;

use App\Entities\ContestEntity;
use App\Models\ContestContestantModel;
use App\Models\ContestModel;
use App\Models\GenreModel;
use App\Models\PerformanceModel;
use App\Models\RoundModel;

class ContestService
{

    /**
     * create contest
     * create contest round info
     * create contestant judges
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function createContest()
    {
        $response = array();
        $response[RESPONSE_CODE] = SUCCESS;
        $response[RESPONSE_MESSAGE] = "Contest Created Successfully";

        $contestModel = new ContestModel();

        $activeContest = $contestModel->getActiveContest();
        if (!empty($activeContest)) {
            $response[RESPONSE_CODE] = SUCCESS;
            $response[RESPONSE_MESSAGE] = "Contest Already in progress";
            return $response;
        }

        $contest = new ContestEntity();
        $contest->completion_status = 0;
        $contest->id = $contestModel->insert($contest);

        $result = JudgeService::createContestJudges($contest);
        if ($result[RESPONSE_CODE] != SUCCESS) {
            $contestModel->delete($contest->id);
            $response[RESPONSE_CODE] = $result[RESPONSE_CODE];

            return $result;
        }

        $result = ContestantService::createContestants($contest);
        if ($result[RESPONSE_CODE] != SUCCESS) {
            $contestModel->delete($contest->id);
            $response[RESPONSE_CODE] = $result[RESPONSE_CODE];

            return $result;
        }

        RoundService::createContestRounds($contest);

        $response[RESPONSE_DATA] = $contest;

        return $response;
    }

    /**
     * This function get Active Contest Data with all contestants and their Performances along with completed rounds info
     *
     * @return array
     */
    public static function getCurrentContestData()
    {
        $response = array();
        $contestModel = new ContestModel();
        $activeContest = $contestModel->getActiveContest();

        if (empty($activeContest)) {
            $response[RESPONSE_CODE] = SUCCESS;
            $response[RESPONSE_MESSAGE] = "Contest not found";
            return $response;
        }

        $roundModel = new RoundModel();
        $roundsCompleted = $roundModel->getCompleteRoundCount($activeContest->id);

        $contestantList = array();
        $contestContestantModel = new ContestContestantModel();
        $contestContestants = $contestContestantModel->getContestContestants('contest_id', $activeContest->id);
        $contestantIds = array_column($contestContestants, 'contestant_id');

        foreach ($contestContestants as $contestant) {
            $contestantList[$contestant->contestant_id] = $contestant;
        }

        $round = $roundModel->getPreviousRound($activeContest->id);
        if(!empty($round))
        {
            $performanceModel = new PerformanceModel();
            $latestPerformance = $performanceModel->getContestantsRoundPerformance($contestantIds, $round->id);
            foreach ($latestPerformance as $performance) {

                $contestantList[$performance->contestant_id]->round_performance = $performance->score;
            }
        }

        $genreModel = new GenreModel();
        $roundGenre = $genreModel->getGenres($round->genre_id);

        $response["roundsComplete"] = $roundsCompleted;
        $response["roundGenre"] = $roundGenre->genre;
        $response["contestJudges"] = JudgeService::getContestJudges($activeContest);
        $response["contestantList"] = $contestantList;

        return $response;
    }
}