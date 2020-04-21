<?php namespace App\Models;

use CodeIgniter\Model;

class ContestContestantModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contest_contestants';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contest_id','contestant_id','contest_score'];
    protected $returnType = 'App\Entities\ContestContestantEntity';

    public function getTopScorer($contest_id)
    {
        $queryString = "SELECT * FROM `contest_contestants` WHERE contest_score=(select max(contest_score) from contest_contestants where contest_id = $contest_id)";
        $query = $this->db->query($queryString);
        return $query->getResult();
    }
}