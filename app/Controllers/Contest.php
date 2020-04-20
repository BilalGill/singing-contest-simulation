<?php namespace App\Controllers;

use App\Entities\ContestEntity;
use App\Entities\JudgeEntity;
use App\Models\ContestModel;
use App\Models\JudgeModel;
use App\Services\ContestantService;
use App\Services\ContestService;

class Contest extends BaseController
{
	public function index()
	{
        $contestService = new ContestService();
        $result = $contestService->createContest();
	}
}
