<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
        return view('singing_contest_view');
    }
}
