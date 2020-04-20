<?php namespace App\Controllers;

use App\Entities\ContestEntity;
use App\Models\ContestModel;
use App\Services\ContestService;

class Contest extends BaseController
{
	public function index()
	{
        $contestService = new ContestService();
        $result = $contestService->createContest();
        print_r($result);
	}
}
