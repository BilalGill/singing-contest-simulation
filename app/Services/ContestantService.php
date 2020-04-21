<?php


namespace App\Services;


use App\Entities\ContestantEntity;
use App\Entities\ContestantGenreInfoEntity;
use App\Entities\ContestContestantEntity;
use App\Entities\ContestEntity;
use App\Models\ContestantGenreInfoModel;
use App\Models\ContestContestantModel;
use App\Models\GenreModel;
use App\Models\ContestantModel;

class ContestantService
{
    public static function createContestants(ContestEntity $contest){

        $contestantModel = new ContestantModel();
        $contestantList = array();

        for($i=0;$i<NUMBERS_OF_CONTESTANT;$i++)
        {
            $contestant = new ContestantEntity();
            $contestant->date_created = date('Y-m-d G:i:s');
            $contestant->id = $contestantModel->insert($contestant);
            $contestantList[] = $contestant;
        }

        ContestantService::createContestantGenreInfo($contestantList);
        ContestantService::createContestContestants($contest, $contestantList);
    }

    public static function createContestantGenreInfo(array $contestantList)
    {
        $contestantGenreInfoModel = new ContestantGenreInfoModel();
        $genreModel = new GenreModel();
        $genres = $genreModel->findAll();

        $contestantGenreInfoList = array();
        foreach ($contestantList as $contestant)
        {
            foreach ($genres as $genreItem)
            {
                $contestantGenreInfo = new ContestantGenreInfoEntity();
                $contestantGenreInfo->genre_id = $genreItem->id;
                $contestantGenreInfo->contestant_id = $contestant->id;
                $contestantGenreInfo->strength = rand(1,10);

                $contestantGenreInfo->id = $contestantGenreInfoModel->insert($contestantGenreInfo);
                $contestantGenreInfoList[] = $contestantGenreInfo;
            }
        }
    }

    public static function createContestContestants(ContestEntity $contest, array $contestantList)
    {
        $contestContestantModel = new ContestContestantModel();

        foreach ($contestantList as $contestant)
        {
            $contestContestantInfo = new ContestContestantEntity();
            $contestContestantInfo->contest_id = $contest->id;
            $contestContestantInfo->contestant_id = $contestant->id;
            $contestContestantInfo->contest_score = 0;

            $contestContestantModel->insert($contestContestantInfo);
        }
    }
}