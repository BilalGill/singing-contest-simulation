<?php namespace App\Models;

use App\Entities\ContestContestantEntity;
use CodeIgniter\Model;

class ContestContestantModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contest_contestants';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contest_id', 'contestant_id', 'contest_score'];
    protected $returnType = 'App\Entities\ContestContestantEntity';

    public function getTopScorer($contestId)
    {
        $topScorer = array();
        $queryString = "SELECT * FROM `contest_contestants` WHERE contest_id = $contestId AND contest_score=(select max(contest_score) from contest_contestants where contest_id =  $contestId) ";
        $query = $this->db->query($queryString);
        $result = $query->getResult();
        if(count($result) > 0)
            $topScorer = $result[0];

        return $topScorer;
    }

    /**
     * @param ContestContestantEntity $contestContestant
     * @return bool|int|string
     * @throws \ReflectionException
     */
    public function createContestContestant(ContestContestantEntity $contestContestant)
    {
        return $this->insert($contestContestant);
    }

    /**
     * @param $key
     * @param $value
     * @return array|null
     */
    public function getContestContestants($key, $value)
    {
        return $this->where($key, $value)->findAll();
    }
}