<?php namespace App\Models;

use CodeIgniter\Model;

class ContestModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contests';
    protected $primaryKey = 'id';
    protected $allowedFields = ['completion_status'];
    protected $returnType = 'App\Entities\ContestEntity';

    /**
     * @return array|object|null
     */
    public function getActiveContest()
    {
        $contest = array();
        $result = $this->where('completion_status', '0')->find();
        if(count($result) > 0)
            $contest = $result[0];

        return $contest;
    }
}