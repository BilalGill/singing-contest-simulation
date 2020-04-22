<?php namespace App\Controllers;

use App\Services\ContestService;

class GetCurrentContest extends BaseController
{
    public function index()
    {
        $response = ContestService::getCurrentContestData();

        echo json_encode($response);
    }
}
