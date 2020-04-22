<?php namespace App\Models;

use CodeIgniter\Model;

class ContestHistoryModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contest_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contest_id', 'contestant_id', 'contest_score'];
    protected $returnType = 'App\Entities\ContestHistoryEntity';


    public function getAllTimeWinner()
    {
        $queryString = "SELECT * FROM `contest_history` WHERE contest_score=(select max(contest_score) from contest_history)";
        $query = $this->db->query($queryString);
        return $query->getResult();
    }

    public function getPreviousContestWinners()
    {
        $response = array();
        $response[RESPONSE_CODE] = SUCCESS;
        $response[RESPONSE_DATA] = $this->orderBy('date_created', 'desc')->findAll(NUMBER_OF_PREVIOUS_CONTEST_WINNERS);

        return $response;
    }
}