<?php namespace App\Controllers;

use App\Services\ContestService;
use App\Services\ProgressService;

class Progress extends BaseController
{
	public function index()
	{
        $progressService = new ProgressService();
        $progressService->progressContest();
	}
}
