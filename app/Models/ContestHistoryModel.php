<?php namespace App\Models;

use CodeIgniter\Model;

class ContestHistoryModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contest_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contest_id','contestant_id','score'];
    protected $returnType = 'App\Entities\ContestHistoryEntity';


    public function getAllTimeWinner()
    {
        $queryString = "SELECT * FROM `contest_history` WHERE score=(select max(score) from contest_history)";
        $query = $this->db->query($queryString);
        return $query->getResult();
    }
}