<?php namespace App\Models;

use CodeIgniter\Model;

class JudgeModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'judges';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judge_type'];
    protected $returnType = 'App\Entities\JudgeEntity';
}