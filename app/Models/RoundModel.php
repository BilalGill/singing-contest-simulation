<?php namespace App\Models;

use CodeIgniter\Model;

class RoundModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'rounds';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contest_id','genre_id','completion_status'];
    protected $returnType = 'App\Entities\RoundEntity';
}