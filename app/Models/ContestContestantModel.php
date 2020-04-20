<?php namespace App\Models;

use CodeIgniter\Model;

class ContestContestantModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contest_contestants';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contest_id','contestant_id'];
    protected $returnType = 'App\Entities\ContestContestantEntity';
}