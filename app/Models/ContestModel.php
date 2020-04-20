<?php namespace App\Models;

use CodeIgniter\Model;

class ContestModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contests';
    protected $primaryKey = 'id';
    protected $allowedFields = ['completion_status'];
    protected $returnType = 'App\Entities\ContestEntity';
}