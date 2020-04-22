<?php namespace App\Controllers;

use App\Services\ContestService;

class Contest extends BaseController
{
    public function index()
    {
        $response = ContestService::createContest();
        echo json_encode($response);
    }
}
