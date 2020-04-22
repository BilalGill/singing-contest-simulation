<?php namespace App\Models;

use App\Controllers\Contest;
use App\Entities\ContestantEntity;
use App\Entities\ContestEntity;
use CodeIgniter\Model;

class ContestantModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contestants';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date_created'];
    protected $returnType = 'App\Entities\ContestantEntity';

    /**
     * @param ContestEntity $contest
     * @return bool|int|string
     * @throws \ReflectionException
     */
    public function createContestant(ContestantEntity $contest)
    {
        return $this->insert($contest);
    }
}