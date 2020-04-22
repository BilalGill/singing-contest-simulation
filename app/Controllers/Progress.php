<?php namespace App\Controllers;

use App\Services\ProgressService;

class Progress extends BaseController
{
	public function index()
	{
        $response = ProgressService::progressContest();
        echo json_encode($response);
    }
}
