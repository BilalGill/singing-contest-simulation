<?php namespace App\Models;

use CodeIgniter\Model;

class PerformanceModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'performances';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contestant_id', 'round_id', 'score'];
    protected $returnType = 'App\Entities\PerformanceEntity';

    public function getContestantsRoundPerformance($contestant_ids, $round_id)
    {
        return $this->whereIn('contestant_id', $contestant_ids)->where('round_id', $round_id)->findAll();
    }
}