<?php namespace App\Controllers;

use App\Services\ProgressService;

class Progress extends BaseController
{
	public function index()
	{
        ProgressService::progressContest();
	}
}
