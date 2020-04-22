<?php namespace App\Models;

use CodeIgniter\Model;

class ContestJudgeModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contest_judges';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contest_id', 'judge_type'];
    protected $returnType = 'App\Entities\ContestJudgeEntity';

    public function getContestJudges($contest_id)
    {
        return $this->where('contest_id', $contest_id)->find();
    }
}