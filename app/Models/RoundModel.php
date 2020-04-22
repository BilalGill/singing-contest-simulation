<?php namespace App\Models;

use CodeIgniter\Model;

class RoundModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'rounds';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contest_id', 'genre_id', 'completion_status'];
    protected $returnType = 'App\Entities\RoundEntity';

    /**
     * @param int $contestId
     * @return mixed
     */
    public function getCompleteRoundCount(int $contestId)
    {
        $queryString = "SELECT count(*) as rounds_completed from rounds where contest_id = $contestId and completion_status = 1";
        $query = $this->db->query($queryString);
        $result = $query->getResult();

        return $result[0]->rounds_completed;
    }

    public function getPreviousRound($contest_id)
    {
        $nextRound = array();
        $result = $this->where('contest_id', $contest_id)->where('completion_status', 1)->orderBy('id', 'desc')->limit(1)->find();
        if(count($result))
            $nextRound = $result[0];

        return $nextRound;
    }

    public function getNextRound($contest_id)
    {
        $nextRound = array();
        $nextRound = $this->where('contest_id', $contest_id)->where('completion_status', 0)->orderBy('id', 'asc')->limit(1)->find();
        if(count($nextRound))
            $nextRound = $nextRound[0];

        return $nextRound;
    }
}