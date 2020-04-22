<?php namespace App\Services;

use App\Entities\ContestEntity;
use App\Entities\RoundEntity;
use App\Models\GenreModel;
use App\Models\RoundModel;

class RoundService
{
    public static function createContestRounds(ContestEntity $contest)
    {
        $randomRoundsList = array();
        $genreModel = new GenreModel();
        $randomRound = $genreModel->orderBy("RAND()")->findAll();
        $roundsList = array();
        foreach ($randomRound as $genre)
        {
            $round = new RoundEntity();
            $round->genre_id = $genre->id;
            $round->contest_id = $contest->id;

            $randomRoundsList[] = $round;
        }
        $roundModel = new RoundModel();
        $roundModel->insertBatch($randomRoundsList);
    }
}