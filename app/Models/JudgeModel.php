<?php namespace App\Models;

use CodeIgniter\Model;

class JudgeModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'judges';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judge_type'];
    protected $returnType = 'App\Entities\JudgeEntity';

    /**
     * @param $judges_id
     * @return array|object|null
     */
    public function getJudges($judges_id)
    {
        return $this->find($judges_id);
    }

    /**
     * @return array|null
     */
    public function getRandomJudges()
    {
        return $this->orderBy("RAND()")->findAll(NUMBERS_OF_JUDGES_FOR_CONTEST);
    }
}