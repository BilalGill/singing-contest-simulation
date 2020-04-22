<?php namespace App\Models;

use CodeIgniter\Model;

class RoundModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'rounds';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contest_id', 'genre_id', 'completion_status'];
    protected $returnType = 'App\Entities\RoundEntity';


    public function getCompleteRoundCount(int $contestId)
    {
        $queryString = "SELECT count(*) as rounds_completed from rounds where contest_id = $contestId and completion_status = 1";
        $query = $this->db->query($queryString);
        $result = $query->getResult();

        return $result[0]->rounds_completed;
    }
}