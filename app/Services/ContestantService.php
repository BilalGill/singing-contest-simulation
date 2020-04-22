<?php


namespace App\Services;


use App\Entities\ContestantEntity;
use App\Entities\ContestantGenreInfoEntity;
use App\Entities\ContestContestantEntity;
use App\Entities\ContestEntity;
use App\Models\ContestantGenreInfoModel;
use App\Models\ContestantModel;
use App\Models\ContestContestantModel;
use App\Models\GenreModel;

class ContestantService
{
    /**
     * create contestants
     *
     * @param ContestEntity $contest
     * @return array
     * @throws \ReflectionException
     */
    public static function createContestants(ContestEntity $contest)
    {
        $response = array();
        $response[RESPONSE_CODE] = SUCCESS;

        $genreModel = new GenreModel();
        $genresList = $genreModel->getAllGenres();

        if (empty($genresList)) {
            $response[RESPONSE_CODE] = ERROR_CODE;
            $response[RESPONSE_MESSAGE] = "Genre Details not Found";

            return $response;
        }

        $contestantModel = new ContestantModel();
        $contestantList = array();

        for ($i = 0; $i < NUMBERS_OF_CONTESTANT; $i++) {
            $contestant = new ContestantEntity();
            $contestant->date_created = date('Y-m-d G:i:s');
            $contestant->id = $contestantModel->createContestant($contestant);
            $contestantList[] = $contestant;
        }

        ContestantService::createContestantGenreInfo($contestantList, $genresList);
        ContestantService::createContestContestants($contest, $contestantList);


        return $response;
    }

    /**
     * create contestants genre info
     *
     * @param array $contestantList
     * @param array $genresList
     * @throws \ReflectionException
     */
    public static function createContestantGenreInfo(array $contestantList, array $genresList)
    {
        $contestantGenreInfoModel = new ContestantGenreInfoModel();
        foreach ($contestantList as $contestant) {
            foreach ($genresList as $genreItem) {
                $contestantGenreInfo = new ContestantGenreInfoEntity();
                $contestantGenreInfo->genre_id = $genreItem->id;
                $contestantGenreInfo->contestant_id = $contestant->id;
                $contestantGenreInfo->strength = rand(1, 10);
                $contestantGenreInfoModel->createContestantGenreInfo($contestantGenreInfo);
            }
        }
    }

    /**
     * @param ContestEntity $contest
     * @param array $contestantList
     * @throws \ReflectionException
     */
    public static function createContestContestants(ContestEntity $contest, array $contestantList)
    {
        $contestContestantModel = new ContestContestantModel();

        foreach ($contestantList as $contestant) {
            $contestContestantInfo = new ContestContestantEntity();
            $contestContestantInfo->contest_id = $contest->id;
            $contestContestantInfo->contestant_id = $contestant->id;
            $contestContestantInfo->contest_score = 0;

            $contestContestantModel->createContestContestant($contestContestantInfo);
        }
    }
}